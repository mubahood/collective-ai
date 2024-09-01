<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    //table
    protected $table = "farmers";

    //boot
    protected static function boot()
    {
        parent::boot();
        //creating
        static::creating(function ($farmer) {
            $farmer = self::prepareData($farmer);
            return $farmer;
        });

        //created
        static::created(function ($farmer) {
            $farmer->create_user_account();
        });

        //updating
        static::updating(function ($farmer) {
            $farmer = self::prepareData($farmer);
            return $farmer;
        });
    }

    //prepare data
    public static function prepareData($data)
    {
        $gender = strtolower($data->gender);
        if ($gender == 'm' || $gender == 'male') {
            $data->gender = 'Male';
        } else if ($gender == 'f' || $gender == 'female') {
            $data->gender = 'Female';
        }

        $parish = Parish::find($data->parish_id);
        if ($parish != null) {
            $data->district_id = $parish->district_id;
            $data->subcounty_id = $parish->subcounty_id;
        } else {
            //throw new \Exception('Parish not found');
            $sub = Subcounty::find($data->subcounty_id);
            if ($sub != null) {
                $data->district_id = $sub->district_id;
            } else {
                //throw new \Exception('Subcounty not found');
                $district = District::find($data->district_id);
                if ($district == null) {
                    //throw new \Exception('District not found');
                } else {
                    $data->district_id = $district->id;
                }
            }
        }
        return $data;
    }

    //appends user_text
    protected $appends = ['user_text'];

    //getter for user_text
    public function getUserTextAttribute()
    {
        if ($this->user == null) {
            $this->create_user_account();
        }
        if ($this->user == null) {
            return $this->first_name . ' ' . $this->last_name;
        }
        $name = trim($this->user->name);

        if (strlen($name) < 1) {
            $name =  $this->first_name . ' ' . $this->last_name;
        }

        if ($this->user->phone_number != null) {
            return $name . ' (' . $this->user->phone_number . ')';
        }
        return $name;
    }


    //create user account
    public function create_user_account()
    {
        $u = User::where('email', $this->email)->first();
        if ($u != null) {
            $this->user_id = $u->id;
            $this->has_user_account = 'Yes';
            $this->save();
            return;
        }
        $u = User::where('phone_number', $this->phone)->first();
        if ($u != null) {
            $this->user_id = $u->id;
            $this->has_user_account = 'Yes';
            $this->save();
            return;
        }
        $u = User::where('username', $this->national_id_number)->first();
        if ($u != null) {
            $this->user_id = $u->id;
            $this->has_user_account = 'Yes';
            $this->save();
            return;
        }
        $u = User::where('user_id', $this->id)->first();
        if ($u != null) {
            $this->user_id = $u->id;
            $this->has_user_account = 'Yes';
            $this->save();
            return;
        }

        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->username = null;
        if ($this->phone != null) {
            $user->username = Utils::prepare_phone_number($this->phone);
        } else if ($this->email != null) {
            $user->username = $this->email;
        } else {
            $user->username = $this->national_id_number;
        }
        $user->email = $this->email;

        if ($user->username == null) {
            $user->username = $user->email;
        }

        $user->password = password_hash('4321', PASSWORD_DEFAULT);
        $user->name = $this->first_name . ' ' . $this->last_name;
        $user->gender = $this->gender;
        $user->email = $this->email;
        $user->phone_number = $this->phone;
        $user->created_at = $this->created_at;
        $user->user_id = $this->id;
        try {
            $user->save();
            $this->user_id = $user->id;
            $this->has_user_account = 'Yes';
            $this->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    //belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //get list of farmers
    public static function get_select_items()
    {
        $items = [];
        $farmers = self::all();
        foreach ($farmers as $farmer) {
            $items[$farmer->user->id] = $farmer->user_text;
        }
        return $items;
    }
}
