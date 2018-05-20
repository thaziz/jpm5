@extends('main')

@section('title', 'dashboard')

@section("extra_styles")

  <link href="{{ asset('assets/vendors/jsTree/style.min.css') }}" rel="stylesheet">

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

    #table_form, #table-filter{
      border:0px solid black;
      width: 100%;
    }

    #table_form input,{
      padding-left: 5px;
    }

    #table_form td{
      padding: 10px 0px 0px 0px;
      vertical-align: top;
    }

    #table-filter td,
    #table-filter th{
      padding:10px 0px;
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
                <a>Keuangan</a>
            </li>
            <li class="active">
                <strong> Desain Laba Rugi  </strong>
            </li>

        </ol>
    </div>

    {{-- <div class="col-lg-12" style="border: 1px solid #eee; margin-top: 15px;">
      <table border="0" width="100%" id="table-filter">
        <tr>
          <th width="7%" class="text-center">Pencarian Berdasarkan : </th>
          <td width="10%">
            &nbsp;&nbsp;<select style="width:90%; border: 0px; border-bottom: 1px solid #aaa; cursor: pointer;" id="berdasarkan">
              <option value="semua">Semua</option>
              <option value="id_akun">Kode Akun</option>
              <option value="nama_akun">Nama Akun</option>
              <option value="dka">Posisi Debet/Kredit</option>
            </select>
          </td>

          <th width="5%" class="text-center">Kata Kunci : </th>
          <td width="8%">
            &nbsp;&nbsp;<input style="width:90%; padding-left: 3px;" data-toggle="tooltip" id="filter" placeholder="Masukkan Kata Kunci">
          </td>
        </tr>
      </table>
    </div> --}}
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
                        <button class="btn btn-sm btn-primary tambahAkun" data-toggle="modal" data-target="#modal_tambah_akun">
                          <i class="fa fa-plus"></i> &nbsp;Tambah Desain Laba Rugi
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

                  <table id="table" width="100%" class="table table-bordered table-striped tbl-penerimabarang no-margin" style="padding:0px;">
                    <thead>
                      <tr>
                        <th width="8%" style="padding:8px 0px" class="text-center">No</ht>
                        <th width="30%" style="padding:8px 0px" class="text-center">Tanggal Buat</ht>
                        <th width="30%" style="padding:8px 0px" class="text-center">Status Saat Ini</th>
                        {{-- <th style="padding:8px 0px" class="text-center">Saldo</th> --}}
                        <th width="20%" style="padding:8px 0px" width="20%" class="text-center">Aksi</th>

                      </tr>
                    </thead>
                    <tbody  class="searchable">

                      <?php $no = 1; ?>

                      @foreach($desain as $dataDesain)
                        <?php
                          $status = ($dataDesain->is_active == 1) ? "Sedang Digunakan" : "Tidak Aktif";
                          $color = ($dataDesain->is_active == 1) ? "#1ab394" : "";
                        ?>

                        <tr>
                          <td class="text-center">{{ $no }}</td>
                          <td class="text-center">{{ Date("d M Y", strtotime($dataDesain->tanggal_buat)) }}</td>
                          <td class="text-center" style="color:{{$color}}; font-weight: 600;"><small>{{ $status }}</small></td>
                          <td class="text-center">
                            <span data-toggle="tooltip" data-placement="top" title="Tampilkan Desain">
                                <button class="btn btn-xs btn-success tampilkan" data-id="{{ $dataDesain->id_desain }}"><i class="fa fa-external-link-square"></i></button>
                            </span>

                            <span data-toggle="tooltip" data-placement="top" title="Perbarui Desain">
                                <button class="btn btn-xs btn-warning editDesain" data-id="{{ $dataDesain->id_desain }}"><i class="fa fa-pencil-square"></i></button>
                            </span>

                            @if($dataDesain->is_active != 1)
                              <span data-toggle="tooltip" data-placement="top" title="Aktifkan Desain Ini">
                                  <button class="btn btn-xs btn-primary aktifkan" data-id="{{ $dataDesain->id_desain }}"><i class="fa fa-check-square"></i></button>
                              </span>
                            @endif

                            @if($dataDesain->is_active != 1)
                              <span data-toggle="tooltip" data-placement="top" title="Hapus Desain">
                                  <button class="btn btn-xs btn-danger hapus" data-id="{{ $dataDesain->id_desain }}"><i class="fa fa-eraser"></i></button>
                              </span>
                            @endif
                          </td>
                        </tr>

                        <?php $no++; ?>
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
<div id="modal_view" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tampilan Laba Rugi</h4>
        <input type="hidden" class="parrent"/>
      </div>
      <div class="modal-body" style="padding: 0px;padding-left: 15px;">
        <center class="text-muted" style="padding: 10px;">Sedang Mengambil Data...</center>
      </div>
    </div>
  </div>
</div>
  <!-- modal -->

<!-- modal -->
<div id="modal_tambah_akun" class="modal">
  <div class="modal-dialog" style="width: 70%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Form Tambah Data Desain Laba Rugi</h4>
        <input type="hidden" class="parrent"/>
      </div>
      <div class="modal-body" style="padding: 0px;padding-left: 15px;">
        <center class="text-muted" style="padding: 10px;">Menyiapkan Form</center>
      </div>

    </div>
  </div>
</div>
  <!-- modal -->

  <!-- modal -->
<div id="modal_edit_akun" class="modal">
  <div class="modal-dialog" style="width: 70%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Form Edit Data Desain Laba Rugi</h4>
        <input type="hidden" class="parrent"/>
      </div>
      <div class="modal-body" style="padding: 0px;padding-left: 15px;">
        <center class="text-muted" style="padding: 10px;">Menyiapkan Form</center>
      </div>

    </div>
  </div>
</div>
  <!-- modal -->

  <div id="modal_detail" class="modal">
    <div class="modal-dialog" style="width: 50%;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Tambahkan Detail Akun di Desain Laba Rugi <span id="title-for"></span></h4>
          <input type="hidden" class="parrent"/>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="col-md-12">
                <input type="text" id="akl" class="form-control" placeholder="Lakukan Pencarian" style="width: 93%;">
              </div>
              <div class="col-md-12" style="height: 300px; overflow-y: scroll; font-size: 8pt; margin-top: 10px;">
                <table class="table table-bordered">
                  <tbody id="parrent-wrap">

                  </tbody>
                </table>
              </div>
            </div>


            <div class="col-md-6" style="background: #f9f9f9;padding: 0px;height: 300px; overflow-y: scroll;">
              <table width="100%" class="table" style="font-size: 8pt;">
                <thead>
                  <tr>
                    <th class="text-center" width="35%">Kode</th>
                    <th class="text-center">Keterangan</th>
                  </tr>
                </thead>

                <tbody id="detail-wrapper">

                </tbody>
              </table>
            </div>

            <div class="col-md-12" id="listErrWrap" style="background: #fff;padding: 5px 10px;height: 100px; overflow-y: scroll; border: 1px solid #eee">

            </div>

            <div class="col-md-12" id="cek" style="border-top: 1px solid #eee;padding-top: 15px;">
              <button class="btn btn-primary btn-xs col-md-3 col-lg-offset-9" id="apply-detail">Apply Detail</button>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>


@endsection



@section('extra_scripts')

<script src="{{ asset('assets/vendors/jsTree/jsTree.min.js') }}"></script>
<script src="{{ asset('assets/vendors/jsTree/jstreetable.js') }}"></script>
<script src="{{ asset('assets/vendors/inputmask/inputmask.jquery.js') }}"></script>
<script type="text/javascript">

  $(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip();
    // $("#modal_detail").modal("show");

    {{-- @if(Session::has('sukses')) --}}
        // alert("{{ Session::get('sukses') }}")
    {{-- @endif --}}

    dataParrent = {!! $data !!};

    tableDetail = $('.tbl-penerimabarang').DataTable({
          responsive: true,
          searching: false,
          sorting: true,
          paging: true,
          //"pageLength": 10,
          "language": dataTableLanguage,
    });

    $(".tambahAkun").on("click", function(){
      $("#modal_tambah_akun .modal-header .parrent").val($(this).data("parrent"));
    })

    $("#modal_tambah_akun").on("hidden.bs.modal", function(e){
      $("#modal_tambah_akun .modal-body").html('<center class="text-muted" style="padding: 10px;">Menyiapkan Form</center>');
      if($change)
        window.location = baseUrl+"/master_keuangan/akun";
    })

    $("#modal_detail").on("hidden.bs.modal", function(e){
      $("#detail-wrapper").html("");
      $("#listErrWrap").html("");
    })

    $("#modal_detail").on("shown.bs.modal", function(e){
      $("#parrent-wrap").html(""); $html = "";

      $.each(dataParrent, function(i, n){
        if(n.id_akun.substring(0, 1) > 0){
          $html = $html + "<tr class='searchable'>"+
            '<td width="30%" class="text-center clickAble" style="cursor: pointer;" data-nama="'+n.nama_akun+'" data-parrent="'+n.id_akun+'">'+n.id_akun+'</td>'+
              '<td class="text-center">'+n.nama_akun+'</td>'+
          "</tr>";
        }
      })

      //alert($html);
      $("#parrent-wrap").html($html);
    })

    $("#modal_tambah_akun").on("shown.bs.modal", function(e){
      //alert($("#modal_tambah_akun .modal-header .parrent").val())

      $.ajax(baseUrl+"/master_keuangan/desain_laba_rugi/add", {
         timeout: 10000,
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

    $(".editDesain").on("click", function(evt){
      evt.stopImmediatePropagation();
      $("#modal_edit_akun").modal("show");
      $("#modal_edit_akun .modal-body").html('<center class="text-muted" style="padding: 10px;">Menyiapkan Form</center>');

      $.ajax(baseUrl+"/master_keuangan/desain_laba_rugi/edit/"+$(this).data("id"), {
         timeout: 10000,
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

    $(".aktifkan").on("click", function(evt){
      evt.stopImmediatePropagation();

      //alert($(this).data("id"));

      $trk = confirm("Apakah Anda Yakin ?. Desain Yang Aktif Sebelumnya Akan Dinonaktifkan...");

      if($trk){
        $.ajax(baseUrl+"/master_keuangan/desain_laba_rugi/aktifkan/"+$(this).data("id"),{
          type: "get",
          dataType: "json",
          success: function(response){
            if(response.status == "sukses"){
              alert("Desain Berhasil Diaktifkan. Halaman Akan Dimuat Ulang.")
              window.location = baseUrl+"/master_keuangan/desain_laba_rugi";
            }
          },
          error: function(request, status, err) {
            if(status == "timeout") {
              alert("Waktu Koneksi Habis. Data Gagal Diubah");
            }else {
              alert("ups. Gagal Loading. Data Gagal Diubah");
            }
          }
        })
      }
    })

    $(".hapus").on("click", function(evt){
      evt.stopImmediatePropagation();

      //alert($(this).data("id"));

      $trk = confirm("Apakah Anda Yakin ?. Desain Yang Dihapus Tidak Akan Bisa Dikembalikan...");

      if($trk){
        $.ajax(baseUrl+"/master_keuangan/desain_laba_rugi/delete/"+$(this).data("id"),{
          type: "get",
          dataType: "json",
          success: function(response){
            if(response.status == "sukses"){
              alert("Desain Berhasil Dihapus. Halaman Akan Dimuat Ulang.")
              window.location = baseUrl+"/master_keuangan/desain_laba_rugi";
            }
          },
          error: function(request, status, err) {
            if(status == "timeout") {
              alert("Waktu Koneksi Habis. Data Gagal Diubah");
            }else {
              alert("ups. Gagal Loading. Data Gagal Diubah");
            }
          }
        })
      }
    })

    $(".tampilkan").on("click", function(evt){
      evt.stopImmediatePropagation();
      $("#modal_view").modal("show");
      $("#modal_view .modal-body").html('<center class="text-muted" style="padding: 10px;">Sedang Mengambil Data...</center>');

      $.ajax(baseUrl+"/master_keuangan/desain_laba_rugi/view/"+$(this).data("id"), {
         timeout: 5000,
         dataType: "html",
         success: function (data) {
             $("#modal_view .modal-body").html(data);
         },
         error: function(request, status, err) {
            if (status == "timeout") {
              $("#modal_view .modal-body").html('<center class="text-muted">Waktu Koneksi habis</center>');
            } else {
              $("#modal_view .modal-body").html('<center class="text-muted">Ups Gagal Loading</center>');
            }
        }
      });
    })

    $('#akl').keyup(function () {
        //alert($('#parrent-wrap .search').html());
        $val = $(this).val().toUpperCase();
        var rex = new RegExp($(this).val(), 'i');
        $('#parrent-wrap tr').hide();
        $('#parrent-wrap tr').filter(function () {
            return rex.test($(this).text());
        }).show();
    })

    $("#cek").click("#apply-detail", function(event){
      event.stopImmediatePropagation();
      // alert("oke tambah")

      $html = ""; $falsed= false; $list = "";

      console.log($neracaDetail);

      //$("#detail-in-show").html("");

      //alert(1);
      $add = true; errList = '<span style="font-size: 8pt; font-weight: 600;">-- Data Berhasil Ditambahkan.</span>';

      $("#detail-in-show .inSearch").each(function(){
        $id1 = $(this).text(); $id2 = $apply_id;
        $ambil = Math.min($id1.length, $id2.length);

        if($id1 == $apply_id){
          errList = '<span style="font-size: 8pt; font-weight: 600;">-- Data Tidak Bisa Ditambahkan.</span>'+
              '<span style="font-size: 8pt; font-weight: 400;"><br/>'+
                'ID Akun Ini Sudah Anda Pilih.'+
              '</span>';
          $add = false;

          return false;
        }

        if($id1.substring(0, $ambil) == $id2.substring(0, $ambil)){
          if($id1.length < $id2.length){
            errList = '<span style="font-size: 8pt; font-weight: 600;">-- Data Tidak Bisa Ditambahkan.</span>'+
              '<span style="font-size: 8pt; font-weight: 400;"><br/>'+
                'ID Akun Yang Anda Pilih Sudah Termasuk Kedalam Akun '+$(this).data("nama")+' Yang Sebelumnya Sudah Anda Pilih.'
              '</span>';

            $add = false;
          }else{
            $(this).parent("tr").remove();
          }

          //return false;
        }

      })

      $.each($neracaDetail, function(i, n){
        $id1 = n.id_akun; $id2 = $apply_id;
        $ambil = Math.min($id1.length, $id2.length);
        // alert("okee");

        if($id1 == $apply_id){
          errList = '<span style="font-size: 8pt; font-weight: 600;">-- Data Tidak Bisa Ditambahkan.</span>'+
              '<span style="font-size: 8pt; font-weight: 400;"><br/>'+
                'ID Akun Ini Sudah Anda Pilih Lohh.'+
              '</span>';
          $add = false;

          return false;
        }

        if($id1.substring(0, $ambil) == $id2.substring(0, $ambil)){
          if($id1.length < $id2.length){
            $idx = $dataNeraca.findIndex(c => c.nomor_id == n.nomor_id);
            errList = '<span style="font-size: 8pt; font-weight: 600;">-- Data Tidak Bisa Ditambahkan.</span>'+
              '<span style="font-size: 8pt; font-weight: 400;"><br/>'+
                'ID Akun Yang Anda Pilih Sudah Termasuk Kedalam Detail '+$dataNeraca[$idx]["keterangan"]+' Yang Sebelumnya Sudah Anda Buat.'
              '</span>';

            $add = false;
          }else{
            $(this).parent("tr").remove();
          }

          //return false;
        }

      })

      if($add)
        $html = "<tr><td class='inSearch' data-for='child' data-nama='"+apply_nama+"'>"+$apply_id+"</td> <td>"+apply_nama+"</td></tr>";

      $("#detail-in-show").prepend($html);
      $("#listErrWrap").html(errList);

    })

    $("#cek").click("#apply-detail", function(event){
      event.stopImmediatePropagation();
      // alert("oke tambah")

      $html = ""; $falsed= false; $list = "";

      console.log($neracaDetail);

      //$("#detail-in-show").html("");

      //alert(1);
      $add = true; errList = '<span style="font-size: 8pt; font-weight: 600;">-- Data Berhasil Ditambahkan.</span>';

      $("#detail-in-show .inSearch").each(function(){
        $id1 = $(this).text(); $id2 = $apply_id;
        $ambil = Math.min($id1.length, $id2.length);

        if($id1 == $apply_id){
          errList = '<span style="font-size: 8pt; font-weight: 600;">-- Data Tidak Bisa Ditambahkan.</span>'+
              '<span style="font-size: 8pt; font-weight: 400;"><br/>'+
                'ID Akun Ini Sudah Anda Pilih.'+
              '</span>';
          $add = false;

          return false;
        }

        if($id1.substring(0, $ambil) == $id2.substring(0, $ambil)){
          if($id1.length < $id2.length){
            errList = '<span style="font-size: 8pt; font-weight: 600;">-- Data Tidak Bisa Ditambahkan.</span>'+
              '<span style="font-size: 8pt; font-weight: 400;"><br/>'+
                'ID Akun Yang Anda Pilih Sudah Termasuk Kedalam Akun '+$(this).data("nama")+' Yang Sebelumnya Sudah Anda Pilih.'
              '</span>';

            $add = false;
          }else{
            $(this).parent("tr").remove();
          }

          //return false;
        }

      })

      $.each($neracaDetail, function(i, n){
        $id1 = n.id_akun; $id2 = $apply_id;
        $ambil = Math.min($id1.length, $id2.length);
        // alert("okee");

        if($id1 == $apply_id){
          errList = '<span style="font-size: 8pt; font-weight: 600;">-- Data Tidak Bisa Ditambahkan.</span>'+
              '<span style="font-size: 8pt; font-weight: 400;"><br/>'+
                'ID Akun Ini Sudah Anda Pilih Lohh.'+
              '</span>';
          $add = false;

          return false;
        }

        if($id1.substring(0, $ambil) == $id2.substring(0, $ambil)){
          if($id1.length < $id2.length){
            $idx = $dataNeraca.findIndex(c => c.nomor_id == n.nomor_id);
            errList = '<span style="font-size: 8pt; font-weight: 600;">-- Data Tidak Bisa Ditambahkan.</span>'+
              '<span style="font-size: 8pt; font-weight: 400;"><br/>'+
                'ID Akun Yang Anda Pilih Sudah Termasuk Kedalam Detail '+$dataNeraca[$idx]["keterangan"]+' Yang Sebelumnya Sudah Anda Buat.'
              '</span>';

            $add = false;
          }else{
            $(this).parent("tr").remove();
          }

          //return false;
        }

      })

      if($add)
        $html = "<tr><td class='inSearch' data-for='child' data-nama='"+apply_nama+"'>"+$apply_id+"</td> <td>"+apply_nama+"</td></tr>";

      $("#detail-in-show").prepend($html);
      $("#listErrWrap").html(errList);

    })
  })

</script>
@endsection
