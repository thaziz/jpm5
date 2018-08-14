<!DOCTYPE html>
<html>
<head>
	<title>Print Tanda Terima Tagihan</title>
	<style type="text/css">
		*{
			font-size: 12px;
		}
		.s16{
			font-size: 16px !important;
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
		.border-top{
			border-top: 1px solid black;
		}
		.border-bottom{
			border-bottom: 1px solid black;
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
			height: 15px;
		}
		table,td,th{
			border:1px solid black;
		}
		table{
			border-collapse: collapse;
		}
		table.border-none ,.border-none td{
			border:none;
		}
		@media print {
			.button-group{
				display: none;
			}
			.div-width{
				margin: auto;
			}
		}
		.button-group{
			width: 100vw;
			/*position: fixed;
			padding: 15px;
			right: 0;
			top: 0;
			margin-bottom: 15px;
*/		}
		/*.button-group button{
			float: right;
		}*/
		.border-none-header{
			border-top: hidden !important;
			border-right: hidden !important;
			border-left: hidden !important;
		}
		.underline_div{
			border-bottom: 1px solid black;
		}
		.width-1percent{
			width: 1%;
			white-space: nowrap;
		}
		@page{
			size: portrait;
		}
		.border{
			border-top: 1px solid black !important;
			border-left: 1px solid black !important;
			border-right: 1px solid black !important;
			border-bottom: 1px solid black !important;
		}

	</style>
</head>
<body>
	<div class="button-group">
		<button onclick="prints()">Print</button>
	</div>
	<div class="div-width">
		<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td class="border-none-header" colspan="7" style="padding: 5px;">
					<table width="100%" class="border-none">
						<tr>
							<td class="bold"><TEX class="s16">PT. Jawa Pratama Mandiri</TEX><br>
								<tex class="underline">JL KARAH AGUNG 45 SURABAYA</tex>
							</td>
							<td class="text-center"><h1 class="s16">TANDA TERIMA TAGIHAN</h1></td>
							<td class="text-center"><tex class="bold">No. </tex><tex <!-- custom tag -- style="padding-left: 70px;margin-left:-10px;border-bottom: 1px solid black">(prenumber)</tex>
							</td>
						</tr>
						<tr>
							<td class="center-item" colspan="7">
								<div style="margin: auto;">
									<div class="float-left">Dari</div>
									<div class="float-left underline_div" style="width: 40vw;height: 10px;"></div>
									<div class="float-left">Alamat</div>
									<div class="float-left underline_div" style="width: 40vw;height: 10px;"></div>
								</div>
								<br>
								<div>
									Telah kami terima berupa
								</div>
								<table width="50%" class="border-none">
									<tr>
										<td>1</td>
										<td>Kwitansi/Invoice/Note</td>
										<td></td>
										<td class="text-center border">Ada / Tidak Ada</td>
									</tr>
									<tr>
										<td>2</td>
										<td>Faktur Pajak</td>
										<td></td>
										<td class="text-center border">Ada / Tidak Ada</td>
									</tr>
									<tr>
										<td>3</td>
										<td>Surat Peralihan asli</td>
										<td></td>
										<td class="text-center border">Ada / Tidak Ada</td>
									</tr>
									<tr>
										<td>4</td>
										<td>Surat Jalan asli</td>
										<td></td>
										<td class="text-center border">Ada / Tidak Ada</td>
									</tr>
									<tr>
										<td>5</td>
										<td>Lain-lain</td>
										<td>:</td>
										<td><div class="underline_div" style="width: 50%;height: 10px;margin-top: 15px;"></div></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<th colspan="3">Nilai Penagihan</th>
				<th colspan="4">Koreksi Dari Akuntasi</th>
			</tr>
			
			<tr class="text-center">
				<th>Tgl. Nota</th>
				<th>No. Nota</th>
				<th>Rupiah</th>
				<th>Kode</th>
				<th>( - ) +</th>
				<th>Sisa</th>
				<th>Uraian</th>
			</tr>
			<tr style="height: 5px;">
				<td colspan="7"></td>
			</tr>
			<tr class="border-none-bottom">
				<td class="text-center">1</td>
				<td>005000018</td>
				<td>Tortilla Catering</td>
				<td class="text-right">100,00 PAK</td>
				<td class="text-right">16,000.00</td>
				<td class="text-right" width="10%">1,600,000.00</td>
				<td class="text-right" width="10%">0.00</td>
			</tr>
			<tr class="border-none-bottom">
				<td class="empty"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr class="border-none-bottom">
				<td class="empty"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr class="border-none-bottom">
				<td class="empty"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr class="">
				<td class="empty"></td>
				<td></td>
				<td></td>
				<td class="border-none-bottom"></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="2" class="text-center bold border-top" class="empty">Total</td>
				<td></td>
				<td></td>
				<td colspan="2" class="border-top"></td>
				<td></td>
			</tr>
			
			<tr>
				<td colspan="7" style="padding: 10px;">
					<div class="float-left">Harap kembali tanggal</div>
					<div class="float-left underline_div" style="width: 15vw;height: 10px;margin-left: 5px;margin-right: 5px;"></div>
					<div class="float-left">atau menghubungi dulu kantor kamu melalui Telepon No.</div>
					<div class="float-left underline_div" style="width: 15vw;height: 10px;margin-left: 5px;margin-right: 5px;"></div>
				</td>
			</tr>
			<tr>
				<th colspan="2">Proses Hutang</th>
				<td colspan="5"></td>
			</tr>
			<tr>
				<td class="text-center">Hutang</td>
				<td class="text-center">Akutansi</td>
				<td colspan="5" rowspan="6" style="vertical-align: top;">
					
					<div class="float-right" style="margin-top: 15px;margin-right: 15px;">
						<div class="float-left">Surabaya ,</div>
						<div class="float-left underline_div" style="width: 15vw;height: 10px"></div>
						<br>
						<div class="float-left">Diterima Oleh,</div>
						<br>
						<div style="border-top:1px solid black;width: 20vw;margin-top: 50px;">Tanda Tangan & Nama Terang</div>
					</div>

				</td>
			</tr>
			<tr class="border-none-bottom">
				<td class="empty"></td>
				<td></td>
			</tr>
			<tr class="border-none-bottom">
				<td style="height: 70px;"></td>
				<td></td>
			
			<tr>
				<td class="text-center">Tanda Tangan</td>
				<td class="text-center">Tanda Tangan</td>
			</tr>

		</table>
	</div>
	<script type="text/javascript">
		function prints()
		{
			window.print();
		}
	</script>
</body>
</html>