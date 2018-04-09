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
            <th> D/K </th>
            <th> Account </th>
            <th> Cash FLow </th>
          </tr>
          </thead>
          <tbody>
            @foreach ($dat1 as $index => $e)
          <tr>
            <td>{{ $index+1 }} </td>
            <td><input type="hidden" name="" value="{{ $dat1[$index][0]->b_kode }}">{{ $dat1[$index][0]->b_kode }}</td>
            <td>{{ $dat1[$index][0]->b_nama }}</td>
            <td>{{ $dat1[$index][0]->b_debet_kredit }}</td>
            <td>{{ $dat1[$index][0]->b_acc_hutang }}</td>
            <td>{{ $dat1[$index][0]->b_csf_hutang }}</td>
            </tr>
          @endforeach
          </tbody>
			</table>
</div>
