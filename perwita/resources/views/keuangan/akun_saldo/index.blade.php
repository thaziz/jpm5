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
                          <i class="fa fa-plus"></i> &nbsp;Tambah Data Saldo Awal Akun
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
                        <th width="18%" rowspan="2" style="padding:8px 0px" class="text-center">Kode Akun</ht>
                        <th width="35%" rowspan="2" style="padding:8px 0px" class="text-center">Nama Akun</th>
                        <th rowspan="2" style="padding:8px 0px" class="text-center">Jenis</th>
                        <th colspan="2" style="padding:8px 0px" class="text-center">Saldo</th>
                      </tr>

                      <tr>
                        <th width="20%" style="padding:8px 0px" class="text-center">Debet</ht>
                        <th style="padding:8px 0px" class="text-center">Kredit</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach($data as $dataAkun)
                      	<?php $debet = 0; $kredit = 0; ?>
                        
                        @if($dataAkun->is_active == 1)
                          <tr>
                          	<td>{{ $dataAkun->akun->id_akun }}</td>
                          	<td>{{ $dataAkun->akun->nama_akun }}</td>

                          	@if($dataAkun->akun->akun_dka == "D")
                          		@if($dataAkun->saldo_akun < 0)
                          			<?php $tipe = "K"; $kredit = ($dataAkun->saldo_akun * -1); ?>
                          		@else
                          			<?php $tipe = "D"; $debet = $dataAkun->saldo_akun; ?>
                          		@endif
                          	@else
                          		@if($dataAkun->saldo_akun < 0)
                          			<?php $tipe = "D"; $debet = ($dataAkun->saldo_akun * -1);?>
                          		@else
                          			<?php $tipe = "K"; $kredit = $dataAkun->saldo_akun;?>
                          		@endif
                          	@endif

                          	<td class="text-center">{{ $tipe }}</td>
                          	<td class="text-right">{{ number_format($debet,2) }}</td>
                          	<td class="text-right">{{ number_format($kredit,2) }}</td>

                          </tr>
                        @endif
                        
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
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Form Tambah Data Saldo Awal Akun</h4>
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
        window.location = baseUrl+"/master_keuangan/saldo_akun";
    })

    $("#modal_tambah_akun").on("shown.bs.modal", function(e){
      //alert($("#modal_tambah_akun .modal-header .parrent").val())

      $.ajax(baseUrl+"/master_keuangan/saldo_akun/add/"+$("#modal_tambah_akun .modal-header .parrent").val(), {
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