<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string'],
            'password'   => ['required', 'string'],
        ]);

        $field = filter_var($credentials['identifier'], FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        $attempt = [
            $field       => $credentials['identifier'],
            'password'   => $credentials['password'],
        ];

        if (! Auth::attempt($attempt, $request->boolean('remember'))) {
            return back()->withErrors([
                'identifier' => 'Inccourect informations.',
            ])->onlyInput('identifier');
        }

        $request->session()->regenerate();

        return redirect()->intended(
            Auth::user()->role === 'admin' ? '/admin' : '/user'
        );
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}