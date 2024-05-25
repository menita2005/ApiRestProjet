<?php

namespace App\Http\Controllers\Api;

use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function index()
    {
        // Cargar relaciones 'categoria' y 'proveedor'
        $productos = Producto::with(['categoria', 'proveedor'])->get();

        if ($productos->isEmpty()) {
            return response()->json(['message' => 'No hay productos'], 404);
        } else {
            return response()->json($productos, 200);
        }
    }

    public function store(Request $request)
    {
        // Validar los datos entrantes de la solicitud
        $validator = Validator::make($request->all(), [
            'NombreP' => 'required|string|max:255',
            'Descripcion' => 'required|string',
            'Precio' => 'required|integer',
            'stock' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'required|exists:proveedores,id'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'error' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        // Crear el nuevo producto usando los datos validados
        $producto = Producto::create($validator->validated());

        if (!$producto) {
            $data = [
                'message' => 'Error al crear el producto',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        // Cargar las relaciones 'categoria' y 'proveedor' en el producto creado
        $producto->load(['categoria', 'proveedor']);

        $data = [
            'producto' => $producto,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function show($id)
    {
        // Buscar el producto por ID y cargar relaciones
        $producto = Producto::with(['categoria', 'proveedor'])->find($id);

        if (!$producto) {
            $data = [
                'message' => 'Error al buscar el producto',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'Producto' => $producto,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        // Buscar el producto por ID
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'message' => 'Error al buscar el producto',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $producto->delete();
        $data = [
            'message' => 'Producto eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        // Buscar el producto por ID
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'message' => 'Error al buscar el producto',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        // Validar los datos entrantes de la solicitud
        $validator = Validator::make($request->all(), [
            'NombreP' => 'required|string|max:255',
            'Descripcion' => 'required|string',
            'Precio' => 'required|integer',
            'stock' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'required|exists:proveedores,id'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'error' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        // Actualizar los datos del producto
        $producto->update($validator->validated());

        // Cargar las relaciones 'categoria' y 'proveedor' en el producto actualizado
        $producto->load(['categoria', 'proveedor']);

        $data = [
            'message' => 'Producto actualizado',
            'Producto' => $producto,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}

