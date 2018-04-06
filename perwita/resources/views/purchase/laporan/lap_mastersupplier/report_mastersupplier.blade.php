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
	width: 25%;
	height:30px;
	}
</style>

<div class=" pembungkus">
					<table width="100%" style="height: 50px; padding: 0;" border="1">
									<tr>
										<th>No</th>
				                        <th>Kode </th>
				                        <th>Nama </th>
				                        <th>Alamat</th>
				                        <th>Kota</th>
				                        <th>Provinsi</th>
				                        <th>Kode Pos</th>
				                        <th>Telp</th>
				                        <th>CP</th>
				                        <th>Kredit</th>
				                        <th>Curn</th>
									</tr>
									@foreach ($dat1 as $index => $a)
									<tr style="font-size: 13px">
										  <td align="center">{{ $index + 1 }}</td>
				                          <td align="center">{{ $dat1[$index][0]->no_supplier }}</td>
				                          <td align="center">{{ $dat1[$index][0]->nama_supplier  }}</td>
				                          <td align="center">{{ $dat1[$index][0]->alamat  }}</td>
				                          <td align="center">{{ $dat1[$index][0]->kota  }}</td>
				                          <td align="center">{{ $dat1[$index][0]->prov  }}</td>
				                          <td align="center">{{ $dat1[$index][0]->kodepos  }}</td>
				                          <td align="center">{{ $dat1[$index][0]->telp  }}</td>
				                          <td align="center">{{ $dat1[$index][0]->contact_person  }} </td>
				                          <td align="center">{{ $dat1[$index][0]->syarat_kredit  }} Hari</td>
				                          <td align="center">{{ $dat1[$index][0]->currency  }}</td>
									</tr>
									@endforeach
								</table>
</div>
