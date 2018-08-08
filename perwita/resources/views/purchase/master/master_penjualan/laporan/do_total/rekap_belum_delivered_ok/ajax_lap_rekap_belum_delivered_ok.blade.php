<table class="table table-bordered datatable table-striped" id="table">
  <thead>
    <tr>
      <th> No.</th>
      <th> Nama Member</th>
      <th> Do</th>
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
      <th style="text-align: right;"> {{ number_format($e->do,0,',','.') }}</th>  
      <th style="text-align: right;"> {{ number_format($e->total,0,',','.')}}</th>
      <th style="text-align: right;"> {{ number_format($e->diskon,0,',','.') }} </th>  
      <th style="text-align: right;"> {{ number_format($e->total_net,0,',','.') }} </th>  
    </tr>

   @endforeach
   <tr>
      <th colspan="2">Grand total</th>
      <th style="text-align: right;"> {{ number_format($do,0,',','.') }}</th>  
      <th style="text-align: right;"> {{ number_format($total,0,',','.')}}</th>
      <th style="text-align: right;"> {{ number_format($diskon,0,',','.') }} </th>  
      <th style="text-align: right;"> {{ number_format($total_net,0,',','.') }} </th>  
    </tr>
  </tbody>
</table>
