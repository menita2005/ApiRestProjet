<?php

namespace Tests\Unit;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriaControllTest extends TestCase
{
    
    public function test_integracion()
    {
        $Category = [
            'id' => 1000,
            'user_id' => 1,
            'Nombre' => 'papas',        
        ];
        $response = $this->postJson('/api/Categoria',$Category);

        $response->assertStatus(422);

        //$this->get('/api/Categoria');

        //$this->put('/api/Categoria');

        //$this->get('/api/Categoria');

        //$this->delete('/api/Categoria');


       
    }

    
    

}
