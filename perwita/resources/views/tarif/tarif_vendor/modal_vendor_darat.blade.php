
                <!-- modal -->
                <div id="modal" class="modal" >
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Tarif Cabang Kilogram</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal kirim row">
                          <div class="col-sm-12">
                            <table class="table table-striped table-bordered table-hover ">
                              <tbody>
                                  <tr>
                                      {{-- <td style="width:120px; padding-top: 0.4cm">Kode</td> --}}
                                      <td colspan="3">
                                          <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                          <input type="hidden" name="ed_kode_old" class="form-control ed_kode_old" >
                                          <input type="hidden" class="form-control" name="crud" class="form-control" >
                                      </td>
                                  </tr>
                                   @if(Auth::user()->punyaAkses('Tarif Cabang Kilogram','cabang'))
                                   <tr>
                                      <td style="padding-top: 0.4cm">Cabang</td>
                                      <td>   
                                          <select class="chosen-select-width b cabang"  name="cb_cabang" id="cb_cabang"  style="width:100%">
                                              <option value="" selected="">-- Pilih Cabang --</option>
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
                                          <select class="chosen-select-width b cabang"  name="cb_cabang" id="cb_cabang" style="width:100%">
                                              <option value="" selected="">-- Pilih Cabang --</option>
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
                                          <select class="chosen-select-width b option kota_asal"  name="cb_kota_asal" style="width:100%" id="cb_kota_asal">
                                              <option value="" selected="">-- Pilih Kota asal --</option>
                                          @foreach ($kota as $row)
                                              <option value="{{ $row->id }}" data-kota="{{ $row->kode_kota }}"> {{ $row->nama }} </option>
                                          @endforeach
                                          </select>
                                      </td>
                                  </tr>

                                  <tr id="hilang2">
                                      <td style="padding-top: 0.4cm">Kota Tujuan</td>
                                      <td>   
                                          <select class="chosen-select-width c option kota_tujuan"  name="cb_kota_tujuan" id="cb_kota_tujuan" style="width:100%">
                                               <option value="" selected="">-- Pilih Kota tujuan --</option>
                                          @foreach ($kota as $row)
                                              <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                          @endforeach
                                          </select>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td style="padding-top: 0.4cm">Vendor</td>
                                      <td>
                                          <select class="chosen-select-width option vendor"  name="cb_vendor" style="width:100%">
                                               <option value="" selected="">-- Pilih Vendor --</option>
                                          @foreach ($vendor as $ven)
                                              <option value="{{ $ven->kode}}" data-nama_akun="{{$ven->nama}}"> {{ $ven->kode }} - {{$ven->nama}}</option>
                                          @endforeach
                                          </select>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td style="padding-top: 0.4cm">Jenis Angkutan</td>
                                      <td>
                                          <select class="chosen-select-width option jenis_angkutan"  name="jenis_angkutan" style="width:100%">
                                               <option value="DARAT">Darat</option>
                                               <option value="LAUT">Laut</option>
                                               <option value="UDARA">Udara</option>
                                          </select>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td style="padding-top: 0.4cm">Jenis Tarif</td>
                                      <td>
                                          <select class="chosen-select-width option jenis_tarif"  name="jenis_tarif" style="width:100%">
                                               <option value="DOKUMEN">Dokumen</option>
                                               <option value="KILOGRAM">Kilogram</option>
                                               <option value="KOLI">Koli</option>
                                               <option value="FLAT">Flat</option>
                                               <option value="UNIT">Unit</option>
                                          </select>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td style="padding-top: 0.4cm">Acc Penjualan</td>
                                      <td>
                                          <select class="chosen-select-width option acc_penjualan"  name="cb_acc_penjualan" style="width:100%">
                                               <option value="" selected="">-- Pilih Akun Penjualan --</option>
                                          @foreach ($akun as $row)
                                              <option value="{{ $row->id_akun}}" data-nama_akun="{{$row->nama_akun}}"> {{ $row->id_akun }} - {{$row->nama_akun}}</option>
                                          @endforeach
                                          </select>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td style="padding-top: 0.4cm">CSF Penjualan</td>
                                      <td>
                                          <select class="chosen-select-width option csf_penjualan"  name="cb_csf_penjualan" style="width:100%">
                                               <option value="" selected="">-- Pilih Csf Penjualan --</option>
                                          @foreach ($akun as $row)
                                              <option value="{{ $row->id_akun}}" data-nama_akun="{{$row->nama_akun}}"> {{ $row->id_akun }} - {{$row->nama_akun}}</option>
                                          @endforeach
                                          </select>
                                      </td>
                                  </tr>
                              </tbody>
                            </table> 
                          </div>
                          <div class="col-sm-12">
                            <ol>
                              <li class="reds">
                                Jika Jenis Tarif Bukan Kilo, Samakan Semua Harga Seperti Tarif Dan Berat Minimum Adalah 1.
                              </li>
                            </ol>
                            <table class="table-striped table-bordered" style="width: 100%"> 
                              <thead>
                                  <tr >
                                      <th style="padding: 7px; text-align: center; color: black"  colspan="2">FORM TARIF</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <input type="hidden" name="id_reguler" id="id_reguler">
                                  <tr>
                                      <td class="pad">Waktu/Estimasi</td>
                                      <td class="pad"><input type="text" name="waktu_regular" class="waktu form-control wajib"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif</td>
                                      <td class="pad"><input type="text" name="tarifkertas_reguler" class="tarif form-control wajib"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif <= 10 Kg</td>
                                      <td class="pad"><input type="text" name="tarif10kg_reguler" class="tarif_kurang form-control wajib"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif Kg selanjutnya</td>
                                      <td class="pad"><input type="text" name="tarifsel_reguler" class="tarif_lebih form-control wajib"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Berat Minimum</td>
                                      <td class="pad"><input type="text" name="berat_minimum_reg" class="berat_minimum form-control wajib"></td>
                                  </tr>

                              </tbody>
                            </table> 
                          </div>
                            
                          
                          <!-- hidden -->

                      {{--     <input type="hidden" name="id_tarif_vendor_reg">
                          <input type="hidden" name="id_tarif_vendor_reg_1">
                          <input type="hidden" name="id_tarif_vendor_reg_2">
                          <input type="hidden" name="id_tarif_vendor_ex">
                          <input type="hidden" name="id_tarif_vendor_ex_1">
                          <input type="hidden" name="id_tarif_vendor_ex_2"> --}}

                          <!-- hidden -->
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btnsave"><i class="loadings fa "></i> Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>
              


