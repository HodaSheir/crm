<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:employee')->except('logout');
    }

    // Show employee login form
    public function showLoginForm()
    {
        return view('employee.login');
    }

    // Handle employee login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('employee')->attempt($credentials, $request->remember)) {
            return redirect()->intended(route('employee.dashboard'));
        }

        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Invalid credentials']);
    }

    // Employee logout
    public function logout()
    {
        Auth::guard('employee')->logout();
        return redirect()->route('employee.login');
    }
}
