<?php

namespace Tests\Unit;

use App\Models\Ventas;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VentaControllTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_get()
    {
        $response = $this->get('api/Ventas'); 
        
        $response->assertStatus(200);

        $response->assertJsonStructure([
            ['id','user_id', 'v_venta', 'f_venta', 'producto_id', 'c_compra', 'created_at', 'updated_at' ]
        ]);
        $response->assertJsonFragment(['c_compra' => 2 ]);
        $response->assertJsonCount(1);
    }

    public function test()
    {
        $response = $this->get('/user/559');
        $response->assertStatus(404);
    }

    public function test_show_categoria_existente()
    {
        // Realizar una solicitud GET a la ruta /api/Ventas/{id} con el ID de la venta existente
        $response = $this->get('/api/Ventas/1');
    
        // Verificar que la solicitud fue exitosa (código 200)
        $response->assertStatus(200);
    
        // Verificar que la respuesta contiene la estructura esperada de la venta y el producto
        $response->assertJsonStructure([
            'status',
            'venta' => [
                'id',
                'user_id',
                'v_venta',
                'f_venta',
                'producto_id',
                'c_compra',
                'created_at',
                'updated_at',
                'producto' => [
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
                ],
            ],
        ]);
    
        // Verificar que la respuesta contenga los datos correctos de la venta 
        $response->assertJsonFragment([
            
                'id' => 1,
                'c_compra' => 2,
            
        ]);
    }

    public function test_show_categoria_no_existente()
    {
        // Realizar una solicitud GET a la ruta /api/ventas/100 (ID inexistente)
        $response = $this->get('api/Ventas/100');
    
        // Verificar que la solicitud devuelva un error 404
        $response->assertStatus(404);
    
        // Verificar que la respuesta contenga el mensaje y el estado esperado
        $response->assertJson([
            'message' => 'Error al buscar la venta',
            'status' => 404,
        ]);
    }
    
    
    
    
    

    
}
