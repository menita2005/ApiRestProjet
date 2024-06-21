<?php

namespace Tests\Unit;

use App\Models\Compra;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompraControllTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_get()
    {
        $response = $this->get('api/Compra');
    
        $response->assertStatus(200);

        $response->assertJsonStructure([
            ['id','user_id', 'v_compra', 'f_compra', 'proveedor_id', 'producto_id', 'c_compra', 'created_at', 'updated_at']
        ]);
        $response->assertJsonFragment(['c_compra' => 2]);
        $response->assertJsonCount(1);
    }
    public function test()
    {
        $response = $this->get('/user/559');
        $response->assertStatus(404);
    }

    public function test_show_categoria_existente()
    {

        // Realizar una solicitud GET a la ruta /api/Categoria/{id} con el ID de la categoría creada
        $response = $this->get('api/Compra/1');

        // Verificar que la solicitud fue exitosa (código 200)
        $response->assertStatus(200);

        // Verificar que la respuesta contiene la estructura esperada
        $response->assertJsonStructure([
            'compra' => [
               'id','user_id', 'v_compra', 'f_compra', 'proveedor_id', 'producto_id', 'c_compra', 'created_at', 'updated_at'],
            
        ]);

        // Verificar que la respuesta contenga los datos correctos de la categoría
        $response->assertJsonFragment([
            'id' => 1,
            'c_compra' => 2,
        ]);
    }

    public function test_show_categoria_no_existente()
{
    // Realizar una solicitud GET a la ruta /api/Categoria/100 (ID inexistente)
    $response = $this->get('/api/Compra/100');

    // Verificar que la solicitud devuelva un error 404
    $response->assertStatus(404);

    // Verificar que la respuesta contenga el mensaje y el estado esperado
    $response->assertJson([
        'message' => 'Compra no encontrada', // Ajustar el mensaje esperado
        'status' => 404,
    ]);
}
}
