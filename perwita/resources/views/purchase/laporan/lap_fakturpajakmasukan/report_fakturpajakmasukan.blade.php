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
										<th> No.</th>
				                        <th> Faktur Pajak Masukan </th>
				                        <th> Tanggal </th>
				                        <th> Masa pajak </th>
				                        <th> D P P </th>
				                        <th> PPn </th>
				                        <th> Netto </th>
									</tr>

									@foreach ($dat1 as $index => $a)
									<tr style="font-size: 13px">
										<td>{{ $index+1 }}</td>
										<td>{{ $dat1[$index][0]->fpm_nota }}</td>
										<td>{{ $dat1[$index][0]->fpm_tgl }}</td>
										<td>{{ $dat1[$index][0]->fpm_masapajak }}</td>
										<td>{{ number_format($dat1[$index][0]->fpm_dpp,0,',','.')}}</td>
										<td>{{ number_format($dat1[$index][0]->fpm_inputppn,0,',','.') }}</td>
										<td>{{ number_format($dat1[$index][0]->fpm_netto,0,',','.') }}</td>
									</tr>
									@endforeach
								</table>
</div>
