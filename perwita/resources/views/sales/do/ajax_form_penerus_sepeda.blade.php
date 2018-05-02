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
                                    <td><input type="text" name="ed_kode" readonly="" class="form-control" placeholder="OTOMATIS"></td>
                                    <input type="hidden" name="ed_kode_old">
                                    <input type="hidden" name="crud">
                                    
                                </tr>
                              {{--  <tr>
                                   <td style="padding-top: 0.4cm">Tipe Kiriman</td>
                                    <td><input type="text" name="ed_tipe" value="KILOGRAM" readonly="" class="form-control"></td>
                               </tr> --}}
                               <tr>
                                   <td style="padding-top: 0.4cm"> Provinsi </td>
                                   <td>
                                       <select name="ed_provinsi_sepeda" id="penerus_provinsisepeda" class="form-control">
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
                                        <select name="ed_kota_sepeda" id="penerus_kotasepeda"  class="form-control">
                                            <option disabled="" selected="">-- --</option>  
                                            @foreach ($kota as $b)
                                                <option value="{{ $b->id }}" data-kota="{{ $b->kode_kota }}">{{ $b->nama }}</option>
                                           @endforeach      
                                        </select>
                                    </td>
                               </tr>

                               <tr>
                                   <td style="padding-top: 0.4cm"> kecamatan </td>
                                   <td>
                                        <select name="ed_kecamatan_sepeda" id="penerus_kecamatansepeda"  class="form-control">
                                            <option disabled="" selected="">-- --</option>
                                            @foreach ($kecamatan as $c)
                                                <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                           @endforeach               
                                        </select>
                                    </td>
                               </tr>
                                <input type="hidden" name="kode_kota_sepeda" id="penerus_kodekotasepeda">
                            </tbody>
                          </table>
                          <table class="table table-striped table-bordered table-hover ">
                              <tr>
                                   <td style="padding-top: 0.4cm"> sepeda</td>
                                   <td>
                                      <select class="form-control chosen-select-width" name="sepeda">
                                            <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach               
                                        </select>
                                   </td>
                               </tr>
                               <tr>
                                  <td style="padding-top: 0.4cm"> bebek/matik</td>
                                   <td>
                                      <select class="form-control chosen-select-width" name="matik">
                                            <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach               
                                        </select>
                                   </td>
                              </tr>
                              <tr>
                                   <td style="padding-top: 0.4cm"> laki/sport</td>
                                   <td>
                                        <select class="form-control chosen-select-width" name="sport">
                                            <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach               
                                        </select>
                                   </td>
                               </tr>
                              <tr>
                                  <td style="padding-top: 0.4cm"> moge</td>
                                   <td>
                                       <select class="form-control chosen-select-width" name="moge">
                                            <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach               
                                        </select>
                                   </td>
                              </tr>
                          <input type="hidden" name="kode_kota" id="kodekota">
                          </table>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="save_penerus_sepeda()">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>