<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:8'],
            'user_type' => ['required', 'in:admin,cliente,recolector'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $password = $data['password'] ?? Str::password();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_type' => $data['user_type'],
            'password' => Hash::make($password),
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
        ]);

        return back()->with([
            'success' => 'Usuario creado correctamente.',
            'generated_password' => $data['password'] ? null : $password,
            'new_user_email' => $user->email,
        ]);
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta desde el panel de administración.');
        }

        $userName = $user->name;
        $user->delete();

        return back()->with('success', "Usuario {$userName} eliminado correctamente.");
    }
}
