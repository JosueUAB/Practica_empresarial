<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    //
    public function index()
    {
        $usuarios = Usuarios::all();
        return response()->json($usuarios);
    }

    public function mostrar($id)
    {
        $usuario = Usuarios::find($id);
        if ($usuario) {
            return response()->json($usuario);
        } else {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'contraseña' => 'required|string|min:8',
            'rol' => 'required|string|max:50'
        ]);

        $usuario = Usuarios::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contraseña' => bcrypt($request->contraseña),
            'rol' => $request->rol
        ]);
        return response()->json($usuario, 201);
    }

    public function actualizar(Request $request, $id)
    {
        $usuario = Usuarios::find($id);
        if ($usuario) {
            $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'correo' => 'sometimes|email|unique:usuarios,correo,' . $id,
                'contraseña' => 'sometimes|string|min:8',
                'rol' => 'sometimes|string|max:50'
            ]);

            if ($request->has('contraseña')) {
                $request->merge(['contraseña' => bcrypt($request->contraseña)]);
            }

            $usuario->update($request->all());
            return response()->json($usuario);
        } else {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }

    public function eliminar($id)
    {
        $usuario = Usuarios::find($id);
        if ($usuario) {
            $usuario->delete();
            return response()->json(['message' => 'Usuario eliminado']);
        } else {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }
}
