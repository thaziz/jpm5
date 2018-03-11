@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Update Faktur Pajak
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
                            <div class="x_content">
                            <form action="{{ url('sales/deliveryorderform/save_update_status') }}" class="form-horizontal" method="post" >
                                <table class="table table-striped table-bordered dt-responsive nowrap table-hover">
                                    <tbody>
                                        <tr>
                                            <td style="width:120px; padding-top: 0.4cm">Cabang</td>
                                            <td colspan="7">
												<select class="form-control" name="cb_cabang" id="cb_cabang">
												@foreach ($cabang as $row)
													<option value="{{ $row->kode }}"> {{ $row->nama }} </option>
												@endforeach
												</select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:120px; padding-top: 0.4cm">Nomor Invoice</td>
                                            <td colspan="7">
                                                <input type="text" class="form-control ui-autocomplete-input" id="ed_nomor_invoice" name="ednomor" style="text-transform:uppercase" >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Pendapatan</td>
                                            <td colspan="7">
                                                <input type="text" class="form-control" id="ed_pendapatan" name="ednomor" readonly="readonly" tabindex="-1">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Tanggal</td>
                                            <td colspan="7">
                                                <input type="text" class="form-control" id="ed_tanggal" name="ednomor" readonly="readonly" tabindex="-1">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Customer</td>
                                            <td colspan="7">
                                                <input type="text" class="form-control" id="ed_customer" name="ednomor" readonly="readonly" tabindex="-1">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="padding-top: 0.4cm">Tagihan</td>
                                            <td colspan="7">
                                                <input type="text" class="form-control" id="ed_tagihan" name="edtotaljualh" value="" style="text-align:right" readonly="readonly" tabindex="-1">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:110px;"> Nomor Faktur Pajak</td>
                                            <td colspan="7">
                                                <input type="text" class="form-control" id="ed_no_faktur_pajak" name="ednomor" value="">
                                                <input type="hidden" id="txtid_h" name="txtid_h" value="" >
                                                <input type="hidden" id="crudmethod_h" name="crudmethod_h" value="" >
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-primary " id="btnsave" ><i class="fa fa-plus"></i> Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <div class="box-body">

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#ed_nomor_invoice').focus();
		$('#ed_nomor_invoice').autocomplete({
			// source: function() { return "GetState.php?country=" + $('#Country').val();},
			  source: function(request, response) {
				$.ajax({
				  url: baseUrl + '/sales/faktur_pajak_cari', 
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
			select:function(event, ui){
				$('#ed_nomor_invoice').val(ui.item.label);
				$('#ed_tanggal').val(ui.item.tanggal);
				$('#ed_customer').val(ui.item.nama);
				$('#ed_tagihan').val(ui.item.total_tagihan);
				$('#ed_pendapatan').val(ui.item.pendapatan);
				
			}
		});

		/*
		$('#ed_nomor_invoice').autocomplete({
			minLength: 2, //minimal huruf saat autocomplete di proses
			source: baseUrl + '/sales/faktur_pajak_cari' + '&kode_cabang='+cabang,
			select:function(event, ui){
				$('#ed_nomor_invoice').val(ui.item.label);
				$('#ed_tanggal').val(ui.item.tanggal);
				$('#ed_customer').val(ui.item.nama);
				$('#ed_tagihan').val(ui.item.total_tagihan);
				$('#ed_pendapatan').val(ui.item.pendapatan);
				
			}
		});
		*/
	});
	
    $(document).on("click","#btnsave",function(){
        var ed_nomor_invoice = $("#ed_nomor_invoice").val();
        var ed_nomor_faktur_pajak = $("#ed_no_faktur_pajak").val();
        value = {
            nomor_invoice : ed_nomor_invoice, 
            no_faktur_pajak: ed_nomor_faktur_pajak,
            _token: "{{ csrf_token() }}",
        };
        $.ajax(
        {
            url : baseUrl + "/sales/faktur_pajak/save_data",
            type: "POST",
            dataType:"JSON",
            data : value,
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
                        //var table = $('#table_data').DataTable();
                        //table.ajax.reload( null, false );
                        //$("#edkode").focus();
                        //$("#modal").modal('hide');
                        //$("#btn_add").focus();
						//alert('update data berhasil');
                        swal("Data berhasil di update","","success");
						$('#ed_nomor_invoice').val('');
						$('#ed_tanggal').val('');
						$('#ed_customer').val('');
						$('#ed_tagihan').val('');
						$('#ed_pendapatan').val('');
						$('#ed_no_faktur_pajak').val('');
						$('#ed_nomor_invoice').focus();

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

    $(document).on("click","#btn_pilih_invoice",function(){
        $("#modal").modal("show");
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    function tambahdata() {
        window.location.href = baseUrl + '/data-master/master-akun/create'
    }
    function hapusData(id) {

        $.ajax({
            url: baseUrl + '/data-master/master-akun/delete/' + id,
            type: 'get',
            dataType: 'text',
            //headers: {'X-XSRF-TOKEN': $_token},
            success: function (response) {
                if (response == 'sukses') {
                    $('.alertBody').html('<div class="alert alert-success">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                            'Data Berhasil Di Hapus' +
                            '</div>');
                    $('.alertBody').show();
                    $('.alertBody').delay(4000).slideUp(300);
                    $("#hapus" + id).remove();
                } else if (response == 'gagal') {
                    $('.alertBody').html('<div class="alert alert-danger">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                            'Data Akun Sudah Digunakan' +
                            '</div>');
                    $('.alertBody').show();
                    $('.alertBody').delay(4000).slideUp(300);
                }

            }
        });
    }

</script>
@endsection
