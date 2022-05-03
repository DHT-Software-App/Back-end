<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() : HasOne{
        return $this->hasOne(User::class);
    }

    public function creator() : HasOne {
        return $this->hasOne(EmployeeCreator::class);
    }
}
