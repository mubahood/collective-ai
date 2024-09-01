<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PestsAndDiseaseReport extends Model
{
    use HasFactory;

    //getter name
    public function getNameAttribute($value)
    {
        $p = $this->pestsAndDisease;
        $name = "";
        if ($p != null) {
            $name = $p->category;
        }
        $district = $this->district;
        if ($district != null) {
            $name = $name . " - " . $district->name;
        }

        //check if the name is too long
        if (strlen($name) > 30) {
            $name = substr($name, 0, 28) . "...";
        }

        return ucfirst($name);
    }

    //belongs to pests_and_disease_id 
    public function pestsAndDisease()
    {
        return $this->belongsTo(PestsAndDisease::class);
    }
    //district_id
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    //belongs to user_id
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
}
