<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

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
