<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class RequestsUpdate extends Model
{
    use HasFactory;

    // Define the table name if it doesn't follow the plural convention
    protected $table = 'requests_update';

    // Specify the fillable fields for mass assignment
    protected $fillable = [
        'business_id',
        'status',
        'accepted_time',
        'job_id',
    ];
}
