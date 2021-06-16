<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $poli = Poli::all();

        $this->reply = [
            'status' => true,
            'data' => $poli
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
        $poli = Poli::create($request->all());

        $this->reply = [
            'status' => true,
            'message' => 'Poli Created!',
            'data' => $poli
        ];
        return response()->json($this->reply, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Poli  $poli
     * @return \Illuminate\Http\Response
     */
    public function show(Poli $poli)
    {
        $this->reply = [
            'status' => true,
            'data' => $poli
        ];
        return response()->json($this->reply, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Poli  $poli
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Poli $poli)
    {
        $poli->update($request->all());

        $this->reply = [
            'status' => true,
            'message' => 'Obat Updated!',
            'data' => $poli
        ];
        return response()->json($this->reply, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Poli  $poli
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poli $poli)
    {
        $poli->delete();

        $this->reply = [
            'status' => true,
            'message' => 'Poli Deleted!'
        ];
        return response()->json($this->reply, 200);
    }
}
