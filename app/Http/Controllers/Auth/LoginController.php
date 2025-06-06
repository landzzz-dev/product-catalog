<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }


    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('home')->with('success', 'Welcome ' . Auth::user()->name . '!');
        }

        return back()->withErrors(['username' => 'The provided credentials do not match our records.'])->onlyInput('username');
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
