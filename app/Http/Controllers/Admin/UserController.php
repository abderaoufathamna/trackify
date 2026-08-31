<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'string', 'min:4'],
            'role'     => ['required', 'in:admin,user'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'username'  => $validated['username'],
                'full_name' => $validated['username'],
                'email'     => $validated['username'].'@trackify.local',
                'password'  => $validated['password'],
                'role'      => $validated['role'],
            ]);

            if ($user->role === 'user') {
                Student::create(['user_id' => $user->id]);
            }
        });

        return redirect()->route('admin.users.index')->with('success', 'User added successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$user->id],
            'password' => ['nullable', 'string', 'min:4'],
            'role'     => ['required', 'in:admin,user'],
        ]);

        if ($user->role === 'admin' && $validated['role'] === 'user') {
            $adminCount = User::where('role', 'admin')->count();

            if ($adminCount <= 1) {
                return back()->withErrors(['role' => 'Cannot demote the last admin.']);
            }
        }

        $user->username = $validated['username'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            $adminCount = User::where('role', 'admin')->count();

            if ($adminCount <= 1) {
                return back()->withErrors(['role' => 'You cannot delete the last admin.']);
            }
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}