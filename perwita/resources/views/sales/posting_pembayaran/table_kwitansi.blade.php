<table id="table_data_d" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Kode Transaksi</th>
            <th>Tanggal</th>
            <th style="width:20%">Jumlah</th>
            <th><input type="checkbox" onchange="check_parent()" class="parent_box" name=""></th>
        </tr>
        </thead>
    <tbody>
            @foreach ($data as $i=> $val)
                <tr>
                    <td>
                        {{$val->k_nomor}}
                        <input type="hidden" class="kwitansi_modal" name="" value="{{$val->k_nomor}}">
                    </td>
                    <td>{{$val->k_tanggal}}</td>
                    <td align="right">{{number_format($val->k_netto, 2, ",", ".")}}</td>
                    <td align="center">
                        <input class="tanda" type="checkbox"  name="tanda">
                    </td>
                </tr>
            @endforeach
    </tbody>
</table>
<script type="text/javascript">
   var table_modal_d = $('#table_data_d').DataTable({
    ordering:false
   });
</script>