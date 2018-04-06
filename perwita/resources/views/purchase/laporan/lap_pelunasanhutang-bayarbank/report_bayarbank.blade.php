<style>
	.pembungkus{
		width: 900px;
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

									@foreach ($dat1 as $index => $a)
									<tr style="font-size: 13px">
										<td>{{ $index+1 }}</td>
										<td>{{ $dat1[$index][0]->bbk_nota }}</td>
										<td>{{ $dat1[$index][0]->bbk_kodebank }}</td>
										<td>{{ $dat1[$index][0]->bbk_cabang }}</td>
										<td>{{ $dat1[$index][0]->bbk_tgl }}</td>
										<td>{{ strtolower($dat1[$index][0]->bbk_keterangan) }}</td>
										<td>{{ $dat1[$index][0]->bbk_cekbg }}</td>
										<td>{{ $dat1[$index][0]->bbk_biaya }}</td>
										<td>{{ $dat1[$index][0]->bbk_total }}</td>
										<td>{{ $dat1[$index][0]->bbk_flag }}</td>
									</tr>
									@endforeach
								</table>
</div>
