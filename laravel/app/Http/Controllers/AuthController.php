<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // if (!Hash::check($request->password, $request->password)) {
        //     return response()->json([
        //         'password' => ['The provided password does not match our records.']
        //     ]);
        // }
        // return response()->json(['status' => 'logged in']);
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return response()->json([
                'status' => 'Authenticated',
                'user' => Auth::user()
            ]);
        }
        return response()->json([
            'status' => 'Not Authenticated',
        ]);
    }
}
