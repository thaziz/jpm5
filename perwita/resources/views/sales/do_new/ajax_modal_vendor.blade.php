<div id="modal_vendor" class="modal_vendor" >
  <div class="modal-dialog " style="width: 900px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" onclick="close_vendor()" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Vendor</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal kirim">
          <table class="table table-striped table-bordered table-hover" id="datatable">
            <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Asal</th>
                  <th>Tujuan</th>
                  <th>Nama</th>
                  <th>Harga</th>
                  <th>Waktu</th>
                </tr> 
            </thead>  
            <tbody> 
              @foreach ($vendor as $index => $element)
                <tr onclick="Pilih_vendor(this)">
                  <td>{{ $index+1 }} </td>
                  <td>{{ $element->kode }} <input type="hidden" class="id_vendor" value="{{ $element->id_tarif_vendor }}"></td>
                  <td>{{ $element->tuj }}</td>
                  <td>{{ $element->as }}</td>
                  <td>{{ $element->nama }}</td>
                  <td>{{ $element->tarif_vendor }}</td>
                  <td>{{ $element->waktu_vendor }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>

