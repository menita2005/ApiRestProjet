<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the 'categorias' table
        Schema::create('categorias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Nombre');
            $table->timestamps();
        });

        // Create the 'proveedores' table
        Schema::create('proveedores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('telefono');
            $table->string('direccion');
            $table->string('correo');
            $table->timestamps();
        });

        // Create the 'productos' table
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('NombreP');
            $table->text('Descripcion')->nullable();
            $table->integer('Precio');
            $table->integer('stock');
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('proveedor_id');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');
            $table->timestamps();
        });

        // Create the 'compras' table
        Schema::create('compras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('proveedor_id');
            $table->unsignedBigInteger('producto_id');
            $table->integer('v_compra');
            $table->date('f_compra');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');
            $table->timestamps();
        });

        // Create the 'ventas' table
        Schema::create('ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('v_venta');
            $table->date('f_venta');
            $table->unsignedBigInteger('producto_id');
            $table->integer('c_compra');
            $table->timestamps();
            
            // Definición de la clave foránea
            $table->foreign('producto_id')
                ->references('id')
                ->on('productos')
                ->onDelete('cascade');
        });

        // Create the 'informes' table
        Schema::create('informes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo');
            $table->date('fecha_i');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informes');
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('compras');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('proveedores');
        Schema::dropIfExists('categorias');
    }
};
