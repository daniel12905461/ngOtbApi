<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    use HasFactory;
    //    relacion de uno a muchos
    public function member()
    {
        return $this->belongsTo('App\Models\Member');
    }

    public function ingresos()
    {
        return $this->hasMany('App\Models\Ingreso');
    }
    public function lecturas()
    {
        return $this->hasMany('App\Models\Lectura');
    }
    public function members()
    {
        return $this->belongsToMany(
            'App\Models\Member', 'member_parcels');
    }
}
