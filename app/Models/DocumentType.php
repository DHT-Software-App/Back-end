<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentType extends Model
{
    use HasFactory;
    protected $table = 'document_types';
    public $timestamps = true;

    protected $guarded = [];

    protected $fillable = array('name');
    protected $visible = array('id', 'name');

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
