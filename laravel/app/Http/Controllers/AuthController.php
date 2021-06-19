<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return response()->json([
                'status' => 'Authenticated',
                'user' => Auth::user()
            ]);
        }
        return response()->json([
            'status' => 'Not Authenticated',
        ], 401);
    }
    public function logout()
    {
        Auth::logout();
    }
    public function changePassword(Request $request)
    {

        $user = User::find($request->id);

        //check if user exist
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found.']);
        }

        // validate the old password
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['status' => false, 'message' => 'Password lama tidak valid']);
        }

        $user->password = $request->new_password;
        $user->save();

        return response()->json(['status' => true, 'message' => 'Password berhasil diubah.']);
    }
}
