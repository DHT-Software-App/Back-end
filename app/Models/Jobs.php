<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use HasFactory;
    protected $table = 'dry_jobs';
    protected $guarded = [];
 
    protected $fillable = [
        'id',
        'id_customers',
        'id_insurance_company',
        'policy_number',
        'claim_number',
        'date_loss',
        'id_type_loss',
        'text',
        'referred_by',
        'id_job_status',
        'id_type_work'
    ];
}
