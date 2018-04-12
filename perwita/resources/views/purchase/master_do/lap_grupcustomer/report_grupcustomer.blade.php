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
              <th> No. </th>
              <th> Group id </th>
              <th> Group Name </th>
              <th> Alamat </th>
              <th> Folder </th>
              <th> Persons </th>
            </tr>
            </thead>
            <tbody>
              @foreach ($dat1 as $index => $e)
            <tr>
              <td>{{ $index+1 }} </td>
              <td><input type="hidden" name="" value="{{ $dat1[$index][0]->group_id }}">{{ $dat1[$index][0]->group_id }}</td>
              <td>{{ $dat1[$index][0]->group_nama }}</td>
              <td>{{ $dat1[$index][0]->group_alamat }}</td>
              <td>{{ $dat1[$index][0]->group_folder }}</td>
              <td>{{ $dat1[$index][0]->group_person }}</td>
              </tr>
            @endforeach
            </tbody>
			</table>
</div>
