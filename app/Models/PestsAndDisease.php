<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PestsAndDisease extends Model
{
    use HasFactory;

    protected $fillable = [
        'garden_location',
        'variety_id',
        'category',
        'photo',
        'video',
        'audio',
        'description',
        'user_id'
    ];

      //relationship between question and user
      public function user()
      {
          return $this->belongsTo(User::class);
      }

      //relationship between question and answer
      public function expertAnswers()
      {
          return $this->hasMany(ExpertAnswer::class);
      }
}
