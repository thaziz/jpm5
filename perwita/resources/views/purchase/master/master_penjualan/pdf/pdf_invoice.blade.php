
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
                        <td align="right"><input type="hidden" value="{{ $e->i_netto+$e->i_ppnrp+$e->i_pajak_lain }}" class="total_netto" name="">{{ number_format($e->i_netto,0,',','.') }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_netto_detail }}" class="total_netto_detil" name="">{{ number_format($e->i_netto_detail,0,',','.') }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_total_tagihan }}" class="total_net" name=""> {{ number_format($e->i_total_tagihan,0,',','.') }}</td>
                        @endif
                        </tr>

                      @endforeach
                      
                    @endforeach
                      <tr align="right">
                        <th colspan="4">Total</th>
                        <td id="brutto_grandtotal"></td>
                        <td id="diskondo_grandtotal"></td>
                        <td id="diskoninv_grandtotal"></td>
                        <td id="ppn_grandtotal"></td>
                        <td id="pajaklain_grandtotal"></td>
                        <td id="netto_grandtotal"></td>
                        <td id="nettodetil_grandtotal"></td>
                        <td id="total_grandtotal"></td>
                      </tr>
                    </tbody>
                  </table>
                


</div>
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>

    <script src="{{ asset('assets/vendors/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/accounting/accounting.min.js') }}"></script>

<script type="text/javascript">
    // window.print();
    var total = 0;
    $('.total_net').each(function(){
        var parents_net = parseInt($(this).val());
        total += parents_net;
    });
    $('#total_grandtotal').text(accounting.formatMoney(total,"",0,'.',','));

    var brutto = 0;
    $('.total_brutto').each(function(){
        var parents_brutto = parseInt($(this).val());
        brutto += parents_brutto;
    });
    $('#brutto_grandtotal').text(accounting.formatMoney(brutto,"",0,'.',','));

    var netto = 0;
    $('.total_netto_detil').each(function(){
        var parents_netto = parseInt($(this).val());
        netto += parents_netto;
    }); 
    $('#netto_grandtotal').text(accounting.formatMoney(netto,"",0,'.',','));

    var netto_detil = 0;
    $('.total_netto').each(function(){
        var parents_netto_detil = parseInt($(this).val());
        netto_detil += parents_netto_detil;
    });
    $('#nettodetil_grandtotal').text(accounting.formatMoney(netto_detil,"",0,'.',','));

     var ppn = 0;
    $('.total_ppn').each(function(){
        var parents_ppn = parseInt($(this).val());
        ppn += parents_ppn;
    });
    $('#ppn_grandtotal').text(accounting.formatMoney(ppn,"",0,'.',','));

     var diskon_do = 0;
    $('.total_diskondo').each(function(){
        var parents_diskon_do = parseInt($(this).val());
        diskon_do += parents_diskon_do;
    });
    $('#diskondo_grandtotal').text(accounting.formatMoney(diskon_do,"",0,'.',','));

     var diskon_inv = 0;
    $('.total_diskoninv').each(function(){
        var parents_diskon_inv = parseInt($(this).val());
        diskon_inv += parents_diskon_inv;
    });
    $('#diskoninv_grandtotal').text(accounting.formatMoney(diskon_inv,"",0,'.',','));

     var pajak_lain = 0;
    $('.total_pajak_lain').each(function(){
        var parents_pajak_lain = parseInt($(this).val());
        pajak_lain += parents_pajak_lain;
    });
    $('#pajaklain_grandtotal').text(accounting.formatMoney(pajak_lain,"",0,'.',','));

</script>
