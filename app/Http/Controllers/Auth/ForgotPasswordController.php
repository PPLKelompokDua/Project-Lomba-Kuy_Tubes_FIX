<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.forgot.request');
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email not founded.']);
        }

        // Simulasi kirim kode (anggap saja dikirim)
        session(['reset_email' => $request->email]);

        return redirect()->route('password.verify');
    }

    public function showVerifyForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.forgot.verify');
    }

    public function verifyCode(Request $request)
    {
        // Karena pura-pura selalu benar
        return redirect()->route('password.reset.form');
    }

    public function showResetForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.forgot.reset');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('email', session('reset_email'))->first();

        if (!$user) {
            return redirect()->route('password.request')->withErrors(['email' => 'Email Not valid.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget('reset_email');

        return redirect()->route('login')->with('success', 'Password successfully changed. Please Log In Again.');
    }
}
