<table class="table riwayat table-bordered table-striped">
    <thead>
        <tr>
            <th>Nomor Kwitansi</th>
            <th>Tanggal</th>
            <th>Jml Bayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $val)
            <tr>
                <td>{{$val->k_nomor}}</td>
                <td>{{$val->k_tanggal}}</td>
                <td>
                    {{number_format($val->kd_total_bayar, 2, ",", ".")}}
                    <input type="hidden" value="{{$val->kd_total_bayar}}" class="kd_total_bayar">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script type="text/javascript">
    var table_riwayat = $('.riwayat').DataTable({
        searching:false,
    });
</script>