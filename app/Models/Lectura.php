<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lectura extends Model
{
    use HasFactory;

    public function mes(){
        return $this->belongsTo('App\Models\mes');
    }

    public function parcel(){
        return $this->belongsTo('App\Models\Parcel');
    }
}
