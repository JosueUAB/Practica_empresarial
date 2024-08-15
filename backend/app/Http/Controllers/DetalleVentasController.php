<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetalleVenta;


class DetalleVentasController extends Controller
{
    //
    public function index()
    {
        $detalles = DetalleVenta::with('venta', 'producto')->get();
        return response()->json($detalles);
    }

    public function mostrar($id)
    {
        $detalle = DetalleVentas::with('venta', 'producto')->find($id);
        if ($detalle) {
            return response()->json($detalle);
        } else {
            return response()->json(['message' => 'Detalle de venta no encontrado'], 404);
        }
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'id_venta' => 'required|exists:ventas,id',
            'id_producto' => 'required|exists:productos,id',
            'cantidad' => 'required|integer',
            'precio_unitario' => 'required|numeric',
            'importe' => 'required|numeric'
        ]);

        $detalle = DetalleVenta::create($request->all());
        return response()->json($detalle, 201);
    }

    public function actualizar(Request $request, $id)
    {
        $detalle = DetalleVenta::find($id);
        if ($detalle) {
            $request->validate([
                'id_venta' => 'sometimes|exists:ventas,id',
                'id_producto' => 'sometimes|exists:productos,id',
                'cantidad' => 'sometimes|integer',
                'precio_unitario' => 'sometimes|numeric',
                'importe' => 'sometimes|numeric'
            ]);

            $detalle->update($request->all());
            return response()->json($detalle);
        } else {
            return response()->json(['message' => 'Detalle de venta no encontrado'], 404);
        }
    }

    public function eliminar($id)
    {
        $detalle = DetalleVenta::find($id);
        if ($detalle) {
            $detalle->delete();
            return response()->json(['message' => 'Detalle de venta eliminado']);
        } else {
            return response()->json(['message' => 'Detalle de venta no encontrado'], 404);
        }
    }
}
