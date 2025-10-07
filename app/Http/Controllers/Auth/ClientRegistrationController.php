<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class ClientRegistrationController extends Controller
{
    public function create()
    {
        $localities = config('localities.bogota'); // archivo config/localities.php
        return view('auth.register-cliente', compact('localities'));
    }

    public function store(Request $request)
    {
        $allowedLocalities = config('localities.bogota');

        $data = $request->validate([
            'first_name' => ['required','string','max:100'],
            'last_name'  => ['required','string','max:100'],
            'phone'      => ['required','string','max:30'],
            'email'      => ['required','string','lowercase','email','max:255','unique:users,email'],
            'address'    => ['required','string','max:255'],
            'locality'   => ['required', Rule::in($allowedLocalities)],
            'password'   => ['required','confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'      => $data['first_name'].' '.$data['last_name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'first_name'=> $data['first_name'],
            'last_name' => $data['last_name'],
            'phone'     => $data['phone'],
            'address'   => $data['address'],
            'locality'  => $data['locality'],
            'user_type' => 'cliente', // si dejaste esta columna
        ]);

        Auth::login($user);

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Tu cuenta fue creada correctamente. ¡Bienvenido a EcoRecolect!');
    }
}
