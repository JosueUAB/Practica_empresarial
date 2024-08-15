<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WifiController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\HabitacionController;



#region clientes
Route::get('/clientes', [ClientesController::Class, 'index']);

Route::get('/clientes/{id}', [ClientesController::Class, 'mostrar']);

Route::post('/clientes',[ClientesController::Class, 'guardar']);

Route::put('/clientes/{id}',[clientesController::Class, 'actualizar']);

Route::delete('/clientes/{id}',[clientesController::Class, 'eliminar']);
#endregion clientes

#region habitaciones
Route::get('/habitaciones', [habitacionController::class, 'index']);

Route::get('/habitaciones/{id}', [habitacionController::class, 'mostrar']);

Route::post('/habitaciones', [habitacionController::class, 'guardar']);

Route::put('/habitaciones/{id}', [habitacionController::class, 'actualizar']);

Route::delete('/habitaciones/{id}', [habitacionController::class, 'eliminar']);
#endregion habitaciones



#region wifi
Route::get('/wifi', [WifiController::class, 'index']);

Route::get('/wifi/{id}', [WifiController::class, 'mostrar']);

Route::post('/wifi', [WifiController::class, 'guardar']);

Route::put('/wifi/{id}', [WifiController::class, 'actualizar']);

Route::delete('/wifi/{id}', [WifiController::class, 'eliminar']);
#endregion wifi



#region reservas
Route::get('/reservas', [ReservasController::class, 'index']);

Route::get('/reservas/{id}', [ReservasController::class, 'mostrar']);

Route::post('/reservas', [ReservasController::class, 'guardar']);

Route::put('/reservas/{id}', [ReservasController::class, 'actualizar']);

Route::delete('/reservas/{id}', [ReservasController::class, 'eliminar']);
#endregion reservas
