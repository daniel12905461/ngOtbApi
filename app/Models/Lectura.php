<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lectura extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lecturas';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lectura_actual',
        'fecha',
        'parcel_id',
        'mes_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Get the Parcel for this model.
     *
     * @return App\Models\Parcel
     */
    public function Parcel()
    {
        return $this->belongsTo('App\Models\Parcel', 'parcel_id', 'id');
    }

    /**
     * Get the Me for this model.
     *
     * @return App\Models\Mes
     */
    public function mes()
    {
        return $this->belongsTo('App\Models\Mes', 'mes_id', 'id');
    }


    /**
     * Get created_at in array format
     *
     * @param string $value
     * @return array
     */
//    public function getCreatedAtAttribute($value)
//    {
//        return \DateTime::createFromFormat($this->getDateFormat(), $value)->format('j/n/Y g:i A');
//    }

    /**
     * Get updated_at in array format
     *
     * @param string $value
     * @return array
     */
//    public function getUpdatedAtAttribute($value)
//    {
//        return \DateTime::createFromFormat($this->getDateFormat(), $value)->format('j/n/Y g:i A');
//    }

}
