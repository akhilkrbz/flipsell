<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function accepted_job_request()
    {
        return $this->hasMany(JobRequest::class, 'id', 'job_id');
    }
}
