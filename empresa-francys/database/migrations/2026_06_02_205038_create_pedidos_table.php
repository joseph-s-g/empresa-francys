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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            // Conecta con el cliente que hace la compra (ID de la tabla users)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            // Conecta con el domiciliario asignado. Puede ser NULL al inicio mientras se prepara el pedido.
            $table->foreignId('domiciliario_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->string('direccion_entrega');
            $table->string('metodo_pago');
            
            // Estado del pedido: 'Recibido', 'Preparado', 'En camino', 'Entregado'
            $table->string('estado')->default('Recibido'); 
            
            $table->integer('total'); // Monto total de la factura
            
            // Aquí guardamos los productos comprados, cantidades y precios en formato JSON o Texto Largo
            $table->text('detalles_productos'); 
            
            $table->timestamp('fecha_entrega')->nullable();
            $table->timestamps(); // Crea created_at (Fecha de compra) y updated_at automáticamente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};