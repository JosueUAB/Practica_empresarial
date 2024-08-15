<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Clientes;
use App\Models\Producto; // Importa el modelo Producto


class VentasController extends Controller
{
    public function index()
    {
        $ventas = Venta::with(['clientes', 'detalles.producto'])->get();
        return response()->json($ventas);
    }

    public function mostrar($id)
    {
        $venta = Venta::with(['cliente', 'detalles.producto'])->find($id);
        if ($venta) {
            return response()->json($venta);
        } else {
            return response()->json(['message' => 'Venta no encontrada'], 404);
        }
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'forma_pago' => 'required|in:QR,contado,cargada_a_habitacion',
            'detalles' => 'required|array',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric',
            'detalles.*.importe' => 'required|numeric'
        ]);

        // Start transaction
        \DB::beginTransaction();

        try {
            $venta = Venta::create([
                'id_cliente' => $request->id_cliente,
                'fecha' => $request->fecha,
                'forma_pago' => $request->forma_pago,
                'total' => collect($request->detalles)->sum('importe')
            ]);

            foreach ($request->detalles as $detalle) {
                $producto = Producto::find($detalle['producto_id']);
                if ($producto->stock < $detalle['cantidad']) {
                    return response()->json(['message' => 'Stock insuficiente para el producto ' . $producto->nombre], 400);
                }
                $producto->decrement('stock', $detalle['cantidad']);

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'importe' => $detalle['importe']
                ]);
            }

            // Commit transaction
            \DB::commit();

            return response()->json($venta, 201);
        } catch (\Exception $e) {
            // Rollback transaction
            \DB::rollback();
            return response()->json(['message' => 'Error al procesar la venta'], 500);
        }
    }

    public function actualizar(Request $request, $id)
    {
        $venta = Venta::find($id);
        if ($venta) {
            $request->validate([
                'id_cliente' => 'sometimes|exists:clientes,id',
                'fecha' => 'sometimes|date',
                'forma_pago' => 'sometimes|in:QR,contado,cargada_a_habitacion',
                'detalles' => 'sometimes|array',
                'detalles.*.producto_id' => 'required|exists:productos,id',
                'detalles.*.cantidad' => 'required|integer|min:1',
                'detalles.*.precio_unitario' => 'required|numeric',
                'detalles.*.importe' => 'required|numeric'
            ]);

            // Start transaction
            \DB::beginTransaction();

            try {
                // Update Venta
                $venta->update($request->only(['id_cliente', 'fecha', 'forma_pago']));

                // Remove existing detalles
                DetalleVenta::where('venta_id', $venta->id)->delete();

                // Update stock and create new detalles
                foreach ($request->detalles as $detalle) {
                    $producto = Producto::find($detalle['producto_id']);
                    if ($producto->stock < $detalle['cantidad']) {
                        return response()->json(['message' => 'Stock insuficiente para el producto ' . $producto->nombre], 400);
                    }
                    $producto->decrement('stock', $detalle['cantidad']);

                    DetalleVenta::create([
                        'venta_id' => $venta->id,
                        'producto_id' => $detalle['producto_id'],
                        'cantidad' => $detalle['cantidad'],
                        'precio_unitario' => $detalle['precio_unitario'],
                        'importe' => $detalle['importe']
                    ]);
                }

                // Commit transaction
                \DB::commit();

                return response()->json($venta);
            } catch (\Exception $e) {
                // Rollback transaction
                \DB::rollback();
                return response()->json(['message' => 'Error al actualizar la venta'], 500);
            }
        } else {
            return response()->json(['message' => 'Venta no encontrada'], 404);
        }
    }

    public function eliminar($id)
    {
        $venta = Venta::find($id);
        if ($venta) {
            // Start transaction
            \DB::beginTransaction();

            try {
                // Restore stock for each producto
                foreach ($venta->detalles as $detalle) {
                    $producto = Producto::find($detalle->producto_id);
                    $producto->increment('stock', $detalle->cantidad);
                }

                $venta->delete();
                // Commit transaction
                \DB::commit();
                return response()->json(['message' => 'Venta eliminada']);
            } catch (\Exception $e) {
                // Rollback transaction
                \DB::rollback();
                return response()->json(['message' => 'Error al eliminar la venta'], 500);
            }
        } else {
            return response()->json(['message' => 'Venta no encontrada'], 404);
        }
    }
}
