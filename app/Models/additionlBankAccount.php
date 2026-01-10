<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class additionlBankAccount extends Model
{
    use HasFactory;

    protected $table = 'aditionlbank_accounts';

    protected $fillable = [
            'user_id',
            'bank_name',
            'ifsc_code',
            'account_holder_name',
            'account_number',
            'status',
            'documents'
        ];

    protected $casts = [
            'documents' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
