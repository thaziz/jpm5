<div id="modal_jurnal_balik" class="modal" >
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
                  <th>Kode Akun</th>
                  <th>Nama Akun</th>
                  <th>Debet</th>
                  <th>Kredit</th>
                </tr> 
            </thead>
                @foreach ($data as $e)
                  <tr>
                    <td>{{ $e->jrdt_acc }}</td>
                    <td>{{ $e->nama_akun }}</td>
                    @if ($e->jrdt_statusdk == 'D')
                      <td><input class="debet_jurnal_balik" value="{{ $e->jrdt_value }}" type="hidden" name="">
                        {{ $e->jrdt_value }}
                      </td>
                      <td><input class="kredit_jurnal_balik" value="0" type="hidden" name="">
                        0
                      </td>
                    @else
                      <td><input value="0" type="hidden" name="">
                        0
                      </td>
                      <td><input class="kredit_jurnal_balik" value="{{ $e->jrdt_value }}" type="hidden" name="">
                        {{ $e->jrdt_value }}
                      </td>
                    @endif
                  </tr>
                @endforeach
                  <tr>
                    <td colspan="2">Total :</td>
                    <td class="total_debet_jurnal_balik"></td>
                    <td class="total_kredit_jurnal_balik"></td>
                  </tr>
            <tbody>
            </tbody>
          </table>


        </form>
      </div>
    </div>
  </div>
</div>
               