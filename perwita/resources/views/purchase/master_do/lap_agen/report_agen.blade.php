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
                      <th> No.</th>
                      <th> Kode</th>
                      <th> Nama </th>
                      <th> Kategori </th>
                      <th> Alamat </th>
                      <th> Kota </th>
                      <th> Telpon </th>
                      <th> Fax </th>
                      <th> Komisi Outlet</th>
                      <th> Komisi Agen</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach ($dat1 as $index => $element)
                    <tr>
                      <td>{{ $index+1 }} </td>
                      <td><input type="hidden" name="" value="{{ $dat1[$index][0]->kode }}">{{ $dat1[$index][0]->kode }}  </td>
                      <td>{{ $dat1[$index][0]->nama }}  </td>
                      <td>{{ $dat1[$index][0]->kategori }}  </td>
                      <td>{{ $dat1[$index][0]->alamat }} </td>
                      <td>{{ $dat1[$index][0]->kode_area }} </td>
                      <td>{{ $dat1[$index][0]->telpon }} </td>
                      <td>{{ $dat1[$index][0]->fax }} </td>
                      <td>{{ $dat1[$index][0]->komisi }}</td>
                      <td>{{ $dat1[$index][0]->komisi_agen }}</td>
                      </tr>
                    @endforeach
                    </tbody>
			</table>
</div>
