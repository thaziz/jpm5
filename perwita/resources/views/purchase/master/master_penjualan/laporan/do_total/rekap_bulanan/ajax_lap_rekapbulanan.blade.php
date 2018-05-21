

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
  </thead>
  <tbody>
    
         
    
    @foreach ($cust as $itcus => $cus)
        <tr>
           <td>{{ $itcus+1 }}</td>
           <td>{{ $cus->kode }} - {{ $cus->nama }}</td>

        {{-- jan --}}
        @if (count($a[1]) > 0)
            @for ($i = 0; $i <count($a[1]) ; $i++)
                @if ($a[1][$i]->kode_customer == $cus->kode)
                  <td>{{ $a[1][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td>0</td>
        @endif  
        

        {{-- feb --}}
        @if (count($a[2]) > 0)
            @for ($i = 0; $i <count($a[2]) ; $i++)
                @if ($a[2][$i]->kode_customer == $cus->kode)
                  <td>{{ $a[2][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td>0</td>
        @endif

        {{-- mar --}}
        @if (count($a[3]) > 0)
            @for ($i = 0; $i <count($a[3]) ; $i++)
                @if ($a[3][$i]->kode_customer == $cus->kode)
                  <td>{{ $a[3][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td>0</td>
        @endif

        {{-- apr --}}
         
            @for ($i = 0; $i <count($a[4]) ; $i++)
                @if ($a[4][$i]->kode_customer == $cus->kode)
                    <td>{{ $a[4][$i]->total_net }}</td>
                @endif
            @endfor
     

        {{-- mei --}}
        @if (count($a[5]) > 0)
            @for ($i = 0; $i <count($a[5]) ; $i++)
                @if ($a[5][$i]->kode_customer == $cus->kode)
                  <td>{{ $a[5][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td>0</td>
        @endif

        {{-- jun --}}
        @if (count($a[6]) > 0)
            @for ($i = 0; $i <count($a[6]) ; $i++)
                @if ($a[6][$i]->kode_customer == $cus->kode)
                  <td>{{ $a[6][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td>0</td>
        @endif

        {{-- aug --}}
        @if (count($a[7]) > 0)
            @for ($i = 0; $i <count($a[7]) ; $i++)
                @if ($a[7][$i]->kode_customer == $cus->kode)
                  <td>{{ $a[7][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td>0</td>
        @endif

        {{-- sep --}}
        @if (count($a[8]) > 0)
            @for ($i = 0; $i <count($a[8]) ; $i++)
                @if ($a[8][$i]->kode_customer == $cus->kode)
                  <td>{{ $a[8][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td>0</td>
        @endif

        {{-- okt --}}
        @if (count($a[9]) > 0)
            @for ($i = 0; $i <count($a[9]) ; $i++)
                @if ($a[9][$i]->kode_customer == $cus->kode)
                  <td>{{ $a[9][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td>0</td>
        @endif

        {{-- nov --}}
        @if (count($a[10]) > 0)
            @for ($i = 0; $i <count($a[10]) ; $i++)
                @if ($a[10][$i]->kode_customer == $cus->kode)
                  <td>{{ $a[10][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td>0</td>
        @endif

        {{-- des --}}
        @if (count($a[11]) > 0)
            @for ($i = 0; $i <count($a[11]) ; $i++)
                @if ($a[11][$i]->kode_customer == $cus->kode)
                  <td>{{ $a[11][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td>0</td>
        @endif
          
          <td>1</td>
        </tr>
    @endforeach
    
      
    
  </tbody>
</table>
