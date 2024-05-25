<?php

use App\Http\Controllers\Api\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProveedorController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\VentaController;
use App\Http\Controllers\Api\CompraController;
// Producto


Route::get('/Productos', [ProductoController::class, 'index']);
Route::get('/Productos/{id}', [ProductoController::class, 'show']);
Route::post('/Productos', [ProductoController::class, 'store']);
Route::put('/Productos/{id}', [ProductoController::class, 'update']);
Route::delete('/Productos/{id}', [ProductoController::class, 'destroy']);
// Proveedor
Route::get('/Proveedors',[ProveedorController::class,'index']);
Route::get('/Proveedors/{id}',[ProveedorController::class,'show']);
Route::post('/Proveedors',[ProveedorController::class,'store']);
Route::put('/Proveedors/{id}',[ProveedorController::class,'update']);
Route::delete('/Proveedors/{id}',[ProveedorController::class,'destroy']);
// Venta
Route::get('/Ventas',[VentaController::class,'index']);
Route::get('/Ventas/{id}',[VentaController::class,'show']);
Route::post('/Ventas',[VentaController::class,'store']);
Route::put('/Ventas/{id}',[VentaController::class,'update']);
Route::delete('/Ventas/{id}',[VentaController::class,'destroy']);
// Categoria
Route::get('/Categoria',[CategoriaController::class,'index']);
Route::get('/Categoria/{id}',[CategoriaController::class,'show']);
Route::post('/Categoria',[CategoriaController::class,'store']);
Route::put('/Categoria/{id}',[CategoriaController::class,'update']);
Route::delete('/Categoria/{id}',[CategoriaController::class,'destroy']);
// Compra
Route::get('/Compra',[CompraController::class,'index']);
Route::get('/Compra/{id}',[CompraController::class,'show']);
Route::post('/Compra',[CompraController::class,'store']);
Route::put('/Compra/{id}',[CompraController::class,'update']);
Route::delete('/Compra/{id}',[CompraController::class,'destroy']);

