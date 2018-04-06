<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Master Item</title>

    <style>
     table {
    border-collapse: collapse;
	}
	  table,th,td{
	    border :1px solid black;
	  }
	.pembungkus {
		width: 900px;
	}    
    </style>
</head>
<body>
				<div class="pembungkus">
						<table class="table table-bordered table-striped" width="100%">
							<tr>
								<th width="50" height="40px"> No.</th>
		                        <th > Kode Item </th>
		                        <th> Nama Item </th>
		                        <th> Group Item</th> 
		                        <th> Acc Stock </th>
		                        <th> Acc HP </th> 
		                        <th> Harga</th> 
							</tr>
							@foreach ($dat1 as $index => $element)
							<tr>
								<td>{{ $index+1 }}</td>
								<td>{{ $dat1[$index][0]->kode_item }}</td>
								<td>{{ $dat1[$index][0]->nama_masteritem }}</td>
								<td>{{ $dat1[$index][0]->groupitem }}</td>
								<td>{{ $dat1[$index][0]->acc_persediaan }}</td>
								<td>{{ $dat1[$index][0]->acc_hpp }}</td>
								<td>{{ $dat1[$index][0]->harga }}</td>
							</tr>
							@endforeach
						</table>
				</div>	
<script>
	$('#button').on('click', function () {
		$(this).hide();
	});
</script>
</body>
</html>