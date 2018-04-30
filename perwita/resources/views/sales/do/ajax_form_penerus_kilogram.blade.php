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
                                    <input type="hidden" name="crud">
                                    
                                </tr>
                               <tr>
                                   <td style="padding-top: 0.4cm">Tipe Kiriman</td>
                                    <td>{{-- <input type="text" value="DOKUMEN" readonly="" > --}}
                                        <select  name="ed_tipe" id="penerus_tipekilo" class="form-control">
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
                                       <select name="ed_provinsi" id="penerus_provinsikilo" class="form-control">
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
                                        <select name="ed_kota" id="penerus_kotakilo"  class="form-control">
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
                                        <select name="ed_kecamatan" id="penerus_kecamatankilo"  class="form-control">
                                            <option disabled="" selected="">-- --</option>
                                            @foreach ($kecamatan as $c)
                                                <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                           @endforeach               
                                        </select>
                                    </td>
                               </tr>
                                <input type="hidden" name="kode_kota" id="penerus_kodekotakilo">
                            </tbody>
                          </table>
                          <table class="table table-striped table-bordered table-hover ">
                              <tr>
                                   <td style="padding-top: 0.4cm"> Tarif >= 10 Reguler</td>
                                   <td>
                                    <select  class="form-control" name="ed_10reguler">
                                    <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach  
                                    </select>
                                   </td>
                               </tr>
                               <tr>
                                  <td style="padding-top: 0.4cm"> Tarif > 20 Reguler</td>
                                   <td>
                                    <select  class="form-control" name="ed_20reguler">
                                    <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach  
                                    </select>
                                   </td>
                              </tr>
                          </table>
                          <table class="table table-striped table-bordered table-hover ">
                              <tr>
                                   <td style="padding-top: 0.4cm"> Tarif >= 10 Express</td>
                                   <td>
                                     <select  class="form-control" name="ed_10express">
                                    <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach  
                                    </select>
                                   </td>
                               </tr>
                              <tr>
                                  <td style="padding-top: 0.4cm"> Tarif > 20 Express</td>
                                   <td>
                                     <select  class="form-control" name="ed_20express">
                                    <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach  
                                    </select>
                                   </td>
                              </tr>
                          </table>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="save_penerus_kilogram()">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>