

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
      <th> Nov  </th>
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
                  <td class="jan">{{ $a[1][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td class="jan">1</td>
        @endif  
        

        {{-- feb --}}
        @if (count($a[2]) > 0)
            @for ($i = 0; $i <count($a[2]) ; $i++)
                @if ($a[2][$i]->kode_customer == $cus->kode)
                  <td class="feb">{{ $a[2][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td class="feb">2</td>
        @endif

        {{-- mar --}}
        @if (count($a[3]) > 0)
            @for ($i = 0; $i <count($a[3]) ; $i++)
                @if ($a[3][$i]->kode_customer == $cus->kode)
                  <td class="mar">{{ $a[3][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td class="mar">3</td>
        @endif

        {{-- apr --}}
        
        @if (count($a[4]) > 0)
            @for ($i = 0; $i <count($a[4]) ; $i++)
                @if ($a[4][$i]->kode_customer == $cus->kode)
                    <td class="apr">rtu</td>
                @endif
            @endfor
        @else

                  <td class="apr">4</td>
        @endif

        {{-- mei --}}
        @if (count($a[5]) > 0)
            @for ($i = 0; $i <count($a[5]) ; $i++)
                @if ($a[5][$i]->kode_customer == $cus->kode)
                  <td class="mei">{{ $a[5][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td class="mei">5</td>
        @endif

        {{-- jun --}}
        @if (count($a[6]) > 0)
            @for ($i = 0; $i <count($a[6]) ; $i++)
                @if ($a[6][$i]->kode_customer == $cus->kode)
                  <td class="jun">{{ $a[6][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td class="jun">6</td>
        @endif

        {{-- aug --}}
        @if (count($a[7]) > 0)
            @for ($i = 0; $i <count($a[7]) ; $i++)
                @if ($a[7][$i]->kode_customer == $cus->kode)
                  <td class="jul">{{ $a[7][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td class="jul">7</td>
        @endif

        {{-- sep --}}
        @if (count($a[8]) > 0)
            @for ($i = 0; $i <count($a[8]) ; $i++)
                @if ($a[8][$i]->kode_customer == $cus->kode)
                  <td class="aug">{{ $a[8][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td class="aug">8</td>
        @endif

        {{-- okt --}}
        @if (count($a[9]) > 0)
            @for ($i = 0; $i <count($a[9]) ; $i++)
                @if ($a[9][$i]->kode_customer == $cus->kode)
                  <td class="sep">{{ $a[9][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td class="sep">9</td>
        @endif

        {{-- nov --}}
        @if (count($a[10]) > 0)
            @for ($i = 0; $i <count($a[10]) ; $i++)
                @if ($a[10][$i]->kode_customer == $cus->kode)
                  <td class="okt">{{ $a[10][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td class="okt">10</td>
        @endif

        {{-- des --}}
        @if (count($a[11]) > 0)
            @for ($i = 0; $i <count($a[11]) ; $i++)
                @if ($a[11][$i]->kode_customer == $cus->kode)
                  <td class="nov">{{ $a[11][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td class="nov">11</td>
        @endif
          
        @if (count($a[12]) > 0)
            @for ($i = 0; $i <count($a[12]) ; $i++)
                @if ($a[12][$i]->kode_customer == $cus->kode)
                  <td class="des">{{ $a[12][$i]->total_net }}</td>  
                @endif
            @endfor
        @else
                  <td class="des">12</td>
        @endif

        <td id="total_total"></td>
        </tr>
    @endforeach
    
      
    
  </tbody>
</table>

    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>

<script type="text/javascript">
  
   




</script>
