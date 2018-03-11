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
		font-size: 14px;
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
		text-align: left;
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

	.borderrighttabel {
		border-right: 1px solid black;
	}

	.borderbottomtabel {
		border-bottom: 1px solid black;
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

	.underline {
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
		margin-top: -48px;
	}

	.margin-top-10px {
		margin-top: -29px;
	}

	.Kwitansi {
		margin-left: 45%;
		font-family: arial;
		font-size: 20px;
	}

	.minheight {
		min-height: 100px;
	}

	.akirkanan {
		padding-left: 40px;
	}
	/*    .table-utama {
      border:1px solid black;
    }*/

	.pembungkus {
		border-right: 1px solid black;
		border-left: 1px solid black;
		border-top: 1px solid black;
		min-height: 1000px;
	}

	.borderlefttabel {
		border-left: 1px solid black;
	}

	.bordertoptabel {
		border-top: 1px solid black;
	}
</style>

<body>
	<div class="wrapper">
		<div class="position-fixed">
			<table class="inlineTable">
				<td>
					<img class="img" width="200" height="100" src="/jpm/perwita/img/logo_jpm.png">
				</td>
			</table>
			<table class="inlineTable size" style="margin-bottom: 10px;">
				<tr>
					<th>PT. JAWA PRATAMA MANDIRI</th>
				</tr>
				<tr>
					<td>Jl. Karah Agung No.45 - Surabaya</td>
				</tr>
				<tr>
					<td>Telp.(031) 8986777, 89868888, Fax. (031) 89839999</td>
				</tr>
				<tr>
					<td>Email : ekspedisi@jawapos.co.id</td>
				</tr>
			</table>
		</div>
		<div style="margin-top: 20px;">
			<div class="Kwitansi bold">
				<p>INVOICE</p>
			</div>
			<table class="inlineTable pull-right margin-top-60px size">
				<tr>
					<th width="90">&nbsp;</th>
					<th width="10">&nbsp;</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<td>No.Faktur</td>
					<td>:</td>
					<td>{{$head->nomor}}</td>
				</tr>
				<tr>
					<td>Tanggal</td>
					<td>:</td>
					<td>{{$head->tanggal}}</td>
				</tr>
				<tr>
					<td>Jatuh Tempo</td>
					<td>:</td>
					<td>{{$head->jatuh_tempo}}</td>
				</tr>
				<tr>
					<td>Kode.Cust.</td>
					<td>:</td>
					<td>{{$head->kode_customer}}</td>
				</tr>
			</table>

			<table class="margin-top-10px size" width="73%">
				<tr>
					<td>Kepada Yth :</td>
				</tr>
				<tr>
					<th style="font-size: 16px;">{{$head->nama}}</th>
				</tr>
				<tr>
					<td>{{$head->alamat}}</td>
				</tr>
				<tr>
					<td>Telp. {{$head->telpon}}</td>
				</tr>
			</table>
		</div>
		<div class="pembungkus">
			<table class="size textcenter  table-responsive" width="100%">
				<tr>
					<th class="textcenter borderbottomtabel borderrighttabel" width="2%" height="30">No.</th>
					<th class="textcenter borderbottomtabel borderrighttabel" width=>No. DO</th>
					<th class="textcenter borderbottomtabel borderrighttabel" width="8%">Tgl</th>
					<th class="textcenter borderbottomtabel borderrighttabel">Keterangan</th>
					<th class="textcenter borderbottomtabel borderrighttabel" width="8%">Kuantum</th>
					<th class="textcenter borderbottomtabel borderrighttabel" width="11%">Harga Satuan</th>
					<th class="textcenter borderbottomtabel borderrighttabel" width="11%">Harga Bruto</th>
					<th class="textcenter borderbottomtabel borderrighttabel" width="8%">Discount</th>
					<th class="textcenter borderbottomtabel" width="11%">Harga Netto</th>
				</tr>
				@php
					$i=1;
				@endphp
				@foreach ($detail as $row)
				<tr>
					<td height="27" class="textright borderbottomtabel borderrighttabel">{{$i++}}.</td>
					<td class="textleft borderbottomtabel borderrighttabel"> {{$row->nomor}} </td>
					<td class="borderbottomtabel borderrighttabel"> {{$row->tgl_do}} </td>
					<td class="textleft borderbottomtabel borderrighttabel"> {{$row->keterangan}} </td>
					<td class="borderbottomtabel borderrighttabel"> {{$row->kuantum}} </td>
					<td class="textright borderbottomtabel borderrighttabel"> {{ number_format($row->harga_satuan, 2, ",", ".") }} </td>
					<td class="textright borderbottomtabel borderrighttabel"> {{ number_format($row->harga_bruto, 2, ",", ".") }} </td>
					<td class="textright borderbottomtabel borderrighttabel"> {{ number_format($row->diskon, 2, ",", ".") }} </td>
					<td class="textright borderbottomtabel borderrighttabel"> {{ number_format($row->harga_netto, 2, ",", ".") }} </td>
				</tr>
				@endforeach
			</table>
		</div>
		{{--
		<tr>
			<td height="200" style="border:0px;"></td>
			<td class="textleft" style="border:0px;"></td>
			<td style="border:0px;"></td>
			<td class="textleft" style="border:0px;"></td>
			<td style="border:0px;"></td>
			<td class="textright" style="border:0px;"></td>
			<td class="textright" style="border:0px;"></td>
			<td class="textright" style="border:0px;"></td>
			<td class="textright" style="border:0px;"></td>
		</tr> --}}
		<table class="size" width="100%">
			<tr>
				<td height="27" class="textleft borderrighttabel borderlefttabel borderbottomtabel bordertoptabel" width="78.2%">Terbilang : {{$terbilang}}</td>
				<td class="textleft borderrighttabel borderbottomtabel bordertoptabel" width="9.1%">Total</td>
				<td class="textright borderrighttabel borderbottomtabel bordertoptabel">{{ number_format($head->total, 2, ",", ".") }}</td>
			</tr>
		</table>
		</table>
		<table width="100%" class="border size hiddenbordertop table-responsive">
			<tr>
				<td class="borderrighttabel textleft" width="26%">Pendaftaran ditransfer ke :</td>
				<td class="textleft borderrighttabel" width="26%">&nbsp;</td>
				<td class="textright borderrighttabel" width="26.4%">&nbsp;</td>
				<td height="27" class="borderrighttabel borderbottomtabel textleft" width="9%">Discount</td>
				<td class="borderrighttabel borderbottomtabel textright">{{ number_format($head->diskon, 2, ",", ".") }}</td>
			</tr>
			<tr>
				<td class="borderrighttabel textleft" width="26%">Pt. Jawa Pratama Mandiri</td>
				<td class="textleft borderrighttabel" width="26%">&nbsp;</td>
				<td class="textright borderrighttabel" width="26.2%">&nbsp;</td>
				<td height="27" class="borderrighttabel borderbottomtabel textleft" width="9%">Netto</td>
				<td class="borderrighttabel borderbottomtabel textright">{{ number_format($head->netto, 2, ",", ".") }}</td>
			</tr>
			<tr>
				<td class="borderrighttabel textleft" width="26%">BCA KCP Bhayangkara Surabaya</td>
				<td class="textleft borderrighttabel" width="26%">&nbsp;</td>
				<td class="textright borderrighttabel" width="26.2%">&nbsp;</td>
				<td height="27" class="borderrighttabel borderbottomtabel textleft" width="9%">PPN</td>
				<td class="borderrighttabel borderbottomtabel textright">{{ number_format($head->ppn, 2, ",", ".") }}</td>
			</tr>
			<tr>
				<td class="borderrighttabel akirkanan textleft" width="26%">Jl.A. Yani Surabaya</td>
				<td class="borderrighttabel underline textcenter" width="26%">OKKIE NESTIE</td>
				<td class="borderrighttabel underline textcenter" width="26.2%">EKO YULI S.</td>
				<td height="27" class="borderrighttabel borderbottomtabel textleft" width="9%">PPh</td>
				<td class="borderrighttabel borderbottomtabel textright">{{ number_format($head->pph, 2, ",", ".") }}</td>
			</tr>
			<tr>
				<td class="borderrighttabel akirkanan textleft" width="26%">A/C : 61-.089797.9</td>
				<td class="borderrighttabel textcenter" width="26%">(Finance Manager)</td>
				<td class="borderrighttabel textcenter" width="26.2%" style="margin-bottom: 10px;">(Account Dept)</td>
				<td height="27" class="borderrighttabel borderbottomtabel textleft" width="9.1%">Jumlah</td>
				<td class="borderrighttabel borderbottomtabel textright">{{ number_format($head->total_tagihan, 2, ",", ".") }}</td>
			</tr>
		</table>
</body>

</html>
