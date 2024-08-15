<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Clientes;
use App\Models\reservas;
use App\Models\Habitaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservasController extends Controller
{
    // Mostrar todas las reservas
    public function index()
    {
        $reservas = reservas::with('cliente', 'habitacion')->get();

        if ($reservas->isEmpty()) {
            return response()->json([
                'msg' => 'No hay reservas registradas',
                'status' => 400
            ], 400);
        }

        return response()->json([
            'msg' => 'true',
            'reservas' => $reservas,
            'status' => 200
        ], 200);
    }

    // Mostrar una reserva específica
    public function mostrar($id)
    {
        $reserva = reservas::with('cliente', 'habitacion')->find($id);

        if (!$reserva) {
            return response()->json([
                'msg' => 'La reserva no existe',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'msg' => 'true',
            'reserva' => $reserva,
            'status' => 200
        ], 200);
    }

    // Guardar una nueva reserva
    // Guardar una nueva reserva
    public function guardar(Request $request)
    {
        // Validar los datos de la solicitud
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required|exists:clientes,id',
            'habitacion_id' => 'required|exists:habitaciones,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'numero_personas' => 'required|integer|min:1',
            'adelanto' => 'nullable|numeric',
            'tipo_comprobante' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        // Encontrar la habitación
        $habitacion = Habitaciones::find($request->habitacion_id);

        if (!$habitacion) {
            return response()->json([
                'msg' => 'La habitación no existe',
                'status' => 404
            ], 404);
        }

        // Calcular la tarifa
        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = Carbon::parse($request->fecha_fin);

        if ($fechaFin->lessThanOrEqualTo($fechaInicio)) {
            return response()->json([
                'msg' => 'La fecha de fin debe ser posterior a la fecha de inicio',
                'status' => 400
            ], 400);
        }

        $dias = $fechaInicio->diffInDays($fechaFin);
        $tarifa = $habitacion->costo * $dias;
        $adelanto = $request->adelanto;

        // Calcular el saldo
        $saldo = $tarifa - $adelanto;

        // Crear la reserva con la tarifa y el saldo calculados
        $reserva = reservas::create([
            'cliente_id' => $request->cliente_id,
            'habitacion_id' => $request->habitacion_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'numero_personas' => $request->numero_personas,
            'adelanto' => $adelanto,
            'saldo' => $saldo,
            'tipo_comprobante' => $request->tipo_comprobante,
            'tarifa' => $tarifa,
        ]);

        if (!$reserva) {
            return response()->json([
                'msg' => 'Error al crear la reserva',
                'status' => 500
            ], 500);
        }

        // Cambiar el estado de la habitación a "Ocupado"
        $habitacion->estado = 'ocupado';
        $habitacion->save();

        // Actualizar el estado del cliente a "activo"
        $cliente = Clientes::find($request->cliente_id);
        if ($cliente) {
            $cliente->estado = 'activo';
            $cliente->save();
        }

        return response()->json([
            'msg' => 'Reserva creada con éxito',
            'reserva' => $reserva,
            'status' => 201
        ], 201);
    }

    // Actualizar una reserva existente
    public function actualizar(Request $request, $id)
    {
        $reserva = reservas::find($id);

        if (!$reserva) {
            return response()->json([
                'msg' => 'La reserva no existe',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'cliente_id' => 'sometimes|required|exists:clientes,id',
            'habitacion_id' => 'sometimes|required|exists:habitaciones,id',
            'fecha_inicio' => 'sometimes|required|date',
            'fecha_fin' => 'sometimes|required|date|after_or_equal:fecha_inicio',
            'numero_personas' => 'sometimes|required|integer|min:1',
            'tarifa' => 'sometimes|required|numeric',
            'adelanto' => 'nullable|numeric',
            'saldo' => 'nullable|numeric',
            'tipo_comprobante' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $reserva->update($request->all());

        return response()->json([
            'msg' => 'Reserva actualizada con éxito',
            'reserva' => $reserva,
            'status' => 200
        ], 200);
    }

    // Eliminar una reserva
    public function eliminar($id)
    {
        $reserva = reservas::find($id);

        if (!$reserva) {
            return response()->json([
                'msg' => 'La reserva no existe',
                'status' => 404
            ], 404);
        }

        $habitacion = Habitaciones::find($reserva->habitacion_id);
        if ($habitacion) {
            // Cambiar el estado de la habitación a "Disponible"
            $habitacion->estado = 'Disponible';
            $habitacion->save();
        }

        $reserva->delete();

        return response()->json([
            'msg' => 'Reserva eliminada con éxito',
            'status' => 200
        ], 200);
    }
}
