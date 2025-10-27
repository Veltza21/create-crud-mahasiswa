<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('template.auth.login');
    }

   public function authenticate(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // Cek apakah input email sebenarnya adalah NIM
        $loginField = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'nim';

        // Ambil user berdasarkan NIM atau email
        $user = User::where($loginField, $credentials['email'])->first();

        if ($user && Auth::attempt([$loginField => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            if ($user->is_admin == 1) {
                return redirect()->intended('dashboard')->with('message_success', 'Berhasil Login sebagai Admin');
            }

            return redirect()->intended('dashboard')->with('message_success', 'Berhasil Login');
        }

        return back()->with('message_danger', 'Login gagal, periksa kembali Email/NIM dan Password Anda');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
