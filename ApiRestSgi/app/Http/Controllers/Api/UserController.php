<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){

        $user = User::all();

        if ($user->isEmpty()) {
            return response()->json(['message' =>'No hay usuarios '],404);
            # code...
        }
        else
        return  response()->json($user, 200);
    }


    public function login(request $request){

        $validator = validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required'
        ]);
        
        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'error'  => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data,400);
        }

        
        
        $user = User::where([
                ['email', '=', $request->email],
                ['password', '=', $request->password]
            ])
        ->first();
        
                
        if (!$user){
            $data = [
                'message' => 'Usuario incorrecto',
                'status' => '500'
            ];
            return response ()->json ($data,500);

        }
        $data = [
            'user' => $user,
            'status' => 200
        ];

        return response()->json($data,200);
    }    
}
