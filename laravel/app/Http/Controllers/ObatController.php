<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obat = Obat::all();

        $this->reply = [
            'status' => true,
            'data' => $obat
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
        $obat = Obat::create($request->all());

        $this->reply = [
            'status' => true,
            'message' => 'Obat Created!',
            'data' => $obat
        ];
        return response()->json($this->reply, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Obat  $obat
     * @return \Illuminate\Http\Response
     */
    public function show(Obat $obat)
    {
        $this->reply = [
            'status' => true,
            'data' => $obat
        ];
        return response()->json($this->reply, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Obat  $obat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Obat $obat)
    {
        $obat->update($request->all());

        $this->reply = [
            'status' => true,
            'message' => 'Obat Updated!',
            'data' => $obat
        ];
        return response()->json($this->reply, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Obat  $obat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Obat $obat)
    {
        $obat->delete();

        $this->reply = [
            'status' => true,
            'message' => 'Obat Updated!'
        ];
        return response()->json($this->reply, 200);
    }
}
