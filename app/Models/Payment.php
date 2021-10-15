<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public function parcel(){
        return $this->belongsTo('App\Models\Parcel');
    }

    public function monthlyPayment(){
        return $this->belongsTo('App\Models\MonthlyPayment');
    }
}
