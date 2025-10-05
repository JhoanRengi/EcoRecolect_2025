<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function store(Request $request) // ¡Aquí está corregido!
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'asunto' => 'nullable|string|max:255',
            'mensaje' => 'required|string',
        ]);

        Contacto::create($validated);

        return redirect()->back()->with('success', 'Mensaje enviado correctamente.');
    }
}