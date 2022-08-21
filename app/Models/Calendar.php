<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calendar extends Model
{
    protected $table = 'calendar';
    public $timestamps = true;

    use SoftDeletes;

    protected $fillable = array( 'start_date', 'end_date', 'notes', 'job_id','employee_id');
    protected $visible = array( 'id', 'start_date', 'end_date', 'notes', 'job_id','employee_id');


    public function Job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function Employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

}
