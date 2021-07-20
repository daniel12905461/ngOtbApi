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

    /**
     * @param $value
     * @return string
     * muta la db solo en ejecucuion
     */
    public function getDirPhotoAttribute($value)
    {
        if ($value !== null) {
            return asset(Storage::url($value));
        } else {
            return $value;
        }
    }
    /**
     *
     * cambia la db  cuando pasa por aqui
     */

//    public function setDirPhotoAttribute($value)
//    {
//        $this->attributes['dir_photo'] = Storage::url('file.jpg');
//    }


    //    relacion de uno a muchos
    public function parcels()
    {
        return $this->hasMany('App\Models\Parcel');
    }

//$url = Storage::url('file.jpg');


}
