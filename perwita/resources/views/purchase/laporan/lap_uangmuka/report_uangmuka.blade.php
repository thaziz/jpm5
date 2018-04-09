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
							<thead>
				             <tr >
				                <th align="center" width="20%">NO</th>
				                <th align="center" width="20%">No bukti</th>
				                <th align="center" width="20%">tanggal</th>
				                <th align="center" width="20%">Tempo</th>
				                <th align="center" width="20%">keterangan</th>
				                <th align="center" width="20%">supllier</th>
				                <th align="center" width="20%">hasil</th>
				                
				            </tr>
				         
				            </thead>
				            
				            <tbody>
				              @foreach ($dat1 as $index => $element)
				                <tr>
				                  <td align="center">{{ $index + 1 }}</td>
				                  <td align="center"><input type="hidden" name="" value="{{ $dat1[$index][0]->v_nomorbukti }}">{{ $dat1[$index][0]->v_nomorbukti }}</td>
				                  <td align="center">{{ $dat1[$index][0]->v_tgl }}</td>
				                  <td align="center">{{ $dat1[$index][0]->v_tempo }}</td>
				                  <td align="center">{{ $dat1[$index][0]->v_keterangan }}</td>
				                  <td align="center">{{ $dat1[$index][0]->v_supid }}</td>
				                  <td align="center">{{ $dat1[$index][0]->v_hasil }}</td>
				                </tr>
				              @endforeach
				            </tbody>
						</table>
				</div>	
<script>
	$('#button').on('click', function () {
		$(this).hide();
	});
</script>
</body>
</html>