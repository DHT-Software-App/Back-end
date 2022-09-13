<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calendar extends Model
{
    protected $table = 'calendars';
    public $timestamps = true;

    use SoftDeletes;

    protected $fillable = array('start_date', 'end_date', 'contacts', 'address', 'notes', 'job_id', 'employee_id');
    protected $visible = array('id', 'start_date', 'end_date', 'contacts', 'address', 'notes', 'job_id', 'employee_id');

    protected $casts = [
        'contacts' => 'array'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
