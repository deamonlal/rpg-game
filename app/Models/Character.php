<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $table = 'characters';

    protected $fillable = [
        'name',
        'level',
        'exp',
        'gold',
        'health',
        'inventory',
        'skills',
    ];

    protected $guarded = false;

    /**
     * Получаем данные персонажа.
     *
     * @param int $characterId
     * @return Character|null
     */
    public static function getById(int $characterId): ?Character
    {
        return self::with(['equipment.item.weapon', 'equipment.item.armor'])->find($characterId);
    }

    public function equipment() {
        return $this->hasMany(Equipment::class);
    }
}
