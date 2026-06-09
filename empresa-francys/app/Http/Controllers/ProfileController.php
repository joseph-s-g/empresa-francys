<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // <-- ASEGÚRATE DE QUE ESTA LÍNEA ESTÉ AQUÍ

class ProfileController extends Controller
{
    public function actualizar(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Buscamos directamente en el modelo User usando el ID del usuario logueado
        $user = User::find(Auth::id()); 
        
        if ($user) {
            $user->name = $request->name;
            $user->save(); // Ahora sí reconocerá el método save sin problema

            return response()->json([
                'success' => true,
                'message' => 'Perfil actualizado correctamente en la base de datos.',
                'newName' => $user->name
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Usuario no encontrado.'
        ], 404);
    }
}