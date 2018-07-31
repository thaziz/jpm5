
                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                       <tr>
                          <th align="center"> No</th>
                          <th align="center"> Customer</th>
                          <th align="center"> Saldo Awal</th>
                          <th align="center"> Terbayar</th>
                          <th align="center"> Sisa Saldo</th>
                          <th align="center"> Umur</th>
                          <th align="center"> Belum jatuh tempo </th>
                          <th align="center"> Umur 0 s/d 30 </th>
                          <th align="center"> Umur 31 s/d 60 </th>
                          <th align="center"> Umur 61 s/d 90 </th>
                          <th align="center"> Umur 91 s/d 120 </th>
                          <th align="center"> Umur 121 s/d 180 </th>
                          <th align="center"> Umur 181 s/d 360 </th>
                          <th align="center"> Lebih dari 360 </th>
                      </tr> 
                           
                    </thead>        
                    <tbody>
                     @foreach ($array as $index => $e)
                       <tr>
                         <td>{{ $index+1 }}</td>
                         <td>{{ $array[$index]['customer'] }}</td>
                         <td>{{ $saldo_push[$index][0]->saldoawal }}</td>
                         <td>{{ $ss[$index] }}</td>
                         <td>{{ $sisa_saldo[$index] }}</td>
                         <td></td>
                         <td>{{ $sebelum_jatuhtempo_push[$index][0]->sebelum_jatuhtempo }}</td>
                         <td>{{ $jatuhtempo_30_push[$index][0]->jatuhtempo_30 }}</td>
                         <td>{{ $jatuhtempo_60_push[$index][0]->jatuhtempo_60 }}</td>
                         <td>{{ $jatuhtempo_90_push[$index][0]->jatuhtempo_90 }}</td>
                         <td>{{ $jatuhtempo_120_push[$index][0]->jatuhtempo_120 }}</td>
                         <td>{{ $jatuhtempo_180_push[$index][0]->jatuhtempo_180 }}</td>
                         <td>{{ $jatuhtempo_360_push[$index][0]->jatuhtempo_360 }}</td>
                         <td>{{ $jatuhtempo_lebih360_push[$index][0]->jatuhtempo_lebih360 }}</td>
                       </tr>
                     @endforeach

                  </table>
                