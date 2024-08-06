<?php
namespace App\Http\Controllers;

use App\Models\Estadia;
use App\Models\Habitaciones;
use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EstadiasController extends Controller
{
    public function index()
    {
        $estadias = Estadia::with(['cliente', 'habitacion'])->get();

        if ($estadias->isEmpty()) {
            return response()->json([
                'msg' => 'No hay estadías registradas',
                'status' => 400
            ], 400);
        }

        return response()->json([
            'msg' => 'true',
            'estadias' => $estadias,
            'status' => 200
        ], 200);
    }


    // public function guardar(Request $request)
    // {
    //     // Validar los datos de entrada
    //     $validator = Validator::make($request->all(), [
    //         'cliente_id' => 'required|exists:clientes,id',
    //         'habitacion_id' => 'required|exists:habitaciones,id',
    //         'fecha_inicio' => 'required|date',
    //         'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'msg' => 'Error en la validación',
    //             'errors' => $validator->errors(),
    //             'status' => 400
    //         ], 400);
    //     }

    //     // Obtener la habitación
    //     $habitacion = Habitaciones::find($request->habitacion_id);

    //     // Verificar si la habitación está disponible
    //     if (!$habitacion->disponible) {
    //         return response()->json([
    //             'msg' => 'La habitación no está disponible',
    //             'status' => 400
    //         ], 400);
    //     }

    //     // Parsear las fechas
    //     $fecha_inicio = Carbon::parse($request->fecha_inicio);
    //     $fecha_fin = Carbon::parse($request->fecha_fin);

    //     // Calcular los días de estadía
    //     $dias = $fecha_inicio->diffInDays($fecha_fin);

    //     // Asegurarse de que el número de días sea positivo
    //     if ($dias <= 0) {
    //         return response()->json([
    //             'msg' => 'La fecha de fin debe ser después de la fecha de inicio',
    //             'status' => 400
    //         ], 400);
    //     }

    //     // Calcular el monto a pagar
    //     $monto_pagar = $dias * $habitacion->costo;

    //     // Crear la estadía
    //     $estadia = Estadia::create([
    //         'cliente_id' => $request->cliente_id,
    //         'habitacion_id' => $request->habitacion_id,
    //         'fecha_inicio' => $fecha_inicio,
    //         'fecha_fin' => $fecha_fin,
    //         'monto_pagar' => $monto_pagar
    //     ]);

    //     // Marcar la habitación como no disponible
    //     $habitacion->update(['disponible' => false]);

    //     return response()->json([
    //         'msg' => 'Estadía creada exitosamente',
    //         'estadia' => $estadia,
    //         'dias' => $dias,
    //         'costo' => $habitacion->costo,
    //         'status' => 201
    //     ], 201);
    // }

    public function guardar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required|exists:clientes,id',
            'habitacion_id' => 'required|exists:habitaciones,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        // Obtener la habitación
        $habitacion = Habitaciones::find($request->habitacion_id);

        // Verificar si la habitación está disponible
        if (!$habitacion->disponible) {
            return response()->json([
                'msg' => 'La habitación no está disponible',
                'status' => 400
            ], 400);
        }

        // Parsear las fechas
        $fecha_inicio = Carbon::parse($request->fecha_inicio);
        $fecha_fin = Carbon::parse($request->fecha_fin);

        // Calcular los días de estadía
        $dias = $fecha_inicio->diffInDays($fecha_fin);

        // Asegurarse de que el número de días sea positivo
        if ($dias <= 0) {
            return response()->json([
                'msg' => 'La fecha de fin debe ser después de la fecha de inicio',
                'status' => 400
            ], 400);
        }

        // Calcular el monto a pagar
        $monto_pagar = $dias * $habitacion->costo;

        // Crear la estadía
        $estadia = Estadia::create([
            'cliente_id' => $request->cliente_id,
            'habitacion_id' => $request->habitacion_id,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'monto_pagar' => $monto_pagar
        ]);

        // Marcar la habitación como no disponible
        $habitacion->update(['disponible' => false]);

        // Registrar el ingreso diario
        $fecha_actual = Carbon::now()->toDateString();
        $ingreso_diario = IngresoDiario::where('fecha', $fecha_actual)->first();

        if ($ingreso_diario) {
            $ingreso_diario->increment('monto_total', $monto_pagar);
        } else {
            IngresoDiario::create([
                'fecha' => $fecha_actual,
                'monto_total' => $monto_pagar
            ]);
        }

        return response()->json([
            'msg' => 'Estadía creada exitosamente',
            'estadia' => $estadia,
            'dias' => $dias,
            'costo' => $habitacion->costo,
            'status' => 201
        ], 201);
    }
    public function mostrar($id)
    {
        $estadia = Estadia::with(['cliente', 'habitacion'])->find($id);

        if (!$estadia) {
            return response()->json([
                'msg' => 'La estadía no existe',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'msg' => 'true',
            'estadia' => $estadia,
            'status' => 200
        ], 200);
    }

    public function actualizar($id, Request $request)
    {
        $estadia = Estadia::find($id);

        if (!$estadia) {
            return response()->json([
                'msg' => 'La estadía no existe',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $habitacion = Habitaciones::find($estadia->habitacion_id);
        $fecha_inicio = Carbon::parse($request->fecha_inicio);
        $fecha_fin = Carbon::parse($request->fecha_fin);
        $dias = $fecha_fin->diffInDays($fecha_inicio);
        $monto_pagar = $dias * $habitacion->costo;

        $estadia->update([
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'monto_pagar' => $monto_pagar
        ]);

        return response()->json([
            'msg' => 'Estadía actualizada exitosamente',
            'estadia' => $estadia,
            'status' => 200
        ], 200);
    }

    public function eliminar($id)
    {
        // Buscar la estadía por ID
        $estadia = Estadia::find($id);

        // Verificar si la estadía existe
        if (!$estadia) {
            return response()->json([
                'msg' => 'La estadía no existe',
                'status' => 404
            ], 404);
        }

        // Obtener la habitación asociada
        $habitacion = Habitaciones::find($estadia->habitacion_id);

        // Verificar si la habitación existe
        if (!$habitacion) {
            return response()->json([
                'msg' => 'La habitación asociada no existe',
                'status' => 404
            ], 404);
        }

        // Eliminar la estadía
        $estadia->delete();

        // Marcar la habitación como disponible
        $habitacion->update(['disponible' => true]);

        return response()->json([
            'msg' => 'Estadía eliminada y habitación marcada como disponible',
            'status' => 200
        ], 200);
    }
}
