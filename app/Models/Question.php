<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable=
        [
          "user_id", 
          "question"
        ];

        //relationship between question and user
        public function user()
        {
            return $this->belongsTo(User::class);
        }

        //relationship between question and answer
        public function answers()
        {
            return $this->hasMany(Answer::class);
        }
}
