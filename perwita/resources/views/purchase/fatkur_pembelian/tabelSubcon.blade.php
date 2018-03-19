 <table id="table_data_do" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nomor DO</th>
            <th>Tgl Order</th>
            <th>Total DO</th>
            <th>Jenis Tarif</th>
            <th>Asal</th>
            <th>Tujuan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($fix as $i=> $val)
        <tr>
           <td>
            {{$fix[$i]['d_nomor']}}
            <input type="hidden" class="d_nomor_do" value="{{$fix[$i]['d_nomor']}}">
           </td>
           <td>{{$fix[$i]['d_nomor']}}</td>
        </tr>
        @endforeach
    </tbody>
</table>