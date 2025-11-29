<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    // tampilkan form login
    public function showLogin()
    {
        return view('auth.login', ['title' => 'Sign In']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user_cred' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
        // cek apakah input berupa email atau username
        $fieldType = filter_var($request->user_cred, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';


        if (Auth::attempt([$fieldType => $request->user_cred, 'password' => $request->password])) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'SuperAdmin') {
                return Redirect::route('admin.indexAdmin');
            } elseif (Auth::user()->role === 'Leader') {
                return Redirect::route('leader.indexLeader');
            } elseif (Auth::user()->role === 'Member') {
                return Redirect::route('member.indexMember');
            }
        }

        return back()->withErrors([
            'user_cred' => 'Email atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
