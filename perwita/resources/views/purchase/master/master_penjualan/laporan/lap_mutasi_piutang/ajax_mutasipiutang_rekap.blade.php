
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
                         <td><input type="hidden" name="" class="fore">{{ $index+1 }}</td>
                        {{--  <td>{{ $saldoawal[$index]->saldo }}</td>
                         <td>{{ $saldoawal[$index]->saldo }}</td> --}}
                        {{--  <td><input type="hidden" value="{{ $saldoawal[$index][0]->saldoawal }}" class="saldoawal_{{ $index }}" name="">
                          {{ $saldoawal[$index][0]->saldoawal }}
                         </td>
                         <td><input type="hidden" value="{{ $piutangbaru[$index][0]->piutang_baru }}" class="piutangbaru_{{ $index }}" name="">
                          {{ $piutangbaru[$index][0]->piutang_baru }}
                         </td>
                         <td><input type="hidden" value="{{ $notadebet[$index][0]->nota_debet }}" class="notadebet_{{ $index }}" name="">
                          {{ $notadebet[$index][0]->nota_debet }}
                         </td>
                         <td><input type="hidden" value="{{ $cash[$index][0]->cash  }}" class="cash_{{ $index }}" name="">
                          {{ $cash[$index][0]->cash }}
                         </td>
                         <td><input type="hidden" value="{{ $cek_bg_trsn[$index][0]->cek_bg_trsn }}" class="cek_bg_trsn_{{ $index }}" name="">
                          {{ $cek_bg_trsn[$index][0]->cek_bg_trsn }}
                          </td>
                         <td><input type="hidden" value="{{ $uangmuka[$index][0]->uangmuka }}" class="uangmuka_{{ $index }}" name="">
                          {{ $uangmuka[$index][0]->uangmuka }}
                         </td>
                         <td><input type="hidden" value="{{ $nota_kredit[$index][0]->nota_kredit }}" class="nota_kredit_{{ $index }}" name="">
                          {{ $nota_kredit[$index][0]->nota_kredit }}
                          </td>
                         <td class="total_{{ $index }}"></td>
                         <td>{{ $sisa_uangmuka[$index][0]->sisa_uangmuka }}</td> --}}
                       </tr>
                     @endforeach

                  </table>
                