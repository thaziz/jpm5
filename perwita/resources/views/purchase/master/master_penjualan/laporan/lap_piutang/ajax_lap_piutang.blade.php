  
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
                      @foreach ($saldo_ut as $saldo_ut_)
                        <tr>
                          <td colspan="6" align="right">{{ $saldo_ut_->saldo }}</td>
                        </tr>
                      @endforeach
                     {{-- @foreach ($customer as $customer_)
                         
                         <tr>
                           <td>{{ $customer_->kode }}</td>
                         </tr>
                        

                     @endforeach --}}
                     @for ($i = 0; $i <count($data) ; $i++)
                          <tr>
                            @if (isset($data[$i]->kode))
                              <td>{{ $data[$i]->kode }}</td>
                            @else
                              <td>0</td>
                            @endif

                            @if (isset($data[$i]->keterangan))
                              <td>{{ $data[$i]->keterangan }}</td>
                            @else
                              <td>0</td>
                            @endif

                            
                          </tr>
                     @endfor
                       {{-- @foreach ($data as $i => $val)
                          <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $data[$i]['kode'] }}</td>
                          </tr>
                       @endforeach --}}

                     {{-- @foreach ($data as $index => $data_)
                       <tr>
                         
                       </tr>
                     @endforeach --}}
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
                  // saldo = 0;
                  // $('.debet').each(function(){
                  //   var par = $(this).parents('tr');
                  //   var kredit = $(par).find('.kredit').val();
                  //   var hasil = $(this).val() - kredit;
                  //   saldo += hasil;
                  //   console.log(saldo);
                  //   $(par).find('.saldo').val(accounting.formatMoney(saldo,"",0,'.',','));
                  // })
                  // $('#total_total_ajax').val(accounting.formatMoney(saldo,"",0,'.',','));
                  // var awal = 0;
                  //   $('.debet').each(function(){
                  //   var total = parseInt($(this).val());
                  //   awal += total;
                  //   // console.log(awal);
                  //   });
                  //   $('#total_debet_ajax').val(accounting.formatMoney(awal,"",0,'.',','));

                  // var kred = 0;
                  //   $('.kredit').each(function(){
                  //   var total = parseInt($(this).val());
                  //   kred += total;
                  //   // console.log(kred);
                  // });
                  // $('#total_kredit_ajax').val(accounting.formatMoney(kred,"",0,'.',','));
                  
                  </script>
