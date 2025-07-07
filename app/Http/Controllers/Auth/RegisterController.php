<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('signup');
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'username'      => 'required|string|unique:users,username',
            'nama'          => 'required|string',
            'password'      => 'required|string|min:4|same:cpassword',
            'cpassword'     => 'required|string|min:4',
        ], [
            'username.unique' => 'Username sudah dipakai.',
            'password.same'   => 'Konfirmasi password tidak cocok.',
        ]);

        // Simpan user baru
        User::create([
            'type'     => 'user', // default type = user
            'name'     => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }
}
