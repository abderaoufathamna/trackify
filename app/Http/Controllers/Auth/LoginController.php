<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => ['requered', 'string'],
            'password'   => ['requered', 'string'],
        ]);

        $field = filter_var($credentials['identifier'], FILTER_validate_email)
        ? 'email' : 'username';

        $attempt = [
            $field    =>$credentials['identifier'],
            $password =>$credentials['password'],
        ];

        if (! Auth::attept($attempt, $request->boolean('remember')))
        {
            return back()->withErrors([
                'identifier', 'Inccourect informations'])
                ->onlyInput('identifier');
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

        return redirect('/logout');
    }
}
