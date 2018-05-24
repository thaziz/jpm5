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
        <h2> Desain Laba Rugi </h2>
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
                <strong> Desain Laba Rugi  </strong>
            </li>

        </ol>
    </div>

    <div class="col-lg-12" style="border: 1px solid #eee; margin-top: 15px;">
      <table border="0" id="form-table" class="col-md-10">
      <tr>
        <td width="15%" class="text-center">Filter Berdasarkan : </td>
        <td width="18%">
          <select class="form-control" style="width:90%; height: 30px" id="berdasarkan">
              <option value="1">Nama Desain</option>
              <option value="2">Tanggal Dibuat</option>
              <option value="3">Status</option>
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
                    <h5> Data Desain Laba Rugi
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        <a class="btn btn-sm btn-primary tambahAkun" href="{{ url('master_keuangan/desain_neraca/add')}}">
                          <i class="fa fa-plus"></i> &nbsp;Tambahkan Data Desain Laba Rugi
                        </a>
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
                                  <th width="5%" class="text-center">No</th>
                                  <th width="40%" class="text-center">Nama Desain</th>
                                  <th width="20%" class="text-center">Tanggal Dibuat</th>
                                  <th class="text-center">Status</th>
                                  <th class="text-center">Aksi</th>

                                </tr>
                              </thead>
                              <tbody  class="searchable">

                                <?php $a = 1; ?>

                                @foreach($desain as $data_desain)
                                <?php $status = ($data_desain->is_active == 1) ? '<span class="text-navy">Sedang Digunakan</span>' : "Tidak Aktif" ?>
                                  <tr>
                                    <td class="text-center">{{ $a }}</td>
                                    <td class="text-center">{{ $data_desain->nama_desain }}</td>
                                    <td class="text-center">{{ date("d", strtotime($data_desain->tanggal_buat)) }} {{ date_ind(date("m")) }} {{ date("Y", strtotime($data_desain->tanggal_buat)) }}</td>
                                    <td class="text-center">{!! $status !!}</td>
                                    <td class="text-center">
                                      
                                      <?php
                                        $dis = "";
                                        if($data_desain->is_active == 1){
                                          $dis = "disabled";
                                        }
                                      ?>

                                      <span data-toggle="tooltip" data-placement="top" title="Gunakan Desain Ini">
                                          <button class="btn btn-xs btn-success aktifkan" data-id="{{ $data_desain->id_desain }}" {{ $dis }}><i class="fa fa-check-square fa-fw"></i></button>
                                      </span>

                                      <span data-toggle="tooltip" data-placement="top" title="Tampilkan Desain">
                                          <button class="btn btn-xs btn-primary tampilkan" data-id="{{ $data_desain->id_desain }}"><i class="fa fa-external-link-square fa-fw"></i></button>
                                      </span>

                                      <span data-toggle="tooltip" data-placement="top" title="Perbarui Desain">
                                          <button class="btn btn-xs btn-warning edit" data-id="{{ $data_desain->id_desain }}"><i class="fa fa-edit fa-fw"></i></button>
                                      </span>

                                      <span data-toggle="tooltip" data-placement="top" title="Hapus Desain">
                                          <button class="btn btn-xs btn-danger hapus" data-id="{{ $data_desain->id_desain }}" {{ $dis }}><i class="fa fa-eraser fa-fw"></i></button>
                                      </span>
                                    </td>
                                  </tr> 

                                  <?php $a++; ?>
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
<div id="modal_tampilkan" class="modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tampilan Desain Neraca</h4>
        <input type="hidden" class="parrent"/>
      </div>
      <div class="modal-body" id="wrap">

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
        toastr.success('{{ Session::get('sukses') }}');
    @elseif(Session::has('terpakai'))
        alert("{{ Session::get('terpakai') }}")
    @elseif(Session::has('err'))
        toastr.error('{{ Session::get('err') }}');
    @endif

    tableDetail = $('.tbl-penerimabarang').DataTable({
      responsive: true,
      searching: true,
      sorting: true,
      paging: true,
      //"pageLength": 10,
      "language": dataTableLanguage,
    });

    $(".tampilkan").click(function(evt){
      evt.stopImmediatePropagation();
      evt.preventDefault();

      $("#modal_tampilkan").modal("show");
      $("#modal_tampilkan .modal-body").html('<center><small class="text-muted">Sedang Mengambil Data Tampilan Neraca...</small></center>');

      $.ajax(baseUrl+"/master_keuangan/desain_neraca/view/"+$(this).data("id"), {
         timeout: 15000,
         dataType: "html",
         success: function (data) {
             $("#modal_tampilkan .modal-body").html(data);
         },
         error: function(request, status, err) {
            if (status == "timeout") {
              $("#modal_tampilkan .modal-body").html('<center class="text-muted">Waktu Koneksi habis</center>');
            } else {
              $("#modal_tampilkan .modal-body").html('<center class="text-muted">Ups Gagal Loading</center>');
            }
        }
      });
    })

    $(".edit").click(function(evt){
      evt.stopImmediatePropagation();
      evt.preventDefault();

      $(".edit").attr("disabled", "disabled");

      window.location = baseUrl+"/master_keuangan/desain_neraca/edit/"+$(this).data("id");

    })

    $(".hapus").click(function(evt){
      evt.stopImmediatePropagation();
      evt.preventDefault();

      $(".hapus").attr("disabled", "disabled");

      prmpt = confirm("Apa Anda Yakin Ingin Menghapus Desain Ini ? ");

      if(prmpt)
        window.location = baseUrl+"/master_keuangan/desain_neraca/delete/"+$(this).data("id");
      else
        return false;

    })


    $(".aktifkan").click(function(evt){
      evt.stopImmediatePropagation();
      evt.preventDefault();

      $(".aktifkan").attr("disabled", "disabled");

      $.ajax(baseUrl+"/master_keuangan/desain_neraca/aktifkan/"+$(this).data("id"), {
         timeout: 15000,
         dataType: "json",
         success: function (data) {
            if(data.status == "sukses"){
              alert("Neraca Berhasil Digunakan.");
              window.location = baseUrl+"/master_keuangan/desain_neraca";
            }else if(data.status == "miss"){
              alert("Ups. Kami Tidak Bisa Menemukan Data Desain Yang Dimaksud..");
              $(".aktifkan").removeAttr("disabled");
            }
         },
         error: function(request, status, err) {
            if (status == "timeout") {
              toastr.error('Request Timeout. Data Gagal Disimpan');
              btn.removeAttr("disabled");
              btn.text("Simpan");
            } else {
              toastr.error('Internal Server Error. Data Gagal Disimpan');
              btn.removeAttr("disabled");
              btn.text("Simpan");
            }
        }
      });

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