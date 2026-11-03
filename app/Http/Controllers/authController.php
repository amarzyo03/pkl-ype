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
            $dashboardRoute = $this->dashboardRoute(session('auth_role'));

            if ($dashboardRoute !== null) {
                return redirect()->route($dashboardRoute);
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

        if (! $auth || ! Hash::check($request->password, $auth->password)) {
            return redirect()->route('auth')->with('error', 'Username atau password salah');
        }

        $dashboardRoute = $this->dashboardRoute($auth->role);

        if ($dashboardRoute === null) {
            return redirect()->route('auth')->with('error', 'Role pengguna tidak valid.');
        }

        Session::put('auth_id', $auth->id);
        Session::put('auth_username', $auth->username);
        Session::put('auth_role', $auth->role);

        return redirect()
            ->route($dashboardRoute)
            ->with('success', 'Login '.ucfirst($auth->role).' berhasil');
    }

    public function logout()
    {
        Session::flush();

        return redirect()->route('auth')->with('success', 'Logout berhasil');
    }

    private function dashboardRoute(?string $role): ?string
    {
        return match ($role) {
            'admin' => 'dashboard',
            'guru' => 'userGuru.dashboard',
            'siswa' => 'userSiswa.dashboard',
            default => null,
        };
    }
}
