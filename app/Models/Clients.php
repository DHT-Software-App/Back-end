<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;
    protected $table = 'dry_clients';
    protected $guarded = [];

    protected $fillable = [
        'id',
        'person_contact',
        'company',
        'street',
        'id_city',
        'id_state',
        'zip',
        'clients_status'
    ];
}
