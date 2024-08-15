<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caja;


class CajaController extends Controller
{
    //
    public function index()
    {
        $cajas = Caja::with('usuario')->get();
        return response()->json($cajas);
    }

    public function mostrar($id)
    {
        $caja = Caja::with('usuario')->find($id);
        if ($caja) {
            return response()->json($caja);
        } else {
            return response()->json(['message' => 'Caja no encontrada'], 404);
        }
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id',
            'estado' => 'required|string|in:abierto,cerrado'
        ]);

        $caja = Caja::create($request->all());
        return response()->json($caja, 201);
    }

    public function actualizar(Request $request, $id)
    {
        $caja = Caja::find($id);
        if ($caja) {
            $request->validate([
                'id_usuario' => 'sometimes|exists:usuarios,id',
                'estado' => 'sometimes|string|in:abierto,cerrado'
            ]);

            $caja->update($request->all());
            return response()->json($caja);
        } else {
            return response()->json(['message' => 'Caja no encontrada'], 404);
        }
    }

    public function eliminar($id)
    {
        $caja = Caja::find($id);
        if ($caja) {
            $caja->delete();
            return response()->json(['message' => 'Caja eliminada']);
        } else {
            return response()->json(['message' => 'Caja no encontrada'], 404);
        }
    }
}
