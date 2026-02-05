<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Jobs\CheckPayoutStatusJob;

class CheckPendingPayouts extends Command
{
    protected $signature = 'payout:check-pending';
    protected $description = 'Check pending payouts and hit status API';

    public function handle()
    {
      
            
        $payouts = DB::table('payout_payment')
            ->where('status', 'pending')
             ->whereRaw(
            "DATE(STR_TO_DATE(txnRcvdTimeStamp, '%d-%m-%Y %H:%i:%s.%f')) = ?",
            [now()->toDateString()]
        )->orderByDesc('id')->get();


        if ($payouts->isEmpty()) {
            $this->info('No pending payouts');
            return;
        }

        foreach ($payouts as $payout) {
            CheckPayoutStatusJob::dispatch($payout);
        }

        $this->info('Pending payout jobs dispatched: ' . $payouts->count());
    }
}
