<?php

use App\Http\Controllers\AutenticacionSocialiteController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\DeslizadoresController;
use App\Http\Controllers\PqrsController;
use App\Http\Controllers\RedesSocialesController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ContactosController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!http://localhost:5173/inmuebles
|
*/

Route::post('register', [UserController::class, "register"]);
Route::post('login', [UserController::class, 'authenticate']);
Route::post('refresh', [UserController::class, 'refresh']);

Route::post('sucursales/ciudades', [CiudadController::class, 'ciudadesSucursales']);
Route::post('redes_sociales/activas', [RedesSocialesController::class, 'activas']);
Route::post('deslizadores/activos', [DeslizadoresController::class, 'activos']);

Route::post('login/{provider}', [AutenticacionSocialiteController::class, 'login']);

Route::post('validarToken', [AutenticacionSocialiteController::class, 'validarToken']);

Route::middleware(['jwt.verify'])->group(function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('users/notifications',['as' => 'users.notifications','uses' => 'UserController@notifis']);
    Route::post('users/readNotification',[UserController::class, 'readNotification'])->name('users.readNotification');
});

//validar el jwt token
Route::post('encriptar_token/{token}', [AutenticacionSocialiteController::class, 'encriptarToken']);
Route::post('/perfil/{id}', [UserController::class, 'perfil']);
Route::post('pqrs', [PqrsController::class, "index"]);
Route::post('pqrs/save', [PqrsController::class, "save"]);
Route::post('/contactos/{id}', [ContactosController::class, 'usuarioscontactos']);


//prueba de lemonguard
//Route::post('/pruebalogin', [ContactosController::class, 'pruebalogin']);
//Route::post('/pruebaregister', [ContactosController::class, 'pruebaregister']);