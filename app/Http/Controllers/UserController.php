<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of HR users.
     */
    public function index()
    {
        $users = User::where('role', 'hr')->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new HR.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created HR in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'photo'    => 'nullable|image|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('users', 'public');
        }

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'hr',
            'photo'     => $photoPath,
            'is_active' => true,
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'HR berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified HR.
     */
    public function edit(string $id)
    {
        $user = User::where('role', 'hr')
            ->where('id', $id)
            ->firstOrFail();

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified HR in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::where('role', 'hr')
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|max:2048',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        // update password jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }

        // update foto jika ada
        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->photo = $request->file('photo')->store('users', 'public');
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'HR berhasil diperbarui');
    }

    /**
     * Remove the specified HR from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('role', 'hr')
            ->where('id', $id)
            ->firstOrFail();

        // hapus foto kalau ada
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'HR berhasil dihapus');
    }

    /**
     * Toggle active / non-active HR
     */
    public function toggleStatus(User $user)
    {
        if ($user->role === 'admin') {
            abort(403, 'Admin tidak boleh dinonaktifkan');
        }

        $user->is_active = ! $user->is_active;
        $user->save();

        return back()->with('success', 'Status HR berhasil diubah');
    }
}