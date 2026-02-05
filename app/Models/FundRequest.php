<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundRequest extends Model
{
    protected $fillable = [
    'user_id',
    'deposit_amount',
    'payment_method',
    'paymentdate',
    'bank_name',
    'account_detail',
    'utr',
    'remark',
    'oldamount',
    'status',
    ];
}
