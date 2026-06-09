<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\DomiciliarioController;

// ================= RUTAS PÚBLICAS =================
Route::get('/', [AuthController::class, 'index'])->name('index');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================= RUTAS PROTEGIDAS =================
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // ---------------- CLIENTE ----------------
    Route::get('/cliente/dashboard', function () {
        $productos = DB::table('productos')->where('stock', '>', 0)->get();
        return view('dashboard.cliente', compact('productos'));
    })->name('cliente.dashboard');

    // ---------------- ADMINISTRADOR ----------------
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/users/store', [AdminController::class, 'storeUsuario'])->name('admin.users.store');
    
    // CRUD Usuarios (NUEVAS RUTAS AÑADIDAS)
    Route::patch('/admin/users/{id}/toggle', [AdminController::class, 'toggleUsuario'])->name('admin.users.toggle');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUsuario'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUsuario'])->name('admin.users.destroy');
    
    // Productos (Admin)
    Route::post('/admin/productos', [AdminController::class, 'storeProducto'])->name('admin.productos.store');
    Route::put('/admin/productos/{id}', [AdminController::class, 'updateProducto'])->name('admin.productos.update');
    Route::delete('/admin/productos/{id}', [AdminController::class, 'destroyProducto'])->name('admin.productos.destroy');

    // ---------------- VENDEDOR ----------------
    Route::get('/vendedor/dashboard', [VendedorController::class, 'index'])->name('vendedor.dashboard');
    Route::post('/vendedor/productos', [VendedorController::class, 'store'])->name('vendedor.productos.store');
    Route::patch('/vendedor/pedidos/{id}/preparar', [VendedorController::class, 'marcarComoPreparado'])->name('vendedor.pedidos.preparar');
    Route::post('/vendedor/pedido/{id}/aprobar', [VendedorController::class, 'aprobarVenta'])->name('vendedor.pedido.aprobar');

    // ---------------- DOMICILIARIO ----------------
    Route::get('/domiciliario/dashboard', [DomiciliarioController::class, 'index'])->name('domiciliario.dashboard');

});