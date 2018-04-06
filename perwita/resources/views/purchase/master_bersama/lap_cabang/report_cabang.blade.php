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
									   	  <th  style="text-align: center" height="40px"> No.</th>                      
					                      <th  style="text-align: center"> Kode</th>
					                      <th  style="text-align: center"> nama </th>
					                      <th  style="text-align: center"> alamat </th>
					                      <th  style="text-align: center"> telpon </th>
					                      <th  style="text-align: center"> fax</th>
					                      <th  style="text-align: center"> Kota</th>
									</tr>

									@foreach ($dat1 as $index => $a)
									<tr style="font-size: 13px">
									  	  <td>{{ $index+1 }} </td>
					                      <td><input type="hidden" name="" value="{{ $dat1[$index][0]->kode }}">{{ $dat1[$index][0]->kode }}  </td>
					                      <td>{{ $dat1[$index][0]->nama }}  </td>
					                      <td>{{ $dat1[$index][0]->alamat }} </td>
					                      <td>{{ $dat1[$index][0]->telpon }} </td>
					                      <td>{{ $dat1[$index][0]->fax }} </td>
					                      <td>{{ $dat1[$index][0]->kota }} </td>
									</tr>
									@endforeach
								</table>
</div>
