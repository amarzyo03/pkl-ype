<?php

namespace App\Http\Controllers;

use App\Models\userModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class authController extends Controller
{
    public function auth()
    {
        if (session()->has('auth_id')) {
            if (session('auth_role') === 'admin') {
                return redirect()->route('dashboard');
            } elseif (session('auth_role') === 'guru') {
                return redirect()->route('dashboard');
            } elseif (session('auth_role') === 'siswa') {
                return redirect()->route('userSiswa.dashboard');
            }
        }

        return view('auth');
    }

    public function authLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $auth = userModel::where('username', $request->username)->first();

        if ($auth && Hash::check($request->password, $auth->password)) {

            Session::put('auth_id', $auth->id);
            Session::put('auth_username', $auth->username);

            if ($auth->role === 'admin') {
                Session::put('auth_role', 'admin');

                return redirect()->route('dashboard')->with('success', 'Login Admin berhasil');
            } elseif ($auth->role === 'guru') {
                Session::put('auth_role', 'guru');

                return redirect()->route('dashboard')->with('success', 'Login Guru berhasil');
            } else {
                Session::put('auth_role', 'siswa');

                return redirect()->route('userSiswa.dashboard')->with('success', 'Login Siswa berhasil');
            }
        } else {
            return redirect()->route('auth')->with('error', 'Username atau password salah');
        }
    }

    public function logout()
    {
        Session::flush();

        return redirect()->route('auth')->with('success', 'Logout berhasil');
    }
}
