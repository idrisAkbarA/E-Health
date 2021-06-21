<?php

namespace App\Http\Controllers;

use App\Models\AntrianObat;
use Illuminate\Http\Request;

class AntrianObatController extends Controller
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
     * Display a listing of the resource today.
     *
     * @return \Illuminate\Http\Response
     */
    public function antrian()
    {
        $antrian = AntrianObat::whereDate('created_at', today())
            ->with('rekam_medis')
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
        $antrianObat = AntrianObat::create($request->all());
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AntrianObat  $antrianObat
     * @return \Illuminate\Http\Response
     */
    public function show(AntrianObat $antrianObat)
    {
        $this->reply = [
            'status' => true,
            'data' => $antrianObat
        ];
        return response()->json($this->reply, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AntrianObat  $antrianObat
     * @return \Illuminate\Http\Response
     */
    public function edit(AntrianObat $antrianObat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AntrianObat  $antrianObat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AntrianObat $antrianObat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AntrianObat  $antrianObat
     * @return \Illuminate\Http\Response
     */
    public function destroy(AntrianObat $antrianObat)
    {
        //
    }
}
