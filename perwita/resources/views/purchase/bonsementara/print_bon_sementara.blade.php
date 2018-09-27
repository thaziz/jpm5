<!DOCTYPE html>
<html>
<head>
	<title>Print Berita Acara</title>
	<style>
*{
	font-family: arial;
}
table {
    border-collapse: collapse;
    font-size:14px;
}

table, td, th {
    border: 1px solid black;
}
.table1 tr > td{
	border-style: hidden;
}
.div-width{
	width: 90vw;
	margin: auto;
}
.top
{
	vertical-align: top;
	text-align: left;
}
.top-center
{
	vertical-align: top
	text-align:center;
}
.bottom
{
	vertical-align: bottom;
	text-align: left;
}
.blank
{
	height: 15px;
}
.tebal
{
	font-weight: bold;
}
.half-left
{
	float: left;
	width: 49.9%;
	border-right: 1px solid black;
}
.half-right
{
	float: right;
	width: 49.9%;
	border-left: 1px solid black;
}
.footer
{
	height: 70px;
}
.text-center{
	text-align: center;
}
.latin{
	font-family: 
}
.italic{
	font-style: italic;
}
.border-none table , .border-none tr , .border-none td{
	border: hidden !important;
}
.float-left{
	float: left;
}
.float-right{
	float: right;
}
@media print{
	margin:0;
}
@page{
	size: portrait;
}
.text-left{
	text-align: left;
}
.div-empty{
	
	height: 10px;
	width: 100%;
}
.border-none-left{
	border-left: hidden;
}

	</style>
</head>
<body>
<div class="div-width">
	
	<table width="100%" cellpadding="5px">
		<tr>
			<td width="1%"><img src="{{asset('perwita/storage/app/upload/images.jpg') }}" width="200px" height="100px"></td>
			<td class="text-center border-none-left">
				<h1>PT. JAWA PRATAMA MANDIRI</h1>
				<h2 class="italic">(CARGO, PAKET, LOGISTIK)</h2>
				<h3>Jl. Karah Agung 45 Surabaya Tlp ( 031 ) 8290606</h3>


			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="20%" class="float-right border-none" style="margin:5px;" cellpadding="3px">
					<tr>
						<td width="1%">No</td>
						<td width="1%">:</td>
						<td>
							<div class="div-empty"> {{$data['bonsem'][0]->bp_nota}}</div>
						</td>
					</tr>
					<tr>
						<td>Tgl</td>
						<td>:</td>
						<td>
							<div class="div-empty"> {{ Carbon\Carbon::parse($data['bonsem'][0]->bp_tgl)->format('d-M-Y ') }} </div>
						</td>
					</tr>
				</table>
				<br>
				<div class="text-center" width="100%" style="margin-top: 40px;">
					<h1>BON SEMENTARA</h1>
				</div>
				<table class="border-none " width="100%" cellpadding="5px">
					
					<tr class="text-left">
						<td>Bagian</td>
						<td>:</td>
						<td>
							<div class="div-empty"> {{$data['bonsem'][0]->bp_bagian}}</div>
						</td>
					</tr>
					<tr class="text-left">
						<td>Jumlah</td>
						<td>:</td>
						<td>
							<div class="div-empty"> {{number_format($data['bonsem'][0]->bp_nominalkeu , 2)}} </div>
						</td>
					</tr>
					<tr class="text-left">
						<td>Terbilang</td>
						<td>:</td>
						<td>
							<div class="div-empty"> {{$data['terbilang']}} Rupiah </div>
						</td>
					</tr>
					<tr class="text-left">
						<td>Keperluan</td>
						<td>:</td>
						<td>
							<div class="div-empty"> {{$data['bonsem'][0]->bp_keperluan}}  </div>
						</td>
					</tr>
				
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div style="height: 40px;">
					Keterangan : {{$data['bonsem'][0]->bp_keteranganpusat}}
				</div>

			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div class="float-left text-center">
					<div style="margin-bottom: 60px;">
						Dibuat oleh,
					</div>
					<div>
						(..............................................)
					</div>
					<div>
						( Admin Cab )
					</div>
				</div>

				<div class="float-left text-center">
					<div style="margin-bottom: 60px;">
						Mengetahui,
					</div>
					<div>
						(..............................................)
					</div>
					<div>
						( Kacab )
					</div>
				</div>

				<table class="float-right border-none" cellpadding="3px">
					<tr class="text-center">
						<td colspan="2">Menyetujui</td>
					</tr>
					<tr>
						<td>
							<div class="text-center">
								<div style="margin-top: 60px;">
									(..............................................)
								</div>
								<div>
									( Keuangan )
								</div>
							</div>
						</td>
						<td>
							<div class="text-center">
								<div style="margin-top: 60px;">
									(..............................................)
								</div>
								<div>
									( Manager Keuangan )
								</div>
							</div>
						</td>
					</tr>
				</table>

			</td>
		</tr>
	</table>

	

</div>
</body>
</html>