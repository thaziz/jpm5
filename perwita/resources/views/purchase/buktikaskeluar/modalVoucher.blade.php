<table class="table table-bordered table-striped table-hover modal_table_faktur">
	<thead>
		<th>No</th>
		<th>No Faktur</th>
		<th>Tanggal</th>
		<th>Keterangan</th>
		<th>Nominal</th>
		<th>Aksi</th>
	</thead>
	<tbody>
		@foreach($data as $i => $val)

			@if($id!=null)
				@if(in_array($val->v_id, $id))
				@else
				<tr >
					<td align="center">{{$i+1}} <input type="hidden" class="sequence_faktur">
						<input type="hidden"  class="id_faktur" value="{{$val->v_id}}">
					</td>
					<td>{{$val->v_nomorbukti}}<input type="hidden" class="fp_nofaktur" value="{{$val->v_nomorbukti}}"></td>
					<td>{{$val->v_tgl}}<input type="hidden" class="fp_tgl" value="{{$val->v_tgl}}"></td>
					<td>{{$val->v_keterangan}}<input type="hidden" class="fP_keterangan" value="{{$val->v_keterangan}}"></td>
					<td align="right">{{$val->v_hasil}}<input type="hidden" class="netto_faktur" value="{{$val->v_hasil}}"></td>
					<td align="center">
						<input type="checkbox" class="checker" >
					</td>
				</tr>
				@endif				
			@else
				<tr >
					<td align="center">{{$i+1}} <input type="hidden" class="sequence_faktur">
						<input type="hidden"  class="id_faktur" value="{{$val->v_id}}">
					</td>
					<td>{{$val->v_nomorbukti}}<input type="hidden" class="fp_nofaktur" value="{{$val->v_nomorbukti}}"></td>
					<td>{{$val->v_tgl}}<input type="hidden" class="fp_tgl" value="{{$val->v_tgl}}"></td>
					<td>{{$val->v_keterangan}}<input type="hidden" class="fP_keterangan" value="{{$val->v_keterangan}}"></td>
					<td align="right">{{$val->v_hasil}}<input type="hidden" class="netto_faktur" value="{{$val->v_hasil}}"></td>
					<td align="center">
						<input type="checkbox" class="checker" >
					</td>
				</tr>
			@endif

		@endforeach
	</tbody>
</table>

<script type="text/javascript">
	var table_modal = $('.modal_table_faktur').DataTable();
	


</script>