<table id="table_data" class="table table-bordered table-striped table_data">
<thead>
    <tr>
        <th align="center">No</th>
        <th>Nomor Invoice</th>
        <th>Tgl Invoice</th>
        <th>Keterangan</th>
        <th>Harga Netto</th>
        <th>Sisa Bayar</th>
    </tr>
</thead>
<tbody>
    @foreach($data as $i=>$val)
    <tr onclick="pilih_invoice()">
        <td>{{$i+1}}</td>
        <td>
            {{$val->i_nomor}}
            <input type="hidden" class="i_nomor_invoice">
        </td>
        <td>{{$val->i_tanggal}}</td>
        <td>{{$val->i_keterangan}}</td>
        <td align="right">{{number_format($val->i_netto, 2, ",", ".")}}</td>
        <td align="right">{{number_format($val->i_sisa_pelunasan, 2, ",", ".")}}</td>
    </tr>
    @endforeach
</tbody>
</table>