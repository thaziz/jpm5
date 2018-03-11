@extends('main')

@section('title', 'dashboard')

@section('extra_styles')
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

	table tr.th td{
		border-color: #000;
		border-style: solid;
		border-width: 0 1px 1px 0;
	}

	table tr.tabel-data td {
		border-color: #000;
		border-style: solid;
		border-width: 0 1px 1px 0;
		height: 18px;
	}

	table tr.ttd td{
		border-color: #000;
		border-style: solid;
		border-width: 0 1px 1px 0;
	}

	table tr.tgl td{
		border-color: #000;
		border-style: solid;
		border-width: 0 1px 1px 0;
	}
</style>
@endsection

@section('content')
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
								<table class="" width="100%" style="height: auto;">
									<tr>
										<td width="75">No.SPP</td>
										<td width="5">:</td>
										<td width="25">{{ $spp["no_spp"] }}</td>
									</tr>

									<tr>
										<td width="75">No.SPP</td>
										<td width="5">:</td>
										<td width="25">{{ $spp["cabang"] }}</td>
									</tr>

									<tr>
										<td>Tanggal</td>
										<td>:</td>
										<td>{{ $spp["created_at"] }}</td>
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
										<td width="69%">Bag. {{ $spp["bagian"] }}</td>
									</tr>

									<tr>
										<td>Untuk Keperluan</td>
										<td>:</td>
										<td>{{ $spp["keperluan"] }}</td>
									</tr>

									<tr>
										<td>Tanggal Dibutukan</td>
										<td>:</td>
										<td>{{ $spp["tglSpp"] }}</td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="3" style="padding: 0; border: 1px solid #000;">
								<table width="100%" style="height: 37px;">
									<tr>
										<td align="center" width="45.8%" style="border-right: 1px solid #000;">
											Diisi Oleh Bagian Yang Membutuhkan Barang/Jasa
										</td>

										<td align="center">Diisi Oleh Bagian Pembelian</td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="3" style="padding: 0;">
								<table width="100%" id="sempak" style="height: 75px; border-style: solid; border-color: #000; border-width: 0 1px 1px 1px;">
									<tr class="th">
										<td rowspan="2" valign="middle" align="center" width="3%">No</td>
										<td rowspan="2" valign="middle" align="center" width="15%">
											Uraian/Nama Barang-Jasa
										</td>

										<td rowspan="2" valign="middle" align="center" width="5%">Jumlah</td>
										<td rowspan="2" valign="middle" align="center" width="7%">Satuan Barang</td>
										<td colspan="3" align="center">Harga Untuk Masing-Masing Supplier</td>
										<td rowspan="2" valign="middle" align="center" width="15%">NO.PO</td>
										<td rowspan="2" valign="middle" align="center" width="30%">Keterangan</td>
									</tr>

									<tr id="supplier">
										@foreach ($suppliers as $supplier)
											@if (count($suppliers) === 1)
												<td align="center" colspan="3" width="23%" style="border-bottom: 1px solid #000;">
													{{ $supplier }}
												</td>
											@elseif (count($suppliers) === 2)
												<td align="center" colspan="1" width="17%" style="border-style: solid; border-color: #000; border-width: 0 1px 1px 0;">
													{{ $supplier }}
												</td>
											@else 
												<td align="center" width="10%" style="border-style: solid; border-color: #000; border-width: 0 1px 1px 0;">
													{{ $supplier }}
												</td>
											@endif
										@endforeach
									</tr>
									
									@if (count($suppliers) === 1)
										@for ($i = 0; $i < count($supplier1["barang"]); $i++)
											<tr class="tabel-data">
												<td align="center">{{ $i + 1 }}</td>
												<td align="center">{{ $supplier1["barang"][$i] }}</td>
												<td align="center">{{ $supplier1["quantity"][$i] }}</td>
												<td align="center">{{ $supplier1["unitstock"][$i] }}</td>
												<td align="right">
													@ Rp {{ number_format((int) $supplier1["hargaSatuan"][$i], 2, ",", ".") }}
												</td>

												<td align="right" colspan="3">
													@ Rp {{ number_format((int) $supplier1["hargaTotal"][$i], 2, ",", ".") }}
												</td>

												<td align="center">{{ $spp["noPO"] }}</td>
												<td align="center">Sudah Terang</td>
											</tr>
										@endfor

										@for ($i = 0; $i < 7; $i++)
											<tr class="tabel-data">
												<td height="18"></td>
												<td height="18"></td>
												<td height="18"></td>
												<td height="18"></td>
												@if ($i === 5)
													<td height="30" align="center" valign="middle"><strong>Total</strong></td>
													<td height="30" colspan="3" align="right" valign="middle">
														<strong>
															@ Rp {{ number_format((int) $supplier1["TOTAL"], 2, ",", ".") }}
														</strong>
													</td>

													<td height="30" align="center" valign="middle">---</td>
													<td height="30" align="center" valign="middle">---</td>
													@break
												@endif
												<td height="18"></td>
												<td height="18" colspan="3"></td>
												<td height="18"></td>
												<td height="18"></td>
											</tr>
										@endfor
									@else
										<span hidden="true">{{ $index = 1 }}</span>
										@if (count($suppliers) === 2)
											@for ($i = 0; $i < count($supplier1["barang"]); $i++)
												<tr class="tabel-data">
													<td align="center">{{ $index++ }}</td>
													<td align="center">{{ $supplier1["barang"][$i] }}</td>
													<td align="center">{{ $supplier1["quantity"][$i] }}</td>
													<td align="center">{{ $supplier1["unitstock"][$i] }}</td>
													<td align="right">
														@ Rp {{ number_format((int) $supplier1["hargaSatuan"][$i], 2, ',', '.') }}
													</td>

													@for ($j = 0; $j < count($supplier1["hargaTotal"][$i]); $j++)
														@if ($supplier1["hargaTotal"][$i][$j] === "---")
															<td align="center" colspan="2">{{ $supplier1["hargaTotal"][$i][$j] }}</td>
														@else
															<td align="right" colspan="1">
																@ Rp {{ number_format((int) $supplier1["hargaTotal"][$i][$j], 2, ',', '.') }}
															</td>
														@endif
													@endfor

													<td align="center">{{ $spp["noPO"] }}</td>
													<td align="center">Sudah Terang</td>
												</tr class="tabel-data">
											@endfor

											@for ($i = 0; $i < count($supplier2["barang"]); $i++)
												<tr class="tabel-data">
													<td align="center">{{ $index++ }}</td>
													<td align="center">{{ $supplier2["barang"][$i] }}</td>
													<td align="center">{{ $supplier2["quantity"][$i] }}</td>
													<td align="center">{{ $supplier2["unitstock"][$i] }}</td>
													<td align="right">
														@ Rp {{ number_format((int) $supplier2["hargaSatuan"][$i], 2, ',', '.') }}
													</td>

													@for ($j = 0; $j < count($supplier2["hargaTotal"][$i]); $j++)
														@if ($supplier2["hargaTotal"][$i][$j] === "---")
															<td align="center" colspan="1">{{ $supplier2["hargaTotal"][$i][$j] }}</td>
														@else
															<td align="right" colspan="2">
																@ Rp {{ number_format((int) $supplier2["hargaTotal"][$i][$j], 2, ',', '.') }}
															</td>
														@endif
													@endfor

													<td align="center">{{ $spp["noPO"] }}</td>
													<td align="center">Sudah Terang</td>
												</tr>
											@endfor

											@for ($i = 0; $i < 7; $i++)
												<tr class="tabel-data">
													<td height="18"></td>
													<td height="18"></td>
													<td height="18"></td>
													<td height="18"></td>
													<td height="18"></td>
													<td height="18" colspan="3"></td>
													<td height="18"></td>
													<td height="18"></td>
												</tr>
											@endfor
										@else 
											@if( (count($supplier2["barang"]) === count($supplier1["barang"])) && 
												 (count($supplier3["barang"]) === count($supplier1["barang"])) &&
												 (count($supplier2["barang"]) === count($supplier3["barang"]))
											   )
												@for ($i = 0; $i < count($supplier1["barang"]); $i++)
													<tr class="tabel-data">
														<td align="center" height="18">{{ $index++ }}</td>
														<td align="center">{{ $supplier1["barang"][$i] }}</td>
														<td align="center">{{ $supplier1["quantity"][$i] }}</td>
														<td align="center">{{ $supplier1["unitstock"][$i] }}</td>
																
														@if ( ($supplier2["barang"][$i] === $supplier1["barang"][$i]) &&
															  ($supplier3["barang"][$i] === $supplier1["barang"][$i]) &&
															  ($supplier2["barang"][$i] === $supplier3["barang"][$i])
															)
															<td align="right" class="supp1">
																@ Rp {{ number_format((int) $supplier1["hargaSatuan"][$i], 2, ',', '.') }}
															</td>
															<td align="right">
																@ Rp {{ number_format((int) $supplier2["hargaSatuan"][$i], 2, ',', '.') }}
															</td>
															<td align="right">
																@ Rp {{ number_format((int) $supplier3["hargaSatuan"][$i], 2, ',', '.') }}
															</td>
														@endif
														<td align="center">{{ $spp["noPO"] }}</td>
														<td align="center">Sudah Terang</td>
													</tr>
												@endfor
											@elseif ( (count($supplier2["barang"]) !== count($supplier1["barang"])) ||
													  (count($supplier3["barang"]) !== count($supplier1["barang"])) ||
													  (count($supplier2["barang"]) !== count($supplier3["barang"]))
													)
												@for ($i = 0; $i < count($supplier1["barang"]); $i++)
													<tr class="tabel-data">
														<td align="center" height="18">{{ $index++ }}</td>
														<td align="center">{{ $supplier1["barang"][$i] }}</td>
														<td align="center">{{ $supplier1["quantity"][$i] }}</td>
														<td align="center">{{ $supplier1["unitstock"][$i] }}</td>
													</tr>
												@endfor
											@endif

											@for ($i = 0; $i < 7; $i++)
												<tr class="tabel-data empty">
													<td height="18"></td>
													<td height="18"></td>
													<td height="18"></td>
													<td height="18"></td>
													<td height="18"></td>
													<td height="18"></td>
													<td height="18"></td>
													<td height="18"></td>
													<td height="18"></td>
													<td height="18"></td>
												</tr>
											@endfor
										@endif
									@endif
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="3" style="padding: 0; margin: 0;">
								<table width="100%" style="border-color: #000; border-style: solid; border-width: 0 1px 1px 1px;">
									<tr>
										<td rowspan="2" width="10%">
											Catatan
										</td>
										<td  style="border-color: #000; border-style: solid; border-width: 0 0 1px 1px;">
											1.Hubungi minimal 2 supplier dan tuliskan nama supplier yang dihubungi, bila hanya ada 1 supplier tuliskan di keterangan alasanya
										</td>
									</tr>

									<tr>
										<td>2.Lingkari dan beri paraf pada supplier yang dipilih (yang dilakukan oleh Manager Keuangan dan Akuntansi)</td>
									</tr>
								</table>
							</td>
						</tr>

						<!-- <tr>
							<td colspan="3" style="padding: 0;">
								<table width="100%" style="border-color: #000; border-style: solid; border-width: 0 1px 1px 1px; margin">
									<tr>
										<td >Perhitungan</td>
										<td rowspan="2" width="100%">:</td>
									</tr>
								</table>
							</td>
						</tr> -->

						<tr>
							<td colspan="3" style="padding: 0;">
								<table width="100%" style="border-color: #000; border-style: solid; border-width: 0 1px 1px 1px;">
									<tr>
										<td align="center" width="50%" colspan="2" style="border-color: #000; border-style: solid; border-width: 0 1px 1px 0;">
											peminta barang/jasa
										</td>

										<td align="center" colspan="3" style="border-bottom: 1px solid #000;">bagian pembelian barang/jasa</td>
									</tr>

									<tr class="ttd">
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

									<tr class="tgl">
										<td width="100"> TGL : </td>
										<td width="100"> TGL : </td>
										<td width="100"> TGL : </td>
										<td width="100"> TGL : </td>
										<td width="100"> TGL : </td>
									</tr>
									
									<tr>
										<td colspan="2">
											<dl style="width: 100%; margin: 0; padding: 0;">
												<dt style="width: 5%; display: inline-block; margin-left: 8px;">1. </dt>
												<dd style="width: 50%; display: inline-block;">Arsip yang meminta barang / jasa</dd>
											</dl>
										</td>
										<td colspan="3">
											<dl style="width: 100%; margin: 0; padding: 0;">
												<dt style="width: 5%; display: inline-block; margin-left: 8px;">2. </dt>
												<dd style="width: 50%; display: inline-block;">Barang Pembelian</dd>
											</dl>
										</td>
									</tr>

									<tr>
										<td colspan="4" style=""></td>
										<td align="center">{{ $spp["noForm"] }}</td>
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


@section("extra_scripts")
<script type="text/javascript">
	window.onload = function () {
		/*(function () {
			var table = document.getElementById("sempak"),
				tbody = table.childNodes[1],
				dataTR = new Array();
				number = 1;
			
			tbody.setAttribute("id", "sempak-body");

			for(var i = 4; i < tbody.childNodes.length; i++){
				if (tbody.childNodes[i].nodeName == "#text") {
					continue;
				} 

				if (tbody.childNodes[i].classList.contains("empty")) {
					continue;
				}
				
				tbody.childNodes[i].setAttribute("id", "data" + number);
				number += 1;
			}

			for(var i = 4; i < tbody.childNodes.length; i++){
				if (tbody.childNodes[i].nodeName == "#text") {
					continue;
				} 

				if (tbody.childNodes[i].classList.contains("empty")) {
					continue;
				}
			}
		}());*/
	};
</script>
@endsection