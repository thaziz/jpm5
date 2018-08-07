 <table id="addColumn"  class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th> No DO</th>
                            <th> cabang </th>
                            <th> total In </th>
                            <th> total Tag </th>
                            <th> total diskon </th>
                            <th> total netto </th>
                            <th> total dpp </th>
                            <th> total ppn </th>
                            
                          
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($data as $index => $element)
                           <tr>
                               <td>{{ $index+1 }}</td>
                               <td>{{ $element->i_kode_cabang }}</td>
                               <td>{{ $element->total_nomor }}</td>
                               <td>{{ $element->total_tagihan  }}</td>
                               <td>{{ $element->diskon  }}</td>
                               <td>{{ $element->netto  }}</td>
                               <td>{{ $element->dpp  }}</td>
                               <td>{{ $element->ppn  }}</td>
                           </tr>
                       @endforeach
                    </tbody>
                    <tr>
                      <td colspan="8">Total net</td>
                      <td id="total_grandtotal"></td>
                    </tr>
                  </table>


  