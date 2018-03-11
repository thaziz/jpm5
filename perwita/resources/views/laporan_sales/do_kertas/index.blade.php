@extends("main")

@section("title", "dashboard")

@section("content")
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
                	<div class="ibox-title">
                		<h5>DELIVERY ORDER</h5>
	                	<div class="ibox-tools"><!-- Horizontal Line --></div>

	                	<div class="text-right">
							<a href="{{ route('DelOrder.redirect') }}">
								<button  type="button" style="margin-right :12px; width:110px" class="btn btn-success " id="addData" name="addData">
	                				</i>Tambah Data
	                			</button>
							</a>
	                	</div>
                    </div> <!-- ibox.title -->

                    <div class="ibox-content">
                		<div class="row">
                			<div class="col-xs-12">
                				<div class="box" id="seragam_box">
                					<div class="box-header">
                						<div class="box-body">
                							<table id="data" class="table table-bordered table-hover" cellspacing="10">
                								<thead>
	                								<tr>
	                									<th>Nomor</th>
	                									<th>No.Do</th>
	                									<th>Tanggal</th>
	                									<th>Pengirim</th>
	                									<th>Penerima</th>
	                									<th>Kota asal</th>
	                									<th>Kota Tujuan</th>
	                									<th>Status</th>
	                									<th>Tarif</th>
	                									<th>Aksi</th>
	                								</tr> <!-- head -->
                								</thead>
												
												<tbody>
													@for ($i = 0; $i < count($data); $i++)
														<tr>
														    <td>{{ $i + 1 }}</td>
														    <td>{{ $data[$i]->nomor }}</td>
														    <td>{{ $data[$i]->tanggal }}</td>
														    <td>{{ $data[$i]->nama_pengirim }}</td>
														    <td>{{ $data[$i]->nama_penerima }}</td>
														    <td>{{ $data[$i]->id_kota_asal }}</td>
														    <td>{{ $data[$i]->id_kota_tujuan }}</td>
														    <td>{{ $data[$i]->status }}</td>
														    <td>{{ $data[$i]->total }}</td>
														    <td>
														    	<div class="btn-group">
                                        							<a href="" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-warning btn-xs btnedit">
                                        								<i class="fa fa-print"></i>
                                        							</a>
                                        							
                                        							<a href="" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit">
                                        								<i class="fa fa-pencil"></i>
                                        							</a>
                                        							
                                        							<a href="" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger btnhapus">
                                        								<i class="fa fa-times"></i>
                                        							</a>
                                    							</div>
														    </td>
													    </tr>
													@endfor
												</tbody>
                							</table>
                						</div>
                					</div>
                				</div>
                			</div>	
                		</div>
                	</div> <!-- ibox.content -->
                </div> 
			</div> 
		</div> <!-- div.row -->
	</div> <!-- div.wrapper -->
@endsection


@section('extra_scripts')
<script type="text/javascript">
	$(document).ready(function() {
		 $('#data').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
      	});
	});
</script>
@endsection()