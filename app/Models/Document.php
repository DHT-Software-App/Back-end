<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    protected $table = 'documents';
    public $timestamps = true;

    use SoftDeletes;

    protected $fillable = array('description', 'job_id', 'document_type_id');
    protected $visible = array('id', 'description', 'job_id', 'document_type_id');

    // One-to-one polymorphic relation
    public function image(): MorphOne
    {
        // 'imageable' is the name of the method created on Image model.
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }
}
