<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanKasir implements FromView
{

    protected $data;
    public function __construct(Collection $data)
    {
        $this->data = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $data = $this->data;
        $now = Carbon::now()->format('d/m/Y');
        return view('LaporanKasir', ['data' => $data, 'now' => $now]);
    }
}
