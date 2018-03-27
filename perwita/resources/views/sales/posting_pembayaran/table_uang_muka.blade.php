<table id="table_data_d" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nomor Uang Muka</th>
            <th>Tanggal</th>
            <th style="width:20%">Jumlah</th>
            <th><input type="checkbox" onchange="check_parent()" class="parent_box" name=""></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $val)
            <tr>
                <td>
                    {{$val->nomor}}
                    <input type="hidden" class="kwitansi_modal" name="" value="{{$val->nomor}}">
                </td>
                <td>{{$val->tanggal}}</td>
                <td align="right">{{number_format($val->jumlah, 2, ",", ".")}}</td>
                <td align="center">
                    <input type="checkbox" class="tanda" name="tanda">
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