<table class="table tabel_append_pajak table-hover" >
	<thead>
		<th>No</th>
		<th>Faktur Pajak</th>
		<th>Tanggal Faktur Pajak</th>
	</thead>
	<tbody>
		@foreach ($data as $i => $val)
			<tr onclick="pilih_pajak(this)" style="cursor: pointer">
				<td>
					{{ $i+1 }}
					<input type="hidden" class="nsp_id" name="nsp_id" value="{{ $val->nsp_id }}">
					<input type="hidden" class="nsp_nomor_pajak" name="nsp_nomor_pajak" value="{{ $val->nsp_nomor_pajak }}">
				</td>
				<td>{{ $val->nsp_nomor_pajak }}</td>
				<td>{{ $val->nsp_tanggal }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

<script type="text/javascript">
	$('.tabel_append_pajak').DataTable({
		 columnDefs: [
	      {
	         targets: 0,
	         className: 'center'
	      },
	      {
	         targets:1,
	         className: 'center'
	      },
	      {
	         targets:2,
	         className: 'center'
	      },
	    ],
	});
</script>