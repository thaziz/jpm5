<!DOCTYPE html>
<html>

<head>
	<title></title>
</head>
<link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<style type="text/css">
	.tandatangan {
		margin-top: 100px;
		margin-left: 40%;
	}

	body {
		font-family: arial;
	}

	th td {
		border: 1px solid black
	}

	.wrapper {
		width: 1000px;
		margin: -10px 10px 10px 10px;
	}

	.bold {
		font-weight: bold;
	}

	.img {
		margin-left: 10px;
		margin-top: 10px;
	}

	.size {
		font-size: 12px;
	}

	.border {
		border: 1px solid;
	}

	.header {
		font-size: 12px;
		margin-top: 20px;
	}

	.full-right {
		margin-bottom: 27px;
		padding-right: 10px;
		padding-left: 10px;
	}

	.bottomheader {
		border-bottom: 1px solid black;
	}

	.kepada {
		border-bottom: 1px solid;
		right: 120%;
	}

	.tabel2 {
		padding: 10px 10px;
		display: inline-block;
	}

	.jarak1 {
		padding: -10px -10px -10px -10px;
	}

	.inlineTable {
		display: inline-block;
	}

	.tabel-utama {
		margin-left: 10px;
		width: 95%;
	}

	.textcenter {
		text-align: center;
	}

	.jarak {
		padding: 10px 10px 10px 10px;
	}

	.textright {
		text-align: right;
		padding-right: 5px;
	}

	.textleft {
		text-indent: 5px;
	}

	.hiddenborderleft {
		border-left: 0px;
	}

	.hiddenborderright {
		border-right: 0px;
	}

	.hiddenbordertop {
		border-top: 0px;
	}

	.hiddenborderbottom {
		border-bottom: 0px;
	}

	.borderright {
		border-right: 1px solid black;
		padding-right: 100px;
	}

	.inputheader {
		width: 285px;
		border-bottom: 1px solid black;
	}

	.fontpenting {
		font-size: 11px;
		margin-top: 100px;
		font-family: georgia;
		padding: 3px 3px 3px 3px;
	}

	.ataspenting {
		margin: 20px 0px 2px 10px;
	}

	.tabelpenting {
		margin: 0px 0px 10px 10px;
		border: 1px 1px 0px 1px solid black;
		width: 112%;
	}

	.headpenting {
		font-family: georgia;
		padding: 3px 3px 3px 3px;
	}

	.tab {
		margin-left: 10px;
		margin-top: 10px;
	}

	.boldtandatangan {
		font-weight: bold;
		font-size: 11px;
	}

	.tandatangandiv {
		margin-top: -225px;
		margin-left: 585px;
		margin-bottom: 10px;
	}

	.headtandatangan {
		text-align: center;
		width: 287px;
		padding-bottom: 70px;
	}

	.top {
		border-top: 1px solid black;
	}

	.bot {
		border-bottom: 1px solid black;
	}

	.bottabelutama {
		border-bottom: 1px solid grey;
	}

	.right {
		border-right: 1px solid black;
	}

	.left {
		border-left: 1px solid black;
	}

	.note {
		margin: 0px 10px 10px 10px;
		text-decoration: underline;
	}

	.nomorform {
		margin: -10px 0px 0px 700px;
	}

	.pull-right {
		margin-right: 14px;
		padding: 0px 10px 0px 0px;
	}

	.paddingbottom {
		padding-bottom: 60px;
	}

	.fixed {
		position: absolute;
	}

	.catatanpadding {
		padding-left: 10px;
	}

	.gg {
		padding-bottom: -20px;
	}

	.position-fixed {
		position: relative;
	}

	.margin-top-60px {
		margin-top: -60px;
	}

	.margin-top-10px {
		margin-top: -25px;
	}

	.Kwitansi {
		margin-left: 45%;
		font-family: arial;
		font-size: 20px;
	}

	.minheight {
		min-height: 100px;
	}

	.pembungkus {
		border-right: 1px solid black;
        border-left: 1px solid black;
        min-height: 100px;
	}

	.sizebig {
		font-size: 16px;
		font-weight: bold;
	}
</style>

<body>
	<div class="wrapper">
		<div class="position-fixed">
			<table class="inlineTable">
				<td>
					<img class="img" width="200" height="100" src="{{ asset('assets/img/dboard/logo/logo_jpm.png') }}">
				</td>
			</table>
			<table class="inlineTable sizebig textcenter" style="margin-bottom: 35px; margin-left: 15%;">
				<tr>
					<td>PT. JAWA PRATAMA MANDIRI</td>
				</tr>
				<tr>
					<td>Telp.(031) 8986777, 89868888, Fax. (031) 89839999</td>
				</tr>
				<tr>
					<td>Email : ekspedisi@jawapos.co.id</td>
				</tr>
			</table>
		</div>
		<div style="margin-top: 10px;">
			<table class="inlineTable">
				<tr>
                    <td style="width:80px">Nomor</td>
                    <td >:</td>
                    <td >{{$nota[0]->nomor}}</td>
                </tr>
                <tr>
                    <td style="width:50px">Tanggal</td>
                    <td >:</td>
                    <td >{{$nota[0]->tanggal}}</td>
                </tr>
                <tr>
                    <td style="width:100px">Kode Customer</td>
                    <td >:</td>
                    <td >{{$nota[0]->nama_customer}}</td>
                </tr>
			</table>

			<table class="pull-right inlineTable" >
				<tr>
					<td>Kepada Yth </td>
				</tr>
				<tr>
                    <td>{{$nota[0]->nama_penerima}}</td>
					<td>{{$nota[0]->alamat_penerima}}</td>
				</tr>
				<tr>
					<td>Telpon : {{$nota[0]->telpon_penerima}}</td>
				</tr>
			</table>
		</div>

		<div class="pembungkus">
			<table class="size" width="100%">
				<tr>
					<th class="textcenter bot right top" height="30" width="2%">No.</th>
					<th class="textcenter bot right top" width="20%">Nama</th>
					<th class="textcenter bot right top" width="40%">Keterangan</th>
					<th class="textcenter bot right top" width="15%">Kuantum</th>
				</tr>
				<tr>
					<td class="bot right textcenter" height="25">1</td>
					<td class="bot right textcenter">KARGO</td>
					<td class="bot right textcenter">{{$nota[0]->no_surat_jalan}} - PENGIRIMAN KARGO DARI {{$nota[0]->asal}} KE {{$nota[0]->tujuan}} {{$nota[0]->nopol}}</td>
					<td class="bot right textcenter">{{ number_format($nota[0]->jumlah, 0, ",", ".") }} {{$nota[0]->kode_satuan}}</td>
				</tr>
                
				
			</table>
        </div>
        
		<table class="bot right left" width="100%" border="1">
			<tr>
				<th class="bot right textcenter" width="33%">Outlet :</th>
				<th class="bot right textcenter" width="33%">Keuangan :</th>
				<th class="bot textcenter" width="33%">Kord.Cabang :</th>
			</tr>
			<tr>
				<td class="right" height="100">&nbsp;</td>
				<td class="right">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</div>
</body>

</html>
<script type="text/javascript">
	window.print();
</script>