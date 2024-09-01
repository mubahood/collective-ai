<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcounty extends Model
{
    use HasFactory;

    //table
    protected $table = 'subcounty';

    //disable timestamps
    public $timestamps = false;

    //District
    public function district()
    {
        return $this->belongsTo(District::class);
    } 

    //boot
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($subcounty){
            $subcounty->parishes()->delete();
        });
    } 

    //has many parishes
    public function parishes()
    {
        return $this->hasMany(Parish::class);
    } 

    //name_text
    public function getNameTextAttribute()
    {
        if($this->district == null){
            return $this->name;
        }
        return $this->district->name . ' - ' . $this->name;
    } 
}
