<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kyc extends Model
{
    use HasFactory;

     protected $fillable = [
        'userid',
        'cin_number',
        'account_type',
        'account_number',
        'account_name',
        'gst',
        'address',
        'bank_name',
        'ifsc_code',
        'adhar_number',
        'kyc_status',
        'pan_number',
        'document',
        'add_data',
    ];

    protected $casts = [
        'document' => 'array',
        'add_data' => 'array',
        'kyc_status' => 'integer',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }
    
}
