<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'plan_id',
        'user_id',
        'start_date',
        'end_date',
        'payment_id',
    ];
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
