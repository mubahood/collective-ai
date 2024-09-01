<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'details',
    ];

    public static function boot()
    {
        parent::boot();
        // self::deleting(function ($m) {
        //     throw new Exception("Cannot delete this record.", 1);
        // });
    }

   
}
