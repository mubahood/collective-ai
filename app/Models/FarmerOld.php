<?php

namespace App\Models\Farmers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Organisations\Organisation;
use App\Models\Settings\Country;
use App\Models\Settings\Language;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use App\Models\Traits\Relationships\FarmerRelationship;
use Illuminate\Database\Eloquent\Model;

class FarmerOld extends Model
{

    protected static function boot()
    {
        parent::boot();
        self::creating(function (Farmer $model) {
            $count = Farmer::where([])->count();
            $model->id = ($count + 1);
        });
        self::updating(function (Farmer $model) {
            //$model->id = $model->generateUuid();
        });
    }

 
}
