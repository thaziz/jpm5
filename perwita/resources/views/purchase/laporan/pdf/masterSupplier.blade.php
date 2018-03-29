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
	width: 25%;
	height:30px;
	}
</style>

<div class=" pembungkus">
	<div class="header" style="margin-bottom: 20px">
		<table width="100%">
			<tr><td>Laporan Master Supplier</td></tr>
		</table>
	</div>
					<table width="100%" style="height: 50px; padding: 0;" border="1">
									<tr>
										<th valign="middle" align="center" style="height: 50px;">No.</th>
										<th valign="middle" align="center" style="height: 50px;">No.Supplier</th>
										<th valign="middle" align="center">Nama</th>
										<th valign="middle" align="center">Alamat</th>
										<th valign="middle" align="center">Kota</th>
										<th valign="middle" align="center">Provinsi</th>
										<th valign="middle" align="center">Cabang</th>
										<th valign="middle" align="center">Kode Pos</th>
										<th valign="middle" align="center">Telp</th>
										<th valign="middle" align="center">Contact Person</th>
										<th valign="middle" align="center">Syarat Kredit</th>
										<th valign="middle" align="center">currency</th>
										<th valign="middle" align="center">Status</th>
									</tr>
									@foreach ($data2 as $index => $a)
									<tr style="font-size: 13px">
										<td>{{ $index+1 }}</td>
										<td>{{ $a->no_supplier }}</td>
										<td>{{ $a->nama_supplier }}</td>
										<td>{{ strtolower($a->alamat) }}</td>
										<td>{{ $a->kotnama }}</td>
										<td>{{ $a->provnama }}</td>
										<td>{{ $a->idcabang }}</td>
										<td>{{ $a->kodepos }}</td>
										<td>{{ $a->telp }}</td>
										<td>{{ $a->contact_person }}</td>
										<td>{{ $a->syarat_kredit }}</td>
										<td>{{ $a->currency }}</td>
										<td>{{ $a->status }}</td>
									</tr>
									@endforeach
								</table>
</div>
