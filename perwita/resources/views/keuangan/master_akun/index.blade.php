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
        <h2> Master Akun </h2>
        <ol class="breadcrumb">
            <li>
                <a>Home</a>
            </li>
            <li>
                <a>Keuangan</a>
            </li>
            <li class="active">
                <strong> Master Akun  </strong>
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
              <option value="2">Posisi Debet/Kredit</option>
              <option value="4">Shared Akun</option>
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
                    <h5> Data Akun Cabang {{ $cabang->nama }}
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                      <div style="display: inline-block; background: none;">
                        <button class="btn btn-sm btn-default pilihCabang" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                          <i class="fa fa-list"></i> &nbsp;Pengaturan Halaman
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1" style="right: 150px;">
                          <li><a href="#" data-toggle="modal" data-target="#modal_setting_table"><i class="fa fa-table fa-fw"></i> &nbsp;Pengaturan Tampilan Table</a></li>
                        </ul>
                      </div>

                        <button class="btn btn-sm btn-primary tambahAkun" data-parrent="0" data-toggle="modal" data-target="#modal_tambah_akun">
                          <i class="fa fa-plus"></i> &nbsp;Tambah Data Akun
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
                                  <th width="15%" class="text-center">Kode Akun</th>
                                  <th width="30%" class="text-center">Nama Akun</th>
                                  <th class="text-center">Cabang</th>
                                  <th class="text-center">Posisi Debet/Kredit</th>
                                  <th class="text-center">Shared Akun</th>
                                  {{-- <th style="padding:8px 0px" class="text-center">Saldo</th> --}}
                                  <th width="20%" width="20%" class="text-center">Aksi</th>
                                </tr>
                              </thead>
                              <tbody  class="searchable">

                                @foreach($data as $dataAkun)

                                  <tr class="treegrid-{{ $dataAkun->id_akun }} expanded">
                                      <td class="id_akun">{{ $dataAkun->id_akun }}</td>
                                      <td class="nama_akun">{{ $dataAkun->nama_akun }}</td>
                                      <td class="nama_cabang text-center">{{ $dataAkun->nama_cabang }}</td>
                                      <td class="text-center dka">{{ ($dataAkun->akun_dka == "D") ? "DEBET" : "KREDIT" }}</td>
                                       <td class="text-center dka">{{ ($dataAkun->shareable == "1") ? "Ya" : "Tidak" }}</td>
                                      {{-- <td></td> --}}
                                      <td class="text-center">

                                        {{-- <span data-toggle="tooltip" data-placement="top" title="Saldo Awal Bulan Ini {{ number_format($dataAkun->saldo,2) }}">
                                            <button class="btn btn-xs btn-info editAkun"><i class="fa fa-money fa-fw"></i></button>
                                        </span> --}}

                                        <span data-toggle="tooltip" data-placement="top" title="Edit Akun {{ $dataAkun->nama_akun }}">
                                            <button data-parrent="{{ $dataAkun->id_akun }}" data-toggle="modal" data-target="#modal_edit_akun" class="btn btn-xs btn-warning editAkun"><i class="fa fa-pencil-square fa-fw"></i></button>
                                        </span>

                                        <a onclick="return confirm('Apakah Anda Yakin, Semua Data Sub Akun Yang Terkait Dengan Akun Ini Juga Akan Dihapus ??')" href="{{ route("akun.hapus", $dataAkun->id_akun).'?cab='.$_GET['cab'] }}">
                                          <button data-toggle="tooltip" data-placement="top" title="Hapus Akun {{ $dataAkun->nama_akun }}" class="btn btn-xs btn-danger"><i class="fa fa-eraser fa-fw"></i></button>
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
<div id="modal_tambah_akun" class="modal">
  <div class="modal-dialog" style="width: 55%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Form Tambah Data Akun</h4>
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
  <div class="modal-dialog" style="width: 55%">
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
                <td width="15%" class="text-center">Pilih Cabang</td>
                <td width="40%" colspan="2">
                    <select name="cab" class="select_validate_null form-control" id="group_laba_rugi">
                      @foreach($cabangs as $cab)
                        <?php $select = ($cab->kode == $_GET["cab"]) ? "selected" : "" ?>
                        <option value="{{ $cab->kode }}" {{$select}}>{{ $cab->nama }}</option>
                      @endforeach
                    </select>
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
      $("#modal_tambah_akun .modal-header .parrent").val($(this).data("parrent"));
    })

    $("#modal_tambah_akun").on("hidden.bs.modal", function(e){
      $("#modal_tambah_akun .modal-body").html('<center class="text-muted">Menyiapkan Form</center>');
      if($change)
        window.location = baseUrl+"/master_keuangan/akun";
    })

    $("#modal_tambah_akun").on("shown.bs.modal", function(e){
      //alert($("#modal_tambah_akun .modal-header .parrent").val())

      $.ajax(baseUrl+"/master_keuangan/add/"+$("#modal_tambah_akun .modal-header .parrent").val(), {
         timeout: 15000,
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

    $(".searchable").on("click", ".editAkun", function(){
      $("#modal_edit").modal("show");
      $("#modal_edit_akun .modal-body").html('<center class="text-muted">Menyiapkan Form</center>');

      $.ajax(baseUrl+"/master_keuangan/edit/"+$(this).data("parrent"), {
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

      window.location = baseUrl + "/master_keuangan/akun?" + form.serialize();
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