<!DOCTYPE html>
<html>

<head>
	<title></title>
</head>
<link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<style type="text/css">
	body {
		font-family: arial;
	}

	.wrapper {
		border-top: 1px solid black;
		border-right: 1px solid black;
		border-left: 1px solid black;
		width: 1000px;
		margin: 10px 10px 10px 10px;
	}

	.wrapper2 {
		border: 1px solid black;
		width: 1100px;
		margin: 10px 10px 10px 10px;
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
		padding: 0px 10px;
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
		margin-top: -100px;
		margin-right: -15px;
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

	.pembungkus {}

	.sizebig {
		font-size: 14px;
	}

	.sizeheader {
		font-size: 13px;
	}

	.sizebiger {
		font-size: 33px;
	}

	.paddingkota {
		padding: 0px 30px 0px 30px;
	}

	.suratjalansize {
		font-size: 16px;
	}

	.marginatas {
		padding-left: 5px;
		padding-right: 20px;
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
	.break{
		page-break-after: always;
		margin-top:  50px;
	}
</style>

<body>
	@foreach ($head as $i=>$h)
		<div class="break">
			<div class="wrapper"  style="margin: auto !important">
				<div class="position-fixed">
					<table class="inlineTable">
				      <td><img class="img" width="160" height="100" src="{{ asset('perwita/storage/app/upload/images.jpg') }}"></td>
					</table>
					<table class="inlineTable sizeheader" style="margin-bottom: 10px;">
						<tr>
							<th class="bold sizebig">{{perusahaan()->mp_nama}}</th>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>{{perusahaan()->mp_alamat}}</td>
						</tr>
						<tr>
							<td>Telp.{{perusahaan()->mp_tlp}}</td>
						</tr>
						<tr>
							<td>Email.: ekspedisi@jawapos.co.id</td>
						</tr>
					</table>
					<table class="inlineTable sizeheader pull-right">
						<tr>
							<th class="bold sizebiger">
								{{$last[$i]}}
							</th>
						</tr>
					</table>
				</div>
				<div style="margin-top:20px;">
					<table class="inlineTable pull-right margin-top-60px size">
						<tr>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
						</tr>
						<tr>
							<td class="top bot right left textcenter paddingkota">KOTA/KAB</td>
							<td class="top bot  left textcenter paddingkota">CHECK</td>
						</tr>
						
						@foreach ($rute[$i] as $a=> $row)
						<tr>
							<td class="top bot right left textcenter paddingkota">{{$rute[$i][$a]->kota}}</td>
							<td class="top bot left textcenter paddingkota"></td>
						</tr>
						@endforeach
					</table>
					<table class="inlineTable" style="margin-left: 40%;margin-top: -10%;">
						<tr>
							<td class="suratjalansize textcenter">SURAT JALAN</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="bold textcenter">
								@foreach ($rute[$i] as $row)
								{{$row->nama}}
								@break
								@endforeach
							</td>
						</tr>
					</table>
					<table class="margin-top-10px" width="100%">
						<tr>
							<td width="5%" class="marginatas">No</td>
							<td width="1%">:</td>
							<td>{{$head[$i]->nomor}}</td>
						</tr>
						<tr>
							<td class="marginatas">Tanggal</td>
							<td>:</td>
							<td>{{$head[$i]->tanggal}}</td>
						</tr>
						<tr>
							<td class="marginatas">Cabang</td>
							<td>:</td>
							<td>{{$head[$i]->kode_cabang}}</td>
						</tr>
					</table>
				</div>

				<div class="pembungkus">
					<table class="size textleft" width="100%">
						<tr>
							<th height="30" class="textcenter bot right top">No.</th>
							<th class="textcenter bot right top">No.Order</th>
							<th class="textcenter bot right top">Tgl.Order</th>
							<th class="textcenter bot right top">Pengirim</th>
							<th class="textcenter bot right top">Penerima</th>
							<th class="textcenter bot right top">Alamat & Telp Penerima</th>
							<th class="textcenter bot right top">Type</th>
							<th class="textcenter bot right top">Kg</th>
							<th class="textcenter bot top">QTY</th>
						</tr>
						@php 
							$k=1; 
							$jml=0; 
						@endphp 
						@foreach ($detail[$i] as $z=>$tes)
						<tr>
							<td height="27" class="textright bot right">{{$z+1}}.</td>
							<td style="display: none;">{{$jml=$jml+$tes->jumlah}}.</td>
							<td class="textleft bot right"> {{$tes->nomor_do}} </td>
							<td class="textleft bot right"> {{$tes->tanggal}} </td>
							<td class="textleft bot right"> {{$tes->nama_pengirim}} </td>
							<td class="textleft bot right"> {{$tes->nama_penerima}} </td>
							<td class="textleft bot right"> {{$tes->alamat_penerima}} {{$tes->telpon_penerima}}</td>
							<td class="textleft bot right"> {{$tes->type_kiriman}} </td>
							<td class="textleft bot right" style="width: 50px !important;text-align: center"> {{$tes->berat}} </td>
							@if ($tes->type_kiriman == 'KILOGRAM')
							<td style="text-align:center;width: 50px !important;" class="textright textleft bot right"> 
								{{ number_format($tes->koli, 0, ",", ".") }} 
							</td>
							@else
							<td style="text-align:center;width: 50px !important;" class="textright textleft bot right"> 
								{{ number_format($tes->jumlah, 0, ",", ".") }} 
							</td>
							@endif
						</tr>
						@endforeach
						<tr>
							<td height="30"class="right textright top bot" colspan="7">Total :</td>
							@php
								$temp = 0;
								foreach($detail[$i] as $row){
									$temp+=$row->berat;
								}
								echo '<td style="text-align:center;" class="textcenter right top bot">'.$temp.'&nbsp</td>'
							@endphp
							@php
								$temp1 = 0;
								foreach($detail[$i] as $row){
									if ($row->type_kiriman == 'KILOGRAM') {
										$temp1+=$row->koli;
									}else{
										$temp1+=$row->jumlah;
									}
								}
								echo '<td style="text-align:center;" class="textcenter top bot">'.$temp1.'&nbsp</td>'
							@endphp
						</tr>
					</table>
				</div>
			</div>
			<table class="wrapper" width="100%" style="margin: auto !important">
				<tr>
					<th class="bot top right left textcenter">Dibuat Oleh :</th>
					<th class="bot top right left textcenter">Driver 1 :</th>
					<th class="bot top right left textcenter">Driver 2 :</th>
					<th class="bot top right left textcenter">Driver 3 :</th>
					<th class="bot top right left textcenter">Driver 4 :</th>
					<th class="bot top right left textcenter">Diver 5 :</th>
					<th class="bot top right left textcenter">Pengirim :</th>
				</tr>
				<tr>
					<td height="100" class="right bot">&nbsp;</td>
					<td height="100" class="right bot">&nbsp;</td>
					<td height="100" class="right bot">&nbsp;</td>
					<td height="100" class="right bot">&nbsp;</td>
					<td height="100" class="right bot">&nbsp;</td>
					<td height="100" class="right bot">&nbsp;</td>
					<td height="100" class="right bot">&nbsp;</td>
				</tr>
			</table>
		</div>
	@endforeach
	
</body>

</html>
<script type="text/javascript">
	window.print();
</script>