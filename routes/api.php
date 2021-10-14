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
