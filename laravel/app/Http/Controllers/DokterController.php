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
  public function rekamMedis(Request $request)
  {
    $nama = $request->nama;
    $from = $request->date[0];
    $to = $request->date[1] ?? $request->date[0];

    $dokter = Dokter::where('user_id', Auth::id())->first();
    $rekamMedis = $dokter->rekam_medis()
      ->when($nama, function ($q) use ($nama) {
        return $q->wherehas('pasien', function ($query) use ($nama) {
          return $query->where('nama', 'LIKE', '%' . $nama . '%')->orWhere('nik', $nama);
        });
      })
      ->when($request->date, function ($q) use ($from, $to) {
        return $q->whereBetween('created_at', [$from, date('Y-m-d', strtotime($to . '+1 day'))]);
      })
      ->latest()
      ->get();

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
