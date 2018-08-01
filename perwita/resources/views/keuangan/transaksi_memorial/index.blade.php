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

    /*.modal-open{
      overflow: inherit;
    }*/

    .chosen-select {
        background: red;
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
        <h2> Transaksi Memorial</h2>
        <ol class="breadcrumb">
            <li>
                <a>Home</a>
            </li>
            <li>
                <a>Keuangan</a>
            </li>
            <li class="active">
                <strong> Transaksi Memorial </strong>
            </li>

        </ol>
    </div>

    <div class="col-lg-12" style="border: 1px solid #eee; margin-top: 15px;">
      <table border="0" id="form-table" class="col-md-10">
      <tr>
        <td width="15%" class="text-center">Filter Berdasarkan : </td>
        <td width="18%">
          <select class="form-control" style="width:90%; height: 30px" id="berdasarkan">
              <option value="1">Transaksi Cabang</option>
                <option value="2">Jurnal Referensi</option>
                <option value="3">Tanggal Jurnal</option>
                <option value="4">Jurnal Detail</option>
                <option value="5">Jurnal Note</option>
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
                    <h5> Data Transaksi Memorial {{ $cabang_nama }} {{-- Periode {{ date_ind($_GET["date"]) }} {{ $_GET["year"] }} --}}
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        <select name="cab" class="select_validate_null" id="pil_cab" style="padding: 5px 5px; border-color: #ccc;border-radius: 3px; color: #666;width: 13em; font-size: 8pt;">

                          @if(Session::get('cabang') == '000')
                            <option value="all">Semua Cabang</option>
                          @endif

                          @foreach($cabangs as $cab)
                            <?php $select = ($cab->kode == $_GET["cab"]) ? "selected" : "" ?>
                            <option value="{{ $cab->kode }}" {{$select}}>{{ $cab->nama }}</option>
                          @endforeach

                        </select> &nbsp;&nbsp;

                        <button class="btn btn-sm btn-primary tambahAkun" data-parrent="0" data-toggle="modal" data-target="#modal_tambah_akun">
                          <i class="fa fa-plus"></i> &nbsp;Tambah Data Transaksi Memorial
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
                                  <th width="15%" class="text-center">Transaksi Cabang</th>
                                  <th width="15%" class="text-center">Jurnal Referensi</th>
                                  <th width="12%" class="text-center">Tanggal</th>
                                  <th class="text-center">Jurnal Detail</th>
                                  <th class="text-center">Jurnal Note</th>
                                  <th class="text-center">Aksi</th>
                                  {{-- <th style="padding:8px 0px" class="text-center">Saldo</th> --}}
                                </tr>
                              </thead>
                              <tbody  class="searchable">

                                @foreach($data as $dataAkun)
                                  <tr>
                                    <td class="text-center">{{ $dataAkun->nama }}</td>
                                    <td class="text-center">{{ $dataAkun->jr_ref }}</td>
                                    <td class="text-center">{{ date("d-m-Y", strtotime($dataAkun->jr_date)) }}</td>
                                    <td class="text-center">{{ $dataAkun->jr_detail }}</td>
                                    <td class="text-center">{{ $dataAkun->jr_note }}</td>
                                    <td class="text-center">
                                      <button class="btn btn-xs btn-success lihat_jurnal" data-toggle="tooltip" data-placement="left" title="Lihat Jurnal" data-id="{{ $dataAkun->jr_id }}"><i class="fa fa-balance-scale"></i></button>
                                    </td>
                                    {{-- <th style="padding:8px 0px" class="text-center">Saldo</th> --}}
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

<div id="overlay">
  <div class="modal-dialog" style="width: 50%; min-height: 650px; margin-top: 30px;">
    <div class="modal-content" style="background: #efefef;">
      <div class="modal-header" style="background: white">
        <button type="button" class="close overlay_close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">List Transaksi Memorial <span id="cab_list_name"></span></h4>
        <input type="hidden" class="parrent"/>
      </div>
      <div class="modal-body">
        <center class="text-muted">Sedang Memuat ...</center>
      </div>

    </div>
  </div>
</div>

 <!-- modal -->
<div id="modal_tambah_akun" class="modal">
  <div class="modal-dialog" style="width: 60%; min-height: 605px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Form Tambah Data Transaksi Memorial</h4>
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
<div id="modal_jurnal" class="modal">
  <div class="modal-dialog" style="width: 55%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Detail Jurnal</h4>
        <input type="hidden" class="parrent"/>
      </div>
      <div class="modal-body">
        <center class="text-muted">Sedang Memuat</center>
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

      $.ajax(baseUrl+"/keuangan/transaksi_memorial/add?cab={{ $_GET['cab'] }}", {
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

    $('#pil_cab').change(function(evt){
      evt.preventDefault();
      window.location = baseUrl + "/keuangan/jurnal_umum?cab="+$(this).val()+"&date={{date('m')}}&year={{date('Y')}}&jenis={{ $_GET['jenis'] }}";
    })

    $("#submit_setting").click(function(event){
      event.preventDefault();
      form = $("#table_setting_form"); $(this).attr("disabled", true); $(this).text("Mengubah Tampilan Table ...");

      window.location = baseUrl + "/keuangan/jurnal_umum?" + form.serialize();
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
    });

    $('.lihat_jurnal').click(function(evt){
      evt.preventDefault();
      $("#modal_jurnal").modal('show');
      $("#modal_jurnal .modal-body").html('<center class="text-muted">Sedang Memuat</center>');

      $.ajax(baseUrl+"/keuangan/jurnal_umum/show-detail/"+$(this).data('id'), {
         timeout: 15000,
         dataType: "html",
         success: function (data) {
             $("#modal_jurnal .modal-body").html(data);
         },
         error: function(request, status, err) {
            if (status == "timeout") {
              $("#modal_jurnal .modal-body").html('<center class="text-muted">Waktu Koneksi habis</center>');
            } else {
              $("#modal_jurnal .modal-body").html('<center class="text-muted">Ups Gagal Loading</center>');
            }
        } 
      });

    });

    $(".overlay_close").click(function(){
      $("#overlay").fadeOut(100);
    });

    $("#overlay").click(function(){
      $("#overlay").fadeOut(100);
    });

  })
</script>
@endsection