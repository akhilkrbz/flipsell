<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    public $timestamps = false;
    protected $table = 'locations';
    protected $primaryKey = 'id';

    protected $fillable = [
        'country_name',
        'country_code',
        'created_at',
        'updated_at'
    ];
}
