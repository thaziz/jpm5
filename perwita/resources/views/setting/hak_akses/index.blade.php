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
                                                <button type="button" class="btn btn-primary " id="btnaddlevel" >Add Level</button>
                                                <button type="button" class="btn btn-primary " id="btneditlevel" >Edit Level</button>
                                                <button type="button" class="btn btn-primary " id="btnhapuslevel" >Hapus Level</button>
                                            </div>
                                        </div>
                                    </form>
                                    <table id="table_data" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="display:none;">Kode</th>
                                                <th>Menu</th>
                                                <th>Aktif</th>
                                                <th>Tambah</th>
                                                <th>Ubah</th>
                                                <th>Hapus</th>
                                                <th>Function 1</th>
                                                <th>Function 2</th>
                                                <th>Function 3</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
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
    $(document).ready(function () {
        $('#table_data').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": false,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "ajax": {
                "url": baseUrl + "/setting/hak_akses/tabel",
                "type": "GET",
                "data": {level: function () {
                        return $('#cblevel').val()
                    }},
            },
            "columns": [
                {"data": "kode", render: $.fn.dataTable.render.number('.'), "sClass": "Kode"},
                {"data": "menu"},
                {"data": "aktif"},
                {"data": "tambah"},
                {"data": "ubah"},
                {"data": "hapus"},
                {"data": "function1"},
                {"data": "function2"},
                {"data": "function3"},
            ]
        });
    });

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

    $(document).on("click", ".btnaktif", function () {
        var id = $(this).attr("id");
        var keterangan = 'aktif';
        var nilai = 20;
        var token = $('#_token').val();
        if ($(this).prop('checked')) {
            nilai = true
        } else {
            nilai = false
        }
        var value = {
            id: id,
            keterangan: keterangan,
            nilai: nilai,
            _token: token,
        };
        $.ajax(
                {
                    url: baseUrl + "/setting/hak_akses/edit_hak_akses",
                    type: "POST",
                    data: value,
                    success: function (data)
                    {
                        if (data == 'error') {
                            alert(data);
                        }
                    }
                });
    });

    $(document).on("click", ".btntambah", function () {
        var id = $(this).attr("id");
        var keterangan = 'tambah';
        var nilai = 20;
        var token = $('#_token').val();
        if ($(this).prop('checked')) {
            nilai = true
        } else {
            nilai = false
        }
        var value = {
            id: id,
            keterangan: keterangan,
            nilai: nilai,
            _token: token,
        };
        $.ajax(
                {
                    url: baseUrl + "/setting/hak_akses/edit_hak_akses",
                    type: "POST",
                    data: value,
                    success: function (data)
                    {
                        if (data == 'error') {
                            alert(data);
                        }
                    }
                });
    });

    $(document).on("click", ".btnubah", function () {
        var id = $(this).attr("id");
        var keterangan = 'ubah';
        var nilai = 20;
        var token = $('#_token').val();
        if ($(this).prop('checked')) {
            nilai = true
        } else {
            nilai = false
        }
        var value = {
            id: id,
            keterangan: keterangan,
            nilai: nilai,
            _token: token,
        };
        $.ajax(
                {
                    url: baseUrl + "/setting/hak_akses/edit_hak_akses",
                    type: "POST",
                    data: value,
                    success: function (data)
                    {
                        if (data == 'error') {
                            alert(data);
                        }
                    }
                });
    });

    $(document).on("click", ".btnhapus", function () {
        var id = $(this).attr("id");
        var keterangan = 'hapus';
        var nilai = 20;
        var token = $('#_token').val();
        if ($(this).prop('checked')) {
            nilai = true
        } else {
            nilai = false
        }
        var value = {
            id: id,
            keterangan: keterangan,
            nilai: nilai,
            _token: token,
        };
        $.ajax(
                {
                    url: baseUrl + "/setting/hak_akses/edit_hak_akses",
                    type: "POST",
                    data: value,
                    success: function (data)
                    {
                        if (data == 'error') {
                            alert(data);
                        }
                    }
                });
    });

    $(document).on("click", ".btnfunction1", function () {
        var id = $(this).attr("id");
        var keterangan = 'function1';
        var nilai = 20;
        var token = $('#_token').val();
        if ($(this).prop('checked')) {
            nilai = true
        } else {
            nilai = false
        }
        var value = {
            id: id,
            keterangan: keterangan,
            nilai: nilai,
            _token: token,
        };
        $.ajax(
                {
                    url: baseUrl + "/setting/hak_akses/edit_hak_akses",
                    type: "POST",
                    data: value,
                    success: function (data)
                    {
                        if (data == 'error') {
                            alert(data);
                        }
                    }
                });
    });

    $(document).on("click", ".btnfunction2", function () {
        var id = $(this).attr("id");
        var keterangan = 'function2';
        var nilai = 20;
        var token = $('#_token').val();
        if ($(this).prop('checked')) {
            nilai = true
        } else {
            nilai = false
        }
        var value = {
            id: id,
            keterangan: keterangan,
            nilai: nilai,
            _token: token,
        };
        $.ajax(
                {
                    url: baseUrl + "/setting/hak_akses/edit_hak_akses",
                    type: "POST",
                    data: value,
                    success: function (data)
                    {
                        if (data == 'error') {
                            alert(data);
                        }
                    }
                });
    });

    $(document).on("click", ".btnfunction3", function () {
        var id = $(this).attr("id");
        var keterangan = 'function3';
        var nilai = 20;
        var token = $('#_token').val();
        if ($(this).prop('checked')) {
            nilai = true
        } else {
            nilai = false
        }
        var value = {
            id: id,
            keterangan: keterangan,
            nilai: nilai,
            _token: token,
        };
        $.ajax(
                {
                    url: baseUrl + "/setting/hak_akses/edit_hak_akses",
                    type: "POST",
                    data: value,
                    success: function (data)
                    {
                        if (data == 'error') {
                            alert(data);
                        }
                    }
                });
    });



</script>
@endsection
