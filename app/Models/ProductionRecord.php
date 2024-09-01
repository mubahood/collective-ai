<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'garden_id',
        'activity_category',
        'description',
        'date',
        'person_responsible',
        'remarks',
       
    ];
}
