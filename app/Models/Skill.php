<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;

    // --- ADD THIS $fillable PROPERTY ---
    protected $fillable = [
        'skill',
    ];
}
