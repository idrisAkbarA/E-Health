<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  public function getByUserId(User $user)
  {
    $dokter = Dokter::where('user_id', $user->id)->first();

    $this->reply = [
      'status' => true,
      'data' => $dokter
    ];
    return response()->json($this->reply, 200);
  }

  /**
   * Display rekam medis of this dokter.
   *
   * @return \Illuminate\Http\Response
   */
  public function rekamMedis()
  {
    $dokter = Dokter::where('user_id', Auth::id())->first();
    $rekamMedis = $dokter->rekam_medis()->get();

    $this->reply = [
      'status' => true,
      'data' => $rekamMedis
    ];
    return response()->json($this->reply, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Dokter  $dokter
   * @return \Illuminate\Http\Response
   */
  public function show(Dokter $dokter)
  {
    $this->reply = [
      'status' => true,
      'data' => $dokter
    ];
    return response()->json($this->reply, 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Dokter  $dokter
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Dokter $dokter)
  {
    $dokter->update($request->all());

    $this->reply = [
      'status' => true,
      'message' => 'Dokter Updated!',
      'data' => $dokter
    ];
    return response()->json($this->reply, 200);
  }
}
