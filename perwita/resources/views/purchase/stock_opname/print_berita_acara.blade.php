<!DOCTYPE html>
<html>
<head>
	<title>Print Berita Acara</title>
	<style>
*{
	font-family: arial;
	text-align: center;
	
}
table {
    border-collapse: collapse;
    font-size:12px;
}

table, td, th {
    border: 1px solid black;
}
.table1 tr > td{
	border-style: hidden;
}
.div-width{
	width: 900px;
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


	</style>
</head>
<body>
<div class="div-width">
	<table width="100%">

	@foreach($data['stockopname'] as $i=>$val)
		<tr>
			<td width="125px"><img src="{{asset('perwita/storage/app/upload/images.jpg') }}" width="125px" height="60px"></td>
			<td align="center" width="280px"><h2>BERITA ACARA STOCK OPNAME</h2></td>
			<td class="top" width="130px">Bulan :  {{$data['tgl'][$i]}} </td>
			<td class="top" width="240px">Lokasi Gudang : {{$val->mg_namagudang}} </td>
		</tr>
		@endforeach
	</table>
	<table width="100%" style="border-top:hidden;">
		<tr>
			<td colspan="8" style="text-align: left">
				Berdasarkan hasil stock opname yang telah dilakukan pada tanggal :<br>
				maka terdapat barang barang yang mengalami selisih sebagai berikut :
			</td>
		</tr>
		<tr>
			<td rowspan="2" width="40px" class="tebal">No</td>
			<td rowspan="2" width="190px" class="tebal">Nama Barang</td>
			<td rowspan="2" width="100px" class="tebal">Satuan</td>
			<td colspan="2" class="tebal">Stock Barang</td>
			<td colspan="2" class="tebal">Jumlah Selisih</td>
			<td rowspan="2" class="tebal" width="170px">Keterangan / Tindak lanjut yang akan dilakukan</td>
		</tr>
		<tr>
			<td width="65px" class="tebal">Fisik Barang</td>
			<td width="65px" class="tebal">Sesuai KS</td>
			<td align="center" class="tebal" width="65px">+</td>
			<td align="center" width="65px" class="tebal">-</td>
		</tr>
		@foreach($data['stockopname_dt'] as $index=>$sodt)
		<tr>
			<td class="blank"> {{$index + 1}}</td>
			<td> {{$sodt->nama_masteritem}}</td>
			<td> {{$sodt->unitstock}} </td>
			<td> {{(int)$sodt->sod_jumlah_real}}  </td>
			<td> {{(int)$sodt->sod_jumlah_stock}} </td>
			@if($sodt->sod_status == 'lebih')
				<td> {{(int)$sodt->sod_jumlah_status}} </td>
				<td> - </td>
			@else
				<td> - </td>
				<td> {{(int)$sodt->sod_jumlah_status}} </td>
			@endif

			
			<td> {{$sodt->sod_keterangan}} </td>
			
		</tr>
		@endforeach
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
		</tr>
		<tr>
			<td class="blank"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
		</tr>
		<tr>
			<td colspan="3" class="tebal">Pelaksana Opname</td>
			<td colspan="5" class="tebal">Menyetujui</td>
		</tr>
	</table>

	<table width="100%" style="border-top: hidden;">
		<tr>
			<td width="200px" class="footer">
				<div class="top-center" style="padding-bottom: 50px;">Staff Gudang</div>
				<div class="bottom">Tanggal :</div>
			</td>
			<td width="182px">
				<div class="top-center" style="padding-bottom: 50px;">Staff Accounting</div>
				<div class="bottom">Tanggal :</div>
			</td>
			<td width="153px">
				<div class="top-center" style="padding-bottom: 35px;">Manajemen Umum dan HRD</div>
				<div class="bottom">Tanggal :</div>
			</td>
			<td width="153px">
				<div class="top-center" style="padding-bottom: 50px;">Manager dan Akuntansi</div>
				<div class="bottom">Tanggal :</div>
			</td>
			<td width="">
				<div class="top-center" style="padding-bottom: 50px;">Direktur Utama</div>
				<div class="bottom">Tanggal :</div>
			</td>
		</tr>
	</table>

</div>
</body>
</html>