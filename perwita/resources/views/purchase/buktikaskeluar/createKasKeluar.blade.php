@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css" media="screen">
  .center{
    text-align: center;
  }
  .right{
    text-align: right;
  }
  .huruf_besar{
    text-transform: uppercase;
  }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
      <h2> Pembayaran Kas </h2>
      <ol class="breadcrumb">
          <li>
              <a>Home</a>
          </li>
          <li>
              <a>Purchase</a>
          </li>
          <li>
            <a> Transaksi Purchase</a>
          </li>
          <li>
            <a> Bukti Kas Keluar</a>
          </li>
          <li class="active">
              <strong>Create</strong>
          </li>

      </ol>
  </div>
  <div class="col-lg-2">

  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
  <div class="col-lg-12" >
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5> 
         <!-- {{Session::get('comp_year')}} -->
        </h5>
        <h3>Bukti Kas Keluar</h3>
      </div>
        <div class="ibox-content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box" id="seragam_box">
                <div class="box-header">
                  </div><!-- /.box-header -->
                    <div class="box-body" >
                      <div class="col-sm-12" style="border-bottom: 0.5px solid #8888">
                        <div class="col-sm-6">
                          <table class="table table-bordered table_header">
                            <tr>
                              <td width="120">No Transaksi</td>
                              <td colspan="2"><input class="form-control nota" type="text" readonly="" name="nota"></td>
                            </tr>
                            <tr>
                              <td width="120">Tanggal</td>
                              <td colspan="2"><input value="{{ $now }}" class="form-control tanggal" type="text" readonly="" name="tanggal"></td>
                            </tr>
                            <tr>
                                @if(Auth::user()->punyaAkses('Bukti Kas Keluar','cabang'))
                                <td style="padding-top: 0.4cm">Cabang</td>
                                @endif
                                @if(Auth::user()->punyaAkses('Bukti Kas Keluar','cabang'))
                                <td>
                                    <select class="form-control chosen-select-width cabang" name="cabang">
                                        @foreach ($cabang as $row)
                                        <option @if(Auth::user()->kode_cabang == $row->kode) selected="" @endif value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                        @endforeach
                                    </select>
                                </td>
                                @else
                                <td class="disabled" hidden="">
                                    <select class="form-control chosen-select-width cabang" name="cabang">
                                        @foreach ($cabang as $row)
                                        <option @if(Auth::user()->kode_cabang == $row->kode) selected="" @endif value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                        @endforeach
                                    </select>
                                </td>
                                @endif
                            </tr>
                            <tr>
                              <td width="120">Jenis Bayar</td>
                              <td class="jenis_bayar_td" colspan="2">
                                <select class="form-control chosen-select-width jenis_bayar" name="jenis_bayar">
                                  <option value="0">Pilih - Jenis</option>
                                  @foreach($jenis_bayar as $val)
                                    <option @if($val->idjenisbayar == 8) selected="" @endif value="{{ $val->idjenisbayar }}">{{ $val->jenisbayar }}</option>
                                  @endforeach
                                </select>
                              </td>
                            </tr>
                            <tr class="supplier_patty_tr">
                              <td width="120">Pemohon</td>
                              <td colspan="2">
                                <input type="text" class="form-control huruf_besar supplier_patty"  name="supplier_patty">
                              </td>
                            </tr>
                            <tr hidden="" class="supplier_faktur_tr">
                              <td width="120">Supplier</td>
                              <td colspan="2" class="supplier_faktur_td">
                                <select class="form-control supplier_faktur" name="supplier_faktur">
                                  <option value="0">Pilih - Supplier</option>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Keterangan</td>
                              <td colspan="2">
                                <input maxlength="300" class="form-control huruf_besar keterangan_head" type="text" name="keterangan_head">
                              </td>
                            </tr>
                          </table>
                        </div>
                        <div class="col-sm-6">
                          <table class="table table-bordered table_jurnal">
                            <tr>
                              <td align="center" colspan="2">POSTING JURNAL</td>
                            </tr>
                            <tr>
                              <td width="120">HUTANG</td>
                              <td><input style="text-align: right" value="0" class="form-control hutang" readonly="" type="text" name="hutang"></td>
                            </tr>
                            <tr>
                              <td width="120">KAS</td>
                              <td class="kas_td">
                                <select class="form-control kas" name="kas">
                                  <option value="0">Pilih - Kas</option>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td width="120">UANG MUKA</td>
                              <td><input style="text-align: right" value="0" class="form-control uang_muka" readonly="" type="text" name="uang_muka"></td>
                            </tr>
                          </table>
                          <table class="table table-bordered table_total">
                            <tr>
                              <td width="120">TOTAL</td>
                              <td>
                                <input type="text" style="text-align: right" value="0" class="form-control total" readonly=""  name="total">
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      {{-- petty cash TR --}}
                      <div class="col-sm-12 patty_cash_div penanda_patty"  >
                        <div class="col-sm-6">
                          <table class="table table-bordered form_patty" >
                            <caption style="text-align: center"><h3>PETTY CASH</h3></caption>
                            <tr>
                              <td width="120">Nomor</td>
                              <td>
                                <input type="text"  readonly="" class="form-control patty_nomor" value="1" class="patty_nomor">
                                <input type="hidden" class="form-control flag_patty" class="flag_patty">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Akun Biaya</td>
                              <td class="akun_biaya_td">
                                <select class="form-control akun_biaya">
                                  <option value=""></option>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td width="120">DEBET/KREDIT</td>
                              <td>
                                <select class="form-control dk_patty">
                                  <option value="DEBET">DEBET</option>
                                  <option value="KREDIT">KREDIT</option>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Keterangan</td>
                              <td>
                                <input maxlength="300" class="form-control keterangan_patty huruf_besar" type="text" class="keterangan_patty">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Nominal</td>
                              <td>
                                <input style="text-align: right" class="form-control nominal_patty" value="0" type="text" class="nominal_patty">
                              </td>
                            </tr>

                          </table>
                          <table class="table">
                            <tr>
                              <td >
                                <button style="margin-left: 5px;" type="button" class="btn btn-info pull-right reload" onclick="reload()"><i class="fa fa-refresh">&nbsp;Reload</i></button>

                                <button style="margin-left: 5px;" type="button" class="btn btn-warning pull-right print_petty disabled" onclick="printing()"><i class="fa fa-print">&nbsp;print</i></button>

                                <button style="margin-left: 5px;" type="button" class="btn btn-primary pull-right disabled" id="save_patty" onclick="save_patty()"><i class="fa fa-save">&nbsp;Simpan Data</i></button>
                                
                                <button style="margin-left: 5px;" type="button" class="btn btn-danger pull-right append_petty"><i class="fa fa-plus">&nbsp;Append</i></button>
                              </td>
                            </tr>
                          </table>
                        </div>
                        <div class="col-sm-12">
                          <table class="table table_patty table-bordered">
                            <thead>
                              <tr>
                                <th width="20">No</th>
                                <th>Akun Biaya</th>
                                <th>Jumlah Bayar</th>
                                <th>Keterangan</th>
                                <th>D/K</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                              
                            </tbody>
                          </table>
                        </div>
                      </div><!-- /.end patty cash tr -->
                      {{-- form faktur --}}
                      <div hidden="" class="col-sm-12 faktur_div penanda_faktur" style="border-bottom: 0.5px solid #8888; margin-top: 10px;">
                        <div class="col-sm-8 detail_biaya">
                        <div class="col-sm-8 ">
                          <caption><h2>Detail Biaya</h2></caption>
                          <table class="table  " >
                            <tr >
                              <td style="border: none" width="120">Filter</td>
                              <td style="border: none" colspan="2">
                                <select class="form-control filter_faktur" name="filter_faktur" >
                                  <option value="faktur">Faktur</option>
                                  <option value="tanggal">Tanggal</option>
                                  <option value="jatuh_tempo">Jatuh Tempo</option>
                                </select>
                              </td>
                            </tr>
                            <tr class="faktur_tr">
                              <td style="border: none" width="120">Faktur</td>
                              <td style="border: none">
                                <input  readonly="" class="form-control faktur_nomor" type="text" class="faktur_nomor">
                              </td>
                              <td style="border: none" align="right">
                                <button type="button" class="btn btn-primary" onclick="cari_faktur()"><i class="fa fa-search" > Cari Faktur</i></button>
                              </td>
                            </tr>
                            <tr hidden="" class="periode_tr">
                              <td style="border: none" width="120">Periode</td>
                              <td style="border: none">
                                <input readonly="" class="form-control periode" value="1" type="text" class="periode">
                              </td>
                              <td style="border: none" align="right">
                                <button type="button" class="btn btn-primary" onclick="cari_faktur()"><i class="fa fa-search" > Cari Faktur</i></button>
                              </td>
                            </tr>
                            <tr hidden="" class="jatuh_tempo_tr">
                              <td style="border: none" width="120">Jatuh Tempo</td>
                              <td style="border: none">
                                <input readonly="" class="form-control jatuh_tempo" value="1" type="text" class="jatuh_tempo">
                              </td>
                              <td style="border: none" align="right">
                                <button type="button" class="btn btn-primary" onclick="cari_faktur()"><i class="fa fa-search"> Cari Faktur</i></button>
                              </td>
                            </tr>
                            <tr>
                              <td style="border: none" width="120">No Tanda Terima</td>
                              <td style="border: none" colspan="2">
                                <input readonly="" class="form-control tanda_terima" type="text" class="tanda_terima">
                              </td>
                            </tr>
                          </table>
                        </div>

                        <div class="col-sm-12 histori">
                                                   <!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                              <a href="#histori_faktur" aria-controls="home" role="tab" data-toggle="tab">Pembayaran</a>
                            </li>
                            <li role="presentation">
                              <a href="#return_faktur" aria-controls="profile" role="tab" data-toggle="tab">Return</a>
                            </li>
                            <li role="presentation">
                              <a href="#kredit_faktur" aria-controls="messages" role="tab" data-toggle="tab">Kredit Nota</a></li>
                            <li role="presentation">
                              <a href="#debet_faktur" aria-controls="settings" role="tab" data-toggle="tab">Debet Nota</a>
                            </li>
                          </ul>
                          <!-- Tab panes -->
                          <div class="tab-content" style="margin-top: 10px">
                            <div role="tabpanel" class="tab-pane fade in active" id="histori_faktur">
                              <table class="table histori_tabel" >
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>No Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah Bayar</th>
                                  </tr>
                                </thead>
                                <tbody>
                                 
                                </tbody>
                              </table>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="return_faktur">
                              <table class="table return_tabel">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>No Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah Bayar</th>
                                  </tr>
                                </thead>
                                <tbody>
                                 
                                </tbody>
                              </table>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="kredit_faktur">
                              <table class="table kredit_tabel">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>No Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah Bayar</th>
                                  </tr>
                                </thead>
                                <tbody>
                                 
                                </tbody>
                              </table>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="debet_faktur">
                              <table class="table debet_tabel">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>No Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah Bayar</th>
                                  </tr>
                                </thead>
                                <tbody>
                                 
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                        </div>
                        <div class="col-sm-4 keterangan_biaya" >
                          <table class="table table-bordered">
                            <tr>
                              <td width="120">Total Biaya Faktur</td>
                              <td>
                                <input type="text" readonly="" class="biaya_detail form-control" name="biaya_faktur">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Terbayar</td>
                              <td>
                                <input type="text" readonly="" class="terbayar_detail form-control" name="terbayar_detail">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Return Pembelian</td>
                              <td>
                                <input type="text" readonly="" class="return_detail form-control" name="pembayaran_faktur">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Debet Nota</td>
                              <td>
                                <input type="text" readonly="" class="debet_detail form-control" name="debet_detail">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Kredit Nota</td>
                              <td>
                                <input type="text" readonly="" class="kredit_detail form-control" name="kredit_detail">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Sisa Pembayaran</td>
                              <td>
                                <input type="text" readonly="" class="sisa_detail form-control" name="sisa_detail">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Pelunasan</td>
                              <td>
                                <input type="text" readonly="" class="pelunasan_detail form-control" name="pelunasan_detail">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Sisa Pembayaran Akhir</td>
                              <td>
                                <input type="text" readonly="" class="total_detail form-control" name="total_detail">
                              </td>
                            </tr>
                          </table>
                        </div>
                        <div class="col-sm-12" style="margin-top: 10px;">
                        <caption><h2>Detail Faktur</h2></caption>
                        <table class="table tabel_faktur">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Faktur</th>
                              <th>Tanggal</th>
                              <th>Akun</th>
                              <th>Total Faktur</th>
                              <th>Pelunasan</th>
                              <th>Keterangan</th>
                              <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                        </table>
                      </div>
                      </div>{{-- <-end form faktur --}}
                      {{-- form uang muka --}}
                      <div hidden="" class="col-sm-12 uang_muka_div penanda_um"  >
                        <div class="col-sm-6">
                          <table class="table table-bordered form_um" >
                            <caption style="text-align: center"><h3>UANG MUKA</h3></caption>
                            <tr>
                              <td width="120">Nomor</td>
                              <td colspan="2">
                                <input readonly="" class="form-control patty_nomor" value="1" type="text" class="patty_nomor">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">No Uang Muka</td>
                              <td>
                                <input readonly="" class="form-control patty_nomor"  type="text" class="nomor_um">
                              </td>
                              <td align="center" style="border: none">
                                <button type="button" class="btn btn-primary" onclick="cari_um()"><i class="fa fa-search" > Cari UM</i></button>
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Supplier</td>
                              <td colspan="2">
                                <select class="form-control supplier_um">
                                  <option value="">Pilih - Supplier</option>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Keterangan</td>
                              <td colspan="2">
                                <input class="form-control keterangan_patty" type="text" class="keterangan_patty">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Nominal</td>
                              <td colspan="2">
                                <input style="text-align: right" class="form-control nominal_patty" value="0" type="text" class="nominal_patty">
                              </td>
                            </tr>

                          </table>
                          <table class="table">
                            <tr>
                              <td >
                                <button style="margin-left: 5px;" type="button" class="btn btn-info pull-right reload" onclick="reload()"><i class="fa fa-refresh">&nbsp;Reload</i></button>

                                <button style="margin-left: 5px;" type="button" class="btn btn-warning pull-right print_patty disabled" onclick="printing()"><i class="fa fa-print">&nbsp;print</i></button>

                                <button style="margin-left: 5px;" type="button" class="btn btn-primary pull-right disabled" id="save_patty" onclick="save_pat()"><i class="fa fa-save">&nbsp;Simpan Data</i></button>
                                
                                <button style="margin-left: 5px;" type="button" class="btn btn-danger pull-right cari-pod"><i class="fa fa-plus">&nbsp;Append</i></button>
                              </td>
                            </tr>
                          </table>
                        </div>
                        <div class="col-sm-12">
                          <table class="table table_um">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Jumlah Bayar</th>
                                <th>Akun Biaya</th>
                                <th>Keterangan</th>
                                <th>D/K</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                              
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div><!-- /.box-body -->
                  </div><!-- /.box-footer -->
                </div><!-- /.box -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div>
        </div>
      </div>
    </div>

    <div class="modal_faktur fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Pilih Faktur</h4>
          </div>
          <div class="modal-body">
            <table>
              <thead>
                <tr onclick="pilih_faktur(this)">
                  <th>No</th>
                  <th>No Faktur</th>
                  <th>Tanggal</th>
                  <th>Jatuh Tempo</th>
                  <th>Harga Faktur</th>
                  <th>No Tanda Terima</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>data</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
  {{-- Note: PENANDA_PATTY UNTUK MENCARI DIV PATTY
             PENANDA_Faktur UNTUK MENCARI DIV FAKTUR
             PENANDA_UM UNTUK MENCARI DIV UANG MUKA 
  --}}
  $('.tanggal').datepicker({
    format:'dd/mm/yyyy'
  });

  $('.periode').daterangepicker({
    format:'dd/mm/yyyy'
  });

  $('.jatuh_tempo').daterangepicker({
    format:'dd/mm/yyyy'
  });
  // GLOBAL VARIABLE
    var seq = 0;
    var table_patty   = $('.table_patty').DataTable({
                          columnDefs: [
                              {
                                 targets: 0,
                                 className: 'center'
                              },
                              {
                                 targets: 2,
                                 className: 'right'
                              },
                              {
                                 targets: 4,
                                 className: 'center'
                              },
                              {
                                 targets: 5,
                                 className: 'center'
                              }
                           ]
                        });
    var histori_tabel = $('.histori_tabel').DataTable();
    var return_tabel  = $('.return_tabel').DataTable();
    var debet_tabel   = $('.debet_tabel').DataTable();
    var kredit_tabel  = $('.kredit_tabel').DataTable();
    var tabel_faktur  = $('.tabel_faktur').DataTable();
    var table_um      = $('.table_um').DataTable();
  // 

  $(document).ready(function(){
    $('.nominal_patty').maskMoney({precision:0,thousands:'.',allowZero:true,defaultZero: true});

    var cabang = $('.cabang').val();
    $.ajax({
        url:baseUrl + '/buktikaskeluar/nota_bukti_kas',
        type:'get',
        data:{cabang},
        dataType:'json',
        success:function(data){
           $('.nota').val(data.nota);
        },
        error:function(data){
            location.reload();
        }
    }); 

    $.ajax({
        url:baseUrl + '/buktikaskeluar/akun_kas_dropdown',
        type:'get',
        data:{cabang},
        success:function(data){
           $('.kas_td').html(data);
        },
        error:function(data){
            location.reload();
        }
    }); 

    $.ajax({
        url:baseUrl + '/buktikaskeluar/akun_biaya_dropdown',
        type:'get',
        data:{cabang},
        success:function(data){
           $('.akun_biaya_td').html(data);
        },
        error:function(data){
            location.reload();
        }
    }); 
  });

  $('.cabang').change(function(){
    var cabang = $('.cabang').val();
    $.ajax({
        url:baseUrl + '/buktikaskeluar/nota_bukti_kas',
        type:'get',
        data:{cabang},
        dataType:'json',
        success:function(data){
           $('.nota').val(data.nota);
        },
        error:function(data){
        }
    }); 

    $.ajax({
        url:baseUrl + '/buktikaskeluar/akun_kas_dropdown',
        type:'get',
        data:{cabang},
        success:function(data){
           $('.kas_td').html(data);
        },
        error:function(data){
        }
    }); 

    $.ajax({
        url:baseUrl + '/buktikaskeluar/akun_biaya_dropdown',
        type:'get',
        data:{cabang},
        success:function(data){
           $('.akun_biaya_td').html(data);
        },
        error:function(data){
        }
    }); 
  })

  $('.jenis_bayar').change(function(){
    if ($(this).val() == 8) {
      $('.supplier_patty_tr').prop('hidden',false);
      $('.supplier_faktur_tr').prop('hidden',true);
      $('.patty_cash_div').prop('hidden',false);
      $('.faktur_div').prop('hidden',true);
      $('.uang_muka_div').prop('hidden',true);
    }else if ($(this).val() == 4) {
      $('.supplier_patty_tr').prop('hidden',true);
      $('.supplier_faktur_tr').prop('hidden',false);
      $('.patty_cash_div').prop('hidden',true);
      $('.faktur_div').prop('hidden',true);
      $('.uang_muka_div').prop('hidden',false);
    }else {
      $('.supplier_patty_tr').prop('hidden',true);
      $('.supplier_faktur_tr').prop('hidden',false);
      $('.patty_cash_div').prop('hidden',true);
      $('.faktur_div').prop('hidden',false);
      $('.uang_muka_div').prop('hidden',true);
    }

    var jenis_bayar = $(this).val();
    $.ajax({
        url:baseUrl + '/buktikaskeluar/supplier_dropdown',
        type:'get',
        data:{jenis_bayar},
        success:function(data){
          $('.supplier_faktur ').val('0').trigger('chosen:updated');
          $('.supplier_faktur_td').html(data);
        },
        error:function(data){
        }
    }); 
  })



  $('.filter_faktur').change(function(){
    if ($(this).val() == 'faktur') {
      $('.faktur_tr').prop('hidden',false);
      $('.periode_tr').prop('hidden',true);
      $('.jatuh_tempo_tr').prop('hidden',true);
    }else if ($(this).val() == 'tanggal') {
      $('.faktur_tr').prop('hidden',true);
      $('.periode_tr').prop('hidden',false);
      $('.jatuh_tempo_tr').prop('hidden',true);
    }else  if ($(this).val() == 'jatuh_tempo') {
      $('.faktur_tr').prop('hidden',true);
      $('.periode_tr').prop('hidden',true);
      $('.jatuh_tempo_tr').prop('hidden',false);
    }
  })

  // PATTY CASH SCRIPT
  function hitung_pt() {
    var total = 0;
    $('.pt_nominal').each(function(){
      total += parseInt($(this).val());
    });

    $('.total').val(accounting.formatMoney(total,"", 0, ".",','));
  }
  $('.append_petty').click(function(){
    var patty_nomor         = $('.patty_nomor').val();
    var akun_biaya          = $('.akun_biaya').val();
    var akun_biaya_text     = $('.akun_biaya :selected').text();
    var dk_patty            = $('.dk_patty').val();
    var keterangan_patty    = $('.keterangan_patty').val();
    var nominal_patty       = $('.nominal_patty').val();
    nominal_patty           = nominal_patty.replace(/[^0-9\-]+/g,"");
    var supplier_patty      = $('.supplier_patty').val();
    var flag_patty          = $('.flag_patty').val();

    // VALIDASI
    if (supplier_patty == '') {
      toastr.warning('Nama Pemohon Harus Diisi');
      return false;
    }

    if (akun_biaya == '0') {
      toastr.warning('Harap Memilih Akun Biaya');
      return false;
    }

    if (keterangan_patty == '') {
      toastr.warning('Keterangan Harus Diisi');
      return false;
    }

    if (nominal_patty == '0') {
      toastr.warning('Nominal Tidak Boleh 0');
      return false;
    }
    if (flag_patty == '') {
      table_patty.row.add([
        '<p class="pt_seq_text">'+patty_nomor+'</p>'+
        '<input type="hidden" name="pt_seq[]" class="pt_seq_'+patty_nomor+' pt_seq" value="'+patty_nomor+'">',

        '<p class="pt_akun_biaya_text">'+akun_biaya_text+'</p>'+
        '<input type="hidden" name="pt_akun_biaya[]" class="pt_akun_biaya" value="'+akun_biaya+'">',

        '<p class="pt_nominal_text">'+accounting.formatMoney(nominal_patty,"", 0, ".",',')+'</p>'+
        '<input type="hidden" name="pt_nominal[]" class="pt_nominal" value="'+nominal_patty+'">',

        '<p class="pt_keterangan_text">'+keterangan_patty+'</p>'+
        '<input type="hidden" name="pt_keterangan[]" class="pt_keterangan" value="'+keterangan_patty+'">',

        '<p class="pt_debet_text">'+dk_patty+'</p>'+
        '<input type="hidden" name="pt_debet[]" class="pt_debet" value="'+dk_patty+'">',

        '<div class="btn-group">'+
        '<button onclick="pt_edit(this)" type="button" class="btn btn-sm btn-warning"><i class="fa fa-pencil" title="Edit"></i></button>'+
        '<button onclick="pt_hapus(this)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash " title="Hapus"></i></button>'+
        '</div>',
      ]).draw();
      seq = parseInt(patty_nomor)+1;
      toastr.success('Data Berhasil Di Append');
    }else{
      var par = $('.pt_seq_'+flag_patty).parents('tr');
      var pt_seq_text        = $(par).find('.pt_seq_text').text(patty_nomor);
      var pt_akun_biaya_text = $(par).find('.pt_akun_biaya_text').text(akun_biaya_text);
      var pt_nominal_text    = $(par).find('.pt_nominal_text').text(accounting.formatMoney(nominal_patty,"", 0, ".",','));
      var pt_keterangan_text = $(par).find('.pt_keterangan_text').text(keterangan_patty);
      var pt_debet_text      = $(par).find('.pt_debet_text').text(dk_patty);

      var pt_seq        = $(par).find('.pt_seq').val(patty_nomor);
      var pt_akun_biaya = $(par).find('.pt_akun_biaya').val(akun_biaya);
      var pt_nominal    = $(par).find('.pt_nominal').val(nominal_patty);
      var pt_keterangan = $(par).find('.pt_keterangan').val(keterangan_patty);
      var pt_debet      = $(par).find('.pt_debet').val(dk_patty);
      toastr.success('Data Berhasil Di Update');
    }

    $('.jenis_bayar_td').addClass('disabled');
    $('.supplier_patty_td').addClass('disabled');
    $('.form_patty :input').val('')
    $('.form_patty .akun_biaya').val('0').trigger('chosen:updated');
    $('.form_patty .nominal_patty').val('0');
    $('.form_patty .dk_patty').val('DEBET');
    $('.form_patty .patty_nomor').val(seq);
    $('#save_patty').removeClass('disabled');

    hitung_pt();
  });

  function pt_edit(a) {
    var par                 = $(a).parents('tr');
    var pt_seq              = $(par).find('.pt_seq').val();
    var pt_akun_biaya       = $(par).find('.pt_akun_biaya').val();
    var pt_nominal          = $(par).find('.pt_nominal').val();
    var pt_keterangan       = $(par).find('.pt_keterangan').val();
    var pt_debet            = $(par).find('.pt_debet').val();
    console.log(pt_keterangan);
    $('.patty_nomor').val(pt_seq);
    $('.flag_patty').val(pt_seq);
    $('.dk_patty').val(pt_debet);
    $('.keterangan_patty').val(pt_keterangan);
    $('.nominal_patty').val(accounting.formatMoney(pt_nominal,"", 0, ".",','));
    $('.akun_biaya').val(pt_akun_biaya).trigger('chosen:updated');
    toastr.info('Data Berhasil Di Inisialisasi');

  }

  function pt_hapus(a) {
    var par = $(a).parents('tr');
    table_patty.row(par).remove().draw(false);
    toastr.info('Data Berhasil Di Hapus');
    hitung_pt();
  }

  function save_patty() {

    swal({
    title: "Apakah anda yakin?",
    text: "Simpan Bukti Kas Keluar!",
    type: "warning",
    showCancelButton: true,
    showLoaderOnConfirm: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Simpan!",
    cancelButtonText: "Batal",
    closeOnConfirm: false
    },function(){

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      $.ajax({
        url:baseUrl + '/buktikaskeluar/save_patty',
        type:'get',
        data:$('.table_header :input').serialize()+'&'+
             $('.table_jurnal :input').serialize()+'&'+
             $('.table_total :input').serialize()+'&'+
             table_patty.$('input').serialize(),
        dataType:'json',
        success:function(data){
          swal({
          title: "Berhasil!",
                  type: 'success',
                  text: "Data Berhasil Dihapus",
                  timer: 2000,
                  showConfirmButton: true
                  },function(){
                     
          });
        },
        error:function(data){
        }
      }); 
    });
  }


</script>
@endsection
