<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = strtolower(trim(Auth::user()->role));
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'tim_oprasional') {
                return redirect()->route('tim-operasional.dashboard');
            } else {
                return redirect()->route('warga.dashboard');
            }
        }
        return back()->with('error', 'Email atau password salah!');
    }

    // Tampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:6',
            'phone_number' => 'required',
            'rt' => 'required',
            'nik' => 'required|digits:16|unique:users',
        ]);

        $fotoPath = 'img/foto-profil/default-fotoprofil.png';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'rt' => $request->rt,
            'nik' => $request->nik,
            'foto_profil' => $fotoPath,
            'role' => 'user',
        ]);

        event(new Registered($user)); // Kirim email verifikasi

        // Redirect ke login dengan alert
        return redirect()->route('auth.login-form')->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login-form');
    }

    // Tampilkan form lupa password
    public function showForgetPasswordForm()
    {
        return view('auth.forget-password');
    }

    // Proses kirim email lupa password (dummy)
    public function sendForgetPassword(Request $request)
    {
        // Implementasi pengiriman email recovery sesuai kebutuhan
        return back()->with('success', 'Kode pemulihan telah dikirim ke email Anda.');
    }

    // Tampilkan form reset password
    public function showResetPasswordForm(Request $request)
    {
        $token = $request->token ?? '';
        return view('auth.reset-password', compact('token'));
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        // Implementasi reset password sesuai kebutuhan
        return redirect()->route('auth.login-form')->with('success', 'Password berhasil direset!');
    }

    // Tampilkan form ganti password
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    // Proses ganti password
    public function changePassword(Request $request)
    {
        // Implementasi ganti password sesuai kebutuhan
        return back()->with('success', 'Password berhasil diganti!');
    }
}
