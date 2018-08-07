 <table id="addColumn"  class="table table-bordered table-striped">
  <thead>
      <tr>
          <th> No.s</th>
          <th> No INV</th>
          <th> cabang </th>
          <th> total netto </th>
          <th> total diskon </th>
          <th> total Tag </th>
      </tr>
  </thead>
  <tbody>
    @foreach ($customer as $el)
      <tr>
        <th colspan="7">{{ $el->i_kode_customer }} - {{ $el->nama }}</th>
      </tr>
     @foreach ($data as $index => $element)
      @if ($el->i_kode_customer == $element->i_kode_customer)
         <tr>
             <td>{{ $index+1 }}</td>
             <td>{{ $element->i_nomor }}</td>
             <td>{{ $element->i_kode_cabang }}</td>
             <td>{{ $element->i_total  }}</td>
             <td>{{ $element->i_diskon2  }}</td>
             <td>{{ $element->i_total_tagihan  }}</td>
         </tr>
      @endif
     @endforeach
    @endforeach
  </tbody>
  <tr>
    <td colspan="7">Total net</td>
    <td id="total_grandtotal"></td>
  </tr>
</table>


  