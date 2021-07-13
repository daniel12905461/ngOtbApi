<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    //    relacion de uno a muchos
    public function parcels()
    {
        return $this->hasMany('App\Models\Parcel');
    }
}
