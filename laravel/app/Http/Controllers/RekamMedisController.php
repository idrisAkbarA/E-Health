<?php

namespace App\Http\Controllers;

use App\Events\AntrianPoli;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

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
        $pasienId = $request->pasien_id;
        $pasien = Pasien::firstOrCreate(['id' => $pasienId], $request->pasien);

        $rekamMedis = $pasien->rekam_medis()->create($request->all());
        broadcast(new AntrianPoli($rekamMedis));

        $this->reply = [
            'status' => true,
            'data' => $rekamMedis
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
        $pasienId = $request->pasien_id;
        $pasien = Pasien::find($pasienId);

        if (is_null($pasien)) {
            $this->reply['message'] = 'Opps Something Wrong';
            return response()->json($this->reply);
        }

        $rekamMedis = $pasien->rekam_medis()->create($request->all());
        broadcast(new AntrianPoli($rekamMedis));

        $this->reply = [
            'status' => true,
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
