
	
	<style type="text/css">
			table, td, th{
				border: 1px solid black;
				font-size: 11px;
				font-family:Arial!important;
			}
			table{
				border-collapse: collapse;
			}
			th{
				text-align: center !important;
			}
			ul{
				text-align: left;
				padding-left: 20px;
			}
		</style>


	<div class="col-sm-12">
		
		<h3 style="margin-bottom: 5px;">PT. JAWA PRATAMA MANDIRI</h3>
		<h4 style="margin: 5px 0;">Laporan Rekap Surat Permintaan Pembelian</h4>
		<h4 style="margin-bottom: 5px; margin-top: 0px;">Periode : {{$bulan1}} s/d {{$bulan2}}</h4>
		

	  <form method="POST" action="{{route('tabel',  ['download' => 'pdf','data'=>$data,'tgl1'=>$tgl1,'tgl2'=>$tgl2]) }}">
	  	{{ csrf_field() }}
		<table style="width: 100%; margin: 0 auto">

		  <thead>
		  	<tr >
		    <th align="center">No.</th>
		    <th align="center">Perusahaan Pemohon</th>
		    <th align="center">No SPP</th>
		    <th align="center">Tanggal Di Butuhkan</th>
		    <th align="center">SPP Keperluan</th>
		    <th align="center">SPP Bagian</th>
		    <th align="center">Status</th>
		    <th align="center">No PO</th>
			</tr>
		  </thead>
		  <tbody>
		  	@foreach($data as $index => $val)
		  	<tr style="text-align: center;">
		  		<td align="center">{{$index+1}}</td>
		  		<td>{{$data[$index]->nama}}</td>
		  		<td >{{$data[$index]->spp_nospp}}</td>
		  		<td align="center">{{$data[$index]->spp_tgldibutuhkan}}</td>
		  		<td align="center" width="100">{{$data[$index]->spp_keperluan}}</td>
		  		<td align="center">{{$data[$index]->spp_bagian}}</td>
		  		<td align="center">{{$data[$index]->spp_status}}</td>

		  		<td>
		  			<ul style="margin-bottom: 0px; margin-top: 0px;">
	                  @foreach($po as $barang)
	                  @if($barang->spptb_idspp == $val->spp_id)
	                  <li>{{$barang->spptb_supplier}}</li>
	                  @endif
	                  @endforeach
	                </ul>
		  		</td>

		  	</tr>
		  	@endforeach
		  </tbody>

		</table>

		</form>
	</div>

		
	</script>


