<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsignacionLimpieza;

class AsignacionLimpiezaController extends Controller
{
    //
    public function index()
    {
        $asignaciones = AsignacionLimpieza::with('personal', 'habitacion')->get();
        return response()->json($asignaciones);
    }

    public function mostrar($id)
    {
        $asignacion = AsignacionLimpieza::with('personal', 'habitacion')->find($id);
        if ($asignacion) {
            return response()->json($asignacion);
        } else {
            return response()->json(['message' => 'Asignación de limpieza no encontrada'], 404);
        }
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'id_personal' => 'required|exists:personal_limpieza,id',
            'id_habitacion' => 'required|exists:habitaciones,id',
            'fecha_asignacion' => 'required|date'
        ]);

        $asignacion = AsignacionLimpieza::create($request->all());
        return response()->json($asignacion, 201);
    }

    public function actualizar(Request $request, $id)
    {
        $asignacion = AsignacionLimpieza::find($id);
        if ($asignacion) {
            $request->validate([
                'id_personal' => 'sometimes|exists:personal_limpieza,id',
                'id_habitacion' => 'sometimes|exists:habitaciones,id',
                'fecha_asignacion' => 'sometimes|date'
            ]);

            $asignacion->update($request->all());
            return response()->json($asignacion);
        } else {
            return response()->json(['message' => 'Asignación de limpieza no encontrada'], 404);
        }
    }

    public function eliminar($id)
    {
        $asignacion = AsignacionLimpieza::find($id);
        if ($asignacion) {
            $asignacion->delete();
            return response()->json(['message' => 'Asignación de limpieza eliminada']);
        } else {
            return response()->json(['message' => 'Asignación de limpieza no encontrada'], 404);
        }
    }
}
