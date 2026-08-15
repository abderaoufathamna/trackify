<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username'  => ['required', 'string', 'max:255', 'unique:users,username'],
            'full_name' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        $user = DB::transaction(function () use ($validated) {

            $user = User::create([
                'username'  => $validated['username'],
                'full_name' => $validated['full_name'],
                'email'     => $validated['email'],
                'password'  => $validated['password'],
                'role'      => 'user',
            ]);

            Student::create([
                'user_id' => $user->id,
            ]);

            return $user;
        });

        Auth::login($user);

        $request->session()->regenerate();

        return redirect('/user');
    }
}