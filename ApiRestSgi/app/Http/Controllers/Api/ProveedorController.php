<?php

namespace App\Http\Controllers\Api;
use App\Models\Proveedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class ProveedorController 
{

    public function index(){

        $proveedores = Proveedor::all();

        if ($proveedores->isEmpty()) {
            return response()->json(['message' =>'No hay proveedores '],404);
            # code...
        }
        else
        return  response()->json($proveedores, 200);
    }

    // public function create(){
    //     return view('proveedors.create');
    // }
    public function store(request $request){

        $validator = validator::make($request->all(),[        
            'Nombre' => 'required',
            'telefono'  => 'required',
            'Direccion' => 'required',
            'Correo' => 'required|email'
        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'error'  => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data,400);
        }

        $proveedor = proveedor::create([
            'id' => $request->id,
            'user_id' => $request->user_id,
            'Nombre'=> $request->Nombre,
            'telefono'=> $request->telefono,
            'Direccion'=> $request->Direccion,
            'Correo'=> $request->Correo
        ]);

        if (!$proveedor){
            $data = [
                'message' => 'error al crear el proveedor ',
                'status' => '500'
            ];
            return response ()->json ($data,500);

        }

        $data = [
            'proveedor' => $proveedor,
            'status' => 201
        ];

        return response()->json($data,201);
    }

    public function Show($id){

        $proveedor = proveedor::find($id);

        if(!$proveedor){
            $data = [
                'message' => 'error al Buscar el proveedor ',
                'status' => '404'
            ];
            return response()->json($data,404);
        }
        $data = [
            'proveedor' => $proveedor,
            'status' => 201
        ];

        return response()->json($data,200);


    }
    public function destroy($id){
        $proveedor = proveedor::find($id);

        if(!$proveedor){
            $data = [
                'message' => 'error al Buscar el proveedor ',
                'status' => '404'
            ];
            return response()->json($data,404);
        }
        $proveedor->delete();
        $data = [
            'message' => 'eliminado',
            'status' => 201
        ];
        return response()->json($data,200);

    }
    public function update(Request $request,$id ){
        $proveedor = Proveedor::find($id);

        if(!$proveedor){
            $data = [
                'message' => 'error al Buscar el proveedor ',
                'status' => '404'
            ];
            return response()->json($data,404);
        }
        $validator = validator::make($request->all(),[

            'Nombre' => 'required',
            'telefono'  => 'required',
            'Direccion' => 'required',
            'Correo' => 'required'
        ]);
        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'error'  => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data,400);
        }
        $proveedor->Nombre= $request->Nombre;
        $proveedor->telefono= $request->telefono;
        $proveedor->Direccion= $request->Direccion;
        $proveedor->Correo= $request->Correo;
        $proveedor->save();
        $data = [
            'message' => 'actualizado',
            'proveedor' => $proveedor,
            'status' => 201
        ];
        return response()->json($data,200);
    }

}
