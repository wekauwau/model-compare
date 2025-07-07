<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validate form input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Attempt login (Laravel will check hashed password)
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect based on user type
            if ($user->type === 'admin') {
                return redirect()->route('dashboard-admin');
            } elseif ($user->type === 'user') {
                return redirect()->route('dashboard-user');
            }

            // If type is neither admin nor user
            Auth::logout();
            return back()->withErrors(['username' => 'Tipe user tidak valid.']);
        }

        // If login fails
        return back()->withErrors(['username' => 'Username atau password salah.'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
