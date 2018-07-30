
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
                         <td>{{ $push_customer_lenght[$index][0]->kode }}</td>
                         <td>{{ $push_customer_lenght[$index][0]->nama }}</td>
                         <td><input type="hidden" value="{{ $saldoawal[$index][0]->saldoawal }}" class="saldoawal" name="">
                          {{ $saldoawal[$index][0]->saldoawal }}
                         </td>
                         <td><input type="hidden" value="{{ $piutangbaru[$index][0]->piutang_baru }}" class="piutangbaru" name="">
                          {{ $piutangbaru[$index][0]->piutang_baru }}
                         </td>
                         <td><input type="hidden" value="{{ $notadebet[$index][0]->nota_debet }}" class="notadebet" name="">
                          {{ $notadebet[$index][0]->nota_debet }}
                         </td>
                         <td><input type="hidden" value="{{ $cash[$index][0]->cash  }}" class="cash" name="">
                          {{ $cash[$index][0]->cash }}
                         </td>
                         <td><input type="hidden" value="{{ $cek_bg_trsn[$index][0]->cek_bg_trsn }}" class="cek_bg_trsn" name="">
                          {{ $cek_bg_trsn[$index][0]->cek_bg_trsn }}
                          </td>
                         <td><input type="hidden" value="{{ $uangmuka[$index][0]->uangmuka }}" class="uangmuka" name="">
                          {{ $uangmuka[$index][0]->uangmuka }}
                         </td>
                         <td><input type="hidden" value="{{ $nota_kredit[$index][0]->nota_kredit }}" class="nota_kredit" name="">
                          {{ $nota_kredit[$index][0]->nota_kredit }}
                          </td>
                         <td class="total"></td>
                         <td>{{ $sisa_uangmuka[$index][0]->sisa_uangmuka }}</td>
                       </tr>
                     @endforeach

                  </table>
                