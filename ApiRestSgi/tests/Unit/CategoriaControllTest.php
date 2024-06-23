<?php

namespace Tests\Unit;

use App\Models\Categoria;
use App\Models\User;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriaControllTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
    /**
     * A basic unit test example.
     */
    public function test_integration()
    {
        $Category = [
            'id' => 1000,
            'user_id' => 1,
            'Nombre' => 'papas',        
        ];
        $response = $this->postJson('/api/Categoria',$Category);

        $response->assertStatus(201);

        $Category = [
            'id' => 1000,  
            'user_id' => 1,          
            'Nombre' => 'patatas'
        ];
        $response = $this->putJson('/api/Categoria/1000',$Category);

        $response->assertStatus(200);

        
        $response = $this->delete('/api/Categoria/1000');

        $response->assertStatus(200);
    }
    
    public function test_unit_NameRequired()
    {
        $Category = [ ];
        $response = $this->postJson('/api/Categoria',$Category);

        $response->assertStatus(400);
    }

    public function test_integration_Duplicated()
    {
        $Category = [
            'id' => 1000,
            'user_id' => 1,
            'Nombre' => 'papas',        
        ];
        $response = $this->postJson('/api/Categoria',$Category);

        $response->assertStatus(201);

        $Category = [
            'id' => 1000,
            'user_id' => 1,
            'Nombre' => 'papas',        
        ];
        $response = $this->postJson('/api/Categoria',$Category);

        $response->assertStatus(500);

        $response = $this->delete('/api/Categoria/1000');

        $response->assertStatus(200);
    }

    /*public function test_integration_Duplicated()
    {
        // Crear el mock para Categoria
        $categoriaMock = Mockery::mock(Categoria::class);

        // Configurar el mock para devolver una categoría simulada al llamar a create
        $categoriaMock->shouldReceive('create')
                  ->once()
                  ->with([
                      'id' => 1000,
                      'Nombre' => 'papas',
                      'user_id' => 1,
                  ])
                  ->andReturn((object)['id' => 1000, 'Nombre' => 'papas', 'user_id' => 1]);

        // Reemplazar la instancia del modelo en el contenedor de Laravel
        $this->app->instance(Categoria::class, $categoriaMock);

        // Enviar una solicitud POST para crear la categoría
        $response = $this->postJson('/api/Categoria', [
            'Nombre' => 'papas',
            'user_id' => 1,
            'id' => 1000
        ]);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(201);
    }*/
            
}
