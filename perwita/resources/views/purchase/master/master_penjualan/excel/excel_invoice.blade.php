
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
         <table id="addColumn" class="table table-bordered table-striped" style="margin-left: 3%;">
                    <thead>
                        <tr>
                            <th> No Inv</th>
                            <th> Tanggal </th>
                            <th> Jatuh Tempo </th>
                            <th> Customer </th>
                            <th> Brutto </th>
                            <th> Diskon Do </th>
                            <th> Diskon Inv </th>
                            <th> PPN </th>
                            <th> PPH </th>
                            <th> Netto DPP </th>
                            <th> Netto detil</th>
                            <th> Total Tagihan </th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($cust as $element)
                        <tr>
                          <td colspan="12" style="background-color: #ccffd7;">{{  $element->i_kode_customer}} - {{  $element->cus}}</td>
                        </tr>
                      @foreach ($data as $index =>$e)
                        <tr>
                          @if ($e->i_kode_customer == $element->i_kode_customer)
                        <td><input type="hidden" value="{{ $e->i_nomor }}" name="nomor">{{ $e->i_nomor }}</td>
                        <td>{{ $e->i_tanggal }}</td>
                        <td>{{ $e->i_jatuh_tempo }}</td>
                        <td>{{ $e->i_kode_customer }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_total }}" class="total_brutto" name="">{{ number_format($e->i_total,0,',','.') }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_diskon1 }}" class="total_diskondo" name="">{{ number_format($e->i_diskon1,0,',','.') }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_diskon2 }}" class="total_diskoninv" name="">{{ number_format($e->i_diskon2,0,',','.') }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_ppnrp }}" class="total_ppn" name="">{{ number_format($e->i_ppnrp,0,',','.') }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_pajak_lain }}" class="total_pajak_lain" name="">{{ number_format($e->i_pajak_lain,0,',','.') }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_netto }}" class="total_netto" name="">{{ number_format($e->i_netto,0,',','.') }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_netto_detail }}" class="total_netto_detil" name="">{{ number_format($e->i_netto_detail,0,',','.') }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_total_tagihan }}" class="total_net" name=""> {{ number_format($e->i_total_tagihan,0,',','.') }}</td>
                        @endif
                        </tr>

                      @endforeach
                      
                    @endforeach
                      <tr align="right">
                        <th colspan="4">Total</th>
                        <td id="brutto_grandtotal">{{ number_format($total_0,0,'','.') }}</td>
                        <td id="diskondo_grandtotal">{{ number_format($total_1,0,'','.') }}</td>
                        <td id="diskoninv_grandtotal">{{ number_format($total_2,0,'','.') }}</td>
                        <td id="ppn_grandtotal">{{ number_format($total_3,0,'','.') }}</td>
                        <td id="pajaklain_grandtotal">{{ number_format($total_4,0,'','.') }}</td>
                        <td id="netto_grandtotal">{{ number_format($total_5,0,'','.') }}</td>
                        <td id="nettodetil_grandtotal">{{ number_format($total_6,0,'','.') }}</td>
                        <td id="total_grandtotal">{{number_format($total_7,0,'','.')  }}</td>
                      </tr>
                    </tbody>
                  </table>
                


</div>
<script type="text/javascript">
    // window.print();
   
</script>
