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
        // Get payout record
        $payout = DB::table('payout_payment')
            ->where('id', $this->payout->id)
            ->where('status', 'pending')
            ->first();

        if (!$payout) {
            return;
        }

        // API request data
        $postData = [
            "token"          => "79Jk2BHqojrpGKTTpWpnFNJR5Mq5dU",
            "transaction_id" => $payout->cus_trx_id,
            "external_ref"   => $payout->systemid
        ];

        // CURL call
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://dashboard.shreefintechsolutions.com/api/payout/v2/get-report-status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            Log::error('Payout Status API Error: ' . curl_error($curl));
            curl_close($curl);
            return;
        }

        curl_close($curl);

        // Decode response
        $responseData = json_decode($response, true);

        // Update payout status
        DB::table('payout_payment')
            ->where('systemid', $payout->systemid)
            ->where('cus_trx_id', $payout->cus_trx_id)
            ->update([
                'utr'           => $responseData['utr_no'] ?? null,
                'status'        => $responseData['status_text'] ?? 'pending',
                'response_data' => json_encode($responseData),
                'updated_at'    => now(),
            ]);

        // Get client callback URL
        $client = DB::table('clints')
            ->where('user_id', $payout->merchant_id)
            ->first();

        // Prepare callback data
        $senddata = DB::table('payout_payment')
            ->where('systemid', $payout->systemid)
            ->where('cus_trx_id', $payout->cus_trx_id)
            ->select('systemid','trx_id','cus_trx_id','utr','txn_type','pymt_type','status','account_number','amount')
            ->first();

        // Send callback
        if ($client && !empty($client->payout_url) && $senddata) {
            try {
                Http::timeout(10)->post($client->payout_url, (array) $senddata);
                // Log::info('PAYOUT CALLBACK SENT', (array) $senddata);
            } catch (\Exception $e) {
                Log::error('PAYOUT CALLBACK FAILED', [
                    'systemid' => $payout->systemid,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
}
