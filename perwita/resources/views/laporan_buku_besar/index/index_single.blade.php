@extends('main')

@section('title', 'dashboard')

@section("extra_styles")
  
  <link href="{{ asset('assets/vendors/bootstrap-treegrid/css/jquery.treegrid.css') }}" rel="stylesheet">

  <style>
  
    .table_neraca td{
      font-weight: 400;
      padding: 7px;
      border-top:1px dotted #efefef;
    }

    .table_neraca td.money{
      text-align: right;
    }

    .table_neraca th{
      font-weight: 600;
      text-align: center;
      padding: 5px;
      border:1px solid #efefef;
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
          <h2> Laporan Buku Besar </h2>
          <ol class="breadcrumb">
              <li>
                  <a>Home</a>
              </li>
              <li>
                  <a>Laporan</a>
              </li>
              <li>
                  <a>Keuangan</a>
              </li>
              <li class="active">
                  <strong> Laporan Buku Besar  </strong>
              </li>

          </ol>
      </div>

      <div class="col-lg-12" style="border: 1px solid #eee; margin-top: 15px;">
        <table border="0" id="form-table" class="col-md-10">
        <tr>
          <td width="10%" class="text-center">Tampilkan : </td>
          <td width="15%">
            <select class="form-control" style="width:90%; height: 30px" id="tampil">
                <option value="bulan">Buku Besar Bulan</option>
                <option value="tahun">Buku Besar Tahun</option>
              </select>
          </td>

          <td width="10%">
            <input class="form-control text-center date" style="width:90%; height: 30px; cursor: pointer; background: #fff; display:none;" readonly data-toggle="tooltip" id="bulan" placeholder="Pilih Bulan">

            <input class="form-control text-center date_year" style="width:90%; height: 30px; cursor: pointer; background: #fff; display:none;" readonly data-toggle="tooltip" id="bulan_1" placeholder="Pilih Bulan Ke-1">

            <input class="form-control text-center year" style="width:90%; height: 30px; cursor: pointer; background: #fff; display:none;" readonly data-toggle="tooltip" id="tahun_1" placeholder="Pilih Tahun Ke-1">

          </td>

          <td width="10%">
            <input class="form-control text-center year" style="width:90%; height: 30px; cursor: pointer; background: #fff; display:none;" readonly data-toggle="tooltip" id="tahun" placeholder="Pilih Tahun">

            <input class="form-control text-center date_year" style="width:90%; height: 30px; cursor: pointer; background: #fff; display:none;" readonly data-toggle="tooltip" id="bulan_2" placeholder="Pilih Bulan Ke-2">

            <input class="form-control text-center year" style="width:90%; height: 30px; cursor: pointer; background: #fff; display:none;" readonly data-toggle="tooltip" id="tahun_2" placeholder="Pilih Tahun Ke-2">
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
                      <h5 id="title_in"></h5>

                    <div class="ibox-tools">
                        <a href="{{ route("neraca.pdf_single", $throttle."?m=".$request["m"]."&y=".$request["y"]) }}" target="_blank">
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
  
                     {{-- Buku Besar START --}}

                    <div class="col-md-12">

                      <div class="col-md-12" style="border: 1px solid #eee; box-shadow: 0px 0px 10px #eee; padding: 0px;">
                      
                      <?php $urt = 0; ?>

                      @foreach($data as $data_akun)
                          <?php $mt = ($urt == 0) ? "m-t" : "m-t-lg"; $saldo = $saldo_awal[$data_akun->akun]; ?>

                          <div class="col-md-4 col-md-offset-8 text-left {{ $mt }}" style="font-size: 8pt; padding: 10px;">
                            <b>Nama Perkiraan : {{ $data_akun->akun }} {{ $data_akun->main_name }}</b>
                          </div>
                          
                          <div class="col-md-12">
                            <table class="table_neraca tree" border="0" width="100%" style="font-size: 8pt; border-bottom: 2px solid #efefef; margin-bottom: 5px;">
                              <thead>
                                <tr>
                                  <th width="10%">Tanggal</th>
                                  <th width="14%">No.Bukti</th>
                                  <th width="40%">Keterangan</th>
                                  <th width="12%">Debet</th>
                                  <th width="12%">Kredit</th>
                                  <th width="12%">Saldo</th>
                                </tr>
                              </thead>

                              <tbody>

                                <tr>
                                  <td class="text-center"></td>
                                  <td class="text-center"></td>
                                  <td style="padding-left: 50px;">Saldo Awal</td>
                                  <td class="money"></td>
                                  <td class="money"></td>
                                  <td class="money">{{ number_format($saldo, 2) }}</td>
                                </tr>

                                @foreach($grap as $data_grap)
                                  @if($data_grap->acc == $data_akun->akun)

                                    <?php 
                                      $debet = 0; $kredit = 0;

                                      $saldo += $data_grap->jrdt_value;

                                      if($data_grap->jrdt_statusdk == "D")
                                        $debet = str_replace("-", "", $data_grap->jrdt_value);
                                      else
                                        $kredit = str_replace("-", "", $data_grap->jrdt_value);

                                    ?>

                                    <tr>
                                      <td class="text-center">{{ date("d-m-Y", strtotime($data_grap->jr_date)) }}</td>
                                      <td class="text-center">{{ $data_grap->jr_ref }}</td>
                                      <td>{{ $data_grap->jr_note }}</td>
                                      <td class="money">{{ number_format($debet, 2) }}</td>
                                      <td class="money">{{ number_format($kredit, 2) }}</td>
                                      <td class="money">{{ number_format($saldo, 2) }}</td>
                                    </tr>
                                  @endif
                                @endforeach
                                
                              </tbody>
                            </table>
                          </div>

                          <?php $urt++; ?>
                      @endforeach

                      </div>
                      
                    </div>

                    {{-- Buku Besar END --}}

                  </div>
            </div>
        </div>
    </div>
</div>

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


   throttle = "{{ $throttle }}"; req1 = "{{ date_ind($request->m) }}"; req2 = "{{ $request->y }}";

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
      $("#title_in").text("Menampilkan Buku Besar Periode Bulan "+req1+" "+req2);
      $("#bulan").css("display", "inline-block"); $("#tahun").css("display", "inline-block");
      $("#bulan").val(req1); $("#tahun").val(req2);
      break;
    case "tahun" :
      $("#tampil").val(throttle);
      $("#title_in").text("Menampilkan Buku Besar Periode Tahun "+req2);
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

   $("#set").click(function(evt){
      evt.stopImmediatePropagation();
      evt.preventDefault();

      tampil = $("#tampil").val();

      if(tampil == "bulan"){
        if($("#bulan").val() == "" || $("#tahun").val() == ""){
          toastr.warning('Bulan Dan Tahun Tidak Boleh Kosong');
          return false;
        }else{
          window.location = baseUrl+"/master_keuangan/neraca/single/"+$("#tampil").val()+"?m="+$("#bulan").val()+"&y="+$("#tahun").val();
        }
      }else if(tampil == "tahun"){
        if($("#bulan").val() == "" || $("#tahun").val() == ""){
          toastr.warning('Tahun Tidak Boleh Kosong');
          return false;
        }else{
          window.location = baseUrl+"/master_keuangan/neraca/single/"+$("#tampil").val()+"?m="+$("#bulan").val()+"&y="+$("#tahun").val();
        }
      }else if(tampil == "p_bulan"){
        if($("#bulan_1").val() == "" || $("#bulan_2").val() == ""){
          toastr.warning('Bulan Tidak Boleh Ada Yang Kosong');
          return false;
        }else{
          window.location = baseUrl+"/master_keuangan/neraca/perbandingan/"+$("#tampil").val()+"?m="+$("#bulan_1").val()+"&y="+$("#bulan_2").val();
        }
      }else if(tampil == "p_tahun"){
        if($("#tahun_1").val() == "" || $("#tahun_2").val() == ""){
          toastr.warning('Tahun Tidak Boleh Ada Yang Kosong');
          return false;
        }else{
          window.location = baseUrl+"/master_keuangan/neraca/perbandingan/"+$("#tampil").val()+"?m="+$("#tahun_1").val()+"&y="+$("#tahun_2").val();
        }
      }
   })

  })

</script>
@endsection





