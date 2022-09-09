<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Silber\Bouncer\Database\Concerns\Authorizable;

class Employee extends Model
{
    use HasFactory;
    use HasRolesAndAbilities;
    use Authorizable;

    protected $guarded = [];

    protected $casts = [
        'contacts' => 'array'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function userProfile(): HasOneThrough
    {
        return $this->hasOneThrough(Profile::class, User::class);
    }

    public function calendar(): HasOne
    {
        return $this->hasOne(calendar::class);
    }
}
