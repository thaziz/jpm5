@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Penerimaan Barang </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Warehouse Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Penerimaan Barang  </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Penerimaan Barang
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        
                    </div>
                </div>
                <div class="ibox-content">
					<div class="row">
						<div class="col-xs-12">
							<div class="box" id="seragam_box">
							<div class="box-header">
							</div><!-- /.box-header -->
								<form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
								<div class="box-body">
								</div>        
                    		


							<div class="box-body">  
							<div class="row">
								<div class="col-sm-3">
									<table class="table" border="0">
										<tr>
											<td> Gudang : </td>
											<td>
												<select class="form-control gudang">
														<option value=""> Pilih Gudang </option>
													@foreach($data['gudang'] as $gudang)
														<option value="{{$gudang->mg_id}}"> {{$gudang->mg_namagudang}} </option>
													@endforeach
												</select>
											</td>
										</tr>								
									</table>
								</div>
							</div>
							<br>

							  <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
								<thead>
								 <tr>
									<th style="width:10px">NO</th>
									<th> No PO </th>
								  
									<th> Supplier </th>
									<th> Status </th>
							   
									<th> Aksi </th>						  
								</tr>					  
								</thead>
								<tbody>
								<!--   @for($j=0; $j < count($data['terima']); $j++)
								 
								  <tr>
									<td> {{$j + 1}} </td>
									<td>  {{$data['terima'][$j]->bt_notransaksi}} </td>
									<td>  {{$data['terima'][$j]->nama_supplier}} </td>
									<td> <span class="label label-info"> {{$data['terima'][$j]->bt_statuspenerimaan}} </span> </td> 
									<td>      <a class="btn btn-sm btn-success" href={{url('penerimaanbarang/detailterimabarang/'. $data['terima'][$j]->bt_id . '/' . $data['terima'][$j]->bt_flag  .'')}}> <i class="fa fa-arrow-right" aria-hidden="true"></i> </a> &nbsp;
								
									</td>                        
								  </tr>
								  @endfor -->
								</tbody>   
							</table>
							</div><!-- /.box-body -->
					
							<div class="box-footer">
							  <div class="pull-right">  
								
								</div>
							</div><!-- /.box-footer --> 
							</div><!-- /.box -->
						</div><!-- /.col -->
					</div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

     tableDetail = $('.tbl-penerimabarang').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

  	$('.gudang').change(function(){
  		var idgudang = $(this).val();
  		$.ajax({
  			url : baseUrl + '/penerimaanbarang/cekgudang',
  			data : {idgudang},
  			type : "POST",
  			dataType : 'json',
  			success : function (data){
  			var tablepenerimaan = $('#addColumn').DataTable();
            tablepenerimaan.clear().draw();            	
									
            var n = 1;
            for(var j = 0; j < data.terima.length; j++){   
	          
	            console.log('a');          
	                var html2 = "<tr> <td>"+ n +" </td>" +
	                                "<td>  "+data.terima[j].bt_notransaksi+" -"+data.terima[j].bt_id+"</td>" +
									"<td>  "+data.terima[j].nama_supplier+" </td>" +
									"<td> <span class='label label-info'> "+data.terima[j].bt_statuspenerimaan+" </span> </td>" + 
									"<td>      <a class='btn btn-sm btn-success' href={{url('penerimaanbarang/detailterimabarang')}}"+'/' +data.terima[j].bt_id+"> <i class='fa fa-arrow-right' aria-hidden='true'></i>"+data.terima[j].bt_id		+"</a> &nbsp;" +
									"</td>";                        
	                                  	                                  
	                              html2 +=  "</tr>";

	               tablepenerimaan.rows.add($(html2)).draw();
	               n++;
	            }

  			}
  		})
  	})
</script>
@endsection
