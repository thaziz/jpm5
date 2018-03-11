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

<div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-10">
          <h2> Laporan Neraca </h2>
          <ol class="breadcrumb">
              <li>
                  <a>Home</a>
              </li>
              <li>
                  <a>Keuangan</a>
              </li>
              <li class="active">
                  <strong> Laporan Neraca  </strong>
              </li>

          </ol>
      </div>

      <div class="col-lg-12" style="border: 1px solid #eee; margin-top: 15px;">
        <table border="0" width="83%" id="table_form">
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
                <option value="perbandingan_bulan">Perbandingan Bulanan</option>
                <option value="perbandingan_tahun">Perbandingan Tahunan</option>
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
                      <h5> Menampilkan Neraca Periode Bulan {{ $request["m"]."/".$request["y"] }}</h5>
                    @elseif($throttle == "tahun")
                      <h5> Menampilkan Neraca Periode Tahun {{ $request["y"] }}</h5>
                    @elseif($throttle == "perbandingan_bulan")
                      <h5> Menampilkan Perbandingan Neraca Bulan {{ $request["m"] }} Dan Bulan {{ $request["y"] }}</h5>
                    @elseif($throttle == "perbandingan_tahun")
                      <h5> Menampilkan Perbandingan Neraca Tahun {{ $request["m"] }} Dan Tahun {{ $request["y"] }}</h5>
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
                            @if($throttle == "perbandingan_bulan")
                              <div class="row-eq-height">
                                <div class="col-md-6">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th colspan="2" class="text-center">Aktiva</th>
                                        </tr>

                                      </thead> 

                                      <tbody>
                                        <td style="border: 1px solid #ccc">
                                          <table width="100%" style="border: 0px solid red" id="bingkai">
                                            <tr>
                                              <?php $DatatotalAktiva1 = 0; $tot1 = 0;?>
                                              @foreach($datat1 as $dataAktiva)
                                                <?php 
                                                  $header = ""; $child = ""; $total = ""; 

                                                  if($dataAktiva["jenis"] == 1){
                                                    $header = "header"; $totalHeader = 0;
                                                  }

                                                  if($dataAktiva["parrent"] != "")
                                                    $child = "child";

                                                  if($dataAktiva["jenis"] == 3)
                                                    $total = "total";
                                                ?>


                                                @if($dataAktiva["type"] == "aktiva")
                                                  
                                                    @if($dataAktiva["jenis"] == "4")
                                                      <tr><td colspan="2">&nbsp;</td></tr>
                                                    @else
                                                      <tr>
                                                        <td class="{{ $header." ".$child." ".$total }} no-border" width="70%">{{ $dataAktiva["nama_perkiraan"] }}</td>
                                                        @if($dataAktiva["jenis"] == 2)

                                                          <?php 
                                                            $show = ($dataAktiva["total"] < 0) ? "(".number_format($dataAktiva["total"]).")" : number_format($dataAktiva["total"]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @elseif($dataAktiva["jenis"] == 3)
                                                          <?php 
                                                            $show = ($mydatatotal1[$dataAktiva["nomor_id"]] < 0) ? "(".number_format($mydatatotal1[$dataAktiva["nomor_id"]]).")" : number_format($mydatatotal1[$dataAktiva["nomor_id"]]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @endif
                                                      </tr>
                                                    @endif

                                                  <?php 
                                                    $DatatotalAktiva1 += $dataAktiva["total"];
                                                    if($dataAktiva["jenis"] == 3)
                                                      $tot1++;
                                                  ?>
                                                @endif

                                              @endforeach
                                            </tr>
                                          </table>
                                        </td>
                                      </tbody>           
                                  </table>
                                </div>

                                <div class="col-md-6">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th colspan="2" class="text-center">Aktiva</th>
                                        </tr>

                                      </thead> 

                                      <tbody>
                                        <td style="border: 1px solid #ccc">
                                          <table width="100%" style="border: 0px solid red" id="bingkai">
                                            <tr>
                                              <?php $DatatotalAktiva2 = 0; $tot2 = 0;?>
                                              @foreach($datat2 as $dataAktiva)
                                                <?php 
                                                  $header = ""; $child = ""; $total = ""; 

                                                  if($dataAktiva["jenis"] == 1){
                                                    $header = "header"; $totalHeader = 0;
                                                  }

                                                  if($dataAktiva["parrent"] != "")
                                                    $child = "child";

                                                  if($dataAktiva["jenis"] == 3)
                                                    $total = "total";
                                                ?>


                                                @if($dataAktiva["type"] == "aktiva")
                                                  
                                                    @if($dataAktiva["jenis"] == "4")
                                                      <tr><td colspan="2">&nbsp;</td></tr>
                                                    @else
                                                      <tr>
                                                        <td class="{{ $header." ".$child." ".$total }} no-border" width="70%">{{ $dataAktiva["nama_perkiraan"] }}</td>
                                                        @if($dataAktiva["jenis"] == 2)

                                                          <?php 
                                                            $show = ($dataAktiva["total"] < 0) ? "(".number_format($dataAktiva["total"]).")" : number_format($dataAktiva["total"]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @elseif($dataAktiva["jenis"] == 3)
                                                          <?php 
                                                            $show = ($mydatatotal2[$dataAktiva["nomor_id"]] < 0) ? "(".number_format($mydatatotal2[$dataAktiva["nomor_id"]]).")" : number_format($mydatatotal2[$dataAktiva["nomor_id"]]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @endif
                                                      </tr>
                                                    @endif

                                                  <?php 
                                                    $DatatotalAktiva2 += $dataAktiva["total"];
                                                    if($dataAktiva["jenis"] == 3)
                                                      $tot2++;
                                                  ?>
                                                @endif

                                              @endforeach
                                            </tr>
                                          </table>
                                        </td>
                                      </tbody>           
                                  </table>
                                </div>
                              </div>

                              <div class="row-eq-height">
                                <div class="col-md-6">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th class="text-center" width="70%">Total Akhir Aktiva</th>
                                          <th class="text-right">{{ ($DatatotalAktiva1 < 0) ? str_replace("-", "", "(".number_format($DatatotalAktiva1).")") : number_format($DatatotalAktiva1) }}</th>
                                        </tr>
                                      </thead>         
                                  </table>
                                </div>

                                <div class="col-md-6">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th class="text-center" width="70%">Total Akhir Aktiva</th>
                                          <th class="text-right">{{ ($DatatotalAktiva2 < 0) ? str_replace("-", "", "(".number_format($DatatotalAktiva2).")") : number_format($DatatotalAktiva2) }}</th>
                                        </tr>
                                      </thead>       
                                  </table>
                                </div>
                              </div>

                              <div class="row-eq-height"> 
                                <div class="col-md-6 m-t-lg">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th colspan="2" class="text-center">Pasiva</th>
                                        </tr>

                                      </thead> 

                                      <tbody>
                                        <td style="border: 1px solid #ccc">
                                          <table width="100%" style="border: 0px solid red" id="bingkai">
                                            <tr>
                                              <?php $DatatotalPasiva1 = 0;?>
                                              @foreach($datat1 as $dataAktiva)
                                                <?php 
                                                  $header = ""; $child = ""; $total = ""; 

                                                  if($dataAktiva["jenis"] == 1){
                                                    $header = "header";
                                                  }

                                                  if($dataAktiva["parrent"] != "")
                                                    $child = "child";

                                                  if($dataAktiva["jenis"] == 3)
                                                    $total = "total";
                                                ?>


                                                @if($dataAktiva["type"] == "pasiva")
                                                  
                                                    @if($dataAktiva["jenis"] == "4")
                                                      <tr><td colspan="2">&nbsp;</td></tr>
                                                    @else
                                                      <tr>
                                                        <td class="{{ $header." ".$child." ".$total }} no-border" width="70%">{{ $dataAktiva["nama_perkiraan"] }}</td>
                                                        @if($dataAktiva["jenis"] == 2)

                                                          <?php 
                                                            $show = ($dataAktiva["total"] < 0) ? "(".number_format($dataAktiva["total"]).")" : number_format($dataAktiva["total"]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @elseif($dataAktiva["jenis"] == 3)
                                                          <?php 
                                                            $show = ($mydatatotal1[$dataAktiva["nomor_id"]] < 0) ? "(".number_format($mydatatotal1[$dataAktiva["nomor_id"]]).")" : number_format($mydatatotal1[$dataAktiva["nomor_id"]]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @endif
                                                      </tr>
                                                    @endif

                                                  <?php 
                                                    $DatatotalPasiva1+= $dataAktiva["total"]; 
                                                    if($dataAktiva["jenis"] == 3)
                                                      $tot1++;
                                                  ?>
                                                @endif

                                              @endforeach
                                            </tr>
                                          </table>
                                        </td>
                                      </tbody>           
                                  </table>
                                </div>

                                <div class="col-md-6 m-t-lg">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th colspan="2" class="text-center">Pasiva</th>
                                        </tr>

                                      </thead> 

                                      <tbody>
                                        <td style="border: 1px solid #ccc">
                                          <table width="100%" style="border: 0px solid red" id="bingkai">
                                            <tr>
                                              <?php $DatatotalPasiva2 = 0;?>
                                              @foreach($datat2 as $dataAktiva)
                                                <?php 
                                                  $header = ""; $child = ""; $total = ""; 

                                                  if($dataAktiva["jenis"] == 1){
                                                    $header = "header";
                                                  }

                                                  if($dataAktiva["parrent"] != "")
                                                    $child = "child";

                                                  if($dataAktiva["jenis"] == 3)
                                                    $total = "total";
                                                ?>


                                                @if($dataAktiva["type"] == "pasiva")
                                                  
                                                    @if($dataAktiva["jenis"] == "4")
                                                      <tr><td colspan="2">&nbsp;</td></tr>
                                                    @else
                                                      <tr>
                                                        <td class="{{ $header." ".$child." ".$total }} no-border" width="70%">{{ $dataAktiva["nama_perkiraan"] }}</td>
                                                        @if($dataAktiva["jenis"] == 2)

                                                          <?php 
                                                            $show = ($dataAktiva["total"] < 0) ? "(".number_format($dataAktiva["total"]).")" : number_format($dataAktiva["total"]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @elseif($dataAktiva["jenis"] == 3)
                                                          <?php 
                                                            $show = ($mydatatotal2[$dataAktiva["nomor_id"]] < 0) ? "(".number_format($mydatatotal2[$dataAktiva["nomor_id"]]).")" : number_format($mydatatotal2[$dataAktiva["nomor_id"]]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @endif
                                                      </tr>
                                                    @endif

                                                  <?php 
                                                    $DatatotalPasiva2+= $dataAktiva["total"]; 
                                                    if($dataAktiva["jenis"] == 3)
                                                      $tot1++;
                                                  ?>
                                                @endif

                                              @endforeach
                                            </tr>
                                          </table>
                                        </td>
                                      </tbody>           
                                  </table>
                                </div>
                              </div>

                              <div class="row-eq-height">
                                <div class="col-md-6">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th class="text-center" width="70%">Total Akhir Pasiva</th>
                                          <th class="text-right">{{ ($DatatotalPasiva1 < 0) ? str_replace("-", "", "(".number_format($DatatotalPasiva1).")") : number_format($DatatotalPasiva1) }}</th>
                                        </tr>
                                      </thead>         
                                  </table>
                                </div>

                                <div class="col-md-6">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th class="text-center" width="70%">Total Akhir Pasiva</th>
                                          <th class="text-right">{{ ($DatatotalPasiva2 < 0) ? str_replace("-", "", "(".number_format($DatatotalPasiva2).")") : number_format($DatatotalPasiva2) }}</th>
                                        </tr>
                                      </thead>         
                                  </table>
                                </div>
                              </div>

                            @elseif($throttle == "perbandingan_tahun")
                              <div class="row-eq-height">
                                <div class="col-md-6">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th colspan="2" class="text-center">Aktiva</th>
                                        </tr>

                                      </thead> 

                                      <tbody>
                                        <td style="border: 1px solid #ccc">
                                          <table width="100%" style="border: 0px solid red" id="bingkai">
                                            <tr>
                                              <?php $DatatotalAktiva1 = 0; $tot1 = 0;?>
                                              @foreach($datat1 as $dataAktiva)
                                                <?php 
                                                  $header = ""; $child = ""; $total = ""; 

                                                  if($dataAktiva["jenis"] == 1){
                                                    $header = "header"; $totalHeader = 0;
                                                  }

                                                  if($dataAktiva["parrent"] != "")
                                                    $child = "child";

                                                  if($dataAktiva["jenis"] == 3)
                                                    $total = "total";
                                                ?>


                                                @if($dataAktiva["type"] == "aktiva")
                                                  
                                                    @if($dataAktiva["jenis"] == "4")
                                                      <tr><td colspan="2">&nbsp;</td></tr>
                                                    @else
                                                      <tr>
                                                        <td class="{{ $header." ".$child." ".$total }} no-border" width="70%">{{ $dataAktiva["nama_perkiraan"] }}</td>
                                                        @if($dataAktiva["jenis"] == 2)

                                                          <?php 
                                                            $show = ($dataAktiva["total"] < 0) ? "(".number_format($dataAktiva["total"]).")" : number_format($dataAktiva["total"]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @elseif($dataAktiva["jenis"] == 3)
                                                          <?php 
                                                            $show = ($mydatatotal1[$dataAktiva["nomor_id"]] < 0) ? "(".number_format($mydatatotal1[$dataAktiva["nomor_id"]]).")" : number_format($mydatatotal1[$dataAktiva["nomor_id"]]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @endif
                                                      </tr>
                                                    @endif

                                                  <?php 
                                                    $DatatotalAktiva1 += $dataAktiva["total"];
                                                    if($dataAktiva["jenis"] == 3)
                                                      $tot1++;
                                                  ?>
                                                @endif

                                              @endforeach
                                            </tr>
                                          </table>
                                        </td>
                                      </tbody>           
                                  </table>
                                </div>

                                <div class="col-md-6">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th colspan="2" class="text-center">Aktiva</th>
                                        </tr>

                                      </thead> 

                                      <tbody>
                                        <td style="border: 1px solid #ccc">
                                          <table width="100%" style="border: 0px solid red" id="bingkai">
                                            <tr>
                                              <?php $DatatotalAktiva2 = 0; $tot2 = 0;?>
                                              @foreach($datat2 as $dataAktiva)
                                                <?php 
                                                  $header = ""; $child = ""; $total = ""; 

                                                  if($dataAktiva["jenis"] == 1){
                                                    $header = "header"; $totalHeader = 0;
                                                  }

                                                  if($dataAktiva["parrent"] != "")
                                                    $child = "child";

                                                  if($dataAktiva["jenis"] == 3)
                                                    $total = "total";
                                                ?>


                                                @if($dataAktiva["type"] == "aktiva")
                                                  
                                                    @if($dataAktiva["jenis"] == "4")
                                                      <tr><td colspan="2">&nbsp;</td></tr>
                                                    @else
                                                      <tr>
                                                        <td class="{{ $header." ".$child." ".$total }} no-border" width="70%">{{ $dataAktiva["nama_perkiraan"] }}</td>
                                                        @if($dataAktiva["jenis"] == 2)

                                                          <?php 
                                                            $show = ($dataAktiva["total"] < 0) ? "(".number_format($dataAktiva["total"]).")" : number_format($dataAktiva["total"]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @elseif($dataAktiva["jenis"] == 3)
                                                          <?php 
                                                            $show = ($mydatatotal2[$dataAktiva["nomor_id"]] < 0) ? "(".number_format($mydatatotal2[$dataAktiva["nomor_id"]]).")" : number_format($mydatatotal2[$dataAktiva["nomor_id"]]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @endif
                                                      </tr>
                                                    @endif

                                                  <?php 
                                                    $DatatotalAktiva2 += $dataAktiva["total"];
                                                    if($dataAktiva["jenis"] == 3)
                                                      $tot2++;
                                                  ?>
                                                @endif

                                              @endforeach
                                            </tr>
                                          </table>
                                        </td>
                                      </tbody>           
                                  </table>
                                </div>
                              </div>

                              <div class="row-eq-height">
                                <div class="col-md-6">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th class="text-center" width="70%">Total Akhir Aktiva</th>
                                          <th class="text-right">{{ ($DatatotalAktiva1 < 0) ? str_replace("-", "", "(".number_format($DatatotalAktiva1).")") : number_format($DatatotalAktiva1) }}</th>
                                        </tr>
                                      </thead>         
                                  </table>
                                </div>

                                <div class="col-md-6">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th class="text-center" width="70%">Total Akhir Aktiva</th>
                                          <th class="text-right">{{ ($DatatotalAktiva2 < 0) ? str_replace("-", "", "(".number_format($DatatotalAktiva2).")") : number_format($DatatotalAktiva2) }}</th>
                                        </tr>
                                      </thead>       
                                  </table>
                                </div>
                              </div>

                              <div class="row-eq-height"> 
                                <div class="col-md-6 m-t-lg">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th colspan="2" class="text-center">Pasiva</th>
                                        </tr>

                                      </thead> 

                                      <tbody>
                                        <td style="border: 1px solid #ccc">
                                          <table width="100%" style="border: 0px solid red" id="bingkai">
                                            <tr>
                                              <?php $DatatotalPasiva1 = 0;?>
                                              @foreach($datat1 as $dataAktiva)
                                                <?php 
                                                  $header = ""; $child = ""; $total = ""; 

                                                  if($dataAktiva["jenis"] == 1){
                                                    $header = "header";
                                                  }

                                                  if($dataAktiva["parrent"] != "")
                                                    $child = "child";

                                                  if($dataAktiva["jenis"] == 3)
                                                    $total = "total";
                                                ?>


                                                @if($dataAktiva["type"] == "pasiva")
                                                  
                                                    @if($dataAktiva["jenis"] == "4")
                                                      <tr><td colspan="2">&nbsp;</td></tr>
                                                    @else
                                                      <tr>
                                                        <td class="{{ $header." ".$child." ".$total }} no-border" width="70%">{{ $dataAktiva["nama_perkiraan"] }}</td>
                                                        @if($dataAktiva["jenis"] == 2)

                                                          <?php 
                                                            $show = ($dataAktiva["total"] < 0) ? "(".number_format($dataAktiva["total"]).")" : number_format($dataAktiva["total"]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @elseif($dataAktiva["jenis"] == 3)
                                                          <?php 
                                                            $show = ($mydatatotal1[$dataAktiva["nomor_id"]] < 0) ? "(".number_format($mydatatotal1[$dataAktiva["nomor_id"]]).")" : number_format($mydatatotal1[$dataAktiva["nomor_id"]]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @endif
                                                      </tr>
                                                    @endif

                                                  <?php 
                                                    $DatatotalPasiva1+= $dataAktiva["total"]; 
                                                    if($dataAktiva["jenis"] == 3)
                                                      $tot1++;
                                                  ?>
                                                @endif

                                              @endforeach
                                            </tr>
                                          </table>
                                        </td>
                                      </tbody>           
                                  </table>
                                </div>

                                <div class="col-md-6 m-t-lg">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th colspan="2" class="text-center">Pasiva</th>
                                        </tr>

                                      </thead> 

                                      <tbody>
                                        <td style="border: 1px solid #ccc">
                                          <table width="100%" style="border: 0px solid red" id="bingkai">
                                            <tr>
                                              <?php $DatatotalPasiva2 = 0;?>
                                              @foreach($datat2 as $dataAktiva)
                                                <?php 
                                                  $header = ""; $child = ""; $total = ""; 

                                                  if($dataAktiva["jenis"] == 1){
                                                    $header = "header";
                                                  }

                                                  if($dataAktiva["parrent"] != "")
                                                    $child = "child";

                                                  if($dataAktiva["jenis"] == 3)
                                                    $total = "total";
                                                ?>


                                                @if($dataAktiva["type"] == "pasiva")
                                                  
                                                    @if($dataAktiva["jenis"] == "4")
                                                      <tr><td colspan="2">&nbsp;</td></tr>
                                                    @else
                                                      <tr>
                                                        <td class="{{ $header." ".$child." ".$total }} no-border" width="70%">{{ $dataAktiva["nama_perkiraan"] }}</td>
                                                        @if($dataAktiva["jenis"] == 2)

                                                          <?php 
                                                            $show = ($dataAktiva["total"] < 0) ? "(".number_format($dataAktiva["total"]).")" : number_format($dataAktiva["total"]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @elseif($dataAktiva["jenis"] == 3)
                                                          <?php 
                                                            $show = ($mydatatotal2[$dataAktiva["nomor_id"]] < 0) ? "(".number_format($mydatatotal2[$dataAktiva["nomor_id"]]).")" : number_format($mydatatotal2[$dataAktiva["nomor_id"]]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @endif
                                                      </tr>
                                                    @endif

                                                  <?php 
                                                    $DatatotalPasiva2+= $dataAktiva["total"]; 
                                                    if($dataAktiva["jenis"] == 3)
                                                      $tot2++;
                                                  ?>
                                                @endif

                                              @endforeach
                                            </tr>
                                          </table>
                                        </td>
                                      </tbody>           
                                  </table>
                                </div>
                              </div>

                              <div class="row-eq-height">
                                <div class="col-md-6">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th class="text-center" width="70%">Total Akhir Pasiva</th>
                                          <th class="text-right">{{ ($DatatotalPasiva1 < 0) ? str_replace("-", "", "(".number_format($DatatotalPasiva1).")") : number_format($DatatotalPasiva1) }}</th>
                                        </tr>
                                      </thead>         
                                  </table>
                                </div>

                                <div class="col-md-6">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th class="text-center" width="70%">Total Akhir Pasiva</th>
                                          <th class="text-right">{{ ($DatatotalPasiva2 < 0) ? str_replace("-", "", "(".number_format($DatatotalPasiva2).")") : number_format($DatatotalPasiva2) }}</th>
                                        </tr>
                                      </thead>         
                                  </table>
                                </div>
                              </div>
                            @else
                              <div class="row-eq-height">
                                <div class="col-md-6">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th colspan="2" class="text-center">Aktiva</th>
                                        </tr>

                                      </thead> 

                                      <tbody>
                                        <td style="border: 1px solid #ccc">
                                          <table width="100%" style="border: 0px solid red" id="bingkai">
                                            <tr>
                                              <?php $DatatotalAktiva = 0; $tot = 0;?>
                                              @foreach($data as $dataAktiva)
                                                <?php 
                                                  $header = ""; $child = ""; $total = ""; 

                                                  if($dataAktiva["jenis"] == 1){
                                                    $header = "header"; $totalHeader = 0;
                                                  }

                                                  if($dataAktiva["parrent"] != "")
                                                    $child = "child";

                                                  if($dataAktiva["jenis"] == 3)
                                                    $total = "total";
                                                ?>


                                                @if($dataAktiva["type"] == "aktiva")
                                                  
                                                    @if($dataAktiva["jenis"] == "4")
                                                      <tr><td colspan="2">&nbsp;</td></tr>
                                                    @else
                                                      <tr>
                                                        <td class="{{ $header." ".$child." ".$total }} no-border" width="70%">{{ $dataAktiva["nama_perkiraan"] }}</td>
                                                        @if($dataAktiva["jenis"] == 2)

                                                          <?php 
                                                            $show = ($dataAktiva["total"] < 0) ? "(".number_format($dataAktiva["total"]).")" : number_format($dataAktiva["total"]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @elseif($dataAktiva["jenis"] == 3)
                                                          <?php 
                                                            $show = ($mydatatotal[$dataAktiva["nomor_id"]] < 0) ? "(".number_format($mydatatotal[$dataAktiva["nomor_id"]]).")" : number_format($mydatatotal[$dataAktiva["nomor_id"]]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @endif
                                                      </tr>
                                                    @endif

                                                  <?php 
                                                    $DatatotalAktiva += $dataAktiva["total"];
                                                    if($dataAktiva["jenis"] == 3)
                                                      $tot++;
                                                  ?>
                                                @endif

                                              @endforeach
                                            </tr>
                                          </table>
                                        </td>
                                      </tbody>           
                                  </table>
                                </div>


                                <div class="col-md-6">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th colspan="2" class="text-center">Pasiva</th>
                                        </tr>

                                      </thead> 

                                      <tbody>
                                        <td style="border: 1px solid #ccc">
                                          <table width="100%" style="border: 0px solid red" id="bingkai">
                                            <tr>
                                              <?php $DatatotalPasiva = 0;?>
                                              @foreach($data as $dataAktiva)
                                                <?php 
                                                  $header = ""; $child = ""; $total = ""; 

                                                  if($dataAktiva["jenis"] == 1){
                                                    $header = "header";
                                                  }

                                                  if($dataAktiva["parrent"] != "")
                                                    $child = "child";

                                                  if($dataAktiva["jenis"] == 3)
                                                    $total = "total";
                                                ?>


                                                @if($dataAktiva["type"] == "pasiva")
                                                  
                                                    @if($dataAktiva["jenis"] == "4")
                                                      <tr><td colspan="2">&nbsp;</td></tr>
                                                    @else
                                                      <tr>
                                                        <td class="{{ $header." ".$child." ".$total }} no-border" width="70%">{{ $dataAktiva["nama_perkiraan"] }}</td>
                                                        @if($dataAktiva["jenis"] == 2)

                                                          <?php 
                                                            $show = ($dataAktiva["total"] < 0) ? "(".number_format($dataAktiva["total"]).")" : number_format($dataAktiva["total"]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @elseif($dataAktiva["jenis"] == 3)
                                                          <?php 
                                                            $show = ($mydatatotal[$dataAktiva["nomor_id"]] < 0) ? "(".number_format($mydatatotal[$dataAktiva["nomor_id"]]).")" : number_format($mydatatotal[$dataAktiva["nomor_id"]]); 
                                                          ?>

                                                          <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                        @endif
                                                      </tr>
                                                    @endif

                                                  <?php 
                                                    $DatatotalPasiva+= $dataAktiva["total"]; 
                                                    if($dataAktiva["jenis"] == 3)
                                                      $tot++;
                                                  ?>
                                                @endif

                                              @endforeach
                                            </tr>
                                          </table>
                                        </td>
                                      </tbody>           
                                  </table>
                                </div>
                              </div>

                              <div class="row-eq-height">
                                <div class="col-md-6 m-t">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th class="text-center" width="70%">Total Akhir Aktiva</th>
                                          <th class="text-right">{{ ($DatatotalAktiva < 0) ? str_replace("-", "", "(".number_format($DatatotalAktiva).")") : number_format($DatatotalAktiva) }}</th>
                                        </tr>
                                      </thead>         
                                  </table>
                                </div>

                                <div class="col-md-6 m-t">                           
                                  <table id="tree" width="100%">
                                      <thead>
                                        <tr>
                                          <th class="text-center" width="70%">Total Akhir Pasiva</th>
                                          <th class="text-right">{{ ($DatatotalPasiva < 0) ? str_replace("-", "", "(".number_format($DatatotalPasiva).")") : number_format($DatatotalPasiva) }}</th>
                                        </tr>
                                      </thead>         
                                  </table>
                                </div>
                              </div>
                            @endif

                          <br>

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
    $("#tree").treegrid({
          treeColumn: 0,
          initialState: "expanded",

    });

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
  })

</script>
@endsection





