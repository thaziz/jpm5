 <table id="addColumn"  class="table table-bordered table-striped">
  <thead>
      <tr>
          <th> No DO</th>
          <th> cabang </th>
          <th> total Tag </th>
          <th> total diskon </th>
          <th> total netto </th>
          <th> Jarak TT </th>
        </tr>
  </thead>
  <tbody>
     @foreach ($data as $index => $element)
         <tr>
             <td>{{ $index+1 }}</td>
             <td>{{ $element->i_kode_cabang }}</td>
             <td>{{ $element->i_total_tagihan  }}</td>
             <td>{{ $element->i_diskon  }}</td>
             <td>{{ $element->i_netto  }}</td>
             <td>{{ $element->tgl  }} Hari  {{ $element->bln }} Bulan {{ $element->yr }} Tahun</td>
         </tr>
     @endforeach
  </tbody>
  <tr>
    <td colspan="7">Total net</td>
    <td id="total_grandtotal"></td>
  </tr>
</table>


  