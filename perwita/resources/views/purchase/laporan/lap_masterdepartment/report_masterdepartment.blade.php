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
		                        <th > Kode  </th>
		                        <th> Nama  </th>
							</tr>
							@foreach ($dat1 as $index => $element)
							<tr>
								<td>{{ $index+1 }}</td>
								<td>{{ $dat1[$index][0]->kode_department }}</td>
								<td>{{ $dat1[$index][0]->nama_department }}</td>
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