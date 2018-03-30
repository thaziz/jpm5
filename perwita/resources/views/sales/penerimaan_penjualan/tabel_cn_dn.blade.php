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
            <td align="right">
                {{number_format($val->cd_debet, 2, ",", ".")}}
                <input type="hidden" value="{{$val->cd_debet}}" class="cd_debet">
            </td>
            <td align="right">
                {{number_format($val->cd_kredit, 2, ",", ".")}}
                <input type="hidden" value="{{$val->cd_kredit}}" class="cd_kredit">
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script type="text/javascript">
 var  table_cd = $('.table_cn_dn').DataTable({
        searching:false,
    });
</script>