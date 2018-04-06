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
					                      <th  style="text-align: center"> keperluan </th>
					                      <th  style="text-align: center"> Peminta </th>
					                      <th  style="text-align: center"> Status</th>
					                      <th  style="text-align: center"> Jenis Keluar</th>
					                      <th  style="text-align: center"> Total </th>
									</tr>

									@foreach ($dat1 as $index => $a)
									<tr style="font-size: 13px">
									  	  <td hidden=""><input type="hidden" name="" value="{{ $dat1[$index][0]->pb_id }}">{{ $dat1[$index][0]->pb_id }} </td>
					                      <td>{{ $index+1 }} </td>
					                      <td>{{ $dat1[$index][0]->pb_nota }}  </td>
					                      <td>{{ $dat1[$index][0]->pb_tgl }}  </td>
					                      <td>{{ $dat1[$index][0]->pb_keperluan }} </td>
					                      <td>{{ $dat1[$index][0]->pb_nama_peminta }} </td>
					                      <td>{{ $dat1[$index][0]->pb_status }} </td>
					                      <td>{{ $dat1[$index][0]->pb_jenis_keluar }} </td>
					                      <td>{{ number_format($dat1[$index][0]->pb_total,0,',','.') }} </td>
									</tr>
									@endforeach
								</table>
</div>
