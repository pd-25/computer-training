<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        try {
            $data = $request->all();
            if (Auth::guard('admin')->attempt(["email" => $data["email"], "password" => $data["password"]])) {
                return redirect()->route('admin.dashboard');
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
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with("msg", "Logged out successfully");
    }

    public function accountSetting()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.auth.account-setting', compact('admin'));
    }

    public function updateAccountSetting(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:admins,email,' . Auth::guard('admin')->id(),
            'password' => 'nullable|min:6|confirmed',
        ]);

        try {
            $admin = Auth::guard('admin')->user();
            $admin->email = $request->email;

            if ($request->filled('password')) {
                $admin->password = Hash::make($request->password);
            }

            $admin->save();

            return back()->with("msg", "Profile updated successfully");
        } catch (\Throwable $th) {
            return back()->with("msg", $th->getMessage());
        }
    }
}
