<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable =
        [
          "question_id", 
          "user_id", 
          "answer"
        ];


        //relationship between answer and question
        public function question()
        {
            return $this->belongsTo(Question::class);
        }
}
