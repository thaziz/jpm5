@extends('main')

@section('title', 'dashboard')

@section("extra_styles")
  
  <link href="{{ asset('assets/vendors/bootstrap-treegrid/css/jquery.treegrid.css') }}" rel="stylesheet">

  <style>
  
    .table_neraca td{
      font-weight: 600;
      border-top:1px dotted #efefef;
    }

    .table_neraca td.lv1{
      padding: 5px 10px;
    }

    .table_neraca td.lv2{
      padding: 5px 25px;
    }

    .table_neraca td.lv3{
      padding: 5px 50px;
      font-style: italic;
    }

    .table_neraca td.money{
      text-align: right;
      padding: 5px 10px;
    }

    .table_neraca td.total{
      border-top: 1px solid #bbb;
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

  </style>

@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-10">
          <h2> Laporan Laba Rugi {{ ($_GET['cab'] == "all") ? "Semua Cabang" : "Cabang ".$cabang->nama }}</h2>
          <ol class="breadcrumb">
              <li>
                  <a>Home</a>
              </li>
              <li>
                  <a>Keuangan</a>
              </li>
              <li class="active">
                  <strong> Laporan Laba Rugi  </strong>
              </li>

          </ol>
      </div>
  </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                      <h5 id="title_in"></h5>

                    <div class="ibox-tools">

                        <div style="display: inline-block; background: none;">
                          <button class="btn btn-sm btn-default pilihCabang" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="fa fa-list"></i> &nbsp;Pengaturan Halaman
                              <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1" style="right: 95px;">
                            <li><a href="#" data-toggle="modal" data-target="#modal_setting_table"><i class="fa fa-table fa-fw"></i> &nbsp;Pengaturan Tampilan Laba Rugi</a></li>
                          </ul>
                        </div>

                        <a href="{{ route("laba_rugi.pdf_single", $throttle."?cab=".$_GET["cab"]."&m=".$request["m"]."&y=".$request["y"]) }}" target="_blank">
                          <button class="btn btn-sm btn-primary" style="font-size: 8pt;">
                            <i class="fa fa-file-pdf-o"></i> &nbsp;Cetak PDF
                          </button>
                        </a>

                        {{-- <a href="{{ route("neraca.excel_single", $throttle."?m=".$request["m"]."&y=".$request["y"]) }}" target="_blank">
                          <button class="btn btn-sm btn-primary" style="font-size: 8pt;">
                            <i class="fa fa-file-excel-o"></i> &nbsp;Cetak Excel
                          </button>
                        </a> --}}
                    </div>
                </div>
                <div class="ibox-content">
                  <div class="row">
  
                    {{-- Aktiva START --}}

                    <div class="col-md-6 col-md-offset-3">
                      <div class="col-md-12 text-center text-muted" style="padding: 10px; border: 1px solid #eee; box-shadow: 0px 0px 10px #eee;">
                        Laba Rugi {{ date_ind($request->m) }} {{ $request->y }}
                      </div>

                      <div class="col-md-12" style="border: 1px solid #eee; box-shadow: 0px 0px 10px #eee; padding: 0px;">
                        <table class="table_neraca tree" width="100%" style="font-size: 8pt;" border="0">

                          <?php $total_aktiva = 0; $total_pasiva = 0; ?>

                          @foreach($data_neraca as $data_neraca_aktiva)
                              <?php 
                                $level = "lv".$data_neraca_aktiva["level"];
                                $tree_parrent = ($data_neraca_aktiva['parrent'] == "") ? "" : "treegrid-parent-".str_replace(".", "_", $data_neraca_aktiva["parrent"]);;
                                $treegrid = "treegrid-".str_replace(".", "_", $data_neraca_aktiva["nomor_id"]);
                              ?>
                              
                              @if($data_neraca_aktiva["jenis"] == 1)
                                <tr class="{{ $treegrid }} {{ $tree_parrent }}" id="{{ $data_neraca_aktiva["nomor_id"] }}">
                                  <td colspan="3" class="{{ $level }}">{{ $data_neraca_aktiva["keterangan"] }}</td>
                                </tr>
                              @elseif($data_neraca_aktiva["jenis"] == 2)
                                <tr class="{{ $treegrid }} {{ $tree_parrent }}" id="{{ $data_neraca_aktiva["nomor_id"] }}">
                                  <td width="50%" class="{{ $level }}">{{ $data_neraca_aktiva["keterangan"] }}</td>
                                  {{-- <td class="money">{{ $data_neraca_aktiva["total"] }}</td> --}}
                                </tr>

                                  @foreach($data_detail as $data_detail_aktiva)
                                    @if($data_detail_aktiva["id_parrent"] == $data_neraca_aktiva["nomor_id"])
                                      <?php 
                                        $tree_parrent = ($data_detail_aktiva['id_parrent'] == "") ? "" : "treegrid-parent-".str_replace(".", "_", $data_detail_aktiva["id_parrent"]);;
                                        $treegrid = "treegrid-".str_replace(".", "_", $data_detail_aktiva["nomor_id"]);

                                        $num = number_format($data_detail_aktiva["total"], 2);

                                        if($data_detail_aktiva["total"] < 0){
                                          $num = "(".number_format(str_replace("-", "", $data_detail_aktiva["total"]), 2).")";
                                        }
                                      ?>

                                      <tr class="{{ $treegrid }} {{ $tree_parrent }}" id="{{ $data_detail_aktiva["nomor_id"] }}">
                                        <td class="lv3">{{ $data_detail_aktiva["nama_referensi"] }}</td>
                                        <td class="money">{{ $num }}</td>
                                        <td></td>

                                        <?php $total_aktiva += $data_detail_aktiva["total"]; ?>
                                      </tr>
                                    @endif
                                  @endforeach

                              @elseif($data_neraca_aktiva["jenis"] == 3)
                                <?php

                                  $num = number_format($data_neraca_aktiva["total"], 2);

                                  if($data_neraca_aktiva["total"] < 0){
                                    $num = "(".number_format(str_replace("-", "", $data_neraca_aktiva["total"]), 2).")";
                                  }

                                ?>

                                <tr class="{{ $treegrid }} {{ $tree_parrent }}" id="{{ $data_neraca_aktiva["nomor_id"] }}">
                                  <td class="{{ $level }}">{{ $data_neraca_aktiva["keterangan"] }}</td>
                                  <td class="money"></td>
                                  <td class="money total">{{ $num }}</td>
                                </tr>
                              @elseif($data_neraca_aktiva["jenis"] == 4)
                                <tr class="{{ $treegrid }} {{ $tree_parrent }}">
                                  <td class="{{ $level }}">&nbsp;</td>
                                  <td></td>
                                  <td></td>
                                </tr>
                              @endif
                          @endforeach

                        </table>
                      </div>
                    </div>

                    {{-- Aktiva END --}}

                  </div>

                  <div class="row">
                    <div class="col-md-6 col-md-offset-3 m-t">
                      <div class="col-md-12" style="border: 1px solid #eee; box-shadow: 0px 0px 10px #eee; padding: 0px;">
                        <table class="table_neraca" width="100%" style="font-size: 8pt;" border="0">

                          <?php
                            $num = number_format($total_aktiva, 2);

                            if($total_aktiva < 0){
                              $num = "(".number_format(str_replace("-", "", $total_aktiva), 2).")";
                            }
                          ?>

                          <tr>
                            <td class="text-center">Total Laba Rugi</td>
                            <td class="money">{{ $num }}</td>
                          </tr>

                        </table>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal -->
<div id="modal_setting_table" class="modal">
  <div class="modal-dialog" style="width: 30%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Setting Tampilan Neraca</h4>
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
                      
                      @if(Session::get("cabang") == '000')
                        <option value="all">SEMUA CABANG</option>
                      @endif

                      @foreach($cabangs as $cab)
                        <?php $select = ($cab->kode == $_GET["cab"]) ? "selected" : "" ?>
                        <option value="{{ $cab->kode }}" {{$select}}>{{ $cab->nama }}</option>
                      @endforeach
                    </select>
                </td>
              </tr>

              <tr>
                <td width="30%" class="text-center">Jenis Laba Rugi</td>
                <td colspan="2">
                    <select class="form-control" style="width:90%; height: 30px" id="tampil">
                      <option value="bulan">Laba Rugi Bulan</option>
                      <option value="tahun">Laba Rugi Tahun</option>
                      <option value="p_bulan">Perbandingan Bulan</option>
                      <option value="p_tahun">Perbandingan Tahun</option>
                    </select>
                </td>
              </tr>

              <tr>
                <td width="30%" class="text-center"></td>
                <td>

                    <input class="form-control text-center date" style="width:90%; height: 30px; cursor: pointer; background: #fff; display:none;" readonly data-toggle="tooltip" id="bulan" placeholder="Pilih Bulan">

                    <input class="form-control text-center date_year" style="width:90%; height: 30px; cursor: pointer; background: #fff; display:none;" readonly data-toggle="tooltip" id="bulan_1" placeholder="Bulan Ke-1">

                    <input class="form-control text-center year" style="width:90%; height: 30px; cursor: pointer; background: #fff; display:none;" readonly data-toggle="tooltip" id="tahun_1" placeholder="Tahun Ke-1">

                </td>

                <td>

                    <input class="form-control text-center year" style="width:80%; height: 30px; cursor: pointer; background: #fff; display:none;" readonly data-toggle="tooltip" id="tahun" placeholder="Pilih Tahun">

                    <input class="form-control text-center date_year" style="width:80%; height: 30px; cursor: pointer; background: #fff; display:none;" readonly data-toggle="tooltip" id="bulan_2" placeholder="Bulan Ke-2">

                    <input class="form-control text-center year" style="width:80%; height: 30px; cursor: pointer; background: #fff; display:none;" readonly data-toggle="tooltip" id="tahun_2" placeholder="Tahun Ke-2">

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
<script type="text/javascript">

  $(document).ready(function(){
    //$("#tree").DataTable();

   // $(".tree").treegrid({
   //    treeColumn: 0,
   //    initialState: "expanded",
   //  });

   // $('.tree').treegrid('getAllNodes').on('collapse', function(){
   //   $id = $(this).attr("id");
   //   alert($id);
   //   $("#tot-"+$id).fadeIn();
   // });

   // $('.tree').treegrid('getAllNodes').on('expand', function(){
   //   $id = $(this).attr("id");
   //   alert($id);
   //   $("#tot-"+$id).fadeOut();
   // });


   throttle = "{{ $throttle }}"; req1 = "{{ $request->m }}"; req2 = "{{ $request->y }}"; date_show = '{{ date_ind($request->m) }}';

   $('.date_year').datepicker( {
        format: "mm/yyyy",
        viewMode: "months", 
        minViewMode: "months"
    });

    $('#dateMonth').datepicker( {
        format: "mm",
        viewMode: "months", 
        minViewMode: "months"
    });

    $('.date').datepicker( {
        format: "mm",
        viewMode: "months", 
        minViewMode: "months"
    });

    $('.year').datepicker( {
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    });

   switch(throttle){
    case "bulan" :
      $("#tampil").val(throttle);
      $("#title_in").text("Menampilkan Laba Rugi Periode Bulan "+date_show+" "+req2);
      $("#bulan").css("display", "inline-block"); $("#tahun").css("display", "inline-block");
      $("#bulan").val(req1); $("#tahun").val(req2);
      break;
    case "tahun" :
      $("#tampil").val(throttle);
      $("#title_in").text("Menampilkan Laba Rugi Periode Tahun "+req2);
      $("#bulan").css("display", "inline-block"); $("#tahun").css("display", "inline-block");
      $("#bulan").attr("disabled", "disabled"); $("#bulan").val("-");
      $("#tahun").val(req2);
      break;
   }

   $("#tampil").change(function(evt){
    evt.stopImmediatePropagation();
    evt.preventDefault();

    cek = $(this);

    if(cek.val() == "bulan"){
      $("#bulan_1").css("display", "none"); $("#bulan_2").css("display", "none");
      $("#tahun_1").css("display", "none"); $("#tahun_2").css("display", "none");
      $("#bulan").css("display", "inline-block"); $("#tahun").css("display", "inline-block");
      $("#bulan").removeAttr("disabled");

      if(throttle == "bulan"){
        $("#bulan").val(req1); $("#tahun").val(req2);
      }else{
        $("#bulan").val(""); $("#tahun").val("");
      }

    }else if(cek.val() == "tahun"){
      $("#bulan_1").css("display", "none"); $("#bulan_2").css("display", "none");
      $("#tahun_1").css("display", "none"); $("#tahun_2").css("display", "none");
      $("#bulan").css("display", "inline-block"); $("#tahun").css("display", "inline-block");
      $("#bulan").attr("disabled", "disabled"); $("#bulan").val("-");

      if(throttle == "tahun"){
        $("#tahun").val(req2);
      }else{
        $("#tahun").val("");
      }
    }else if(cek.val() == "p_bulan"){
      $("#tahun_1").css("display", "none"); $("#tahun_2").css("display", "none");
      $("#bulan").css("display", "none"); $("#tahun").css("display", "none");
      $("#bulan_1").css("display", "inline-block"); $("#bulan_2").css("display", "inline-block");

      if(throttle == "p_bulan"){
        $("#bulan_1").val(req1); $("#bulan_2").val(req2);
      }else{
        $("#bulan_1").val(""); $("#bulan_2").val("");
      }
    }else if(cek.val() == "p_tahun"){
      $("#bulan_1").css("display", "none"); $("#bulan_2").css("display", "none");
      $("#bulan").css("display", "none"); $("#tahun").css("display", "none");
      $("#tahun_1").css("display", "inline-block"); $("#tahun_2").css("display", "inline-block");

      if(throttle == "p_tahun"){
        $("#tahun_1").val(req1); $("#tahun_2").val(req2);
      }else{
        $("#tahun_1").val(""); $("#tahun_2").val("");
      }
    }

   })

   $("#submit_setting").click(function(event){
      event.preventDefault();
      form = $("#table_setting_form"); $(this).attr("disabled", true); $(this).text("Mengubah Tampilan Laba Rugi ...");

      tampil = $("#tampil").val();

      if(tampil == "bulan"){

        data = $("#tampil").val()+"?"+form.serialize()+"&m="+$("#bulan").val()+"&y="+$("#tahun").val();

        if($("#bulan").val() == "" || $("#tahun").val() == ""){
          toastr.warning('Bulan Dan Tahun Tidak Boleh Kosong');
          $(this).removeAttr("disabled"); $(this).text("Submit");
          return false;
        }else{
          window.location = baseUrl+"/master_keuangan/laba_rugi/single/"+data;
        }
      }else if(tampil == "tahun"){

        data = $("#tampil").val()+"?"+form.serialize()+"&m="+$("#bulan").val()+"&y="+$("#tahun").val();

        if($("#bulan").val() == "" || $("#tahun").val() == ""){
          toastr.warning('Tahun Tidak Boleh Kosong');
          $(this).removeAttr("disabled"); $(this).text("Submit");
          return false;
        }else{
          window.location = baseUrl+"/master_keuangan/laba_rugi/single/"+data;
        }
      }else if(tampil == "p_bulan"){

        data = $("#tampil").val()+"?"+form.serialize()+"&m="+$("#bulan_1").val()+"&y="+$("#bulan_2").val();

        if($("#bulan_1").val() == "" || $("#bulan_2").val() == ""){
          toastr.warning('Bulan Tidak Boleh Ada Yang Kosong');
          $(this).removeAttr("disabled"); $(this).text("Submit");
          return false;
        }else{
          window.location =baseUrl+"/master_keuangan/laba_rugi/perbandingan/"+data;
        }
      }else if(tampil == "p_tahun"){

        data = $("#tampil").val()+"?"+form.serialize()+"&m="+$("#tahun_1").val()+"&y="+$("#tahun_2").val();

        if($("#tahun_1").val() == "" || $("#tahun_2").val() == ""){
          toastr.warning('Tahun Tidak Boleh Ada Yang Kosong');
          $(this).removeAttr("disabled"); $(this).text("Submit");
          return false;
        }else{
          window.location = baseUrl+"/master_keuangan/laba_rugi/perbandingan/"+data;
        }
      }
    })

   // $("#set").click(function(evt){
   //    evt.stopImmediatePropagation();
   //    evt.preventDefault();

   //    tampil = $("#tampil").val();

   //    if(tampil == "bulan"){
   //      if($("#bulan").val() == "" || $("#tahun").val() == ""){
   //        toastr.warning('Bulan Dan Tahun Tidak Boleh Kosong');
   //        return false;
   //      }else{
   //        window.location = baseUrl+"/master_keuangan/laba_rugi/single/"+$("#tampil").val()+"?m="+$("#bulan").val()+"&y="+$("#tahun").val();
   //      }
   //    }else if(tampil == "tahun"){
   //      if($("#bulan").val() == "" || $("#tahun").val() == ""){
   //        toastr.warning('Tahun Tidak Boleh Kosong');
   //        return false;
   //      }else{
   //        window.location = baseUrl+"/master_keuangan/laba_rugi/single/"+$("#tampil").val()+"?m="+$("#bulan").val()+"&y="+$("#tahun").val();
   //      }
   //    }else if(tampil == "p_bulan"){
   //      if($("#bulan_1").val() == "" || $("#bulan_2").val() == ""){
   //        toastr.warning('Bulan Tidak Boleh Ada Yang Kosong');
   //        return false;
   //      }else{
   //        window.location = baseUrl+"/master_keuangan/laba_rugi/perbandingan/"+$("#tampil").val()+"?m="+$("#bulan_1").val()+"&y="+$("#bulan_2").val();
   //      }
   //    }else if(tampil == "p_tahun"){
   //      if($("#tahun_1").val() == "" || $("#tahun_2").val() == ""){
   //        toastr.warning('Tahun Tidak Boleh Ada Yang Kosong');
   //        return false;
   //      }else{
   //        window.location = baseUrl+"/master_keuangan/laba_rugi/perbandingan/"+$("#tampil").val()+"?m="+$("#tahun_1").val()+"&y="+$("#tahun_2").val();
   //      }
   //    }
   // })

  })

</script>
@endsection





