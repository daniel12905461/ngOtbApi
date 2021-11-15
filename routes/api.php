<?php


use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/register', [AuthController::class, 'register'])->name('api.auth.register');
Route::post('auth/login', [AuthController::class, 'login'])->name('api.auth.login');
Route::get('auth/me', [AuthController::class, 'me'])
    ->middleware('auth:api');

//Route::post('message/send', [MessageController::class, 'send'])
//    ->middleware('auth:api');
//
//Route::post('message/sendDM', [MessageController::class, 'sendDM'])
//    ->middleware('auth:api');

Route::apiResource('users', 'Api\UserController');
Route::get('users/enabled/{id}', 'Api\UserController@enabled');

Route::apiResource('rols', 'Api\RolController');
Route::get('rols/enabled/{id}', 'Api\RolController@enabled');

Route::apiResource('devices', 'Api\DeviceController');

Route::apiResource('members', 'Api\MemberController');
Route::get('members/enabled/{id}', 'Api\MemberController@enabled');
Route::get('members/parcels/getall', 'Api\MemberController@getAllMemberswithParcels');

Route::apiResource('parcels', 'Api\ParcelController');
Route::post('parcels/mes_ingresos_parcel', 'Api\ParcelController@parcelIngresosMeses');
Route::get('parcels/enabled/{id}', 'Api\ParcelController@enabled');
Route::get('parcels/mes/{id}', 'Api\ParcelController@getAllByIdMes');

Route::apiResource('settings', 'Api\SettingController');

Route::apiResource('cobro_aguas', 'Api\CobroAguaController');
Route::get('cobro_aguas/enabled/{id}', 'Api\CobroAguaController@enabled');

Route::apiResource('tipo_moneda', "Api\TipoMonedasController");
Route::get('tipo_moneda/enabled/{id}', 'Api\TipoMonedasController@enabled');

Route::apiResource('cobro_aguas', 'Api\CobroAguaController');
Route::get('cobro_aguas/enabled/{id}', 'Api\CobroAguaController@enabled');

Route::apiResource('prices', 'Api\PriceController');

Route::apiResource('monthly_payments', 'Api\MonthlyPaymentController');

Route::apiResource('payments', 'Api\PaymentController');

//Route::get('mes/mes_ingresos_parcel/{parcel_id}', 'Api\MesController@mesesIngresosParcel');

Route::group([
    'prefix' => 'cuenta_ingresos',
], function () {
    Route::get('/', 'Api\CuentaIngresosController@index')
        ->name('api.cuenta_ingresos.cuenta_ingreso.index');
    Route::get('/show/{cuentaIngreso}', 'Api\CuentaIngresosController@show')
        ->name('api.cuenta_ingresos.cuenta_ingreso.show')->where('id', '[0-9]+');
    Route::post('/', 'Api\CuentaIngresosController@store')
        ->name('api.cuenta_ingresos.cuenta_ingreso.store');
    Route::put('cuenta_ingreso/{cuentaIngreso}', 'Api\CuentaIngresosController@update')
        ->name('api.cuenta_ingresos.cuenta_ingreso.update')->where('id', '[0-9]+');
    Route::delete('/cuenta_ingreso/{cuentaIngreso}', 'Api\CuentaIngresosController@destroy')
        ->name('api.cuenta_ingresos.cuenta_ingreso.destroy')->where('id', '[0-9]+');
});

Route::group([
    'prefix' => 'cuenta_egresos',
], function () {
    Route::get('/', 'Api\CuentaEgresosController@index')
        ->name('api.cuenta_egresos.cuenta_egreso.index');
    Route::get('/show/{cuentaEgreso}', 'Api\CuentaEgresosController@show')
        ->name('api.cuenta_egresos.cuenta_egreso.show')->where('id', '[0-9]+');
    Route::post('/', 'Api\CuentaEgresosController@store')
        ->name('api.cuenta_egresos.cuenta_egreso.store');
    Route::put('cuenta_egreso/{cuentaEgreso}', 'Api\CuentaEgresosController@update')
        ->name('api.cuenta_egresos.cuenta_egreso.update')->where('id', '[0-9]+');
    Route::delete('/cuenta_egreso/{cuentaEgreso}', 'Api\CuentaEgresosController@destroy')
        ->name('api.cuenta_egresos.cuenta_egreso.destroy')->where('id', '[0-9]+');
});


Route::group([
    'prefix' => 'egresos',
], function () {
    Route::get('/', 'Api\EgresosController@index')
        ->name('api.egresos.egreso.index');
    Route::get('/show/{egreso}', 'Api\EgresosController@show')
        ->name('api.egresos.egreso.show')->where('id', '[0-9]+');
    Route::post('/', 'Api\EgresosController@store')
        ->name('api.egresos.egreso.store');
    Route::put('egreso/{egreso}', 'Api\EgresosController@update')
        ->name('api.egresos.egreso.update')->where('id', '[0-9]+');
    Route::delete('/egreso/{egreso}', 'Api\EgresosController@destroy')
        ->name('api.egresos.egreso.destroy')->where('id', '[0-9]+');
});

Route::group([
    'prefix' => 'ingresos',
], function () {
    Route::get('/', 'Api\IngresosController@index')
        ->name('api.ingresos.ingreso.index');
    Route::get('/show/{ingreso}', 'Api\IngresosController@show')
        ->name('api.ingresos.ingreso.show')->where('id', '[0-9]+');
    Route::post('/', 'Api\IngresosController@store')
        ->name('api.ingresos.ingreso.store');
    Route::put('ingreso/{ingreso}', 'Api\IngresosController@update')
        ->name('api.ingresos.ingreso.update')->where('id', '[0-9]+');
    Route::delete('/ingreso/{ingreso}', 'Api\IngresosController@destroy')
        ->name('api.ingresos.ingreso.destroy')->where('id', '[0-9]+');
});


Route::group([
    'prefix' => 'mes',
], function () {
    Route::get('/', 'Api\MesController@index')
        ->name('api.mes.mes.index');
    Route::get('/show/{mes}', 'Api\MesController@show')
        ->name('api.mes.mes.show')->where('id', '[0-9]+');
    Route::post('/', 'Api\MesController@store')
        ->name('api.mes.mes.store');
    Route::put('/{mes}', 'Api\MesController@update')
        ->name('api.mes.mes.update')->where('id', '[0-9]+');
    Route::delete('/{mes}', 'Api\MesController@destroy')
        ->name('api.mes.mes.destroy')->where('id', '[0-9]+');
    Route::get('/mes_ingresos_parcel/{parcel_id}', 'Api\MesController@mesesIngresosParcel')
       ->name('api.mes.mes.destroy');
    Route::get('/lectura', 'Api\MesController@getAllWithLectura')
       ->name('api.mes.mes.lectura');
});

Route::group([
    'prefix' => 'lecturas',
], function () {
    Route::get('/', 'Api\LecturasController@index')
        ->name('api.lecturas.lectura.index');
    Route::get('/show/{lectura}', 'Api\LecturasController@show')
        ->name('api.lecturas.lectura.show');
    Route::post('/', 'Api\LecturasController@store')
        ->name('api.lecturas.lectura.store');
    Route::put('lectura/{lectura}', 'Api\LecturasController@update')
        ->name('api.lecturas.lectura.update');
    Route::delete('/lectura/{lectura}', 'Api\LecturasController@destroy')
        ->name('api.lecturas.lectura.destroy');
});
