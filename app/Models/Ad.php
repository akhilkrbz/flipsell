<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'image', 'link','image1', 'link1','image2', 'link2','ad_set'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
