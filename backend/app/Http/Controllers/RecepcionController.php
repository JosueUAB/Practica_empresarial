<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recepcion;


class RecepcionController extends Controller
{
    //
    public function index()
    {
        $recepciones = Recepcion::with('usuario')->get();
        return response()->json($recepciones);
    }

    public function mostrar($id)
    {
        $recepcion = Recepcion::with('usuario')->find($id);
        if ($recepcion) {
            return response()->json($recepcion);
        } else {
            return response()->json(['message' => 'Recepción no encontrada'], 404);
        }
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id',
            'fecha' => 'required|date',
            'ticket' => 'required|string|max:50'
        ]);

        $recepcion = Recepcion::create($request->all());
        return response()->json($recepcion, 201);
    }

    public function actualizar(Request $request, $id)
    {
        $recepcion = Recepcion::find($id);
        if ($recepcion) {
            $request->validate([
                'id_usuario' => 'sometimes|exists:usuarios,id',
                'fecha' => 'sometimes|date',
                'ticket' => 'sometimes|string|max:50'
            ]);

            $recepcion->update($request->all());
            return response()->json($recepcion);
        } else {
            return response()->json(['message' => 'Recepción no encontrada'], 404);
        }
    }

    public function eliminar($id)
    {
        $recepcion = Recepcion::find($id);
        if ($recepcion) {
            $recepcion->delete();
            return response()->json(['message' => 'Recepción eliminada']);
        } else {
            return response()->json(['message' => 'Recepción no encontrada'], 404);
        }
    }
}
