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
									  <th  hidden="" style="text-align: center"> No.</th>                      
				                      <th  style="text-align: center"> No.</th>                      
				                      <th  style="text-align: center"> Kode</th>
				                      <th  style="text-align: center"> Tgl </th>
				                      <th  style="text-align: center"> Supplier </th>
				                      <th  style="text-align: center"> Terima Dari </th>
				                      <th  style="text-align: center"> Gudang</th>
				                      <th  style="text-align: center"> acc HutangDagang</th>
				                      <th  style="text-align: center"> Status </th>
									</tr>

									@foreach ($dat1 as $index => $a)
									<tr style="font-size: 13px">
									  <td hidden="">{{ $dat1[$index][0]->pb_id }} </td>
				                      <td>{{ $index+1 }} </td>
				                      <td><input type="hidden" name="" value="{{ $dat1[$index][0]->pb_lpb }}">  {{ $dat1[$index][0]->pb_lpb }}  </td>
				                      <td>{{ $dat1[$index][0]->pb_suratjalan }}  </td>
				                      <td>{{ $dat1[$index][0]->supplier }} </td>
				                      <td>{{ $dat1[$index][0]->pb_terimadari }} </td>
				                      <td>{{ $dat1[$index][0]->gudang }}  </td>
				                      <td>{{ $dat1[$index][0]->akun }} </td>
				                      <td>{{ $dat1[$index][0]->pb_status }} </td>
									</tr>
									@endforeach
								</table>
</div>
