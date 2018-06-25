<table class="table table-bordered datatable table-striped" id="table" width="900px">
  <thead>
    <tr>
      <th> No</th>
      <th> Cabang</th>
      <th> Jum DO</th>
      <th> Total Net DO</th>
      
    </tr>
  </thead>
  <tbody>
    @foreach ( $data  as $index => $element)
        
        <tr>  
          <td> {{ $index+1 }} </td>
          <td> {{ $element->nama }} - {{ $element->kode_cabang }} </td>
          <td align="right"> {{number_format($element->total,0,',','.')  }} </td>
          <td align="right"> {{number_format($element->sum,0,',','.')  }} </td>
        </tr>
        
    @endforeach  

    <tr>
      <td colspan="2" align="center">Total</td>
      <td align="right">{{number_format( $tot_hit,0,',','.') }}</td>
      <td align="right">{{number_format( $tot,0,',','.') }}</td>
    </tr>
  </tbody>
</table>
