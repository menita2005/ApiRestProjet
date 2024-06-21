<?php

namespace Tests\Unit;

use App\Models\Proveedor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProveedorControllTest extends TestCase
{
    
     /**
     * A basic unit test example.
     */
    public function test_get()
    {
        $response = $this->get('api/Proveedors');
        
        $response->assertStatus(200);
    
        $response->assertJsonStructure([
            ['id', 'user_id', 'nombre', 'telefono', 'direccion', 'correo', 'status', 'created_at', 'updated_at']
        ]);
        $response->assertJsonFragment(['nombre' => 'frutiago']);
        $response->assertJsonCount(1); // Cambié a 1 porque el JSON proporcionado tiene solo un objeto
    }
    public function test()
    {
        $response = $this->get('/user/559');
        $response->assertStatus(404);
    }

    public function test_show_categoria_existente()
    {
        // Realizar una solicitud GET a la ruta /api/Categoria/{id} con el ID de la categoría creada
        $response = $this->get('api/Proveedors/1');
    
        // Verificar que la solicitud fue exitosa (código 200)
        $response->assertStatus(200);
    
        // Verificar que la respuesta contiene la estructura esperada
        $response->assertJsonStructure([
            'proveedor' => [
                'id',
                'user_id',
                'nombre',
                'telefono',
                'direccion',
                'correo',
                'status',
                'created_at',
                'updated_at'
            ],
            'status'
        ]);
    
        // Verificar que la respuesta contenga los datos correctos de la categoría
        $response->assertJsonFragment([
            'id' => 1,
            'nombre' => 'frutiago',
        ]);
    }
    public function test_show_categoria_no_existente()
{
    // Realizar una solicitud GET a la ruta /api/Proveedors/100 (ID inexistente)
    $response = $this->get('api/Proveedors/100');

    // Verificar que la solicitud devuelva un error 404
    $response->assertStatus(404);

    // Verificar que la respuesta contenga el mensaje y el estado esperado
    $response->assertJson([
        'message' => 'error al Buscar el proveedor ',
        'status' => '404',
    ]);
}



    
}
