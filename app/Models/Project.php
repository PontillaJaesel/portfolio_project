<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    // --- ADD THIS $fillable PROPERTY ---
    protected $fillable = [
        'title',
        'organization',
        'year',
        'details',
    ];
    // ------------------------------------
}
