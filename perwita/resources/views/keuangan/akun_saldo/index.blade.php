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

    #table_form .right_side{
      padding-left: 10px;
    }

    .modal-open{
      overflow: inherit;
    }

    .cabang{
      color: #555;
    }
    .cabang:hover{
      color: white;
    }
    .cabangs:hover{
      background: #0099CC;
    }
  </style>
@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-10">
          <h2> Saldo Akun </h2>

          <ol class="breadcrumb">
              <li>
                  <a>Home</a>
              </li>
              <li>
                  <a>Keuangan</a>
              </li>
              <li class="active">
                  <strong> Saldo Akun  </strong>
              </li>
          </ol>
      </div>
      
      <div class="col-lg-12" style="border: 1px solid #eee; margin-top: 15px;">
        <table border="0" id="form-table" class="col-md-10">
        <tr>
          <td width="15%" class="text-center">Filter Berdasarkan : </td>
          <td width="18%">
            <select class="form-control" style="width:90%; height: 30px" id="berdasarkan">
                <option value="0">Kode Akun</option>
                <option value="1">Nama Akun</option>
                <option value="2">Jenis</option>
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
                    <h5> Data Saldo Akun Cabang {{ $cabang->nama }} Periode {{ date_ind($_GET["date"]) }} {{ $_GET["year"] }}
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        <div style="display: inline-block; background: none;">
                          <button class="btn btn-sm btn-default pilihCabang" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="fa fa-list"></i> &nbsp;Pengaturan Halaman
                              <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1" style="right: 0px;">
                            <li><a href="#" data-toggle="modal" data-target="#modal_setting_table"><i class="fa fa-table fa-fw"></i> &nbsp;Pengaturan Tampilan Table</a></li>
                          </ul>
                        </div>
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
                                  <th width="10%" class="text-center">Kode Akun</ht>
                                  <th width="25%" class="text-center">Nama Akun</th>
                                  <th width="10%" class="text-center">Jenis</th>
                                  <th width="15%" class="text-center">Saldo Debet</th>
                                  <th width="15%" class="text-center">Saldo Kredit</th>
                                  <th width="8%" class="text-center">Aksi</th>
                                </tr>
                              </thead>
                              <tbody>

                                @foreach($data as $dataAkun)
                                	<?php $debet = 0; $kredit = 0; ?>
                                  
                                  {{-- @if($dataAkun->is_active == 1) --}}
                                    <tr>
                                    	<td>{{ $dataAkun->id_akun }}</td>
                                    	<td>{{ $dataAkun->nama_akun }}</td>
                                    	<td class="text-center">{{ $dataAkun->akun_dka }}</td>

                                      <?php

                                        $deb = (count($dataAkun->mutasi_bank_debet) > 0) ? $dataAkun->mutasi_bank_debet->first()->total : 0;
                                        $kredit = (count($dataAkun->mutasi_bank_kredit) > 0) ? $dataAkun->mutasi_bank_kredit->first()->total : 0;

                                        $total = $dataAkun->coalesce + ($deb + $kredit);

                                        $totdeb = $totkred = 0;

                                        if($dataAkun->akun_dka == 'D')
                                          if($total > 0 )
                                            $totdeb = str_replace('-', '', $total);
                                          else
                                            $totkred = str_replace('-', '', $total);
                                        else
                                          if($total > 0 )
                                            $totkred = str_replace('-', '', $total);
                                          else
                                            $totdeb = str_replace('-', '', $total);

                                        if(strtotime($_GET['year'].'-'.$_GET['date'].'-01') < strtotime($dataAkun->opening_date)){
                                          $totkred = 0; $totdeb = 0;
                                        }

                                      ?>

                                    	<td class="text-right">{{  number_format($totdeb,2) }}</td>
                                    	<td class="text-right">{{ number_format($totkred,2) }}</td>
                                      <td class="text-center">
                                        <span data-toggle="tooltip" data-placement="top" title="Sesuaikan Saldo {{ $dataAkun->nama_akun }}">
                                            <button class="btn btn-xs btn-info editAkun" data-id="{{ $dataAkun->id_akun }}"><i class="fa fa-pencil fa-fw"></i></button>
                                        </span>
                                      </td>
                                    </tr>
                                  {{-- @endif --}}
                                  
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
        <h4 class="modal-title">Edit Saldo Akun</h4>
        <input type="hidden" class="parrent"/>
      </div>
      <div class="modal-body">
        
      </div>

    </div>
  </div>
</div>
  <!-- modal -->

  <!-- modal -->
<div id="modal_setting_table" class="modal">
  <div class="modal-dialog" style="width: 30%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Setting Tampilan Table</h4>
        <input type="hidden" class="parrent"/>
      </div>
      <div class="modal-body">
        <div class="row">
          <form id="table_setting_form">
          <div class="col-md-12" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px;">
            <table border="0" id="form-table" class="col-md-12">
              <tr>
                <td width="30%" class="text-center">Pilih Cabang</td>
                <td colspan="2">
                    <select name="cab" class="select_validate_null form-control" id="group_laba_rugi">
                      @foreach($cabangs as $cab)
                        <?php $select = ($cab->kode == $_GET["cab"]) ? "selected" : "" ?>
                        <option value="{{ $cab->kode }}" {{$select}}>{{ $cab->nama }}</option>
                      @endforeach
                    </select>
                </td>
              </tr>

              <tr>
                <td class="text-center">Pilih Periode</td>
                <td>
                    <input type="text" name="date" class="form-control dateMonth text-center" readonly style="cursor: pointer;" value="{{$_GET["date"]}}">
                </td>
                <td>
                    <input type="text" name="year" class="form-control year text-center" readonly style="cursor: pointer;" value="{{$_GET["year"]}}">
                </td>
              </tr>
            </table>
          </div>
          </form>

          <div class="col-md-12 m-t" style="border-top: 1px solid #eee; padding: 10px 10px 0px 0px;">
            <button class="btn btn-primary btn-sm pull-right" id="submit_setting">Submit</button>
          </div>
        </div>
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
    $('[data-toggle="tooltip"]').tooltip();

    $('.dateMonth').datepicker( {
        format: "mm",
        viewMode: "months", 
        minViewMode: "months"
    });

    $('.year').datepicker( {
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    });

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
      // alert($(this).data("id"));
      $("#modal_edit_akun").modal("show");
      $("#modal_edit_akun .modal-body").html('<center class="text-muted">Menyiapkan Form</center>');

       $.ajax(baseUrl+"/master_keuangan/saldo_akun/edit/"+$(this).data("id"), {
         timeout: 15000,
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

    $("#submit_setting").click(function(event){
      event.preventDefault();
      form = $("#table_setting_form"); $(this).attr("disabled", true); $(this).text("Mengubah Tampilan Table ...");

      window.location = baseUrl + "/master_keuangan/saldo_akun?" + form.serialize();
    })

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