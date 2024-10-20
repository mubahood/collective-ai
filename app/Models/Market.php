<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($m) {
            $p = Parish::find($m->parish_id);
            if ($p != null) {
                $m->district_id = $p->district_id;
                $m->subcounty_id = $p->subcounty_id;
                $m->gps = trim($m->gps);
                if ($m->gps == null || $m->gps == '') {
                    $m->gps = $p->lat . ',' . $p->lng;
                }
            }
        });

        //updaring
        self::updating(function ($m) {
            $p = Parish::find($m->parish_id);
            if ($p != null) {
                $m->district_id = $p->district_id;
                $m->subcounty_id = $p->subcounty_id;
                if ($m->gps == null || $m->gps == '') {
                    $m->gps = $p->lat . ',' . $p->lng;
                }
            }
        });

        
        self::created(function ($m) {
            Utils::process_price_records();
        });

        //updating
        self::updated(function ($m) {
            Utils::process_price_records();
        });
    }

    //belongs to parish_id
    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }
}
