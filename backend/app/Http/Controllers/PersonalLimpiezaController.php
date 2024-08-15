<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalLimpieza;

class PersonalLimpiezaController
{
    //
    public function index()
    {
        $personal = PersonalLimpieza::all();
        return response()->json($personal);
    }

    public function mostrar($id)
    {
        $personal = PersonalLimpieza::find($id);
        if ($personal) {
            return response()->json($personal);
        } else {
            return response()->json(['message' => 'Personal de limpieza no encontrado'], 404);
        }
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email'
        ]);

        $personal = PersonalLimpieza::create($request->all());
        return response()->json($personal, 201);
    }

    public function actualizar(Request $request, $id)
    {
        $personal = PersonalLimpieza::find($id);
        if ($personal) {
            $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'telefono' => 'sometimes|string|max:20',
                'correo' => 'sometimes|email'
            ]);

            $personal->update($request->all());
            return response()->json($personal);
        } else {
            return response()->json(['message' => 'Personal de limpieza no encontrado'], 404);
        }
    }

    public function eliminar($id)
    {
        $personal = PersonalLimpieza::find($id);
        if ($personal) {
            $personal->delete();
            return response()->json(['message' => 'Personal de limpieza eliminado']);
        } else {
            return response()->json(['message' => 'Personal de limpieza no encontrado'], 404);
        }
    }
}
