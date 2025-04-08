<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses login (admin, user, organizer).
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Admin manual login check
        if (
            $request->email === 'admin@lombakuy.com' &&
            $request->password === '12345678'
        ) {
            $request->session()->put('is_admin', true);
            return redirect()->route('admin.dashboard');
        }

        // Login untuk user biasa & organizer
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect sesuai role
            switch ($user->role) {
                case 'organizer':
                    return redirect()->route('organizer.dashboard');
                case 'user':
                default:
                    return redirect()->route('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password Anda salah.',
        ])->onlyInput('email');
    }

    /**
     * Logout (admin dan user/organizer).
     */
    public function logout(Request $request)
    {
        $request->session()->forget('is_admin');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
