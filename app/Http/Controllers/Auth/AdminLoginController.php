<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    // Show admin login form
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Handle admin login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Invalid credentials']);
    }

    // Admin logout
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
