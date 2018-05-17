<div id="modal" class="modal" >
                  <div class="modal-dialog " style="width: 900px;">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insert Edit Tarif Penerus Dokumen</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal kirim">
                          <table class="table table-striped table-bordered table-hover" id="ajax_modal_kontrak">
                            <thead>
                                <tr>
                                  <th>No Tarif</th>
                                  <th>Asal Tarif</th>
                                  <th>Tujuan Tarif</th>
                                  <th>Jenis Tarif</th>
                                  <th>Biaya Kontrak</th>
                                  <th>Jenis</th>
                                </tr> 
                            </thead>
                                @foreach ($data as $e)
                                  <tr onclick="Pilih_kontrak(this)">
                                    <td >{{ $e->kcd_kode }}<input type="hidden" class="kcd_dt" value="{{ $e->kcd_dt }}"><input type="hidden" class="kcd_id" value="{{ $e->kcd_id }}"></td>
                                    <td>{{ $e->asal}}</td>
                                    <td>{{ $e->tujuan }}</td>
                                    <td>{{ $e->kcd_harga }}</td>
                                    <td>{{ $e->tarif }}</td>
                                    <td>{{ $e->jenis }}</td>
                                  </tr>
                                @endforeach
                            <tbody>
                            </tbody>
                          </table>


                        </form>
                      </div>
                    </div>
                  </div>
                </div>
               