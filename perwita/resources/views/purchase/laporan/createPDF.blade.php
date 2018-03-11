
<style>
	#table-parent{
		border: 2px solid #000;
	}

	div.surat{
		margin-top: 35px;
		font-size: 20px;
		line-height: 30px;
		font-weight: bold;
	}

	td#td-first, td#td-first-sibbling{
		border: 1px solid #000;
	}
	td#td-first-sibbling{
		width: auto;
		padding: 29px 7px 0;
	}
</style>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-content">
					<table class="table table-bordered" id="table-parent">
						<tr>
							<td valign="middle" align="center" id="td-first">
								<img src="{{ asset('/assets/img/dboard/logo/Capture.png') }}" alt="">
							</td>

							<td valign="middle" align="center" id="td-first">
								<div class="surat">
									SURAT PERMINTAAN PEMBELIAN
								</div>
							</td>

							<td valign="middle" id="td-first-sibbling">
								<table width="100%" style="height: auto;">
									<tr>
										<td width="75">No.SPP</td>
										<td width="5">:</td>
										<td width="25">{{ $dataSpp["noSpp"] }}</td>
									</tr>

									<tr>
										<td style="padding-top: 17px;">Tanggal</td>
										<td style="padding-top: 17px;">:</td>
										<td style="padding-top: 17px;">undefined</td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="3" style="border: 1px solid #000;">
								<table width="100%">
									<tr>
										<td width="20%">Diminta Oleh Bagian</td>
										<td width="1%">:</td>
										<td width="69%">Bag. {{ $dataSpp["namaBagian"] }}</td>
									</tr>

									<tr>
										<td>Untuk Keperluan</td>
										<td>:</td>
										<td>{{ $dataSpp["keperluan"] }}</td>
									</tr>

									<tr>
										<td>Tanggal Dibutukan</td>
										<td>:</td>
										<td>{{ $dataSpp["tglSpp"] }}</td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="3" style="padding: 0; border: 1px solid #000;">
								<table width="100%" border="1" style="height: 37px;">
									<tr>
										<td align="center" width="45.8%">Diisi Oleh Bagian Yang Membutuhkan Barang/Jasa</td>
										<td align="center">Diisi Oleh Bagian Pembelian</td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="3" style="padding: 0;">
								<table width="100%" border="1"  style="height: 75px;">
									<tr>
										<td rowspan="2" valign="middle" align="center">No</td>
										<td rowspan="2" valign="middle" align="center">Uraian/Nama Barang-Jasa</td>
										<td rowspan="2" valign="middle" align="center">Jumlah</td>
										<td rowspan="2" valign="middle" align="center">Satuan</td>
										<td colspan="3" align="center">Harga Untuk Masing-Masing Supplier</td>
										<td rowspan="2" valign="middle" align="center">NO.PO</td>
										<td rowspan="2" valign="middle" align="center">Keterangan</td>
									</tr>

									<tr>
							
												<td colspan="3" align="center" style="width: 15%;">
												
												</td>
									
												<td align="center" style="width: 15%;">
											
												</td>
							
												<td  align="center" style="width: 13%;">
									
												</td>
								
									</tr>
									
									<span hidden="true"></span>
									<!-- jika hanya stu supplier -->
								
											<tr>
												<td align="center"></td>
												<td align="center"></td>
												<td align="center"></td>
												<td align="center"></td>
												<td align="center" colspan="3"></td>
												<td align="center"></td>
												<td align="center">Keterangan</td>
											</tr>
					
											<tr>
												<td align="center"></td>
												<td align="center"></td>
												<td align="center"></td>
												<td align="center"></td>
												<td align="center"></td>
												
														<td align="center">-</td>
								
														<td align="center" colspan="2">-</td>
							
													<td align="center" colspan="3">-</td>
				
												<td align="center"></td>
												<td align="center">Keterangan</td>
											</tr>
									
													<tr>
														<td align="center"></td>
														<td align="center"></td>
														<td align="center"></td>
														<td align="center"></td>
														<td align="center">-</td>
														<td align="center" colspan="2"></td>
														<td align="center"></td>
														<td align="center">Keterangan</td>
													</tr>
									
												<span hidden="true"></span>
										
												<tr>
													<td align="center"></td>
													<td align="center"></td>
												</tr>
									
												<tr>
													<td align="center"></td>
													<td align="center"></td>
													<td align="center"></td>
													<td align="center"></td>
													<td align="center">-</td>
													<td align="center"></td>
													<td></td>
													<td align="center"></td>
													<td align="center">Keterangan</td>
												</tr>
							
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="3" style="padding: 0">
								<table width="100%" border="1">
									<tr>
										<td rowspan="2" width="10%">Catatan</td>
										<td>1.Hubungi minimal 2 supplier dan tuliskan nama supplier yang dihubungi, bila hanya ada 1 supplier tuliskan di keterangan alasanya</td>
									</tr>

									<tr>
										<td>2.Lingkari dan beri paraf pada supplier yang dipilih (yang dilakukan oleh Manager Keuangan dan Akuntansi)</td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="3">
								<table width="100%">
									<tr>
										<td >Perhitungan</td>
										<td rowspan="2" width="100%">:</td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="3">
								<table width="100%" border="1">
									<tr>
										<td align="center" width="50%" colspan="2">peminta barang/jasa</td>
										<td align="center" colspan="3">bagian pembelian barang/jasa</td>
									</tr>

									<tr>
										<td height="100" valign="top" align="center" width="100">
											Diminta Oleh
										</td>
										<td valign="top" align="center" width="100">
											Disetujui oleh
										</td>
										<td valign="top" align="center" width="100">
											staff pembelian
										</td>
										<td valign="top" align="center" width="100">
											dikontrol oleh
										</td>
										<td valign="top" align="center" width="100">
											Manager Keuangan Dan Akutansi
										</td>
									</tr>

									<tr>
										<td width="100"> TGL : </td>
										<td width="100">	</td>
										<td width="100"> TGL : </td>
										<td width="100"> TGL : </td>
										<td width="100"> TGL : </td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>	
	</div>
</div>
@endsection