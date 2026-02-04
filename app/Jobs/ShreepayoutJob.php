<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShreepayoutJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $payoutId, $payload, $userId, $finalAmount;

    public $tries = 5;
    public $timeout = 120;

    public function __construct($payoutId, $payload, $userId, $finalAmount)
    {
        $this->payoutId    = $payoutId;
        $this->payload     = $payload;
        $this->userId      = $userId;
        $this->finalAmount = $finalAmount;
    }

    /* ---------------- CLIENT CALLBACK ---------------- */
    private function sendClientCallback(array $data)
    {
        $client = DB::table('clints')->where('user_id', $this->userId)->first();

        if ($client && !empty($client->payout_url)) {
            try {
                Http::timeout(10)->post($client->payout_url, $data);
            } catch (\Exception $e) {
                Log::error('Client Callback Failed', ['error' => $e->getMessage()]);
            }
        }
    }

    /* ---------------- JOB HANDLE ---------------- */
    public function handle()
    {
        try {

            $url = "https://dashboard.shreefintechsolutions.com/api/payout/v2/transaction";
            $response = Http::timeout(90)->post($url, $this->payload);

            if (!$response->successful()) {
                throw new \Exception('ORO API failed');
            }

            $responseData = $response->json();
           

            // ✅ Wallet insufficient case
            if (data_get($responseData, 'message') == 'Insufficient payout wallet balance') {

                DB::transaction(function () use ($responseData) {

                    $user = User::lockForUpdate()->find($this->userId);
                    $user->wallet_amount += $this->finalAmount;
                    $user->save();

                    DB::table('payout_payment')
                        ->where('id', $this->payoutId)
                        ->update([
                            'status'         => 'Refunded',
                            'refund_amount'  => $this->finalAmount,
                            'response_data'  => json_encode($responseData),
                            'txnUpdTimeStamp'=> now(),
                        ]);
                });

                $this->sendClientCallback([
                    'status'  => 'FAILED',
                    'message' => 'Your Request Bounce'
                ]);

                return;
            }

            // ✅ Safe transaction id
            $transactionId = data_get($responseData, 'transaction_id');

            if ($transactionId) {
                DB::table('payout_payment')
                    ->where('id', $this->payoutId)
                    ->where('cus_trx_id', $transactionId)
                    ->update([
                        'systemid'       => data_get($responseData, 'response.CBX_API_REF_NO'),
                        'response_data'  => json_encode($responseData),
                        'txnUpdTimeStamp'=> now(),
                    ]);
            }

            $data = DB::table('payout_payment')->where('id', $this->payoutId)->first();

            $this->sendClientCallback([
                'status' => 'SUCCESS',
                'data'   => $data
            ]);

        } catch (\Throwable $e) {

            Log::error('OroDash Job Exception', [
                'payout_id' => $this->payoutId,
                'error'     => $e->getMessage()
            ]);

            $this->fail($e);
        }
    }
}
