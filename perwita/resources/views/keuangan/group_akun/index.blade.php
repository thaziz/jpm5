@extends('main')

@section('title', 'dashboard')

@section("extra_styles")
  
  <link href="{{ asset('assets/vendors/bootstrap-treegrid/css/jquery.treegrid.css') }}" rel="stylesheet">

  <style>
    body{
      overflow-y: scroll;
    }

    #form-table{
      font-size: 8pt;
    }

    #form-table td{
      padding: 5px 0px;
    }

    #form-table .form-control{
      height: 30px;
      width: 90%;
      font-size: 8pt;
    }

    .error-badge{
      color:#ed5565;
      font-weight: 600;
    }

    .error-badge small{
      display: none;
    }

    .modal-open{
      overflow: inherit;
    }.chosen-select {
        background: red;
    }
  </style>
@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2> Master Group Akun </h2>
        <ol class="breadcrumb">
            <li>
                <a>Home</a>
            </li>
            <li>
                <a>Keuangan</a>
            </li>
            <li class="active">
                <strong> Master Group Akun  </strong>
            </li>

        </ol>
    </div>

    <div class="col-lg-12" style="border: 1px solid #eee; margin-top: 15px;">
      <table border="0" id="form-table" class="col-md-10">
      <tr>
        <td width="15%" class="text-center">Filter Berdasarkan : </td>
        <td width="18%">
          <select class="form-control" style="width:90%; height: 30px" id="berdasarkan">
              <option value="0">Kode Group</option>
              <option value="1">Nama Group</option>
              <option value="2">Jenis Group</option>
            </select>
        </td>

        <td width="18%">
          <select class="form-control" style="width:90%; height: 30px" id="yang">
              <option value="1">Yang Mengandung</option>
              <option value="2">Yang Berawalan</option>
            </select>
        </td>

        <td width="15%" class="text-center">Kata Kunci : </td>
        <td width="20%">
          <input class="form-control" style="width:90%; height: 30px;" data-toggle="tooltip" id="filter" placeholder="Masukkan Kata Kunci">
        </td>

        <td width="15%" class="text-left">
          <button class="btn btn-success btn-sm" id="set" style="font-size: 8pt;"> Terapkan</button>
        </td>
      </tr>

    </table>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Data Group Akun
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        <button class="btn btn-sm btn-primary tambahAkun" data-parrent="0" data-toggle="modal" data-target="#modal_tambah">
                          <i class="fa fa-plus"></i> &nbsp;Tambah Data Group Akun
                        </button>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                      <div class="col-xs-12">
                        
                        <div class="box" id="seragam_box">
                          <div class="box-header">
                          </div><!-- /.box-header -->
                          <div class="box-body" style="min-height: 330px;">

                            <table id="table" width="100%" class="table table-bordered table-striped tbl-penerimabarang no-margin" style="padding:0px; font-size: 8pt;">
                              <thead>
                                <tr>
                                  <th width="15%" class="text-center">Kode Group</th>
                                  <th width="30%" class="text-center">Nama Group</th>
                                  <th class="text-center">Jenis Group</th>
                                  <th class="text-center">Tanggal Buat</th>
                                  {{-- <th style="padding:8px 0px" class="text-center">Saldo</th> --}}
                                  <th width="20%" width="20%" class="text-center">Aksi</th>

                                </tr>
                              </thead>
                              <tbody  class="searchable">

                                @foreach($data as $group)
                                  <tr>
                                    <td class="id">{{ $group->id }}</td>
                                    <td class="nama_group">{{ $group->nama_group }}</td>
                                    <td class="jenis_group text-center">{{ $group->jenis_group }}</td>
                                    <td class="tanggal_buat text-center">{{ date("d-m-Y", strtotime($group->tanggal_buat)) }}</td>

                                    <td class="text-center">

                                        <span data-toggle="tooltip" data-placement="top" title="Edit Group {{ $group->nama_group }}">
                                            <button data-parrent="{{ $group->id }}" data-toggle="modal" data-target="#modal_edit" class="btn btn-xs btn-warning edit"><i class="fa fa-pencil-square fa-fw"></i></button>
                                        </span>

                                        <a onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Group \'{{ $group->nama_group }}\' Ini ??')" href="{{ route("group_akun.hapus", $group->id) }}">
                                          <button data-toggle="tooltip" data-placement="top" title="Hapus Group {{ $group->nama_group }}" class="btn btn-xs btn-danger"><i class="fa fa-eraser fa-fw"></i></button>
                                        </a>

                                      </td>
                                  </tr>
                                @endforeach
                                
                              </tbody>
                            </table>
                          </div><!-- /.box-body -->
                      </div><!-- /.box -->
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>

 <!-- modal -->
<div id="modal_tambah" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Form Tambah Data Master Group Akun</h4>
        <input type="hidden" class="parrent"/>
      </div>
      <div class="modal-body">
        <center class="text-muted">Menyiapkan Form</center>
      </div>

    </div>
  </div>
</div>
  <!-- modal -->

<!-- modal -->
<div id="modal_edit" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Form Edit Data Master Group Akun</h4>
        <input type="hidden" readonly class="parrent"/>
      </div>
      <div class="modal-body">
        <center class="text-muted">Menyiapkan Form</center>
      </div>

    </div>
  </div>
</div>
  <!-- modal -->

@endsection



@section('extra_scripts')

<script src="{{ asset('assets/vendors/bootstrap-treegrid/js/jquery.treegrid.js') }}"></script>
<script src="{{ asset('assets/vendors/inputmask/inputmask.jquery.js') }}"></script>
<script type="text/javascript">

  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip()

    @if(Session::has('sukses'))
        alert("{{ Session::get('sukses') }}")
    @elseif(Session::has('terpakai'))
        alert("{{ Session::get('terpakai') }}")
    @endif

    tableDetail = $('.tbl-penerimabarang').DataTable({
      responsive: true,
      searching: true,
      sorting: true,
      paging: true,
      //"pageLength": 10,
      "language": dataTableLanguage,
    });

    $(".tambahAkun").on("click", function(){
      $("#modal_tambah .modal-header .parrent").val($(this).data("parrent"));
    })

    $("#modal_tambah").on("hidden.bs.modal", function(e){
      $("#modal_tambah .modal-body").html('<center class="text-muted">Menyiapkan Form</center>');
      if($change)
        window.location = baseUrl+"/master_keuangan/akun";
    })

    $("#modal_tambah").on("shown.bs.modal", function(e){
      // alert("aa");

      $.ajax(baseUrl+"/master_keuangan/group_akun/add", {
         timeout: 15000,
         dataType: "html",
         success: function (data) {
             $("#modal_tambah .modal-body").html(data);
         },
         error: function(request, status, err) {
            if (status == "timeout") {
              $("#modal_tambah .modal-body").html('<center class="text-muted">Waktu Koneksi habis</center>');
            } else {
              $("#modal_tambah .modal-body").html('<center class="text-muted">Ups Gagal Loading</center>');
            }
        } 
      });
    })

    $(".edit").on("click", function(){
      $("#modal_edit .modal-header .parrent").val($(this).data("parrent"));
    })

    $("#modal_edit").on("hidden.bs.modal", function(e){
      $("#modal_edit .modal-body").html('<center class="text-muted">Menyiapkan Form</center>');
      if($change)
        window.location = baseUrl+"/master_keuangan/akun";
    })

    $("#modal_edit").on("shown.bs.modal", function(e){
      //alert($("#modal_edit_akun .modal-header .parrent").val())

      $.ajax(baseUrl+"/master_keuangan/group_akun/edit/"+$("#modal_edit .modal-header .parrent").val(), {
         timeout: 15000,
         dataType: "html",
         success: function (data) {
             $("#modal_edit .modal-body").html(data);
         },
         error: function(request, status, err) {
            if (status == "timeout") {
              $("#modal_edit .modal-body").html('<center class="text-muted">Waktu Koneksi habis</center>');
            } else {
              $("#modal_edit .modal-body").html('<center class="text-muted">Ups Gagal Loading</center>');
            }
        } 
      });
    })

    $("#collapsed").click(function(){
      $('#table').treegrid('collapseAll');
    })

    $("#expand").click(function(){
      $('#table').treegrid('expandAll');
    })

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    $('#set').click(function () {
        $val = $('#filter').val().toUpperCase();

        if($("#yang").val() == 1)
          tableDetail.columns($("#berdasarkan").val()).every( function () {
              var that = this;
              // console.log(that);
              that.search($val).draw();
          });
        else{
          tableDetail.columns($("#berdasarkan").val()).every( function () {
              var that = this;
              // console.log(that);
              that.search('^' + $val, true, false).draw();
          });
        }
    })

  })

</script>
@endsection