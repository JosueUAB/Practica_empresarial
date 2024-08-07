<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ingresos;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function reporteMensual(Request $request)
    {
        $mes = $request->input('mes', Carbon::now()->month);
        $anio = $request->input('anio', Carbon::now()->year);

        $ingresos = Ingresos::whereYear('fecha', $anio)
            ->whereMonth('fecha', $mes)
            ->get();

        $total_ingresos = $ingresos->sum('monto_total');

        return response()->json([
            'mes' => $mes,
            'anio' => $anio,
            'total_ingresos' => $total_ingresos,
            'ingresos' => $ingresos,
            'status' => 200
        ], 200);
    }
}

