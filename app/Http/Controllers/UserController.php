<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user dengan level "admin"
     */
    public function index()
    {
        $users = User::with('level')
            ->select('id', 'name', 'level_id', 'created_at', 'status')
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

        $user = User::create([
            'name'       => $request->name,
            'password'   => Hash::make($request->password),
            'level_id'   => $request->level_id,
            'status'     => 'active',
            'delete_add' => 'active'
        ]);

        // Jika request AJAX, return JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan.',
                'user' => $user->load('level')
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Show user details (for view modal)
     */
    public function show($id)
    {
        $user = User::with('level')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function edit($id)
    {
        $user = User::with('level')->findOrFail($id);
        $levels = Level::where('name', 'admin')->get();

        // Jika request AJAX, return JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'user' => $user,
                'levels' => $levels
            ]);
        }

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

        // Jika request AJAX, return JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diperbarui.',
                'user' => $user->fresh()->load('level')
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'inactive']);

        // Jika request AJAX, return JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil di-nonaktifkan.'
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil di-nonaktifkan.');
    }
}