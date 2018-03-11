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
        <table border="0" width="100%" id="table_form">
          <tr>
            <th width="5%" class="text-center">Per : </th>
            <td width="25%">
              {{--<select style="width:35%">
                <option>Hari Ini</option>
                <option>Kemarin</option>
              </select>--}}
              <input type="text" value="{{ date("d/m/Y") }}" style="width:50%">

            </td>

            <th width="12%" class="text-center">Bandingkan Periode : </th>
            <td width="25%">
              <input type="text" value="{{ date("d/m/Y") }}" style="width:40%">

              <input type="text" value="{{ date("d/m/Y") }}" style="width:40%">
            </td>

            <td width="10%">
              <button class="btn btn-success btn-sm">Filter</button>
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
                    <h5> Menampilkan Neraca Pada Tanggal {{ date("d/m/Y") }}
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        <button class="btn btn-sm btn-primary tambahAkun" data-parrent="0" data-toggle="modal" data-target="#modal_tambah_akun">
                          <i class="fa fa-plus"></i> &nbsp;Cetak PDF
                        </button>

                        <button class="btn btn-sm btn-primary tambahAkun" data-parrent="0" data-toggle="modal" data-target="#modal_tambah_akun">
                          <i class="fa fa-pdf"></i> &nbsp;Cetak Excel
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
                                          <?php $DatatotalAktiva = 0; $totalHeader = 0;?>
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
                                                        $show = ($totalHeader < 0) ? "(".number_format($totalHeader).")" : number_format($totalHeader); 
                                                      ?>

                                                      <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                    @endif
                                                  </tr>
                                                @endif

                                              <?php $DatatotalAktiva+= $dataAktiva["total"]; $totalHeader+= $dataAktiva["total"]; ?>
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
                                          <?php $DatatotalPasiva = 0; $totalHeader = 0;?>
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
                                                        $show = ($totalHeader < 0) ? "(".number_format($totalHeader).")" : number_format($totalHeader); 
                                                      ?>

                                                      <td class="text-right {{ $total }}">{{ str_replace("-", "", $show) }}</td>
                                                    @endif
                                                  </tr>
                                                @endif

                                              <?php $DatatotalPasiva+= $dataAktiva["total"]; $totalHeader+= $dataAktiva["total"]; ?>
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

             $('body').removeClass('fixed-sidebar');
            $("body").toggleClass("mini-navbar");
  })

</script>
@endsection





