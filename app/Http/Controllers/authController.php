<?php

namespace App\Http\Controllers;

use App\Models\userModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class authController extends Controller
{
    public function index()
    {
        $users = UserModel::orderBy('created_at', 'desc')->get();
        return view('auth.index', compact('users'));
    }

    public function add()
    {
        return view('auth.add');
    }

    public function save(Request $request)
    {
        $validated      = $request->validate([
            'nama'      => ['required', 'string', 'max:255'],
            'username'  => ['required', 'string', 'max:255', 'unique:tb_users,username'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'role'      => ['required', 'in:admin,guru,siswa'],
            'status'    => ['required', 'in:active,inactive'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        UserModel::create($validated);
        return redirect()->route('auth')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $user = UserModel::findOrFail($id);
        return view('auth.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user           = UserModel::findOrFail($id);
        $validated      = $request->validate([
            'nama'      => ['required', 'string', 'max:255'],
            'username'  => ['required', 'string', 'max:255', Rule::unique('tb_users', 'username')->ignore($user->id)],
            'password'  => ['nullable', 'string', 'min:8', 'confirmed'],
            'role'      => ['required', 'in:admin,guru,siswa'],
            'status'    => ['required', 'in:active,inactive'],
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return redirect()->route('auth')->with('success', 'User berhasil diperbarui.');
    }

    public function delete(string $id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();
        return redirect()->route('auth')->with('success', 'User berhasil dihapus.');
    }

    public function import()
    {
        return view('auth.import');
    }
}
