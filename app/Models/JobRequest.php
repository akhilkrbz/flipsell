<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;

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
        'location_longitude',
        'location_langitude',
        'tags',
        'distance_limit',
        'user_id',
        'status',
        'business_id',
        'accepted_time',
        'job_date',
        'job_date_flexible',
        'address',
        'image_1',
        'image_2',
        'image_3',
        'full_screen_image',
        'connect_type',
        'created_at',
        'updated_at',
    ];

    public function scopeBasic($query)
    {
        $query->select(
            'budget',
            'category_id',
            'subcategory_id',
            'description',
            'flexible',
            'looking_for',
            'location',
            'location_longitude',
            'location_langitude',
            'tags',
            'distance_limit',
            'user_id',
            'status',
            'business_id',
            'accepted_time',
            'job_date',
            'job_date_flexible',
            'address',
            'image_1',
            'image_2',
            'image_3',
            'full_screen_image',
            'connect_type',
            'created_at',
            'updated_at',
        );
    }


    public function scopeUser($query, $user_id)
    {
        $query->where('user_id', $user_id);
    }

    public function scopePending($query)
    {
        $query->where('accepted_time', null);
    }

    public function scopeAccepted($query)
    {
        $query->where('accepted_time', '!=', null);
    }

    public function scopeAddRequestStatus($query)
    {
        $query->addSelect(new Expression("NULL as request_status"));
    }

    public function getRequestStatusAttribute()
    {
        return $this->updated_at < date('Y-m-d') ? 'Inactive' : 'Active';
    }

    public function request_update()
    {
        return $this->hasOne(RequestsUpdate::class, 'job_id', 'id')->where('status', 1);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function sub_category()
    {
        return $this->belongsTo(Category::class, 'subcategory_id', 'id');
    }

    public function user_data()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
