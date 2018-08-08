 <table id="addColumn"  class="table table-bordered table-striped">
  <thead>
      <tr>
          <th> No.</th>
          <th> No INV</th>
          <th> cabang </th>
          <th> total netto </th>
          <th> total Tag </th>
          <th> total diskon </th>
      </tr>
  </thead>
  <tbody>
     @foreach ($data as $index => $element)
         <tr>
             <td>{{ $index+1 }}</td>
             <td>{{ $element->i_nomor }}</td>
             <td>{{ $element->i_kode_cabang }}</td>
             <td>{{ $element->i_total  }}</td>
             <td>{{ $element->i_total_tagihan  }}</td>
             <td>{{ $element->i_diskon2  }}</td>
         </tr>
     @endforeach
  </tbody>
  <tr>
    <td colspan="8">Total net</td>
    <td id="total_grandtotal"></td>
  </tr>
</table>


  