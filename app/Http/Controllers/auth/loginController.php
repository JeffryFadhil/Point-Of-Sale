<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
 public function index (){
    return view ('auth.login');
 }

 public function HandleLogin(Request $request)
 {
    $credentials = $request->validate([
         'email' => 'required|email',
         'password' => 'required|min:6',
     ],
    [
         'email.required' => 'email harus diisi',
            'email.email' => 'format email tidak valid',
            'password.required' => 'password harus diisi',
            'password.min' => 'password minimal 6 karakter',

     ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard'); // Redirect ke halaman yang diinginkan setelah login
        }
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
 }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/'); // Redirect ke halaman login setelah logout
    }
}
