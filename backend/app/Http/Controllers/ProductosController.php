<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductosController extends Controller
{
    //
    public function index()
    {
        $productos = Producto::all();
        return response()->json($productos);
    }

    public function mostrar($id)
    {
        $producto = Producto::find($id);
        if ($producto) {
            return response()->json($producto);
        } else {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
    }
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'descripcion' => 'required|string|max:255'
        ]);

        $producto = Producto::create($request->all());
        return response()->json($producto, 201);
    }

    public function actualizar(Request $request, $id)
    {
        $producto = Producto::find($id);
        if ($producto) {
            $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'precio' => 'sometimes|numeric',
                'stock' => 'sometimes|integer',
                'descripcion' => 'sometimes|string|max:255'
            ]);

            $producto->update($request->all());
            return response()->json($producto);
        } else {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
    }



    public function eliminar($id)
    {
        $producto = Producto::find($id);
        if ($producto) {
            $producto->delete();
            return response()->json(['message' => 'Producto eliminado']);
        } else {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
    }
}
