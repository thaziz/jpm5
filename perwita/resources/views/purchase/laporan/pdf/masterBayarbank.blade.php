<style>
	.pembungkus{
		width: 100%;
	}
	table {
    border-collapse: collapse;
	}
	table,th,td{
	border :1px solid black;
	}
	.header{
    border-collapse: collapse;
	border :1px solid black;
	font-size: 16;
	font-weight: bold;
	width: 30%;
	height:30px;
	}
</style>

<div class=" pembungkus">
	<div class="header" style="margin-bottom: 20px">
		<table width="100%">
			<tr><td>Laporan Bayar Bank</td></tr>
		</table>
	</div>
					<table width="100%" {{-- style="height: 50px; padding: 0;" --}} border="1">
									<tr>
										<th valign="middle" align="center" style="height: 50px;">No.</th>
										<th valign="middle" align="center" style="height: 50px;">No.Bank Keluar</th>
										<th valign="middle" align="center">Bkk kode bank</th>
										<th valign="middle" align="center">Bkk Cabang</th>
										<th valign="middle" align="center">Tanggal</th>
										<th valign="middle" align="center">Keterangan</th>
										<th valign="middle" align="center">Cek bg</th>
										<th valign="middle" align="center">Biaya</th>
										<th valign="middle" align="center">Total</th>
										<th valign="middle" align="center">Flag</th>
									</tr>

									@foreach ($data2 as $index => $a)
									<tr style="font-size: 13px">
										<td>{{ $index+1 }}</td>
										<td>{{ $a->bbk_nota }}</td>
										<td>{{ $a->bbk_kodebank }}</td>
										<td>{{ $a->bbk_cabang }}</td>
										<td>{{ $a->bbk_tgl }}</td>
										<td>{{ strtolower($a->bbk_keterangan) }}</td>
										<td>{{ $a->bbk_cekbg }}</td>
										<td>{{ $a->bbk_biaya }}</td>
										<td>{{ $a->bbk_total }}</td>
										<td>{{ $a->bbk_flag }}</td>
									</tr>
									@endforeach
								</table>
</div>
