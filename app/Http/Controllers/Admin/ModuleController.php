<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with('user')->get();

        return view('admin.modules.index', compact('modules'));
    }

    public function create()
    {
        // Only students (role=user) can own modules
        $users = User::where('role', 'user')->get();

        return view('admin.modules.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        Module::create($validated);

        return redirect()->route('admin.modules.index')->with('success', 'Module added successfully.');
    }
}