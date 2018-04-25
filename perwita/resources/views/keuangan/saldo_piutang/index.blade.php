@extends('main')

@section('title', 'dashboard')

@section("extra_styles")
  
  <link href="{{ asset('assets/vendors/bootstrap-treegrid/css/jquery.treegrid.css') }}" rel="stylesheet">

  <style>

    body{
      overflow-y: scroll;
    }

    .modal-open{
      overflow: inherit;
    }

     #table_form input{
      padding-left: 5px;
    }

    #table_form td,
    #table_form th{
      padding:10px 0px;
    }

    .table-form{
      border-collapse: collapse;
    }

    .table-form th{
      font-weight: 600;
    }

    .table-form th,
    .table-form td{
      padding: 2px 0px;
    }

    .table-form input{
      font-size: 10pt;
    }

    .table-detail{
      font-size: 8pt;
    }

    .table-detail td,
    .table-detail th{
      border: 1px solid #bbb;
    }

    .table-detail th{
      padding: 3px 0px 10px 0px;
      background: white;
      position: sticky;
      top: 0px;
    }

    .table-detail tfoot th{
      position: sticky;
      bottom:0px;
    }

    .table-detail td{
      padding: 5px;
    }

    .row-detail{
      cursor: pointer;
    }

    .row-detail:hover{
      background: #1b82cf;
      color: #fff;
    }

  </style>
@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-10">
          <h2> Saldo Piutang </h2>
          <ol class="breadcrumb">
              <li>
                  <a>Home</a>
              </li>
              <li>
                  <a>Keuangan</a>
              </li>
              <li class="active">
                  <strong> Saldo Awal Piutang </strong>
              </li>

          </ol>
      </div>
      <div class="col-lg-12" style="border: 1px solid #eee; margin-top: 15px;">
        <table border="0" width="100%" id="table_form">
          <tr>
            <th width="15%" class="text-center">Menampilkan Cabang : </th>
            <td width="17%">

              @if(Session::get('cabang') == 000)
                <select class="chosen-select" id="cabang" name="cabang" style="background:;">
                  @foreach ($cab as $cabangs)
                    <?php
                      $selected = "";
                      if($cabangs->kode == $cabang)
                        $selected = "selected";
                    ?>

                    <option value="{{ $cabangs->kode }}" {{ $selected }}>{{ $cabangs->nama }}</option>
                  @endforeach
                </select>
              @else
                
                <input type="hidden" class="form-control" id="cabang" name="cabang" style="background:; font-size: 10pt; padding-left: 10px;" value="{{ Session::get('cabang') }}" readonly>

                <input type="text" class="form-control" id="aa" name="aa" style="background:; font-size: 10pt; padding-left: 10px; width: 90%;" value="{{ Session::get('namaCabang') }}" readonly>

              @endif
            </td>

            <td>
              <button class="btn btn-success btn-sm" id="filter">Filter</button>
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
                    <h5> Data Saldo Awal Akun
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        {{-- <button class="btn btn-sm btn-success" id="collapsed" data-toggle="tooltip" data-placement="top" title="Sembunyikan Semua Sub Akun">
                          <i class="fa fa-archive fa-fw"></i>
                        </button>
                        
                        <button class="btn btn-sm btn-success" id="expand" data-toggle="tooltip" data-placement="top" title="Tampilkan Semua Sub Akun">
                          <i class="fa fa-code-fork fa-fw"></i>
                        </button> --}}

                        <button class="btn btn-sm btn-primary tambahAkun" data-parrent="10" data-toggle="modal" data-target="#modal_tambah_akun">
                          <i class="fa fa-plus"></i> &nbsp;Tambah Data Saldo Piutang
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
                        <th style="padding:8px 0px" class="text-center">No</th>
                        <th style="padding:8px 0px" class="text-center">Periode</th>
                        <th width="18%" style="padding:8px 0px" class="text-center">Kode Customer</th>
                        <th width="35%" style="padding:8px 0px" class="text-center">Nama Customer</th>
                        <th style="padding:8px 0px" class="text-center">Saldo Piutang</th>
                        <th style="padding:8px 0px" class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    
                    <tbody id="okee">
                      
                      <?php $no = 1; ?>

                      @foreach($data as $saldo_piutang)
                        <tr>
                          <td class="text-center" width="5%">{{ $no++ }}</td>
                          <td class="text-center" width="10%">{{ date('m/Y') }}</td>
                          <td class="text-center" width="20%">{{ $saldo_piutang->kode_customer }}</td>
                          <td class="text-center">{{ $saldo_piutang->nama_customer }}</td>
                          <td class="text-right" width="15%">{{ number_format($saldo_piutang->jumlah, 2) }}</td>
                          <td class="text-center">
                            <span data-toggle="tooltip" data-placement="top" title="Tampilkan Detail Saldo">
                                <button class="btn btn-xs btn-success tampilkan" data-id="{{ $saldo_piutang->id }}"><i class="fa fa-external-link-square"></i></button>
                            </span>
                          </td>
                        </tr>
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
<div id="modal_tambah_akun" class="modal">
  <div class="modal-dialog" style="width: 60%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Form Tambah Data Saldo Piutang</h4>
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
<div id="modal_view" class="modal">
  <div class="modal-dialog" style="width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Detail Saldo Piutang</h4>
        <input type="hidden" class="parrent"/>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-5">
            <div class="col-md-12" style="background: #fff; padding: 10px; border: 1px solid #ddd;border-radius: 5px;" id="master_saldo_piutang" data-toggle="tooltip" data-placement="top" title="Pastikan Tidak Ada Data Yang Kosong">
              <span class="text-muted" style="position: absolute; background: white; top: -10px; padding: 0px 10px; font-style: italic;"><small>Form Master Saldo Piutang</small></span>
              <form id="customer_form">
                <table width="100%" border="0" class="table-form" style="margin-top: 10px;">
                  <tr>
                    <th>Cabang</th>
                    <td>
                      <input type="text" id="cab_view" class="form-control" readonly>
                    </td>
                  </tr>

                  <tr>
                    <th>Kode Customer</th>
                    <td>
                      <input type="text" class="form-control" id="cust_view" readonly>
                    </td>
                  </tr>

                  <tr>
                    <th>Nama</th>
                    <td>
                      <input type="text" class="form-control" id="nama_cust_view" placeholder="" style="height: 30px;" disabled>
                    </td>
                  </tr>

                  <tr>
                    <th>Alamat</th>
                    <td>
                      <input type="text" class="form-control" id="alamat_cust_view" placeholder="" style="height: 30px;" disabled>
                    </td>
                  </tr>

                  <tr>
                    <th>Periode</th>
                    <td>
                      <input type="text" class="form-control" id="periode_view" placeholder="Bulan/Tahun" style="height: 30px; cursor: pointer; background: white;" readonly name="periode" readonly value="{{ date("m/Y") }}">
                    </td>
                  </tr>

                  <tr>
                    <th>Saldo Awal</th>
                    <td>
                      <input type="text" class="form-control currency" id="saldo_awal_view" placeholder="0" style="height: 30px; text-align: right;" readonly>
                    </td>
                  </tr>

                </table>
              </form>
            </div>

            <div class="col-md-12" style="background: #fff; padding: 10px; border: 1px solid #ddd;border-radius: 5px; margin-top: 25px;" id="detail_saldo_piutang" data-toggle="tooltip" data-placement="top" title="Pastikan Tidak Ada Data Yang Kosong">
              <span class="text-muted" style="position: absolute; background: white; top: -10px; padding: 0px 10px; font-style: italic;"><small>Form Detail Saldo Piutang</small></span>

              <span class="text-muted" style="position: absolute; background: white; top: -10px; right: -5px; padding: 0px 0px; font-style: italic;"><small><i class="fa fa-arrow-right"></i> <i class="fa fa-arrow-right"></i> <i class="fa fa-arrow-right"></i></small></span>
              <table width="100%" border="0" class="table-form" style="margin-top: 10px;" id="table-datail">
                <tr>
                  <th>Nomor Faktur</th>
                  <td>
                    <input type="text" class="form-control" placeholder="Masukkan Nomor Faktur" style="height: 30px;" id="nomor_faktur_view" readonly>
                  </td>
                </tr>

                <tr>
                  <th>Tanggal Faktur</th>
                  <td>
                    <input type="text" class="form-control" placeholder="Tanggal/Bulan/Tahun" style="height: 30px; cursor: pointer;background: white;" readonly id="tanggal_faktur_view" readonly>
                  </td>
                </tr>

                <tr>
                  <th>Jatuh Tempo</th>
                  <td>
                    <input type="text" class="form-control" placeholder="Tanggal/Bulan/Tahun" style="height: 30px;cursor: pointer;background: white;" readonly id="jatuh_tempo_view" readonly>
                  </td>
                </tr>

                <tr>
                  <th>Keterangan</th>
                  <td>
                    <input type="text" class="form-control" placeholder="" style="height: 30px;" id="keterangan_view" readonly>
                  </td>
                </tr>

                <tr>
                  <th>Jumlah</th>
                  <td>
                    <input type="text" class="form-control currency" placeholder="0" style="height: 30px; text-align: right;" id="jumlah_view" readonly>
                  </td>
                </tr>

              </table>
            </div>

            <div class="col-md-12 m-t text-right" style="border-top: 1px solid #ddd; padding: 15px 10px 0px 10px">

            </div>

          </div>

          <div class="col-md-7" style="background:; min-height: 300px; padding: 0px;">
            <div class="col-md-12" style="padding: 0px; height: 450px; overflow-y: scroll; border-bottom: 1px solid #bbb;">
              <table border="0" class="table-detail" width="100%">
                <thead>
                  <tr>
                    <th width="18%" class="text-center">Nomor Faktur</th>
                    <th width="13%" class="text-center">Tanggal</th>
                    <th width="14%"class="text-center">Jatuh Tempo</th>
                    <th class="text-center">Keterangan</th>
                    <th width="19%" class="text-center">Jumlah</th>
                  </tr>
                </thead>

                <tbody id="body_detail">
                  
                    

                </tbody>
              </table>
            </div>

            <div class="col-md-12" style="padding: 0px; margin-top: 8px;">
              <table border="0" class="table-detail" width="100%">
                <tbody>
                  <tr>
                    <td class="text-center" width="79%" colspan="4" style="font-weight: bold;">Grand Total</td>
                    <td class="text-right" id="grand_total"><b></b></td>
                  </tr>
                </tbody>
              </table>
            </div>
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

    saldo_piutang = {!! $datajson !!}; detail = {!! $detailjson !!}; $state = 0;

    $('.tbl-penerimabarang').DataTable({
          responsive: true,
          searching: true,
          sorting: true,
          paging: true,
          //"pageLength": 10,
          "language": dataTableLanguage,
    });

    console.log(detail);

    @if(Session::has('sukses'))
        alert("{{ Session::get('sukses') }}")
    @endif

    $("#filter").click(function(){
      window.location = baseUrl+"/master_keuangan/saldo_piutang/"+$('#cabang').val();
    })

    $('.currency').inputmask("currency", {
        radixPoint: ",",
        groupSeparator: ".",
        digits: 2,
        autoGroup: true,
        prefix: '', //Space after $, this will not truncate the first character.
        rightAlign: false,
        oncleared: function () { self.Value(''); }
    });

    $(".tambahAkun").on("click", function(){
      $("#modal_tambah_akun .modal-header .parrent").val($(this).data("parrent"));
    })

    $("#modal_tambah_akun").on("hidden.bs.modal", function(e){
      $("#modal_tambah_akun .modal-body").html('<center class="text-muted">Menyiapkan Form</center>');
      if($change)
        window.location = baseUrl+"/master_keuangan/saldo_akun";
    })

    $("#modal_tambah_akun").on("shown.bs.modal", function(e){
      //alert($("#modal_tambah_akun .modal-header .parrent").val())

      $.ajax(baseUrl+"/master_keuangan/saldo_piutang/add/"+$("#modal_tambah_akun .modal-header .parrent").val(), {
         timeout: 5000,
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

    $("#okee").on("click", ".tampilkan", function(evt){
      // alert("okee");
      detail_reset();
      evt.stopImmediatePropagation()
      $id = $(this).data("id");

      $("#modal_view").modal("show");

      initiate_saldo(saldo_piutang.findIndex(x => x.id === $id), $id);
    })

    $("#body_detail").on("click", ".row-detail", function(evt){
      evt.stopImmediatePropagation();

      // console.log($data_detail[$getId]);

      $("#nomor_faktur_view").val($(this).data("nf"));
      $("#tanggal_faktur_view").val($(this).data("tanggal"));
      $("#jatuh_tempo_view").val($(this).data("jt"));
      $("#keterangan_view").val($(this).data("keterangan"));
      $("#jumlah_view").val($(this).data("jumlah"));
    });

    function detail_reset(){
      $("#nomor_faktur_view").val("");
      $("#tanggal_faktur_view").val("");
      $("#jatuh_tempo_view").val("");
      $("#keterangan_view").val("");
      $("#jumlah_view").val("");
    }

    function initiate_saldo($idx, $id){
      id = $idx

      $state = id;

      $("#cab_view").val(saldo_piutang[id].nama_cabang);
      $("#cust_view").val(saldo_piutang[id].kode_customer);
      $("#nama_cust_view").val(saldo_piutang[id].nama_customer);
      $("#alamat_cust_view").val(saldo_piutang[id].alamat_customer);
      $("#saldo_awal_view").val(saldo_piutang[id].jumlah);

      initial_detail($id)
    }

    function initial_detail($id){

      $html = ""; $total = 0;
      if(detail.length != 0){
        $.each(detail, function(i, n){
          if(n.id_saldo_piutang == $id){

            $a = n.jenis;

            if($a == "KREDIT"){
              $total -= parseInt(n.jumlah);
              $b = '('+addCommas(n.jumlah)+',00)';
            }
            else{
              $total += parseInt(n.jumlah);
              $b = addCommas(n.jumlah)+',00';
            }

            ket = n.keterangan;

            if(n.keterangan.length >= 28)
              ket = n.keterangan.substring(0, 24)+' ...';

            $faktur = (n.id_referensi == "null") ? "" : n.id_referensi;

            $html = $html + '<tr class="row-detail" data-nf = "'+$faktur+'" data-tanggal = "'+n.tanggal+'" data-jt = "'+n.jatuh_tempo+'" data-keterangan = "'+n.keterangan+'" data-jumlah = "'+$b+'">'+
                  '<td>'+$faktur+'</td>'+
                  '<td class="text-center">'+n.tanggal+'</td>'+
                  '<td class="text-center">'+n.jatuh_tempo+'</td>'+
                  '<td>'+ket+'</td>'+
                  '<td class="text-right">'+$b+'</td>'+
                '</tr>';
          }
        })

        $("#saldo_awal").val($total);
        $("#grand_total b").text(addCommas($total)+",00");
        $("#body_detail").html($html);
      }else{
        $html = $html + '<tr>'+
                      '<td colspan="5" class="text-center text-muted"><small>Tidak Ada Detail</small></td>'+
                    '</tr>';

        $("#body_detail").html($html);
      }

    }

  })

  function addCommas(nStr) {
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + '.' + '$2');
      }
      return x1 + x2;
    }

</script>
@endsection