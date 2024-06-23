<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductoTest extends TestCase
{
    public function test_integration()
    {                        
        $Producto = [
            'id' => 1000,
            'user_id' => 1,
            'NombreP' => "producto prueba",
            'Descripcion' => 'Ejecucion de test', 
            'Precio' => 100000, 
            'stock' => 100, 
            'categoria_id' => 1,        
            'proveedor_id' => 1,        
        ];        
        $response = $this->postJson('/api/productos',$Producto);        
        $response->assertStatus(201);

        $Producto = [
            'id' => 1000,
            'user_id' => 1,
            'NombreP' => "producto prueba",
            'Descripcion' => 'Ejecucion de test', 
            'Precio' => 100000, 
            'stock' => 500, 
            'categoria_id' => 1,        
            'proveedor_id' => 1,         
        ];        
        $response = $this->putJson('/api/productos/1000',$Producto);
        $response->assertStatus(200);

        
        $response = $this->delete('/api/productos/1000');
        $response->assertStatus(200);
    }

    public function test_unit_NameRequired()
    {
        $Producto = [ ];
        $response = $this->postJson('/api/productos',$Producto);

        $response->assertStatus(400);
    }

    public function test_integration_Duplicated()
    {
        $Producto = [
            'id' => 1000,
            'user_id' => 1,
            'NombreP' => "producto prueba",
            'Descripcion' => 'Ejecucion de test', 
            'Precio' => 100000, 
            'stock' => 100, 
            'categoria_id' => 1,        
            'proveedor_id' => 1,        
        ];

        $response = $this->postJson('/api/productos',$Producto);

        $response->assertStatus(201);

        $Producto = [
            'id' => 1000,
            'user_id' => 1,
            'NombreP' => "producto prueba",
            'Descripcion' => 'Ejecucion de test', 
            'Precio' => 100000, 
            'stock' => 100, 
            'categoria_id' => 1,        
            'proveedor_id' => 1,      
        ];

        $response = $this->postJson('/api/productos',$Producto);        

        $response->assertStatus(500);

        $response = $this->delete('/api/productos/1000');

        $response->assertStatus(200);
    }    
}
