<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parish extends Model
{
    use HasFactory;

    //table
    protected $table = 'parish';

    //disable timestamps
    public $timestamps = false;

    //District
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    //Subcounty
    public function subcounty()
    {
        return $this->belongsTo(Subcounty::class);
    }

    //boot
    protected static function boot()
    {
        parent::boot();
        //creating
        static::creating(function ($parish) {
            $district = Subcounty::find($parish->subcounty_id);
            if ($district != null) {
                $parish->district_id = $district->district_id;
            } else {
                throw new \Exception('Subcounty not found');
            }
        });

        //updating
        static::updating(function ($parish) {
            $district = Subcounty::find($parish->subcounty_id);
            if ($district != null) {
                $parish->district_id = $district->district_id;
            } else {
                throw new \Exception('Subcounty not found');
            }
        });
    }

    public function getNameTextAttribute()
    {
        $name = $this->name;
        if ($this->subcounty != null) {
            $name = $this->subcounty->name . ', ' . $name;
        }
        if ($this->district != null) {
            $name = $this->district->name . ', ' . $name;
        }
        return $name;
    }

    //get dropdown list
    public static function getDropDownList()
    {
        $parishes = Parish::all();
        $list = [];
        foreach ($parishes as $parish) {
            $list[$parish->id] = $parish->name_text;
        }
        return $list;
    } 
}
