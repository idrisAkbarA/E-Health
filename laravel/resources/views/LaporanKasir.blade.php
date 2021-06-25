<table style="width:100%">
    <thead>
        <tr>
            <th style="height: 70px; font-weight: bold; font-size:20px" colspan="7">

                Laporan Kasir

                <br>

            </th>
        </tr>
        <tr>
            <th colspan="7">
                <span style="font-weight: bold; font-size:12px !imporrtant">
                    Tanggal laporan dibuat: {{ $now }}
                </span>
            </th>
        </tr>
        <tr></tr>
        <tr>
            <th style="font-weight: bold; padding:20px !important">#</th>
            <th style="font-weight: bold; padding:20px !important">Nama</th>
            <th style="font-weight: bold; padding:20px !important">Poli</th>
            <th style="font-weight: bold; padding:20px !important">Status Pembayaran</th>
            <th style="font-weight: bold; padding:20px !important">Tanggal Dibuat</th>
        </tr>
    </thead>

    @foreach ($data as $key => $item)
        <tr>
            <td style="text-align: left; padding:20px !important">{{ $key + 1 }}</td>
            <td style="width:30px">{{ $item['pasien']['nama'] }}</td>
            <td>{{ $item['nama_poli'] }}</td>
            <td style="width:30px">{{ $item['is_bayar'] ? 'Sudah Bayar' : 'Belum Bayar' }}</td>
            <td style="width:30px">{{ \Carbon\Carbon::parse($item['created_at']) }}</td>
            {{-- <td>
              <v-chip
                v-if="data.is_bayar"
                class="black--text"
                color="success"
              >{{data.is_bayar?"Sudah Bayar":"Belum Bayar"}}</v-chip>
              <v-chip
                v-else
                class="black--text"
                color="secondary"
              >{{data.is_bayar?"Sudah Bayar":"Belum Bayar"}}</v-chip>
            </td>
            <td>{{$moment(data.created_at).format("Do MMMM YYYY","id")}}</td> --}}
        </tr>

    @endforeach
</table>
