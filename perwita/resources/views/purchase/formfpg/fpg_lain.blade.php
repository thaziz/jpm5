<!DOCTYPE html>
<html>
<head>
	<title>FORM PERMINTAAN GIRO</title>
	<style type="text/css">
		
		.s16{
			font-size: 16px !important;
		}
		.s14 {
			font-size: 14px !important;

		}
		.div-width{
			margin: auto;
			width: 95vw;
		}
		.underline{
			text-decoration: underline;
		}
		.italic{
			font-style: italic;
		}
		.bold{
			font-weight: bold;
		}
		.text-center{
			text-align: center;
		}
		.text-right{
			text-align: right;
		}
		.text-left{
			text-align: left;
		}
		.border-none-right{
			border-right: hidden;
		}
		.border-none-left{
			border-left:hidden;
		}
		.border-none-bottom{
			border-bottom: hidden;
		}
		.border-none-top{
			border-top: hidden;
		}
		.float-left{
			float: left;
		}
		.float-right{
			float: right;
		}
		.top{
			vertical-align: text-top;
		}
		.vertical-baseline{
			vertical-align: baseline;
		}
		.bottom{
			vertical-align: text-bottom;
		}
		.ttd{
			top: 0;
			position: absolute;
		}
		.relative{
			position: relative;
		}
		.absolute{
			position: absolute;
		}
		.empty{
			height: 18px;
		}
		table,td{
			border:1px solid black;
		}
		table{
			border-collapse: collapse;
		}
		table.border-none ,.border-none td{
			border:none !important;
		}
		.position-top{
			vertical-align: top;
		}
		@page {
			size: portrait;
		}
		@media print {
			margin:0;
		}
		fieldset{
			border: 1px solid black;
			margin:-.5px;
		}

		td{
			font-size : 14px;
		}
	</style>
</head>
<body>
	<div class="div-width">
		<table class="border-none" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td width="1%"><img src="{{asset('perwita/storage/app/upload/images.jpg') }}" width="120px" height="75px"></td>
				<td class="s16 text-left">
					<text class="bold">PT. Jawa Pratama Mandiri</text><br>
					<small>
						Gedung Temprina Lt.1 Jl.Wringin Anom KM 30-31 Sumengko<br>
						Telp. ( 031 ) 8986777, 896888<br>
						Email : ekspedisi@jawapos.co.id
					</small>
				</td>
				<td class="s16 position-top" width="30%">
					<table class="border-none float-right">
						<tr>
							<td class="s14">No. FPG</td>
							<td class="s14">:</td>
							<td class="s14"> {{$data['fpg'][0]->fpg_nofpg}}</td>
						</tr>
						<tr>
							<td class="s14">Tanggal</td>
							<td class="s14">:</td>
							<td class="s14">{{$data['fpg'][0]->fpg_tgl}}</td>
						</tr>
						<tr>
							<td class="s14"> Cabang </td>
							<td class="s14"> : </td>
							<td class="s14">{{$data['fpg'][0]->fpg_cabang}} - {{$data['fpg'][0]->nama}} </td>
						</tr>
					</table>
				</td>
				
			</tr>
			<tr>
				<td colspan="3" class="text-center bold underline">
					
						<h2>FORM PERMINTAAN GIRO</h2>
					
				</td>
			</tr>
		</table>
		
		<fieldset style="margin-bottom: 5px;text-align: center;">
			@if($data['fpg'][0]->fpg_jenisbayar == '5')
				<h2>Transfer Kas/Bank</h2>
			@else
				<h2> Pindah Buku </h2>
			@endif
		</fieldset>
		@if($data['fpg'][0]->fpg_jenisbayar == '12')
		<fieldset>
			<legend>
				Bayar Kepada : <br>
				@foreach($data['fpg_bank'] as $index=>$fpgbank)
					{{$index + 1 }}.  {{$fpgbank->fpgb_nmbanktujuan}} 
				@endforeach
			</legend>
		</fieldset>
		@endif
		<br>
		<table width="100%" cellspacing="0" class="tabel" border="1px" cellpadding="10px">
			<tr class="text-center">
				<td>No</td>
				<td>Keterangan</td>
				<td>No Cek/BG</td>
			
				<td>Bank</td>
				<td>Jumlah</td>
			</tr>
			@foreach($data['fpg_bank'] as $index=>$fpgbank)
			<tr class="border-none-bottom">
				<td class="text-center"> {{$index + 1}} </td>
				<td> {{$data['fpg'][0]->fpg_keterangan}} </td>
				<td>@if($fpgbank->fpgb_jenisbayarbank == 'INTERNET BANKING')
						{{$fpgbank->fpgb_jenisbayarbank}}
					@else
						{{$fpgbank->fpgb_nocheckbg}}
					@endif
				</td>
				
				<td> {{$fpgbank->mb_nama}}</td>
				<td class="text-right"> {{number_format($fpgbank->fpg_totalbayar , 2)}}</td>
			</tr>
			@endforeach
			
			<tr class="border-none-bottom">
				<td class="text-center empty"></td>
				<td></td>
				<td></td>
				
				<td></td>
				<td class="text-right"></td>
			</tr>
			<tr class="border-none-bottom">
				<td class="text-center empty"></td>
				<td></td>
				<td></td>
			
				<td></td>
				<td class="text-right"></td>
			</tr>
			<tr class="">
				<td class="text-center empty"></td>
				<td></td>
				<td></td>
				
				<td></td>
				<td class="text-right"></td>
			</tr>
			<tr>
				<td colspan="3" class="border-none-right"></td>
				<td class="text-center">Total Cek/BG</td>
				<td class="text-right"> {{number_format($fpgbank->fpg_cekbg , 2)}}</td>
			</tr>
			<tr>
				<td colspan="5">Terbilang : {{$data['katauang']}}</td>
			</tr>
			
		</table>
		<table class="border-none-top" width="100%">
			<tr>
				<td class="text-center">Dibuat Oleh :</td>
				<td class="text-center">Penerima :</td>
				<td class="text-center">Disetujui Oleh :</td>
				<td class="text-center">Mengetahui :</td>
			</tr>
			<tr>
				<td style="height: 100px;"></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
	</div>
</body>
</html>