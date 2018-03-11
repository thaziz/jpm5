<!DOCTYPE html>
<html>
<head>
	<title>Print</title>
	<style>
*{
	font-family: arial;
}
table {
    border-collapse: collapse;
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
</style>
</head>
<body>
<div class="div-width">
<table  width="100%" style="border-bottom-style:hidden;">
	<tr>
		<td width="25%"><img src="" width="100px" height="100px"></td>
		<td width="50%" align="center"><h2>BUKTI PERMINTAAN DAN<br> PENGELUARAN BARANG</h2></td>
		<td><table class="table1" border="0">
			<tr>
				<td>No. BPJS</td>
				<td>:</td>
			</tr>
			<tr>
				<td>Tanggal</td>
				<td>:</td>
			</tr>
		</table></td>
		
	</tr>
	<tr>
		<td colspan="3" style="height: 40px;vertical-align: top;text-align: left;">Keperluan untuk :</td>
		
	</tr>
</table>
<table width="100%" >
	<tr>
		<td align="center" colspan="4">Diisi oleh bagian yang meminta barang</td>

		<td align="center" colspan="2">Diisi oleh bagian gudang</td>
	</tr>

	<tr align="center">
		<td height="40px" width="5%">No</td>
		<td width="25%">Uraian Barang</td>
		<td width="16%">Satuan</td>
		<td width="16%">Jumlah satuan yang diminta</td>
		<td width="16%">Jumlah satuan diberi</td>
		<td>Keterangan</td>
	</tr>
	<tr>
		<td height="25px"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td height="25px"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td height="25px"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	
</table>
<table  width="100%" style="border-top-style:hidden;">
	<tr>
		<td height="100px" width="30%" colspan="2" style="vertical-align: top;text-align: center;">Diminta oleh</td>
		<td style="vertical-align: top;text-align: center;" width="24%">Disetujui oleh</td>
		<td style="vertical-align: top;text-align: center;" width="24%">Diserahkan oleh</td>
		<td style="vertical-align: top;text-align: center;">Diterima oleh</td>
	</tr>
</table>
</div>
</body>
</html>