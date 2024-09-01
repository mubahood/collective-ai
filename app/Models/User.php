<?php

namespace App\Models;

use Encore\Admin\Form\Field\BelongsToMany;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany as RelationsBelongsToMany;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject ;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Encore\Admin\Auth\Database\Administrator;



class User extends Authenticatable implements JWTSubject
{
    use HasFactory; 
    use Notifiable;
 
    protected $fillable = [
            'first_name',
            'last_name',
            'middle_name',
            'username',
            'name',
            'gender',
            'email',
            'phone_number',
            'avatar',
            'password',
          
    ];  
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

       //assign a user a role of 3 once they are registered
       public static function boot()
       {
           parent::boot();

           static::created(function ($user) {
               $user = Administrator::find($user->id);
               $user->roles()->attach(3);
           });
       }


  
}
