
<style>
  .pembungkus{
    width: 1000px;
  }
  table {
    border-collapse: collapse;
}
  table,th,td{
    border :1px solid black;
  }
</style>

<div class=" pembungkus">
{{--   @if ()
    expr
  @endif --}}
           <table id="addColumn" width="100%" class="table table-bordered table-striped">
                    <thead>
                        <tr> 
                            <th> No.</th>
                            <th> No. CN/DN</th>
                            <th> No. Inv</th>
                            <th> Tanggal </th>
                            <th> tagihan invoice </th>
                            <th> debet </th>
                            <th> kredit </th>
                            <th> total </th>
                            <th> keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dat1 as $index=>$val)
                        <tr>
                          <td>{{ $index+1 }}</td>
                          <td>{{ $dat1[$index][0]->cd_nomor }}</td>
                          <td>{{ $dat1[$index][0]->cd_invoice }}</td>
                          <td>{{ $dat1[$index][0]->cd_tanggal }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->cd_tagihan_invoice,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->cd_debet,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->cd_kredit,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->cd_total,0,',','.') }}</td>
                          <td align="right">{{ $dat1[$index][0]->cd_keterangan }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                  </table>



</div>
<script type="text/javascript">
    window.print();
</script>
