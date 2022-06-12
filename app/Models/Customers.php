<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    protected $table = 'dry_customers';
    protected $guarded = [];

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'street',
        'id_city',
        'id_state',
        'zip',
    ];
}
