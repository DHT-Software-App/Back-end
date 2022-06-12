<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuredCompany extends Model
{
    use HasFactory;
    protected $table = 'dry_insurance_company';
    protected $guarded = [];

    protected $fillable = [
        'company',
        'street',
        'id_city',
        'id_state',
        'zip',
        'insuredcompany_status'
    ];
}
