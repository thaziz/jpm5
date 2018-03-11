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
<table  width="100%" style="border-bottom-style:hidden; font-size: 12px">
	<tr>
		<td width="25%">
			<img style="margin-left: 50px" src="{{ asset('assets/img/dboard/logo/logo_jpm.png') }}"></td>
		<td width="50%" align="center"><h2>BUKTI PERMINTAAN DAN<br> PENGELUARAN BARANG</h2></td>
		<td>
		<table class="table1" border="0">
			<tr>
				<td>No. BPPB</td>
				<td>:</td>
				<td>{{$data->pb_nota}}</td>
			</tr>
			<tr>
				<td>Tanggal</td>
				<td>:</td>
				<td>{{$tgl}}</td>
			</tr>
		</table></td>
		
	</tr>
	<tr>
		<td colspan="3" style="height: 40px;vertical-align: top;text-align: left;">Keperluan untuk : {{$data->pb_keperluan}}</td>
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
	@foreach($data_dt as $i=>$val)
	<tr>
		<td height="25px">{{$i+1}}</td>
		<td>{{$val->nama_masteritem}}</td>
		<td>{{$val->unitstock}}</td>
		<td>{{round($val->pbd_jumlah_barang,2)}}</td>
		<td>{{round($val->pbd_disetujui,2)}}</td>
		<td>{{$val->pbd_keterangan}}</td>
	</tr>
	@endforeach
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