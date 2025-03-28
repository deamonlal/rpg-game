<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Weapon extends Model
{
    use HasFactory;

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
