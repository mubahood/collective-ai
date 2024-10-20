<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    use HasFactory;

    //created
    public static function boot()
    {
        parent::boot();
        self::created(function ($m) {
            Utils::process_price_records();
        });

        //updating
        self::updated(function ($m) {
            Utils::process_price_records();
        });
    }

    //process_price
    public function process_price()
    {
        $min_price = PriceRecord::where('commodity_id', $this->id)->min('retail_price');
        $max_price = PriceRecord::where('commodity_id', $this->id)->max('retail_price');
        $avg_price = PriceRecord::where('commodity_id', $this->id)->avg('retail_price');
        $lastRecord = PriceRecord::where('commodity_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->first();
        if ($lastRecord != null) {
            $this->current_price = $lastRecord->retail_price;
        }
        //price_direction new avg price vs current price
        if ($avg_price == $this->avg_price) {
            $this->price_direction = 'Stable';
        } else if ($avg_price > $this->avg_price) {
            $this->price_direction = 'Rising';
        } else {
            $this->price_direction = 'Falling';
        }
        $this->min_price = $min_price;
        $this->max_price = $max_price;
        $this->avg_price = $avg_price;
        $this->save();
    }
}
