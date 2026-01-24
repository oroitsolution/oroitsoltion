<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Clints extends Model
{
     use HasFactory;
    protected $table = 'clints';
     protected $fillable = [
            'user_id',
            'client_id',
            'secret_id',
            'payout_url',
            'payin_url',
            'ipaddress',
            'status',
        ];
}
