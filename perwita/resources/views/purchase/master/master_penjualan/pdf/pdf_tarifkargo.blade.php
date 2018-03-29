
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
                    			<thead>
									<tr>
										<th align="center"> No. </th>
										<th align="center"> Kota Asal</th>
				                        <th align="center"> Kota Tujuan</th>
				                        <th >kode</th>
				                        <th align="center"> jenis </th>
				                        <th align="center"> Keterangan</th>
				                        <th align="center"> Tarif</th>
									</tr>
								</thead>
								<tbody>
				                      @foreach($data2 as $index => $val)
					                      <tr style="font-size: 12px;">
					                      	<td>{{ $index+1 }}</td>
					                        <td>{{$val->asal}}</td>
					                        <td>{{$val->tujuan}}</td>
					                        <td >{{$val->kode}}</td>
					                        <td align="center">{{$val->jenis}}</td>
					                        <td align="center">-</td>
					                        <td>{{"Rp " . number_format($val->harga,2,",",".")}}</td>
					                      </tr>
					                      @endforeach
				                     </tbody>

					</table>
		
</div>
