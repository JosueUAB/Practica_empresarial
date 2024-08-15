<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\WifiController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ProductosController;

use App\Http\Controllers\RecepcionController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\RegistroCajaController;
use App\Http\Controllers\DetalleVentasController;
use App\Http\Controllers\ReportesRecepcionController;



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


//#region productos
Route::get('/productos', [ProductosController::class, 'index']);
Route::get('/productos/{id}', [ProductosController::class, 'mostrar']);
Route::post('productos', [ProductosController::class, 'guardar']);

Route::put('/productos/{id}', [ProductosController::class, 'actualizar']);
Route::delete('/productos/{id}', [ProductosController::class, 'eliminar']);
//#endregion productos

//#region ventas
Route::get('/ventas', [VentasController::class, 'index']);
Route::get('/ventas/{id}', [VentasController::class, 'mostrar']);
Route::post('/ventas', [VentasController::class, 'guardar']);
Route::put('/ventas/{id}', [VentasController::class, 'actualizar']);
Route::delete('/ventas/{id}', [VentasController::class, 'eliminar']);
//#endregion ventas

//#region detalle ventas
Route::get('/detalle-ventas', [DetalleVentasController::class, 'index']);
Route::get('/detalle-ventas/{id}', [DetalleVentasController::class, 'mostrar']);
Route::post('/detalle-ventas', [DetalleVentasController::class, 'guardar']);
Route::put('/detalle-ventas/{id}', [DetalleVentasController::class, 'actualizar']);
Route::delete('/detalle-ventas/{id}', [DetalleVentasController::class, 'eliminar']);
//#endregion detalle ventas

//#region usuarios
Route::get('/usuarios', [UsuariosController::class, 'index']);
Route::get('/usuarios/{id}', [UsuariosController::class, 'mostrar']);
Route::post('/usuarios', [UsuariosController::class, 'guardar']);
Route::put('/usuarios/{id}', [UsuariosController::class, 'actualizar']);
Route::delete('/usuarios/{id}', [UsuariosController::class, 'eliminar']);
//#endregion usuarios

//#region caja
Route::get('/caja', [CajaController::class, 'index']);
Route::get('/caja/{id}', [CajaController::class, 'mostrar']);
Route::post('/caja', [CajaController::class, 'guardar']);
Route::put('/caja/{id}', [CajaController::class, 'actualizar']);
Route::delete('/caja/{id}', [CajaController::class, 'eliminar']);
//#endregion caja

//#region registro caja
Route::get('/registro-caja', [RegistroCajaController::class, 'index']);
Route::get('/registro-caja/{id}', [RegistroCajaController::class, 'mostrar']);
Route::post('/registro-caja', [RegistroCajaController::class, 'guardar']);
Route::put('/registro-caja/{id}', [RegistroCajaController::class, 'actualizar']);
Route::delete('/registro-caja/{id}', [RegistroCajaController::class, 'eliminar']);
//#endregion registro caja

//#region reportes recepcion
Route::get('/reportes-recepcion', [ReportesRecepcionController::class, 'index']);
Route::get('/reportes-recepcion/{id}', [ReportesRecepcionController::class, 'mostrar']);
Route::post('/reportes-recepcion', [ReportesRecepcionController::class, 'guardar']);
Route::put('/reportes-recepcion/{id}', [ReportesRecepcionController::class, 'actualizar']);
Route::delete('/reportes-recepcion/{id}', [ReportesRecepcionController::class, 'eliminar']);
//#endregion reportes recepcion

//#region recepcion
Route::get('/recepcion', [RecepcionController::class, 'index']);
Route::get('/recepcion/{id}', [RecepcionController::class, 'mostrar']);
Route::post('/recepcion', [RecepcionController::class, 'guardar']);
Route::put('/recepcion/{id}', [RecepcionController::class, 'actualizar']);
Route::delete('/recepcion/{id}', [RecepcionController::class, 'eliminar']);
//#endregion recepcion
Route::post('test', function (Request $request) {
    return response()->json(['message' => 'Test route hit']);
});
