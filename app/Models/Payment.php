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
        'created_at',
        'updated_at',
        'payment_intent_id',
        'payment_status',
        'transaction_id',
        'receipt_url',
        'order_id',
        'plan_id',
    ];
}
