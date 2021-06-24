<?php

namespace App\Http\Controllers;

use App\Models\SuratRujukan;
use Illuminate\Http\Request;

class SuratRujukanController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required',
            'dokter_id' => 'required',
            'diagnosa' => 'required',
            'pengobatan' => 'required',
            'keadaan' => 'required',
            'tujuan' => 'required',
        ]);

        $suratRujukan = SuratRujukan::create($validated);

        $this->reply = [
            'status' => true,
            'data' => $suratRujukan,
            'message' => 'Surat Rujukan berhail dibuat!'
        ];
        return response()->json($this->reply, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SuratRujukan  $suratRujukan
     * @return \Illuminate\Http\Response
     */
    public function show(SuratRujukan $suratRujukan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SuratRujukan  $suratRujukan
     * @return \Illuminate\Http\Response
     */
    public function edit(SuratRujukan $suratRujukan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SuratRujukan  $suratRujukan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SuratRujukan $suratRujukan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SuratRujukan  $suratRujukan
     * @return \Illuminate\Http\Response
     */
    public function destroy(SuratRujukan $suratRujukan)
    {
        //
    }
}
