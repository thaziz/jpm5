    <table class="table table-bordered  table-hover table-striped tabel_tarif">
    <thead>
        <tr>
            <th>No Kontrak</th>
            <th>Asal</th>
            <th>Tujuan</th>
            <th>Tarif Dasar</th>
            <th>Satuan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cari_kontrak as $i=>$val)
        <tr onclick="pilih_kontrak(this)">
            <td>
                {{$val->kc_nomor}}
                <input type="hidden" value="{{$val->kc_nomor}}" class="kc_nomor">
            </td>
            <td>
                {{$val->nama_asal}}
                <input type="hidden" value="{{$val->kcd_kota_asal}}" class="kcd_kota_asal">
                <input type="hidden" value="{{$val->kcd_dt}}" class="kcd_dt_m">
                <input type="hidden" value="{{$val->kcd_acc_penjualan}}" class="acc_kontrak">
                <input type="hidden" value="{{$val->kcd_csf_penjualan}}" class="csf_kontrak">
                <input type="hidden" value="{{$val->acc_piutang}}" class="acc_kontrak_piutang">
                <input type="hidden" value="{{$val->csf_piutang}}" class="csf_kontrak_piutang">
                <input type="hidden" value="{{$val->kcd_keterangan}}" class="kcd_keterangan">
            </td>
            <td>
                {{$val->nama_tujuan}}
                <input type="hidden" value="{{$val->kcd_kota_tujuan}}" class="kcd_kota_tujuan">
            </td>
            <td style="text-align: right">
                {{number_format($val->kcd_harga, 0, ",", ".")}}
                <input type="hidden" value="{{$val->kcd_harga}}" class="kcd_harga">
            </td>
            <td style="text-align: center">
                {{$val->kcd_kode_satuan}}
                <input type="hidden" value="{{$val->kcd_kode_satuan}}" class="kcd_kode_satuan">
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script type="text/javascript">
    $('.tabel_tarif').DataTable();
</script>