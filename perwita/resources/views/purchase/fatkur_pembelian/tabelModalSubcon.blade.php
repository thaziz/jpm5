<table class="table table-bordered table-striped table-hover tb_modal">
	<thead>
		<th>No.Subcon</th>
		<th>Asal</th>
		<th>Tujuan</th>
		<th>Angkutan</th>
		<th>Harga</th>
		<th>Jenis Tarif</th>
	</thead>
	<tbody>
	@if(isset($fix))
	  @foreach( $fix as $val )
	  <tr style="cursor: pointer;" onclick="pilih_kontrak(this)">
		<td style="width: 20px; text-align: center;">
			{{$val['ksd_id']}}
			<input type="hidden" class="id_kontrak" value="{{$val['ksd_id']}}">
		</td>
		<td>{{$val['ksd_asal']}}</td>
		<td>{{$val['ksd_tujuan']}}</td>
		<td>{{$val['ksd_angkutan']}}</td>
		<td>{{number_format($val['ksd_harga'])}}</td>
		<td>{{$val['ksd_jenis_tarif']}}</td>
	  </tr>
	  @endforeach
	  @endif
	</tbody>
</table>

<script type="text/javascript">
	$('.tb_modal').DataTable();
</script>