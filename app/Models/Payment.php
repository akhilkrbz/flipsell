<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'amount_paid',
        'status',
        'payment_gateway_id',
        'user_id',
        'currency',
    ];
}
