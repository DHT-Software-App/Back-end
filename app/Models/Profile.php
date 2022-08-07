<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'photo'];

    // One-to-one polymorphic relation
    public function image(): MorphOne
    {
        // 'imageable' is the name of the method created on Image model.
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
