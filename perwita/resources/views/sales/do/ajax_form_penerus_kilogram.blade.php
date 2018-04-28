<div id="modal" class="modal" >
                  <div class="modal-dialog modal-lg ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insert Edit Tarif Cabang Kilogram</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal kirim">
                          <table class="table table-striped table-bordered table-hover ">
                            <tbody>
                                <tr>
                                    {{-- <td style="width:120px; padding-top: 0.4cm">Kode</td> --}}
                                    <td colspan="3">
                                        {{-- <input type="text" name="ed_kode" class="form-control a" style="text-transform: uppercase" > --}}
                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                        <input type="hidden" name="ed_kode_old" class="form-control" >
                                        <input type="hidden" class="form-control" name="crud" class="form-control" >
                                    </td>
                                </tr>
                                 @if(Auth::user()->punyaAkses('Tarif Cabang Kilogram','cabang'))
                                 <tr>
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    <td>   
                                        <select class="chosen-select-width b"  name="cb_cabang" id="ed_harga"  style="width:100%">
                                            <option value="" selected="" disabled="">-- Pilih Cabang --</option>
                                        @foreach ($cabang as $row)
                                             <option @if(Auth::user()->kode_cabang == $row->kode) selected="" @endif value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @else
                                 <tr>
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    <td class="disabled">   
                                        <select class="chosen-select-width b"  name="cb_cabang" id="ed_harga" style="width:100%">
                                            <option value="" selected="" disabled="">-- Pilih Cabang --</option>
                                        @foreach ($cabang as $row)
                                            <option @if(Auth::user()->kode_cabang == $row->kode) selected="" @endif value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="padding-top: 0.4cm">Kota Asal</td>
                                    <td>   
                                        <select class="chosen-select-width b"  name="cb_kota_asal" style="width:100%" id="cb_kota_asal">
                                            <option value="" selected="" disabled="">-- Pilih Kota asal --</option>
                                        @foreach ($kota as $row)
                                            <option value="{{ $row->id }}" data-kota="{{ $row->kode_kota }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr id="hilang2">
                                    <td style="padding-top: 0.4cm">Kota Tujuan</td>
                                    <td>   
                                        <select class="chosen-select-width c"  name="cb_kota_tujuan" id="cb_kota_tujuan" style="width:100%">
                                             <option value="" selected="" disabled="">-- Pilih Kota tujuan --</option>
                                        @foreach ($kota as $row)
                                            <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr id="hilang">
                                    <td style="padding-top: 0.4cm">Provinsi Tujuan</td>
                                    <td>   
                                        <select class="chosen-select-width c"  name="cb_provinsi_tujuan" id="cb_provinsi_tujuan" style="width:100%" i>
                                            <option value="" selected="" disabled="">-- Pilih Provinsi tujuan --</option>
                                        @foreach ($prov as $prov)
                                            <option value="{{ $prov->id }}"> {{ $prov->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Acc Penjualan</td>
                                    <td>
                                        <select class="chosen-select-width"  name="cb_acc_penjualan" style="width:100%">
                                             <option value="" selected="" disabled="">-- Pilih Akun Penjualan --</option>
                                        @foreach ($akun as $row)
                                            <option value="{{ $row->id_akun}}" data-nama_akun="{{$row->nama_akun}}"> {{ $row->id_akun }} - {{$row->nama_akun}}</option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">CSF Penjualan</td>
                                    <td>
                                        <select class="chosen-select-width"  name="cb_csf_penjualan" style="width:100%">
                                             <option value="" selected="" disabled="">-- Pilih Csf Penjualan --</option>
                                        @foreach ($akun as $row)
                                            <option value="{{ $row->id_akun}}" data-nama_akun="{{$row->nama_akun}}"> {{ $row->id_akun }} - {{$row->nama_akun}}</option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>

                            </tbody>
                          </table>
                           <table class="table-striped table-bordered" width="48%"> 
                              <thead>
                                  <tr >
                                      <th style="padding: 7px; text-align: center;"  colspan="2">REGULAR</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <input type="hidden" name="id_reguler" id="id_reguler">
                                  <tr>
                                      <td class="pad">Waktu/Estimasi</td>
                                      <td class="pad"><input type="text" name="waktu_regular"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif Kertas / Kg</td>
                                      <td class="pad"><input type="text" name="tarifkertas_reguler"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif <= 10 Kg</td>
                                      <td class="pad"><input type="text" name="tarif0kg_reguler"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif Kg selanjutnya</td>
                                      <td class="pad"><input type="text" name="tarif10kg_reguler"></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" style="background-color: white;color: white; " align="center">-</td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif <= 20 Kg</td>
                                      <td class="pad"><input type="text" name="tarif20kg_reguler"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif Kg selanjutnya</td>
                                      <td class="pad"><input type="text" name="tarifkgsel_reguler"></td>
                                  </tr>

                              </tbody>
                          </table> 
                          <table class="table-striped table-bordered" style="margin-left: 45%;margin-top: -323px;position: fixed;" width="48%"> 
                              <thead>
                                  <tr>
                                      <th style="padding: 7px; text-align: center;"  colspan="2">EXPRESS</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <input type="hidden" name="id_express" id="id_express">

                                  <tr>
                                      <td class="pad">Waktu/Estimasi</td>
                                      <td class="pad"><input type="text" name="waktu_express"></td>
                                  </tr>
                                   <tr>
                                      <td class="pad">Tarif Kertas / Kg</td>
                                      <td class="pad"><input type="text" name="tarifkertas_express"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif 0 <= 10 Kg</td>
                                      <td class="pad"><input type="text" name="tarif0kg_express"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif Kg selanjutnya</td>
                                      <td class="pad"><input type="text" name="tarif10kg_express"></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" style="background-color: white;color: white; " align="center">-</td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif <= 20 Kg</td>
                                      <td class="pad"><input type="text" name="tarif20kg_express"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif Kg selanjutnya</td>
                                      <td class="pad"><input type="text" name="tarifkgsel_express"></td>
                                  </tr>
                              </tbody>
                          </table>
                          
                          <input type="hidden" name="kodekota" id="kodekota">
                          {{-- KODE utama  --}}
                          {{-- KODE SAMA KILO --}}
                          <input type="hidden" name="kode_sama_kilo">
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btnsave">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>