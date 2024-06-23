<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProveedorsTest extends TestCase
{
    public function test_integration()
    {                        
        $Proveedors = [
            'id' => 1000,
            'user_id' => 1,
            'Nombre' => "proveedor prueba",
            'telefono' => '757575', 
            'Direccion' => 'cl 1 # 32 - 32', 
            'Correo' => "prueba@prueba.com"       
        ];        
        $response = $this->postJson('/api/Proveedors',$Proveedors);        
        $response->assertStatus(201);

        $Proveedors = [
            'id' => 1000,
            'user_id' => 1,
            'Nombre' => "proveedor prueba update",
            'telefono' => '757575', 
            'Direccion' => 'cl 1 # 32 - 32', 
            'Correo' => "prueba@prueba.com"            
        ];        
        $response = $this->putJson('/api/Proveedors/1000',$Proveedors);
        $response->assertStatus(200);

        
        $response = $this->delete('/api/Proveedors/1000');
        $response->assertStatus(200);
    }

    public function test_unit_NameRequired()
    {
        $Proveedors = [ ];
        $response = $this->postJson('/api/Proveedors',$Proveedors);

        $response->assertStatus(400);
    }

    public function test_integration_Duplicated()
    {
        $Proveedors = [
            'id' => 1000,
            'user_id' => 1,
            'Nombre' => "proveedor prueba",
            'telefono' => '757575', 
            'Direccion' => 'cl 1 # 32 - 32', 
            'Correo' => "prueba@prueba.com"          
        ];

        $response = $this->postJson('/api/Proveedors',$Proveedors);

        $response->assertStatus(201);

        $Proveedors = [
            'id' => 1000,
            'user_id' => 1,
            'Nombre' => "proveedor prueba",
            'telefono' => '757575', 
            'Direccion' => 'cl 1 # 32 - 32', 
            'Correo' => "prueba@prueba.com"        
        ];

        $response = $this->postJson('/api/Proveedors',$Proveedors);        

        $response->assertStatus(500);

        $response = $this->delete('/api/Proveedors/1000');

        $response->assertStatus(200);
    }  
}
