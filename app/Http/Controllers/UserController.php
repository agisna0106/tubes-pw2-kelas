<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['users'] = User::with(['branch', 'roles'])->get();
        return view('users.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::orderBy('name')->get();
        $roles = Role::all();

        return view(
            'users.create',
            compact('branches', 'roles')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|lowercase|unique:users,email',
            'password' => ['required', Rules\Password::defaults()],
            'branch_id' => 'nullable|integer|exists:branches,id',
            'role' => 'required'
        ]);

        $validate['password'] = Hash::make($validate['password']);

        $role = $validate['role'];
        unset($validate['role']);

        // dd($validate);
        $user = User::create($validate);
        $user->assignRole($role);

        return redirect()
        ->route('users.index')
        ->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $branches = Branch::all();
        $roles = Role::all();

        return view(
            'users.edit',
            compact('user','branches', 'roles')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'. $user->id,
            'email' => 'required|string|email|lowercase|unique:users,email,'. $user->id,
            'branch_id' => 'nullable|integer|exists:branches,id',
            'role' => 'required'
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', Rules\Password::defaults()]
            ]);

            $validate['password'] = Hash::make($request->password);
        }

        $role = $validate['role'];
        unset($validate['role']);

        $user->update($validate);

        $user->syncRoles($role);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus');
    }
}
