  
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
                     
                    @foreach ($customer as $in => $customer_)
                         <tr>
                           <td colspan="6">Customer : [{{ $customer[$in]->kode }}] {{ $customer[$in]->nama }}</td>
                         </tr>
                          <tr>

                                  <td >Saldo Awal :</td>
                                  <td colspan="5" align="right"><input type="hidden" value="0" class="saldo saldo_{{ $in }}" name="">
                                    {{ $saldo_ut[0]->saldo }}</td>
                  
                          </tr>
                          @for ($i = 0; $i <count($data) ; $i++)
                            @if ($customer[$in]->kode == $data[$i]->customer)
                              <tr>
                                @if ($data[$i]->kode)
                                  <td>{{ $data[$i]->kode }}</td>
                                @else
                                  <td>0</td>
                                @endif

                                @if ($data[$i]->tanggal)
                                  <td>{{ $data[$i]->tanggal }}</td>
                                @else
                                  <td>-</td>
                                @endif

                                @if ($data[$i]->keterangan)
                                  <td>{{ $data[$i]->keterangan }}</td>
                                @else
                                  <td>-</td>
                                @endif

                                @if ($data[$i]->flag == 'D')
                                  <td align="right">
                                    <input type="hidden" name="" value="{{ $data[$i]->nominal }}" class="debet debet_{{ $in }}">
                                    {{ $data[$i]->nominal }}
                                  </td>
                                  <td align="right">
                                    <input type="hidden" name="" value="0" class="kredit kredit_{{ $in }}">
                                    0
                                  </td>
                                @else
                                  <td align="right">
                                    <input type="hidden" name="" value="0" class="debet debet_{{ $in }}">
                                    0
                                  </td>
                                  <td align="right">
                                    <input type="hidden" name="" value="{{ $data[$i]->nominal }}" class="kredit kredit_{{ $in }}">
                                    {{ $data[$i]->nominal }}
                                  </td>
                                @endif

                                <td class="total">

                                </td>
                              
                              </tr>
                            @endif
                          @endfor
                          <tr>
                            <td colspan="5">Grand Total</td>
                            <td class="grand grand_{{ $in }}"></td>
                          </tr>
                     @endforeach
                     
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
                  