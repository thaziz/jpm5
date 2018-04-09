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
		                        <th align="center" width="20%" hidden="">Kode</th>
		                        <th align="center" width="20%">Nama</th>
		                        <th align="center" width="20%">Cabang</th>
		                        <th align="center" width="20%">keterangan</th>
		                        <th align="center" width="20%">persen</th>
		                        <th align="center" width="20%">Jenis Biaya</th>
		                        <th align="center" width="20%">kode akun</th>
		                        
		                    </tr>
		                 
		                    </thead>
		                    
		                    <tbody>
		                      @foreach ($dat1 as $index => $element)
		                        <tr>
		                          <td align="center">{{ $index + 1 }}</td>
		                          <td hidden="" align="center"><input type="hidden" name="" value="{{ $dat1[$index][0]->kode }}">{{ $dat1[$index][0]->kode }}</td>
		                          <td align="center">{{ $dat1[$index][0]->nama }}</td>
		                          <td align="center">{{ $dat1[$index][0]->cabang }}</td>
		                          <td align="center">{{ $dat1[$index][0]->keterangan }}</td>
		                          <td align="center">{{ $dat1[$index][0]->persen }}</td>
		                          <td align="center">{{ $dat1[$index][0]->jenis_biaya }}</td>
		                          <td align="center">{{ $dat1[$index][0]->kode_akun }}</td>
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