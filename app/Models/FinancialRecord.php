<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialRecord extends Model
{
    use HasFactory;

    //fillable
    protected $fillable = [
        'garden_id',
        'user_id',
        'category', //income or expense
        'date',
        'amount',
        'payment_method', //cash, cheque, bank transfer, mobile money
        'recipient',
        'description',
        'quantity'
    ];

    //belongs to garden
    public function garden()
    {
        return $this->belongsTo(Garden::class);
    }

    //appends
    protected $appends = [
        'garden_text',
    ];

    //getter for garden_text
    public function getGardenTextAttribute()
    {
        if ($this->garden == null) {
            return "No garden found.";
        }
        return $this->garden->name;
    }
}
