<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mes extends Model
{
    use HasFactory;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mes';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'year',
        'index',
        'enabled',
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


    // public function ingresos()
    // {
    //     return $this->hasMany('App\Models\Ingreso');
    // }

    public function ingresos()
    {
        return $this->hasMany('App\Models\Ingreso', 'mes_id');
    }

    public function lecturas()
    {
//        todo falta mandar en su formato
        return $this->hasMany('App\Models\Lectura', 'mes_id');
    }

}
