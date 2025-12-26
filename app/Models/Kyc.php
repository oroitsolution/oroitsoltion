<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kyc extends Model
{
     use HasFactory;

     protected $fillable = [
        'user_id',
        'account_type',
        'account_number',
        'cin_number',
        'account_name',
        'gst',
        'address',
        'bank_name',
        'ifsc_code',
        'adhar_number',
        'pan_number',
        'document',
    ];
    
}
