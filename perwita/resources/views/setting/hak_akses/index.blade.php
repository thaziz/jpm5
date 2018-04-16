@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .Kode {display:none; }
</style>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> HAK AKSES
                        <!-- {{Session::get('comp_year')}} -->
                    </h5>

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
                                    <form class="form-horizontal" method="post" >
                                        <table class="table table-striped table-bordered table-hover">
                                            <tbody>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Level</td>
                                                    <td>
                                                        <input type="hidden" class="form-control" name="_token" id="_token" value="{{ csrf_token() }}" readonly="" >
                                                        <select class="form-control" id="cblevel" name="cb_level">
                                                            @foreach ($level as $row)
                                                            <option value="{{ $row->level }}"> {{ $row->level }} </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <button type="button" class="btn btn-primary " id="cari" >Cari</button>
                                                <button type="button" class="btn btn-primary " id="btnaddlevel" >Add Level</button>
                                                <button type="button" class="btn btn-primary " id="btneditlevel" >Edit Level</button>
                                                <button type="button" class="btn btn-primary " id="btnhapuslevel" >Hapus Level</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="table_data">
                                        
                                    </div>
                                    
                                </div><!-- /.box-body -->

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
    var filter  = $('.filter').val();
    
    $('#cari').click(function(){
        var cblevel = $('#cblevel').val();
        var filter  = $('.filter').val();

        $.ajax({
                url: baseUrl + "/setting/hak_akses/cari_data",
                type: "get",
                data: {filter,cblevel},
                success: function(data)
                {
                    $('.table_data').html(data);
                }
        });
    })

    $("#cblevel").change(function () {
        var table = $('#table_data').DataTable();
        table.ajax.reload(null, false);
    });

    $(document).on("click", "#btnaddlevel", function () {
        window.location = baseUrl + "/setting/hak_akses/add_level";
    });
    $(document).on("click", "#btneditlevel", function () {
        var level = $("select[name='cb_level']").val();
        window.location = baseUrl + "/setting/hak_akses/" + level + "/edit_level";
    });

    $(document).on("click", "#btnhapuslevel", function () {
        var level = $("select[name='cb_level']").val();
        if (level == "ADMINISTRATOR") {
            alert('Level administrator tidak boleh di hapus ');
            return false;
        }
        var token = $('#_token').val();
        var value = {
            level: level,
            _token: token,
        };
        $.ajax(
                {
                    url: baseUrl + "/setting/hak_akses/hapus_data",
                    type: "POST",
                    data: value,
                    success: function(data, textStatus, jqXHR)
                    {
                        if(data.result ==1){
                            window.location = baseUrl + "/setting/hak_akses";
                        }else{
                            window.location = baseUrl + "/setting/hak_akses";
                        }

                    }
                });
    });

   

   function tes() {
       var parent_check = $('.aktif_all:checkbox:checked');
      console.log(parent_check);
      if (parent_check.length >0) {
        $('.aktif:checkbox').prop('checked',true);
      }else if(parent_check.length==0) {
        $('.aktif:checkbox').removeAttr('checked');
      }
   }

   function tes1() {
       var parent_check = $('.tambah_all:checkbox:checked');
      console.log(parent_check);
      if (parent_check.length >0) {
        $('.tambah:checkbox').prop('checked',true);
      }else if(parent_check.length==0) {
        $('.tambah:checkbox').removeAttr('checked');
      }
   }

   function tes2() {
       var parent_check = $('.ubah_all:checkbox:checked');
      console.log(parent_check);
      if (parent_check.length >0) {
        $('.ubah:checkbox').prop('checked',true);
      }else if(parent_check.length==0) {
        $('.ubah:checkbox').removeAttr('checked');
      }
   }

   function tes3() {
       var parent_check = $('.hapus_all:checkbox:checked');
      console.log(parent_check);
      if (parent_check.length >0) {
        $('.hapus:checkbox').prop('checked',true);
      }else if(parent_check.length==0) {
        $('.hapus:checkbox').removeAttr('checked');
      }
   }

   function tes4() {
       var parent_check = $('.cabang_all:checkbox:checked');
      console.log(parent_check);
      if (parent_check.length >0) {
        $('.cabang:checkbox').prop('checked',true);
      }else if(parent_check.length==0) {
        $('.cabang:checkbox').removeAttr('checked');
      }
   }

   function tes5() {
       var parent_check = $('.print_all:checkbox:checked');
      console.log(parent_check);
      if (parent_check.length >0) {
        $('.print:checkbox').prop('checked',true);
      }else if(parent_check.length==0) {
        $('.print:checkbox').removeAttr('checked');
      }
   }

   function tes6() {
       var parent_check = $('.global_all:checkbox:checked');
      console.log(parent_check);
      if (parent_check.length >0) {
        $('.global:checkbox').prop('checked',true);
      }else if(parent_check.length==0) {
        $('.global:checkbox').removeAttr('checked');
      }
   }

</script>
@endsection
