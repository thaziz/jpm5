@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> NOTA DEBET KREDIT  
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <div class="text-right">
                       <button  type="button" class="btn btn-success " id="btn_add" name="btnok"><i class="glyphicon glyphicon-plus"></i>Tambah Data</button>
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
                       <!--  <div class="form-group">

                            <div class="form-group">
                            <label for="bulan_id" class="col-sm-1 control-label">Bulan</label>
                            <div class="col-sm-2">
                             <select id="bulan_id" name="bulan_id" class="form-control">
                                                      <option value="">Pilih Bulan</option>

                              </select>
                            </div>
                          </div>
                          </div>
                           <div class="form-group">

                            <div class="form-group">
                            <label for="tahun" class="col-sm-1 control-label">Tahun</label>
                            <div class="col-sm-2">
                             <select id="tahun" name="tahun" class="form-control">
                                                      <option value="">Pilih Tahun</option>

                              </select>
                            </div>
                          </div>
                          </div> -->
                            <div class="row">
                                <table class="table table-striped table-bordered dt-responsive nowrap table-hover">
                                    
                            </table>
                        <div class="col-xs-6">



                        </div>



                    </div>
                </form>
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>Nomor Invoice</th>
							<th>Keterangan</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                            <th> Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <!-- modal -->
                <div id="modal" class="modal" >
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insert/Edit Nota Debet Kredit</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal  kirim">
                          <table id="table_data" class="table table-striped table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <td style="width:120px; padding-top: 0.4cm">Nomor</td>
                                    <td>
                                        <input type="text" name="ed_nomor" class="form-control" style="text-transform: uppercase" >
                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                        <input type="hidden" name="ed_nomor_old" class="form-control" >
                                        <input type="hidden" class="form-control" name="crud" class="form-control" >
                                    </td>
                                </tr>
                                <tr>
									<td style="padding-top: 0.4cm">Tanggal</td>
									<td >
										<div class="input-group date">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control col-xs-12" name="ed_tanggal" value="{{ $data->tanggal or  date('Y-m-d') }}">
										</div>
									</td>
                                </tr>
                                <tr>
									<td style="width:110px; padding-top: 0.4cm">Cabang</td>
									<td >
									<select class="chosen-select-width" name="cb_cabang" id="cb_cabang" >
											<option value=""></option>
										@foreach ($cabang as $row)
											<option value="{{ $row->kode }}"> {{ $row->nama }} </option>
										@endforeach
										</select>
									</td>
                                </tr>
								<tr>
									<td style="width:120px; padding-top: 0.4cm">Nomor Invoice</td>
									<td >
										<input type="text" class="form-control ui-autocomplete-input" id="ed_nomor_invoice" name="ed_nomor_invoice" style="text-transform:uppercase" >
									</td>
								</tr>
								<tr>
									<td style="padding-top: 0.4cm">Tagihan</td>
									<td>
										<input type="text" class="form-control angka " name="ed_tagihan" id="ed_tagihan" style="text-align:right" readonly="readonly" tabindex="-1">
									</td>
								<tr>
									<td style="padding-top: 0.4cm">Debet</td>
									<td>
										<input type="text" class="form-control angka " name="ed_debet" style="text-align:right" >
									</td>
								</tr>
								<tr>
									<td style="padding-top: 0.4cm">Kredit</td>
									<td>
										<input type="text" class="form-control angka " name="ed_kredit" style="text-align:right" >
									</td>
								</tr>
								<tr>
									<td style="padding-top: 0.4cm">Total</td>
									<td>
										<input type="text" class="form-control angka " name="ed_total" style="text-align:right" readonly="readonly" tabindex="-1">
									</td>
								</tr>    
								<tr>
									<td style="width:120px; padding-top: 0.4cm">Keterangan</td>
									<td >
										<input type="text" name="ed_keterangan" class="form-control" style="text-transform: uppercase" > 
									</td>
								</tr>
                            </tbody>
                          </table>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btnsave">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>
                  <!-- modal -->
                <div class="box-footer">
                  <div class="pull-right">


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
    $(document).ready( function () {
        $('#table_data').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
            "ajax": {
              "url" :  baseUrl + "/sales/nota_debet_kredit/tabel",
              "type": "GET"
            },
            "columns": [
            { "data": "nomor" },
            { "data": "tanggal" },
            { "data": "nomor_invoice" },
            { "data": "keterangan" },
            { "data": "debet" },
            { "data": "kredit" },
            { "data": "button" },
            ]
        });
        $("input[name='ed_harga']").maskMoney({thousands:'.', decimal:',', precision:-1});
    });

    

	$('#ed_nomor_invoice').autocomplete({
		// source: function() { return "GetState.php?country=" + $('#Country').val();},
		source: function(request, response) {
			$.ajax({
				url: baseUrl + '/sales/nota_debet_kredit_cari', 
				dataType: "json",
				data: {
					term : request.term,
					cabang : $('#cb_cabang').val()
				},
				success: function(data) {
					response(data);
				}
			});
		},
		minLength: 2,
        
        appendTo:"#modal",
		//appendTo:"#modal",
		select:function(event, ui){
			$('#ed_nomor_invoice').val(ui.item.label);
			//$('#ed_tanggal').val(ui.item.tanggal);
			//$('#ed_customer').val(ui.item.nama);
			$('#ed_tagihan').val(ui.item.total_tagihan);
			//$('#ed_pendapatan').val(ui.item.pendapatan);
		},
		
	});


    $(document).on("click","#btn_add",function(){
		var fullDate = new Date();
		var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) :(fullDate.getMonth()+1);//fullDate.getMonth().length+1
		if(twoDigitMonth.length==1)	twoDigitMonth="0" +twoDigitMonth;
		var twoDigitDate = fullDate.getDate()+"";
		if(twoDigitDate.length==1)	twoDigitDate="0" +twoDigitDate;
		var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + twoDigitDate; 
        $("input[name='crud']").val('N');
        $("input[name='ed_nomor']").val('');
        $("input[name='ed_nomor_old']").val('');
        $("input[name='ed_tanggal']").val('');
        $("input[name='ed_nomor_invoice']").val('');
		$("select[name='cb_cabang']").val('').trigger('chosen:updated');
        $("input[name='ed_tagihan']").val('0');
        $("input[name='ed_kredit']").val('0');
		$("input[name='ed_debet']").val('0');
        $("input[name='ed_total']").val('0');
        $("input[name='ed_tanggal']").val(currentDate);
        $("#modal").modal("show");
        $("input[name='ed_nomor']").focus();
    });

    $(document).on( "click",".btnedit", function() {
        var id=$(this).attr("id");
        var value = {
            id: id
        };
        $.ajax(
        {
            url : baseUrl + "/sales/nota_debet_kredit/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='crud']").val('E');
				$("input[name='ed_nomor']").val(data.nomor);
				$("input[name='ed_nomor_old']").val(data.nomor);
				$("input[name='ed_tanggal']").val(data.tanggal);
				$("input[name='ed_nomor_invoice']").val(data.nomor_invoice);
				$("select[name='cb_cabang']").val(data.kode_cabang).trigger('chosen:updated');
				$("input[name='ed_tagihan']").val('0');
				$("input[name='ed_kredit']").val(data.kredit);
				$("input[name='ed_debet']").val(data.debet);
				$("input[name='ed_total']").val('0');
				$("input[name='ed_tanggal']").val(data.tanggal);
                $("#modal").modal('show');
                $("input[name='ed_nomor']").focus();
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on("click","#btnsave",function(){
        $.ajax(
        {
            url : baseUrl + "/sales/nota_debet_kredit/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result == 1){
                        var table = $('#table_data').DataTable();
                        table.ajax.reload( null, false );
                        $("#modal").modal('hide');
                        $("#btn_add").focus();
                    }else{
                        alert("Gagal menyimpan data!");
                    }
                }else if(data.crud == 'E'){
                    if(data.result == 1){
                        //$.notify('Successfull update data');
                        var table = $('#table_data').DataTable();
                        table.ajax.reload( null, false );
                        //$("#edkode").focus();
                        $("#modal").modal('hide');
                        $("#btn_add").focus();
                    }else{
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }
                }else{
                    swal("Error","invalid order","error");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on( "click",".btndelete", function() {
        var name = $(this).attr("name");
        var id = $(this).attr("id");
        if(!confirm("Hapus Data " +name+ " ?")) return false;
        var value = {
            id: id,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "POST",
            url : baseUrl + "/sales/nota_debet_kredit/hapus_data",
            dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result ==1){
                    var table = $('#table_data').DataTable();
                    table.ajax.reload( null, false );
                }else{
                    swal("Error","Data tidak bisa hapus : "+data.error,"error");
                }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });


    });
    </script>
@endsection
