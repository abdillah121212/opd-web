<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user dengan level "admin" saja
     */
    public function index()
    {
        $users = User::with('level')
            ->whereHas('level', function ($query) {
                $query->where('name', 'admin');
            })
            ->get();

        return view('users.list', compact('users'));
    }

    /**
     * Menampilkan form tambah user
     */
    public function create()
    {
        $levels = Level::where('name', 'admin')->get();
        return view('users.create', compact('levels'));
    }

    /**
     * Menyimpan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|unique:users,name',
            'password' => 'required|string|min:6|confirmed',
            'level_id' => 'required|exists:levels,id'
        ]);

        User::create([
            'name'     => $request->name,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id,
            'status'   => 'active',
            'delete_add' => 'active'
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $levels = Level::where('name', 'admin')->get();

        return view('users.edit', compact('user', 'levels'));
    }

    /**
     * Mengupdate data user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|unique:users,name,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'level_id' => 'required|exists:levels,id'
        ]);

        $data = [
            'name'     => $request->name,
            'level_id' => $request->level_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Menghapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
