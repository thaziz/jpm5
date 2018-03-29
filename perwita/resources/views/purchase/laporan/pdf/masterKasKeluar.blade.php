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
										<th valign="middle" align="center" style="height: 50px;">No. Kas Nota</th>
										<th valign="middle" align="center">Tanggal</th>
										<th valign="middle" align="center">Jenis Bayar</th>
										<th valign="middle" align="center">Supplier</th>
										<th valign="middle" align="center">Keterangan</th>
										<th valign="middle" align="center">Bkk Comp</th>
										<th valign="middle" align="center">Total</th>
										<th valign="middle" align="center">Akun kas</th>
										<th valign="middle" align="center">Akun Hutang</th>
										<th valign="middle" align="center">Status</th>
									</tr>

									@foreach ($data2 as $index => $a)
									<tr style="font-size: 13px">
										<td>{{ $index+1 }}</td>
										<td>{{ $a->bkk_nota }}</td>
										<td>{{ $a->bkk_tgl }}</td>
										<td>{{ $a->bkk_jenisbayar }}</td>
										<td>{{ $a->bkk_supplier }}</td>
										<td>{{ $a->bkk_keterangan }}</td>
										<td>{{ $a->bkk_comp }}</td>
										<td>{{ $a->bkk_total }}</td>
										<td>{{ $a->bkk_akun_kas }}</td>
										<td>{{ $a->bkk_akun_hutang }}</td>
										<td>{{ $a->bkk_status}}</td>
									</tr>
									@endforeach
								</table>
</div>
