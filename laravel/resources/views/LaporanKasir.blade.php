<table style="width:100%">
    <tr>
        <th style="height: 70px; font-weight: bold; font-size:20px" colspan="7">

            Laporan Kasir

            <br>
            Tanggal laporan dibuat: {{ $now }}
        </th>
    </tr>
    <tr></tr>
    <tr>
        <th style="font-weight: bold">Nama</th>
        <th style="font-weight: bold">Poli</th>
        <th style="font-weight: bold">Status Pembayaran</th>
        <th style="font-weight: bold">Tanggal Dibuat</th>
    </tr>
    @foreach ($data as $item)
        <tr>

            <td>Jill</td>
            <td>Smith</td>
            <td>50</td>
        </tr>
    @endforeach
</table>
