<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;
    protected $table = 'dry_caledar';
    protected $guarded = [];

    protected $fillable = [
        'id',
        'id_jobs',
        'id_technician',
        'date_start_job',
        'date_finish_job',
        'note'
    ];
}
