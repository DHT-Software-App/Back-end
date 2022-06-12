<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobStatus extends Model
{
    use HasFactory;
    protected $table = 'dry_job_status';
    protected $guarded = [];

    protected $fillable = [
        'id',
        'type_job'
    ];
}
