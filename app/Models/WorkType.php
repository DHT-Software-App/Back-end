<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkType extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function estimateItems(): HasMany
    {
        return $this->hasMany(EstimateItem::class);
    }
}
