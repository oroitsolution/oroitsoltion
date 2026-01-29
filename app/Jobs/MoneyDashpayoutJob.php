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

class MoneyDashpayoutJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $payoutId, $payload, $userId, $finalAmount;

    public $tries = 5;
    public $timeout = 120;

    public function __construct($payoutId, $payload, $userId, $finalAmount)
    {
        $this->payoutId   = $payoutId;
        $this->payload    = $payload;
        $this->userId     = $userId;
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
                Log::error('Client callback failed: ' . $e->getMessage());
            }
        }
    }

    /* ---------------- JOB HANDLE ---------------- */
    public function handle()
    {
       
        try {

            DB::table('payout_payment')
                ->where('id', $this->payoutId)
                ->update([
                    'status'         => 'SUCCESS',
                ]);

           

        } catch (\Throwable $e) {

            Log::error('ASL Job Failed: ' . $e->getMessage());

            $this->fail($e);
        }
    }
}
