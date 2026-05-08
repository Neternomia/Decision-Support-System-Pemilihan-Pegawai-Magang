<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard')->with('success', 'Anda sudah login!');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);


        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard')
                ->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }
}
