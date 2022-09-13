<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'contacts' => 'array',
    ];

    //-------------------
    // Accessors
    //-------------------

    protected function insuredFirstname(): Attribute
    {
        return Attribute::get(fn ($value) => $value ?? '');
    }

    protected function insuredLastname(): Attribute
    {
        return Attribute::get(fn ($value) => $value ?? '');
    }

    //-------------------
    // Relations
    //-------------------

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
