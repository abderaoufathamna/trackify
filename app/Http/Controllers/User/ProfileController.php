<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view('user.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:255', 'unique:users,username,'.$user->id],
            'password' => ['nullable', 'string', 'min:4'],
        ]);

        $user->username = $validated['username'];

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()->route('user.profile.edit')->with('success', 'Profile updated successfully.');
    }
}