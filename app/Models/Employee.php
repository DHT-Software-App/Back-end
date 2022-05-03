<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() : HasOne{
        return $this->hasOne(User::class);
    }

    public function userProfile() : HasOneThrough {
        return $this->hasOneThrough(Profile::class, User::class);
    }

    public function creator() : BelongsTo {
        return $this->belongsTo(Creator::class);
    }

    
}
