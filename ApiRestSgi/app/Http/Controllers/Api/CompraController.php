<?php

namespace App\Http\Controllers\Api;

use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CompraController extends Controller
{
    public function index()
    {
        // Obtener todas las compras con relaciones de proveedor y producto
        $compras = Compra::with(['proveedor', 'producto'])->get();

        if ($compras->isEmpty()) {
            return response()->json(['message' => 'No hay compras'], 404);
        } else {
            return response()->json($compras, 200);
        }
    }

    public function store(Request $request)
    {
        // Validar los datos entrantes de la solicitud
        $validator = Validator::make($request->all(), [
            'proveedor_id' => 'required|exists:proveedores,id',
            'producto_id' => 'required|exists:productos,id',
            'c_compra' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        // Obtener el ID del usuario autenticado
        $userId = auth()->id();

        // Obtener el producto seleccionado
        $producto = Producto::find($request->producto_id);

        if (!$producto) {
            return response()->json([
                'message' => 'Producto no encontrado',
                'status' => 404
            ], 404);
        }

        // Calcular el valor de la compra
        $valorCompra = $producto->precio * $request->c_compra;

        // Crear la nueva compra usando los datos validados y la fecha actual
        $compra = Compra::create([
            'user_id' => $userId,
            'proveedor_id' => $request->proveedor_id,
            'producto_id' => $request->producto_id,
            'c_compra' => $request->c_compra,
            'v_compra' => $valorCompra,
            'f_compra' => now(), // Fecha actual
        ]);

        if (!$compra) {
            return response()->json([
                'message' => 'Error al crear la compra',
                'status' => 500
            ], 500);
        }

        // Actualizar la cantidad del producto en la base de datos
        $producto->update([
            'stock' => $producto->stock + $request->c_compra,
        ]);

        // Cargar las relaciones de proveedor y producto en la compra creada
        $compra->load(['proveedor', 'producto']);

        return response()->json([
            'message' => 'Compra creada exitosamente',
            'compra' => $compra,
            'status' => 201
        ], 201);
    }

    public function show($id)
    {
        // Buscar la compra por ID y cargar relaciones
        $compra = Compra::with(['proveedor', 'producto'])->find($id);

        if (!$compra) {
            return response()->json([
                'message' => 'Compra no encontrada',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'compra' => $compra,
            'status' => 200
        ], 200);
    }

    public function update(Request $request, $id)
    {
        // Buscar la compra por ID
        $compra = Compra::find($id);

        if (!$compra) {
            return response()->json([
                'message' => 'Compra no encontrada',
                'status' => 404
            ], 404);
        }

        // Validar los datos entrantes de la solicitud
        $validator = Validator::make($request->all(), [
            'proveedor_id' => 'required|exists:proveedores,id',
            'producto_id' => 'required|exists:productos,id',
            'c_compra' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        // Obtener el producto seleccionado
        $producto = Producto::find($request->producto_id);

        if (!$producto) {
            return response()->json([
                'message' => 'Producto no encontrado',
                'status' => 404
            ], 404);
        }

        // Calcular la diferencia de cantidad entre la compra anterior y la actual
        $diferenciaCantidad = $request->c_compra - $compra->c_compra;

        // Actualizar los datos de la compra
        $compra->update([
            'proveedor_id' => $request->proveedor_id,
            'producto_id' => $request->producto_id,
            'c_compra' => $request->c_compra,
        ]);

        // Actualizar la cantidad del producto en la base de datos
        $producto->update([
            'stock' => $producto->stock + $diferenciaCantidad,
        ]);

        // Cargar las relaciones de proveedor y producto en la compra actualizada
        $compra->load(['proveedor', 'producto']);

        return response()->json([
            'message' => 'Compra actualizada',
            'compra' => $compra,
            'status' => 200
        ], 200);
    }

    public function destroy($id)
    {
        // Buscar la compra por ID
        $compra = Compra::find($id);

        if (!$compra) {
            return response()->json([
                'message' => 'Compra no encontrada',
                'status' => 404
            ], 404);
        }

        // Obtener el producto asociado a la compra
        $producto = Producto::find($compra->producto_id);

        if ($producto) {
            // Restar la cantidad de la compra eliminada del total del producto
            $producto->update([
                'stock' => $producto->stock - $compra->c_compra,
            ]);
        }

        $compra->delete();

        return response()->json([
            'message' => 'Compra eliminada exitosamente',
            'status' => 200
        ], 200);
    }
}
