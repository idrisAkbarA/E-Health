<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('dokter')->get();

        $this->reply = [
            'status' => true,
            'data' => $users
        ];
        return response()->json($this->reply, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());

        if ($user->role == 'Dokter') {
            $user->dokter()->create($request->dokter);
        }

        $this->reply = [
            'status' => true,
            'message' => 'User Created!',
            'data' => $user
        ];
        return response()->json($this->reply, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        if ($user->role == 'Dokter') {
            $user->dokter()->update($request->dokter);
        }

        $this->reply = [
            'status' => true,
            'message' => 'User Updated!',
            'data' => $user
        ];
        return response()->json($this->reply, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        $this->reply = [
            'status' => true,
            'message' => 'User Deleted!'
        ];
        return response()->json($this->reply, 200);
    }
}
