<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    protected $table = 'document';
    public $timestamps = true;

    use SoftDeletes;

    protected $fillable = array( 'description', 'url', 'job_id','document_type_id');
    protected $visible = array( 'id', 'description', 'url', 'job_id','document_type_id');


    public function Job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function Employee()
    {
        return $this->belongsTo(DocumentType::class, 'employee_id');
    }

}
