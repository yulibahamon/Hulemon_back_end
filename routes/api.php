<?php

use App\Http\Controllers\AutenticacionSocialiteController;
use App\Http\Controllers\PqrsController;
use App\Http\Controllers\RedesSocialesController;
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
| be assigned to the "api" middleware group. Make something great
|
*/

Route::post('register', [UserController::class, "register"]);
Route::post('login', [UserController::class, 'authenticate']);
Route::post('refresh', [UserController::class, 'refresh']);

Route::post('redes_sociales/activas', [RedesSocialesController::class, 'activas']);

Route::post('login/{provider}', [AutenticacionSocialiteController::class, 'login']);
Route::post('validarToken', [AutenticacionSocialiteController::class, 'validarToken']);
Route::post('encriptar_token/{token}', [AutenticacionSocialiteController::class, 'encriptarToken']);

Route::middleware(['jwt.verify'])->group(function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('tabla_usuarios', [UserController::class, 'tablaUsuarios']);
    //Route::post('buscarRol/{id}', [UserController::class, 'buscarRol']);
});

