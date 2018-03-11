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
</style>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<div class="ibox float-e-margins">
				<div class="ibox-content">
					<a class="btn btn-info" href="{{ route('masterSupplier.ViewReport', ['download' => 'pdf']) }}">
                        <i class="fa fa-print" aria-hidden="true"></i> Download PDF 
                    </a> 
					<table border="1" class="table table-bordered" id="table-parent">
						<tr>
							<td valign="middle" align="center" id="td-first">
								<img src="{{ asset('/assets/img/dboard/logo/Capture.png') }}" alt="">
							</td>

							<td valign="middle" align="center" id="td-first">
								<div class="surat">
									LAPORAN MASTER BARANG PEMBELIAN
								</div>
							</td>

							<td valign="middle" id="td-first-sibbling">
								<table width="100%" style="height: auto;">
									<tr>
										<td width="75">Tanggal</td>
										<td width="5">:</td>
										<td width="25"></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="3" style="padding: 0;">
								<table width="100%" style="height: 50px; padding: 0;" border="1">
									<tr>
										<td valign="middle" align="center" style="height: 50px;">NO</td>
										<td valign="middle" align="center">Nama</td>
										<td valign="middle" align="center">Alamat</td>
										<td valign="middle" align="center">Kota</td>
										<td valign="middle" align="center">Cabang</td>
										<td valign="middle" align="center">Kode Pos</td>
										<td valign="middle" align="center">Telp</td>
										<td valign="middle" align="center">Contact Person</td>
										<td valign="middle" align="center">Status</td>
									</tr>

									@for ($index = 0; $index < count($masterSupplier["nama"]); $index++)
										<tr>
											<td valign="middle" align="center" width="5%">{{ $index + 1 }}</td>
											<td valign="middle" align="center" width="13%">
												{{ $masterSupplier["nama"][$index] }}
											</td>
											<td valign="middle" align="center" width="13%">
												{{ $masterSupplier["alamat"][$index] }}
											</td>
											<td valign="middle" align="center" width="13%">
												{{ $masterSupplier["kota"][$index] }}
											</td>
											<td valign="middle" align="center" width="8%">
												{{ $masterSupplier["cabang"][$index] }}
											</td>
											<td valign="middle" align="center" width="13%">
												{{ $masterSupplier["kodePos"][$index] }}
											</td>
											<td valign="middle" align="center" width="13%">
												{{ $masterSupplier["telp"][$index] }}
											</td>
											<td valign="middle" align="center" width="13%">
												{{ $masterSupplier["contPerson"][$index] }}
											</td>
											<td valign="middle" align="center" width="13%">
												{{ $masterSupplier["status"][$index] }}
											</td>
										</tr>
									@endfor
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