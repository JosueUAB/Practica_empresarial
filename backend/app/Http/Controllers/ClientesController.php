<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{
    public function index()
    {
        $clientes = Clientes::all();

        if($clientes->isEmpty()){
            $data = [
                'msg' => 'No hay clientes registrados',
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $data = [
            'msg' => 'true',
            'clientes' => $clientes,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function guardar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'numero_documento' => 'required|unique:clientes,numero_documento',
            'correo' => 'required|email',
            'direccion' => 'required',
            'nacionalidad' => 'required',
            'procedencia' => 'required',
            'fecha_de_nacimiento' => 'required|date',
            'estado_civil' => 'required|in:soltero,casado,divorciado,viudo',
            'telefono' => 'required',
            'tipo_de_huesped' => 'required|in:Natural,Empresa',
            'tipo_de_documento' => 'required|in:CI,pasaporte,carnet_de_extranjero,NIT',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = $errors->has('numero_documento') ? 'El cliente con este número de documento ya existe.' : 'Error en la validación';

            $data = [
                'msg' => $msg,
                'errors' => $errors,
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $cliente = Clientes::create($request->all());

        if (!$cliente) {
            $data = [
                'msg' => 'Error al guardar el cliente',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'msg' => 'Cliente guardado con éxito',
            'cliente' => $cliente,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function mostrar($id)
    {
        $cliente = Clientes::find($id);

        if (!$cliente) {
            $data = [
                'msg' => 'El cliente no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'msg' => 'true',
            'cliente' => $cliente,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function actualizar($id, Request $request)
    {
        $cliente = Clientes::find($id);
        if (!$cliente) {
            $data = [
                'msg' => 'El cliente no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'numero_documento' => 'required|unique:clientes,numero_documento,' . $id,
            'correo' => 'required|email',
            'direccion' => 'required',
            'nacionalidad' => 'required',
            'procedencia' => 'required',
            'fecha_de_nacimiento' => 'required|date',
            'estado_civil' => 'required|in:soltero,casado,divorciado,viudo',
            'telefono' => 'required',
            'tipo_de_huesped' => 'required|in:Natural,Empresa',
            'tipo_de_documento' => 'required|in:CI,pasaporte,carnet_de_extranjero,NIT',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $cliente->update($request->all());

        $data = [
            'msg' => 'Cliente actualizado con éxito',
            'cliente' => $cliente,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function eliminar($id)
    {
        $cliente = Clientes::find($id);
        if (!$cliente) {
            $data = [
                'msg' => 'El cliente no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $cliente->delete();
        $data = [
            'msg' => 'Cliente eliminado con éxito',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
