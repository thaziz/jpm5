@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> PROVINSI </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Master Bersama</a>
                        </li>
                        <li class="active">
                            <strong> PROVINSI </strong>
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
                    <h5> PROVINSI
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
                                <th style="width:70px"> Id</th>
                                <th> Nama </th>
                                <th style="width:70px"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <!-- modal -->
                <div id="modal" class="modal" >
                  <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="demo"></h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal kirim">
                                <table class="table table-striped table-bordered table-hover ">
                                    <tbody>
                                        <tr>
                                            <td style="width:120px; padding-top: 0.4cm">Id</td>
                                            <td>
                                                <input type="number" name="id" class="form-control" id="ed_id" >
                                                <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }} " id="ed_token" >
                                                <input type="hidden" name="ed_id_old" class="form-control" id="ed_id_old" >
                                                <input type="hidden" name="crud" class="form-control" id="crud" >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Provinsi</td>
                                            <td><input type="text" class="form-control" id="ed_provinsi" style="text-transform:uppercase"></td>
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
              "url" :  baseUrl + "/sales/provinsi/tabel",
              "type": "GET"
            },
            "columns": [
            { "data": "id" },
            { "data": "nama" },
            { "data": "button" },
            ]
        });
    });

    $(document).on("click","#btn_add",function(){
           document.getElementById("demo").innerHTML = "Insert Provinsi";
        $("#modal").modal("show");
        $("#ed_id").focus();
        $("#ed_id").val("");
        $("#ed_provinsi").val("");
        $("#crud").val("N");
    });

    $(document).on( "click",".btnedit", function() {
           document.getElementById("demo").innerHTML = "Edit Provinsi";
        $("#ed_id").focus();
        var id=$(this).attr("id");
        var value = {
            id: id
        };
        $.ajax(
        {
            url : baseUrl + "/sales/provinsi/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                //var data = jQuery.parseJSON(data);
                $("#crud").val("E");
                $("#ed_id_old").val(data.id);
                $("#ed_id").val(data.id);
                $("#ed_provinsi").val(data.nama);
                $("#modal").modal('show');
                $("#ed_id").focus();
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", 'ss', "error");
            }
        });
    });

    $(document).on("click","#btnsave",function(e){
        var _token = $("#ed_token").val();
        var id_old = $("#ed_id_old").val();
        var id = $("#ed_id").val();
        var provinsi = $("#ed_provinsi").val();
        var crud   = $("#crud").val();
        if(id == '' || id == null ){
            Command: toastr["warning"]('Kolom "ID Provinsi" tidak boleh kosong ', "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": true,
              "progressBar": false,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "3000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }
        if(provinsi == '' || provinsi == null ){
            Command: toastr["warning"]('Kolom "Provinsi" tidak boleh kosong ', "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": true,
              "progressBar": false,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "3000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }
        value = {
            id_old: id_old,
            id: id,
            provinsi: provinsi.toUpperCase(),
            crud: crud,
            _token: "{{ csrf_token() }}",
        };
        $.ajax(
        {
            url : baseUrl + "/sales/provinsi/save_data",
            type: "POST",
            dataType:"JSON",
            data : value,//$('.kirim').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result == 1){
                        var table = $('#table_data').DataTable();
                        table.ajax.reload( null, false );
                        $("#modal").modal('hide');
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
                    }else{
                        swal("Error","Can't update customer data, error : "+data.error,"error");
                    }
                }else{
                    swal("Error","invalid order","error");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Data ID Tidak Boleh Sama!", "Mohon dicek lagi :)", "warning");
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
            url : baseUrl + "/sales/provinsi/hapus_data",
            //dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                var data = jQuery.parseJSON(data);
                if(data.result ==1){
                    var table = $('#table_data').DataTable();
                    table.ajax.reload( null, false );
                }else{
                    swal("Error","Data tidak bisa hapus : "+data.error,"error");
                }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", 'textStatus', "error");
            }
        });


    });


</script>
@endsection
