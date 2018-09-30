
<table class="table table-striped table-bordered table-hover" id="datatable_vendor">
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
    @foreach ($data as $index => $element)
      <tr onclick="Pilih_vendor('{{ $element->id_tarif_vendor }}')" style="cursor: pointer;">
        <td>{{ $index+1 }} </td>
        <td><input type="hidden" class="id_vendor" value="{{ $element->id_tarif_vendor }}">
          {{ $element->kode }}</td>
        <td>{{ $element->asal }}</td>
        <td>{{ $element->tujuan }}</td>
        <td><input type="hidden" name="" class="vendor_nama" value={{ $element->nama }}"">
          {{ $element->nama }}</td>
        <td align="right">
          <input type="hidden"  class="tarif_vendor" value="{{ $element->tarif_vendor}}">
          {{ number_format($element->tarif_vendor,0,'','.') }}</td>
        <td>{{ number_format($element->waktu_vendor,0,'','.') }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<script type="text/javascript">
  var datatable_vendor = $('#datatable_vendor').DataTable();
</script>