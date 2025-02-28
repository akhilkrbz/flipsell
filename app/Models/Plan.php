<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'plan_name',
        'month_no',
        'price',
        'symbol',
        'currency',
        'description', // Added description as fillable field
    ];
    protected $dates = ['deleted_at'];
}
