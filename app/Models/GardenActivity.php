<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GardenActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'garden_id',
        'user_id',
        'activity_category',
        'description',
        'date',
        'person_responsible',
        'remarks'

    ];
    //append for garden_text
    protected $appends = ['garden_text'];
    //get garden_text
    public function getGardenTextAttribute()
    {
        if ($this->garden == null) {
            return "No Garden";
        }
        return $this->garden->name;
    }

    //getter for 

    //belongs to garden
    public function garden()
    {
        return $this->belongsTo(Garden::class);
    }
}
