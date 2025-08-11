<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user dengan level "admin"
     */
    public function index()
    {
        $users = User::select('id', 'name', 'level_id', 'created_at', 'status',)
            ->where('status', 'active')
            ->get();

        return view('apps.user-management.users.list', compact('users'));
    }

    public function create()
    {
        $levels = Level::where('name', 'admin')->get();
        return view('apps.user-management.users.create', compact('levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|unique:users,name',
            'password' => 'required|string|min:6|confirmed',
            'level_id' => 'required|exists:levels,id'
        ]);

        User::create([
            'name'       => $request->name,
            'password'   => Hash::make($request->password),
            'level_id'   => $request->level_id,
            'status'     => 'active',
            'delete_add' => 'active'
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $levels = Level::where('name', 'admin')->get();

        return view('apps.user-management.users.edit', compact('user', 'levels'));
    }

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

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'inactive';
        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil di-nonaktifkan.');
    }
}
