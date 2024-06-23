<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Compra;

class CompraTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_integration()
    {                        
        $Compra = [
            'id' => 1000,
            'user_id' => 1,
            'v_compra' => 10,
            'f_compra' => '2002/01/01', 
            'proveedor_id' => 1, 
            'producto_id' => 1, 
            'c_compra' => 10,        
        ];        
        $response = $this->postJson('/api/Compra',$Compra);        
        $response->assertStatus(201);

        $Compra = [
            'id' => 1000,
            'user_id' => 1,
            'v_compra' => 20,
            'f_compra' => '2002/01/01', 
            'proveedor_id' => 1, 
            'producto_id' => 1, 
            'c_compra' => 10,       
        ];
        $response = $this->putJson('/api/Compra/1000',$Compra);
        $response->assertStatus(200);

        
        $response = $this->delete('/api/Compra/1000');
        $response->assertStatus(200);
    }
    
    public function test_unit_NameRequired()
    {
        $Compra = [ ];
        $response = $this->postJson('/api/Compra',$Compra);

        $response->assertStatus(400);
    }

    public function test_integration_Duplicated()
    {
        $Compra = [
            'id' => 1000,
            'user_id' => 1,
            'v_compra' => 10,
            'f_compra' => '2002/01/01', 
            'proveedor_id' => 1, 
            'producto_id' => 1, 
            'c_compra' => 10,        
        ];

        $response = $this->postJson('/api/Compra',$Compra);

        $response->assertStatus(201);

        $Compra = [
            'id' => 1000,
            'user_id' => 1,
            'v_compra' => 10,
            'f_compra' => '2002/01/01', 
            'proveedor_id' => 1, 
            'producto_id' => 1, 
            'c_compra' => 10,         
        ];

        $response = $this->postJson('/api/Compra',$Compra);        

        $response->assertStatus(500);

        $response = $this->delete('/api/Compra/1000');

        $response->assertStatus(200);
    }
}
