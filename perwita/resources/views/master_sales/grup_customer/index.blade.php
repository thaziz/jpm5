@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> GROUP CUSTOMER </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Master Penjualan</a>
                        </li>
                        <li>
                          <a> Master DO</a>
                        </li>
                        <li class="active">
                            <strong> Group Customer </strong>
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
                    <h5> GRUP ITEM
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
                            <th> Group id </th>
                            <th> Group Name </th>
                            <th> Alamat </th>
                            <th> Folder </th>
                            <th> Persons </th>
                            <th> Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <!-- modal -->
                <div id="modal" class="modal" >
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insert Edit Grup Item</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal  kirim">
                          <table id="table_data" class="table table-striped table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <td style="width:120px; padding-top: 0.4cm">Group id</td>
                                    <td>
                                        <input type="text" name="ed_kode" class="form-control" style="text-transform: uppercase" >
                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                        <input type="hidden" name="ed_kode_old" class="form-control" >
                                        <input type="hidden" class="form-control" name="crud" class="form-control" >
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Group Name</td>
                                    <td><input type="text" class="form-control" name="ed_nama" style="text-transform: uppercase" ></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Alamat</td>
                                    <td><input type="text" class="form-control" name="ed_alamat" style="text-transform: uppercase" ></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Folder</td>
                                    <td><input type="text" class="form-control" name="ed_folder" style="text-transform: uppercase" ></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Persons</td>
                                    <td><input type="text" class="form-control" name="ed_person" style="text-transform: uppercase" ></td>
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
              "url" :  baseUrl + "/master_sales/group_customer/tabel",
              "type": "GET"
            },
            "columns": [
            { "data": "group_id" },
            { "data": "group_nama" },
            { "data": "group_alamat" },
            { "data": "group_folder" },
            { "data": "group_person" },
            { "data": "button" },
            ]
        });
        $("input[name='ed_harga']").maskMoney({thousands:'.', decimal:',', precision:-1});
    });

    $(document).on("click","#btn_add",function(){
        $("input[name='crud']").val('N');
        $("input[name='ed_kode']").val('');
        $("input[name='ed_kode_old']").val('');
        $("input[name='ed_nama']").val('');
        $("input[name='ed_alamat']").val('');
        $("input[name='ed_folder']").val('');
        $("input[name='ed_person']").val('');
        $("#modal").modal("show");
        $("input[name='ed_kode']").focus();
    });

    $(document).on( "click",".btnedit", function() {
        var id=$(this).attr("id");
        var value = {
            id: id
        };
        $.ajax(
        {
            url : baseUrl + "/master_sales/group_customer/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='crud']").val('E');
                $("input[name='ed_kode']").val(data.group_id);
                $("input[name='ed_kode_old']").val(data.group_id);
                $("input[name='ed_nama']").val(data.group_nama);
                $("input[name='ed_alamat']").val(data.group_alamat);
                $("input[name='ed_folder']").val(data.group_folder);
                $("input[name='ed_person']").val(data.group_person);
                $("#modal").modal('show');
                $("input[name='ed_kode']").focus();
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
            url : baseUrl + "/master_sales/group_customer/save_data",
            type: "get",
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
            type: "get",
            url : baseUrl + "/master_sales/group_customer/hapus_data",
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
