<?php

namespace App\Http\Controllers;

use App\Events\AntrianPoli;
use App\Exports\LaporanKasir;
use App\Models\AntrianObat;
use App\Models\Poli;
use App\Models\RekamMedis;
use App\Services\Antrian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RekamMedisController extends Controller
{
    public function Export($data)
    {
        $converted = Collection::make($data);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $isExport = $request->has('isExport') ? $request->isExport : null;
        $nama = $request->has('nama') ? $request->nama : null;
        $status = $request->has('status') ? $request->status : null;
        $status_bayar = $request->has('status_bayar') ? $request->status_bayar : null;
        $payment = $request->has('payment') ? true : false;
        $poli = $request->has('poli') ? $request->poli : null;
        $page = $request->has('page') ? $request->page : null;
        $from = null;
        $to = null;
        if ($request->has('tanggal')) {
            if (count($request->tanggal) > 0) {
                $from = $request->tanggal[0];
                $to = $request->tanggal[1];
            }
        }
        $antrian = RekamMedis::with('pasien')
            ->when($nama, function ($q) use ($nama) {
                return $q->whereHas('pasien', function ($query) use ($nama) {
                    return $query->where('nama', 'LIKE', '%' . $nama . '%')->orWhere('nik', $nama);
                });
            })
            ->when(!is_null($status), function ($q) use ($status) {
                if ($status == 'null') {
                    return $q->whereNull('status');
                }
                return $q->where('status', $status);
            })
            ->when(!is_null($status_bayar), function ($q) use ($status_bayar) {
                return $q->where('is_bayar', $status_bayar);
            })
            ->when($poli, function ($q) use ($poli) {
                return $q->where('is_bayar', $poli == 'null' ? null : $poli);
            })
            ->when($request->tanggal, function ($q) use ($from, $to) {
                return $q->whereBetween('created_at', [$from, date('Y-m-d', strtotime($to . '+1 day'))]);
            })
            ->latest()
            ->get();

        $antrianObat = (new AntrianObat())
            ->when($nama, function ($q) use ($nama) {
                return $q->where('nama', 'LIKE', '%' . $nama . '%');
            })
            ->when($status, function ($q) use ($status) {
                return $q->where('status', $status == 'null' ? null : $status);
            })
            ->when($request->tanggal, function ($q) use ($from, $to) {
                return $q->whereBetween('created_at', [$from, date('Y-m-d', strtotime($to . '+1 day'))]);
            })
            ->latest()
            ->get();

        $finalAntrianObat = [];
        foreach ($antrianObat as $key => $value) {
            $temp = [
                'from_antrian_obat' => true,
                'pasien' => ["nama" => $value['nama']],
                "pasien_id" => null,
                "dokter_id" => null,
                "poli_id" => null,
                "nama_poli" => "-",
                "daignosa" => null,
                "pengobatan" => null,
                "total_biaya" => null,
                "status" => null,
                "total_biaya" => $value['total_biaya'],
                "status" => null,
                "is_bayar" => $value['is_bayar'],
                "lunas_at" => null,
                "created_at" => $value['created_at'],
                "updated_at" => $value['updated_at'],
            ];
            array_push($finalAntrianObat, $temp);
        }

        $result = array_merge($antrian->toArray(), $finalAntrianObat);
        if ($isExport) {
            $this->export($result);
            return 0;
        }

        return response()->json($this->paginate($result, $request->perPage, $request->page));
        return response()->json($antrian);
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function getByPoliId(Poli $poli)
    {
        $rekamMedis = RekamMedis::where('poli_id', $poli->id)
            ->whereDate('created_at', today())
            ->latest()
            ->get();

        $this->reply = [
            'status' => true,
            'data' => $rekamMedis
        ];
        return response()->json($this->reply, 200);
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
     * Display all history.
     *
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {
        $nama = $request->nama;
        $status = $request->status;
        $pembayaran = $request->pembayaran;
        $from = $request->date[0] ?? null;
        $to = null;
        if ($request->date[1] ?? null) {
            $to = $request->date[1];
        } else {
            $to = $from;
        }
        // $to = $request->date[1] ?? $request->date[0];

        $antrian = RekamMedis::with('pasien')
            ->when($nama, function ($q) use ($nama) {
                return $q->wherehas('pasien', function ($query) use ($nama) {
                    return $query->where('nama', 'LIKE', '%' . $nama . '%')->orWhere('nik', $nama);
                });
            })
            ->when(!is_null($status), function ($q) use ($status) {
                if ($status == 'null') {
                    return $q->whereNull('status');
                }
                return $q->where('status', $status);
            })
            ->when(!is_null($pembayaran), function ($q) use ($pembayaran) {
                return $q->where('is_bayar', $pembayaran);
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
        // request to update payment status should has "payment" property
        if ($request->has('payment')) {
            (new Antrian())->receivePayment($rekamMedis, $request);
            $this->reply = [
                'status' => true,
                'message' => 'Pembayaran berhasil di simpan!',
            ];
            return response()->json($this->reply, 201);
        }

        $rekamMedis->update($request->except('resep_obat'));
        $request->resep_obat && $rekamMedis->resep_obat()->create($request->resep_obat);

        broadcast(new AntrianPoli());

        $this->reply = [
            'status' => true,
            'message' => 'Rekam Medis updated!',
            'data' => $rekamMedis
        ];
        return response()->json($this->reply, 200);
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
