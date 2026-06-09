<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    /**
     * Campos que se pueden asignar masivamente.
     * He añadido 'categoria' para que el controlador pueda guardarlo.
     */
    protected $fillable = [
        'nombre', 
        'precio', 
        'stock', 
        'descripcion', 
        'categoria' // <--- ESTO ES LO QUE FALTABA
    ];

    /**
     * Relación: Un producto puede estar en muchos detalles de pedidos.
     */
    public function detallesPedido(): HasMany
    {
        return $this->hasMany(PedidoProducto::class, 'producto_id');
    }
}