<?php
namespace App\Http\Controllers\Api;

use App\Models\Venta;
use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('producto')->get();

        if ($ventas->isEmpty()) {
            return response()->json(['message' => 'No hay ventas'], 404);
        }

        return response()->json($ventas, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'producto_id' => 'required|exists:productos,id',
            'c_compra' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'error' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        $producto = Producto::find($request->producto_id);
        $cantidadVenta = $request->c_compra;
        $cantidadDisponible = $producto->stock;

        if ($cantidadVenta > $cantidadDisponible) {
            return response()->json([
                'message' => 'No hay suficientes productos en stock para realizar la venta',
                'status' => 400,
            ], 400);
        }

        $valorVenta = $producto->Precio * $cantidadVenta;

        // Obtener el ID del usuario autenticado
        $userId = auth()->id() !== null ? auth()->id() : $request->user_id; 

        // Realizar la venta
        $venta = Venta::create([
            'id' => $request->id,
            'user_id' => $userId,
            'v_venta' => $valorVenta,
            'f_venta' => Carbon::now(),
            'producto_id' => $request->producto_id,
            'c_compra' => $cantidadVenta,
        ]);

        if (!$venta) {
            return response()->json([
                'message' => 'Error al crear la venta',
                'status' => 500,
            ], 500);
        }

        // Actualizar el stock del producto
        $producto->stock -= $cantidadVenta;
        $producto->save();

        $venta->load('producto');

        return response()->json([
            'venta' => $venta,
            'status' => 201,
        ], 201);
    }

    public function show($id)
    {
        $venta = Venta::with('producto')->find($id);

        if (!$venta) {
            return response()->json([
                'message' => 'Error al buscar la venta',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'venta' => $venta,
            'status' => 200,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return response()->json([
                'message' => 'Error al buscar la venta',
                'status' => 404,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'producto_id' => 'required|exists:productos,id',
            'c_compra' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'error' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        $producto = Producto::find($request->producto_id);
        $cantidadVenta = $request->c_compra;
        $cantidadDisponible = $producto->stock;

        // Si la cantidad de la venta es mayor que la disponible,
        // y no es la misma venta que la actual, devuelve un error.
        if ($cantidadVenta > $cantidadDisponible && $venta->c_compra !== $cantidadVenta) {
            return response()->json([
                'message' => 'No hay suficientes productos en stock para realizar la venta',
                'status' => 400,
            ], 400);
        }

        $valorVenta = $producto->Precio * $cantidadVenta;

        $venta->update([
            'v_venta' => $valorVenta,
            'f_venta' => Carbon::now(),
            'producto_id' => $request->producto_id,
            'c_compra' => $cantidadVenta,
        ]);

        // Actualizar el stock del producto
        $producto->stock += $venta->c_compra; // Añadir la cantidad anterior al stock
        $producto->stock -= $cantidadVenta; // Restar la nueva cantidad del stock
        $producto->save();

        $venta->load('producto');

        return response()->json([
            'message' => 'Venta actualizada',
            'venta' => $venta,
            'status' => 200,
        ], 200);
    }

    public function destroy($id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return response()->json([
                'message' => 'Error al buscar la venta',
                'status' => 404,
            ], 404);
        }

        // Restaurar la cantidad de productos vendidos al stock
        $producto = Producto::find($venta->producto_id);
        $producto->stock += $venta->c_compra;
        $producto->save();

        $venta->delete();

        return response()->json([
            'message' => 'Venta eliminada',
            'status' => 200,
        ], 200);
    }
}
