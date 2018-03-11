<table class="table table-bordered table-striped table-hover tb_modal">
	<thead>
		<th>No.Subcon</th>
		<th>Asal</th>
		<th>Tujuan</th>
		<th>Angkutan</th>
		<th>Harga</th>
	</thead>
	<tbody>
	  @foreach( $subcon_dt as $val )
	  <tr style="cursor: pointer;" onclick="pilih_kontrak(this)">
		<td>
			{{$val->ks_nota}}
			<input type="hidden" class="id_kontrak" value="{{$val->ksd_ks_id}}">
			<input type="hidden" class="dt_kontrak" value="{{$val->ksd_ks_dt}}">

		</td>
		<td>{{$val->asal}}</td>
		<td>{{$val->tujuan}}</td>
		<td>{{$val->angkutan}}</td>
		<td>{{$val->ksd_harga}}</td>
	  </tr>
	  @endforeach
	</tbody>
</table>

<script type="text/javascript">
	$('.tb_modal').DataTable();
</script>