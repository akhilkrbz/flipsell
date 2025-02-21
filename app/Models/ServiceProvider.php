<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    protected $fillable = [
        'category_id', 
        'subcategory_id', 
        'website', 
        'business_image', 
        'gst_number',
        'reg_document',
        'status',
        'user_id',
        'business_name',
        'business_phone',
        'business_email'

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'user_id', 'user_id');
    }
}
