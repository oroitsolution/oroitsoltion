<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payout extends Model
{
   use HasFactory;

     protected $fillable = [
            'user_id',
            'bank_name',
            'ifsc_code',
            'account_number',
            'account_name',
        ];
}
