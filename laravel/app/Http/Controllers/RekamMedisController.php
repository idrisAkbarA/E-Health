<?php

namespace App\Http\Controllers;

use App\Events\AntrianPoli;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RekamMedisController extends Controller
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
     * Display an antrian today.
     *
     * @return \Illuminate\Http\Response
     */
    public function antrian()
    {
        $antrian = RekamMedis::whereDate('created_at', today())
            ->with('pasien')
            ->with('poli')
            ->with('resep_obat')
            ->latest()
            ->get();

        $this->reply = [
            'status' => true,
            'data' => $antrian
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
            'pasien_id' => 'required',
            'poli_id' => 'required'
        ]);

        RekamMedis::create($validated);
        Log::info('new antrian created');

        broadcast(new AntrianPoli());

        $this->reply = [
            'status' => true,
            'message' => 'Antrian berhail dibuat!'
        ];
        return response()->json($this->reply, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RekamMedis  $rekamMedis
     * @return \Illuminate\Http\Response
     */
    public function show(RekamMedis $rekamMedis)
    {
        $this->reply = [
            'status' => true,
            'data' => $rekamMedis
        ];
        return response()->json($this->reply, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RekamMedis  $rekamMedis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RekamMedis $rekamMedis)
    {
        $rekamMedis->update($request->except('resep_obat'));
        $rekamMedis->resep_obat()->create($request->resep_obat);

        broadcast(new AntrianPoli());

        $this->reply = [
            'status' => true,
            'message' => 'Rekam Medis updated!',
            'data' => $rekamMedis
        ];
        return response()->json($this->reply, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RekamMedis  $rekamMedis
     * @return \Illuminate\Http\Response
     */
    public function destroy(RekamMedis $rekamMedis)
    {
        //
    }
}
