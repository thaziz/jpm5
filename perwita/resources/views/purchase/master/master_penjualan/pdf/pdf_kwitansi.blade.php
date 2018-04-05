
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
                            <th> no.</th> 
                            <th> No Kwitansi</th>
                            <th> Tanggal </th>
                            <th> Customer </th>
                            <th> Ttl Bayar</th>
                            <th> Uang M(-) </th>
                            <th> Debet(+) </th>
                            <th> Kredit(-) </th>
                            <th> Netto </th>
                            <th> bank </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dat1 as $index=>$val)
                        <tr>
                          <td>{{ $index }}</td>
                          <td>{{ $dat1[$index][0]->k_nomor }}</td>
                          <td>{{ $dat1[$index][0]->k_tanggal }}</td>
                          <td>{{ $dat1[$index][0]->nama }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->k_jumlah,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->k_uang_muka,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->k_debet,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->k_kredit,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->k_netto,0,',','.') }}</td>
                          <td>{{ $dat1[$index][0]->k_nota_bank }}</td>
                        </tr>
                        @endforeach

                    </tbody>

                  </table>



</div>
<script type="text/javascript">
    window.print();
</script>
