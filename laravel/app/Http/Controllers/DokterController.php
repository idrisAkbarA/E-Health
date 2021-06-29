<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokterController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $dokter = Dokter::where('is_aktif', true)->get();

    $this->reply = [
      'status' => true,
      'data' => $dokter
    ];
    return response()->json($this->reply, 200);
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
    $from = $request->date ? $request->date[0] : null;
    $to = $request->date ? $request->date[1] ? $request->date[1] : $request->date[0] : null;

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
  public function updatePhoto(Request $request, Dokter $dokter)
  {
    $validated = $request->validate([
      'file' => 'required|mimes:jpg,jpeg,png|max:512|dimensions:min_width=400,min_height=500'
    ]);

    $photo = $validated['file'];
    $extension = $photo->getClientOriginalExtension();
    $newName = 'profil-' . $dokter->id . '.' . $extension;
    /**
     * Delete old file
     */
    $path = 'public/profil';
    Storage::delete($path . '/' . $newName);
    Storage::putFileAs($path, $photo, $newName);

    $dokter->foto = Storage::url('profil' . '/' . $newName);
    $dokter->save();

    $this->reply = [
      'status' => true,
      'message' => 'Dokter Updated!',
      'url' => $dokter->foto
    ];
    return response()->json($this->reply, 200);
  }
}
