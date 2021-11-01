<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ingresos';

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
        'fecha',
        'mes',
        'concepto',
        'monto_importe',
        'descripcion',
        'tipo_moneda_id',
        'cuenta_egresos_id',
        'parcels_id',
        'menbers_id',
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
     * Get the tipoMoneda for this model.
     *
     * @return App\Models\TipoMoneda
     */
    public function tipoMoneda()
    {
        return $this->belongsTo('App\Models\TipoMoneda', 'tipo_moneda_id');
    }

    /**
     * Get the cuentaEgreso for this model.
     *
     * @return App\Models\CuentaEgreso
     */
    public function cuentaEgreso()
    {
        return $this->belongsTo('App\Models\CuentaEgreso', 'cuenta_egresos_id');
    }

    /**
     * Get the parcel for this model.
     *
     * @return App\Models\Parcel
     */
    public function parcel()
    {
        return $this->belongsTo('App\Models\Parcel', 'parcels_id');
    }

    /**
     * Get the menber for this model.
     *
     * @return App\Models\Menber
     */
    public function menber()
    {
        return $this->belongsTo('App\Models\Menber', 'menbers_id');
    }


}
