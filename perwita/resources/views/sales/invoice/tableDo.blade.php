<table id="table_data_do" class="table table-bordered table-striped">
    <thead>
        <tr>
           <th>No</th>
           <th>Nomor Order</th>
           <th>Tgl Order</th>
           <th>Jumlah</th>
           <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i=>$val)
        <tr>
            <td>{{$i+1}}</td>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" name="">
            </td>
        </tr>
        @endforeach
    </tbody>
</table>