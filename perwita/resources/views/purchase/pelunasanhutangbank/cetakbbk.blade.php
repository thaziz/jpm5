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
	<table style="border:hidden;" width="100%">
		<tr style="border:hidden;">
			<td style="border:hidden;" width="125px" rowspan="2"><img src="" width="125px" height="60px"></td>
			<td style="border:hidden;text-align: left" class="tebal">PT. Jawa Pratama Mandiri</td>
			<td align="center" width="280px" class="tebal" style="text-decoration: underline;border:hidden;text-align: left;">
				BUKTI BANK KELUAR
			</td>
			<td class="top" width="130px" style="border:hidden;">No.BBK : {{$data['bbk'][0]->bbk_nota}}</td>
		</tr>
		<tr style="border:hidden;">
			<td colspan="2" class="top" style="font-size: 10px;border:hidden;">Gedung Temprina Lt 1 Jl. Wringin Anom KM 30-31 Sumengkir Gresik<br>
				Telp (031) 89886777, 8986888<br>
				Email : ekspedisi@jawapos.co.id</td>
			<td class="top" width="240px" style="border:hidden;">Tgl BBK : {{ Carbon\Carbon::parse($data['bbk'][0]->bbk_tgl)->format('d-M-Y ') }} </td>
		</tr>
		<tr style="border:hidden;">
			<td colspan="3" style="text-align: left; border:hidden;">
				Dibayar Kepada : {{$data['bbk'][0]->mb_nama}}
			</td>
		</tr>
	</table>

	@if($data['bbk'][0]->bbk_flag == 'BIAYA')
	<table width="100%">
		<tr>
			<td colspan="2" width="40px" class="tebal">BIAYA </td>
			<td rowspan="2" width="190px" class="tebal"> Nama Biaya </td>
			<td rowspan="2" width="100px" class="tebal">Nilai Cek / BG</td>
			<td colspan="2" class="tebal">Kode Account</td>
			<td rowspan="2" class="tebal" width="170px">Keterangan / Tindak lanjut yang akan dilakukan</td>
			<td rowspan="2" class="tebal">D/K</td>
			<td rowspan="2" class="tebal" width="150px">Rupiah</td>
		</tr>
		<tr>
			
			<td class="tebal" colspan="2">Tanggal</td>
			<td width="65px" class="tebal">CF</td>
			<td width="65px" class="tebal">AK</td>

		</tr>
		@foreach($data['detail'] as $detail)
		<tr>
		
			<td colspan="2"> {{ Carbon\Carbon::parse($data['bbk'][0]->bbk_tgl)->format('d-M-Y ') }} </td>
			<td> {{$detail->nama_akun}} </td>
			<td>{{ number_format($detail->bbkb_nominal, 2) }} </td>
			<td> {{$detail->bbkb_akun}} </td>
			<td>  {{$detail->bbkb_akun}}</td>
			<td> {{$detail->bbkb_keterangan}}</td>
			<td> {{$detail->bbkb_dk}}</td>
			<td> {{ number_format($detail->bbkb_nominal, 2) }} </td>
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
			<td></td>
		</tr>
		<tr>
			<td colspan="9" class="tebal top">Terbilang : {{$data['terbilang']}} rupiah</td>

		</tr>
	</table>
	@else
	<table width="100%">
		<tr>
			<td colspan="2" width="40px" class="tebal">Cheque / BG</td>
			<td rowspan="2" width="190px" class="tebal">Nama Bank</td>
			<td rowspan="2" width="100px" class="tebal">Nilai Cek / BG</td>
			<td colspan="2" class="tebal">Kode Account</td>
			<td rowspan="2" class="tebal" width="170px">Keterangan / Tindak lanjut yang akan dilakukan</td>
			<td rowspan="2" class="tebal">D/K</td>
			<td rowspan="2" class="tebal" width="150px">Rupiah</td>
		</tr>
		<tr>
			<td class="tebal">Nomor</td>
			<td class="tebal">Tanggal</td>
			<td width="65px" class="tebal">CF</td>
			<td width="65px" class="tebal">AK</td>

		</tr>
			@foreach($data['detail'] as $detail)
		<tr>
		
			<td colspan="2"> {{ Carbon\Carbon::parse($data['bbk'][0]->bbk_tgl)->format('d-M-Y ') }} </td>
			<td> {{$detail->bbkd_nocheck}} </td>
			<td>{{ number_format($detail->bbkd_nominal, 2) }} </td>
			<td> {{$detail->mb_kode}} </td>
			<td>  {{$detail->mb_kode}}</td>
			<td> {{$detail->bbkd_keterangan}}</td>
			<td> {{$detail->akun_dka}}</td>
			<td> {{ number_format($detail->bbkd_nominal, 2) }} </td>
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
			<td></td>
		</tr>
		<tr>
		<td colspan="9" class="tebal top">Terbilang : {{$data['terbilang']}} rupiah</td>
		</tr>
	</table>
	@endif
	<table width="100%" style="border-top: hidden;">
		<tr>
			<td width="200px">
				Mengetahui
				
			</td>
			<td width="182px">
				Disetujui
				
			</td>
			<td width="153px">
				Pembukaan
			</td>
			<td width="153px">
				Kasir
			</td>
			<td width="">
				Penerima
			</td>
		</tr>
		<tr>
			<td class="footer"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>

</div>
</body>
</html>