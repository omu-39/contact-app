<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        Auth::attempt($request->only(['email', 'password']));

        $request->session()->regenerate();

        return redirect()->intended(route('admin.index'));
    }
}
