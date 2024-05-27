<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class authController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(Request $request){

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            $request->session()->regenerate();

            return redirect()->route('dashboard')->with('login', 'Berhasil Login');
        }


        return redirect()->back()->with('gagal', 'Login Gagal, Pastikan email dan password anda');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('logout', 'Anda berhasil Logout');
    }
}
