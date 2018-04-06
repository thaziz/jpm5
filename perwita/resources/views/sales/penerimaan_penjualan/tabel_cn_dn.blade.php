<table class=" table_cn_dn table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nomor CN/DN</th>
            <th>Tanggal</th>
            <th>Jml Debit</th>
            <th>Jml Kredit</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $val)
        <tr>
            <td>{{$val->cd_nomor}}</td>
            <td>{{$val->cd_tanggal}}</td>
            @if($val->cd_jenis == 'K')
            <td align="right">
                {{number_format(0, 2, ",", ".")}}
                <input type="hidden" value="{{0}}" class="cd_debet">
            </td>
            <td align="right">
                {{number_format($val->cdd_dpp_akhir+$val->cdd_ppn_akhir-$val->cdd_pph_akhir, 2, ",", ".")}}
                <input type="hidden" value="{{$val->cdd_dpp_akhir+$val->cdd_ppn_akhir-$val->cdd_pph_akhir}}" class="cd_kredit">
            </td>
            @else
            <td align="right">
                {{number_format($val->cdd_dpp_akhir+$val->cdd_ppn_akhir-$val->cdd_pph_akhir, 2, ",", ".")}}
                <input type="hidden" value="{{$val->cdd_dpp_akhir+$val->cdd_ppn_akhir-$val->cdd_pph_akhir}}" class="cd_debet">
            </td>
            <td align="right">
                {{number_format(0, 2, ",", ".")}}
                <input type="hidden" value="{{0}}" class="cd_kredit">
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
<script type="text/javascript">
 var  table_cd = $('.table_cn_dn').DataTable({
        searching:false,
    });
</script>