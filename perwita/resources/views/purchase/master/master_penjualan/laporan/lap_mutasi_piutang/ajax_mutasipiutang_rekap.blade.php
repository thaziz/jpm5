
                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                       <tr>
                          <th align="center" rowspan="2" > No</th>
                          <th align="center" colspan="2"> Customer</th>
                          <th align="center" rowspan="2"> Saldo Awal</th>
                          <th align="center" colspan="2"> DEBET</th>
                          <th align="center" colspan="4"> Kota Tujuan</th>
                          <th align="center" rowspan="2"> Saldo Akir</th>
                          <th align="center" rowspan="2"> Sisa Uangmuka </th>
                      </tr> 
                      <tr>
                          <th>Kode</th>
                          <th>Nama</th>
                          <th>Piutang Baru</th>
                          <th>Nota Debet</th>
                          <th>Byr Cash</th>
                          <th>Byr.Cek/BG/Trans</th>
                          <th>Byr Uang Muka</th>
                          <th>Nota Kredit</th>
                      </tr>       
                    </thead>        
                    <tbody>
                     @foreach ($array as $index => $e)
                       <tr>
                         <td>{{ $array[$index]['customer'] }}</td>
                         {{-- <td>{{ $data[$index]-> }}</td> --}}
                       </tr>
                     @endforeach
                      
                    </tbody>       
                  </table>
                