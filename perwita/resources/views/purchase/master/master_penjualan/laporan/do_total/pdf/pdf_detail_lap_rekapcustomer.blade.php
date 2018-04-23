
<style type="text/css">
      @media screen, print {
      table{
        width: 900px;
        border-collapse: collapse;
        font-size: 13px; 
      }
       

    table, th, td {
        border: 1px solid black;
    }
}

</style>
<table class="table table-bordered datatable table-striped" id="table" >
  <thead>
    <tr>
      <th> No.</th>
      <th> Nama Member</th>
      <th> Total Order</th>
      <th> Brutto</th>
      <th> Diskon</th>
      <th> Netto</th>
    </tr>
    
  </thead>
  <tbody>
   @foreach ($data_awal as $index => $e) 
    <tr style="background-color: #aeff87;">
      <td>{{ $index+1 }}</td>
      <td>{{ $e->kode_customer }} - {{ $e->nama }}</td>
      <td style="text-align: right;">{{ number_format($e->do,0,',','.') }}</td>
      <td style="text-align: right;">{{ number_format($e->total,0,',','.') }}</td>
      <td style="text-align: right;">{{ number_format($e->diskon,0,',','.') }}</td>
      <td style="text-align: right;">{{ number_format($e->total_net,0,',','.') }}</td>
    </tr>
    <tr style="background-color: #c3ffa6;">
      <th colspan="2" style="text-align: center;">type</th>
      <th style="text-align: center;">qty</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
    </tr>
    <tr style="text-align: right;background-color: #e6ffda;">
      @foreach ($doc as $a => $element)
        @if ($e->kode_customer == $doc[$a]->kode_customer)
              <td style="text-align: left;" colspan="2">dokumen</td>
              <td>{{ number_format($doc[$a]->do,0,',','.') }}</td>
              <td>{{ number_format($doc[$a]->total,0,',','.') }}</td>
              <td>{{ number_format($doc[$a]->diskon,0,',','.') }}</td>
              <td>{{ number_format($doc[$a]->total_net,0,',','.') }}</td>
        @endif
      @endforeach
    </tr>
    
    <tr style="text-align: right;background-color: #e6ffda;" >
      @foreach ($kilo as $b => $element)
        @if ($e->kode_customer == $kilo[$b]->kode_customer)
              <td  style="text-align: left;" colspan="2">Kilogram</td>
              <td>{{ number_format($kilo[$b]->do,0,',','.') }}</td>
              <td>{{ number_format($kilo[$b]->total,0,',','.') }}</td>
              <td>{{ number_format($kilo[$b]->diskon,0,',','.') }}</td>
              <td>{{ number_format($kilo[$b]->total_net,0,',','.') }}</td>
        @endif
      @endforeach
    </tr>
    <tr style="text-align: right;background-color: #e6ffda;">
      @foreach ($koli as $c => $element)
        @if ($e->kode_customer == $koli[$c]->kode_customer)
              <td style="text-align: left;" colspan="2">Koli</td>
              <td>{{ number_format($koli[$c]->do,0,',','.') }}</td>
              <td>{{ number_format($koli[$c]->total,0,',','.') }}</td>
              <td>{{ number_format($koli[$c]->diskon,0,',','.') }}</td>
              <td>{{ number_format($koli[$c]->total_net,0,',','.') }}</td>
        @endif
      @endforeach
    </tr>
    <tr style="text-align: right;background-color: #e6ffda;">
      @foreach ($sepeda as $d => $element)
        @if ($e->kode_customer == $sepeda[$d]->kode_customer)
              <td style="text-align: left;" colspan="2">Sepeda</td>
              <td>{{ number_format($sepeda[$d]->do,0,',','.') }}</td>
              <td>{{ number_format($sepeda[$d]->total,0,',','.') }}</td>
              <td>{{ number_format($sepeda[$d]->diskon,0,',','.') }}</td>
              <td>{{ number_format($sepeda[$d]->total_net,0,',','.') }}</td>
        @endif
      @endforeach
    </tr> 
    <tr style="text-align: right;background-color: #e6ffda;">
      @foreach ($koran as $f => $element)
        @if ($e->kode_customer == $koran[$f]->kode_customer)
              <td style="text-align: left;" colspan="2">Koran</td>
              <td>{{ number_format($koran[$f]->do,0,',','.') }}</td>
              <td>{{ number_format($koran[$f]->total,0,',','.') }}</td>
              <td>{{ number_format($koran[$f]->diskon,0,',','.') }}</td>
              <td>{{ number_format($koran[$f]->total_net,0,',','.') }}</td>
        @endif
      @endforeach
    </tr>
    <tr style="text-align: right;background-color: #e6ffda;" > 
      @foreach ($kargo as $g => $element)
        @if ($e->kode_customer == $kargo[$g]->kode_customer)
              <td  style="text-align: left;" colspan="2">Kargo</td>
              <td>{{ number_format($kargo[$g]->do,0,',','.') }}</td>
              <td>{{ number_format($kargo[$g]->total,0,',','.') }}</td>
              <td>{{ number_format($kargo[$g]->diskon,0,',','.') }}</td>
              <td>{{ number_format($kargo[$g]->total_net,0,',','.') }}</td>
        @endif
      @endforeach
    </tr>
    <tr style="background-color: #ffe0e0;">
      <th colspan="3" style="text-align: right;">Total</th>
      <th style="text-align: right;">{{ number_format($e->total,0,',','.') }}</th>
      <th style="text-align: right;">{{ number_format($e->diskon,0,',','.') }}</th>
      <th style="text-align: right;">{{ number_format($e->total_net,0,',','.') }}</th> 
    </tr>
   @endforeach
   <tr>
      <th colspan="2">Grand total</th>
      <th> {{ number_format($do ,0,',','.')}}</th>
      <th> {{ number_format($total,0,',','.') }} </th>  
      <th> {{ number_format($diskon,0,',','.') }} </th>  
      <th> {{ number_format($total_net,0,',','.') }}</th>  
    </tr>
  </tbody>
</table>
