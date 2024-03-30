<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function signin()
    {
        return 'about to sigin';
    }

    public function logout()
    {
        return 'about ot logoout';
    }
}
