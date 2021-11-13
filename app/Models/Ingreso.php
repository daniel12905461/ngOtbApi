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
                  'pagado',
                  'tipo_moneda_id',
                  'cuenta_egresos_id',
                  'parcel_id',
                  'member_id',
                  'lectura_id',
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
        return $this->belongsTo('App\Models\TipoMoneda','tipo_moneda_id');
    }

    /**
     * Get the cuentaEgreso for this model.
     *
     * @return App\Models\CuentaEgreso
     */
    public function cuentaEgreso()
    {
        return $this->belongsTo('App\Models\CuentaEgreso','cuenta_egresos_id');
    }

    /**
     * Get the parcel for this model.
     *
     * @return App\Models\Parcel
     */
    public function parcel()
    {
        return $this->belongsTo('App\Models\Parcel','parcel_id');
    }

    /**
     * Get the member for this model.
     *
     * @return App\Models\Member
     */
    public function member()
    {
        return $this->belongsTo('App\Models\Member','member_id');
    }

    /**
     * Get the lectura for this model.
     *
     * @return App\Models\Lectura
     */
    public function lectura()
    {
        return $this->belongsTo('App\Models\Lectura','lectura_id');
    }

    /**
     * Get the me for this model.
     *
     * @return App\Models\Me
     */
    public function mes()
    {
        return $this->belongsTo('App\Models\Mes','mes_id');
    }

    /**
     * Get created_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getCreatedAtAttribute($value)
    {
        return \DateTime::createFromFormat($this->getDateFormat(), $value)->format('j/n/Y g:i A');
    }

    /**
     * Get updated_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getUpdatedAtAttribute($value)
    {
        return \DateTime::createFromFormat($this->getDateFormat(), $value)->format('j/n/Y g:i A');
    }

}
