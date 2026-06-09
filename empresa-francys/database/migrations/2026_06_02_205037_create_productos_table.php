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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');               // Nombre del producto (ej: Papas Fritas)
            $table->string('categoria');            // Categoría (ej: golosinas-paquetes)
            $table->integer('precio');              // Precio en pesos colombianos (ej: 5000)
            $table->integer('stock');               // Cantidad disponible que sube el vendedor (ej: 40)
            $table->string('icono')->default('fa-box'); // Ícono estético de FontAwesome para la vista
            $table->timestamps();                   // Crea created_at y updated_at automáticamente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};