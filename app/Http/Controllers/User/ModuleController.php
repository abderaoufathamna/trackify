<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function create()
    {
        return view('user.modules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Module::create([
            'name'    => $validated['name'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Module added.');
    }
}