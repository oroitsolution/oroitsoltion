<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckPayoutStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $payout;

    public function __construct($payout)
    {
        $this->payout = $payout;
    }

    public function handle()
    {
        dd(123);
        $payout = DB::table('payout_payment')
            ->where('id', $this->payout->id)
            ->where('status', 'PENDING')
            ->first();

        if (!$payout) {
            return; // already updated
        }

        /* ================= STATUS API HIT ================= */
        $payload = [
            "apiToken"  => "f062d2a0c3580ea3f52b0aad4919906c",
            "apiUserId" => "5116",
            "orderId"   => $payout->apiRefNum,
            "service"   => "payout"
        ];

        $response = Http::post(
            'https://payzones.in/apipartner/apiservice/check/checkStatus',
            $payload
        )->json();
        /* ================================================== */

        if (empty($response['data']['status'])) {
            return;
        }

        $finalStatus = $response['data']['status'] === 'SUCCESS'
            ? 'COMPLETED'
            : $response['data']['status'];

        // 🔹 update payout
        DB::table('indiplexpayout')
            ->where('id', $payout->id)
            ->update([
                'txnStatus'        => $finalStatus,
                'bankRefId'        => $response['data']['tranref'] ?? null,
                'responsedata'     => json_encode($response),
                'txnUpdTimeStamp'  => now()->format('d-m-Y H:i:s.v'),
            ]);

        /* ================= CALLBACK ================= */
        $client = DB::table('clients')
            ->where('user_id', $payout->merchant_id)
            ->first();
            
        $senddata = DB::table('indiplexpayout')
                ->where('apiRefNum', $this->payout->apiRefNum)
                ->first();
                
        unset($senddata->responsedata);

        if ($client && !empty($client->url)) {
            try {
                Http::timeout(10)->post($client->url, (array) $senddata);

                //  Log::info('PAYOUT CALLBACK SENT', (array) $senddata);

            } catch (\Exception $e) {
                Log::error('PAYOUT CALLBACK FAILED', [
                    'order_id' => $payout->apiRefNum,
                    'error'    => $e->getMessage()
                ]);
            }
        }
        /* ============================================== */
    }
}
