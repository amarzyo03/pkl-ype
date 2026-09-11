<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\userModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class userController extends Controller
{
    public function index(Request $request)
    {
        $query = UserModel::query();

        $search = trim((string) $request->input('search', ''));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $role = strtolower((string) $request->input('role', 'all'));
        if (in_array($role, ['admin', 'guru', 'siswa'], true)) {
            $query->where('role', $role);
        }

        $status = strtolower((string) $request->input('status', 'all'));
        if (in_array($status, ['active', 'inactive'], true)) {
            $query->where('status', $status);
        }

        $perPage = (int) $request->input('perPage', 15);
        if (!in_array($perPage, [15, 25, 50, 100], true)) {
            $perPage = 15;
        }

        $users = $query
            ->orderBy('id', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        if ($request->boolean('ajax')) {
            return response()->json([
                'rows' => view('user.partials.user_rows', compact('users'))->render(),
                'summary' => view('user.partials.user_summary', compact('users'))->render(),
                'pager' => view('user.partials.user_pager', compact('users'))->render(),
            ]);
        }

        return view('user.index', compact('users'));
    }

    public function add()
    {
        return view('user.add');
    }

    public function save(Request $request)
    {
        $validated      = $request->validate([
            'nama'      => ['required', 'string', 'max:255'],
            'username'  => ['required', 'string', 'max:255', 'unique:tb_users,username'],
            'password'  => ['required', 'string', 'min:3', 'confirmed'],
            'role'      => ['required', 'in:admin,guru,siswa'],
            'status'    => ['required', 'in:active,inactive'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        UserModel::create($validated);
        return redirect()->route('user')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $user = UserModel::findOrFail($id);
        return view('user.edit', compact('user'));
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
        return redirect()->route('user')->with('success', 'User berhasil diperbarui.');
    }

    public function delete(string $id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();
        return redirect()->route('user')->with('success', 'User berhasil dihapus.');
    }

    public function import()
    {
        return view('user.import');
    }

    public function importStore(Request $request)
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        Excel::import(new UsersImport, $validated['file']);
        return redirect()->route('user')->with('success', 'Data user berhasil diimport.');
    }
}
