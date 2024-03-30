<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login', ['auth' => auth()->user()]);
    }

    public function signin(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            return response()->json(['auth' => true, 'message' => 'Successfully signed in.']);
        }

        return response()->json(['auth' => false, 'message' => 'Invalid credentials.'], 500);
    }

    public function logout()
    {
        return 'about ot logoout';
    }
}
