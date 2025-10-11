<?php

namespace App\Http\Controllers\subadmin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('subadmin.auth.login');
    }
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        try {
            $data = $request->all();
            if (Auth::guard('subadmin')->attempt(["email" => $data["email"], "password" => $data["password"]])) {
                return redirect()->route('subadmin.dashboard');
            } else {
                return back()->with("msg", "Invalid credentials");
            }
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with("msg", throw $th);
        }
    }

    public function adminLogout()
    {
        Auth::guard('subadmin')->logout();
        return redirect()->route('subadmin.login')->with("msg", "Logged out successfully");
    }
}
