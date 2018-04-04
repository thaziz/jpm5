@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> BIAYA </h2>
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
                            <strong> Biaya </strong>
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
                    <h5>
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <div class="text-right">
                       <button  type="button" class="btn btn-success " id="btn_add" name="btnok"><i class="glyphicon glyphicon-plus"></i>Tambah Data</button>
                            <a href="{{ url('/master_sales/biaya') }}" class="btn btn-warning"><i class="glyphicon glyphicon-print"></i>LAPORAN</a>
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
                                    <tbody>

                                </tbody>
                            </table>
                        <div class="col-xs-6">



                        </div>



                    </div>
                </form>
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th> Kode</th>
                            <th> Nama </th>
                            <th> D/K </th>
                            <th> Account </th>
                            <th> Cash FLow </th>
                            <th width="50"> Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $e)
                       <tr>
                           <td>{{ $e->b_kode }}</td>
                           <td>{{ $e->b_nama }}</td>
                           <td>{{ $e->b_debet_kredit }}</td>
                           <td>{{ $e->b_acc_hutang }}</td>
                           <td>{{ $e->b_csf_hutang }}</td>
                           <td>
                            <div class="btn-group">
                                    <button type="button" id="{{ $e->b_kode }}" data- data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>                       
                                    <button type="button" id="{{ $e->b_kode }}" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                            </div>
                           </td>
                       </tr>
                       @endforeach
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <!-- modal -->
                <div id="modal" class="modal" >
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insert Edit Biaya</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal kirim" id="kirim">
                          <table class="table table-striped table-bordered table-hover">
                                <tr>
                                    <td style="width:120px; padding-top: 0.4cm">Kode</td>
                                    <td><input type="text" class="form-control" name="ed_kode" id="edkode" ></td>
                                    
                                </tr>
                                <input type="hidden" class="form-control" name="ed_kode_old" id="edkode_old" >
                                <input type="hidden" class="form-control" name="crud" id="crud" >
                                <tr>
                                    <td style="padding-top: 0.4cm">Nama</td>
                                    <td><input type="text" class="form-control" name="ed_nama" id="ed_nama"></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Debet/Kredit</td>
                                    <td>
                                        <select class=" form-control" name="ed_dk" id=ed_dk"  style="width: 100% !important;">
                                            <option selected="">- Pilih -</option>
                                            <option value="D">D</option>
                                            <option value="K">K</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Kode Accounting</td>
                                    <td><input type="text" class="form-control" name="ed_acc" id="ed_acc"></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Kode Cash Flow</td>
                                    <td><input type="text" class="form-control" name="ed_csf" id="ed_csf" ></td>
                                </tr>
                                <tr>
                                    <td style="width:120px; padding-top: 0.4cm">Default</td>
                                    <td>
                                        <input type="checkbox" name="checkbox1" id="checkbox1">
                                    </td>
                                </tr>
                        
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
    $('#table_data').DataTable();
} );
    $(document).on("click","#btn_add",function(){
        $("#modal").modal("show");
        $('#crud').val('N');
        $('#edkode').val('');
        $('#ed_nama').val('');
        $('#ed_acc').val('');
        $('#ed_csf').val('');
        $('select[name="ed_dk"]').val('');
        $("input[name='checkbox1']").val('');
    });
    $(document).on("click",".btnedit", function() {
        $("#modal").modal("show");
        $('#btnsave').attr('id','btnupdate');
        var id=$(this).attr("id");
        var value = {
            id: id
        };
        var crud_edit = 'E';
        $('#crud').val('E');
        $.ajax(
        {
            url : baseUrl + "/master_sales/biaya/edit_data",
            type: "get",
            dataType:"JSON",
            data :value,
            success: function(data, textStatus, jqXHR)
            {
                console.log(data);
              
                    
                    $('#edkode_old').val(data.b_kode);
                    $('#edkode').val(data.b_kode);
                    $('#ed_nama').val(data.b_nama);
                    $('#ed_acc').val(data.b_acc_hutang);
                    $('#ed_csf').val(data.b_csf_hutang);
                    $('select[name="ed_dk"]').val(data.b_debet_kredit);

                    if(data.b_default == true || data.b_default == 'TRUE'){
                    $("input[name='checkbox1']").prop('checked', true);  
                    }else if (data.b_default == false || data.b_default == 'TRUE') {
                    $("input[name='checkbox1']").val('');
                    }                   
                
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
            url : baseUrl + "/master_sales/biaya/save_data",
            type: "get",
            dataType:"JSON",
            data : $('.kirim').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                console.log(data);
                if(data.crud == 'N'){
                    if(data.result == 1){
                        $("#modal").modal('hide');
                        $("#btn_add").focus();
                        location.reload();
                    }else{
                        alert("Gagal menyimpan data!");
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

    $(document).on("click","#btnupdate",function(){
        
        $.ajax(
        {
            url : baseUrl + "/master_sales/biaya/update_data",
            type: "get",
            dataType:"JSON",
            data : $('.kirim').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                console.log(data);
                if(data.crud == 'E'){
                    if(data.result == 1){                        
                        $("#modal").modal('hide');
                        $("#btn_add").focus();
                        location.reload();
                    }else{
                        alert("Gagal menyimpan data!");
                }


            }else{
                    alert('err');
                }          
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on( "click",".btndelete", function() {
        if(!confirm("Hapus Data ?")) return false;
    });
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
