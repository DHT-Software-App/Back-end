<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'photo'];

    // One-to-one polymorphic relation
    public function image() {
        // 'imageable' is the name of the method created on Image model.
        return $this->morphOne('App\Models\Image', 'imageable');
    }
}
