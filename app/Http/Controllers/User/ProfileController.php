<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'username'       => ['required', 'string', 'min:3', 'max:255', 'unique:users,username,'.$user->id],
            'password'       => ['nullable', 'string', 'min:4'],
            'profile_image'  => ['nullable', 'image', 'max:2048'],
        ]);

        $user->username = $validated['username'];

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $user->profile_image = $request->file('profile_image')->store('profile-images', 'public');
        }

        $user->save();

        return redirect()->route('user.profile.edit')->with('success', 'Profile updated successfully.');
    }
}