<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Master Item</title>
	<!-- Bootstrap -->
    <link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <style>
    	div.container{
    		margin-top: 20px;
    	}

    	#button{
    		margin: 10px 0;
    	}

    	div.surat{
    		margin-top: 30px;
    		font-weight: bold;
    		font-size: 20px;
    	}

    	#tgl{
    		margin-top: 20px;
    		font-size: 13px;
    	}
    </style>
</head>
<body>
	<div class="container">
		<div class="wrapper-table">
			<table border="1" class="table table-bordered" id="table-parent">
				{{-- <tr>
					<td valign="middle" align="center" id="td-first">
						<img src="{{ asset('/assets/img/dboard/logo/Capture.png') }}" alt="">
					</td>

					<td valign="middle" align="center" id="td-first">
						<div class="surat">
										LAPORAN MASTER BARANG PEMBELIAN
						</div>
					</td>

					<td valign="middle" id="td-first-sibbling">
						<table width="100%" id="tgl">
							<tr>
								<td>Tanggal</td>
								<td>:</td>
								<td> 23 November 2017</td>
							</tr>
						</table>
					</td>
				</tr> --}}

				<tr>
					<td colspan="3" style="padding: 0;">
						<table width="100%" style="height: 35px; padding: 0;" border="1">
							<tr>
								<td valign="middle" align="center">NO</td>
								<td valign="middle" align="center">Kode</td>
								<td valign="middle" align="center">Nama Item</td>
								<td valign="middle" align="center">Group</td>
								<td valign="middle" align="center">Satuan</td>
								<td valign="middle" align="center">Acc Stock</td>
								<td valign="middle" align="center">Acc HP</td>
							</tr>

							{{-- @for ($index = 0; $index < count($data2); $index++)
								<tr>
						          	<td align="center">{{ $data2[$index]->kode_item}}</td>
						        </tr>
							@endfor --}}
							{{-- <tr>
								<td>1w</td>
								<td>1</td>
								<td>1</td>
								<td>1</td>
								<td>1</td>
								<td>1</td>
								<td>1</td>
							</tr> --}}



							@foreach ($data2 as $index => $element)
							<tr>
								<td>{{ $index+1 }}</td>
								<td>{{ $element->kode_item }}</td>
								<td>{{ $element->nama_masteritem }}</td>
								<td>{{ $element->groupitem }}</td>
								<td>{{ $element->unitstock }}</td>
								<td>{{ $element->acc_persediaan }}</td>
								<td>{{ $element->acc_hpp }}</td>

							</tr>
							@endforeach






						</table>
					</td>
				</tr>
			</table>
		</div>	
	</div>
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/bootstrap/js/bootstrap.min.js') }}"></script>
<script>
	$('#button').on('click', function () {
		$(this).hide();
	});
</script>
</body>
</html>