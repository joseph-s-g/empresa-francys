<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DomiciliarioController extends Controller
{
    public function index()
    {
        // Usaremos directamente auth()->user() en la vista para evitar errores de variables
        return view('dashboard.domiciliario');
    }
}