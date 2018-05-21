

<table class="table table-bordered datatable table-striped" id="table">
  <thead>
    <tr>
      <th> No.</th>
      <th> Customer</th>
      <th> Jan</th>
      <th> Feb</th>
      <th> Mar</th>
      <th> Apr</th>
      <th> Mei</th>
      <th> Jun</th>
      <th> Jul</th>
      <th> Aug</th>
      <th> Sep</th>
      <th> Okt</th>
      <th> Des</th>
      <th> Total</th>
    </tr>
    @foreach ($a as $index => $an)
      <tr>
        <td>{{ $index }}</td>

        <td>kosong</td>
      
        @if ($a[1] == null)
        <td>0</td>
        @else
        <td>{{ $a[1][$index]->total_net }}</td>
        @endif
     
        @if ($a[2] == null)
        <td>0</td>
        @else
        <td>{{ $a[2][$index]->total_net }}</td>
        @endif
      
        @if ($a[3] == null)
        <td>0</td>
        @else
        <td>{{ $a[3][$index]->total_net }}</td>
        @endif
      
        @if ($a[4] == null)
        <td>0</td>
        @else
        <td>{{ $a[4][$index]->total_net }}</td>
        @endif
      
        @if ($a[5] == null)
        <td>0</td>
        @else
        <td>{{ $a[5][$index]->total_net }}</td>
        @endif
      
        @if ($a[6] == null)
        <td>0</td>
        @else
        <td>{{ $a[6][$index]->total_net }}</td>
        @endif
      
        @if ($a[7] == null)
        <td>0</td>
        @else
        <td>{{ $a[7][$index]->total_net }}</td>
        @endif
      
        @if ($a[8] == null)
        <td>0</td>
        @else
        <td>{{ $a[8][$index]->total_net }}</td>
        @endif
      
        @if ($a[9] == null)
        <td>0</td>
        @else
        <td>{{ $a[9][$index]->total_net }}</td>
        @endif
      
        @if ($a[10] == null)
        <td>0</td>
        @else
        <td>{{ $a[10][$index]->total_net }}</td>
        @endif
      
        @if ($a[11] == null)
        <td>0</td>
        @else
        <td>{{ $a[11][$index]->total_net }}</td>
        @endif
      <td>tot</td>
       </tr>
    @endforeach
    
    
  </thead>
  <tbody>
  
  </tbody>
</table>
