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
					<table id="addColumn" class="table table_header table-bordered table-striped" width="100%"> 
                    <thead>
                    <tr>
                      <th> No.</th>
                      <th> Kode</th>
                      <th> Nama </th>
                      <th> Nilai </th>
                      <th> Keterangan </th>
                      <th> Kode Accounting  </th>
                      <th> Kode cash </th>
                  </tr>
                    </thead>
                    <tbody>
                      @foreach ($dat1 as $index => $element)
                    <tr>
                      <td>{{ $index+1 }} </td>
                      <td>{{ $dat1[$index][0]->kode }}  </td>
                      <td>{{ $dat1[$index][0]->nama }}  </td>
                      <td>{{ number_format($dat1[$index][0]->nilai,0,',','.') }} </td>
                      <td>{{ $dat1[$index][0]->keterangan }} </td>
                      <td>{{ $dat1[$index][0]->acc1 }} </td>
                      <td>{{ $dat1[$index][0]->cash1 }} </td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
</div>
