<form name="add_item" method="POST" class="form-horizontal col-xs-12" data-toggle="validator" id="not_modalForm">
	{{ csrf_field() }} {{ method_field('POST') }}
	<div class="col-sm-8">
		<table class="table table-bordered table-hover" id="table-top">
			<tr>
				<td width="2.5%">
					<label for="no" class="control-label">Nomor.DO</label>
				</td>
				<td width="30%">
					<input name="nomor" type="text" class="form-control" id="DO_number" placeholder="Nomor">
				</td>
			</tr>

			<tr>
				<td width="2.5%">
					<label for="tanggal" class="control-label">Tanggal</label>
				</td>
				<td width="30%">
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</span>
						<input name="tanggal" type="text" class="form-control date" id="tgl" placeholder="Tanggal">
					</div>
				</td>
			</tr>

			<tr>
				<td width="2.5%">
					<label for="codeCustomer" class="control-label" style="text-align: left;">Kode Customer</label>
				</td>
				<td width="30%">
					<select id="customer" name="kode_customer" data-placeholder="Customer" class="chosen-select form-control col-sm-8">
						<option value="">-- Pilih Customer --</option>
						@for ($i = 0; $i < count($data); $i++)
							@if (!empty($data[$i]))
								<option value="{{ $data[$i][0]->kode }}">
									{{ $data[$i][0]->nama }}
								</option>
							@else
								<option value="">Data Kosong</option>
							@endif
						@endfor
					</select>
				</td>
			</tr>

			<tr>
				<td width="2.5%">
					<label for="useSO" class="control-label" style="text-align: left;">Pakai SO</label>
				</td>
				<td width="30%">
					<span class="button-checkbox">
						<button type="button" class="btn" data-color="primary" id="useSO">Checked</button>
						<input id="SO" type="checkbox" class="hidden" name="useSO" />
					</span>
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<div class="col-sm-10 col-sm-offset-2" id="butt">
						<button onclick="addItem()" class="btn btn-primary btn-save collapse" id="add" type="button">
							<strong>Tambah Item</strong>
						</button>
			
						<a onclick="redirectTo('{{ route('DelOrder.index') }}')" class="btn btn-warning btn-save">
							<strong>Kembali</strong>
						</a>
					</div>
				</td>
			</tr>
		</table>
	</div>

	<div class="col-sm-4">
		<table class="table table-bordered table-hover" id="table-top-rightSide">
			<tr>
				<td width="2.5%">
					<label for="bruto" class="control-label">Bruto</label>
				</td>
				<td>
					<input name="bruto" type="number" class="form-control text-right" id="bruto" placeholder="Bruto" readonly>
				</td>
			</tr>

			<tr>
				<td width="2.5%">
					<label for="discount" class="control-label">Discount</label>
				</td>
				<td>
					<input name="discount" type="text" class="form-control text-right" id="discount_form" placeholder="Discount" readonly>
				</td>
			</tr>

			<tr>
				<td width="2.5%">
					<label for="netto" class="control-label">Netto</label>
				</td>
				<td>
					<input name="netto" type="number" class="form-control text-right" id="netto_form" placeholder="Netto" readonly>
				</td>
			</tr>
		</table>
	</div>


	<!-- <div class="col-sm-8">
		<div class="form-group">
			<label for="no" class="col-sm-2 control-label">Nomor.DO</label>
			<div class="col-sm-10">
				<input name="nomor" type="text" class="form-control" id="DO_number" placeholder="Nomor">
			</div>
		</div>
	
		<div class="form-group">
			<label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
			<div class="col-sm-4">
				<div class="input-group">
					<span class="input-group-addon">
					<i class="fa fa-calendar"></i>
					</span>
					<input name="tanggal" type="text" class="form-control date" id="tgl" placeholder="Tanggal">
				</div>
			</div>
	
			<label for="tempo" class="col-sm-2 control-label">Tempo</label>
			<div class="col-sm-4">
				<div class="input-group">
					<span class="input-group-addon">
					<i class="fa fa-calendar"></i>
					</span>
					<input name="tempo" type="text" class="form-control date" id="tgl" placeholder="Jatuh Tempo">
				</div>
			</div>
		</div>
															
		<div class="form-group">
			<label for="customer" class="col-sm-2 control-label">Customer</label>
			<div class="col-sm-10">
				<select id="customer" data-placeholder="Customer" class="chosen-select form-control col-sm-8">
					<option value="">-- Pilih Customer --</option>
					@for ($i = 0; $i < count($data); $i++)
						@if (!empty($data[$i]))
							<option value="{{ $data[$i][0]->kode }}">
								{{ $data[$i][0]->nama }}
							</option>
						@else
							<option value="">Data Kosong</option>
						@endif
					@endfor
				</select>
			</div>
		</div>
	
		<div class="form-group">
			<label for="useSO" class="col-sm-2 control-label">Pakai SO</label>
			<div class="col-sm-10">
				<span class="button-checkbox">
					<button type="button" class="btn" data-color="primary" id="useSO">Checked</button>
					<input id="SO" type="checkbox" class="hidden" name="useSO" />
				</span>
			</div>
		</div>
	
		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2" id="butt">
				<a onclick="addItem()" class="btn btn-primary btn-save collapse" id="add">
					<strong>Add Item</strong>
				</a>
	
				<a onclick="redirectTo('{{ route('DelOrder.index') }}')" class="btn btn-warning btn-save">
					<strong>Previous Page</strong>
				</a>
	
				<button onclick="onShow()" type="button" class="btn btn-primary btn-save" id="show" style="margin-left: 2px;">
					<strong>Show Table</strong>
				</button>
			</div>
		</div>
	</div> left side
	
	<div class="col-sm-4">
		
	
		<div class="form-group">
			<label for="bruto" class="col-sm-2 control-label">Bruto</label>
			<div class="col-sm-10">
				<input name="bruto" type="number" class="form-control" id="bruto" placeholder="Bruto" readonly>
			</div>
		</div>
	
		<div class="form-group">
			<label for="discount" class="col-sm-2 control-label">Disc <strong>Rp</strong></label>
			<div class="col-sm-10">
				<input name="discount" type="text" class="form-control" id="discount_form" placeholder="Discount" readonly>
			</div>
		</div>
	
		<div class="form-group">
			<label for="netto" class="col-sm-2 control-label">Netto</label>
			<div class="col-sm-10">
				<input name="netto" type="number" class="form-control" placeholder="Netto" readonly>
			</div>
		</div>
	</div> right side -->
</form>