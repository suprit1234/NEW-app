<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register()
        {
        return view('register.register');
    }

    public function store(){
        request()->validate([
            'name' => ['required|min:7|max:255'],
            'username' => ['required|max:255'],
            'email' => 'required|email|max:255',
            'password' => 'required|min:7|max:255',
        ]);

        dd('success validation succeeded');
    }
}
