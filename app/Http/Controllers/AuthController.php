<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user != null) {
            if(Hash::check($request->password, $user->password)) {
                session()->put('user', $user);
                return redirect()->route('home');
            }
        }
        return redirect()->route('login')->with(['errmsg' => 'User tidak terdaftar']);
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
