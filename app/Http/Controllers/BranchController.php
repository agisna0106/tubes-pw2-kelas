<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::with('manager')->latest()->get();

        return view('branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $managers = User::role('manager')->get();

        return view('branches.create', compact('managers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        Branch::create([
            'name' => $request->name,
            'city' => $request->city,
            'address' => $request->address,
            'phone' => $request->phone,
            'manager_id' => $request->manager_id,
        ]);

        return redirect()->route('branches.index')
            ->with('success', 'Data branch berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
         return redirect()->route('branches.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
         $managers = User::role('manager')->get();

        return view('branches.edit', compact('branch', 'managers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
         $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $branch->update([
            'name' => $request->name,
            'city' => $request->city,
            'address' => $request->address,
            'phone' => $request->phone,
            'manager_id' => $request->manager_id,
        ]);

        return redirect()->route('branches.index')
            ->with('success', 'Data branch berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
         $branch->delete();

        return redirect()->route('branches.index')
            ->with('success', 'Data branch berhasil dihapus.');
    }
}
