<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garden extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'garden_size',
        'ownership',
        'planting_date',
        'harvest_date',
        'variety_id',
        'seed_class',
        'certified_seller',
        'name_of_seller',
        'seller_location',
        'seller_contact',
        'purpose_of_seller',
        'user_id',
        'crop_id',
    ];

    public function getGardenNameAttribute()
    {
        return $this->name;
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($m) {
            $p = Parish::find($m->parish_id);
            if ($p != null) {
                $m->district_id = $p->district_id;
                $m->subcounty_id = $p->subcounty_id;
            }
        });

        //updaring
        self::updating(function ($m) {
            $p = Parish::find($m->parish_id);
            if ($p != null) {
                $m->district_id = $p->district_id;
                $m->subcounty_id = $p->subcounty_id;
            }
        });
    }

    //crop_text
    public function getCropTextAttribute()
    {
        if ($this->crop == null) {
            return 'No Crop';
        }
        return $this->crop->name;
    }

    //belongs to crop
    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
    //belongs to parish
    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }

    //getter for parish_text
    public function getParishTextAttribute()
    {
        if ($this->parish == null) {
            return 'No Parish';
        }
        return $this->parish->name_text;
    }

    //belongs to variety_id
    public function variety()
    {
        return $this->belongsTo(Crop::class, 'crop_id');
    }

    //appends crop_text
    protected $appends = ['crop_text', 'parish_text'];
}
