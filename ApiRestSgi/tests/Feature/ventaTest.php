<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ventaTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_integration()
    {
        $Category = [
            'id' => 1000,
            'user_id' => 1,
            'v_venta' => 1000,        
            'f_venta' => '2002/01/01',
            'producto_id' => 1,
            'c_compra' => 10,
        ];
        $response = $this->postJson('/api/Ventas',$Category);

        $response->assertStatus(201);

        $Category = [
            'id' => 1000,
            'user_id' => 1,
            'v_venta' => 10000,        
            'f_venta' => '2002/01/01',
            'producto_id' => 1,
            'c_compra' => 10,
        ];
        $response = $this->putJson('/api/Ventas/1000',$Category);

        $response->assertStatus(200);

        
        $response = $this->delete('/api/Ventas/1000');

        $response->assertStatus(200);
    }
    
    public function test_unit_NameRequired()
    {
        $Category = [ ];
        $response = $this->postJson('/api/Ventas',$Category);

        $response->assertStatus(400);
    }

    public function test_integration_Duplicated()
    {
        $Category = [
            'id' => 1000,
            'user_id' => 1,
            'v_venta' => 1000,        
            'f_venta' => '2002/01/01',
            'producto_id' => 1,
            'c_compra' => 10,      
        ];
        $response = $this->postJson('/api/Ventas',$Category);

        $response->assertStatus(201);

        $Category = [
            'id' => 1000,
            'user_id' => 1,
            'v_venta' => 1000,        
            'f_venta' => '2002/01/01',
            'producto_id' => 1,
            'c_compra' => 10,       
        ];
        $response = $this->postJson('/api/Ventas',$Category);

        $response->assertStatus(500);

        $response = $this->delete('/api/Ventas/1000');

        $response->assertStatus(200);
    }
}
