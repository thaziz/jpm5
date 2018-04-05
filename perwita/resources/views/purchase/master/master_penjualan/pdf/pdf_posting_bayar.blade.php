
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
                          <th>No</th>
                           <th> No Inv</th>
                            <th> Tanggal </th>
                            <th> Jatuh Tempo </th>
                            <th> Customer </th>
                            <th> Total </th>
                            <th> Diskon Do </th>
                            <th> Netto detil</th>
                            <th> Diskon Inv </th>
                            <th> Netto DPP </th>
                            <th> PPN </th>
                            <th> PPH </th>
                            <th> Total Tagihan </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dat1 as $index=>$val)
                        <tr>
                          <td>{{ $index }}</td>
                          <td>{{ $dat1[$index][0]->i_nomor }}</td>
                          <td>{{ $dat1[$index][0]->i_tanggal }}</td>
                          <td>{{ $dat1[$index][0]->i_jatuh_tempo }}</td>
                          <td>{{ $dat1[$index][0]->i_kode_customer }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->i_total,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->i_diskon1,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->i_netto,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->i_diskon2,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->i_netto_detail,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->i_ppnrp,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->i_pajak_lain,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->i_total_tagihan,0,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                  </table>



</div>
<script type="text/javascript">
    window.print();
</script>
