<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataCollectionGenerator extends Model
{
    use HasFactory;

    //boot
    public static function boot()
    {


        parent::boot();

        //deleting
        self::deleting(function ($m) {
            throw new Exception('Cannot delete this record'); 
        });
        self::creating(function ($m) {
            $due_date = $m->due_date;
            $dup = DataCollectionGenerator::where('due_date', $due_date)->first();
            if ($dup != null) {
                throw new Exception('Data Collection for this date already exists');
            }
        });

        //updaring
        self::updating(function ($m) {
            $due_date = $m->due_date;
            $dup = DataCollectionGenerator::where('due_date', $due_date)->first();
            if ($dup != null && $dup->id != $m->id) {
                throw new Exception('Data Collection for this date already exists');
            }
        });

        //created
        self::created(function ($m) {
            if ($m->do_generate == 'Yes') {
                self::generate_records($m);
            }
            //prepared statemnt that sets do_generate to No
            $stmt = "UPDATE data_collection_generators SET do_generate = 'No' WHERE id = ?";
            DB::update($stmt, [$m->id]);
        });
        self::updated(function ($m) {
            if ($m->do_generate == 'Yes') {
                self::generate_records($m);
            }
            //prepared statemnt that sets do_generate to No
            $stmt = "UPDATE data_collection_generators SET do_generate = 'No' WHERE id = ?";
            DB::update($stmt, [$m->id]);
        });
    }

    //generate_records
    public static function generate_records($m)
    {
        /* $com = Commodity::where('name','Irish Potatoes')->first();
        $com->process_price();
        dd($com); */
        //set unlimited time
        //set unlimited memory
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $commodies = Commodity::all();
        $markets = Market::all();
        $due_date = $m->due_date;
        foreach ($commodies as $com) {
            foreach ($markets as $market) {
                $record = PriceRecord::where('data_collection_generator_id', $m->id)
                    ->where('commodity_id', $com->id)
                    ->where('market_id', $market->id)
                    ->first();
                if ($record == null) {
                    $record = new PriceRecord();
                    $record->data_collection_generator_id = $m->id;
                    $record->due_date = $due_date;
                    $record->commodity_id = $com->id;
                    $record->parish_id = $market->parish_id;
                    $record->subcounty_id = $market->subcounty_id;
                    $record->district_id = $market->district_id;
                    $record->gps = $market->gps;
                    $record->measurement_unit = $com->unit;
                    $record->price_direction = 'Stable';
                    $record->status = 'Pending';
                    $record->market_id = $market->id;
                    $record->save();
                }
            }
        }
    }

    //has many price records
    public function price_records()
    {
        return $this->hasMany(PriceRecord::class);
    } 
}
