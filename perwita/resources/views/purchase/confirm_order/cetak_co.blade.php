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
.float-left
{
	float: left;
}
.float-right
{
	float:right;
}
.border-bottom
{
	border-bottom: 1px solid black; 
	width: 200px;
	text-align: left;
}
.border-hidden{
	border: hidden;
}
.border-top
{
	border-top: 1px solid black;
}
.border-top-hidden
{
	border-top: hidden;
}
.text-left
{
	text-align: left;
}
.bold-italic
{
	font-weight: bold;
	font-style: italic;
}
.font12
{
	font-size: 12px;
}
.border-left-hidden
{
	border-left: hidden;
}

	</style>
</head>
<body>
<div class="div-width">
	<table width="100%">
		<tr>
			<td width="125px"><img src="" width="125px" height="60px"></td>
			<td align="center" width="380px"><h2>LAPORAN PENERIMAAN BARANG</h2></td>
			<td class="top" width="270px">
				<div class="float-left">
					No SPP :
				</div>
				<div class="float-left border-bottom">
					&nbsp; {{$data['co'][0]->spp_nospp}}
				</div>
				<br>
				<br>
				<div class="float-left">
					Tanggal :
				</div>
				<div class="float-left border-bottom">
					&nbsp; {{ Carbon\Carbon::parse($data['co'][0]->co_time_mng_pem_approved)->format('d-M-Y') }}
				</div>
			</td>
		</tr>
	</table>
	<table width="100%" style="border-top:hidden;">
		<!-- <tr>
			<td colspan="3" class="text-left"></td>
			<td colspan="4" class="text-left" style="border-left: hidden;"></td>
		</tr>
		<tr>
			<td colspan="7" class="text-left"></td>
		</tr>
		<tr>
			<td colspan="5" class="bold-italic"></td>
			<td colspan="2" class="bold-italic"></td>
		</tr> -->
		<tr>
			<td width="40px">No</td>
			<td width="150px">Uraian Barang</td>
			<td width="190px">Suplier</td>
			<td width="70px">Satuan</td>
			<td width="100px">Quantity Request</td>
			<td width="100px">Quantity Approved</td>
			<td width="120px">Harga Satuan</td>
			<td width="120px">Jumlah</td>
		</tr>

		@foreach($data['co'] as $index=>$co)
		<tr>
			<td class="blank"> {{$index + 1}} </td>
			<td> {{$co->nama_masteritem}}</td>
			<td> {{$co->nama_supplier}}</td>
			<td> {{$co->unitstock}}</td>
			<td> {{$co->codt_qtyrequest}}  </td>
			<td> {{$co->codt_qtyapproved}}  </td>
			<td>
				<div class="float-left">Rp.</div>
				<div class="float-right">{{number_format($co->codt_harga, 2)}}</div>
			</td>
			<td>
				<div class="float-left">Rp.</div>
				<div class="float-right">{{number_format($co->codt_harga * $co->codt_qtyapproved, 2)}}</div>
			</td>
			
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
			<td colspan="3" class="tebal">JUMLAH</td>
			<td></td>
			<td></td>
			<td></td>
			<td>
				
			</td>
			<td>
				<div class="float-left">Rp.</div>
				<div class="float-right">0,00</div>
			</td>
		</tr>
</table>
<table class="border-top-hidden" width="100%">
		<tr>
			<td class="footer" width="170px">
				<div class="top-center" style="padding-bottom: 60px;">Penerima Barang</div>
			</td>
			<td width="170px">
				<div class="top-center" style="padding-bottom: 60px;">Menyetujui</div>
			</td>
			<td width="205px">
				<div class="top-center" style="padding-bottom: 60px;">Bagian Pembelian</div>
			</td>
			<td>
				<div class="top-center" style="padding-bottom: 60px;">Bagian Hutang</div>
			</td>
		</tr>
	</table>
	<table class="border-hidden" width="100%" style="margin-top: 15px;">
		<tr>
			<td class="text-left border-left-hidden">1. Bagian Pembelian</td>
			<td class="text-left border-left-hidden">2. Bagian Hutang</td>
			<td class="text-left border-left-hidden">3. Bagian Gudang</td>
		</tr>
	</table>
</div>
</body>
</html>