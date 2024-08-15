<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportesRecepcion;


class ReportesRecepcionController extends Controller
{
    //
    public function index()
    {
        $reportes = ReportesRecepcion::with('usuario')->get();
        return response()->json($reportes);
    }

    public function mostrar($id)
    {
        $reporte = ReportesRecepcion::with('usuario')->find($id);
        if ($reporte) {
            return response()->json($reporte);
        } else {
            return response()->json(['message' => 'Reporte de recepción no encontrado'], 404);
        }
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id',
            'tipo_reporte' => 'required|string|max:255',
            'fechas' => 'required|date',
            'contenido' => 'required|string',
            'ticket' => 'required|string|max:50'
        ]);

        $reporte = ReportesRecepcion::create($request->all());
        return response()->json($reporte, 201);
    }

    public function actualizar(Request $request, $id)
    {
        $reporte = ReportesRecepcion::find($id);
        if ($reporte) {
            $request->validate([
                'id_usuario' => 'sometimes|exists:usuarios,id',
                'tipo_reporte' => 'sometimes|string|max:255',
                'fechas' => 'sometimes|date',
                'contenido' => 'sometimes|string',
                'ticket' => 'sometimes|string|max:50'
            ]);

            $reporte->update($request->all());
            return response()->json($reporte);
        } else {
            return response()->json(['message' => 'Reporte de recepción no encontrado'], 404);
        }
    }

    public function eliminar($id)
    {
        $reporte = ReportesRecepcion::find($id);
        if ($reporte) {
            $reporte->delete();
            return response()->json(['message' => 'Reporte de recepción eliminado']);
        } else {
            return response()->json(['message' => 'Reporte de recepción no encontrado'], 404);
        }
    }
}
