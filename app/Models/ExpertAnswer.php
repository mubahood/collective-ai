<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertAnswer extends Model
{
    use HasFactory;

    protected $fillable =
    [
      "pests_and_diseases_id", 
      "user_id", 
      "answer"
    ];


    //relationship between answer and question
    public function question()
    {
        return $this->belongsTo(PestsAndDisease::class);
    }
}
