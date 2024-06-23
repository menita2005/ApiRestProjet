<?php

namespace App\Http\Controllers\Api;
use App\Models\Categoria;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    public function index(){

        $categorias = Categoria::all();

        if ($categorias->isEmpty()) {
            return response()->json(['message' =>'No hay categorias '],404);
            # code...
        }
        else
        return  response()->json($categorias, 200);
    }

    // public function create(){
    //     return view('categorias.create');
    // }
    public function store(request $request){
        
        $validator = validator::make($request->all(),[
            'Nombre' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'error'  => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data,400);
        }        

        $userId = auth()->id() !== null ? auth()->id() : $request->user_id;

        $categoria = Categoria::create([
            'id'=> $request->id,
            'user_id'=> $userId,
            'Nombre'=> $request->Nombre
        ]);        

        if (!$categoria){
            $data = [
                'message' => 'error al crear el categoria ',
                'status' => '500'
            ];
            return response ()->json ($data,500);

        }
        $data = [
            'categoria' => $categoria,
            'status' => 201
        ];

        return response()->json($data,201);
    }

    public function Show($id){

        $categoria = Categoria::find($id);

        if(!$categoria){
            $data = [
                'message' => 'error al Buscar el categoria ',
                'status' => '404'
            ];
            return response()->json($data,404);
        }
        $data = [
            'categoria' => $categoria,
            'status' => 201
        ];

        return response()->json($data,200);


    }
    public function destroy($id){
        $categoria = Categoria::find($id);

        if(!$categoria){
            $data = [
                'message' => 'error al Buscar el categoria ',
                'status' => '404'
            ];
            return response()->json($data,404);
        }
        $categoria->delete();
        $data = [
            'message' => 'eliminado',
            'status' => 201
        ];
        return response()->json($data,200);

    }
    public function update(Request $request,$id ){
        $categoria = Categoria::find($id);

        if(!$categoria){
            $data = [
                'message' => 'error al Buscar el categoria ',
                'status' => '404'
            ];
            return response()->json($data,404);
        }
        $validator = validator::make($request->all(),[

            'Nombre' => 'required'
        ]);
        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'error'  => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data,400);
        }
        $categoria->Nombre= $request->Nombre;
        $categoria->save();
        $data = [
            'message' => 'actualizado',
            'categoria' => $categoria,
            'status' => 201
        ];
        return response()->json($data,200);
    }

}
