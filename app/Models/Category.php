<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use SoftDeletes;  // Enable soft deletes

    protected $dates = ['deleted_at']; 
    protected $fillable = [
        'category_name', 
        'sub_of',
    ];
}
