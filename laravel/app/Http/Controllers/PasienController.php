<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Services\Antrian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pasien = Pasien::latest()->get();

        $this->reply = [
            'status' => true,
            'data' => $pasien
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
        $validated = $request->validate([
            'nik' => 'required|unique:pasien',
            'nama' => 'required',
            'jenis_kelamin' => 'kontak',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'kontak' => 'required',
            'alamat' => 'nullable',
            'poli_id' => 'nullable',
            'agama' => 'nullable',
            'riwayat_alergi' => 'nullable',
            'riwayat_penyakit_pribadi' => 'nullable',
            'riwayat_penyakit_keluarga' => 'nullable',
            'pekerjaan' => 'nullable',
            'pendidikan' => 'nullable',
        ]);

        if ($validated['poli_id']) {
            (new Antrian())->storePasienAddQueue($validated);
            return response()->json(['status' => true, 'message' => "Pasien berhasil ditambahkan!"]);
        }

        Pasien::create($validated);
        return response()->json(['status' => true, 'message' => "Pasien berhasil ditambahkan!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pasien  $pasien
     * @return \Illuminate\Http\Response
     */
    public function show(Pasien $pasien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pasien  $pasien
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pasien $pasien)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pasien  $pasien
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pasien $pasien)
    {
        //
    }

    public function liveSearch(Request $request)
    {
        $searchResult = DB::table('pasien')->where('nama', 'like', '%' . $request->data . '%')
            ->orWhere('nik', 'like', '%' . $request->data . '%')
            ->get();
        return response()->json($searchResult);
    }
}
