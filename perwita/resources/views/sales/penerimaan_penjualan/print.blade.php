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
		font-size: 12px;
	}
	.wrapper {
		width: 900px;
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
		width: 97%;
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
		margin-top: -20px;
	}

	.margin-top-10px {
		margin-top: -40px;
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
		min-height: 200px;
		border-bottom: 1px solid black;
		border-right: 1px solid black;
		border-left: 1px solid black;
	}
	.margin-top10px{
		margin-top: 10px;
	}
</style>

<body>
	<div class="wrapper">
		<div class="position-fixed">
			<table class="inlineTable">
				<td>
					<img class="img" width="150" height="80" src="/jpm/perwita/img/logo_jpm.png">
				</td>
			</table>
			<table class="inlineTable size" style="margin-bottom: 10px;" >
				<tr>
					<th>PT. JAWA PRATAMA MANDIRI</th>
				</tr>
				<tr>
					<td>Gedung Temprina Lt. 1 Jl. Wringin Anom KM 30-31 Sumengko Gresik</td>
				</tr>
				<tr>
					<td>Telp.(031) 8986777, 89868888, Fax. (031) 89839999</td>
				</tr>
				<tr>
					<td>Email : ekspedisi@jawapos.co.id</td>
				</tr>
			</table>
		</div>
		<div class="Kwitansi bold">
				<p>KWITANSI</p>
			</div>
		<div style="margin-top: 30px;">
			
			<table class="inlineTable pull-right margin-top-60px size">
				<tr>
					<th width="90">&nbsp;</th>
					<th width="10">&nbsp;</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<td>No.Kwitansi</td>
					<td>:</td>
					<td>{{$head->nomor}}</td>
				</tr>
				<tr>
					<td>Tanggal</td>
					<td>:</td>
					<td>{{$head->tanggal}}</td>
				</tr>
				<tr>
					<td>Kode.Cust.</td>
					<td>:</td>
					<td>{{$head->kode_customer}}</td>
				</tr>
			</table>

			<table class="margin-top-10px size" width="40%">
				<tr>
					<th>{{$head->nama}}</th>
				</tr>
				<tr>
					<td width="50%">{{$head->alamat}}</td>
				</tr>
				<tr>
					<td>Telp.{{$head->telpon}}</td>
				</tr>
			</table>
		</div>

		<div class="pembungkus">
			<table class="size textcenter" width="100%">
				<tr>
					<th height="30" class="textcenter bot right top" width="3%">No.</th>
					<th class="textcenter bot right top" width="11%">No Invoice</th>
					<th class="textcenter bot right top" width="7%">Tanggal</th>
					<th class="textcenter bot right top" width="40%">Keterangan</th>
					<th class="textcenter bot right top" width="15%">Nilai Invoice</th>
					<th class="textcenter bot top" width="15%">Jumlah Bayar</th>
				</tr>
				@php
					$i=1;
				@endphp
				@foreach ($detail as $row)
				<tr>
					<th height="25" style="text-align:right" class="textcenter bot right top"> {{$i++}}.&nbsp </th>
					<td class="bot right"> {{$row->nomor_invoice}}</td>
					<td class="bot right"> {{$row->tanggal}} </td>
					<td style="text-align:left" class="bot right">&nbsp {{$row->keterangan}} </td>
					<td style="text-align:right" class="bot right"> {{ number_format($row->total_tagihan, 2, ",", ".") }}&nbsp </td>
					<td style="text-align:right" class="bot right">{{ number_format($row->jumlah, 2, ",", ".") }}&nbsp</td>
				</tr>
				@endforeach
				
			</table>
		</div>

		<table class="size tab inlineTable">
			<tr>
				<td width="55">Terbilang</td>
				<td width="10">:</td>
				<td>{{$terbilang}}</td>
			</tr>
		</table>
		<table class="size margin-top10px inlineTable pull-right" width="32%" style="margin-right: 0px;padding-right: 0px;">
			<tr>
				<td width="20%">Jumlah</td>
				<td width="50%" style="text-align:right" class="textright"> {{ number_format($head->netto, 2, ",", ".") }} </td>
			</tr>
			<tr>
				<td>Biaya (D/K)</td>
				<td style="text-align:right" class="textright">{{ number_format($head->debet+$head->kredit, 2, ",", ".") }}</td>
			</tr>
			<tr>
				<td>Total</td>
				<td class="textright">{{ number_format($head->jumlah, 2, ",", ".") }}</td>
			</tr>
		</table>
		<div>
			<input class="border tandatangan hiddenbordertop hiddenborderright hiddenborderleft" type="" name="">
		</div>
	</div>
</body>

</html>