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
            <th hidden=""></th>
            <th> Nama </th>
            <th> Harga </th>
            <th> Jarak awal</th>
            <th> Jarak akir</th>
            <th> Tipe</th>
            <th> Keterangan </th>
          </tr>
          </thead>
          <tbody>
            @foreach ($dat1 as $index => $element)
          <tr>
            <td>{{ $index+1 }} </td>
            <td><input type="hidden" name="" value="{{$dat1[$index][0]->id_zona}}"> {{$dat1[$index][0]->id_zona}}  </td>
            <td> {{$dat1[$index][0]->nama}}  </td>
            <td> {{$dat1[$index][0]->harga_zona}} </td>
            <td> {{$dat1[$index][0]->jarak_awal}} </td>
            <td> {{$dat1[$index][0]->jarak_akir}} </td>
            <td> {{$dat1[$index][0]->tipe_zona}} </td>
            <td> {{$dat1[$index][0]->keterangan}} </td>
          </tr>
          @endforeach
          </tbody>
			</table>
</div>
