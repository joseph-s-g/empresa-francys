<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Muestra la página principal (Index) con los formularios
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('index');
    }

    // Procesa el Registro de Usuarios
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'rol' => 'required|in:admin,vendedor,cliente,domiciliario',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'activo' => true // Agregado para el control de inhabilitación del SENA
        ]);

        return redirect()->route('index')->with('success', 'Registro exitoso. Ya puedes iniciar sesión.');
    }

    // Procesa el Inicio de Sesión
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // REGLA DE NEGOCIO: Si el usuario fue inhabilitado por el Admin, no dejarlo entrar
            if (!Auth::user()->activo) {
                Auth::logout();
                return back()->withErrors(['email' => 'Esta cuenta se encuentra inhabilitada por la administración.']);
            }

            $request->session()->regenerate();
            return redirect()->route('dashboard'); 
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    // CORREGIDO: Redirige a las rutas correspondientes para que se carguen los datos de la BD
    public function dashboard()
    {
        $user = Auth::user();

        switch ($user->rol) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'vendedor':
                return redirect()->route('vendedor.dashboard');
            case 'domiciliario':
                return redirect()->route('domiciliario.dashboard'); // Lo dejaremos listo para el siguiente paso
            case 'cliente':
            default:
                return redirect()->route('cliente.dashboard');
        }
    }

    // Cierra la sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('index');
    }

    // Procesa la EDICIÓN de un usuario antiguo
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'rol' => 'required|in:admin,vendedor,cliente,domiciliario',
        ]);

        $targetUser = User::findOrFail($id);
        $oldName = $targetUser->name;

        $targetUser->update([
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
        ]);

        return redirect()->route('dashboard')->with('success', "El usuario '{$oldName}' ha sido actualizado con éxito.");
    }

    // Procesa la ELIMINACIÓN de un usuario antiguo
    public function destroyUser($id)
    {
        $targetUser = User::findOrFail($id);
        
        if ($targetUser->id === Auth::id()) {
            return redirect()->route('dashboard')->withErrors(['error' => 'No puedes eliminar tu propia cuenta de administrador.']);
        }

        $deletedName = $targetUser->name;
        $targetUser->delete();

        return redirect()->route('dashboard')->with('success', "El usuario '{$deletedName}' ha sido eliminado correctamente.");
    }
}