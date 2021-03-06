@if($jenis_bayar == 11)
<table class="table tabel_modal table-hover">
  <thead>
    <tr>
      <th>No</th>
      <th>No Faktur</th>
      <th>Tanggal</th>
      <th>Jatuh Tempo</th>
      <th>Harga Faktur</th>
      <th>Sisa Pelunasan</th>
      <th>No Tanda Terima</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($data as $i=>$val)
  	<tr onclick="pilih_faktur(this)" style="cursor: pointer;">
  		<td align="center">{{ $i+1 }}</td>
  		<td class="no_faktur">{{ $val->ik_nota }}</td>
  		<td>{{ carbon\carbon::parse($val->ik_tanggal)->format('d/m/Y') }}</td>
  		<td> - </td>
  		<td align="right">{{ number_format($val->ik_total, 0, ",", ".") }}</td>
  		<td align="right">{{ number_format($val->ik_pelunasan, 0, ",", ".") }}</td>
  		<td> - </td>
  		<td align="center">
        <input type="checkbox" name="check[]" class="check">
      </td>
  	</tr>
  	@endforeach
  </tbody>
</table>
@else

@endif
<script>
	var check = $('.tabel_modal').DataTable();

  function pilih_faktur(a) {
    var check = $(a).find('.check').is(':checked');

    if (check == false) {
      $(a).find('.check').prop('checked',true);
    }else{
      $(a).find('.check').prop('checked',false);
    }

  }

  $('.check').change(function(){
    var check = $(this).is(':checked');
    if (check == false) {
      $(this).prop('checked',true);
    }else{
      $(this).prop('checked',false);
    }
  })
</script>