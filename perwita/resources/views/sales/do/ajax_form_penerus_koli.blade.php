 <div id="modal" class="modal" >
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insert Edit Tarif Penerus Dokumen</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal kirim">
                          <table class="table table-striped table-bordered table-hover ">
                            <tbody>
                                
                                <tr>
                                    <td style="padding-top: 0.4cm">Kode</td>
                                    <td><input type="text" name="ed_kode" class="form-control" placeholder="OTOMATIS"></td>
                                    <input type="hidden" name="ed_kode_old">
                                    <input type="hidden" name="ed_kode_lama">
                                    <input type="hidden" name="crud">
                                    
                                </tr>
                               <tr>
                                    <td style="padding-top: 0.4cm">Tipe Kiriman</td>
                                    <td>{{-- <input type="text" value="DOKUMEN" readonly="" > --}}
                                        <select  name="ed_tipe" class="form-control">
                                          <option value="">Pilih - Tipe</option>
                                          <option value="DOKUMEN">DOKUMEN</option>
                                          <option value="KILOGRAM">KILOGRAM</option>
                                          <option value="KOLI">KOLI</option>
                                          <option value="SEPEDA">SEPEDA</option>
                                        </select>
                                    </td>
                               </tr>
                               <tr>
                                   <td style="padding-top: 0.4cm"> Provinsi </td>
                                   <td>
                                       <select name="ed_provinsi" id="provinsi" class="form-control">
                                           <option>-- Pilih Provinsi Terlebih dahulu --</option>
                                           @foreach ($provinsi as $a)
                                                <option value="{{ $a->id }}">{{ $a->nama }}</option>
                                           @endforeach
                                       </select>
                                   </td>
                               </tr>

                               <tr>
                                   <td style="padding-top: 0.4cm"> Kota </td>
                                   <td>
                                        <select name="ed_kota" id="kota"  class="form-control">
                                            <option disabled="" selected="">-- --</option>  
                                            @foreach ($kota as $b)
                                                <option value="{{ $b->id }}">{{ $b->nama }}</option>
                                           @endforeach      
                                        </select>
                                    </td>
                               </tr>

                               <tr>
                                   <td style="padding-top: 0.4cm"> kecamatan </td>
                                   <td>
                                        <select name="ed_kecamatan" id="kecamatan"  class="form-control">
                                            <option disabled="" selected="">-- --</option>
                                            @foreach ($kecamatan as $c)
                                                <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                           @endforeach               
                                        </select>
                                    </td>
                               </tr>
                                <input type="hidden" name="kode_kota">
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
                                      <td class="pad"> < 10 Kg reguler </td>
                                      <td class="pad">
                                        <select id="ed_reguler"  class="form-control chosen-select-width" name="ed_10_reguler">
                                            <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach               
                                        </select>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="pad"> < 20 reguler </td>
                                      <td class="pad">
                                        <select id="ed_reguler"  class="form-control chosen-select-width" name="ed_20_reguler">
                                            <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach               
                                        </select>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="pad"> < 30 reguler </td>
                                      <td class="pad">
                                        <select id="ed_reguler"  class="form-control chosen-select-width" name="ed_30_reguler">
                                            <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach               
                                        </select>
                                        </td>
                                  </tr>
                                  <tr>
                                      <td class="pad"> > 30 reguler </td>
                                      <td class="pad">
                                         <select id="ed_reguler"  class="form-control chosen-select-width" name="ed_lebih_30_reguler">
                                            <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach               
                                        </select>
                                      </td>
                                  </tr>
                              </tbody>
                          </table> 
                          <table class="table-striped table-bordered" style="margin-left: 45%;margin-top: -254px;position: fixed;" width="48%"> 
                              <thead>
                                  <tr>
                                      <th style="padding: 7px; text-align: center;"  colspan="2">EXPRESS</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <input type="hidden" name="id_express" id="id_express">

                                  <tr>
                                      <td class="pad"> < 10 Kg express </td>
                                      <td class="pad">
                                         <select id="ed_reguler"  class="form-control chosen-select-width" name="ed_10_express">
                                            <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach               
                                        </select>
                                      </td>
                                  </tr>
                                   <tr>
                                      <td class="pad"> < 20 express </td>
                                      <td class="pad">
                                         <select id="ed_reguler"  class="form-control chosen-select-width" name="ed_20_express">
                                            <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach               
                                        </select>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="pad"> < 30 express </td>
                                      <td class="pad">
                                        <select id="ed_reguler"  class="form-control chosen-select-width" name="ed_30_express">
                                            <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach               
                                        </select>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="pad"> > 30 express </td>
                                      <td class="pad">
                                        <select id="ed_reguler"  class="form-control chosen-select-width" name="ed_lebih_30_express">
                                            <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach               
                                        </select>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="save_penerus_koli()">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>