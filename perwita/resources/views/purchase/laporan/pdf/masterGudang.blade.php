
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
</style>

<div class=" pembungkus">
					<table class="border" width="100%">
									<tr>
										<th valign="middle" align="center">NO</th>
										<th valign="middle" align="center">Nama</th>
										<th valign="middle" align="center">Cabang</th>
										<th valign="middle" align="center">Alamat</th>
									</tr>
				                      @foreach ($data2 as $index => $element)
				                      	 <tr>
				                          <td align="center">{{ $index + 1 }}</td>
				                          <td align="center">{{ $element->mg_namagudang }}</td>
				                          <td align="center">{{ $element->mg_cabang }}</td>
				                          <td align="center">{{ $element->mg_alamat }}</td>
				                        </tr>
				                      @endforeach	
				                     {{--  @for ($i = 0; $i < count($data1) ; $i++)
				                      	 <tr>
				                          <td align="center">{{ $i + 1 }}</td>
				                          <td align="center">{{ $data1[$i][0]->mg_namagudang }}</td>
				                          <td align="center">{{ $data1[$i][0]->mg_namagudang }}</td>
				                          <td align="center">{{ $data1[$i][0]->mg_namagudang }}</td>
				                        </tr>
				                      @endfor --}}
				             {{-- <tr>
				             	<td>1</td>
				             	<td>1</td>
				             	<td>1</td>
				             	<td>1</td>
				             </tr> --}}
						
					</table>
		
</div>
