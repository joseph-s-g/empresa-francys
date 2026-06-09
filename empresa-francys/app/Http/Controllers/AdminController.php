<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index() 
    {
        $usuarios = User::all();
        $productos = Producto::all();
        return view('dashboard.admin', compact('usuarios', 'productos'));
    }

    public function toggleUsuario($id) 
    {
        $user = User::findOrFail($id);
        $user->activo = !$user->activo;
        $user->save();
        return back()->with('success', 'Estado  cambiado.');
    }

    public function storeProducto(Request $request) 
    {
        Producto::create($request->all());
        return back()->with('success', 'Producto creado.');
    }

    public function updateProducto(Request $request, $id) 
    {
        Producto::findOrFail($id)->update($request->all());
        return back()->with('success', 'Producto actualizado.');
    }

    public function destroyProducto($id) 
    {
        Producto::destroy($id);
        return back()->with('success', 'Producto eliminado.');
    }
    public function updateUsuario(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$id,
    ]);

    $user = User::findOrFail($id);
    $user->update($request->only(['name', 'email']));

    return back()->with('success', 'Usuario actualizado correctamente.');
}
// En app/Http/Controllers/AuthController.php
public function register(Request $request) 
{
    // ... tu lógica de creación de usuario ...
    
    // Al final, asegúrate de tener esto:
    return back()->with('success', 'Usuario creado exitosamente.');
}
}