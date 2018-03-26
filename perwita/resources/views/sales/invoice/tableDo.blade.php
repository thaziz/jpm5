@if($jenis == 'KORAN')
<table id="table_data_do" class="table table-bordered table-striped">
    <thead>
        <tr>
           <th>No</th>
           <th>Nomor Order</th>
           <th>Tgl Order</th>
           <th>Harga Bruto</th>
           <th style="text-align: center;"><input type="checkbox" class="parent_check" onchange="check_parent()"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i=>$val)
        @if($val->id_nomor_do == null or $val->id_nomor_invoice == $id)
                <tr>
                    <td align="center">
                        {{$i+1}}
                        <input type="hidden" value="{{$val->dd_id}}" class="nomor_dt" name="id_dt">
                    </td>
                    <td>
                        {{$val->nomor}}
                        {{$val->id_nomor_invoice}}
                        <input type="hidden" value="{{$val->dd_nomor}}" class="nomor_do" name="nomor_do">
                    </td>
                    <td>{{$val->tanggal}}</td>
                    <td>{{$val->dd_total}}</td>
                    <td align="center">
                        <input class="tanda" type="checkbox"  name="tanda">
                    </td>
                </tr>
        @endif
        @endforeach
    </tbody>
</table>
@else
<table id="table_data_do" class="table table-bordered table-striped">
    <thead>
        <tr>
           <th>No</th>
           <th>Nomor Order</th>
           <th>Tgl Order</th>
           <th>Jumlah</th>
           <th style="text-align: center;"><input type="checkbox" class="parent_check" onchange="check_parent()"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i=>$val)
        @if($val->id_nomor_do == null or $val->id_nomor_invoice == $id)
                <tr>
                    <td align="center">
                        {{$i+1}}
                    </td>
                    <td>
                        {{$val->nomor}}
                        <input type="hidden" value="{{$val->nomor}}" class="nomor_do" name="nomor_do">
                    </td>
                    <td>{{$val->tanggal}}</td>
                    <td align="right"> {{number_format($val->total, 2, ",", ".")}}</td>
                    <td align="center">
                        <input class="tanda" type="checkbox"  name="tanda">
                    </td>
                </tr>
        @endif
        @endforeach
    </tbody>
</table>
@endif
<script type="text/javascript">
    var table_data_do = $('#table_data_do').DataTable({
        "ordering": false
    });
</script>