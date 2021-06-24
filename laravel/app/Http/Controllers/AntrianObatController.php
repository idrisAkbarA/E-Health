<?php

namespace App\Http\Controllers;

use App\Events\AntrianObatEvent;
use App\Models\AntrianObat;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class AntrianObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nama = $request->nama;
        $status = $request->status;
        $from = $request->date[0] ?? null;
        $to = null;
        if ($request->date[1] ?? null) {
            $to = $request->date[1];
        } else {
            $to = $from;
        }

        // return gettype($status);
        $antrian = AntrianObat::with('rekam_medis')
            ->when($nama, function ($q) use ($nama) {
                return $q->where('nama', $nama)->orWhereHas('rekam_medis', function ($que) use ($nama) {
                    return $que->wherehas('pasien', function ($query) use ($nama) {
                        return $query->where('nama', 'LIKE', '%' . $nama . '%')->orWhere('nik', $nama);
                    });
                });
            })
            ->when(!is_null($status), function ($q) use ($status) {
                if ($status == 'null') {
                    return $q->whereNull('status');
                }
                return $q->where('status', $status);
            })
            ->when($request->date, function ($q) use ($from, $to) {
                return $q->whereBetween('created_at', [$from, date('Y-m-d', strtotime($to . '+1 day'))]);
            })
            ->latest()
            ->get();

        $this->reply = [
            'status' => true,
            'data' => $antrian
        ];
        return response()->json($this->reply, 200);
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
        AntrianObat::create($request->all());
        broadcast(new AntrianObatEvent());

        $this->reply = [
            'status' => true,
            'message' => 'Antrian berhail dibuat!'
        ];
        return response()->json($this->reply, 201);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AntrianObat  $antrianObat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AntrianObat $antrianObat)
    {
        if ($request->has('payment')) {
            $antrianObat->is_bayar = 1;
            $antrianObat->save();
            $this->reply = [
                'status' => true,
                'message' => 'Pembayaran berhasil disimpan!',
            ];
            broadcast(new AntrianObatEvent());
            return response()->json($this->reply, 200);
        }
        $antrianObat->update($request->all());

        broadcast(new AntrianObatEvent());

        $this->reply = [
            'status' => true,
            'message' => 'Rekam Medis updated!',
            'data' => $antrianObat
        ];
        return response()->json($this->reply, 200);
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
