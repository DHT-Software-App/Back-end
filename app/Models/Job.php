<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    protected $table = 'jobs';
    public $timestamps = true;

    use SoftDeletes;

    protected $fillable = array( 'claim_number', 'notes', 'date_of_loss', 'type_of_loss','status', 'state', 'street', 'city', 'zip', 'company', 'employee_id', 'customer_id', 'client_id', 'work_type_id', 'insurance_id');
    protected $visible = array( 'id', 'claim_number', 'notes', 'date_of_loss', 'type_of_loss','status', 'state', 'street', 'city', 'zip', 'company', 'employee_id', 'customer_id', 'client_id', 'work_type_id', 'insurance_id');


    public function Employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function Client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function WorkType()
    {
        return $this->belongsTo(WorkType::class, 'work_type_id');
    }

    public function Insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id');
    }


}
