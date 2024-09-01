<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category', 
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'level_of_education',
        'phone_number',
        'gender',
        'sub_county',
        'parish',
        'village',
        'farmers_group',
        'farming_experience',
        'production_scale',
        'number_of_dependants',
        'company_information',
        'registration_date',
        'registration_number',
        'district',
        'specialization',
        'service_provider_name',
        'physical_address',
        'email_address',
        'services_offered',
        'service_category',
        'status',

        
    ];

  //on creating a registration the user role is set to 2
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($registration) 
        {
            //if the user is an admin, set the status to 1
            $user = auth()->user();
            if($user->isRole('administrator'))
            {
                $registration->status = 1;

                //create a new user with the user role of 4
                $new_user = new User();
                $new_user->name = $registration->first_name . ' ' . $registration->last_name;
                $new_user->username = $registration->first_name;
                $new_user->phone_number = $registration->phone_number;
                $new_user->email = $registration->email_address ? $registration->email_address : ' ';
                
                $new_user->password = bcrypt('password');
                $new_user->save();

                //create a new role for the user
                $new_role = new AdminRoleUser();
                $new_role->user_id = $new_user->id;
                $new_role->role_id = 4;
                //$new_role->save();

            }
            //$new_user->email not valid em
            if(filter_var($new_user->email_address, FILTER_VALIDATE_EMAIL))
            {
                $new_user->email_address = rand(10, 100) . $new_user->email_address;
            } 
          
        }          
        );

        static::updated(function ($registration) 
        {

            //get the user_id of the registration, then check what the role of that id is in the admin_role_user table

            $user_id = $registration->user_id;
            $roles = AdminRoleUser::where('role_id', 1)->get();
            //check if any of those roles , the user id matches the user id of the registration
            foreach($roles as $role)
            {
                if($role->user_id != $user_id)
                {
                      //change the role of the basic user to that of the seed producer if approved
                    if($registration->isDirty('status') && $registration->status == 1){
                    
                        if($registration->category == 'farmer' || $registration->category == 'seed producer'){
                        
                            AdminRoleUser::where([
                                'user_id' => $registration->user_id
                            ])->delete();
                            $new_role = new AdminRoleUser();
                            $new_role->user_id = $registration->user_id;
                            $new_role->role_id = 4;
                            $new_role->save();
                        }
                    }
                }
            
            }
           

         
         
        }  
                    
            );
        }


}
