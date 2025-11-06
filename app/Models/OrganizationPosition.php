<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationPosition extends Model
{
    use HasFactory;

    // --- ADD THIS $fillable PROPERTY ---
    protected $fillable = [
        'role',
        'year_range',
        'details',
        // 'organization_id' is handled by the relationship,
        // but these three must be fillable.
    ];
}
