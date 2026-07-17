<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

class LoginController extends Controller
{

    public function index()
    {
        $email = request()->cookie('remember_email');
        $password = request()->cookie('remember_password');

        return view('login.index', [
            'title'    => 'login',
            'setting'  => Setting::first(),
            'email'    => $email,
            'password' => $password,
            'remember' => $email ? true : false
        ]);
    }

    public function register()
    {
        return view('login.register', [
            'title'   => 'Daftar Akun Pelamar',
            'setting' => Setting::first(),
        ]);
    }

    public function storeRegister(Request $request): RedirectResponse
    {
        $validate = $request->validate([
            'name'            => 'required',
            'email'           => 'required|email|lowercase|unique:users,email',
            'password'        => 'required|min:8',
            'passwordconfirm' => 'required|same:password',
        ], [
            'name.required'            => 'Nama wajib diisi',
            'email.required'           => 'Email wajib diisi',
            'email.email'              => 'Format email tidak valid',
            'email.unique'             => 'Email sudah terdaftar',
            'password.required'        => 'Password wajib diisi',
            'password.min'             => 'Password minimal 8 karakter',
            'passwordconfirm.required' => 'Konfirmasi password wajib diisi',
            'passwordconfirm.same'     => 'Konfirmasi password tidak cocok',
        ]);

        // Self-registration HANYA menghasilkan role pelamar — tidak ada input role dari user
        \App\Models\User::create([
            'name'              => $validate['name'],
            'email'             => $validate['email'],
            'password'          => bcrypt($validate['password']),
            'role'              => 'pelamar',
            'email_verified_at' => now(),
        ]);

        return to_route('login')->withSuccess('Pendaftaran berhasil! Silakan login.');
    }
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Save credentials to cookies if remember is checked
            if ($remember) {
                cookie()->queue('remember_email', $request->email, 60 * 24 * 30); // 30 days
                cookie()->queue('remember_password', $request->password, 60 * 24 * 30); // 30 days
            } else {
                // Clear cookies if remember is not checked
                cookie()->queue(cookie()->forget('remember_email'));
                cookie()->queue(cookie()->forget('remember_password'));
            }

            return to_route('dashboard.index')->withSuccess('Login berhasil');
        }

        return back()->withError('Login gagal email atau password tidak benar')->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->withSuccess('Logout berhasil');
    }

    public function switchUser(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        Auth::loginUsingId($request->user_id);

        return to_route('dashboard.index')->withSuccess('User berhasil diganti');
    }
}
