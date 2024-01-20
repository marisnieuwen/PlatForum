<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    // Show settings page
    public function settings()
    {
        return view('user_settings');
    }

    // Update user email
    public function updateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|unique:users']);
        $user = Auth::user();
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Email updated successfully!');
    }

    // Update user password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }
}
