<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTablesExceptUsers extends Migration
{
    public function up()
    {
        // Crear la tabla `categorias`
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('Nombre');
            $table->timestamps();
        });

        // Crear la tabla `proveedores`
        Schema::create('proveedors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->string('telefono', 15);
            $table->string('direccion');
            $table->string('correo')->unique();
            $table->timestamps();
        });

        // Crear la tabla `productos`
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('NombreP');
            $table->text('Descripcion');
            $table->decimal('Precio', 10, 2);
            $table->integer('stock');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->foreignId('proveedor_id')->constrained('proveedors')->onDelete('cascade');
            $table->timestamps();
        });

        // Crear la tabla `ventas`
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('v_venta', 10, 2);
            $table->date('f_venta');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->integer('c_compra');
            $table->timestamps();
        });

        // Crear la tabla `compras`
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('v_compra', 10, 2);
            $table->date('f_compra');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->integer('c_compra');
            $table->timestamps();
        });

        // Crear la tabla `informes`
        Schema::create('informes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->text('descripcion');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('informes');
        Schema::dropIfExists('compras');
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('proveedors');
        Schema::dropIfExists('categorias');
    }
}
