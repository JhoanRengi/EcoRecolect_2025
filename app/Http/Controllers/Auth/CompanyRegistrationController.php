<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class CompanyRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'company_name'    => ['required','string','max:150'],
            'company_address' => ['required','string','max:255'],
            'company_email'   => ['required','string','lowercase','email','max:255','unique:companies,email'],
            'collect_types'   => ['required','array','min:1'],
            'collect_types.*' => ['required', Rule::in(['organicos','inorganicos_reciclables','peligrosos'])],

            'password'        => ['required','confirmed', Rules\Password::defaults()],
        ]);

        // 1) Crea el usuario "empresa" (usará su email de empresa para login)
        $user = User::create([
            'name'      => $data['company_name'],
            'email'     => $data['company_email'],
            'user_type' => 'empresa',
            'password'  => Hash::make($data['password']),
        ]);

        // 2) Crea su registro de empresa
        Company::create([
            'user_id'       => $user->id,
            'name'          => $data['company_name'],
            'address'       => $data['company_address'],
            'email'         => $data['company_email'],
            'collect_types' => $data['collect_types'],
        ]);

       
    }
}