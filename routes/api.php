<?php

use App\Http\Controllers\AutenticacionSocialiteController;
use App\Http\Controllers\PqrsController;
use App\Http\Controllers\RedesSocialesController;
use App\Http\Controllers\ContactosController;
use App\Http\Controllers\LotesController;
use App\Http\Controllers\OpcionesEspecificasController;
use App\Http\Controllers\OpcionesGeneralesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Models\Opciones;
use App\Models\OpcionesEspecificas;
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
    Route::post('tabla_usuarios/{id}', [UserController::class, 'tablaUsuarios']);
    Route::post('users_create', [UserController::class, 'register']);
    Route::post('usuarios_edit_data/{id}', [UserController::class, 'datoseditar']);
    Route::post('usuarios_edit', [UserController::class, 'editar']);
    Route::post('conseguir_agronomos', [UserController::class, 'obteneragronomos']);
    Route::delete('users_destroy/{id}', [UserController::class, 'destroy']);

    Route::post('tabla_roles/{id}', [RolesController::class, 'tablaRoles']);
    Route::post('conseguir_roles', [RolesController::class, 'get']);
    Route::post('roles_create', [RolesController::class, 'guardar']);
    Route::delete('roles_destroy/{id}', [RolesController::class, 'destroy']);

    Route::post('tabla_opciones_generales', [OpcionesGeneralesController::class, 'tablaOpcionesGenerales']);
    Route::post('opciones_generales_create', [OpcionesGeneralesController::class, 'guardar']);
    Route::post('opciones_generales_edit_data/{id}', [OpcionesGeneralesController::class, 'datoseditar']);
    Route::post('opciones_generales_edit', [OpcionesGeneralesController::class, 'editar']);
    Route::delete('opciones_generales_destroy/{id}', [OpcionesGeneralesController::class, 'destroy']);
    
    Route::post('tabla_opciones_especificas', [OpcionesEspecificasController::class, 'tablaOpcionesEspecificas']);
    Route::post('opciones_especificas_create', [OpcionesEspecificasController::class, 'guardar']);
    Route::post('opciones_especificas_edit_data/{id}', [OpcionesEspecificasController::class, 'datoseditar']);
    Route::post('opciones_especificas_edit', [OpcionesEspecificasController::class, 'editar']);
    Route::delete('opciones_especificas_destroy/{id}', [OpcionesEspecificasController::class, 'destroy']);

    Route::post('opciones', [OpcionesEspecificasController::class, 'opciones']);

    Route::post('lotes_usuario/{id}', [LotesController::class, 'lotesPorUsuario']);
    Route::post('lotes_create', [LotesController::class, 'guardar']);
});

