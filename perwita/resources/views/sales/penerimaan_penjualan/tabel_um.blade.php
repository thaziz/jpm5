<table id="tabel_um_modal" class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th>Nomor Uang Muka</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status Uang Muka</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $val)
        <tr onclick="pilih_um(this)">
            <td>
                {{$val->nomor}}
                <input type="hidden" value="{{$val->nomor}}" class="nomor_modal_um" name="">
            </td>
            <td>
                {{$val->tanggal}}
            </td>
            <td class="right">
                {{number_format($val->jumlah, 2, ",", ".")}}
            </td>
            <td class="center">
                {{$val->status_um}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $('#tabel_um_modal').DataTable();
</script>