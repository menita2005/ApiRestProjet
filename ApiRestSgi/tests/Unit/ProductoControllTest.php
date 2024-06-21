<?php

namespace Tests\Unit;

use App\Models\productos;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ProductoControllTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_get()
{
    $response = $this->get('api/productos');

    $response->assertStatus(200);

    $response->assertJsonStructure([[
        'id',
        'user_id',
        'NombreP',
        'Descripcion',
        'Precio',
        'stock',
        'categoria_id',
        'proveedor_id',
        'status',
        'created_at',
        'updated_at'
]]);

    $response->assertJsonFragment(['NombreP' => 'zanahoria ']);
    $response->assertJsonCount(1);
}
public function test()
    {
        $response = $this->get('/user/559');
        $response->assertStatus(404);
    }
    public function test_show_producto_existente()
    {
        // Realizar una solicitud GET a la ruta /api/productos/{id} con el ID del producto existente
        $response = $this->get('api/productos/1');
       
    
        // Verificar que la solicitud fue exitosa (código 200)
        $response->assertStatus(200);
    
        // Verificar que la respuesta contiene la estructura esperada del producto
        $response->assertJsonStructure([
            'Producto' => [
                'id',
                'user_id',
                'NombreP',
                'Descripcion',
                'Precio',
                'stock',
                'categoria_id',
                'proveedor_id',
                'status',
                'created_at',
                'updated_at',
                'categoria' => [
                    'id',
                    'user_id',
                    'Nombre',
                    'status',
                    'created_at',
                    'updated_at',
                ],
                'proveedor' => [
                    'id',
                    'user_id',
                    'nombre',
                    'telefono',
                    'direccion',
                    'correo',
                    'status',
                    'created_at',
                    'updated_at',
                ]
            ],
            'status'
        ]);
    
        // Verificar que la respuesta contenga los datos correctos del producto
        $response->assertJsonFragment([
            'categoria_id' => 1,
            'NombreP' => 'zanahoria ',
        ]);
    }
   public function test_show_categoria_no_existente()
{
    // Realizar una solicitud GET a la ruta /api/Categoria/100 (ID inexistente)
    $response = $this->get('api/productos/100');

    // Verificar que la solicitud devuelva un error 404
    $response->assertStatus(404);

    // Verificar que la respuesta contenga el mensaje y el estado esperado
    $response->assertJson([
        'message' => 'Error al buscar el producto',
        'status' => 404,
    ]);
}



}
