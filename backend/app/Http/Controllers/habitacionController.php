<?php

namespace App\Http\Controllers;

use App\Models\Habitaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HabitacionController extends Controller
{
    public function index()
    {
        $habitaciones = Habitaciones::all();

        if ($habitaciones->isEmpty()) {
            $data = [
                'msg' => 'No hay habitaciones registradas',
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $data = [
            'msg' => 'true',
            'habitaciones' => $habitaciones,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function guardar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_piso' => 'required|integer',
            'numero' => 'required|string|max:20',
            'tipo' => 'required|in:individual,doble,colectiva,matrimonial,familiar',
            'cantidad_camas' => 'required|integer',
            'limite_personas' => 'required|integer',
            'descripcion' => 'nullable|string',
            'costo' => 'required|numeric',
            'tv' => 'boolean',
            'wifi_id' => 'nullable|exists:wifi,id',
            'ducha' => 'boolean',
            'banio' => 'boolean',
            'estado' => 'required|in:disponible,mantenimiento,limpieza,ocupado,reservado',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $habitacion = Habitaciones::create($request->all());

        if (!$habitacion) {
            $data = [
                'msg' => 'Error al guardar la habitación',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'msg' => 'Habitación guardada con éxito',
            'habitacion' => $habitacion,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function mostrar($id)
    {
        $habitacion = Habitaciones::find($id);

        if (!$habitacion) {
            $data = [
                'msg' => 'La habitación no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'msg' => 'true',
            'habitacion' => $habitacion,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function actualizar($id, Request $request)
    {
        $habitacion = Habitaciones::find($id);

        if (!$habitacion) {
            $data = [
                'msg' => 'La habitación no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'numero_piso' => 'sometimes|required|integer',
            'numero' => 'sometimes|required|string|max:20',
            'tipo' => 'sometimes|required|in:individual,doble,colectiva,matrimonial,familiar',
            'cantidad_camas' => 'sometimes|required|integer',
            'limite_personas' => 'sometimes|required|integer',
            'descripcion' => 'nullable|string',
            'costo' => 'sometimes|required|numeric',
            'tv' => 'sometimes|boolean',
            'wifi_id' => 'nullable|exists:wifi,id',
            'ducha' => 'sometimes|boolean',
            'banio' => 'sometimes|boolean',
            'estado' => 'sometimes|required|in:disponible,mantenimiento,limpieza,ocupado,reservado',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $habitacion->update($request->all());

        $data = [
            'msg' => 'Habitación actualizada con éxito',
            'habitacion' => $habitacion,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function eliminar($id)
    {
        $habitacion = Habitaciones::find($id);

        if (!$habitacion) {
            $data = [
                'msg' => 'La habitación no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $habitacion->delete();

        $data = [
            'msg' => 'Habitación eliminada con éxito',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
