@extends('main')

@section('title', 'dashboard')

@section('content')customer
<style type="text/css">
      .id {display:none; }
      .cssright { text-align: right; }
      .disabled {
        pointer-events: none;
        opacity: 0.7;
        }
       .center{
        text-align: center;
        }
       .right{
        text-align: right;
        }
        td.details-control {
            background: url('{{ asset('assets/img/details_open.png') }}') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('{{ asset('assets/img/details_close.png') }}') no-repeat center center;
        }
        .tabel_coba thead th{
            background: yellow;
        }
        .kecil{
            width: 207px;
        }
        .kanan{
            margin-right: 20px;
        }
        #table_cn_dn tbody tr{
            cursor: pointer;
        }
        .borderless td, .borderless th {
            border: none !important;
          }

        #modal_um {
            overflow-y:scroll;
        }

        .ui-select-placeholder, .ui-select-match-text {
          width: 100%;
          overflow: hidden;
          text-overflow: ellipsis;
          padding-right: 40px;
        }
    </style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> KWITANSI
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>

                     <a href="../sales/penerimaan_penjualan" class="pull-right" style="color: grey; float: right;"><i class="fa fa-arrow-left"> Kembali</i></a>

                </div>
               
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                        <div class="box-body">
                            <div class="row">
                                <table class="table table-striped table-bordered dt-responsive nowrap table-hover">

                            </table>
                        <div class="col-xs-6">

                        </div>
                    </div>
                </form>
                <form id="form_header" class="form-horizontal">
                    <div class="col-sm-6">
                    <table  class="table table-striped table-bordered table-hover tabel_header">
                            <tr>
                                <td style="width:px; padding-top: 0.4cm">Nomor Kwitansi</td>
                                <td colspan="20">
                                    <input type="text" name="nota" id="nota_kwitansi" class="form-control" readonly="readonly" style="text-transform: uppercase" value="" >
                                    <input type="hidden" name="flag_nota" id="flag_nota" class="form-control flag_nota"  readonly="readonly" style="text-transform: uppercase" value="0" >
                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:px; padding-top: 0.4cm">Nomor Trans Bank</td>
                                <td colspan="20">
                                    <input type="text" name="nota_bank" id="nota_bank" class="form-control" readonly="readonly" style="text-transform: uppercase" value="" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td colspan="20">
                                    <div class="input-group date" style="width: 100%">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="ed_tanggal form-control col-xs-12"  name="ed_tanggal" value="{{$tgl}}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px;">Jenis Pembayaran</td>
                                <td colspan="20" class="jenis_pembayaran_td">

                                    <select  class="form-control cb_jenis_pembayaran" onchange="nota_tes()" name="cb_jenis_pembayaran" >
                                        <option value="0">Pilih - Pembayaran</option>
                                        <option value="T"> TUNAI/CASH </option>
                                        <option value="C"> TRANSFER </option>
                                        <option value="U"> UANG MUKA </option>
                                        <option value="B"> NOTA/BIAYA LAIN </option>
                                        <option value="F"> CHEQUE/BG </option>
                                    </select>
                                </td>
                            </tr>
                            @if(Auth::user()->punyaAkses('Kwitansi','cabang'))
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td> 
                                <td colspan="20" class="cabang_td">
                                    <select onchange="ganti_nota()" class="cb_cabang  form-control chosen-select-width"  name="cb_cabang" onchange="nota_kwitansi()" >
                                        <option value="0">Pilih - Cabang</option>
                                    @foreach ($cabang as $row)
                                        @if(Auth()->user()->kode_cabang == $row->kode)
                                            <option selected="" value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                        @else
                                            <option value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                        @endif
                                    @endforeach
                                    </select>
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td style="width:368px; padding-top: 0.4cm" colspan="20" class="cabang_td">
                                    <select class="cb_cabang disabled form-control"  name="cb_cabang" onchange="nota_kwitansi()" >
                                        <option value="0">Pilih - Cabang</option>
                                    @foreach ($cabang as $row)
                                        @if(Auth()->user()->kode_cabang == $row->kode)
                                            <option selected="" value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                        @else
                                            <option value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                        @endif
                                    @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endif
                            <tr class="">
                                <td style="padding-top: 0.4cm">Customer</td>
                                <td  class="customer_td">
                                    <div style="width: 400px">
                                        <select class="chosen-select-width customer"  name="customer " id="customer " style="width:100%" >
                                        <option value="0">Pilih - Customer</option>
                                        @foreach ($customer as $row)
                                            <option value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} - {{ $row->cabang }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    
                                </td>
                                
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Akun</td>
                                <td colspan="3" class="akun_bank_td">
                                    <select class="form-control chosen-select-width cb_akun_h" id="cb_akun_h" name="cb_akun_h" >
                                        <option value="0">Pilih - Akun Bank</option>
                                        @foreach($akun_bank as $val)
                                        <option value="{{$val->mb_kode}}">{{$val->mb_kode}} - {{$val->mb_nama}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            
                            
                            <tr>    
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td colspan="3">
                                    <input type="text" name="ed_keterangan" class="form-control" style="text-transform: uppercase" value="" >
                                </td>
                            </tr>
                        </table>
                        </div>
                        <div class="col-sm-1">
                            
                        </div>
                        <div class="col-sm-5">
                        <table class="table table-striped table-bordered table-hover table_rincian">
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Total Bayar</td>
                                <td colspan="3">
                                    <input type="text"  class="form-control total_jumlah_bayar_text" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1" value="0">

                                    <input type="hidden" name="jumlah_bayar" class="form-control total_jumlah_bayar" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1" value="0">
                                </td>
                              
                            </tr>
                            <tr>
                                  <td style="width:120px; padding-top: 0.4cm">Total Debet (+)</td>
                                <td colspan="3">
                                    <input type="text"  class="form-control ed_debet_text" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1" value="0" >
                                    <input type="hidden" name="ed_debet" class="form-control ed_debet" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1" value="0">
                                </td>
                            </tr>
                            <tr>
                                 <td style="width:120px; padding-top: 0.4cm">Total Kredit (-)</td>
                                <td colspan="3">
                                    <input type="text"  class="form-control ed_kredit_text" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1" value="0">
                                    <input type="hidden" name="ed_kredit"  class="form-control ed_kredit" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1" value="0">
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Netto</td>
                                <td colspan="3">
                                    <input type="text"  class="form-control ed_netto_text" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1" value="0">
                                    <input type="hidden" name="ed_netto" class="form-control ed_netto" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1" value="0">
                                </td>
                            </tr>
                    </table>
                    </div> 

                    <div class="row">
                       
                        <div class="col-sm-12 ">
                            <button type="button" class="btn btn-danger kanan pull-right reload" id="reload" name="btnsimpan" ><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                            <button type="button" class="btn btn-warning kanan pull-right print disabled" id="print" name="btnsimpan" ><i class="glyphicon glyphicon-print"></i> Print</button>
                            <button type="button" class="btn btn-success kanan pull-right temp_1" id="btnsimpan" name="btnsimpan" ><i class="glyphicon glyphicon-save"></i> Simpan</button>
                            <button type="button" class="btn btn-info kanan pull-right tambah_invoice temp_1" name="btnadd" ><i class="glyphicon glyphicon-plus"></i> Pilih Nomor Invoice</button>
                        </div>
                    </div>
                </form>
                <div class="box-body">
                    <div class="tabs-container tab_detail">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" class="tab-1" href="#tab-1"> Detail Kwitansi</a></li>
                            {{-- <li class=""><a data-toggle="tab" class="tab-2" href="#tab-2">Detail Biaya</a></li> --}}
                            {{-- <li class=""><a data-toggle="tab" class="tab-3" href="#tab-3">Detail Uang Muka</a></li> --}}
                        </ul>
                        <div class="tab-content ">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <table id="table_data" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor Invoice</th>
                                                <th>Total Netto</th>
                                                <th>Sisa Bayar</th>
                                                <th>Jumlah Bayar</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <table id="table_data_biaya" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Biaya</th>
                                                <th>Jenis</th>
                                                <th>Jumlah</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                    <table id="tabel_uang_muka" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nomor Uang Muka</th>
                                                <th>Status Uang Muka</th>
                                                <th>Jumlah</th>
                                                <th>Nominal</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                
                <!-- modal -->
                <div id="modal_invoice" class="modal" >
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" style="min-width: 1000px;max-width: 1000px">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Pilih Nomor Invoice</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal  tabel_invoice">
                                    
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="btnsave"><i class="fa fa-plus"> Tambah</i></button>
                            </div>
                        </div>
                    </div>
                </div>
                  <!-- modal -->

                <!-- modal info -->
                <div id="modal_info" class="modal" >
                    <div class="modal-dialog modal-lg" style="min-width: 1200px;max-width: 1200px">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Riwayat Pembayaran Invoice</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <table class="table table-bordered table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding-top: 0.4cm">No Invoice</td>
                                                        <td colspan="3">
                                                            <input type="text" class="form-control ed_nomor_invoice" name="ed_nomor_invoice"  readonly="readonly">
                                                            <input type="hidden" name="ed_id" readonly="readonly" >
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jumlah Invoice</td>
                                                        <td colspan="3">
                                                            <input type="text" class="form-control ed_jumlah_tagihan" name="ed_jumlah_tagihan"  style="text-align:right" readonly="readonly" tabindex="-1">
                                                            <input type="hidden" readonly="readonly" class="form-control jumlah_tagihan">
                                                        </td>
                                                    </tr>
                                                    <tr>    
                                                        <td style="padding-top: 0.4cm">Terbayar</td>
                                                        <td colspan="3">
                                                            <input type="text" readonly="readonly" class="form-control ed_terbayar" name="ed_terbayar" style="text-align:right" tabindex="-1">
                                                            <input type="hidden" readonly="readonly" class="form-control terbayar">
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td style="padding-top: 0.4cm">Nota Debet</td>
                                                        <td colspan="3">
                                                            <input type="text" readonly="readonly" class="form-control ed_nota_debet" style="text-align:right">
                                                            <input type="hidden" readonly="readonly" class="form-control nota_debet">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 0.4cm">Nota Kredit</td>
                                                        <td colspan="3">
                                                            <input type="text" readonly="readonly" class="form-control ed_nota_kredit" name="ed_nota_kredit" style="text-align:right" value="0" tabindex="-1">
                                                            <input type="hidden" readonly="readonly" class="form-control nota_kredit">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sisa Terbayar</td>
                                                        <td colspan="3">
                                                            <input type="text" class="form-control ed_sisa_terbayar" name="ed_sisa_terbayar" id="ed_sisa_terbayar" readonly="readonly" style="text-align:right" tabindex="-1">
                                                            <input type="hidden" readonly="readonly" class="form-control sisa_terbayar">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jumlah Bayar</td>
                                                        <td colspan="3">
                                                            <input type="text"  class="form-control ed_jumlah_bayar" name="ed_jumlah_bayar" readonly="readonly" style="text-align:right" tabindex="-1">
                                                            <input type="hidden" readonly="readonly" class="form-control jumlah_bayar">
                                                        </td>
                                                    </tr>
                                         
                                                    <tr>
                                                        <td>Akun Biaya</td>
                                                        <td style="max-width: 200px" class="">
                                                            <select onchange="akun_biaya1()" class="form-control akun_biaya" id="akun_biaya">
                                                                <option value="0" data-jenis ="D" data-biaya ="0">Non-Biaya</option>
                                                                @foreach($akun_biaya as $val)
                                                                <option value="{{$val->kode}}" data-biaya ="{{$val->acc_biaya}}" data-jenis ="{{$val->jenis}}">{{$val->kode}} - {{$val->nama}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td colspan="2">
                                                            <input type="text" onkeyup="hitung()" style="text-align:right" class="jumlah_biaya_admin form-control" value="0" readonly="">
                                                            <input type="hidden" class="jenis_biaya " value="D">
                                                            <input type="hidden" class="akun_acc_biaya" value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Bayar</td>
                                                        <td colspan="3">
                                                            <input type="text" readonly="" style="text-align:right" class="total_bayar form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sisa</td>
                                                        <td colspan="3">
                                                            <input type="text" class="form-control ed_total"  readonly="readonly" style="text-align:right" tabindex="-1">
                                                            <input type="hidden" readonly="readonly" class="form-control total">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-7">
                                            <h3>Riwayat</h3>
                                            <div class="tabs-container">
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a data-toggle="tab" href="#tab-rk"> Riwayat Kwitansi</a></li>
                                                    <li class=""><a data-toggle="tab" href="#tab-cn">Riwayat CN/DN</a></li>
                                                </ul>
                                                <div class="tab-content ">
                                                    <div id="tab-rk" class="tab-pane active">
                                                        <div class="panel-body riwayat_kwitansi">
                                                            <table class="table riwayat table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nomor Kwitansi</th>
                                                                    <th>Tanggal</th>
                                                                    <th>Jml Bayar</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                        </div>
                                                    </div>
                                                    <div id="tab-cn" class="tab-pane">
                                                        <div class="panel-body riwayat_cn_dn">
                                                            <table id="table_cn_dn" class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nomor CN/DN</th>
                                                                        <th>Tanggal</th>
                                                                        <th>Jml Kredit</th>
                                                                        <th>Jml Kredit</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h3>Pembayaran</h3>
                                            <table class="table  table-bordered table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td>Jumlah Bayar</td>
                                                        <td>
                                                            <input type="text" onkeyup="hitung()" class="form-control angka" name="ed_jml_bayar" style="text-align:right">
                                                            <input type="hidden" name="ed_jml_bayar_old" >
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="btnsave2">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  <!-- modal -->

                
                  {{-- modal um --}}
                <div id="modal_um" class="modal" >
                    <div class="modal-dialog modal-lg" style="min-width: 1300px;max-width: 1300px">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Edit Insert Uang Muka</h4>
                            </div>
                            <div class="modal-body">
                                    <form class="form-horizontal">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <table class="table table-bordered table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding-top: 0.4cm">No Invoice</td>
                                                        <td colspan="3">
                                                            <input type="text" class="form-control ed_nomor_invoice" name="ed_nomor_invoice"  readonly="readonly">
                                                            <input type="hidden" name="ed_id" readonly="readonly" >
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jumlah Invoice</td>
                                                        <td colspan="3">
                                                            <input type="text" class="form-control ed_jumlah_tagihan" name="ed_jumlah_tagihan"  style="text-align:right" readonly="readonly" tabindex="-1">
                                                            <input type="hidden" readonly="readonly" class="form-control jumlah_tagihan">
                                                        </td>
                                                    </tr>
                                                    <tr>    
                                                        <td style="padding-top: 0.4cm">Terbayar</td>
                                                        <td colspan="3">
                                                            <input type="text" readonly="readonly" class="form-control ed_terbayar" name="ed_terbayar" style="text-align:right" tabindex="-1">
                                                            <input type="hidden" readonly="readonly" class="form-control terbayar">
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td style="padding-top: 0.4cm">Nota Debet</td>
                                                        <td colspan="3">
                                                            <input type="text" readonly="readonly" class="form-control ed_nota_debet" style="text-align:right">
                                                            <input type="hidden" readonly="readonly" class="form-control nota_debet">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 0.4cm">Nota Kredit</td>
                                                        <td colspan="3">
                                                            <input type="text" readonly="readonly" class="form-control ed_nota_kredit" name="ed_nota_kredit" style="text-align:right" value="0" tabindex="-1">
                                                            <input type="hidden" readonly="readonly" class="form-control nota_kredit">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sisa Terbayar</td>
                                                        <td colspan="3">
                                                            <input type="text" class="form-control ed_sisa_terbayar" name="ed_sisa_terbayar" id="ed_sisa_terbayar" readonly="readonly" style="text-align:right" tabindex="-1">
                                                            <input type="hidden" readonly="readonly" class="form-control sisa_terbayar_um">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jumlah Bayar</td>
                                                        <td colspan="3">
                                                            <input type="text"  class="form-control ed_jumlah_bayar" name="ed_jumlah_bayar" readonly="readonly" style="text-align:right" tabindex="-1">
                                                            <input type="hidden" readonly="readonly" class="form-control jumlah_bayar">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Akun Biaya</td>
                                                        <td style="max-width: 200px" class="">
                                                            <select onchange="akun_biaya_um()" class="form-control akun_biaya_um" id="akun_biaya">
                                                                <option value="0" data-jenis ="D" data-biaya ="0">Non-Biaya</option>
                                                                @foreach($akun_biaya as $val)
                                                                <option value="{{$val->kode}}" data-biaya ="{{$val->acc_biaya}}" data-jenis ="{{$val->jenis}}">{{$val->kode}} - {{$val->nama}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td colspan="2">
                                                            <input type="text" readonly="" onkeyup="hitung_um()" style="text-align:right" class="jumlah_biaya_admin_um form-control" value="0">
                                                            <input type="hidden" class="jenis_biaya_um " value="D">
                                                            <input type="hidden" class="akun_acc_biaya_um" value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Bayar</td>
                                                        <td colspan="3">
                                                            <input type="text" readonly="" style="text-align:right" class="total_bayar form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sisa</td>
                                                        <td colspan="3">
                                                            <input type="text" class="form-control ed_total"  readonly="readonly" style="text-align:right" tabindex="-1">
                                                            <input type="hidden" readonly="readonly" class="form-control total">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-7">
                                            <h3>Riwayat Dan Pembayaran</h3>
                                            <div class="tabs-container">
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a data-toggle="tab" href="#tab-pb">Pembayaran</a></li>
                                                    <li class=""><a data-toggle="tab" href="#tab-rk1"> Riwayat Kwitansi</a></li>
                                                    <li class=""><a data-toggle="tab" href="#tab-cn1">Riwayat CN/DN</a></li>
                                                </ul>
                                                <div class="tab-content ">
                                                    <div id="tab-pb" class="tab-pane active">
                                                        <div class="panel-body pembayaran_um">
                                                            <table class="table tabel_pembayaran_um borderless table-striped">
                                                                <tr>
                                                                    <td>No UM</td>
                                                                    <td><input readonly="" type="text" class="form-control no_um"></td>
                                                                    <td>
                                                                        <button type="button" class="cari_um btn btn-primary">
                                                                            <i class="fa fa-search"> Cari</i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Nominal Uang Muka</td>
                                                                    <td colspan="2">
                                                                        <input type="text" readonly="" style="text-align: right" class="form-control nominal_um_text">
                                                                        <input type="hidden" readonly="" style="text-align: right" class="form-control nominal_um">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Sisa</td>
                                                                    <td colspan="2">
                                                                        <input type="text" readonly="" style="text-align: right" class="form-control terpakai_um_text">
                                                                        <input type="hidden" readonly="" style="text-align: right" class="form-control terpakai_um">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Status UM</td>
                                                                    <td colspan="2">
                                                                        <input type="text" readonly="" style="text-align: right" class="form-control status_um">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Jumlah Bayar</td>
                                                                    <td colspan="2">
                                                                        <input type="text" style="text-align: right" class="form-control jumlah_bayar_um">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <div class="pull-right">
                                                                        <button type="button" class="btn btn-default append_um">
                                                                        <i class="fa fa-plus"></i>Append
                                                                        </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div id="tab-rk1" class="tab-pane">
                                                        <div class="panel-body riwayat_kwitansi_um">
                                                            <table class="table riwayat table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nomor Kwitansi</th>
                                                                    <th>Tanggal</th>
                                                                    <th>Jml Bayar</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                        </div>
                                                    </div>
                                                    <div id="tab-cn1" class="tab-pane">
                                                        <div class="panel-body riwayat_cn_dn_um">
                                                            <table id="table_cn_dn" class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nomor CN/DN</th>
                                                                        <th>Tanggal</th>
                                                                        <th>Jml Kredit</th>
                                                                        <th>Jml Kredit</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <table class="table table_histori_um ">
                                                    <thead>
                                                        <tr>
                                                            <th>No UM</th>
                                                            <th>Nominal</th>
                                                            <th>Sisa</th>
                                                            <th>Jumlah Bayar</th>
                                                            <th>Sisa Akhir</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="save_um">Simpan Uang Muka</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="box-footer">
                  <div class="pull-right">

                     cari um modal
                <div id="modal_cari_um" class="modal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Edit Insert Uang Muka</h4>
                            </div>
                            <div class="modal-body ">
                                <div class="um_table">
                                    
                                </div>
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
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







<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')



<script type="text/javascript">
//GLOBAL VARIABLE
var array_simpan = [];
var array_edit = [];
var array_harga = [];
var count_um = 1;
var simpan_um = [];
var harga_um = [];
var array_um= [];
var array_um_harga=[];

// datepicker
$('.ed_tanggal').datepicker({
    format:'dd/mm/yyyy',
    endDate:'today'
})

var config1 = {
                   '.chosen-select'           : {},
                   '.chosen-select-deselect'  : {allow_single_deselect:true},
                   '.chosen-select-no-single' : {disable_search_threshold:10},
                   '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                   '.chosen-select-width1'     : {width:"100%"},
                   'parser_config': { copy_data_attributes: true }
                 }
    for (var selector in config1) {
      $(selector).chosen(config1[selector]);
    }
//datatable detail_invoice
var anjay = [];


var table_data = $('#table_data').DataTable({
                    searching:false,
                    columnDefs: [
                      {
                         targets: 1 ,
                         className: 'right'
                      },
                      {
                         targets: 2,
                         className: 'right'
                      },
                      {
                         targets: 5,
                         className: 'center'
                      },
                      {
                         targets: 4,
                         className: 'center'
                      }
                    ],
                    
                })


var table_histori_um = $('.table_histori_um').DataTable({
                    searching:false,
                })

var table_data_biaya = $('#table_data_biaya').DataTable({
                    searching:false,
                    columnDefs: [
                      {
                         targets: 0 ,
                         className: 'center'
                      },
                      {
                         targets: 1 ,
                         className: 'left'
                      },
                      {
                         targets: 3,
                         className: 'right'
                      },
                      {
                         targets: 5,
                         className: 'center'
                      },
                      {
                         targets: 3,
                         className: 'left'
                      }
                    ],
                    
                })

//mengganti nota kwitansi
function nota_kwitansi() {
    var cb_cabang = $('.cb_cabang').val();

    $.ajax({
        url:baseUrl + '/sales/nota_kwitansi',
        data:{cb_cabang},
        dataType:'json',
        success:function(response){
            $('#ed_nomor').val(response.nota);
        }
    })


}

//NOTA kwitansi
$(document).ready(function(){
    var cabang = $('.cb_cabang').val();
    $.ajax({
        url:baseUrl+'/sales/nota_kwitansi',
        data:{cabang},
        dataType : 'json',
        success:function(response){
            $('#nota_kwitansi').val(response.nota);
        },
        error:function(){
            location.reload();
        }


    });


    
    $('.angka').maskMoney({precision:0,thousands:'.',allowZero:true,defaultZero: true});
    $('.jumlah_biaya_admin').maskMoney({precision:0,thousands:'.',allowZero:true,defaultZero: true});
    $('.jumlah_biaya_admin_um').maskMoney({precision:0,thousands:'.',allowZero:true,defaultZero: true});
    $('.m_jumlah').maskMoney({precision:0,thousands:'.',allowZero:true,defaultZero: true});
    $('.me_jumlah').maskMoney({precision:0,thousands:'.',allowZero:true,defaultZero: true});
});

// ganti nota untuk admin
    function ganti_nota(argument) {
      var cabang = $('.cb_cabang').val();
        $.ajax({
        url:baseUrl+'/sales/nota_kwitansi',
        data:{cabang},
        dataType : 'json',
        success:function(response){
            $('#nota_kwitansi').val(response.nota);
        },
        error:function(){
            toastr.warning('terjadi Kesalahan');
        }
    });

        $.ajax({
            url:baseUrl+'/sales/akun_all',
            data:{cabang},
            success:function(response){
                $('.akun_lain_td').html(response);
            },
            error:function(){
            toastr.warning('terjadi Kesalahan');
            }
        });

        $.ajax({
            url:baseUrl+'/sales/akun_biaya',
            data:{cabang},
            success:function(response){
                $('.akun_biaya_td').html(response);

            },
            error:function(){
                // location.reload();
            }
        });

        $.ajax({
        url:baseUrl +'/sales/drop_cus',
        data:{cabang},
        success:function(data){
            // $('.customer_td').html(data);
            toastr.info('Data Telah Dirubah Harap Periksa Kembali');
        },
        error:function(){
            location.reload();
        }
        });


    $.ajax({
        url:baseUrl+'/sales/akun_bank',
        data:{cabang},
        success:function(response){
            $('.td_akun_bank').html(response);
        },
        error:function(){
            location.reload();
        }
    });
    }
// check all
function nota_tes(){
    var cabang = $('.cb_cabang').val();
    var cb_jenis_pembayaran = $('.cb_jenis_pembayaran').val();
    $.ajax({
        url:baseUrl+'/sales/nota_bank',
        data:{cabang,cb_jenis_pembayaran},
        dataType : 'json',
        success:function(response){
            $('#nota_bank').val(response.nota);
        },
        error:function(){
        }
    });
}
    


// tambah invoice
$('.tambah_invoice').click(function(){
    if ($('.cb_jenis_pembayaran ').val() == '0') {
        toastr.warning('Jenis Pembayaran Harus Dipilih')
        return 1
    }
    if ($('.cb_cabang').val() == '0') {
        toastr.warning('Cabang Harus Dipilih')
        return 1
    }
    if ($('.customer ').val() == '0') {
        toastr.warning('Customer Harus Dipilih')
        return 1
    }
    if ($('#cb_akun_h').val() == '0') {
        toastr.warning('Akun Harus Dipilih')
        return 1
    }
    
    var cb_cabang = $('.cb_cabang').val();
    var cb_customer = $('.customer').val();

    $.ajax({
        url:baseUrl + '/sales/cari_invoice',
        data:{cb_cabang,cb_customer,array_simpan},
        success:function(data){


            $('.tabel_invoice').html(data);
            $('#modal_invoice').modal('show');       
        }
    })

})

//Append invoice



$('#btnsave').click(function(){

    var nomor = [];
        
    $('.child_check').each(function(){
        var check = $(this).is(':checked');
        if (check == true) {
            var par   = $(this).parents('tr');
            var inv   = $(par).find('.nomor_inv').val();
            nomor.push(inv);
            array_simpan.push(inv);

        }  
    });
///////////////////////////////////////////
    $.ajax({
        url:baseUrl + '/sales/append_invoice',
        data:{nomor},
        dataType:'json',
        success:function(response){
            for(var i = 0; i < response.data.length;i++){
                table_data.row.add([
                        '<a class="his" title="Klik disini untuk menginput nilai" onclick="histori(this)">'+response.data[i].i_nomor+'</a>'+'<input type="hidden" class="i_nomor i_flag_'+response.data[i].i_nomor+'" name="i_nomor[]" value="'+response.data[i].i_nomor+'">',
                        accounting.formatMoney(response.data[i].i_tagihan, "", 2, ".",',')+'<input type="hidden" class="i_tagihan" name="i_tagihan[]" value="'+response.data[i].i_tagihan+'">',
                        accounting.formatMoney(response.data[i].i_sisa_pelunasan, "", 2, ".",',')+'<input type="hidden" class="i_sisa" name="i_sisa[]" value="'+response.data[i].i_sisa_pelunasan+'">',
                        '<input type="text" style="text-align:right;" readonly class="form-control i_bayar_text input-sm" value="0">'+
                        '<input type="hidden" style="text-align:right;" readonly class="form-control i_bayar input-sm" name="i_bayar[]" value="0">'+
                        '<input type="hidden" readonly class="form-control i_debet input-sm" name="i_debet[]" value="0">'+
                        '<input type="hidden" readonly class="form-control i_kredit input-sm" name="i_kredit[]" value="0">'+
                        '<input type="hidden" readonly class="form-control i_akun_biaya input-sm" name="akun_biaya[]" value="0">',
                        '<input type="text" placeholder="keterangan..." class="form-control input-sm" name="i_keterangan[]" value="">',
                        '<button type="button" onclick="hapus_detail(this)" class="btn btn-danger hapus btn-sm" title="hapus"><i class="fa fa-trash"><i></button>'
                    ]).draw();

                $('#modal_invoice').modal('hide');
                $('.customer_tr').addClass('disabled');
            }     

            $('.i_bayar').blur(function(){
              var temp =  $(this).val();
              console.log(temp);
              $(this).val(accounting.formatMoney(temp, "", 2, ".",','));
            });  

            $(".i_bayar").focus(function() {
                 $(this).select();
            });
            $('.jenis_pembayaran_td').addClass('disabled');
            $('.cabang_td').addClass('disabled');
            $('.customer_td').addClass('disabled');
            $('.akun_bank_td').addClass('disabled');

            $( ".his" ).tooltip({ show: { effect: "none", duration: 800 } });
            $('.tab_detail ul li .tab-1').trigger('click');
        }
    })
});

function akun_biaya1(){
   var jenis =  $('.akun_biaya').find(':selected').data('jenis');
   var biaya =  $('.akun_biaya').find(':selected').data('biaya');

   console.log(jenis);
   $('.jenis_biaya').val('');
   $('.akun_acc_biaya').val('');
   $('.jenis_biaya').val(jenis);
   $('.akun_acc_biaya').val(biaya);
   if (jenis != 'K') {
      $('.jumlah_biaya_admin').val('0');
   }

   if ($('.akun_biaya').val() == '0') {
    $('.jumlah_biaya_admin').attr('readonly',true);
   }else{
    $('.jumlah_biaya_admin').attr('readonly',false);
   }
}

// hitung total
function hitung() {
    var angka         = $('.angka').val();
    var biaya_admin   = $('.jumlah_biaya_admin').val();
    var jenis         = $('.jenis_biaya').val();
    var akun_acc_biaya= $('.akun_acc_biaya').val();

    if (biaya_admin == '') {
        biaya_admin = 0;
    }else{
        biaya_admin       = biaya_admin.replace(/[^0-9\-]+/g,"");
    }
    biaya_admin = parseFloat(biaya_admin);
    
        console.log(biaya_admin);
    
    var sisa_terbayar = $('.sisa_terbayar').val();
    sisa_terbayar     = parseFloat(sisa_terbayar);
    angka             = angka.replace(/[^0-9\-]+/g,"");
    var total         = sisa_terbayar - angka - biaya_admin;
    if (total < 0) {
        total = 0;
    }

    if (angka > sisa_terbayar) {
        if ($('.akun_biaya').val() != 'U2') {
            $('.akun_biaya').val('B3').trigger('chosen:updated');
            akun_biaya1();
            var jenis         = $('.jenis_biaya').val();
            var akun_acc_biaya= $('.akun_acc_biaya').val();
        }
    }
    $('.ed_jumlah_bayar').val(accounting.formatMoney(angka,"",2,'.',','));
    $('.jumlah_bayar').val(angka);

    $('.ed_total').val(accounting.formatMoney(total,"",2,'.',','))
    $('.total').val(total);
    angka = parseFloat(angka);
  
    
    if (jenis == 'D') {
        $('.total_bayar').val(accounting.formatMoney(angka+biaya_admin,"",2,'.',','))
    }else if(jenis == 'K'){
        var hasil = angka-sisa_terbayar;
        if (hasil <0) {
            hasil = 0;
        }
        var angka = $('.jumlah_bayar').val();
        $('.jumlah_biaya_admin').val(accounting.formatMoney(hasil,"",0,'.',','))

        var biaya_admin   = $('.jumlah_biaya_admin').val();
        biaya_admin       = biaya_admin.replace(/[^0-9\-]+/g,"");
        biaya_admin       = parseFloat(biaya_admin);

        $('.total_bayar').val(accounting.formatMoney(angka-biaya_admin,"",2,'.',','))
    }

}


function histori(p){
    var par                 = $(p).parents('tr');
    var i_nomor             = $(par).find('.i_nomor').val();
    var i_sisa_pelunasan    = $(par).find('.i_sisa_pelunasan').val();
    var i_bayar             = $(par).find('.i_bayar ').val();
    var nota_kwitansi       = $('#nota_kwitansi').val();
    var i_tagihan           = $(par).find('.i_tagihan ').val();
    var cb_jenis_pembayaran = $('.cb_jenis_pembayaran').val(); 
    var asd                 = simpan_um.length;
    simpan_um.splice(0,asd);

    if (cb_jenis_pembayaran != 'U') {

        $.ajax({
        url:baseUrl + '/sales/riwayat_invoice',
        data:{i_nomor,cb_jenis_pembayaran,nota_kwitansi},
        success:function(data){

            $('.riwayat_kwitansi').html(data);
            table_riwayat.destroy();

            var temp = 0;
            table_riwayat.$('.kd_total_bayar').each(function(){
                temp += parseFloat($(this).val());
            });
            $('.ed_terbayar').val(accounting.formatMoney(temp,"",2,'.',','));
            $('.terbayar').val(temp);


            $.ajax({
                url:baseUrl + '/sales/riwayat_cn_dn',
                data:{i_nomor,cb_jenis_pembayaran,nota_kwitansi},
                success:function(data){
                    $('.riwayat_cn_dn').html(data);
                    table_cd.destroy();

                    var temp = 0;
                    var temp1 = 0;
                    table_cd.$('.cd_debet').each(function(){
                        temp += parseFloat($(this).val());
                    });

                    table_cd.$('.cd_kredit').each(function(){
                        temp1 += parseFloat($(this).val());
                    });
                    $('.ed_nota_debet').val(accounting.formatMoney(temp,"",2,'.',','));
                    $('.nota_debet').val(temp);

                    $('.ed_nota_kredit').val(accounting.formatMoney(temp1,"",2,'.',','));
                    $('.nota_kredit').val(temp1);


                    $('.ed_nomor_invoice').val(i_nomor);
                    $('.ed_jumlah_tagihan').val(accounting.formatMoney(i_tagihan,"",2,'.',','));
                    $('.jumlah_tagihan').val(i_tagihan);

                    var jumlah_tagihan = $('.jumlah_tagihan').val();
                    jumlah_tagihan     = parseFloat(jumlah_tagihan);
                    var terbayar       = $('.terbayar').val();
                    terbayar           = parseFloat(terbayar);
                    var nota_debet     = $('.nota_debet').val()
                    nota_debet         = parseFloat(nota_debet);

                    var nota_kredit    =$('.nota_kredit').val()
                    nota_kredit        = parseFloat(nota_kredit);


                    var jumlah         = jumlah_tagihan - terbayar + nota_debet - nota_kredit;
                    jumlah             = jumlah;
                    $('.ed_sisa_terbayar').val(accounting.formatMoney(jumlah,"",2,'.',','));
                    $('.sisa_terbayar').val(jumlah);

                    var i_bayar        = $(par).find('.i_bayar').val();
                    var i_debet    = $(par).find('.i_debet').val();
                    var i_kredit    = $(par).find('.i_kredit').val();
                    var biaya_admin = parseFloat(i_debet)+parseFloat(i_kredit);
                    console.log(i_bayar);
                    $('.angka').val(i_bayar);
                    $('.ed_jumlah_bayar').val(accounting.formatMoney(i_bayar,"",2,'.',','));
                    $('.jumlah_bayar').val(i_bayar);
                    $('.jumlah_biaya_admin ').val(biaya_admin);
                    var biaya_admin    = $(par).find('.i_akun_biaya').val();
                    $('.akun_biaya ').val(biaya_admin).trigger('chosen:updated');
                    if (biaya_admin == '0') {
                        $('.jumlah_biaya_admin').attr('readonly',true);
                    }else{
                        $('.jumlah_biaya_admin').attr('readonly',false);
                    }
                    hitung();
                    $('#modal_info').modal('show');
                }
            })
        }
        })
    }else{
        $.ajax({
        url:baseUrl + '/sales/riwayat_invoice',
        data:{i_nomor,cb_jenis_pembayaran,nota_kwitansi},
        success:function(data){
            $('.riwayat_kwitansi_um').html(data);
            var temp = 0;
            table_riwayat_um.$('.kd_total_bayar_um').each(function(){
                temp += parseFloat($(this).val());
            });
            $('.ed_terbayar').val(accounting.formatMoney(temp,"",2,'.',','));
            $('.terbayar').val(temp);


            $.ajax({
                url:baseUrl + '/sales/riwayat_cn_dn',
                data:{i_nomor,cb_jenis_pembayaran,nota_kwitansi},
                success:function(data){
                    $('.riwayat_cn_dn_um').html(data);
                    var temp = 0;
                    var temp1 = 0;
                    table_cd_um.$('.cd_debet_um').each(function(){
                        temp += parseFloat($(this).val());
                    });

                    table_cd_um.$('.cd_kredit_um').each(function(){
                        temp1 += parseFloat($(this).val());
                    });
                    console.log(temp1);
                    $('.ed_nota_debet').val(accounting.formatMoney(temp,"",2,'.',','));
                    $('.nota_debet').val(temp);

                    $('.ed_nota_kredit').val(accounting.formatMoney(temp1,"",2,'.',','));
                    $('.nota_kredit').val(temp1);


                    $('.ed_nomor_invoice').val(i_nomor);
                    $('.ed_jumlah_tagihan').val(accounting.formatMoney(i_tagihan,"",2,'.',','));
                    $('.jumlah_tagihan').val(i_tagihan);

                    var jumlah_tagihan = $('.jumlah_tagihan').val();
                    jumlah_tagihan     = parseFloat(jumlah_tagihan);
                    var terbayar       = $('.terbayar').val();
                    terbayar           = parseFloat(terbayar);
                    var nota_debet     = $('.nota_debet').val()
                    nota_debet         = parseFloat(nota_debet);

                    var nota_kredit    = $('.nota_kredit').val()
                    nota_kredit        = parseFloat(nota_kredit);


                    var jumlah         = jumlah_tagihan - terbayar + nota_debet - nota_kredit;
                    jumlah             = jumlah;
                    $('.ed_sisa_terbayar').val(accounting.formatMoney(jumlah,"",2,'.',','));
                    $('.sisa_terbayar_um').val(jumlah);

                    var i_bayar        = $(par).find('.i_bayar').val();
                    var i_debet    = $(par).find('.i_debet').val();
                    var i_kredit    = $(par).find('.i_kredit').val();
                    var biaya_admin = parseFloat(i_debet)+parseFloat(i_kredit);
                    console.log(i_bayar);
                    $('.angka').val(i_bayar);
                    $('.ed_jumlah_bayar').val(accounting.formatMoney(i_bayar,"",2,'.',','));
                    $('.jumlah_bayar').val(i_bayar);
                    $('.jumlah_biaya_admin_um').val(biaya_admin);
                    var biaya_admin    = $(par).find('.i_akun_biaya ').val();
                    $('.akun_biaya_um').val(biaya_admin).trigger('chosen:updated');
                    if (biaya_admin == '0') {
                        $('.jumlah_biaya_admin_um').attr('readonly',true);
                    }else{
                        $('.jumlah_biaya_admin_um').attr('readonly',false);
                    }
                    $.ajax({
                        url:baseUrl + '/sales/kwitansi_cari_um',
                        data:{i_nomor,nota_kwitansi},
                        dataType:'json',
                        success:function(response){
                            table_histori_um.clear().draw();
                            console.log(response);
                            for (var i = 0; i < response.data.length; i++) {

                                var sisa_akhir = parseFloat(response.data[i].sisa_uang_muka)+parseFloat(response.data[i].ku_jumlah) - parseFloat(response.data[i].ku_jumlah);

                                table_histori_um.row.add([

                                    '<p class="no_um_text">'+response.data[i].ku_nomor_um+'</p>'
                                    +'<input type="hidden" value="'+response.data[i].ku_nomor_um+'" class="m_no_um m_um_'+response.data[i].ku_nomor_um+'" name="m_no_um[]">',

                                    '<p class="m_nominal_um_text">'+accounting.formatMoney(response.data[i].jumlah,"",2,'.',',')+'</p>'+
                                    '<input type="hidden" value="'+response.data[i].jumlah+'" class="m_nominal_um">',

                                    '<p class="m_terpakai_um_text">'+accounting.formatMoney(parseFloat(response.data[i].sisa_uang_muka)+parseFloat(response.data[i].ku_jumlah),"",2,'.',',')+'</p>'+
                                    '<input type="hidden" value="'+parseFloat(response.data[i].sisa_uang_muka)+parseFloat(response.data[i].ku_jumlah)+'" class="m_terpakai_um">',

                                    '<p class="m_jumlah_bayar_um_text">'+accounting.formatMoney(response.data[i].ku_jumlah,"",2,'.',',')+'</p>'+
                                    '<input type="hidden" value="'+response.data[i].ku_jumlah+'" class="m_jumlah_bayar_um" name="m_jumlah_bayar_um[]">',

                                    '<p class="m_sisa_akhir_um_text">'+accounting.formatMoney(sisa_akhir,"",2,'.',',')+'</p>'+
                                    '<input type="hidden" value="'+sisa_akhir+'" class="m_sisa_akhir_um" name="m_sisa_akhir_um[]">',

                                    '<div class="btn-group ">'+
                                    '<a  onclick="edit_um(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
                                    '<a  onclick="hapus_um(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
                                    '</div>',


                                ]).draw();

                                simpan_um.push(response.data[i].ku_nomor_um);
                            }

                            console.log(simpan_um);

                            var temp = 0;
                            
                            table_histori_um.$('.m_jumlah_bayar_um').each(function(){
                                var ini = $(this).val();
                                ini = parseFloat(ini);
                                temp += ini;
                            });


                            $('.ed_jumlah_bayar').val(accounting.formatMoney(temp,"",2,'.',','));
                            $('.jumlah_bayar').val(temp);
                            $('.tabel_pembayaran_um input').val('');
                            $('#modal_um').modal('show');
                            hitung_um();


                        }
                    })

                }
            })
        }
        })
    }
    
  
}


 
//hapus detail
function hapus_detail(o) {
    var par = o.parentNode.parentNode;
    var arr = $(par).find('.i_nomor').val();
    var flag_nota = $('.flag_nota').val();
    var index = array_simpan.indexOf(arr);
    array_simpan.splice(index,1);
    $.ajax({
        url:baseUrl + '/sales/hapus_um_kwitansi',
        data:$('.tabel_header :input').serialize()
             +'&i_nomor='+arr
             +'&flag='+'H'
             +'&flag_nota='+flag_nota,
        dataType:'json',
        success:function(response){
        }
    })
    table_data.row(par).remove().draw(false);

    var temp =  0 ;
    $('.i_nomor').each(function(){
        temp += 1;
    })
    if (temp == 0) {
        $('.jenis_pembayaran_td').removeClass('disabled');
        $('.cabang_td').removeClass('disabled');
        $('.customer_td').removeClass('disabled');
        $('.akun_bank_td').removeClass('disabled');

    }
}

//hitung total bayar

function hitung_bayar() {
    var total_bayar = $('.total_jumlah_bayar').val();
        total_bayar = parseFloat(total_bayar);

    var ed_debet = $('.ed_debet').val();
        ed_debet = parseFloat(ed_debet);

    var ed_kredit = $('.ed_kredit').val();
        ed_kredit = parseFloat(ed_kredit);


    var total     = total_bayar + ed_debet - ed_kredit;
    if (total < 0) {
        total = 0;
    }
    $('.ed_netto').val(total);
    $('.ed_netto_text').val(accounting.formatMoney(total,"",2,'.',','));
    
}
$('.jumlah_biaya_admin').blur(function(){
var ini = $(this).val();
if (ini == '') {
$(this).val(0);
}
});
// simpan perubahan
$('#btnsave2').click(function(){
    var jumlah_bayar         = $('.jumlah_bayar').val();
    jumlah_bayar             = parseFloat(jumlah_bayar);
    var akun_biaya           = $('.akun_biaya').val();
    var jumlah_biaya_admin   = $('.jumlah_biaya_admin').val();
    var jenis                = $('.jenis_biaya').val();
    var akun_acc_biaya       = $('.akun_acc_biaya').val();

    if (jumlah_biaya_admin == '') {
        jumlah_biaya_admin = 0;
    }else{
        jumlah_biaya_admin       = jumlah_biaya_admin.replace(/[^0-9\-]+/g,"");
        jumlah_biaya_admin       = parseFloat(jumlah_biaya_admin);
    }
    
    var angka                = $('.angka').val();
    angka                    = angka.replace(/[^0-9\-]+/g,"");
    angka                    = parseFloat(angka);
    var ed_nomor_invoice     = $('.ed_nomor_invoice').val();
    var tes                  = [];
    var par                  = $('.i_flag_'+ed_nomor_invoice).parents('tr');
    var jumlah_biaya         = 0;
    if (jenis == 'K') {
        $(par).find('.i_kredit').val(jumlah_biaya_admin);
        $(par).find('.i_debet').val('0');
    }else{
        $(par).find('.i_debet').val(jumlah_biaya_admin);
        $(par).find('.i_kredit').val('0');
    }
    $(par).find('.i_bayar_text').val(accounting.formatMoney(angka,"",2,'.',','));
    $(par).find('.i_bayar').val(angka);
    $(par).find('.i_akun_biaya ').val(akun_biaya);
    var temp = 0;
    table_data.$('.i_bayar').each(function(){
        var i_bayar = Math.round($(this).val()).toFixed(2);
            i_bayar = parseFloat(i_bayar);
        temp += i_bayar;
    })

    var temp1 = 0;
    table_data.$('.i_debet').each(function(){
        var i_bayar = Math.round($(this).val()).toFixed(2);
            i_bayar = parseFloat(i_bayar);
        temp1 += i_bayar;
    })

    var temp2 = 0;
    table_data.$('.i_kredit').each(function(){
        var i_bayar = Math.round($(this).val()).toFixed(2);
            i_bayar = parseFloat(i_bayar);
        temp2 += i_bayar;
    })




    $('.total_jumlah_bayar').val(temp);
    $('.total_jumlah_bayar_text').val(accounting.formatMoney(temp,"",2,'.',','));
    $('.ed_debet').val(temp1);
    $('.ed_debet_text').val(accounting.formatMoney(temp1,"",2,'.',','));

    $('.ed_kredit').val(temp2);
    $('.ed_kredit_text').val(accounting.formatMoney(temp2,"",2,'.',','));
    hitung_bayar();
    $('#modal_info').modal('hide');

})
// add biaya modal
var count = 1;
$('#btnadd_biaya').click(function(){
    $('.m_sequence').val(count);
    $('#modal_biaya').modal('show');
})

// save biaya lain
$('#btnsave3').click(function(){
    var seq          = $('.m_sequence').val();
    var akun_lain    = $('.akun_lain').val();
    var m_acc        = $('.m_acc').val();
    var m_csf        = $('.m_csf').val();
    var m_debet      = $('.m_debet').val();
    var m_jumlah     = $('.m_jumlah ').val();
    m_jumlah         = m_jumlah.replace(/[^0-9\-]+/g,"");
    var m_keterangan = $('.m_keterangan ').val();
    var m_nama_akun  = $('.m_nama_akun').val();
    var debet        = 0;
    var kredit       = 0;
    if (m_debet == 'DEBET') {
        debet  = m_jumlah;
        kredit = 0;
    }else{
        debet  = 0;
        kredit = m_jumlah;
    }

    table_data_biaya.row.add([
            '<p class="b_seq_text">'+seq+'</p>'+'<input type="hidden" class="b_flag_'+seq+'">',
            '<p class="b_nama_akun_text">'+m_nama_akun+'</p>'+'<input type="hidden" class="b_kode_akun" value="'+m_acc+'" name="b_akun[]">',
            '<p class="b_debet_text">'+m_debet+'</p>',
            '<p class="b_jumlah_text">'+accounting.formatMoney(m_jumlah,"",2,'.',',')+'</p>'+
            '<input type="hidden" class="b_jumlah" value="'+m_jumlah+'" name="b_jumlah[]">'+
            '<input type="hidden" class="b_debet" value="'+debet+'" name="b_debet[]">'+
            '<input type="hidden" class="b_kredit" value="'+kredit+'" name="b_kredit[]">',
            '<p class="b_keterangan_text">'+m_keterangan+'</p>'+
            '<input type="hidden" class="b_keterangan" value="'+m_keterangan+'" name="b_keterangan[]">',
            '<button type="button" onclick="hapus_detail_biaya(this)" class="btn btn-danger hapus btn-sm" title="hapus">'+
            '<label class="fa fa-trash"><label></button>'+
            '<button type="button" onclick="edit_detail_biaya(this)" class="btn btn-warning hapus btn-sm" title="edit">'+
            '<label class="fa fa-pencil"><label></button>'

        ]).draw();
    var temp = 0;    
    var temp1 = 0; 

    table_data_biaya.$('.b_debet').each(function(){
        var deb = parseFloat($(this).val());
        temp += deb;
    })  
    table_data_biaya.$('.b_kredit').each(function(){
        var deb = parseFloat($(this).val());
        temp1 += deb;
    })  

    $('.ed_debet').val(temp);
    $('.ed_kredit').val(temp1);
    $('.ed_debet_text').val(accounting.formatMoney(temp,"",2,'.',','));
    $('.ed_kredit_text').val(accounting.formatMoney(temp1,"",2,'.',','));

    $('.m_acc').val('');
    $('.m_csf').val('');
    $('.m_debet').val('');
    $('.m_jumlah ').val('');
    $('.m_keterangan ').val('');
    $('.m_nama_akun').val('');

    hitung_bayar();

        $('#modal_biaya').modal('hide');
    count+=1;  

$('.tab_detail ul li .tab-2').trigger('click');

});
// hapus detail biaya
function hapus_detail_biaya(p) {
    var par = p.parentNode.parentNode;
    table_data_biaya.row(par).remove().draw(false);
    hitung_bayar();
}

function edit_detail_biaya(p) {
    var par = p.parentNode.parentNode;
    var b_seq = $('.b_seq_text').text();
    var b_kode_akun = $('.b_kode_akun').val();
    var b_debet_text = $('.b_debet_text').text();
    var b_nama_akun_text = $('.b_nama_akun_text').text();
    var b_jumlah = $('.b_jumlah').val();
    var b_keterangan = $('.b_keterangan').val();


    $('.me_nomor ').val(b_seq);
    $('.akun_lain').val(b_kode_akun).trigger('chosen:updated');
    $('.me_debet').val(b_debet_text);
    $('.me_acc').val(b_kode_akun);
    $('.me_csf').val(b_kode_akun);
    $('.m_nama_akun').val(b_nama_akun_text);
    $('.me_jumlah').val(b_jumlah);
    $('.me_keterangan').val(b_keterangan);
    $('#modal_edit_biaya').modal('show');
}

$('#update_biaya').click(function(){
    var me_nomor = $('.me_nomor').val();
    var par = $('.b_flag_'+me_nomor).parents('tr');
    var akun_lain = $('.akun_lain').val();
    var me_debet = $('.me_debet').val();
    var me_acc = $('.me_acc').val();
    var me_jumlah = $('.me_jumlah').val();
    me_jumlah     = me_jumlah.replace(/[^0-9\-]+/g,"");

    var me_keterangan = $('.me_keterangan').val();
    var m_nama_akun = $('.m_nama_akun').val();
    var debet        = 0;
    var kredit       = 0;
    console.log(par);
    console.log(me_nomor);
    $(par).find('.b_nama_akun_text').text(m_nama_akun);
    $(par).find('.b_kode_akun').val(me_acc);
    $(par).find('.b_debet_text').text(me_debet);
    $(par).find('.b_debet_text').text(me_debet);
    if (me_debet == 'DEBET') {
        debet  = me_jumlah;
        kredit = 0;
    }else{
        debet  = 0;
        kredit = me_jumlah;
    }
    $(par).find('.b_jumlah_text').text(accounting.formatMoney(me_jumlah,"",2,'.',','));
    $(par).find('.b_jumlah').val(me_jumlah);
    $(par).find('.b_debet').val(debet);
    $(par).find('.b_kredit').val(kredit);
    $(par).find('.b_keterangan').val(me_keterangan);
    var temp = 0;    
    var temp1 = 0; 

    table_data_biaya.$('.b_debet').each(function(){
        var deb = parseFloat($(this).val());
        temp += deb;
    })  
    table_data_biaya.$('.b_kredit').each(function(){
        var deb = parseFloat($(this).val());
        temp1 += deb;
    })  

    $('.ed_debet').val(temp);
    $('.ed_kredit').val(temp1);
    $('.ed_debet_text').val(accounting.formatMoney(temp,"",2,'.',','));
    $('.ed_kredit_text').val(accounting.formatMoney(temp1,"",2,'.',','));

    $('.m_acc').val('');
    $('.m_csf').val('');
    $('.m_debet').val('');
    $('.m_jumlah ').val('');
    $('.m_keterangan ').val('');
    $('.m_nama_akun').val('');

    hitung_bayar();
    hitung_bayar();

    $('#modal_edit_biaya').modal('hide');
})
var simpan_um = [];

// cari um
$('.cari_um').click(function(){
    if ($('#cb_akun_h').val() == '0') {
        toastr.warning('Akun Harus Dipilih')
        return 1
    }
    if ($('.customer').val() == '0') {
        toastr.warning('Customer Harus Dipilih')
        return 1
    }
    var cb_cabang = $('.cb_cabang').val();
    var cb_customer = $('.customer').val();

    $.ajax({
        url:baseUrl + '/sales/cari_um',
        data:{cb_cabang,cb_customer,simpan_um},
        success:function(data){
            $('.um_table').html(data);

            $('#modal_cari_um').modal('show');       
        }
    })
});
// simpan
$('#btnadd_um').click(function(){
    if ($('#cb_akun_h').val() == '0') {
        toastr.warning('Akun Harus Dipilih')
        return 1
    }
    if ($('.customer').val() == '0') {
        toastr.warning('Customer Harus Dipilih')
        return 1
    }
   $('.cari_um').removeClass('disabled');
   

    $('.tabel_um :input').val('');
    $('.seq_um ').val(count_um);



    $('#modal_um').modal('show');
});
// pilih um
function pilih_um(par) {
    var um = $(par).find('.nomor_modal_um').val();
    $.ajax({
        url:baseUrl+'/sales/pilih_um',
        data:{um,simpan_um},
        dataType : 'json',
        success:function(response){
            $('.no_um').val(response.data[0].nomor);
            $('.nominal_um_text').val(accounting.formatMoney(response.data[0].jumlah,"",2,'.',','));
            $('.nominal_um').val(response.data[0].jumlah);
            $('.terpakai_um_text').val(accounting.formatMoney(response.data[0].sisa_uang_muka,"",2,'.',','));
            $('.terpakai_um').val(response.data[0].sisa_uang_muka);
            $('.status_um').val(response.data[0].status_um);
            $('#modal_cari_um').modal('hide');

        },
        error:function(){
        }
    });

}
var tabel_uang_muka = $('#tabel_uang_muka').DataTable({
     columnDefs: [  
                      {
                         targets: 0,
                         className: 'center'
                      },
                      {
                         targets: 4 ,
                         className: 'center'
                      },
       
                      {
                         targets: 3,
                         className: 'right'
                      },
                      {
                      
                         targets: 5,
                         className: 'center'
                      },
                      {
                      
                         targets: 6,
                         className: 'center'
                      }
                    ],
});
$('.jumlah_bayar_um').maskMoney({precision:0,thousands:'.',defaultZero: true});
$('.jumlah_bayar_um ').keyup(function(){
   var jumlah = $(this).val();
   jumlah     = jumlah.replace(/[^0-9\-]+/g,"");
   jumlah     = parseFloat(jumlah);
   var total_um  = $('.total_um ').val();
   total_um   = parseFloat(total_um);

   if (jumlah > total_um) {
    jumlah = total_um;
   }
   $(this).val(accounting.formatMoney(jumlah,"",0,'.',','));
});

function akun_biaya_um(){
   var jenis =  $('.akun_biaya_um').find(':selected').data('jenis');
   var biaya =  $('.akun_biaya_um').find(':selected').data('biaya');
   console.log(jenis);
   $('.jenis_biaya_um').val('');
   $('.akun_acc_biaya_um').val('');
   $('.jenis_biaya_um').val(jenis);
   $('.akun_acc_biaya_um').val(biaya);
   $('.jumlah_biaya_admin_um').val('0');
   if ($('.akun_biaya_um').val() == '0') {
    $('.jumlah_biaya_admin_um ').attr('readonly',true);
   }else{
    $('.jumlah_biaya_admin_um ').attr('readonly',false);
   }
}

function hitung_um(){
    var sisa_terbayar = $('.sisa_terbayar_um').val();
    var jumlah_bayar = $('.jumlah_bayar').val();
    var jumlah_biaya_admin  = $('.jumlah_biaya_admin_um').val();
    jumlah_biaya_admin     = jumlah_biaya_admin.replace(/[^0-9\-]+/g,"");
    jumlah_biaya_admin     = parseFloat(jumlah_biaya_admin);
    var akun_biaya         = $('.akun_biaya_um').val();
    var jenis              = $('.jenis_biaya_um').val();



    if (jenis != 'K') {
        if (jumlah_biaya_admin > sisa_terbayar) {
            toastr.warning('Biaya Tidak Boleh Melebihi Sisa Piutang');
            $('.jumlah_biaya_admin_um').val('0');
            var jumlah_biaya_admin  = $('.jumlah_biaya_admin_um').val();
            jumlah_biaya_admin     = jumlah_biaya_admin.replace(/[^0-9\-]+/g,"");
            jumlah_biaya_admin     = parseFloat(jumlah_biaya_admin);
        }
        var hasil = sisa_terbayar - jumlah_bayar - jumlah_biaya_admin;

        $('.ed_total').val(accounting.formatMoney(hasil,"",2,'.',','));
        $('.total').val(hasil);
        
        var hasil1 = parseFloat(jumlah_bayar) + parseFloat(jumlah_biaya_admin);
        $('.total_bayar ').val(accounting.formatMoney(hasil1,"",2,'.',','));
    }else{
        toastr.warning('Jenis Akun Biaya Tidak Boleh Kredit');
        $('.akun_biaya_um').val('0').trigger('chosen:updated');
        akun_biaya_um();

    }




}
    


$('.append_um').click(function(){
    var seq_um      = $('.seq_um').val();
    var no_um       = $('.no_um').val();
    var nominal_um  = $('.nominal_um').val();
    var terpakai_um   = $('.terpakai_um').val();
    var status_um   = $('.status_um').val();
    var terpakai_um = $('.terpakai_um').val();
    var sisa_terbayar_um = $('.sisa_terbayar_um').val();
    var jumlah_bayar_um   = $('.jumlah_bayar_um ').val();
    jumlah_bayar_um  = jumlah_bayar_um.replace(/[^0-9\-]+/g,"");
    jumlah_bayar_um = parseFloat(jumlah_bayar_um);
    if (jumlah_bayar_um > terpakai_um) {
        toastr.warning('Jumlah Lebih Besar Dari Sisa Uang Muka');
        $('.jumlah_bayar_um ').val('0');
        return 1;
    }
    if (jumlah_bayar_um == 0 ||  jumlah_bayar_um =='') {
        toastr.warning('Jumlah Bayar Harus Diisi');
        return 1;
    }

    if (jumlah_bayar_um > sisa_terbayar_um) {
        toastr.warning('Jumlah Bayar Melebihi Sisa Piutang');
        $('.jumlah_bayar_um ').val('0');
        return 1;
    }
    
    var sisa_akhir = terpakai_um - jumlah_bayar_um;
    var index = simpan_um.indexOf(no_um);
    if (index == -1) {

            table_histori_um.row.add([
                    
                    '<p class="no_um_text">'+no_um+'</p>'
                    +'<input type="hidden" value="'+no_um+'" class="m_no_um m_um_'+no_um+'" name="m_no_um[]">',

                    '<p class="m_nominal_um_text">'+accounting.formatMoney(nominal_um,"",2,'.',',')+'</p>'+
                    '<input type="hidden" value="'+nominal_um+'" class="m_nominal_um">',

                    '<p class="m_terpakai_um_text">'+accounting.formatMoney(terpakai_um,"",2,'.',',')+'</p>'+
                    '<input type="hidden" value="'+terpakai_um+'" class="m_terpakai_um">',

                    '<p class="m_jumlah_bayar_um_text">'+accounting.formatMoney(jumlah_bayar_um,"",2,'.',',')+'</p>'+
                    '<input type="hidden" value="'+jumlah_bayar_um+'" class="m_jumlah_bayar_um" name="m_jumlah_bayar_um[]">',

                    '<p class="m_sisa_akhir_um_text">'+accounting.formatMoney(sisa_akhir,"",2,'.',',')+'</p>'+
                    '<input type="hidden" value="'+sisa_akhir+'" class="m_sisa_akhir_um" name="m_sisa_akhir_um[]">',

                    '<div class="btn-group ">'+
                    '<a  onclick="edit_um(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
                    '<a  onclick="hapus_um(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
                    '</div>',

                ]).draw();


            count_um++;

            simpan_um.push(no_um);
            var temp = 0;
            
            table_histori_um.$('.m_jumlah_bayar_um').each(function(){
                var ini = $(this).val();
                ini = parseFloat(ini);
                temp+=ini;
            });
            console.log(temp);
            $('.ed_jumlah_bayar').val(accounting.formatMoney(temp,"",2,'.',','));
            $('.jumlah_bayar').val(temp);
            $('.tabel_pembayaran_um input').val('');
            hitung_um();
    }else{
        var par = $('.m_um_'+no_um).parents('tr');
        table_histori_um.row(par).remove().draw(false);

        table_histori_um.row.add([
                    
                    '<p class="no_um_text">'+no_um+'</p>'
                    +'<input type="hidden" value="'+no_um+'" class="m_no_um m_um_'+no_um+'" name="m_no_um[]">',

                    '<p class="m_nominal_um_text">'+accounting.formatMoney(nominal_um,"",2,'.',',')+'</p>'+
                    '<input type="hidden" value="'+nominal_um+'" class="m_nominal_um">',

                    '<p class="m_terpakai_um_text">'+accounting.formatMoney(terpakai_um,"",2,'.',',')+'</p>'+
                    '<input type="hidden" value="'+terpakai_um+'" class="m_terpakai_um">',

                    '<p class="m_jumlah_bayar_um_text">'+accounting.formatMoney(jumlah_bayar_um,"",2,'.',',')+'</p>'+
                    '<input type="hidden" value="'+jumlah_bayar_um+'" class="m_jumlah_bayar_um" name="m_jumlah_bayar_um[]">',

                    '<p class="m_sisa_akhir_um_text">'+accounting.formatMoney(sisa_akhir,"",2,'.',',')+'</p>'+
                    '<input type="hidden" value="'+sisa_akhir+'" class="m_sisa_akhir_um" name="m_sisa_akhir_um[]">',

                    '<div class="btn-group ">'+
                    '<a  onclick="edit_um(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
                    '<a  onclick="hapus_um(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
                    '</div>',

                ]).draw();

            var temp = 0;
            
            table_histori_um.$('.m_jumlah_bayar_um').each(function(){
                var ini = $(this).val();
                ini = parseFloat(ini);
                temp+=ini;
            });
            console.log(temp);
            $('.ed_jumlah_bayar').val(accounting.formatMoney(temp,"",2,'.',','));
            $('.jumlah_bayar').val(temp);
            $('.tabel_pembayaran_um input').val('');
            hitung_um();
    }
    // hitung();

});






$('#save_um').click(function(){
    var customer = $('.customer').val();
    var ed_nomor_invoice = $('.ed_nomor_invoice').val();
    swal({
        title: "Apakah anda yakin?",
        text: "Simpan Data Uang Muka!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Simpan!",
        cancelButtonText: "Batal",
        closeOnConfirm: true
      },
      function(){

               // alert(accPiutang);
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

          $.ajax({
          url:baseUrl + '/sales/save_um_kwitansi',
          type:'post',
          dataType:'json',
          data:$('.tabel_header :input').serialize()
               +'&'+table_histori_um.$('input').serialize()
               +'&customer='+customer
               +'&ed_nomor_invoice='+ed_nomor_invoice,
          success:function(response){
                swal({
                    title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){

                        var jumlah_bayar         = $('.jumlah_bayar').val();
                        jumlah_bayar             = parseFloat(jumlah_bayar);
                        var akun_biaya           = $('.akun_biaya_um').val();
                        var jumlah_biaya_admin   = $('.jumlah_biaya_admin_um').val();
                        var jenis                = $('.jenis_biaya_um').val();
                        var akun_acc_biaya       = $('.akun_acc_biaya_um').val();

                        if (jumlah_biaya_admin == '') {
                            jumlah_biaya_admin = 0;
                        }else{
                            jumlah_biaya_admin       = jumlah_biaya_admin.replace(/[^0-9\-]+/g,"");
                            jumlah_biaya_admin       = parseFloat(jumlah_biaya_admin);
                        }

                        var angka                = $('.jumlah_bayar').val();
                        angka                    = angka.replace(/[^0-9\-]+/g,"");
                        angka                    = parseFloat(angka);
                        var ed_nomor_invoice     = $('.ed_nomor_invoice').val();
                        var par                  = $('.i_flag_'+ed_nomor_invoice).parents('tr');
                        var jumlah_biaya         = 0;
                        if (jenis == 'K') {
                            $(par).find('.i_kredit').val(jumlah_biaya_admin);
                        }else{
                            $(par).find('.i_debet').val(jumlah_biaya_admin);
                        }
                        $(par).find('.i_bayar_text').val(accounting.formatMoney(angka,"",2,'.',','));
                        $(par).find('.i_bayar').val(angka);
                        $(par).find('.i_akun_biaya').val(akun_biaya);
                        var temp = 0;

                        table_data.$('.i_bayar').each(function(){
                            var i_bayar = Math.round($(this).val()).toFixed(2);
                                i_bayar = parseFloat(i_bayar);
                            temp += i_bayar;
                        })

                        var temp1 = 0;
                        table_data.$('.i_debet').each(function(){
                            var i_bayar = Math.round($(this).val()).toFixed(2);
                                i_bayar = parseFloat(i_bayar);
                            temp1 += i_bayar;
                        })

                        var temp2 = 0;
                        table_data.$('.i_kredit').each(function(){
                            var i_bayar = Math.round($(this).val()).toFixed(2);
                                i_bayar = parseFloat(i_bayar);
                            temp2 += i_bayar;
                        });

                        $('.total_jumlah_bayar').val(temp);
                        $('.total_jumlah_bayar_text').val(accounting.formatMoney(temp,"",2,'.',','));
                        $('.ed_debet').val(temp1);
                        $('.ed_debet_text').val(accounting.formatMoney(temp1,"",2,'.',','));

                        $('.ed_kredit').val(temp2);
                        $('.ed_kredit_text').val(accounting.formatMoney(temp2,"",2,'.',','));

                        hitung_bayar();
                        $('#modal_um').modal('hide');
                });

          
          },
          error:function(data){
            swal({
            title: "Terjadi Kesalahan",
                    type: 'error',
                    timer: 900,
                   showConfirmButton: true

        });
       }
      });  
     });
})


function edit_um(a) {
    var par = $(a).parents('tr');
    var um = $(par).find('.m_no_um').val();

    var nota_kwitansi = $('#nota_kwitansi').val();
    var m_jumlah_bayar_um = $(par).find('.m_jumlah_bayar_um').val();
    var ed_nomor_invoice = $('.ed_nomor_invoice').val();

    m_jumlah_bayar_um = parseFloat(m_jumlah_bayar_um);
    $.ajax({
        url:baseUrl+'/sales/pilih_um',
        data:{um,nota_kwitansi,ed_nomor_invoice},
        dataType : 'json',
        success:function(response){
            $('.no_um').val(response.data[0].nomor);
            $('.nominal_um_text').val(accounting.formatMoney(response.data[0].jumlah,"",2,'.',','));
            $('.nominal_um').val(response.data[0].jumlah);
            if (response.status == 'E') {
                $('.terpakai_um_text').val(accounting.formatMoney(response.data[0].sisa_uang_muka,"",2,'.',','));
                $('.terpakai_um').val(response.data[0].sisa_uang_muka);
            }else{
                $('.terpakai_um_text').val(accounting.formatMoney(parseFloat(response.data[0].sisa_uang_muka)+m_jumlah_bayar_um,"",2,'.',','));
                $('.terpakai_um').val(parseFloat(response.data[0].sisa_uang_muka)+m_jumlah_bayar_um);
            }
            
            $('.status_um').val(response.data[0].status_um);
            $('#modal_cari_um').modal('hide');
            toastr.info('Edit Data Berhasil Diinisialisasi');
        },
        error:function(){
        }
    });

}
function hapus_um(a) {
    var par = $(a).parents('tr');
    var no  = $(par).find('.m_no_um').val();
    table_histori_um.row(par).remove().draw(false);
    var index = array_simpan.indexOf(no);
    simpan_um.splice(index,1);
    var temp = 0;
    
    table_histori_um.$('.m_jumlah_bayar_um').each(function(){
        var ini = $(this).val();
        ini = parseFloat(ini);
        temp+=ini;
    });
    console.log(temp);
    $('.ed_jumlah_bayar').val(accounting.formatMoney(temp,"",2,'.',','));
    $('.jumlah_bayar').val(temp);
    $('.tabel_pembayaran_um input').val('');
    hitung_um();

}


$('#btnsimpan').click(function(){
    var customer = $('.customer').val();
    swal({
        title: "Apakah anda yakin?",
        text: "Simpan Data Kwitansi!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Simpan!",
        cancelButtonText: "Batal",
        closeOnConfirm: true
      },
      function(){

               // alert(accPiutang);
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

          $.ajax({
          url:baseUrl + '/sales/simpan_kwitansi',
          type:'post',
          dataType:'json',
          data:$('.tabel_header :input').serialize()
               +'&'+table_data.$('input').serialize()
               +'&'+table_data_biaya.$('input').serialize()
               +'&'+tabel_uang_muka.$('input').serialize()
               +'&'+$('.table_rincian :input').serialize()
               +'&customer='+customer,
          success:function(response){
            if (response.status == 1) {
                swal({
                    title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){
                        // location.reload();
                        $('.temp_1').addClass('disabled');
                        $('.print').removeClass('disabled');
                        $('.flag_nota').val('success');
                });
            }else{
                $('#nota_kwitansi').val(response.nota);
                toastr.info('Nomor Kwitansi Telah Dirubah Menjadi '+response.nota);
                $('#btnsimpan').click();
            }
          },
          error:function(data){
            swal({
            title: "Terjadi Kesalahan",
                    type: 'error',
                    timer: 900,
                   showConfirmButton: true

        });
       }
      });  
     });
})

$('.reload').click(function(){
    location.reload();
})

$('.print').click(function(){
    var id = $('#nota_kwitansi').val();

    window.open('{{url("sales/kwitansi/cetak_nota")}}'+'/'+id);
});


window.onbeforeunload = function(event)
{       
            var flag_nota = $('.flag_nota').val();
            $.ajax({
            url:baseUrl + '/sales/hapus_um_kwitansi',
            data:$('.tabel_header :input').serialize()
                 +'&'+table_data.$('input').serialize()
                 +'&flag='+'R'
                 +'&flag_nota='+flag_nota,
            dataType:'json',
            success:function(response){
            }
            })


};

</script>

@endsection
