<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendedorController extends Controller
{
    // 1. Mostrar pedidos pendientes para el vendedor
 public function index()
    {
        // 1. Pedidos para la tabla "Órdenes" (usando el nombre que espera la vista)
        $pedidosParaPreparar = Pedido::where('estado', 'pendiente')
                                    ->with('cliente', 'detalles.producto')
                                    ->get();

        // 2. Traer todos los productos para la tabla "Stock"
        $productos = Producto::all();

        // 3. Pasamos ambas variables a la vista
        return view('dashboard.vendedor', compact('pedidosParaPreparar', 'productos'));
    }

    // 2. Lógica real de aprobación y descuento de stock
    public function aprobarVenta($id)
    {
        $pedido = Pedido::with('detalles')->findOrFail($id);

        if ($pedido->estado !== 'pendiente') {
            return back()->with('error', 'Este pedido ya fue procesado.');
        }

        foreach ($pedido->detalles as $item) {
            $producto = Producto::find($item->producto_id);
            if (!$producto || $producto->stock < $item->cantidad) {
                return back()->with('error', "Stock insuficiente para: " . ($producto ? $producto->nombre : 'Producto desconocido'));
            }
        }

        foreach ($pedido->detalles as $item) {
            $producto = Producto::find($item->producto_id);
            $producto->decrement('stock', $item->cantidad);
        }

        $pedido->estado = 'aprobado';
        $pedido->save();

        return back()->with('success', 'Venta aprobada y stock actualizado exitosamente.');
    }
    
    // 3. Método para guardar un producto nuevo (Corregido y Robusto)
    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'precio'    => 'required|numeric',
            'stock'     => 'required|integer',
            'categoria' => 'nullable|string|max:255', // Validamos pero permitimos null
        ]);

        // Preparamos los datos
        $data = $request->all();
        
        // Asignamos valores por defecto si no vienen en el formulario
        $data['categoria'] = $request->input('categoria', 'General');
        $data['user_id']   = Auth::id(); // Asignamos el ID del vendedor autenticado

        Producto::create($data);

        return back()->with('success', 'Producto creado exitosamente.');
    }
}