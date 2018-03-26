<table id="table_data_d" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nomor Kwitansi</th>
            <th>Tanggal</th>
            <th style="width:20%">Jumlah</th>
            <th><input type="checkbox" class="parent_box" name=""></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $val)
            <tr>
                <td>
                    {{$val->k_nomor}}
                    <input type="hidden" class="kwitansi_modal" name="" value="{{$val->k_nomor}}">
                </td>
                <td>{{$val->k_tanggal}}</td>
                <td>{{$val->k_netto}}</td>
                <td><input type="checkbox" class="child_box" name=""></td>
            </tr>
        @endforeach
    </tbody>
</table>

<script type="text/javascript">
    $('#tabe_data_id').DataTable();
</script>