@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> PENGGUNA
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
                            <th> Nama </th>
                            <th> Level </th>
                            <th> Cabang </th>
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
                                    <td style="width:120px; padding-top: 0.4cm">Kode</td>
                                    <td>
                                        <input type="text" name="ed_nama" class="form-control kode" >
                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                        <input type="hidden" name="ed_nama_old" class="form-control" >
                                        <input type="hidden" class="form-control" name="crud" class="form-control" >
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Kata Sandi</td>
                                    <td><input type="password" class="form-control pass" name="ed_kata_sandi" ></td>
                                </tr>
                                <tr>
                                    <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                    <td>
                                        <select class="form-control cabang" name="cb_cabang" >
                                        <option value="">--Pilih Cabang--</option>
                                        @foreach ($cabang as $row)
                                            <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Level</td>
                                    <td>
                                        <select class="form-control level" name="cb_level" id="jenis_kiriman" >
                                            <option value="">--Pilih Level--</option>
                                        @foreach ($level as $row)
                                            <option value="{{ $row->level }}"> {{ $row->level }} </option>
                                        @endforeach
                                        </select>
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
              "url" :  baseUrl + "/setting/pengguna/tabel",
              "type": "GET"
            },
            "columns": [
            { "data": "m_username" },
            { "data": "m_level" },
            { "data": "cabang" },
            { "data": "button" },
            ]
        });
    });

    $(document).on("click","#btn_add",function(){
        $("input[name='crud']").val('N');
        $("input[name='ed_nama']").val('');
        $("input[name='ed_nama_old']").val('');
        $("input[name='ed_kata_sandi']").val('');
        $("select[name='cb_level']").val('');
        $("select[name='cb_cabang']").val('');
        $("#modal").modal("show");
        $("input[name='ed_nama']").focus();
    });

    $(document).on( "click",".btnedit", function() {
        var id=$(this).attr("id");
        var value = {
            id: id
        };
        $.ajax(
        {
            url : baseUrl + "/setting/pengguna/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='crud']").val('E');
                $("input[name='ed_nama']").val(data.m_username);
                $("input[name='ed_nama_old']").val(data.m_username);
                $("select[name='cb_level']").val(data.m_level);
                $("select[name='cb_cabang']").val(data.kode_cabang);
                $("#modal").modal('show');
                $("input[name='ed_nama']").focus();
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on("click","#btnsave",function(){
        /*
        var kode_old = $("#ed_kode_old").val();
        var kode = $("#ed_kode").val();
        var kota = $("#ed_kota").val();
        var provinsi = $("#cb_kota_asal").val();
        var crud   = $("#crud").val();
        if(id == '' || id == null ){
            alert('Id harus di isi');
            $("#ed_kode").focus();
            return false;
        }
        if(provinsi == '' || provinsi == null ){
            alert('provinsi harus di isi');
            $("#cb_kota_asal").focus();
            return false;
        }
        /*
        value = {
            id_old: id_old,
            id: id,
            provinsi: provinsi,
            kota: kota.toUpperCase(),
            crud: crud,
            _token: "{{ csrf_token() }}",
        };
        */
        var a = $('.kode').val();
        var b = $('.pass').val();
        var c = $('.cabang').val();
        var d = $('.level').val();
        
        if (a == ''){
            alert ('Kode Harus di isi');
            return false;
        }
        else if (b == '') {
            alert ('Password Harus di isi');
            return false;
        }
        else if (c == '') {
            alert ('Cabang Harus di pilih');
            return false;
        }
        else if (d == '') {
            alert ('Level Harus di pilih');
            return false;
        }

        $.ajax(
        {
            url : baseUrl + "/setting/pengguna/save_data",
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
            url : baseUrl + "/setting/pengguna/hapus_data",
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
                swal("Data Kode Tidak Boleh Sama!", 'Selihakan Cek Kode Sekali lagi', "warning");
            }
        });


    });
    

</script>
@endsection
