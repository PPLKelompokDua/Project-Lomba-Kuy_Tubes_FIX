<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Menampilkan form registrasi.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Menerima data POST dari form registrasi.
     */
    public function store(Request $request)
    {
        // Validasi data dengan menyertakan field role
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // Pastikan opsi yang diizinkan sesuai kebutuhan
            'role'     => 'required|in:user,organizer,admin',
        ]);

        // Buat user baru dengan menyimpan role dari input form
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // Login otomatis user yang telah didaftarkan
        auth()->login($user);

        // Arahkan ke dashboard yang sesuai
        return redirect()->route('dashboard');
    }
}
