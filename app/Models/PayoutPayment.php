<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayoutPayment extends Model
{
    use HasFactory;

    protected $table = 'payout_payment';

    protected $fillable = [
        'payout_id',
        'systemid',
        'trx_id',
        'cus_trx_id',
        'utr',
        'txnRcvdTimeStamp',
        'txnUpdTimeStamp',
        'txn_type',
        'pymt_type',
        'status',
        'name',
        'ifsc',
        'account_number',
        'amount',
        'charges',
        'usercharges',
        'refund_amount',
        'lastwallet_balance',
        'payment_source',
        'merchant_id',
        'payouttype',
        'response_data',
    ];

    /**
     * Cast fields
     */
    protected $casts = [
        'response_data' => 'array',
    ];

    /**
     * Relation: payout belongs to a user (merchant)
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'merchant_id', 'id');
    }

}
