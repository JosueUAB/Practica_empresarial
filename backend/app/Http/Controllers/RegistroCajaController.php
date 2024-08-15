<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroCaja;


class RegistroCajaController extends Controller
{
    //
    public function index()
    {
        $registros = RegistroCaja::with('caja')->get();
        return response()->json($registros);
    }

    public function mostrar($id)
    {
        $registro = RegistroCaja::with('caja')->find($id);
        if ($registro) {
            return response()->json($registro);
        } else {
            return response()->json(['message' => 'Registro de caja no encontrado'], 404);
        }
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'id_caja' => 'required|exists:caja,id',
            'tipo_operacion' => 'required|string|max:50',
            'monto' => 'required|numeric',
            'descripcion' => 'required|string|max:255',
            'fecha' => 'required|date'
        ]);

        $registro = RegistroCaja::create($request->all());
        return response()->json($registro, 201);
    }

    public function actualizar(Request $request, $id)
    {
        $registro = RegistroCaja::find($id);
        if ($registro) {
            $request->validate([
                'id_caja' => 'sometimes|exists:caja,id',
                'tipo_operacion' => 'sometimes|string|max:50',
                'monto' => 'sometimes|numeric',
                'descripcion' => 'sometimes|string|max:255',
                'fecha' => 'sometimes|date'
            ]);

            $registro->update($request->all());
            return response()->json($registro);
        } else {
            return response()->json(['message' => 'Registro de caja no encontrado'], 404);
        }
    }

    public function eliminar($id)
    {
        $registro = RegistroCaja::find($id);
        if ($registro) {
            $registro->delete();
            return response()->json(['message' => 'Registro de caja eliminado']);
        } else {
            return response()->json(['message' => 'Registro de caja no encontrado'], 404);
        }
    }
}
