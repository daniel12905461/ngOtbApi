<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    // concatenamos la url de la foto
    public function getDirPhotoAttribute($value)
    {
        if ($value !== null) {
            return asset(Storage::url($value));
        } else {
            return $value;
        }
    }

    public function setDirPhotoAttribute($value)
    {
        $this->attributes['dir_photos'] = 'hola';
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = 'hola';
    }

    //    relacion de uno a muchos
    public function parcels()
    {
        return $this->hasMany('App\Models\Parcel');
    }

//$url = Storage::url('file.jpg');


}
