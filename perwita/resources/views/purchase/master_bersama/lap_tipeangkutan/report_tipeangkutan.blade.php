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
									 <thead>
					                    <tr>
					                      <th  style="text-align: center"> No.</th>                      
					                      <th  style="text-align: center"> Kode</th>
					                      <th  style="text-align: center"> Nama </th>
					                      <th  style="text-align: center"> Bahan Bakar </th>
					                      <th  style="text-align: center"> Km/Liter </th>
					                    </tr>
					                    </thead>
					                    <tbody>
					                      @foreach ($dat1 as $index => $element)
					                    <tr>
					                      <td>{{ $index+1 }} </td>
					                      <td><input type="hidden" name="" value="{{ $dat1[$index][0]->kode }}">{{ $dat1[$index][0]->kode }}  </td>
					                      <td>{{ $dat1[$index][0]->nama }}  </td>
					                      <td>{{ $dat1[$index][0]->bahan_bakar }} </td>
					                      <td>{{ $dat1[$index][0]->bbm_per_liter }} </td>
					                    </tr>
					                    @endforeach
					                    </tbody>
								</table>
</div>
