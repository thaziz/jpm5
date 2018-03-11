	<style type="text/css">
			table, td, th{
				border: 1px solid black;
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
    <link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

	<div class="col-sm-12">
		
		<h3 style="margin-bottom: 5px;">PT. JAWA PRATAMA MANDIRI</h3>
		<h4 style="margin: 5px 0;">Laporan Rekap Surat Permintaan Pembelian</h4>
		<h4 style="margin-bottom: 5px; margin-top: 0px;">Periode : {{$bulan1}} s/d {{$bulan2}}</h4>
		

	  <form method="POST" action="{{route('tabel1',  ['download' => 'pdf','data'=>$data,'tgl1'=>$tgl1,'tgl2'=>$tgl2]) }}">
	  	{{ csrf_field() }}
		<table style="width: 100%; margin: 0 auto"  id="resultsTable" data-tableName="Test Table 2" class="table table-bordered">

		  <thead>
		  	<tr >
		    <th align="center">No.</th>
		    <th align="center">Perusahaan Pemohon</th>
		    <th align="center">No PO</th>
		    <th align="center">Tanggal Di Butuhkan</th>
		    <th align="center">Supplier</th>
		    <th align="center">Jumlah Biaya</th>
		    <th align="center">Status</th>
			</tr>
		  </thead>
		  <tbody>
		  	@foreach($data as $index => $val)
		  	<tr style="text-align: center;" class="noExl">
		  		<td align="center">{{$index+1}}</td>
		  		<td>{{$data[$index]->nama}}</td>
		  		<td >{{$data[$index]->po_no}}</td>
		  		<td align="center" width="200">{{$data[$index]->spp_tgldibutuhkan}}</td>
		  		<td align="center">{{$data[$index]->nama_supplier}}</td>
		  		<td align="center">{{"Rp " . number_format($data[$index]->po_totalharga,2,",",".")}}</td>
		  		<td align="center">{{$data[$index]->po_status}}</td>
		  	</tr>
		  @endforeach
		  </tbody>

		</table>
		<input type="submit" class="btn btn-primary" style="margin-top: 5px;" value="Cetak PDF">
		 <a class="btn btn-default" id="export-btn">Export</a>
		</form>
	</div>
	<script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery.table2excel.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript">

  $(function() {
				$(".resultsTable").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: "myFileName" + new Date().toISOString().replace(/[\-\:\.]/g, ""),
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			});

	</script>


