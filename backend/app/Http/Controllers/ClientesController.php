<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;

//validacion
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{
    public function index()
    {
        $clientes = Clientes::all();


        if($clientes->isEmpty()){
            $data=[
                'msg' => 'no hay clientes registrados',
                'status'=>400
            ];
            return response()->json(
                $data,400);

        }
        $data=[
            'msg'=>'true',
            'clientes' => $clientes,
           'status'=>200
        ];
        // Si hay clientes, devuelve la colección como respuesta JSON
        return response()->json(
            $data, 200);
    }


    // public function guardar(Request $request)
    // {
    //     $validator= Validator::make($request->all(),[
    //         'nombre'=>'required',
    //         'apellido'=>'required',
    //         'CI'=>'required',
    //         'direccion'=>'required'
    //     ]);
    //     if($validator->fails()){
    //         $data=[
    //             'msg' => 'Error en la validacion',
    //             'errors' => $validator->errors(),
    //             'status'=>400
    //         ];
    //         return response()->json(
    //             $data,400);
    //     }

    //     $cliente= Clientes::create([
    //         'nombre'=> $request->nombre,
    //         'apellido'=> $request->apellido,
    //         'CI'=> $request->CI,
    //         'correo'=> $request->correo,
    //         'direccion'=> $request->direccion
    //     ]);

    //     if(!$cliente){
    //         $data=[
    //             'msg' => 'Error al guardar el cliente',
    //            'status'=>500
    //         ];
    //         return response()->json(
    //             $data,500);
    //     }

    //     $data=[
    //        'msg'=>'true',
    //         'cliente' => $cliente,
    //        'status'=>201
    //     ];
    //     return response()->json($data,201);


    // }
    public function guardar(Request $request)
{
    // Validar los datos de entrada
    $validator = Validator::make($request->all(), [
        'nombre' => 'required',
        'apellido' => 'required',
        'CI' => 'required|unique:clientes,CI',  // Verifica que el CI sea único en la tabla clientes
        'direccion' => 'required'
    ]);

    // Si la validación falla, devolver errores específicos
    if ($validator->fails()) {
        // Verifica si el error es de unicidad
        $errors = $validator->errors();
        $msg = $errors->has('CI') ? 'El cliente con este CI ya existe.' : 'Error en la validación';

        $data = [
            'msg' => $msg,
            'errors' => $errors,
            'status' => 400
        ];
        return response()->json($data, 400);
    }

    // Crear el nuevo cliente
    $cliente = Clientes::create([
        'nombre' => $request->nombre,
        'apellido' => $request->apellido,
        'CI' => $request->CI,
        'correo' => $request->correo,
        'direccion' => $request->direccion
    ]);

    // Verificar si el cliente fue creado exitosamente
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
        $cliente= Clientes::find($id);

        if(!$cliente){
            $data=[
               'msg' => 'El cliente no existe',
               'status'=>404
            ];
            return response()->json(
                $data,404);
        }

        $data=[
           'msg'=>'true',
            'cliente' => $cliente,
           'status'=>200
        ];
        return response()->json($data,200);
    }

    public function actualizar($id, Request $request)
    {
        $cliente=Clientes::find($id);
        if(!$cliente){
            $data=[
               'msg' => 'El cliente no existe',
               'status'=>404
            ];
            return response()->json(
                $data,404);
        }
        $validator= Validator::make($request->all(),[
            'nombre'=>'required',
            'apellido'=>'required',
            'CI'=>'required',
            'direccion'=>'required'
        ]);
        if($validator->fails()){
            $data=[
                'msg' => 'Error en la validacion',
                'errors' => $validator->errors(),
               'status'=>400
            ];
            return response()->json(
                $data,400);
        }
        $cliente->nombre=$request->nombre;
        $cliente->apellido=$request->apellido;
        $cliente->CI=$request->CI;
        $cliente->correo=$request->correo;
        $cliente->direccion=$request->direccion;

        $cliente->save();
        $data=[
           'msg'=>'true',
            'cliente' => $cliente,
           'status'=>200
        ];
        return response()->json($data,200);


    }
    public function eliminar($id)
    {
        $cliente=Clientes::find($id);
        if(!$cliente){
            $data=[
               'msg' => 'El cliente no existe',
               'status'=>404
            ];
            return response()->json(
                $data,404);
        }
        $cliente->delete();
        $data=[
           'msg'=>'true',
           'status'=>200
        ];
        return response()->json($data,200);
    }
}


