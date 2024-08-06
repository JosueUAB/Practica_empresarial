<?php

namespace App\Http\Controllers;

use App\Models\Habitaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HabitacionesController extends Controller
{
    // Método para obtener todas las habitaciones
    public function index()
    {
        $habitaciones = Habitaciones::all();

        if ($habitaciones->isEmpty()) {
            return response()->json([
                'msg' => 'No hay habitaciones registradas',
                'status' => 400
            ], 400);
        }

        return response()->json([
            'msg' => 'true',
            'habitaciones' => $habitaciones,
            'status' => 200
        ], 200);
    }

    // Método para guardar una nueva habitación
    public function guardar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero' => 'required|string|max:10',
            'tipo' => 'required|in:individual,doble,colectiva,matrimonial',
            'cantidad_camas' => 'required|integer|min:1',
            'descripcion' => 'nullable|string',
            'costo' => 'required|numeric|min:0',
            'tv' => 'boolean',
            'wifi' => 'boolean',
            'ducha' => 'boolean',
            'baño' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $habitacion = Habitaciones::create([
            'numero' => $request->numero,
            'tipo' => $request->tipo,
            'cantidad_camas' => $request->cantidad_camas,
            'descripcion' => $request->descripcion,
            'costo' => $request->costo,
            'tv' => $request->tv ?? false,   // Asignar falso si el campo no está presente
            'wifi' => $request->wifi ?? false,
            'ducha' => $request->ducha ?? false,
            'baño' => $request->baño ?? false
        ]);

        return response()->json([
            'msg' => 'Habitación creada exitosamente',
            'habitacion' => $habitacion,
            'status' => 201
        ], 201);
    }

    // Método para mostrar una habitación específica
    public function mostrar($id)
    {
        $habitacion = Habitaciones::find($id);

        if (!$habitacion) {
            return response()->json([
                'msg' => 'La habitación no existe',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'msg' => 'true',
            'habitacion' => $habitacion,
            'status' => 200
        ], 200);
    }

    // Método para actualizar una habitación existente
    public function actualizar($id, Request $request)
    {
        $habitacion = Habitaciones::find($id);

        if (!$habitacion) {
            return response()->json([
                'msg' => 'La habitación no existe',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'numero' => 'required|string|max:10',
            'tipo' => 'required|in:individual,doble,colectiva,matrimonial',
            'cantidad_camas' => 'required|integer|min:1',
            'descripcion' => 'nullable|string',
            'costo' => 'required|numeric|min:0',
            'tv' => 'boolean',
            'wifi' => 'boolean',
            'ducha' => 'boolean',
            'baño' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $habitacion->update([
            'numero' => $request->numero,
            'tipo' => $request->tipo,
            'cantidad_camas' => $request->cantidad_camas,
            'descripcion' => $request->descripcion,
            'costo' => $request->costo,
            'tv' => $request->tv ?? false,
            'wifi' => $request->wifi ?? false,
            'ducha' => $request->ducha ?? false,
            'baño' => $request->baño ?? false
        ]);

        return response()->json([
            'msg' => 'Habitación actualizada exitosamente',
            'habitacion' => $habitacion,
            'status' => 200
        ], 200);
    }

    // Método para eliminar una habitación
    public function eliminar($id)
    {
        $habitacion = Habitaciones::find($id);

        if (!$habitacion) {
            return response()->json([
                'msg' => 'La habitación no existe',
                'status' => 404
            ], 404);
        }

        $habitacion->delete();

        return response()->json([
            'msg' => 'Habitación eliminada exitosamente',
            'status' => 200
        ], 200);
    }
}
