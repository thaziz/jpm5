
@if($kontrak == 1)
<table class="table table-hover table-bordered table-striped tabel_tarif">
    <thead>
        <tr>
            <th>No Tarif</th>
            <th>Asal Tarif</th>
            <th>Tujuan Tarif</th>
            <th>Jenis Tarif</th>
            <th>Biaya Kontrak</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i=>$val)
        <tr onclick="pilih_kontrak(this)">
            <td>
                {{$val->kc_nomor}}
                <input type="hidden" value="{{$val->kcd_id}}" class="kcd_id">
                <input type="hidden" value="{{$val->kcd_dt}}" class="kcd_dt">
            </td>
            <td>
                {{$val->nama_asal}}
                <input type="hidden" value="{{$val->kcd_kota_asal}}" class="kcd_kota_asal">
            </td>
            <td>
                {{$val->nama_tujuan}}
                <input type="hidden" value="{{$val->kcd_kota_tujuan}}" class="kcd_kota_tujuan">
            </td>
            <td style="text-align: right">
                {{$val->jt_nama_tarif}}
                <input type="hidden" value="{{$val->kcd_jenis_tarif}}" class="kcd_jenis_tarif">
            </td>
            <td style="text-align: right">
                {{number_format($val->kcd_harga, 0, ",", ".")}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<table class="table table-bordered  table-hover table-striped tabel_tarif">
    <thead>
        <tr>
            <th>No Tarif</th>
            <th>Asal Tarif</th>
            <th>Tujuan Tarif</th>
            <th>Jenis Tarif</th>
            <th>Tarif Dasar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i=>$val)
        <tr onclick="pilih_tarif(this)">
            <td>
                {{$val->kode}}
                <input type="hidden" value="{{$val->kode}}" class="kode_tarif">
            </td>
            <td>
                {{$val->nama_asal}}
            </td>
            <td>
                {{$val->nama_tujuan}}
            </td>
            <td>
                {{$val->jt_nama_tarif}}
            </td>
            <td style="text-align: right">
                {{number_format($val->harga, 0, ",", ".")}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
<script type="text/javascript">
    $('.tabel_tarif').DataTable();
</script>