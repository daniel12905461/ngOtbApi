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
Route::get('parcels/enabled/{id}', 'Api\ParcelController@enabled');
Route::apiResource('settings', 'Api\SettingController');

Route::apiResource('cobro_aguas', 'Api\CobroAguaController');
Route::get('cobro_aguas/enabled/{id}', 'Api\CobroAguaController@enabled');

Route::apiResource('tipo_moneda', "Api\TipoMonedasController");

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
