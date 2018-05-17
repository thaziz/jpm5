@extends('main')

@section('title', 'dashboard')

@section("extra_styles")
  
  <link href="{{ asset('assets/vendors/bootstrap-treegrid/css/jquery.treegrid.css') }}" rel="stylesheet">

  <style>
  .row-eq-height {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
  }

    #table_form input{
      padding-left: 5px;
    }

    #table_form td,
    #table_form th{
      padding:10px 0px;
    }

    #tree th{
      padding:5px;
      border: 1px solid #ccc;
      font-weight: 600;
    }

    #tree td.secondTree{
      padding-left: 40px;
    }

    #tree td{
      border: 0px;
      padding: 5px;
    }

    #tree td.{
      color:blue;
    }

    #tree td.highlight{
      border-top:2px solid #aaa;
      border-bottom: 2px solid #aaa;
      color:#222;
    }

    #tree td.break{
      padding: 10px 0px;
      background: #eee;
    }

    #bingkai td.header{
      font-weight: bold;
    }

    #bingkai td.child{
      padding-left: 20px;
    }

    #bingkai td.total{
      border-top: 2px solid #999;
      font-weight: 600;
    }

    #bingkai td.no-border{
      border: 0px;
    }

  </style>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="box" id="seragam_box">
                        <div class="box-header">
                        </div><!-- /.box-header -->
                        <div class="box-body" style="min-height: 330px;">
                          <div class="col-md-12" style="border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            <center><small class="text-muted">Tidak Ada Desain Neraca Yang Aktif. Sehingga Laporan Neraca Tidak Bisa Ditampilkan. <b>Silahkan Aktifkan Salah Satu Desain Dibawah Ini.</b></small></center>
                          </div>

                          <div class="col-md-12 m-t">
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

                                      </td>
                                    </tr> 

                                    <?php $a++; ?>
                                  @endforeach
                                  
                                </tbody>
                              </table>
                            </div>

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
  <script>
    $(document).ready(function(){
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

      $(".aktifkan").click(function(evt){
      evt.stopImmediatePropagation();
      evt.preventDefault();

      $(".aktifkan").attr("disabled", "disabled");

      $.ajax(baseUrl+"/master_keuangan/desain_neraca/aktifkan/"+$(this).data("id"), {
         timeout: 15000,
         dataType: "json",
         success: function (data) {
            if(data.status == "sukses"){
              alert("Desain Neraca Berhasil Digunakan. Halaman Akan Dimuat Ulang");
              location.reload();
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

    })
  </script>
@endsection





