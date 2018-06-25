  
                <table id="addColumn" class="table table-bordered table-striped" width="100%" >
                    <thead>
                        <tr>
                            <th width="10%"> Kode</th>
                            <th width="10%"> Tgl </th>
                            <th width="10%"> Keterangan </th>
                            <th width="10%"> Debet(+) </th>
                            <th width="10%"> Kredit(-) </th>
                            <th width="10%"> saldo </th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($data_i as $a => $element)
                         <tr>
                           <td colspan="6">{{ $data_i[$a]->i_kode_customer }}  - {{ $data_i[$a]->cnama }}</td>
                           <input type="hidden" name="" class="gege" value="{{ $data_i[$a]->i_kode_customer }}">
                         </tr>
                      @foreach ($data_saldo as $l => $el)
                        <tr>
                          @if ($data_saldo[$l]->i_kode_customer == $data_i[$a]->i_kode_customer)
                            <td colspan="5">Saldo Awal</td>
                            <td align="right"> {{ number_format($data_saldo[$l]->saldo,0,',','.') }}</td>
                          @endif
                        </tr>
                      @endforeach
                         @foreach ($data as $e => $element)
                        <tr style="text-align: right;background-color: #e6ffda;">
                              @if ($data_i[$a]->i_kode_customer == $data[$e]->cutomer)

                                      <td><input type="hidden" value="{{ $data[$e]->kode }}" name="nomor">{{ $data[$e]->kode }}</td>
                                      <td>{{ $data[$e]->tanggal }}</td>
                                      <td align="left">{{ $data[$e]->keterangan }}</td>
                                      <td align="right" > 
                                      @if ($data[$e]->flag == 'D' or substr($data[$e]->kode,0,3) == 'INV')
                                        {{ number_format($data[$e]->total,0,',','.') }}
                                        <input type="hidden" class="debet" value="{{ $data[$e]->total }}" name="">
                                      @else 
                                        0
                                        <input type="hidden" class="debet" value="0" name="">
                                      @endif
                                      </td>

                                      <td align="right"> 
                                      @if ($data[$e]->flag == 'K' or substr($data[$e]->kode,0,2) == 'KN' or substr($data[$e]->kode,0,3) == 'KWT' or substr($data[$e]->kode,0,3) == 'PST')
                                        <input type="hidden" class="kredit" value="{{ $data[$e]->total }}" name="">
                                        {{ number_format($data[$e]->total,0,',','.') }}
                                      @else 
                                        0
                                        <input type="hidden" class="kredit" value="0" name="">
                                      @endif
                                      </td>

                                      <td>
                                        <input type="text" name="" readonly="" class="saldo" style="text-align: right">
                                      </td>

                              @endif 
                        </tr>

                        @endforeach
                          <tr>
                            <td colspan="3">Total</td>
                            <td class="debet_perc" align="right"></td>
                            <td class="kredit_perc" align="right"></td>
                            <td class="total_perc" align="right"></td>
                          </tr>
                    @endforeach
                    <tr>
                          <th colspan="3" align="right">total</th>
                          <td><input type="text" id="total_debet_ajax" readonly="" name="" style="text-align: right;font-weight: bold;border: none;"></td>
                          <td><input type="text" id="total_kredit_ajax" readonly="" name="" style="text-align: right;font-weight: bold;border: none;"></td>
                          <td><input type="text" id="total_total_ajax" readonly="" name="" style="text-align: right;font-weight: bold;border: none;"></td>
                        </tr>
                    </tbody>

                  </table>
                   <script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>
                   <script src="{{ asset('assets/vendors/money/dist/jquery.maskMoney.js') }}"></script>
                   <script src="{{ asset('assets/vendors/accounting/accounting.min.js') }}"></script>
                   <script src="{{ asset('assets/vendors/jquery-ui/jquery-ui.min.js') }}"></script>
                  <script type="text/javascript">                                   
                  saldo = 0;
                  $('.debet').each(function(){
                    var par = $(this).parents('tr');
                    var kredit = $(par).find('.kredit').val();
                    var hasil = $(this).val() - kredit;
                    saldo += hasil;
                    console.log(saldo);
                    $(par).find('.saldo').val(accounting.formatMoney(saldo,"",0,'.',','));
                  })
                  $('#total_total_ajax').val(accounting.formatMoney(saldo,"",0,'.',','));
                  var awal = 0;
                    $('.debet').each(function(){
                    var total = parseInt($(this).val());
                    awal += total;
                    // console.log(awal);
                    });
                    $('#total_debet_ajax').val(accounting.formatMoney(awal,"",0,'.',','));

                  var kred = 0;
                    $('.kredit').each(function(){
                    var total = parseInt($(this).val());
                    kred += total;
                    // console.log(kred);
                  });
                  $('#total_kredit_ajax').val(accounting.formatMoney(kred,"",0,'.',','));
                  
                  </script>
