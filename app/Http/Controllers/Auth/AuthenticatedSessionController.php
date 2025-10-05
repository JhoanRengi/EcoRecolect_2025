<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    
    public function create(): View
    {
        return view('auth.login');
    }

    
    public function store(Request $request)
{
    $credentials = $request->validate([
        'email'    => ['required','string','email'],
        'password' => ['required','string'],
    ]);

    if (! Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()->withErrors(['email' => __('auth.failed')])->onlyInput('email');
    }

    $request->session()->regenerate();
    
    $request->session()->forget('url.intended');

    $user = Auth::user();

    $target = $user->user_type === 'admin'
        ? route('admin.dashboard')
        : route('dashboard');

    return redirect()->to($target); 
}
    
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
