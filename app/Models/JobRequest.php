<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobRequest extends Model
{
    protected $fillable = [
        'budget',
        'category_id',
        'subcategory_id',
        'description',
        'flexible',
        'looking_for',
        'location',
        'tags',
        'distance_limit',
        'user_id',
        'status',
        'business_id',
        'accepted_time',
    ];
}
