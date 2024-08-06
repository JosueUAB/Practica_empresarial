<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\EstadiasController;
use App\Http\Controllers\HabitacionesController;


#region clientes
Route::get('/clientes', [ClientesController::Class, 'index']);

Route::get('/clientes/{id}', [ClientesController::Class, 'mostrar']);

Route::post('/clientes',[ClientesController::Class, 'guardar']);

Route::put('/clientes/{id}',[clientesController::Class, 'actualizar']);

Route::delete('/clientes/{id}',[clientesController::Class, 'eliminar']);
#endregion clientes


#region Habitaciones

Route::get('/habitaciones', [HabitacionesController::class, 'index']);
Route::post('/habitaciones', [HabitacionesController::class, 'guardar']);
Route::get('/habitaciones/{id}', [HabitacionesController::class, 'mostrar']);
Route::put('/habitaciones/{id}', [HabitacionesController::class, 'actualizar']);
Route::delete('/habitaciones/{id}', [HabitacionesController::class, 'eliminar']);
#endregion Habitaciones






Route::prefix('estadias')->group(function () {
    Route::get('/', [EstadiasController::class, 'index']);
    Route::post('/', [EstadiasController::class, 'guardar']);
    Route::get('/{id}', [EstadiasController::class, 'mostrar']);
    Route::put('/{id}', [EstadiasController::class, 'actualizar']);
    Route::delete('/{id}', [EstadiasController::class, 'eliminar']);
});
