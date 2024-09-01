<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroundnutVariety extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'details',
    ];
}
