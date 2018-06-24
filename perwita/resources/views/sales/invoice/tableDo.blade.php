@if($jenis == 'KORAN')
<table id="table_data_do" class="table table-bordered table-striped">
    <thead>
        <tr>
           <th>No</th>
           <th>Nomor Order</th>
           <th>Tgl Order</th>
           <th>Nama Customer</th>
           <th>Keterangan</th>
           <th>Harga Netto</th>
           <th style="text-align: center;"><input type="checkbox" class="parent_check" onchange="check_parent()"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i=>$val)
        @if($val->id_nomor_do == null or $val->id_nomor_invoice == $id)
                <tr>
                    <td align="center">
                      {{ csrf_field() }}
                        {{$i+1}}
                        <input type="hidden" value="{{$val->dd_id}}" class="nomor_dt" >
                    </td>
                    <td>
                        {{$val->nomor}} -
                        {{$val->dd_nomor_dt}}
                        <input type="hidden" value="{{$val->dd_nomor}}" class="nomor_do" >
                    </td>
                    <td>{{$val->tanggal}}</td>
                    <td>{{$val->nama_customer}}</td>
                    <td>{{$val->dd_keterangan}}</td>
                    <td align="right">{{number_format($val->dd_total, 2, ",", ".")}}</td>
                    <td align="center">
                        <input class="tanda" type="checkbox"  >
                    </td>
                </tr>
        @endif
        @endforeach
    </tbody>
</table>
@elseif($jenis == 'PAKET')
<table id="table_data_do" class="table table-bordered table-striped">
    <thead>
        <tr>
           <th>No</th>
           <th>Nomor Order</th>
           <th>Tgl Order</th>
           <th>Nama Customer</th>
           <th>Keterangan</th>
           <th>Harga Netto</th>
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
                    <td>{{$val->nama_customer}}</td>
                    <td>{{$val->keterangan_tarif}}</td>
                    <td align="right"> {{number_format($val->total_net, 2, ",", ".")}}</td>
                    <td align="center">
                        <input class="tanda" type="checkbox"  name="tanda">
                    </td>
                </tr>
        @endif
        @endforeach
    </tbody>
</table>
@elseif($jenis == 'KARGO')
<table id="table_data_do" class="table table-bordered table-striped">
    <thead>
        <tr>
           <th>No</th>
           <th>Nomor Order</th>
           <th>Tgl Order</th>
           <th>Nama Customer</th>
           <th>Keterangan</th>
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
                    </td>
                    <td>
                        {{$val->nomor}}
                        <input type="hidden" value="{{$val->nomor}}" class="nomor_do" name="nomor_do">
                    </td>
                    <td>{{$val->tanggal}}</td>
                    <td>{{$val->nama_customer}}</td>
                    <td>{{$val->keterangan_tarif}}</td>
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