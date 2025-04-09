<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // ✅ ADMIN HARDCODE
        if ($request->email === 'admin@lombakuy.com' && $request->password === 'admin123') {
            // Cek di database beneran ada user ini
            $admin = \App\Models\User::where('email', 'admin@lombakuy.com')->first();
        
            if (!$admin) {
                return back()->withErrors(['email' => 'Admin belum tersedia di database.']);
            }
        
            Auth::login($admin);
            return redirect()->route('admin.dashboard');
        }

        // 🧑🏻‍💼 USER / ORGANIZER dari database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'organizer') return redirect()->route('organizer.dashboard');
            return redirect()->route('dashboard'); // user biasa
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        // Keluarin manual admin
        $request->session()->forget('is_admin');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
