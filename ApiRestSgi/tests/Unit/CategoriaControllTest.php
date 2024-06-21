<?php

namespace Tests\Unit;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriaControllTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_get()
    {
        $response = $this->get('api/Categoria');
    
        $response->assertStatus(200);

        $response->assertJsonStructure([
            ['id','Nombre', 'status', 'created_at', 'updated_at' ]
        ]);
        $response->assertJsonFragment(['Nombre' => 'Verduras']);
        $response->assertJsonCount(2);
    }
    public function test()
    {
        $response = $this->get('/user/559');
        $response->assertStatus(404);
    }

    public function test_show_categoria_existente()
    {

        // Realizar una solicitud GET a la ruta /api/Categoria/{id} con el ID de la categoría creada
        $response = $this->get('/api/Categoria/2');

        // Verificar que la solicitud fue exitosa (código 200)
        $response->assertStatus(200);

        // Verificar que la respuesta contiene la estructura esperada
        $response->assertJsonStructure([
            'categoria' => [
                'id',
                'Nombre',
                'status',
                'created_at',
                'updated_at',
            ],
            'status',
        ]);

        // Verificar que la respuesta contenga los datos correctos de la categoría
        $response->assertJsonFragment([
            'id' => 2,
            'Nombre' => 'Frutas',
        ]);
    }

    public function test_show_categoria_no_existente()
    {
        // Realizar una solicitud GET a la ruta /api/Categoria/100 (ID inexistente)
        $response = $this->get('/api/Categoria/100');

        // Verificar que la solicitud devuelva un error 404
        $response->assertStatus(404);

        // Verificar que la respuesta contenga el mensaje y el estado esperado
        $response->assertJson([
            'message' => 'error al Buscar el categoria ',
            'status' => 404,
        ]);
    }

    
    
    
    

}
