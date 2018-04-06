
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
</style>

<div class=" pembungkus">
					<table class="table" width="100%">
									<tr>
										<th valign="middle" align="center">NO</th>
										<th valign="middle" align="center">Kode</th>
										<th valign="middle" align="center">Nama</th>
										<th valign="middle" align="center">Alamat</th>
									</tr>
				                      @foreach ($dat1 as $index => $element)
				                      	 <tr>
				                          <td align="center">{{ $index + 1 }}</td>
				                          <td align="center">{{ $dat1[$index][0]->mg_id }}</td>
				                          <td align="center">{{ $dat1[$index][0]->mg_namagudang }}</td>
				                          <td align="center">{{ $dat1[$index][0]->mg_alamat }}</td>
				                        </tr>
				                      @endforeach						
					</table>
		
</div>
