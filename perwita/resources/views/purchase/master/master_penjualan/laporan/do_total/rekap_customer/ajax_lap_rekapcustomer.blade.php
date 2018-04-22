
@if ($view == 'rekap')
<table class="table table-bordered datatable table-striped" id="table">
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
@else
<table class="table table-bordered datatable table-striped" id="table">
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
      <td>{{ number_format($e->do,0,',','.') }}</td>
      <td>{{ number_format($e->total,0,',','.') }}</td>
      <td>{{ number_format($e->diskon,0,',','.') }}</td>
      <td>{{ number_format($e->total_net,0,',','.') }}</td>
    </tr>
    @foreach ($doc as $index => $doc1)
    <tr>
      <td colspan="2">dokumen</td>
      <td>{{ $doc[$index]->kode_customer }}</td>
    </tr>
    @endforeach
    
    <tr>
      <td>kilogram</td>
    </tr>
    <tr>
      <td>koli</td>
    </tr>
    <tr>
      <td>sepeda</td>
    </tr> 
    <tr>
      <td>koran</td>
    </tr>
    <tr> 
      <td>kargo</td>
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
@endif