<div class="modal fade" id="modal_vendor" class="modal_vendor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width: 800px;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Point-Point Yang Harus Diperhatikan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
                <td align="right">{{ number_format($element->tarif_vendor,0,'','.') }}</td>
                <td>{{ number_format($element->waktu_vendor,0,'','.') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </form>
      <div class="modal-footer">                            
      </div>
    </div>
  </div>
</div>