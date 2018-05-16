@if($jenis_bayar == 2 or $jenis_bayar == 6 or $jenis_bayar == 7 or $jenis_bayar == 9)
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
  		<td class="no_faktur">{{ $val->fp_nofaktur }}</td>
  		<td>{{ carbon\carbon::parse($val->fp_tgl)->format('d/m/Y') }}</td>
  		<td>{{ carbon\carbon::parse($val->fp_jatuhtempo)->format('d/m/Y') }}</td>
  		<td align="right">{{ number_format($val->fp_netto, 0, ",", ".") }}</td>
  		<td align="right">{{ number_format($val->fp_sisapelunasan, 0, ",", ".") }}</td>
  		<td>{{ $val->tt_noform }}</td>
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