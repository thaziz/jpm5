@extends('main')

@section('title', 'dashboard')

@section("extra_styles")
  
  <link href="{{ asset('assets/vendors/bootstrap-treegrid/css/jquery.treegrid.css') }}" rel="stylesheet">

  <style>
    body{
      overflow-y: scroll;
    }

    #table{
      width: 100%;
    }

    #table td{
      padding: 8px 20px;
    }

    #table_form{
      border:0px solid black;
      width: 100%;
    }

    #table_form input{
      padding-left: 5px;
    }

    #table_form td{
      padding: 10px 0px 0px 0px;
      vertical-align: top;
    }

    .error-badge{
      color:#ed5565;
      font-weight: 600;
    }

    .error-badge small{
      display: none;
    }

    #table_form .right_side{
      padding-left: 10px;
    }

    .modal-open{
      overflow: inherit;
    }
  </style>
@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-10">
          <h2> Master Akun </h2>
          <ol class="breadcrumb">
              <li>
                  <a>Home</a>
              </li>
              <li>
                  <a>Operasional</a>
              </li>
              <li>
                  <a>Keuangan</a>
              </li>
              <li class="active">
                  <strong> Saldo Awal Akun  </strong>
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
                    <h5> Data Saldo Awal Akun
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        {{-- <button class="btn btn-sm btn-success" id="collapsed" data-toggle="tooltip" data-placement="top" title="Sembunyikan Semua Sub Akun">
                          <i class="fa fa-archive fa-fw"></i>
                        </button>
                        
                        <button class="btn btn-sm btn-success" id="expand" data-toggle="tooltip" data-placement="top" title="Tampilkan Semua Sub Akun">
                          <i class="fa fa-code-fork fa-fw"></i>
                        </button> --}}

                        <button class="btn btn-sm btn-primary tambahAkun" data-parrent="10" data-toggle="modal" data-target="#modal_tambah_akun">
                          <i class="fa fa-plus"></i> &nbsp;Tambah Data Jurnal
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
                
                  <table id="table" width="100%" class="table-bordered table-striped tbl-penerimabarang no-margin" style="padding:0px;">
                    <thead>
                      <tr>
                        <th width="15%" style="padding:8px 0px" class="text-center">Tahun Jurnal</ht>
                        <th width="15%" style="padding:8px 0px" class="text-center">Tanggal</th>
                        <th style="padding:8px 0px" class="text-center">Jurnal Detail</th>
                        <th style="padding:8px 0px" class="text-center">Jurnal Referensi</th>
                        <th width="20%" style="padding:8px 0px" class="text-center">Jurnal Note</th>
                        <th width="20%" style="padding:8px 0px" class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach($data as $dataJurnal)
                      	<?php $debet = 0; $kredit = 0; ?>

                        <tr>
                        	<td class="text-center">{{ $dataJurnal->jr_year }}</td>
                        	<td class="text-center">{{ $dataJurnal->jr_date }}</td>
                        	<td class="text-center">{{ $dataJurnal->jr_detail }}</td>
                        	<td class="text-center">{{ $dataJurnal->jr_ref }}</td>
                        	<td class="text-center">{{ $dataJurnal->jr_note }}</td>
                          <td class="text-center">
                            <span data-toggle="tooltip" data-placement="top" title="Tampilkan Detail">
                              <button class="btn btn-success btn-xs" class="detail" data-toggle="modal" data-target="#modal-detail" onclick="$('#id_jrdt').val({{ $dataJurnal->jr_id }})"><i class="fa fa-search-plus"></i></button>
                            </span>
                          </td>
                        </tr>
                        
                      @endforeach
                      
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

 <!-- modal -->
  <div id="modal_tambah_akun" class="modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Form Tambah Data Jurnal Transaksi</h4>
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
  <div id="modal-detail" class="modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Detail Jurnal</h4>
          <input type="hidden" id="id_jrdt">
        </div>
        <div class="modal-body">
          <center class="text-muted">Menyiapkan Detail</center>
        </div>

      </div>
    </div>
  </div>
  <!-- modal -->

<!-- modal -->
<div id="modal_edit_akun" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Form Edit Data Akun</h4>
        <input type="hidden" class="parrent"/>
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
      $("#modal_tambah_akun .modal-header .parrent").val($(this).data("parrent"));
    })

    $("#modal_tambah_akun").on("hidden.bs.modal", function(e){
      $("#modal_tambah_akun .modal-body").html('<center class="text-muted">Menyiapkan Form</center>');
      if($change)
        window.location = baseUrl+"/keuangan/jurnal_umum";
    })

    $("#modal-detail").on("shown.bs.modal", function(e){
      //alert($("#modal-detail .modal-header #id_jrdt").val())
      $("#modal-detail .modal-body").html('<center class="text-muted">Menyiapkan Detail</center>');

      $.ajax(baseUrl+"/keuangan/jurnal_umum/show-detail/"+$("#modal-detail .modal-header #id_jrdt").val(), {
         timeout: 5000,
         dataType: "html",
         success: function (data) {
             $("#modal-detail .modal-body").html(data);
         },
         error: function(request, status, err) {
            if (status == "timeout") {
              $("#modal-detail .modal-body").html('<center class="text-muted">Waktu Koneksi habis</center>');
            } else {
              $("#modal-detail .modal-body").html('<center class="text-muted">Ups Gagal Loading</center>');
            }
        } 
      });
    })

    $("#modal_tambah_akun").on("shown.bs.modal", function(e){
      //alert($("#modal_tambah_akun .modal-header .parrent").val())

      $.ajax(baseUrl+"/keuangan/jurnal_umum/add", {
         timeout: 5000,
         dataType: "html",
         success: function (data) {
             $("#modal_tambah_akun .modal-body").html(data);
         },
         error: function(request, status, err) {
            if (status == "timeout") {
              $("#modal_tambah_akun .modal-body").html('<center class="text-muted">Waktu Koneksi habis</center>');
            } else {
              $("#modal_tambah_akun .modal-body").html('<center class="text-muted">Ups Gagal Loading</center>');
            }
        } 
      });
    })

    $(".editAkun").on("click", function(){
      $("#modal_edit_akun .modal-header .parrent").val($(this).data("parrent"));
    })

    $("#modal_edit_akun").on("hidden.bs.modal", function(e){
      $("#modal_edit_akun .modal-body").html('<center class="text-muted">Menyiapkan Form</center>');
      if($change)
        window.location = baseUrl+"/master_keuangan/akun";
    })

    $("#modal_edit_akun").on("shown.bs.modal", function(e){
      //alert($("#modal_edit_akun .modal-header .parrent").val())

      $.ajax(baseUrl+"/master_keuangan/edit/"+$("#modal_edit_akun .modal-header .parrent").val(), {
         timeout: 5000,
         dataType: "html",
         success: function (data) {
             $("#modal_edit_akun .modal-body").html(data);
         },
         error: function(request, status, err) {
            if (status == "timeout") {
              $("#modal_edit_akun .modal-body").html('<center class="text-muted">Waktu Koneksi habis</center>');
            } else {
              $("#modal_edit_akun .modal-body").html('<center class="text-muted">Ups Gagal Loading</center>');
            }
        } 
      });
    })

    $("#table").treegrid({
          treeColumn: 0,
          initialState: "expanded"
    });

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
  })

</script>
@endsection