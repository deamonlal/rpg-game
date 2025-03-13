<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enemy extends Model
{
    use HasFactory;

    protected $table = 'enemies';

    protected $fillable = [
        'name',
        'level',
        'exp_gain',
        'gold_gain',
        'health',
        'item',
        'skills',
    ];
}
