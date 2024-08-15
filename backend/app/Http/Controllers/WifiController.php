<?php

namespace App\Http\Controllers;

use App\Models\Wifi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WifiController extends Controller
{

    public function index()
    {
        $wifi = Wifi::all();

        if ($wifi->isEmpty()) {
            $data = [
                'msg' => 'No hay redes Wi-Fi registradas',
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $data = [
            'msg' => 'true',
            'wifi' => $wifi,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function guardar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ssid' => 'required|string|max:255',
            'contrasena' => 'required|string|max:255',
            'piso' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $wifi = Wifi::create($request->all());

        if (!$wifi) {
            $data = [
                'msg' => 'Error al guardar la red Wi-Fi',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'msg' => 'Red Wi-Fi guardada con éxito',
            'wifi' => $wifi,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function mostrar($id)
    {
        $wifi = Wifi::find($id);

        if (!$wifi) {
            $data = [
                'msg' => 'La red Wi-Fi no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'msg' => 'true',
            'wifi' => $wifi,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function actualizar($id, Request $request)
    {
        $wifi = Wifi::find($id);
        if (!$wifi) {
            $data = [
                'msg' => 'La red Wi-Fi no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'ssid' => 'sometimes|required|string|max:255',
            'contrasena' => 'sometimes|required|string|max:255',
            'piso' => 'sometimes|required|integer',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $wifi->update($request->all());

        $data = [
            'msg' => 'Red Wi-Fi actualizada con éxito',
            'wifi' => $wifi,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function eliminar($id)
    {
        $wifi = Wifi::find($id);
        if (!$wifi) {
            $data = [
                'msg' => 'La red Wi-Fi no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $wifi->delete();
        $data = [
            'msg' => 'Red Wi-Fi eliminada con éxito',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
