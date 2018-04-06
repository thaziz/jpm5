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
										<th> No </th>
				                        <th> No Spp </th>
				                        <th> Keperluan </th>
				                        <th> Bagian</th>
				                        <th> Tanggal </th>
				                        <th> Gudang </th>
				                        <th> status </th>
									</tr>
									@foreach ($dat1 as $index => $a)
									<tr style="font-size: 13px">
										   <td>{{ $index+1 }}</td>
					                        <td><input type="hidden" name="" value="{{ $dat1[$index][0]->spp_nospp }}">{{ $dat1[$index][0]->spp_nospp }}</td>
					                        <td>{{ $dat1[$index][0]->spp_keperluan }}</td>
					                        <td>{{ $dat1[$index][0]->spp_bagian }}</td>
					                        <td>{{ $dat1[$index][0]->spp_tgldibutuhkan }}</td>
					                        <td>{{ $dat1[$index][0]->spp_lokasigudang }}</td>
					                        <td>{{ $dat1[$index][0]->spp_status }}</td>
									</tr>
									@endforeach
								</table>
</div>
