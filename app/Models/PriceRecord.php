<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceRecord extends Model
{
    use HasFactory;

    //boot
    public static function boot()
    {
        parent::boot();
        self::creating(function ($m) {
            if ($m->retail_price > 0) {
                $m->status = 'Submitted';
                $lastRecord = PriceRecord::where('commodity_id', $m->commodity_id)
                    ->where('market_id', $m->market_id)
                    ->orderBy('created_at', 'desc')
                    ->first();
                if ($lastRecord != null) {
                    if ($m->retail_price == $lastRecord->retail_price) {
                        $m->price_direction = 'Stable';
                    } else if ($m->retail_price > $lastRecord->retail_price) {
                        $m->price_direction = 'Rising';
                    } else {
                        $m->price_direction = 'Falling';
                    }
                }
            }
        });

        //updaring
        self::updating(function ($m) {
            if ($m->retail_price > 0) {
                $m->status = 'Submitted';
                $lastRecord = PriceRecord::where('commodity_id', $m->commodity_id)
                    ->where('market_id', $m->market_id)
                    ->orderBy('created_at', 'desc')
                    ->first();
                if ($lastRecord != null) {
                    if ($m->retail_price == $lastRecord->retail_price) {
                        $m->price_direction = 'Stable';
                    } else if ($m->retail_price > $lastRecord->retail_price) {
                        $m->price_direction = 'Rising';
                    } else {
                        $m->price_direction = 'Falling';
                    }
                }
            }
        });
        
        //udapted
        self::updated(function ($m) {
            $commodity = Commodity::find($m->commodity_id);
            if($commodity != null){
                $commodity->process_price();
            }
        });

        //created
        self::created(function ($m) {
            $commodity = Commodity::find($m->commodity_id);
            if($commodity != null){
                $commodity->process_price();
            }
        }); 
    }

    //belongs to commodity_id
    public function commodity()
    {
        return $this->belongsTo(Commodity::class);
    }
    //market_id
    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    //parish_id
    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }
    //subcounty_id
    public function subcounty()
    {
        return $this->belongsTo(Subcounty::class);
    }
    //district_id
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    //appends for commodity_text
    public function getCommodityTextAttribute()
    {
        if ($this->commodity == null) {
            return 'No Commodity';
        }
        return $this->commodity->name;
    }

    //appends for market_text
    protected $appends = ['commodity_text','market_text','parish_text'];

    //appends for market_text
    public function getMarketTextAttribute()
    {
        if ($this->market == null) {
            return 'No Market';
        }
        return $this->market->name;
    } 

    //getter for parish_text
    public function getParishTextAttribute()
    {
        if ($this->parish == null) {
            return 'No Parish';
        }
        return $this->parish->name_text;
    } 
}
