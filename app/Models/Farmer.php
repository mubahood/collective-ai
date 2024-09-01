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
            //create user account
            $this->create_user_account();
        }
        if ($this->user == null) {
            return $this->first_name . ' ' . $this->last_name;
        }

        return $this->user->name;
    }

    //create user account
    public function create_user_account()
    {
        /* 
farmer account


id	
organisation_id	
farmer_group_id	
first_name	
last_name	
country_id	
language_id	
national_id_number	
gender	
education_level	
year_of_birth	
phone	
email	
is_your_phone	
is_mm_registered	
other_economic_activity	
location_id	
address	
latitude	
longitude	
password	
farming_scale	
land_holding_in_acres	
land_under_farming_in_acres	
ever_bought_insurance	
ever_received_credit	
status	
created_by_user_id	
created_by_agent_id	
agent_id	
created_at	
updated_at	
poverty_level	
food_security_level	
marital_status	
family_size	
farm_decision_role	
is_pwd	
is_refugee	
date_of_birth	
age_group	
language_preference	
phone_number	
phone_type	
preferred_info_type	
home_gps_latitude	
home_gps_longitude	
village	
street	
house_number	
land_registration_numbers	
labor_force	
equipment_owned	
livestock	
crops_grown	
has_bank_account	
has_mobile_money_account	
payments_or_transfers	
financial_service_provider	
has_credit	
loan_size	
loan_usage	
farm_business_plan	
covered_risks	
insurance_company_name	
insurance_cost	
repaid_amount	
photo	
district_id	
subcounty_id	
parish_id	
bank_id	
other_livestock_count	
poultry_count	
sheep_count	
goat_count	
cattle_count	
bank_account_number	
has_receive_loan	
	
Edit Edit
Copy Copy

*/

        /* 
        User account 
id	

	
Edit
        */
        //now create a new user account based on the top fields

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
}
