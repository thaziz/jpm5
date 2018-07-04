<div class="col-sm-12">
	<div class="col-sm-6"  >
		<div class="header_vendor" style="text-align: center"><h3>Form Pembayaran Vendor</h3></div>
		<form class="form_vendor">
			<table class="table table_vendor">
				<tr>
					<td>Tanggal</td>
					<td><input type="text" readonly="" value="{{$tanggal}}" class="form-control tanggal_vendor" name="tanggal_vendor"></td>
				</tr>
				<tr>
					<td>Jatuh Tempo</td>
					<td><input type="text" readonly="" value="{{$tanggal}}" class="form-control jatuh_tempo_vendor" name="jatuh_tempo_vendor"></td>
				</tr>
				<tr>
					<td>Status</td>
					<td><input type="text" value="Released" readonly="" class="form-control status" name="status"></td>
				</tr>
				<tr>
					<td>Vendor</td>
					<td>
						<select class="form-control chosen-select-width-vendor nama_vendor">
							<option value="0">Pilih - Vendor</option>
							@foreach ($vendor as $val)
								<option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
							@endforeach
						</select>
					</td>
				</tr>
				<tr>
					<td>No Invoice</td>
					<td><input type="text" class="form-control no_invoice" name="no_invoice"></td>
				</tr>
				<tr>
					<td>Keterangan</td>
					<td><input type="text" class="form-control keterangan" name="keterangan"></td>
				</tr>
				<tr>
					<td>Total Biaya</td>
					<td><input readonly="" type="text" class="form-control total" name="total"></td>
				</tr>
				<tr>
					<td colspan="2">
						<button type="button" class="btn btn-primary tambah_data_vendor" ><i class="fa fa-plus"> Tambah Data</i></button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<script type="text/javascript">
$('.tangal_vendor').datepicker({
	format:'dd/mm/yyyy'
});
$('.jatuh_tempo_vendor').datepicker({
	format:'dd/mm/yyyy'
});

var config_vendor = {
           '.chosen-select'           : {},
           '.chosen-select-deselect'  : {allow_single_deselect:true},
           '.chosen-select-no-single' : {disable_search_threshold:10},
           '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
           '.chosen-select-width-vendor'     : {width:"100%"}
        }
for (var selector in config_vendor) {
	$(selector).chosen(config_vendor[selector]);
}	 

$('.tambah_data_vendor').click(function(){
	
})

</script>