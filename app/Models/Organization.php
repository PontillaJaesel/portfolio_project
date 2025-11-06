<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;

    // --- ADD THIS $fillable PROPERTY ---
    protected $fillable = [
        'name',
    ];
    public function positions() {
        return $this->hasMany(OrganizationPosition::class);
    }
}
