

<table class="table table-bordered datatable table-striped" id="bulan_rep">
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
    @foreach ($a as $index => $row)
        <tr>
           <td>{{ $index+1 }}</td>
           <td class="hit">{{ $row->customer }} - {{ $row->nama_cus }}</td>
              
              @if ( $a[$index]->januari != null)
                <td class=" jan" >{{ number_format($a[$index]->januari,0,'',',')  }}</td>
              @else
                <td class=" jan">0</td>
              @endif

              @if ( $a[$index]->februari != null)
                <td class="feb">{{  number_format($$a[$index]->februari,0,'',',')  }}</td>
              @else
                <td class="feb">0</td>
              @endif

              @if ( $a[$index]->maret != null)
                <td class="mar">{{  number_format($$a[$index]->maret,0,'',',')  }}</td>
              @else
                <td class="mar">0</td>
              @endif

              @if ( $a[$index]->april != null)
                <td class="april">{{  number_format($$a[$index]->april,0,'',',')  }}</td>
              @else
                <td class="april">0</td>
              @endif

              @if ( $a[$index]->mei != null)
                <td class="mei">{{  number_format($$a[$index]->mei,0,'',',')  }}</td>
              @else
                <td class="mei">0</td>
              @endif

              @if ( $a[$index]->juni != null)
                <td class="jun">{{  number_format($$a[$index]->juni,0,'',',')  }}</td>
              @else
                <td class="jun">0</td>
              @endif

              @if ( $a[$index]->juli != null)
                <td class="jul">{{  number_format($$a[$index]->juli,0,'',',')  }}</td>
              @else
                <td class="jul">0</td>
              @endif

              @if ( $a[$index]->agustus != null)
                <td class="aug">{{ number_format($ $a[$index]->agustus,0,'',',')  }}</td>
              @else
                <td class="aug">0</td>
              @endif

              @if ( $a[$index]->september != null)
                <td class="sep">{{  number_format($$a[$index]->september,0,'',',')  }}</td>
              @else
                <td class="sep">0</td>
              @endif

              @if ( $a[$index]->oktober != null)
                <td class="okt">{{  number_format($$a[$index]->oktober,0,'',',')  }}</td>
              @else
                <td class="okt">0</td>
              @endif

              @if ( $a[$index]->desember != null)
                <td class="nov">{{  number_format($$a[$index]->november,0,'',',')  }}</td>
              @else
                <td class="nov">0</td>
              @endif

              @if ( $a[$index]->desember != null)
                <td class="des">{{  number_format($$a[$index]->desember,0,'',',')  }}</td>
              @else
                <td class="des">0</td>
              @endif
           
                



        <td class="total_total"></td>
        </tr>
    @endforeach
    <tr> 
        <td colspan="12">total</td>     
        <td id="hasilakir"></td>
    </tr>
  </tbody>
</table>



<script type="text/javascript">
  
   




</script>
