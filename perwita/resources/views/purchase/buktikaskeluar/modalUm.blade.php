<table class="table table-bordered table-striped table-hover modal_table_um">
	<thead>
		<th>No</th>
		<th>No Uang Muka</th>
		<th>Tanggal</th>
		<th>Keterangan</th>
		<th>Nominal</th>
		<th>Sisa UM</th>
	</thead>
	<tbody>
		@foreach($data as $i => $val)
			<tr onclick="set_um(this)">
				<td>
				{{$i+1}}
				<input type="hidden"  class="id_um" value="{{$val->um_id}}">
				</td>
				<td>
				{{$val->um_nomorbukti}}
				<input type="hidden"  class="no_um" value="{{$val->um_nomorbukti}}">
				</td>
				<td>
				{{$val->um_tgl}}
				<input type="hidden"  class="tgl_um" value="{{$val->um_tgl}}">
				</td>
				<td>
				{{$val->um_keterangan}}
				<input type="hidden"  class="ket_um" value="{{$val->um_keterangan}}">
				</td>
				<td>
				{{$val->um_jumlah}}
				<input type="hidden"  class="jumlah_um" value="{{$val->um_jumlah}}">
				</td><td>
				{{$val->um_sisapelunasan}}
				<input type="hidden"  class="sisa_um" value="{{$val->um_sisapelunasan}}">
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

<script type="text/javascript">
	var table_modal_um = $('.modal_table_um').DataTable();
</script>