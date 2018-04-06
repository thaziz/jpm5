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
									  <th  style="text-align: center"> No.</th>                      
				                      <th  style="text-align: center"> Nota BKK</th>
				                      <th  style="text-align: center"> Tgl </th>
				                      <th  style="text-align: center"> jenis bayar </th>
				                      <th  style="text-align: center"> Akun kas - Akun hutang</th>
				                      <th  style="text-align: center"> keterangan</th>
				                      <th  style="text-align: center"> Status BKK </th>
									</tr>

									@foreach ($dat1 as $index => $a)
									<tr style="font-size: 13px">
									  <td> {{ $index+1 }} </td>
				                      <td> {{ $dat1[$index][0]->bkk_nota }}  </td>
				                      <td>  {{ $dat1[$index][0]->bkk_tgl }}  </td>
				                      <td>{{ $dat1[$index][0]->bkk_jenisbayar }} </td>
				                      <td> {{ $dat1[$index][0]->bkk_akun_kas }} - {{ $dat1[$index][0]->bkk_akun_hutang }}  </td>
				                      <td> {{ $dat1[$index][0]->bkk_keterangan }}  </td>
				                      <td>  {{ $dat1[$index][0]->bkk_status }} </td>
									</tr>
									@endforeach
								</table>
</div>
