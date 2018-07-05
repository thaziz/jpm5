<table class="table table-bordered table-hover table_modal_vendor">
	<thead>
		<tr>
			<th>No</th>
			<th>Delivery Order</th>
			<th>Tanggal</th>
			<th>Total Tarif</th>
			<th>Tarif Vendor</th>
			<th><input type="checkbox" name="check_vendor_all" class="check_vendor_all form-control"></th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $i=>$val)
			<tr style="cursor: pointer;">
				<td>{{ $i+1 }}</td>
				<td class="nomor_do_vendor">{{ $val->nomor }}</td>
				<td>{{ $val->tanggal }}</td>
				<td>{{ number_format($val->total_net,2,",",".") }}</td>
				<td>{{ number_format($val->total_vendo,2,",",".") }}</td>
				<td><input type="checkbox" name="check_vendor[]" class="check_vendor form-control"></td>
			</tr>
		@endforeach
	</tbody>
</table>
<script>
var table_modal_vendor = $('.table_modal_vendor').DataTable({
	sort:false,
	columnDefs: [
              {
                 targets: 5,
                 className: 'center'
              },
              {
                 targets: 0,
                 className: 'center'
              },
              {
                 targets:4,
                 className: 'right'
              },
              {
                 targets:3,
                 className: 'right'
              },
            ],
});

$('.check_vendor_all').change(function(){
	console.log($(this).is(':checked'));
	if ($(this).is(':checked') == true) {
		table_modal_vendor.$('.check_vendor').each(function(){
			$(this).prop('checked',true);
		})
	}else if ($(this).is(':checked') == false){
		table_modal_vendor.$('.check_vendor').each(function(){
			$(this).prop('checked',false);
		})
	}
})
</script>