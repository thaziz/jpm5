<table id="table_cn_dn" class="table table-bordered table-striped">
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
        <tr>
            <td>
                {{$val->nomor}}
                <input type="hidden" value="{{$val->nomor}}" class="nomor_modal_um" name="">
            </td>
            <td>
                {{$val->tanggal}}
            </td>
            <td class="right">
                {{$val->jumlah}}
            </td>
            <td class="center">
                {{$val->status_um}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>