<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Freeze extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
    ];
}
