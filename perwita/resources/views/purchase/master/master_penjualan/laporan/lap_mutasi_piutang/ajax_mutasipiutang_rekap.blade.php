
                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                       <tr>
                          <th align="center" rowspan="2" > No</th>
                          <th align="center" colspan="2"> Customer</th>
                          <th align="center" rowspan="2"> Saldo Awal</th>
                          <th align="center" colspan="2"> DEBET</th>
                          <th align="center" colspan="4"> KREDIT</th>
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
                         <td>{{ $index+1 }}</td>
                         <td>{{ $customer_lenght[$index]->kode }}</td>
                         <td>{{ $customer_lenght[$index]->nama }}</td>
                         <td>{{ $saldoawal[$index][0]->saldoawal }}</td>
                         <td>{{ $piutangbaru[$index][0]->piutang_baru }}</td>
                         <td>{{ $notadebet[$index][0]->nota_debet }}</td>
                         <td>{{ $cash[$index][0]->cash }}</td>
                         <td>{{ $cek_bg_trsn[$index][0]->cek_bg_trsn }}</td>
                         <td>{{ $uangmuka[$index][0]->uangmuka }}</td>
                         <td>{{ $nota_kredit[$index][0]->nota_kredit }}</td>
                         <td class="total">1</td>
                         <td>{{ $sisa_uangmuka[$index][0]->sisa_uangmuka }}</td>
                       </tr>
                     @endforeach

                  </table>
                