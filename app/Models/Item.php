<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    use HasFactory;

    public function weapon(): HasOne
    {
        return $this->hasOne(Weapon::class);
    }

    public function armor(): HasOne
    {
        return $this->hasOne(Armor::class);
    }

    public function tier(): BelongsTo
    {
        return $this->belongsTo(Tier::class);
    }
}
