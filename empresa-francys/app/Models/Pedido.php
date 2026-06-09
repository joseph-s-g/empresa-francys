<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'user_id', 
        'direccion_entrega', 
        'metodo_pago', 
        'estado', 
        'domiciliario_id', 
        'total'
    ];

    /**
     * Usamos la ruta completa \Illuminate\Database\Eloquent\Relations\BelongsTo
     * para evitar el error de "undefined type"
     */
    public function cliente(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Usamos la ruta completa \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\PedidoProducto::class, 'pedido_id');
    }
}