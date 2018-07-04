<div class="col-sm-12">
	<div class="col-sm-6"  >
		<div class="header" style="text-align: center"><h3>Form Pembayaran Vendor</h3></div>
		<form class="form_vendor">
			<table class="table table_vendor">
				<tr>
					<td>Tanggal</td>
					<td><input type="text" readonly="" class="form-control tangal_vendor" name="tangal_vendor"></td>
				</tr>
				<tr>
					<td>Jatuh Tempo</td>
					<td><input type="text" readonly="" class="form-control jatuh_tempo" name="jatuh_tempo"></td>
				</tr>
				<tr>
					<td>Status</td>
					<td><input type="text" class="form-control status" name="status"></td>
				</tr>
				<tr>
					<td>Nama Vendor</td>
					<td><input type="text" class="form-control nama_vendor" name="nama_vendor"></td>
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
					<td><input type="text" class="form-control total" name="total"></td>
				</tr>
				<tr>
					<td colspan="2">
						<button type="button" class="btn btn-primary" ></button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<script type="text/javascript">
	$('.tangal_vendor').datepicker()
</script>