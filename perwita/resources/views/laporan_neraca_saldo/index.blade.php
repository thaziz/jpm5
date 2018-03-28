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

   .headcol {
      position:sticky;
      left: 0;
      background: white;
      border: 1px solid #eee;
   }

  </style>
@endsection

@section('content')

<div class="col-md-1" style="background: ; min-height: 30px; position: fixed; z-index: 1; bottom: 30px; right: 70px;">
   <div class="col-md-6 text-center" id="scroll_left" style="background: white; padding: 5px; font-size: 10pt; color: #128ac6;box-shadow:2px 2px 10px #999;border:1px solid #eee; border-radius:5px; cursor: pointer;">
      <i class="fa fa-arrow-left"></i>
   </div>
   <div class="col-md-6 text-center" id="scroll_right" style="background: white; padding: 5px; font-size: 10pt; color: #128ac6;box-shadow:2px 2px 10px #999;border:1px solid #eee; border-radius:5px; cursor: pointer;">
      <i class="fa fa-arrow-right"></i>
   </div>
</div>

<div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-10">
          <h2> Laporan Neraca Saldo </h2>
          <ol class="breadcrumb">
              <li>
                  <a>Home</a>
              </li>
              <li>
                  <a>Keuangan</a>
              </li>
              <li class="active">
                  <strong> Laporan Neraca Saldo</strong>
              </li>



          </ol>
      </div>

      <div class="col-lg-12" style="border: 1px solid #eee; margin-top: 15px;">
        <table border="0" width="95%" id="table_form">
          <tr>
            <th width="10%" class="text-center">Tampilkan : </th>
            <td width="25%">
              {{--<select style="width:35%">
                <option>Hari Ini</option>
                <option>Kemarin</option>
              </select>--}}
              <select name="show" class="form-control" id="show" style="cursor: pointer;">
                <option value="bulan">Laporan Bulanan</option>
                <option value="tahun">Laporan Tahunan</option>
              </select>

            </td>

            <?php
              $pb = ""; $pt = ""; $single="";

              if($throttle == "perbandingan_bulan"){
                $pt = "none"; $single = "none";
              }else if($throttle == "perbandingan_tahun"){
                $pb = "none"; $single = "none";
              }else{
                $pt = "none"; $pb = "none";
              }
            ?>

              <th style="display: {{$pb}};" width="10%" class="text-center pb">Bulan 1 : </th>
              <td class="pb" style="display: {{$pb}};" width="20%">
                <input type="text" class="form-control bulan" id="bulan1" name="bulan1" style="width:100%;cursor: pointer;text-align: center;" readonly>
              </td>

              <th style="display: {{$pb}};" width="10%" class="text-center pb">Bulan 2 : </th>
              <td class="pb" style="display: {{$pb}};" width="20%">
                <input type="text" class="form-control bulan" id="bulan2" name="bulan2" style="width:100%;cursor: pointer;text-align: center;" readonly>
              </td>

              <th style="display: {{$pt}}" width="10%" class="text-center pt">tahun 1 : </th>
              <td style="display: {{$pt}}" class="pt" width="20%">
                <input type="text" class="form-control tahun" id="tahun1" name="bulan1" style="width:100%;cursor: pointer;text-align: center;" readonly>
              </td>

              <th style="display: {{$pt}}" width="10%" class="text-center pt">tahun 2 : </th>
              <td style="display: {{$pt}}" class="pt" width="20%">
                <input type="text" class="form-control tahun" id="tahun2" name="bulan2" style="width:100%;cursor: pointer;text-align: center;" readonly>
              </td>

              <th style="display: {{$single}};" width="10%" class="text-center single">Bulan : </th>
              <td class="single" style="display: {{$single}};" width="20%">
                <input type="text" class="form-control" id="dateMonth" name="bulan" style="width:100%;cursor: pointer;text-align: center;" readonly {{ ($throttle == "tahun") ? "disabled" : "" }}>
              </td>

              <th style="display: {{$single}};" width="10%" class="text-center single">Tahun : </th>
              <td class="single" style="display: {{$single}};" width="20%">
                <input type="text" class="form-control" id="dateYear" name="Tahun" style="width:100%;cursor: pointer;text-align: center;" readonly>
              </td>


            <td width="2%">

            </td>

            <td width="14%">
              <button class="btn btn-success btn-sm" id="filter" data-throttle="{{ $throttle }}">Filter</button>
            </td>

            <td width="14%">
              
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
                    @if($throttle == "bulan")
                      <h5> Menampilkan Neraca Saldo Periode Bulan {{ $request["m"]."/".$request["y"] }}</h5>
                    @elseif($throttle == "tahun")
                      <h5> Menampilkan Neraca Saldo Periode Tahun {{ $request["y"] }}</h5>
                    @elseif($throttle == "perbandingan_bulan")
                      <h5> Menampilkan Perbandingan Neraca Saldo Bulan {{ $request["m"] }} Dan Bulan {{ $request["y"] }}</h5>
                    @elseif($throttle == "perbandingan_tahun")
                      <h5> Menampilkan Perbandingan Neraca Saldo Tahun {{ $request["m"] }} Dan Tahun {{ $request["y"] }}</h5>
                    @endif

                    <div class="ibox-tools">
                        <a href="{{ route("neraca.pdf", $throttle."?m=".$request["m"]."&y=".$request["y"]) }}" target="_blank">
                          <button class="btn btn-sm btn-primary">
                            <i class="fa fa-file-pdf-o"></i> &nbsp;Cetak PDF
                          </button>
                        </a>

                        <a href="{{ route("neraca.excel", $throttle."?m=".$request["m"]."&y=".$request["y"]) }}" target="_blank">
                          <button class="btn btn-sm btn-primary">
                            <i class="fa fa-file-excel-o"></i> &nbsp;Cetak Excel
                          </button>
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

                              <div class="row-eq-height">
                                 
                                 <div style="overflow-x: scroll;" id="content_scroll">
                                   <table class="table table-bordered" style="font-size: 8pt; width: 1600px">

                                     <thead class="text-center">
                                       <tr>
                                         <td rowspan="2" class="headcol">(kode) &nbsp;&nbsp; Nama</td>
                                         <td colspan="2">Saldo Awal</td>
                                         <td colspan="2">Mutasi Bank</td>
                                         <td colspan="2">Mutasi Kas</td>
                                         <td colspan="2">Mutasi Memorial</td>
                                         <td colspan="2">Total Mutasi</td>
                                       </tr>

                                       <tr>
                                         <td width="8%">Debet</td>
                                         <td width="8%">Kredit</td>

                                         <td width="8%">Debet</td>
                                         <td width="8%">Kredit</td>

                                         <td width="8%">Debet</td>
                                         <td width="8%">Kredit</td>

                                         <td width="8%">Debet</td>
                                         <td width="8%">Kredit</td>

                                         <td width="8%">Debet</td>
                                         <td width="8%">Kredit</td>
                                       </tr>
                                     </thead>

                                     <tbody>
                                       @foreach($data as $akun)
                                          <tr>
                                             <td class="headcol"><span style="font-weight: 600"> ({{ $akun->id_akun }})</span> &nbsp;&nbsp; {{ $akun->nama_akun }}</td>
                                             <td class="text-right" data-toggle="tooltip" data-placement="top" title="Saldo Awal (Debet)">{{ number_format(20000000000, 2) }}</td>
                                             <td class="text-right"data-toggle="tooltip" data-placement="top" title="Saldo Awal (Kredit)">{{ number_format(20000000000, 2) }}</td>
                                             <td class="text-right" data-toggle="tooltip" data-placement="top" title="Mutasi Bank (Debet)">{{ number_format(20000000000, 2) }}</td>
                                             <td class="text-right" data-toggle="tooltip" data-placement="top" title="Mutasi Bank (Kredit)">{{ number_format(20000000000, 2) }}</td>
                                             <td class="text-right" data-toggle="tooltip" data-placement="top" title="Mutasi Kas (Debet)">{{ number_format(20000000000, 2) }}</td>
                                             <td class="text-right" data-toggle="tooltip" data-placement="top" title="Mutasi Kas (Kredit)">{{ number_format(20000000000, 2) }}</td>
                                             <td class="text-right" data-toggle="tooltip" data-placement="top" title="Mutasi Memorial (Debet)">{{ number_format(20000000000, 2) }}</td>
                                             <td class="text-right" data-toggle="tooltip" data-placement="top" title="Mutasi Memorial (Kredit)">{{ number_format(20000000000, 2) }}</td>
                                             <td class="text-right" data-toggle="tooltip" data-placement="top" title=" Total Mutasi (Debet)">{{ number_format(20000000000, 2) }}</td>
                                             <td class="text-right" data-toggle="tooltip" data-placement="top" title=" Total Mutasi (Kredit)">{{ number_format(20000000000, 2) }}</td>
                                          </tr>
                                       @endforeach
                                     </tbody>
                                   </table>
                                 </div>
                                
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
<div id="modal_tambah_akun" class="modal">
  <div class="modal-dialog">
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



@endsection



@section('extra_scripts')

<script src="{{ asset('assets/vendors/bootstrap-treegrid/js/jquery.treegrid.js') }}"></script>
<script type="text/javascript">

  $(document).ready(function(){
    //$("#tree").DataTable();

    $("#scroll_right").click((e) => {
      e.preventDefault();
      $('#content_scroll').animate({
          scrollLeft: "+=250px"
      }, "fast");
    })

    $("#scroll_left").click((e) => {
      e.preventDefault();
      $('#content_scroll').animate({
          scrollLeft: "-=250px"
      }, "fast");
    })

    $("#show").val("{{ $throttle }}");
    $('body').removeClass('fixed-sidebar');
    $("body").toggleClass("mini-navbar");

    $('#dateYear').datepicker( {
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    });

    $('#dateMonth').datepicker( {
        format: "mm",
        viewMode: "months",
        minViewMode: "months"
    });

    $('.bulan').datepicker( {
        format: "mm/yyyy",
        viewMode: "months",
        minViewMode: "months"
    });

    $('.tahun').datepicker( {
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });

    switch($("#filter").data("throttle")){
      case 'perbandingan_bulan':
        $("#bulan1").val("{{ $request["m"] }}");
        $("#bulan2").val("{{ $request["y"] }}");

        break;

      case 'perbandingan_tahun':
        $("#tahun1").val("{{ $request["m"] }}");
        $("#tahun2").val("{{ $request["y"] }}");
        break;

      default :

        $("#dateYear").val("{{ $request["y"] }}");

        if("{{ $throttle }}" == "bulan")
          $("#dateMonth").val("{{ $request["m"] }}");
        else
          $("#dateMonth").val("---");

        break;
    }

    $("#show").change(function(){

      if($(this).val() == "perbandingan_bulan"){
        $(".pt").css("display", "none");
        $(".single").css("display", "none");
        $(".pb").css("display", "");
      }else if($(this).val() == "perbandingan_tahun"){
        $(".pt").css("display", "");
        $(".single").css("display", "none");
        $(".pb").css("display", "none");
      }else{
        $(".pt").css("display", "none");
        $(".single").css("display", "");
        $(".pb").css("display", "none");

        if($(this).val() == "tahun"){
          if($("#filter").data("throttle") != 'bulan'){
            $("#dateMonth").val("---"); $("#dateYear").removeAttr(""); $("#dateMonth").attr("disabled", "disabled");
          }else{
            $("#dateMonth").val("---"); $("#dateMonth").attr("disabled", "disabled"); $("#dateYear").val("{{ $request["y"] }}");
          }

        }else{
          if($("#filter").data("throttle") != 'bulan'){
            $("#dateMonth").val(""); $("#dateYear").removeAttr(""); $("#dateMonth").removeAttr("disabled");
          }else{
            $("#dateMonth").val("{{ $request["m"] }}"); $("#dateMonth").removeAttr("disabled"); $("#dateYear").val("{{ $request["y"] }}");
          }

        }
      }

    })

    $("#filter").click(function(evt){
      evt.stopImmediatePropagation();

      if($("#show").val() == "perbandingan_bulan"){
        if($("#bulan1").val() == "" || $("#bulan2").val() == ""){
          alert("Bulan 1 Dan Bulan 2 Tidak Boleh Kosong");
          return false;
        }

        window.location = baseUrl+"/master_keuangan/neraca/"+$("#show").val()+"?m="+$("#bulan1").val()+"&y="+$("#bulan2").val();
      }else if($("#show").val() == "perbandingan_tahun"){
        if($("#tahun1").val() == "" || $("#tahun2").val() == ""){
          alert("tahun 1 Dan tahun 2 Tidak Boleh Kosong");
          return false;
        }

        window.location = baseUrl+"/master_keuangan/neraca/"+$("#show").val()+"?m="+$("#tahun1").val()+"&y="+$("#tahun2").val();
      }else{
        if($("#show").val() == "bulan" && $("#dateMonth").val() == "---" || $("#show").val() == "bulan" && $("#dateMonth").val() == ""){
          alert("Pilih Bulan Terlebih Dahulu");
          return false;
        }else if($("#dateMonth").val() == "" || $("#dateYear").val() == ""){
          alert("Bulan dan Tahun Tidak Boleh Kosong");
          return false;
        }

        window.location = baseUrl+"/master_keuangan/neraca/"+$("#show").val()+"?m="+$("#dateMonth").val()+"&y="+$("#dateYear").val();
      }

    })

    $("#filter-rekap").click(function(evt){
      evt.stopImmediatePropagation();

      if($("#show").val() == "perbandingan_bulan"){
        if($("#bulan1").val() == "" || $("#bulan2").val() == ""){
          alert("Bulan 1 Dan Bulan 2 Tidak Boleh Kosong");
          return false;
        }

        window.location = baseUrl+"/master_keuangan/neraca-detail/"+$("#show").val()+"?m="+$("#bulan1").val()+"&y="+$("#bulan2").val();
      }else if($("#show").val() == "perbandingan_tahun"){
        if($("#tahun1").val() == "" || $("#tahun2").val() == ""){
          alert("tahun 1 Dan tahun 2 Tidak Boleh Kosong");
          return false;
        }

        window.location = baseUrl+"/master_keuangan/neraca-detail/"+$("#show").val()+"?m="+$("#tahun1").val()+"&y="+$("#tahun2").val();
      }else{
        if($("#show").val() == "bulan" && $("#dateMonth").val() == "---" || $("#show").val() == "bulan" && $("#dateMonth").val() == ""){
          alert("Pilih Bulan Terlebih Dahulu");
          return false;
        }else if($("#dateMonth").val() == "" || $("#dateYear").val() == ""){
          alert("Bulan dan Tahun Tidak Boleh Kosong");
          return false;
        }

        window.location = baseUrl+"/master_keuangan/neraca-detail/"+$("#show").val()+"?m="+$("#dateMonth").val()+"&y="+$("#dateYear").val();
      }

    })
  })

</script>
@endsection
