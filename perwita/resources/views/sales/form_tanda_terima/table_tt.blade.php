<table class="table table_invoice table-bordered" style="color:black;width: 100%">
	<thead  style="color:white!important">
		<tr>
			<td >No</td>
			<td>Invoice</td>
			<td>Nominal</td>
			<td>Tanggal</td>
			<td align="center"><input type="checkbox" class="parent_check"></td>
		</tr>
	</thead>
	<tbody>
		@foreach ($data as $i=> $val)
			<tr>
				<td style="width: 20px">{{ $i+1 }}
					{{ csrf_field() }}
				</td>
				<td>{{ $val->i_nomor }}
					<input type="hidden" name="nomor_invoice" class="nomor_invoice" value="{{ $val->i_nomor }}">
				</td>
				<td>{{ number_format($val->i_total_tagihan, 2, ",", ".") }}</td>
				<td>{{ Carbon\carbon::parse($val->i_tanggal)->format('d/m/Y') }}</td>
				<td><input type="checkbox" class="child_check" name="child_check"></td>
			</tr>
		@endforeach
	</tbody>
</table>

<script type="text/javascript">
	var invoice = $('.table_invoice').DataTable({
		sorting:false,
		columnDefs: [
	        {
	           targets: 0,
	           className: 'center'
	        },
	        {
	           targets: 4,
	           className: 'center'
	        },
	        {
	           targets: 2,
	           className: 'right'
	        },
    	],
	});


	$('.parent_check').change(function(){
		if ($(this).is(':checked')== true) {
			invoice.$('.child_check').prop('checked',true);
		}else{
			invoice.$('.child_check').prop('checked',false);
		}
	})
</script>