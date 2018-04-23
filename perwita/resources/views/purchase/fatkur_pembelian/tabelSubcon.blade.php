 <table id="table_data_do" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nomor DO</th>
            <th>Tgl Order</th>
            <th>Jenis</th>
            <th>Angkutan</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Asal</th>
            <th>Tujuan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i=> $val)
        <tr onclick="pilih_do_subcon(this)">
           <td>
            {{$val->nomor}}
            <input type="hidden" class="d_nomor_do" value="{{$val->nomor}}">
           </td>
           <td>
            {{carbon\carbon::parse($val->tanggal)->format('d/m/Y')}}
            <input type="hidden" class="d_tanggal" value="{{carbon\carbon::parse($val->tanggal)->format('d/m/Y')}}">
           </td>
           <td>
            <p class="d_jenis_tarif_text">{{$val->nama_tarif}}</p>
            <input type="hidden" class="d_jenis_tarif" value="{{$val->jenis_tarif}}">
           </td>
           <td>
           <p class="d_tipe_angkutan_text"> {{$val->nama_angkutan}}</p>
            <input type="hidden" class="d_tipe_angkutan" value="{{$val->kode_tipe_angkutan}}">
           </td>
           <td>
            {{$val->jumlah}}
            <input type="hidden" class="d_jumlah" value="{{$val->jumlah}}">
           </td>
           <td>
            {{$val->kode_satuan}}
            <input type="hidden" class="d_satuan" value="{{$val->kode_satuan}}">
           </td>
           <td>
            <p class="d_asal_text">{{$val->nama_asal}}</p>
            <input type="hidden" class="d_asal" value="{{$val->id_kota_asal}}">
           </td>
           <td>
            <p class="d_tujuan_text">{{$val->nama_tujuan}}</p>
            <input type="hidden" class="d_tujuan" value="{{$val->id_kota_tujuan}}">
           </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    var table_data_do = $('#table_data_do').DataTable();
</script>