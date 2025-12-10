<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Charge extends Model
{
    use HasFactory;
    protected $table = 'charges';

    protected $fillable = [
            'user_id',
            'type',
            'start_range',
            'end_range',
            'charge_type',
            'charges',
            'reserve_charges',
            'created_at',
            'updated_at',
        ];
}
