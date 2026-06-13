<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Redirect default (tetap biarkan, tapi akan kita timpa di bawah).
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Buat instance controller baru.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validasi data registrasi.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Simpan user baru ke database.
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * INI BAGIAN PENTING: Menimpa alur setelah registrasi berhasil.
     */
    protected function registered(Request $request, $user)
    {
        // 1. Logout otomatis user yang baru terdaftar
        Auth::logout();

        // 2. Arahkan ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi XPloreJogja berhasil! Silakan login untuk masuk.');
    }
}