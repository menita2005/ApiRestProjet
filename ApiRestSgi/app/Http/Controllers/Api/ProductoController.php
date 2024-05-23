<?php

namespace App\Http\Controllers\Api;
use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{

        public function index(){

            $productos = Producto::all();

            if ($productos->isEmpty()) {
                return response()->json(['message' =>'No hay productos '],404);
                # code...
            }
            else
            return  response()->json($productos, 200);
        }

        // public function create(){
        //     return view('Productos.create');
        // }
        public function store(request $request){

            $validator = validator::make($request->all(),[

                'NombreP' => 'required',
                'Descripcion'  => 'required',
                'Precio' => 'required',
                'stock' => 'required'
            ]);
            if ($validator->fails()){
                $data = [
                    'message' => 'Error en la validacion de los datos',
                    'error'  => $validator->errors(),
                    'status' => 400
                ];

                return response()->json($data,400);
            }
            $producto = Producto::create([
                'NombreP'=> $request->NombreP,
            'Descripcion'=> $request->Descripcion,
            'Precio'=> $request->Precio,
            'stock'=> $request->stock
            ]);
            if (!$producto){
                $data = [
                    'message' => 'error al crear el Producto ',
                    'status' => '500'
                ];
                return response ()->json ($data,500);

            }
            $data = [
                'producto' => $producto,
                'status' => 201
            ];

            return response()->json($data,201);





        }

        public function Show($id){

            $producto = Producto::find($id);

            if(!$producto){
                $data = [
                    'message' => 'error al Buscar el Producto ',
                    'status' => '404'
                ];
                return response()->json($data,404);
            }
            $data = [
                'Producto' => $producto,
                'status' => 201
            ];

            return response()->json($data,200);


        }
        public function destroy($id){
            $producto = Producto::find($id);

            if(!$producto){
                $data = [
                    'message' => 'error al Buscar el Producto ',
                    'status' => '404'
                ];
                return response()->json($data,404);
            }
            $producto->delete();
            $data = [
                'message' => 'eliminado',
                'status' => 201
            ];
            return response()->json($data,200);

        }
        public function update(Request $request,$id ){
            $producto = Producto::find($id);

            if(!$producto){
                $data = [
                    'message' => 'error al Buscar el Producto ',
                    'status' => '404'
                ];
                return response()->json($data,404);
            }
            $validator = validator::make($request->all(),[

                'NombreP' => 'required',
                'Descripcion'  => 'required',
                'Precio' => 'required',
                'stock' => 'required'
            ]);
            if ($validator->fails()){
                $data = [
                    'message' => 'Error en la validacion de los datos',
                    'error'  => $validator->errors(),
                    'status' => 400
                ];

                return response()->json($data,400);
            }
            $producto->NombreP= $request->NombreP;
            $producto->Descripcion= $request->Descripcion;
            $producto->Precio= $request->Precio;
            $producto->stock= $request->stock;
            $producto->save();
            $data = [
                'message' => 'actualizado',
                'Producto' => $producto,
                'status' => 201
            ];
            return response()->json($data,200);
        }

    }

