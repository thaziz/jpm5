<div class="modal" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form method="POST" class="form-horizontal" data-toggle="validator">
				{{ csrf_field() }} {{ method_field('POST') }}
				<div class="modal-header">
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h3 class="modal-title"></h3>
				</div>  <!-- end modal-header -->
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12">
								<div class="col-xs-6">
									<table class="table table-bordered table-hover">
										<tr>
											<td width="5%">
												<label for="seq" class="control-label">Seq</label>
											</td>
											<td>
												<input type="number" id="seq" name="seq" class="form-control" autofocus readonly>
												<span class="help-block with-errors"></span>
											</td>
											<td width="5%">
												<label for="kode_item" class="control-label">Kode Item</label>
											</td>
											<td>
												<input type="text" id="kode_item" name="kode_item" class="form-control" autofocus  readonly>
												<span class="help-block with-errors"></span>
											</td>
										</tr>

										<tr>
											<td colspan="4">
												<select id="nama_item" data-placeholder="Pilih Item" class="chosen-select-width form-control">
													<option value="Belum Memilih">--_Pilih Nama Item_--</option>
													@for ($i = 0; $i < count($item); $i++)
														<option value="{{ $item[$i]->kode }},{{ $item[$i]->kode_satuan }},{{ $item[$i]->harga }}">
															{{ $item[$i]->nama }}
														</option>
													@endfor
												</select>
												<span class="help-block with-errors"></span>
											</td>
										</tr>
										
										<tr>
											<td colspan="4">
												<table width="100%" class="table table-bordered table-hover">
													<tr>
														<td width="5%">
															<label for="satuan" class="control-label" style="text-align: left;">
																Satuan
															</label>
														</td>
														<td width="50%">
															<input type="text" id="nominal_satuan1" name="nominal_satuan1" class="form-control" autofocus readonly style="text-align: right;">
															<span class="help-block with-errors"></span>
														</td>
														<td width="30%">
															<input type="text" id="satuan_satu" name="satuan" class="form-control" autofocus readonly>
														</td>
													</tr>

													<!-- <tr>
														<td width="5%">
															<label for="satuan_dua" class="control-label" style="text-align: left;">
																Satuan Dua
															</label>
														</td>
														<td width="50%">
															<input type="text" id="nominal_satuan2" name="satuan_dua" class="form-control" autofocus  readonly>
																<span class="help-block with-errors"></span>
														</td>
														<td width="30%">
															<input type="text" id="satuan_dua" name="satuan_dua" class="form-control" autofocus  readonly >
														</td>
													</tr> -->
													<tr>
														<td width="5%">
															<label for="total" class="control-label" style="text-align: left;">
																Total
															</label>
														</td>
														<td width="50%">
															<input type="text" id="total" name="total" class="form-control" autofocus style="text-align: right;" readonly>
															<span class="help-block with-errors"></span>
														</td>
														<td width="30%">
															<input type="text" id="total_satuan" name="total_satuan" class="form-control" autofocus readonly>
														</td>
													</tr>
													<tr>
														<td width="5%">
															<label for="harga" class="control-label">
																Harga
															</label>
														</td>
														<td>
															<input type="text" id="harga" name="harga" class="form-control" autofocus style="text-align: right;">
															<span class="help-block with-errors"></span>
														</td>
														<td>
															<dl style="display: inline-block; margin-bottom: 0;">
																<dt style="width: 10%; display: inline-block;">
																	<h3>/</h3>
																</dt>
																<dd style="width: 83%; display: inline-block;">
																	<input type="text" id="harga_satuan" class="form-control" autofocus  readonly >
																</dd>
															</dl>
														</td>
													</tr>
													<tr>
														<td>
															<label for="jumlah" class="control-label" style="text-align: left;">
																Jumlah Harga
															</label>
														</td>
														<td colspan="3">
															<input type="text" id="jumlah" name="jumlah" class="form-control" autofocus style="text-align: right;" readonly>
															<span class="help-block with-errors"></span>
														</td>
													</tr>
													<tr>
														<td>
															<label for="discount" class="control-label" style="text-align: left;">
																Discount
															</label>
														</td>
														<td colspan="3">
															<dl style="display: inline-block; margin-bottom: 0;">
																<dt style="width: 20%; display: inline-block;">
																	<input type="text" id="discount" name="diskon" class="form-control" autofocus >
																</dt>
																<dd style="display: inline-block;">%</dd>
																<dt style="display: inline-block;">= Rp</dt>
																<dd style="width: 56%; display: inline-block;">
																	<input type="text" id="rupiah" name="rupiah" class="form-control" autofocus readonly>
																</dd>
															</dl>
														</td>
													</tr>
													<tr>
														<td width="5%">
															<label for="netto" class="control-label">
																Netto
															</label>
														</td>
														<td colspan="3">
															<input type="text" id="netto" name="netto" class="form-control" autofocus style="text-align: right;" readonly>
															<span class="help-block with-errors"></span>
														</td>
													</tr>
													<tr>
														<td width="5%">
															<label for="keterangan" class="control-label" style="text-align: left;">
																Keterangan
															</label>
														</td>
														<td colspan="3">
															<input type="text" id="keterangan" name="keterangan" class="form-control" autofocus >
															<span class="help-block with-errors"></span>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</div>

								<div class="col-xs-6">
									<table class="table table-bordered table-hover">
										<tr>
											<td width="10%">
												<label for="kota_tujuan" class="control-label" style="text-align: left;">
													Kota Tujuan
												</label>
											</td>
											<td width="25%">
												<input type="text" id="kota_tujuan" name="kota_tujuan" class="form-control" autofocus >
											</td>
											<td width="60%">
												<input type="text" id="kota_tujuan" name="kota_tujuan" class="form-control" autofocus >
												<span class="help-block with-errors"></span>
											</td>
										</tr>

										<tr>
											<td width="10%">
												<label for="kota_asal" class="control-label" style="text-align: left;">
													Kota Asal
												</label>
											</td>
											<td width="25%">
												<input type="text" id="kota_asal" name="kota_asal" class="form-control" autofocus >
											</td>
											<td width="60%">
												<input type="text" id="kota_asal" name="kota_asal" class="form-control" autofocus >
												<span class="help-block with-errors"></span>
											</td>
										</tr>

										<tr>
											<td colspan="3">
												<table class="table table-bordered table-hover">
													<tr>
														<td colspan="3">
															<span class="button-transportation" id="button-transportation">
																<button type="button" class="btn" data-color="primary" id="useAng">Pakai Angkutan</button>
																<input id="ang" name="useAng" type="checkbox" class="hidden" name="useAng" />
															</span>
														</td>
													</tr>
													<tr class="transportation">
														<td>
															<label for="nopol" class="control-label" style="text-align: left;">
																No.Pol
															</label>
														</td>
														<td>
															<input type="text" id="nopol" name="nopol" class="form-control" autofocus>
														</td>
														<td>
															<input type="text" id="nopol" name="nopol" class="form-control" autofocus>
														</td>
													</tr>
													<tr class="transportation">
														<td>
															<label for="kode_sopir" class="control-label" style="text-align: left;">
																Kode Sopir
															</label>
														</td>
														<td>
															<input type="text" id="kode_sopir" name="kode_sopir" class="form-control" autofocus>
														</td>
														<td>
															<input type="text" id="kode_sopir" name="kode_sopir" class="form-control" autofocus>
														</td>
													</tr>
													<tr class="transportation">
														<td>
															<label for="kode_marketing" class="control-label" style="text-align: left;">
																Kode Marketing
															</label>
														</td>
														<td>
															<input type="text" id="kode_marketing" name="kode_marketing" class="form-control" autofocus>
														</td>
														<td>
															<input type="text" id="kode_marketing" name="kode_marketing" class="form-control" autofocus>
														</td>
													</tr>
													<tr class="transportation">
														<td>
															<label for="cabang" class="control-label" style="text-align: left;">
																Cabang
															</label>
														</td>
														<td>
															<input type="text" id="cabang" name="cabang" class="form-control" autofocus>
														</td>
														<td>
															<input type="text" id="cabang" name="cabang" class="form-control" autofocus>
														</td>
													</tr>
													<tr class="transportation">
														<td>
															<label for="angkutan" class="control-label" style="text-align: left;">
																Tipe Angkutan
															</label>
														</td>
														<td>
															<input type="text" id="angkutan" name="angkutan" class="form-control" autofocus>
														</td>
														<td>
															<input type="text" id="angkutan" name="angkutan" class="form-control" autofocus>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</div>
								<div class="col-xs-12">
									<div class="modal-footer">
										<input type="submit" id="save" class="btn btn-primary btn-save" value="Save" />
										<button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">
											Cancel
										</button>
									</div> <!-- modal-footer -->
								</div>
								<!-- <div class="col-xs-6">
									<div class="form-group">
										<input type="hidden" id="id" name="id">
										<label for="seq" class="col-md-2 control-label">Seq</label>
										<div class="col-md-3">
											<input type="number" id="seq" name="seq" class="form-control" autofocus  readonly>
											<span class="help-block with-errors"></span>
										</div>
								
										<label for="kode_item" class="col-md-3 control-label">Kode Item</label>
										<div class="col-md-4">
											<input type="text" id="kode_item" name="kode_item" class="form-control" autofocus  readonly>
											<span class="help-block with-errors"></span>
										</div>
									</div>  end form-group
								
									<div class="form-group">
										<div class="col-md-12" id="select_item">
											<div id="sempak">
												<select id="nama_item" data-placeholder="Pilih Item" class="chosen-select-width form-control">
													<option value="Belum Memilih">--_Pilih Nama Item_--</option>
													@for ($i = 0; $i < count($item); $i++)
														<option value="{{ $item[$i]->kode }},{{ $item[$i]->kode_satuan }},{{ $item[$i]->harga }}">
															{{ $item[$i]->nama }}
														</option>
													@endfor
												</select>
											</div>
											<span class="help-block with-errors"></span>
										</div>
									</div>
								</div>
															</div>
														</div> row Item
								
														<div class="row">
															<div class="col-xs-6">
								<div class="col-xs-12">	
									<div class="form-group">
										<label for="satuan" class="col-md-2 control-label">Satuan</label>
										<div class="col-md-6">
											<input type="text" id="nominal_satuan1" name="satuan" class="form-control" autofocus  readonly>
											<span class="help-block with-errors"></span>
										</div>
								
										<div class="col-md-3">
											<input type="text" id="satuan_satu" name="satuan_satu" class="form-control" autofocus  readonly>
										</div>
									</div>
								
									<div class="form-group">
										<label for="satuan_dua" class="col-md-2 control-label">Satuan Dua</label>
										<div class="col-md-6">
											<input type="text" id="nominal_satuan2" name="satuan_dua" class="form-control" autofocus  readonly>
											<span class="help-block with-errors"></span>
										</div>
								
										<div class="col-md-3">
											<input type="text" id="satuan_dua" name="satuan_dua" class="form-control" autofocus  readonly >
											<span class="help-block with-errors"></span>
										</div>
									</div>
									<hr class="text-center" />
								
									<div class="form-group">
										<label for="harga" class="col-md-2 control-label">Harga</label>
										<div class="col-md-6">
											<input type="text" id="harga" name="harga" class="form-control" autofocus >
											<span class="help-block with-errors"></span>
										</div>
								
										<div class="col-md-4">
											<p style="display: inline-block; margin: 0; width: 10%;">
												<strong style="font-size: 24px; font-weight: bolder;">/</strong> 
											</p>
											<input type="text" id="harga_satuan" class="form-control pull-right" autofocus  readonly style="width: 70%;">
											<span class="help-block with-errors"></span>
										</div>
									</div>
								
									<div class="form-group">
										<label for="jumlah" class="col-md-2 control-label">Jumlah Item</label>
										<div class="col-md-10">
											<input type="text" id="jumlah" name="jumlah" class="form-control" autofocus >
											<span class="help-block with-errors"></span>
										</div>
									</div>
								
									<div class="form-group">
										<label for="total" class="col-md-2 control-label">Total</label>
										<div class="col-md-6">
											<input type="text" id="total" name="total" class="form-control" autofocus>
											<span class="help-block with-errors"></span>
										</div>
								
										<div class="col-md-3">
											<input type="text" id="total_satuan" name="total" class="form-control" autofocus  readonly>
											<span class="help-block with-errors"></span>
										</div>
									</div>
								</div>
															</div> Perhitungan
								
															<div class="col-xs-6">
								<div class="col-xs-12">
									<div class="form-group">
										<div class="col-md-6 col-md-offset-3">
											<span class="button-transportation" id="button-transportation">
												<button type="button" class="btn" data-color="primary" id="useAng">	
													Pakai Angkutan
												</button>
												<input id="ang" name="useAng" type="checkbox" class="hidden" name="useAng" />
											</span>
										</div>
									</div>
								
									<div class="form-group transportation">
										<label for="nopol" class="col-md-3 control-label">No.Pol</label>
										<div class="col-md-6">
											<input type="text" id="nopol" name="nopol" class="form-control" autofocus>
										</div>
									</div>
								
									<div class="form-group transportation">
										<label for="kode_sopir" class="col-md-3 control-label">Kode Sopir</label>
										<div class="col-md-6">
											<input type="text" id="kode_sopir" name="kode_sopir" class="form-control" autofocus>
										</div>
									</div>
								
									<div class="form-group transportation">
										<label for="kode_marketing" class="col-md-3 control-label">
											Kode Marketing
										</label>
										<div class="col-md-6">
											<input type="text" id="kode_marketing" name="kode_marketing" class="form-control" autofocus>
										</div>
									</div>
								
									<div class="form-group transportation">
										<label for="cabang" class="col-md-3 control-label">
											Cabang
										</label>
										<div class="col-md-6">
											<input type="text" id="cabang" name="cabang" class="form-control" autofocus>
										</div>
									</div>
								
									<div class="form-group transportation">
										<label for="angkutan" class="col-md-3 control-label">
											Tipe Angkutan
										</label>
										<div class="col-md-6">
											<input type="text" id="angkutan" name="angkutan" class="form-control" autofocus>
										</div>
									</div>
								</div>
															</div> Kendaraan
														</div> row perhitungan && Kendaraan
								
														<div class="row">
															<div class="col-xs-6">
								<div class="col-xs-12">
									<div class="form-group">
										<label for="discount" class="col-md-2 control-label">Discount</label>
										<div class="col-md-3">
											<input type="text" id="discount" name="diskon" class="form-control" autofocus >
											<span class="help-block with-errors"></span>
										</div>
								
										<div class="col-md-6">
											<p style="display: inline-block; margin: 0; width: 30%;">
												<strong>%</strong> 
												<span style="font-size: 15px;">= Rp</span>
											</p>
											<input type="text" id="rupiah" name="rupiah" class="form-control pull-right" autofocus  readonly style="width: 70%;">
											<span class="help-block with-errors"></span>
										</div>
									</div>
								</div>
															</div>
														</div>
								
														<div class="row">
															<div class="col-xs-6">
								<div class="col-xs-12">
									<div class="form-group">
										<label for="netto" class="col-md-2 control-label">Netto</label>
										<div class="col-md-10">
											<input type="text" id="netto" name="netto" class="form-control" autofocus >
											<span class="help-block with-errors"></span>
										</div>
									</div>
								</div>	
															</div>
														</div>
								
														<div class="row">
															<div class="col-xs-6">
								<div class="col-xs-12">
									<div class="form-group">
										<label for="keterangan" class="col-md-2 control-label">
											Ket
										</label>
										<div class="col-md-10">
											<input type="text" id="keterangan" name="keterangan" class="form-control" autofocus >
											<span class="help-block with-errors"></span>
										</div>
									</div>
								</div>
															</div>
														</div>
								
														<div class="row">
															<div class="col-xs-6">
								<div class="col-xs-12">
									<input type="text" id="nomor_DO" name="nomor_DO" hidden>
								</div>
															</div>
														</div> -->
					</div> <!-- container-fluid -->
				</div> <!-- end modal-body -->
			</form>
		</div> <!-- end modal-content -->
	</div><!-- end modal-dialog modal-lg  -->
</div> <!-- end modal parent -->