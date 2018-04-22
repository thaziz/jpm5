<style type="text/css">
  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px; 
}

table, th, td {
    border: 1px solid black;
}

</style>


<table>
  <thead>
    <tr>
      <th> No.</th>
      <th> Nama Member</th>
      <th> Total Order</th>
      <th> Brutto</th>
      <th> Diskon</th>
      <th> Netto</th>
    </tr>
    <tr>
      <th>type</th>
      <th>qty</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
   @foreach ($data_awal as $index => $e) 
    <tr>
      <td>{{ $index+1 }}</td>
      <td>{{ $e->kode_customer }} - {{ $e->nama }}</td>
      <td align="center">{{ number_format($e->do,0,',','.') }}</td>
      <td align="right">{{ number_format($e->total,0,',','.') }}</td>
      <td align="right">{{ number_format($e->diskon,0,',','.') }}</td>
      <td align="right">{{ number_format($e->total_net,0,',','.') }}</td>
    </tr>
    <tr>
      <td>dokumen</td>
      <td>kilogram</td>
      <td>koli</td>
      <td>sepeda</td>
      <td>koran</td>
      <td>kargo</td>
    </tr>
   @endforeach
   <tr>
      <th colspan="2" height="23">Grand total</th>
      <th> {{ number_format($do ,0,',','.')}}</th>
      <th align="right"> {{ number_format($total,0,',','.') }} </th>  
      <th align="right"> {{ number_format($diskon,0,',','.') }} </th>  
      <th align="right"> {{ number_format($total_net,0,',','.') }}</th>  
    </tr>
  </tbody>
</table>
