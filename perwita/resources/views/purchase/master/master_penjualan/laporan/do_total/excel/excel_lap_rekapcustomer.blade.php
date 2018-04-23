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
  </thead>
  <tbody>
   @foreach ($data_awal as $index => $e) 
    <tr>
      <td>{{ $index+1 }}</td>
      <td>{{ $e->kode_customer }} - {{ $e->nama }}</td>
      <td>{{ number_format($e->do,0,',','.') }}</td>
      <td>{{ number_format($e->total,0,',','.') }}</td>
      <td>{{ number_format($e->diskon,0,',','.') }}</td>
      <td>{{ number_format($e->total_net,0,',','.') }}</td>
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