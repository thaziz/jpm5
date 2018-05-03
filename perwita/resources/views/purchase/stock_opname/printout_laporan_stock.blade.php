<!DOCTYPE html>
<html>
<head>
	<title>Print Laporan Stock</title>
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
			<td width="125px"><img src="" width="125px" height="60px"></td>
			<td align="center" width="280px"><h2>LAPORAN STOCK</h2></td>
			<td class="top" width="130px">Bulan :</td> <td> {{$data['tgl'][$i]}} </td>
			<td class="top" width="240px">Lokasi Gudang : {{$val->mg_namagudang}} </td>
		</tr>
		@endforeach
	</table>
	<table width="100%" style="border-top:hidden;">
		<tr>
			<td width="40px" class="tebal">Nomor</td>
			<td width="200px" class="tebal">Nama Barang</td>
			<td width="100px" class="tebal">Satuan</td>
			<td width="65px" class="tebal">Harga Awal</td>
			<td width="65px" class="tebal">Masuk</td>
			<td class="tebal" width="64px">Keluar</td>
			<td class="tebal" width="100px">Saldo Akhir</td>
			<td class="tebal" width="139px">Keterangan</td>
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
			<td colspan="2" class="footer">
				<div class="top-center" style="padding-bottom: 50px;">Dibuat oleh Staff Gudang</div>
				<div class="bottom">Tanggal :</div>
			</td>
			<td colspan="3">
				<div class="top-center" style="padding-bottom: 50px;">Diperiksa oleh Staff Accounting</div>
				<div class="bottom">Tanggal :</div>
			</td>
			<td colspan="3">
				<div class="top-center" style="padding-bottom: 50px;">Diperiksa oleh Manajemen Keuangan dan Akuntasi</div>
				<div class="bottom">Tanggal :</div>
			</td>
			
		</tr>
	</table>
	<div style="float: right;font-size: 12px;">
		JPM/FR/GUD/06-02 Januari 2017-00
	</div>
</div>
</body>
</html>