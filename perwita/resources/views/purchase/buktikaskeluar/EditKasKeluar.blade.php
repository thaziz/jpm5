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
  .mrgin{
    margin-right: 10px;
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
              <strong>Edit</strong>
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
        <h3>
          Bukti Kas Keluar
        <a href="../index" class="pull-right" style="color: grey; float: right;"><i class="fa fa-arrow-left"> Kembali</i></a>
        <a class="pull-right jurnal" style="margin-right: 20px;"><i class="fa fa-eye"> Lihat Jurnal</i></a>
        </h3>
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
                              <td colspan="2">
                                <input class="form-control nota" value="{{$data->bkk_nota}}" type="text" readonly="" name="nota">
                                <input class="form-control id_header" type="hidden" value="{{$id}}" name="id_header">
                              </td>
                            </tr>
                            <tr>
                              <td width="120" class="">Tanggal</td>
                              <td colspan="2" class="disabled"><input value="{{ carbon\carbon::parse($data->bkk_tgl)->format('d/m/Y') }}" class="form-control tanggal" type="text" readonly="" name="tanggal"></td>
                            </tr>
                            <tr>
                                <td>Cabang</td>
                                <td class="disabled">
                                    <select class="form-control chosen-select-width cabang" name="cabang">
                                        @foreach ($cabang as $row)
                                        <option @if($data->bkk_comp == $row->kode) selected="" @endif value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr class="disabled">
                              <td width="120">Jenis Bayar</td>
                              <td class="jenis_bayar_td disabled" colspan="2">
                                <select class="form-control chosen-select-width jenis_bayar" name="jenis_bayar">
                                  <option value="0">Pilih - Jenis</option>
                                  @foreach($jenis_bayar as $val)
                                    <option @if($data->bkk_jenisbayar == $val->idjenisbayar) selected="" @endif value="{{ $val->idjenisbayar }}">{{ $val->jenisbayar }}</option>
                                  @endforeach
                                </select>
                              </td>
                            </tr>
                            <tr class="supplier_patty_tr">
                              <td width="120">Pemohon</td>
                              <td colspan="2">
                                <input type="text" value="{{ $data->bkk_supplier }}" class="form-control huruf_besar supplier_patty"  name="supplier_patty">
                              </td>
                            </tr>
                            <tr hidden="" class="supplier_faktur_tr disabled">
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
                                <input maxlength="300" value="{{$data->bkk_keterangan}}" class="form-control huruf_besar keterangan_head" type="text" name="keterangan_head">
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
                              <td><input style="text-align: right" value="{{$data->bkk_akun_hutang}}" class="form-control hutang" readonly="" type="text" name="hutang"></td>
                            </tr>
                            <tr>
                              <td width="120">KAS</td>
                              <td class="kas_td">
                                <select class="form-control kas" name="kas">
                                  <option value="0">Pilih - Kas</option>
                                </select>
                              </td>
                            </tr>
                          </table>
                          <table class="table table-bordered table_total">
                            <tr>
                              <td width="120">TOTAL</td>
                              <td>
                                <input type="text" style="text-align: right" value="{{ number_format($data->bkk_total, 2, ",", ".") }}" class="form-control total" readonly=""  name="total">
                              </td>
                            </tr>
                          </table>
                          @if ($data->bkk_jenisbayar == 11)
                            <table class="table table-bordered table_bonsem" hidden="">
                            <tr>
                              <td width="120">NOTA BONSEM</td>
                              <td>
                                <input type="text" style="text-align: left" placeholder="Klik disini untuk menambah bonsem" class="form-control nota_bonsem" readonly="" value="{{ $data->bkk_nota_bonsem }}" name="nota_bonsem">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">SISA BONSEM</td>
                              <td>
                                <input type="text" style="text-align: right" value="{{ $bonsem->bp_sisapemakaian }}" class="form-control sisa_bonsem" readonly=""  name="sisa_bonsem">
                                <input type="hidden" style="text-align: right"  class="form-control sisa_bonsem_master" readonly=""  name="sisa_bonsem_master" value="{{ $bonsem->bp_sisapemakaian+$data->bkk_nominal_bonsem }}">
                              </td>
                            </tr>
                          </table>
                          @else
                          <table class="table table-bordered table_bonsem" hidden="">
                            <tr>
                              <td width="120">NOTA BONSEM</td>
                              <td>
                                <input type="text" style="text-align: left" placeholder="Klik disini untuk menambah bonsem" class="form-control nota_bonsem" readonly="" value="{{ $data->bkk_nota_bonsem }}" name="nota_bonsem">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">SISA BONSEM</td>
                              <td>
                                <input type="text" style="text-align: right" value="0" class="form-control sisa_bonsem" readonly=""  name="sisa_bonsem">
                                <input type="hidden" style="text-align: right"  class="form-control sisa_bonsem_master" readonly=""  name="sisa_bonsem_master" value="0">
                              </td>
                            </tr>
                          </table>
                          @endif
                          
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

                                <button style="margin-left: 5px;" type="button" class="btn btn-warning pull-right print_petty " onclick="printing()"><i class="fa fa-print">&nbsp;print</i></button>

                                <button style="margin-left: 5px;" type="button" class="btn btn-primary pull-right " id="save_patty" onclick="save_patty()"><i class="fa fa-save">&nbsp;Simpan Data</i></button>
                                
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
                        <div class="col-sm-8 form_histori">
                        <div class="col-sm-8 ">
                          <caption><h2>Detail Biaya</h2></caption>
                          <table class="table  " >
                            <tr >
                              <td style="border: none" width="120">`</td>
                              <td style="border: none" colspan="2">
                                <select class="form-control filter_faktur" name="filter_faktur" >
                                  <option value="faktur">Nomor Bukti</option>
                                  <option value="tanggal">Tanggal</option>
                                  <option value="jatuh_tempo">Jatuh Tempo</option>
                                </select>
                              </td>
                            </tr>
                            <tr class="faktur_tr">
                              <td style="border: none" width="120">Faktur</td>
                              <td style="border: none">
                                <input  class="form-control faktur_nomor" type="text" class="faktur_nomor">
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
                           {{--  <tr>
                              <td style="border: none" width="120">No Tanda Terima</td>
                              <td style="border: none" colspan="2">
                                <input readonly="" class="form-control tanda_terima" type="text" class="tanda_terima">
                              </td>
                            </tr> --}}
                          </table>
                        </div>

                        <div class="col-sm-12 histori">
                                                   <!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                              <a href="#histori_faktur" role="tab" data-toggle="tab">Pembayaran</a>
                            </li>
                            <li role="presentation">
                              <a href="#kredit_faktur" role="tab" data-toggle="tab">Kredit Nota</a></li>
                            <li role="presentation">
                              <a href="#debet_faktur" role="tab" data-toggle="tab">Debet Nota</a>
                            </li>
                            <li role="presentation">
                              <a href="#um_faktur" role="tab" data-toggle="tab">Uang Muka</a>
                            </li>
                          </ul>
                          <!-- Tab panes -->
                          <div class="tab-content" style="margin-top: 10px">
                            <div role="tabpanel" class="tab-pane fade in active " id="histori_faktur">
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
                            <div role="tabpanel" class="tab-pane fade" id="um_faktur">
                              <table class="table um_tabel">
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
                          <table class="table table-bordered detail_biaya">
                            <tr>
                              <td width="120">Total Biaya Faktur</td>
                              <td>
                                <input type="text" readonly="" class="biaya_detail form-control right" name="biaya_faktur">
                                <input type="hidden" readonly="" class="flag_detail form-control right" name="flag_detail">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Terbayar</td>
                              <td>
                                <input type="text" readonly="" class="terbayar_detail form-control right" name="terbayar_detail">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Pelunasan Uang Muka</td>
                              <td>
                                <input type="text" readonly="" class="pelunasan_um form-control right" name="pelunasan_um">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Debet Nota</td>
                              <td>
                                <input type="text" readonly="" class="debet_detail form-control right" name="debet_detail">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Kredit Nota</td>
                              <td>
                                <input type="text" readonly="" class="kredit_detail form-control right" name="kredit_detail">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Sisa Pembayaran</td>
                              <td>
                                <input type="text" readonly="" class="sisa_detail form-control right" name="sisa_detail">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Pelunasan</td>
                              <td>
                                <input type="text" class="pelunasan_detail form-control right" name="pelunasan_detail">
                              </td>
                            </tr>
                            <tr>
                              <td width="120">Sisa Pembayaran Akhir</td>
                              <td>
                                <input type="text" readonly="" class="total_detail form-control right" name="total_detail">
                              </td>
                            </tr>
                          </table>
                          <table class="table">
                            <tr><td align="right"><button class="btn btn-primary update_detail">Update</button></td></tr>
                          </table>
                        </div>
                        <div class="col-sm-12" style="margin-top: 10px;overflow: auto" >
                          <button class="btn pull-right btn-danger reload_form mrgin"><i class="fa fa-reload"> Reload</i></button>
                          <button onclick="printing()" class="btn pull-right btn-warning print_form mrgin"><i class="fa fa-print"> Print</i></button>
                          <button class="btn pull-right btn-primary simpan_form mrgin"><i class="fa fa-save"> Simpan</i></button>
                        <caption><h2>Detail Faktur</h2></caption>
                        <table class="table tabel_faktur table-bordered " >
                          <thead>
                            <tr>
                              <th>Faktur</th>
                              <th>Tanggal</th>
                              <th>Akun</th>
                              <th>Total Faktur</th>
                              <th>Terbayar</th>
                              <th>Pelunasan</th>
                              <th>Sisa Akhir</th>
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



    <div class="modal modal_faktur fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document" style="width: 1000px;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body tabel_modal_faktur">
            <table>
              <thead>
                <tr>
                  <th>No Faktur</th>
                  <th>Tanggal</th>
                  <th>Jatuh Tempo</th>
                  <th>Harga Faktur</th>
                  <th>No Tanda Terima</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
          
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary  append_modal" data-dismiss="modal">Append</button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal modal_jurnal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document" style="width: 1000px;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body tabel_jurnal">
              
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    

<div class="row" style="padding-bottom: 50px;"></div>


<div class="modal modal_bonsem fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document" style="width: 1000px;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">NOTA BONSEM</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body tabel_modal_bonsem">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary  append_modal" data-dismiss="modal">Append</button>
          </div>
        </div>
      </div>
    </div>

@endsection



@section('extra_scripts')
<script type="text/javascript">
  {{-- Note: PENANDA_PATTY UNTUK MENCARI DIV PATTY
             PENANDA_Faktur UNTUK MENCARI DIV FAKTUR
             PENANDA_UM UNTUK MENCARI DIV UANG MUKA 
  --}}
  var valid = [0];
  $('.tanggal').datepicker({
    format:'dd/mm/yyyy'
  });

  $('.periode').daterangepicker({
    format:'dd-mm-yyyy'
  });

  $('.jatuh_tempo').daterangepicker({
    format:'dd-mm-yyyy'
  });
  // GLOBAL VARIABLE
    var seq = 1;
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
    var um_tabel      = $('.um_tabel').DataTable();
    var tabel_faktur  = $('.tabel_faktur').DataTable({
                          columnDefs: [
                            {
                               targets: 3,
                               className: 'right'
                            },
                            {
                               targets: 4,
                               className: 'right'
                            },
                            {
                               targets: 5,
                               className: 'center'
                            },
                            {
                               targets: 6,
                               className: 'center'
                            },
                            {
                               targets: 8,
                               className: 'center'
                            }
                           ]
                        });
    var table_um      = $('.table_um').DataTable();
    $('.nominal_patty').maskMoney({precision:0,thousands:'.',allowZero:true,defaultZero: true});
    $('.pelunasan_detail').maskMoney({precision:0,thousands:'.',allowZero:true,defaultZero: true});
  // 
  $('.jurnal').click(function(){
    $('.modal_jurnal').modal('show');
  })
  function jurnal() {
    var id = '{{ $id }}';
    $.ajax({
        url:baseUrl + '/buktikaskeluar/jurnal',
        type:'get',
        data:{id},
        success:function(data){
           $('.tabel_jurnal').html(data);
        },
        error:function(data){
            // location.reload();
        }
    }); 
  }
  $(document).ready(function(){
    var cabang = $('.cabang').val();
    var id     = '{{$id}}';
    var sup    = '{{$data->bkk_supplier}}';
    var kas    = '{{$data->bkk_akun_kas}}';
    var jenis_bayar = $('.jenis_bayar').val();
    $('.patty_nomor').val(seq);
    $.ajax({
        url:baseUrl + '/buktikaskeluar/akun_kas_dropdown',
        type:'get',
        data:{cabang,kas},
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
        data:{cabang,id},
        success:function(data){
           $('.akun_biaya_td').html(data);
        },
        error:function(data){
            location.reload();
        }
    }); 

    if ($('.jenis_bayar').val() == 8) {
      $('.supplier_patty_tr').prop('hidden',false);
      $('.supplier_faktur_tr').prop('hidden',true);
      $('.patty_cash_div').prop('hidden',false);
      $('.faktur_div').prop('hidden',true);
      $('.uang_muka_div').prop('hidden',true);
      $('.table_bonsem').prop('hidden',true);
    }else if ($('.jenis_bayar').val() == 11){
      $('.supplier_patty_tr').prop('hidden',false);
      $('.supplier_faktur_tr').prop('hidden',true);
      $('.patty_cash_div').prop('hidden',false);
      $('.faktur_div').prop('hidden',true);
      $('.uang_muka_div').prop('hidden',true);
      $('.table_bonsem').prop('hidden',false);
    }else{
      $('.supplier_patty_tr').prop('hidden',true);
      $('.supplier_faktur_tr').prop('hidden',false);
      $('.patty_cash_div').prop('hidden',true);
      $('.faktur_div').prop('hidden',false);
      $('.uang_muka_div').prop('hidden',true);
      $('.table_bonsem').prop('hidden',true);
    }
    
    $.ajax({
        url:baseUrl + '/buktikaskeluar/supplier_dropdown',
        type:'get',
        data:{jenis_bayar,sup},
        success:function(data){
          $('.supplier_faktur ').val('0').trigger('chosen:updated');
          $('.supplier_faktur_td').html(data);
        },
        error:function(data){
          location.reload();
        }
    }); 
    jurnal();
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

    var l = valid.length;
    valid.splice(0,l);
    valid.push(0);
  })

    $('.jenis_bayar').change(function(){

    if ($(this).val() == 8) {
      $('.supplier_patty_tr').prop('hidden',false);
      $('.supplier_faktur_tr').prop('hidden',true);
      $('.patty_cash_div').prop('hidden',false);
      $('.faktur_div').prop('hidden',true);
      $('.uang_muka_div').prop('hidden',true);
    }else {
      $('.supplier_patty_tr').prop('hidden',true);
      $('.supplier_faktur_tr').prop('hidden',false);
      $('.patty_cash_div').prop('hidden',true);
      $('.faktur_div').prop('hidden',false);
      $('.uang_muka_div').prop('hidden',true);
    }
    
    var l = valid.length;
    valid.splice(0,l);
    valid.push(0);
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

  $('.supplier_faktur').change(function(){
    var l = valid.length;
    valid.splice(0,l);
    valid.push(0);
  })

  $('.filter_faktur').change(function(){
    if ($(this).val() == 'faktur') {
      $('.faktur_tr').prop('hidden',false);
      $('.faktur_nomor').prop('readonly',false);
      $('.periode_tr').prop('hidden',true);
      $('.jatuh_tempo_tr').prop('hidden',true);
    }else if ($(this).val() == 'tanggal') {
      $('.faktur_tr').prop('hidden',true);
      $('.faktur_nomor').prop('readonly',true);
      $('.periode_tr').prop('hidden',false);
      $('.jatuh_tempo_tr').prop('hidden',true);
    }else  if ($(this).val() == 'jatuh_tempo') {
      $('.faktur_tr').prop('hidden',true);
      $('.faktur_nomor').prop('readonly',true);
      $('.periode_tr').prop('hidden',true);
      $('.jatuh_tempo_tr').prop('hidden',false);
    }
  })

  // PATTY CASH SCRIPT
  function hitung_pt() {
    var total = 0;
    table_patty.$('.pt_nominal').each(function(){
      var par = $(this).parents('tr');
      var debet = $(par).find('.pt_debet').val();
      if (debet == 'DEBET') {
        total += parseInt($(this).val());
      }else{
        total -= parseInt($(this).val());
      }
    });
    if ($('.jenis_bayar').val() == 11) {
      var sisa = $('.sisa_bonsem_master').val();
      sisa     = sisa.replace(/[^0-9\-]+/g,"");
      console.log(sisa);

      var total_bon = sisa - total;
      if (total_bon < 0) {
        $('.total').val(accounting.formatMoney(total_bon*-1,"", 2, ".",','));
        $('.sisa_bonsem').val(accounting.formatMoney(0,"", 2, ".",','));
      }else{
        $('.sisa_bonsem').val(accounting.formatMoney(total_bon,"", 2, ".",','));
        $('.total').val(accounting.formatMoney(0,"", 2, ".",','));
      }
    }else{
      $('.total').val(accounting.formatMoney(total,"", 2, ".",','));
    }
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
    if ($('.total').val()*1 < 0) {
      return toastr.warning('Total Tidak Boleh Minus');
    }
    var temp = 0;
    table_patty.$('.pt_debet').each(function(){
      temp+=1;
    })
    if (temp == 0) {
      return toastr.warning('Tidak Ada Data Yang Akan Dibiayai');
    }
    swal({
    title: "Apakah anda yakin?",
    text: "Simpan Bukti Kas Keluar!",
    type: "warning",
    showCancelButton: true,
    showLoaderOnConfirm: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Simpan!",
    cancelButtonText: "Batal",
    closeOnConfirm: true
    },function(){

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      $.ajax({
        url:baseUrl + '/buktikaskeluar/update_patty',
        type:'post',
        data:$('.table_header :input').serialize()+'&'+
             $('.table_jurnal :input').serialize()+'&'+
             $('.table_total :input').serialize()+'&'+
             $('.table_bonsem :input').serialize()+'&'+
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
            jurnal();
          });
        },
        error:function(data){
        }
      }); 
    });
  }

  // supplier hutang dagang



  function faktur() {

    var jenis_bayar       = $('.jenis_bayar').val();
    var cabang            = $('.cabang').val();
    var supplier_faktur   = $('.supplier_faktur ').val();
    var filter_faktur     = $('.filter_faktur').val();
    var faktur_nomor      = $('.faktur_nomor').val();
    var periode           = $('.periode').val();
    var nota              = '{{$data->bkk_nota}}';

    if (cabang == '0') {
      toastr.warning('Cabang Harus Dipilih');
      return false;
    }

    if (supplier_faktur == '0') {
      toastr.warning('Supplier Harus Dipilih');
      return false;
    }




    if (filter_faktur == 'faktur') {
      if ($('.faktur_nomor').val() == '') {
        toastr.warning('Nomor Faktur Harus Diisi');
        return false;
      }
      $.ajax({
        url:baseUrl + '/buktikaskeluar/cari_faktur_edit',
        type:'get',
        data:{jenis_bayar,cabang,supplier_faktur,filter_faktur,faktur_nomor,valid,nota},
        dataType:'json',
        success:function(data){
          for (var i = 0; i < data.data.length; i++) {
            var fp_terbayar = parseFloat(data.data[i].fp_netto) - parseFloat(data.data[i].fp_sisapelunasan);

            tabel_faktur.row.add([
              '<a onclick="detail_faktur(this)" class="fp_faktur_text">'+data.data[i].fp_nofaktur+'</a>'+
              '<input type="hidden" value="'+data.data[i].fp_nofaktur+'" class="fp_faktur" name="fp_faktur[]">'+
              '<input type="hidden" value="'+data.data[i].fp_idfaktur+'" class="fp_id fp_'+data.data[i].fp_idfaktur+'">',

              '<p class="fp_tanggal_text">'+data.data[i].fp_tgl+'</p>',

              '<p class="fp_akun_text">'+data.data[i].fp_acchutang+'</p>'+
              '<input type="hidden" class="fp_kredit" name="fp_kredit[]" value="'+data.data[i].fp_creditnota+'">'+
              '<input type="hidden" class="fp_debet" name="fp_debet[]" value="'+data.data[i].fp_debitnota+'">',

              '<p class="fp_total_text">'+accounting.formatMoney(data.data[i].fp_netto,"", 0, ".",',')+'</p>'+
              '<input type="hidden" class="fp_total" name="fp_total[]" value="'+data.data[i].fp_netto+'">',

              '<p class="fp_terbayar_text">'+accounting.formatMoney(fp_terbayar,"", 0, ".",',')+'</p>'+
              '<input type="hidden" class="fp_terbayar" name="fp_terbayar[]" value="'+fp_terbayar+'">',

              '<input readonly value="0" type="text" class="fp_pelunasan right form-control" name="fp_pelunasan[]">',

              '<input readonly  type="text" class="fp_sisa_akhir right form-control" value="'+accounting.formatMoney(data.data[i].fp_sisapelunasan,"", 0, ".",',')+'" name="fp_sisa_akhir[]">',

              '<p class="fp_keterangan_text">'+data.data[i].fp_keterangan+'</p>'+
              '<input type="hidden" class="fp_keterangan" name="fp_keterangan[]" value="'+data.data[i].fp_keterangan+'">',

              '<button onclick="fp_hapus(this)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash " title="Hapus"></i></button>',
            ]).draw();
            valid.push(data.data[i].fp_nofaktur);
          }

          var terbayar = parseFloat(data.data[0].fp_netto) - parseFloat(data.data[0].fp_sisapelunasan) 
                         + parseFloat(data.data[0].fp_debitnota) 
                         - parseFloat(data.data[0].fp_creditnota) 
                         + parseFloat(data.data[0].fp_uangmuka);
          $('.biaya_detail').eq(0).val(accounting.formatMoney(data.data[0].fp_netto,"", 2, ".",','));
          $('.terbayar_detail').eq(0).val(accounting.formatMoney(terbayar,"", 2, ".",','));
          $('.pelunasan_um').eq(0).val(accounting.formatMoney(data.data[0].fp_uangmuka,"", 2, ".",','));
          $('.debet_detail').eq(0).val(accounting.formatMoney(data.data[0].fp_debitnota,"", 2, ".",','));
          $('.kredit_detail').eq(0).val(accounting.formatMoney(data.data[0].fp_creditnota,"", 2, ".",','));
          $('.sisa_detail').eq(0).val(accounting.formatMoney(data.data[0].fp_sisapelunasan,"", 2, ".",','));
          $('.flag_detail').eq(0).val(data.data[0].fp_idfaktur);
          var total = parseFloat(data.data[0].fp_sisapelunasan) - 0; 
          $('.pelunasan_detail').eq(0).val(0);
          $('.total_detail').eq(0).val(accounting.formatMoney(total,"", 2, ".",','));
          var fp_faktur     = data.data[0].fp_nofaktur;

          $.ajax({
            url:baseUrl + '/buktikaskeluar/histori_faktur',
            type:'get',
            data:{fp_faktur,jenis_bayar,nota},
            success:function(data){
              $('#histori_faktur').html(data);
            },
            error:function(data){
            }
          }); 


          $.ajax({
            url:baseUrl + '/buktikaskeluar/debet_faktur',
            type:'get',
            data:{fp_faktur,jenis_bayar,nota},
            success:function(data){
              $('#debet_faktur').html(data);
            },
            error:function(data){
            }
          });

          $.ajax({
            url:baseUrl + '/buktikaskeluar/kredit_faktur',
            type:'get',
            data:{fp_faktur,jenis_bayar},
            success:function(data){
              $('#kredit_faktur').html(data);
            },
            error:function(data){
            }
          });

          $.ajax({
            url:baseUrl + '/buktikaskeluar/um_faktur',
            type:'get',
            data:{fp_faktur,jenis_bayar},
            success:function(data){
              $('#um_faktur').html(data);
            },
            error:function(data){
            }
          });

          toastr.info('Data Berhasil Diinisialisasi');
          $('.faktur_nomor').val('');
        },
        error:function(data){
        }
      }); 
    }else{
      $.ajax({
        url:baseUrl + '/buktikaskeluar/cari_faktur_edit',
        type:'get',
        data:{jenis_bayar,cabang,supplier_faktur,periode,filter_faktur,valid,nota},
        success:function(data){
          $('.tabel_modal_faktur').html(data);
          $('.modal_faktur').modal('show');
        },
        error:function(data){

        }
      }); 
    }
    

  }
  $('.append_modal').click(function(){
    var check_array = [];
    var jenis_bayar = $('.jenis_bayar').val();
    var nota        = '{{$data->bkk_nota}}';
    check.$('.check').each(function(){
      if ($(this).is(':checked') == true) {
        var par    = $(this).parents('tr');
        var faktur = $(par).find('.no_faktur').text();
        check_array.push(faktur);
      }
    })

    $.ajax({
      url:baseUrl + '/buktikaskeluar/append_faktur_edit',
      type:'get',
      data:{check_array,jenis_bayar,nota},
      dataType:'json',
      success:function(data){
        for (var i = 0; i < data.data.length; i++) {
          if (jenis_bayar == '2' || jenis_bayar == '6' || jenis_bayar == '7' || jenis_bayar == '9') {
            var terbayar = parseFloat(data.data[i].fp_sisapelunasan) + parseFloat(data.data[i].fp_debitnota) - parseFloat(data.data[i].fp_creditnota) + parseFloat(data.data[i].fp_uangmuka);


            var fp_terbayar = parseFloat(data.data[i].fp_netto) - parseFloat(terbayar);
            tabel_faktur.row.add([
              '<a onclick="detail_faktur(this)" class="fp_faktur_text">'+data.data[i].fp_nofaktur+'</a>'+
              '<input type="hidden" value="'+data.data[i].fp_nofaktur+'" class="fp_faktur" name="fp_faktur[]">'+
              '<input type="hidden" value="'+data.data[i].fp_idfaktur+'" class="fp_id fp_'+data.data[i].fp_idfaktur+'">',

              '<p class="fp_tanggal_text">'+data.data[i].fp_tgl+'</p>',

              '<p class="fp_akun_text">'+data.data[i].fp_acchutang+'</p>'+
              '<input type="hidden" class="fp_kredit" name="fp_kredit[]" value="'+data.data[i].fp_creditnota+'">'+
              '<input type="hidden" class="fp_debet" name="fp_debet[]" value="'+data.data[i].fp_debitnota+'">',

              '<p class="fp_total_text">'+accounting.formatMoney(data.data[i].fp_netto,"", 0, ".",',')+'</p>'+
              '<input type="hidden" class="fp_total" name="fp_total[]" value="'+data.data[i].fp_netto+'">',

              '<p class="fp_terbayar_text">'+accounting.formatMoney(fp_terbayar,"", 0, ".",',')+'</p>'+
              '<input type="hidden" class="fp_terbayar" name="fp_terbayar[]" value="'+fp_terbayar+'">',

              '<input readonly value="0" type="text" class="fp_pelunasan right form-control" name="fp_pelunasan[]">',

              '<input readonly  type="text" class="fp_sisa_akhir right form-control" value="'+accounting.formatMoney(data.data[i].fp_sisapelunasan,"", 0, ".",',')+'" name="fp_sisa_akhir[]">',

              '<p class="fp_keterangan_text">'+data.data[i].fp_keterangan+'</p>',

              '<button onclick="fp_hapus(this)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash " title="Hapus"></i></button>',
            ]).draw();
            valid.push(data.data[i].fp_nofaktur);
          }else if(jenis_bayar == 3){
            var fp_terbayar = parseFloat(data.data[i].v_hasil) - parseFloat(data.data[i].v_pelunasan);

            tabel_faktur.row.add([
              '<a onclick="detail_faktur(this)" class="fp_faktur_text">'+data.data[i].v_nomorbukti+'</a>'+
              '<input type="hidden" value="'+data.data[i].v_nomorbukti+'" class="fp_faktur" name="fp_faktur[]">'+
              '<input type="hidden" value="'+data.data[i].v_id+'" class="fp_id fp_'+data.data[i].v_id+'">',

              '<p class="fp_tanggal_text">'+data.data[i].v_tgl+'</p>',

              '<p class="fp_akun_text">2101</p>',

              '<p class="fp_total_text">'+accounting.formatMoney(data.data[i].v_hasil,"", 0, ".",',')+'</p>'+
              '<input type="hidden" class="fp_total" name="fp_total[]" value="'+data.data[i].v_hasil+'">',

              '<p class="fp_terbayar_text">'+accounting.formatMoney(fp_terbayar,"", 0, ".",',')+'</p>'+
              '<input type="hidden" class="fp_terbayar" name="fp_terbayar[]" value="'+fp_terbayar+'">',

              '<input readonly value="0" type="text" class="fp_pelunasan form-control" name="fp_pelunasan[]">',

              '<input readonly  type="text" class="fp_sisa_akhir form-control" value="'+accounting.formatMoney(data.data[i].v_pelunasan,"", 0, ".",',')+'" name="fp_sisa_akhir[]">',

              '<p class="fp_keterangan_text">'+data.data[i].v_keterangan+'</p>'+
              '<input type="hidden" class="fp_keterangan" name="fp_keterangan[]" value="'+data.data[i].v_keterangan+'">',

              '<button onclick="fp_hapus(this)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash " title="Hapus"></i></button>',
            ]).draw();
            valid.push(data.data[i].v_nomorbukti);
          }else if(jenis_bayar == 4){
            var fp_terbayar = parseFloat(data.data[i].um_jumlah) - parseFloat(data.data[i].um_sisapelunasan);
            tabel_faktur.row.add([
              '<a onclick="detail_faktur(this)" class="fp_faktur_text">'+data.data[i].um_nomorbukti+'</a>'+
              '<input type="hidden" value="'+data.data[i].um_nomorbukti +'" class="fp_faktur" name="fp_faktur[]">'+
              '<input type="hidden" value="'+data.data[i].um_id+'" class="fp_id fp_'+data.data[i].um_id+'">',

              '<p class="fp_tanggal_text">'+data.data[i].um_tgl+'</p>',

              '<p class="fp_akun_text">2101</p>',

              '<p class="fp_total_text">'+accounting.formatMoney(data.data[i].um_jumlah,"", 0, ".",',')+'</p>'+
              '<input type="hidden" class="fp_total" name="fp_total[]" value="'+data.data[i].um_jumlah+'">',

              '<p class="fp_terbayar_text">'+accounting.formatMoney(fp_terbayar,"", 0, ".",',')+'</p>'+
              '<input type="hidden" class="fp_terbayar" name="fp_terbayar[]" value="'+fp_terbayar+'">',

              '<input readonly value="0" type="text" class="fp_pelunasan form-control" name="fp_pelunasan[]">',

              '<input readonly  type="text" class="fp_sisa_akhir form-control" value="'+accounting.formatMoney(data.data[i].um_sisapelunasan,"", 0, ".",',')+'" name="fp_sisa_akhir[]">',

              '<p class="fp_keterangan_text">'+data.data[i].um_keterangan+'</p>'+
              '<input type="hidden" class="fp_keterangan" name="fp_keterangan[]" value="'+data.data[i].um_keterangan+'">',

              '<button onclick="fp_hapus(this)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash " title="Hapus"></i></button>',
            ]).draw();
            valid.push(data.data[i].um_nomorbukti);
          }else if(jenis_bayar == 11){
            var fp_terbayar = parseFloat(data.data[i].ik_total) - parseFloat(data.data[i].ik_pelunasan);

            tabel_faktur.row.add([
              '<a onclick="detail_faktur(this)" class="fp_faktur_text">'+data.data[i].ik_nota+'</a>'+
              '<input type="hidden" value="'+data.data[i].ik_nota+'" class="fp_faktur" name="fp_faktur[]">'+
              '<input type="hidden" value="'+data.data[i].ik_id+'" class="fp_id fp_'+data.data[i].ik_id+'">',

              '<p class="fp_tanggal_text">'+data.data[i].ik_tanggal+'</p>',

              '<p class="fp_akun_text">2101</p>',

              '<p class="fp_total_text">'+accounting.formatMoney(data.data[i].ik_total,"", 0, ".",',')+'</p>'+
              '<input type="hidden" class="fp_total" name="fp_total[]" value="'+data.data[i].ik_total+'">',

              '<p class="fp_terbayar_text">'+accounting.formatMoney(fp_terbayar,"", 0, ".",',')+'</p>'+
              '<input type="hidden" class="fp_terbayar" name="fp_terbayar[]" value="'+fp_terbayar+'">',

              '<input readonly value="0" type="text" class="fp_pelunasan form-control" name="fp_pelunasan[]">',

              '<input readonly  type="text" class="fp_sisa_akhir form-control" value="'+accounting.formatMoney(data.data[i].ik_pelunasan,"", 0, ".",',')+'" name="fp_sisa_akhir[]">',

              '<p class="fp_keterangan_text">'+data.data[i].ik_keterangan+'</p>'+
              '<input type="hidden" class="fp_keterangan" name="fp_keterangan[]" value="'+data.data[i].ik_keterangan+'">',

              '<button onclick="fp_hapus(this)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash " title="Hapus"></i></button>',
            ]).draw();
            valid.push(data.data[i].ik_nota);
          }
        }

        if (jenis_bayar == '2' || jenis_bayar == '6' || jenis_bayar == '7' || jenis_bayar == '9') {

          var terbayar = parseFloat(data.data[0].fp_netto) - parseFloat(data.data[0].fp_sisapelunasan) + parseFloat(data.data[0].fp_debitnota) - parseFloat(data.data[0].fp_creditnota) + parseFloat(data.data[0].fp_uangmuka);
          $('.biaya_detail').eq(0).val(accounting.formatMoney(data.data[0].fp_netto,"", 2, ".",','));
          $('.terbayar_detail').eq(0).val(accounting.formatMoney(terbayar,"", 2, ".",','));
          $('.pelunasan_um').eq(0).val(accounting.formatMoney(data.data[0].fp_uangmuka,"", 2, ".",','));
          $('.debet_detail').eq(0).val(accounting.formatMoney(data.data[0].fp_debitnota,"", 2, ".",','));
          $('.kredit_detail').eq(0).val(accounting.formatMoney(data.data[0].fp_creditnota,"", 2, ".",','));
          $('.sisa_detail').eq(0).val(accounting.formatMoney(data.data[0].fp_sisapelunasan,"", 2, ".",','));
          $('.flag_detail').eq(0).val(data.data[0].fp_idfaktur);
          var total = parseFloat(data.data[0].fp_sisapelunasan) - 0; 
          $('.pelunasan_detail').eq(0).val(0);
          $('.total_detail').eq(0).val(accounting.formatMoney(total,"", 2, ".",','));
          var fp_faktur     = data.data[0].fp_nofaktur;
        }else if(jenis_bayar == 3){
          var terbayar = parseFloat(data.data[0].v_hasil) - parseFloat(data.data[0].v_pelunasan) 
                       + parseFloat(0) 
                       - parseFloat(0) 
                       + parseFloat(0);

          $('.biaya_detail').eq(0).val(accounting.formatMoney(data.data[0].v_hasil,"", 2, ".",','));
          $('.terbayar_detail').eq(0).val(accounting.formatMoney(terbayar,"", 2, ".",','));
          $('.pelunasan_um').eq(0).val(0);
          $('.debet_detail').eq(0).val(0);
          $('.kredit_detail').eq(0).val(0);
          $('.sisa_detail').eq(0).val(accounting.formatMoney(data.data[0].v_pelunasan,"", 2, ".",','));
          $('.flag_detail').eq(0).val(data.data[0].v_id);
          var total = parseFloat(data.data[0].v_pelunasan) - 0; 
          $('.pelunasan_detail').eq(0).val(0);
          $('.total_detail').eq(0).val(accounting.formatMoney(total,"", 2, ".",','));
          var fp_faktur     = data.data[0].v_nomorbukti;
        }else if(jenis_bayar == 4){
          var terbayar = parseFloat(data.data[0].um_jumlah) - parseFloat(data.data[0].um_sisapelunasan);

          $('.biaya_detail').eq(0).val(accounting.formatMoney(data.data[0].um_jumlah,"", 2, ".",','));
          $('.terbayar_detail').eq(0).val(accounting.formatMoney(terbayar,"", 2, ".",','));
          $('.pelunasan_um').eq(0).val(0);
          $('.debet_detail').eq(0).val(0);
          $('.kredit_detail').eq(0).val(0);
          $('.sisa_detail').eq(0).val(accounting.formatMoney(data.data[0].um_sisapelunasan,"", 2, ".",','));
          $('.flag_detail').eq(0).val(data.data[0].um_id);
          var total = parseFloat(data.data[0].um_sisapelunasan) - 0; 
          $('.pelunasan_detail').eq(0).val(0);
          $('.total_detail').eq(0).val(accounting.formatMoney(total,"", 2, ".",','));
          var fp_faktur     = data.data[0].um_nomorbukti;
        }else if(jenis_bayar == 11){
          var terbayar =parseFloat(data.data[0].ik_total) - parseFloat(data.data[0].ik_pelunasan) 
                       + parseFloat(0) 
                       - parseFloat(0) 
                       + parseFloat(0);

          $('.biaya_detail').eq(0).val(accounting.formatMoney(data.data[0].ik_total,"", 2, ".",','));
          $('.terbayar_detail').eq(0).val(accounting.formatMoney(terbayar,"", 2, ".",','));
          $('.pelunasan_um').eq(0).val(0);
          $('.debet_detail').eq(0).val(0);
          $('.kredit_detail').eq(0).val(0);
          $('.sisa_detail').eq(0).val(accounting.formatMoney(data.data[0].ik_pelunasan,"", 2, ".",','));
          $('.flag_detail').eq(0).val(data.data[0].ik_id);
          var total = parseFloat(data.data[0].ik_pelunasan) - 0; 
          $('.pelunasan_detail').eq(0).val(0);
          $('.total_detail').eq(0).val(accounting.formatMoney(total,"", 2, ".",','));
          var fp_faktur     = data.data[0].ik_nota;
        }

        $.ajax({
          url:baseUrl + '/buktikaskeluar/histori_faktur',
          type:'get',
          data:{fp_faktur,jenis_bayar,nota},
          success:function(data){
            $('#histori_faktur').html(data);
          },
          error:function(data){
          }
        }); 


        $.ajax({
          url:baseUrl + '/buktikaskeluar/debet_faktur',
          type:'get',
          data:{fp_faktur,jenis_bayar},
          success:function(data){
            $('#debet_faktur').html(data);
          },
          error:function(data){
          }
        });

        $.ajax({
          url:baseUrl + '/buktikaskeluar/kredit_faktur',
          type:'get',
          data:{fp_faktur,jenis_bayar},
          success:function(data){
            $('#kredit_faktur').html(data);
          },
          error:function(data){
          }
        });

        $.ajax({
          url:baseUrl + '/buktikaskeluar/um_faktur',
          type:'get',
          data:{fp_faktur,jenis_bayar},
          success:function(data){
            $('#um_faktur').html(data);
          },
          error:function(data){
          }
        });


        toastr.info('Data Berhasil Diinisialisasi');
        $('.jenis_bayar_td').addClass('disabled');
        $('.supplier_faktur_td').addClass('disabled');
      },
      error:function(data){
      }
    }); 
  })

  function detail_faktur(a) {
    var nota            = '{{$data->bkk_nota}}';
    var par           = $(a).parents('tr');
    var fp_faktur     = $(par).find('.fp_faktur').val();
    var fp_id         = $(par).find('.fp_id').val();
    var fp_pelunasan  = $(par).find('.fp_pelunasan').val();
    fp_pelunasan      = fp_pelunasan.replace(/[^0-9\-]+/g,"");
    var jenis_bayar   = $('.jenis_bayar').val();
    $.ajax({
      url:baseUrl + '/buktikaskeluar/histori_faktur',
      type:'get',
      data:{fp_faktur,jenis_bayar,nota},
      success:function(data){
        $('#histori_faktur').html(data);
      },
      error:function(data){
      }
    }); 


    $.ajax({
      url:baseUrl + '/buktikaskeluar/debet_faktur',
      type:'get',
      data:{fp_faktur,jenis_bayar,nota},
      success:function(data){
        $('#debet_faktur').html(data);
      },
      error:function(data){
      }
    });

    $.ajax({
      url:baseUrl + '/buktikaskeluar/kredit_faktur',
      type:'get',
      data:{fp_faktur,jenis_bayar,nota},
      success:function(data){
        $('#kredit_faktur').html(data);
      },
      error:function(data){
      }
    });

    $.ajax({
      url:baseUrl + '/buktikaskeluar/um_faktur',
      type:'get',
      data:{fp_faktur,jenis_bayar,nota},
      success:function(data){
        $('#um_faktur').html(data);
      },
      error:function(data){
      }
    });



    $.ajax({
      url:baseUrl + '/buktikaskeluar/detail_faktur',
      type:'get',
      data:{fp_faktur,jenis_bayar,nota},
      dataType:'json',
      success:function(data){
        if (jenis_bayar == '2' || jenis_bayar == '6' || jenis_bayar == '7' || jenis_bayar == '9') {

          var terbayar =   parseFloat(data.data.fp_netto) 
                         - parseFloat(data.data.fp_sisapelunasan) 
                         + parseFloat(data.data.fp_debitnota) 
                         - parseFloat(data.data.fp_creditnota) 
                         + parseFloat(data.data.fp_uangmuka);
          $('.biaya_detail').eq(0).val(accounting.formatMoney(data.data.fp_netto,"", 2, ".",','));
          $('.terbayar_detail').eq(0).val(accounting.formatMoney(terbayar,"", 2, ".",','));
          $('.pelunasan_um').eq(0).val(accounting.formatMoney(data.data.fp_uangmuka,"", 2, ".",','));
          $('.debet_detail').eq(0).val(accounting.formatMoney(data.data.fp_debitnota,"", 2, ".",','));
          $('.kredit_detail').eq(0).val(accounting.formatMoney(data.data.fp_creditnota,"", 2, ".",','));
          $('.sisa_detail').eq(0).val(accounting.formatMoney(data.data.fp_sisapelunasan,"", 2, ".",','));
          $('.flag_detail').eq(0).val(data.data.fp_idfaktur);
          var total = parseFloat(data.data.fp_sisapelunasan) - parseFloat(fp_pelunasan); 
          $('.pelunasan_detail').eq(0).val(accounting.formatMoney(fp_pelunasan,"", 0, ".",','));
          $('.total_detail').eq(0).val(accounting.formatMoney(total,"", 2, ".",','));
        }else if(jenis_bayar == 3){
          var terbayar = parseFloat(data.data.v_hasil) - parseFloat(data.data.v_pelunasan) 
                       + parseFloat(0) 
                       - parseFloat(0) 
                       + parseFloat(0);

          $('.biaya_detail').eq(0).val(accounting.formatMoney(data.data.v_hasil,"", 2, ".",','));
          $('.terbayar_detail').eq(0).val(accounting.formatMoney(terbayar,"", 2, ".",','));
          $('.pelunasan_um').eq(0).val(0);
          $('.debet_detail').eq(0).val(0);
          $('.kredit_detail').eq(0).val(0);
          $('.sisa_detail').eq(0).val(accounting.formatMoney(data.data.v_pelunasan,"", 2, ".",','));
          $('.flag_detail').eq(0).val(data.data.v_id);
          var total = parseFloat(data.data.v_pelunasan) - parseFloat(fp_pelunasan);
          $('.pelunasan_detail').eq(0).val(accounting.formatMoney(fp_pelunasan,"", 0, ".",','));
          $('.total_detail').eq(0).val(accounting.formatMoney(total,"", 2, ".",','));
        }else if(jenis_bayar == 4){
          var terbayar =  parseFloat(data.data.um_jumlah) -  parseFloat(data.data.um_sisapelunasan);
                       

          $('.biaya_detail').eq(0).val(accounting.formatMoney(data.data.um_jumlah,"", 2, ".",','));
          $('.terbayar_detail').eq(0).val(accounting.formatMoney(terbayar,"", 2, ".",','));
          $('.pelunasan_um').eq(0).val(0);
          $('.debet_detail').eq(0).val(0);
          $('.kredit_detail').eq(0).val(0);
          $('.sisa_detail').eq(0).val(accounting.formatMoney(data.data.um_sisapelunasan,"", 2, ".",','));
          $('.flag_detail').eq(0).val(data.data.um_id);
          var total = parseFloat(data.data.um_sisapelunasan) - parseFloat(fp_pelunasan); 
          $('.pelunasan_detail').eq(0).val(accounting.formatMoney(fp_pelunasan,"", 0, ".",','));
          $('.total_detail').eq(0).val(accounting.formatMoney(total,"", 2, ".",','));
        }else if(jenis_bayar == 11){
          var terbayar =  parseFloat(data.data.ik_total) -  parseFloat(data.data.ik_pelunasan);
          $('.biaya_detail').eq(0).val(accounting.formatMoney(data.data.ik_total,"", 2, ".",','));
          $('.terbayar_detail').eq(0).val(accounting.formatMoney(terbayar,"", 2, ".",','));
          $('.pelunasan_um').eq(0).val(0);
          $('.debet_detail').eq(0).val(0);
          $('.kredit_detail').eq(0).val(0);
          $('.sisa_detail').eq(0).val(accounting.formatMoney(data.data.ik_pelunasan,"", 2, ".",','));
          $('.flag_detail').eq(0).val(data.data.ik_id);
          var total = parseFloat(data.data.ik_pelunasan) - parseFloat(fp_pelunasan); 
          $('.pelunasan_detail').eq(0).val(accounting.formatMoney(fp_pelunasan,"", 0, ".",','));
          $('.total_detail').eq(0).val(accounting.formatMoney(total,"", 2, ".",','));
        }

        toastr.info('Data Berhasil Diinisialisasi');
      },
      error:function(data){
      }
    }); 
  }

  $('.pelunasan_detail').keyup(function(){
    var pelunasan_detail  = $('.pelunasan_detail').val();
    pelunasan_detail      = pelunasan_detail.replace(/[^0-9\-]+/g,"");

    var sisa_detail  = $('.sisa_detail').val();
    sisa_detail      = sisa_detail.replace(/[^0-9\-]+/g,"")/100;
    if (pelunasan_detail > sisa_detail) {
      pelunasan_detail = sisa_detail;
      $('.pelunasan_detail').val(accounting.formatMoney(pelunasan_detail,"", 0, ".",','));
    }

    var total = parseFloat(sisa_detail) - parseFloat(pelunasan_detail);
    $('.total_detail').val(accounting.formatMoney(total,"", 2, ".",','));

  });

  $('.update_detail').click(function(){
    var flag_detail      = $('.flag_detail').val();
    var par              = $('.fp_'+flag_detail).parents('tr');
    var pelunasan_detail = $('.pelunasan_detail').val();
    var total_detail     = $('.total_detail').val();

    $(par).find('.fp_pelunasan').val(pelunasan_detail);
    $(par).find('.fp_sisa_akhir').val(total_detail);
    $('.detail_biaya :input').val('');
    var total_detail = 0;
    $('.fp_pelunasan').each(function(){
      var fp_pelunasan = $(this).val();
      fp_pelunasan     = fp_pelunasan.replace(/[^0-9\-]+/g,"");
      total_detail    += parseFloat(fp_pelunasan);
    })
    $('.total').val(accounting.formatMoney(total_detail,"", 2, ".",','))
  })
  function fp_hapus(a) {
    var par       = $(a).parents('tr');
    var fp_faktur = $(par).find('.fp_faktur').val();
    var index     = valid.indexOf(fp_faktur);
    valid.splice(index,1)
    tabel_faktur.row(par).remove().draw(false);
    var total_detail = 0;
    var temp = 0;
    $('.fp_pelunasan').each(function(){
      var fp_pelunasan = $(this).val();
      fp_pelunasan     = fp_pelunasan.replace(/[^0-9\-]+/g,"");
      total_detail    += parseFloat(fp_pelunasan);
      temp+=1;
    });
    if (temp == 0) {
      $('.jenis_bayar_td').removeClass('disabled');
      $('.supplier_faktur_td').removeClass('disabled');
    }
    $('.total').val(accounting.formatMoney(total_detail,"", 2, ".",','))

    toastr.info('Data Berhasil Dihapus');
  }

  $('.simpan_form').click(function(){
    var temp = 0
    var validator = [];
    $('.fp_faktur').each(function(){
      temp += 1;
    })
    if (temp == 0) {
      toastr.warning('Tidak Ada Yang Akan Disimpan');
      return false;
    }
    $('.fp_pelunasan').each(function(){
      if ($(this).val() == 0) {
        validator.push(0);
      } 
    });
    var index = validator.indexOf(0);
    if (index != -1) {
      toastr.warning('Ada Data Pembayaran Bernilai 0');
      return false;
    }
    swal({
    title: "Apakah anda yakin?",
    text: "Simpan Bukti Kas Keluar!",
    type: "warning",
    showCancelButton: true,
    showLoaderOnConfirm: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Simpan!",
    cancelButtonText: "Batal",
    closeOnConfirm: true
    },function(){

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      $.ajax({
        url:baseUrl + '/buktikaskeluar/update_form',
        type:'post',
        data:$('.table_header :input').serialize()+'&'+
             $('.table_jurnal :input').serialize()+'&'+
             $('.table_total :input').serialize()+'&'+
             tabel_faktur.$('input').serialize(),
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

          jurnal();
        },
        error:function(data){
        }
      }); 
    });
  })

  // voucher / hutang dagang
  function voucher() {
    var jenis_bayar       = $('.jenis_bayar').val();
    var cabang            = $('.cabang').val();
    var supplier_faktur   = $('.supplier_faktur ').val();
    var filter_faktur     = $('.filter_faktur').val();
    var faktur_nomor      = $('.faktur_nomor').val();
    var periode           = $('.periode').val();
    var nota              = '{{$data->bkk_nota}}';

    if (cabang == '0') {
      toastr.warning('Cabang Harus Dipilih');
      return false;
    }

    if (supplier_faktur == '0') {
      toastr.warning('Supplier Harus Dipilih');
      return false;
    }

    if (filter_faktur == 'faktur') {


      if ($('.faktur_nomor').val() == '') {
        toastr.warning('Nomor Faktur Harus Diisi');
        return false;
      }

      $.ajax({
        url:baseUrl + '/buktikaskeluar/cari_faktur_edit',
        type:'get',
        data:{jenis_bayar,cabang,supplier_faktur,filter_faktur,faktur_nomor,valid,nota},
        dataType:'json',
        success:function(data){
          for (var i = 0; i < data.data.length; i++) {
            var fp_terbayar = parseFloat(data.data[i].v_hasil) - parseFloat(data.data[i].v_pelunasan);

            tabel_faktur.row.add([
              '<a onclick="detail_faktur(this)" class="fp_faktur_text">'+data.data[i].v_nomorbukti+'</a>'+
              '<input type="hidden" value="'+data.data[i].v_nomorbukti+'" class="fp_faktur" name="fp_faktur[]">'+
              '<input type="hidden" value="'+data.data[i].v_id+'" class="fp_id fp_'+data.data[i].v_id+'">',

              '<p class="fp_tanggal_text">'+data.data[i].v_tgl+'</p>',

              '<p class="fp_akun_text">2101</p>',

              '<p class="fp_total_text">'+accounting.formatMoney(data.data[i].v_hasil,"", 0, ".",',')+'</p>'+
              '<input type="hidden" class="fp_total" name="fp_total[]" value="'+data.data[i].v_hasil+'">',

              '<p class="fp_terbayar_text">'+accounting.formatMoney(fp_terbayar,"", 0, ".",',')+'</p>'+
              '<input type="hidden" class="fp_terbayar" name="fp_terbayar[]" value="'+fp_terbayar+'">',

              '<input readonly value="0" type="text" class="fp_pelunasan right form-control" name="fp_pelunasan[]">',

              '<input readonly value="'+accounting.formatMoney(data.data[i].v_pelunasan,"", 0, ".",',')+'" type="text" class="fp_sisa_akhir right form-control" name="fp_sisa_akhir[]">',

              '<p class="fp_keterangan_text">'+data.data[i].v_keterangan+'</p>'+
              '<input type="hidden" class="fp_keterangan" name="fp_keterangan[]" value="'+data.data[i].v_keterangan+'">',

              '<button onclick="fp_hapus(this)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash " title="Hapus"></i></button>',
            ]).draw();
            valid.push(data.data[i].v_nomorbukti);
          }

          var terbayar = parseFloat(data.data[0].v_hasil) 
                         - parseFloat(data.data[0].v_pelunasan);

          $('.biaya_detail').eq(0).val(accounting.formatMoney(data.data[0].v_hasil,"", 2, ".",','));
          $('.terbayar_detail').eq(0).val(accounting.formatMoney(terbayar,"", 2, ".",','));
          $('.pelunasan_um').eq(0).val(0);
          $('.debet_detail').eq(0).val(0);
          $('.kredit_detail').eq(0).val(0);
          $('.sisa_detail').eq(0).val(accounting.formatMoney(data.data[0].v_pelunasan,"", 2, ".",','));
          $('.flag_detail').eq(0).val(data.data[0].v_id);
          var total = parseFloat(data.data[0].v_pelunasan) - 0; 
          $('.pelunasan_detail').eq(0).val(0);
          $('.total_detail').eq(0).val(accounting.formatMoney(total,"", 2, ".",','));
          var fp_faktur     = data.data[0].v_nomorbukti;

          $.ajax({
            url:baseUrl + '/buktikaskeluar/histori_faktur',
            type:'get',
            data:{fp_faktur,jenis_bayar,nota},
            success:function(data){
              $('#histori_faktur').html(data);
            },
            error:function(data){
            }
          }); 


          $.ajax({
            url:baseUrl + '/buktikaskeluar/debet_faktur',
            type:'get',
            data:{fp_faktur,jenis_bayar},
            success:function(data){
              $('#debet_faktur').html(data);
            },
            error:function(data){
            }
          });

          $.ajax({
            url:baseUrl + '/buktikaskeluar/kredit_faktur',
            type:'get',
            data:{fp_faktur,jenis_bayar},
            success:function(data){
              $('#kredit_faktur').html(data);
            },
            error:function(data){
            }
          });

          $.ajax({
            url:baseUrl + '/buktikaskeluar/um_faktur',
            type:'get',
            data:{fp_faktur,jenis_bayar},
            success:function(data){
              $('#um_faktur').html(data);
            },
            error:function(data){
            }
          });

          toastr.info('Data Berhasil Diinisialisasi');
          $('.faktur_nomor').val('');
        },
        error:function(data){
        }
      }); 
    }else{
      $.ajax({
        url:baseUrl + '/buktikaskeluar/cari_faktur_edit',
        type:'get',
        data:{jenis_bayar,cabang,supplier_faktur,periode,filter_faktur,valid,nota},
        success:function(data){
          $('.tabel_modal_faktur').html(data);
          $('.modal_faktur').modal('show');
        },
        error:function(data){

        }
      }); 
    }
  }

  function uang_muka() {

    var jenis_bayar       = $('.jenis_bayar').val();
    var cabang            = $('.cabang').val();
    var supplier_faktur   = $('.supplier_faktur ').val();
    var filter_faktur     = $('.filter_faktur').val();
    var faktur_nomor      = $('.faktur_nomor').val();
    var periode           = $('.periode').val();
    var nota              = '{{$data->bkk_nota}}';

    if (cabang == '0') {
      toastr.warning('Cabang Harus Dipilih');
      return false;
    }

    if (supplier_faktur == '0') {
      toastr.warning('Supplier Harus Dipilih');
      return false;
    }

    if (filter_faktur == 'faktur') {


      if ($('.faktur_nomor').val() == '') {
        toastr.warning('Nomor Faktur Harus Diisi');
        return false;
      }

      $.ajax({
        url:baseUrl + '/buktikaskeluar/cari_faktur_edit',
        type:'get',
        data:{jenis_bayar,cabang,supplier_faktur,filter_faktur,faktur_nomor,valid,nota},
        dataType:'json',
        success:function(data){
          for (var i = 0; i < data.data.length; i++) {
            var fp_terbayar = parseFloat(data.data[i].um_jumlah) - parseFloat(data.data[i].um_sisapelunasan);

            tabel_faktur.row.add([
              '<a onclick="detail_faktur(this)" class="fp_faktur_text">'+data.data[i].um_nomorbukti+'</a>'+
              '<input type="hidden" value="'+data.data[i].um_nomorbukti+'" class="fp_faktur" name="fp_faktur[]">'+
              '<input type="hidden" value="'+data.data[i].um_id+'" class="fp_id fp_'+data.data[i].um_id+'">',

              '<p class="fp_tanggal_text">'+data.data[i].um_tgl+'</p>',

              '<p class="fp_akun_text">'+data.data[i].um_tgl+'</p>',

              '<p class="fp_total_text">'+accounting.formatMoney(data.data[i].um_jumlah,"", 0, ".",',')+'</p>'+
              '<input type="hidden" class="fp_total" name="fp_total[]" value="'+data.data[i].um_jumlah+'">',

              '<p class="fp_terbayar_text">'+accounting.formatMoney(fp_terbayar,"", 0, ".",',')+'</p>'+
              '<input type="hidden" class="fp_terbayar" name="fp_terbayar[]" value="'+fp_terbayar+'">',

              '<input readonly value="0" type="text" class="fp_pelunasan right form-control" name="fp_pelunasan[]">',

              '<input readonly value="'+accounting.formatMoney(data.data[i].um_sisapelunasan,"", 0, ".",',')+'" type="text" class="fp_sisa_akhir right form-control" name="fp_sisa_akhir[]">',

              '<p class="fp_keterangan_text">'+data.data[i].um_keterangan+'</p>'+
              '<input type="hidden" class="fp_keterangan" name="fp_keterangan[]" value="'+data.data[i].um_keterangan+'">',

              '<button onclick="fp_hapus(this)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash " title="Hapus"></i></button>',
            ]).draw();
            valid.push(data.data[i].um_nomorbukti);
          }

          var terbayar = parseFloat(data.data[0].um_jumlah) - parseFloat(data.data[0].um_sisapelunasan);

          $('.biaya_detail').eq(0).val(accounting.formatMoney(data.data[0].um_jumlah,"", 2, ".",','));
          $('.terbayar_detail').eq(0).val(accounting.formatMoney(terbayar,"", 2, ".",','));
          $('.pelunasan_um').eq(0).val(0);
          $('.debet_detail').eq(0).val(0);
          $('.kredit_detail').eq(0).val(0);
          $('.sisa_detail').eq(0).val(accounting.formatMoney(data.data[0].um_sisapelunasan,"", 2, ".",','));
          $('.flag_detail').eq(0).val(data.data[0].um_id);
          var total = parseFloat(data.data[0].um_sisapelunasan) - 0; 
          $('.pelunasan_detail').eq(0).val(0);
          $('.total_detail').eq(0).val(accounting.formatMoney(total,"", 2, ".",','));
          var fp_faktur     = data.data[0].um_nomorbukti;

          $.ajax({
            url:baseUrl + '/buktikaskeluar/histori_faktur',
            type:'get',
            data:{fp_faktur,jenis_bayar,nota},
            success:function(data){
              $('#histori_faktur').html(data);
            },
            error:function(data){
            }
          }); 


          $.ajax({
            url:baseUrl + '/buktikaskeluar/debet_faktur',
            type:'get',
            data:{fp_faktur,jenis_bayar},
            success:function(data){
              $('#debet_faktur').html(data);
            },
            error:function(data){
            }
          });

          $.ajax({
            url:baseUrl + '/buktikaskeluar/kredit_faktur',
            type:'get',
            data:{fp_faktur,jenis_bayar},
            success:function(data){
              $('#kredit_faktur').html(data);
            },
            error:function(data){
            }
          });

          $.ajax({
            url:baseUrl + '/buktikaskeluar/um_faktur',
            type:'get',
            data:{fp_faktur,jenis_bayar},
            success:function(data){
              $('#um_faktur').html(data);
            },
            error:function(data){
            }
          });

          toastr.info('Data Berhasil Diinisialisasi');
          $('.faktur_nomor').val('');
        },
        error:function(data){
        }
      }); 
    }else{
      $.ajax({
        url:baseUrl + '/buktikaskeluar/cari_faktur_edit',
        type:'get',
        data:{jenis_bayar,cabang,supplier_faktur,periode,filter_faktur,valid,nota},
        success:function(data){
          $('.tabel_modal_faktur').html(data);
          $('.modal_faktur').modal('show');
        },
        error:function(data){

        }
      }); 
    }
  }
// BON SEMENTARA
  // function bon_sementara() {
  //   var jenis_bayar       = $('.jenis_bayar').val();
  //   var cabang            = $('.cabang').val();
  //   var supplier_faktur   = $('.supplier_faktur ').val();
  //   var filter_faktur     = $('.filter_faktur').val();
  //   var faktur_nomor      = $('.faktur_nomor').val();
  //   var periode           = $('.periode').val();

  //   if (cabang == '0') {
  //     toastr.warning('Cabang Harus Dipilih');
  //     return false;
  //   }

  //   if (supplier_faktur == '0') {
  //     toastr.warning('Supplier Harus Dipilih');
  //     return false;
  //   }

  //   if (filter_faktur == 'faktur') {


  //     if ($('.faktur_nomor').val() == '') {
  //       toastr.warning('Nomor Faktur Harus Diisi');
  //       return false;
  //     }

  //     $.ajax({
  //       url:baseUrl + '/buktikaskeluar/cari_faktur',
  //       type:'get',
  //       data:{jenis_bayar,cabang,supplier_faktur,filter_faktur,faktur_nomor,valid},
  //       dataType:'json',
  //       success:function(data){
  //         for (var i = 0; i < data.data.length; i++) {
  //           var fp_terbayar = parseFloat(data.data[i].ik_total) - parseFloat(data.data[i].ik_pelunasan);

  //           tabel_faktur.row.add([
  //             '<a onclick="detail_faktur(this)" class="fp_faktur_text">'+data.data[i].ik_nota+'</a>'+
  //             '<input type="hidden" value="'+data.data[i].ik_nota+'" class="fp_faktur" name="fp_faktur[]">'+
  //             '<input type="hidden" value="'+data.data[i].ik_id+'" class="fp_id fp_'+data.data[i].ik_id+'">',

  //             '<p class="fp_tanggal_text">'+data.data[i].ik_tanggal+'</p>',

  //             '<p class="fp_akun_text">2101</p>',

  //             '<p class="fp_total_text">'+accounting.formatMoney(data.data[i].ik_total,"", 0, ".",',')+'</p>'+
  //             '<input type="hidden" class="fp_total" name="fp_total[]" value="'+data.data[i].ik_total+'">',

  //             '<p class="fp_terbayar_text">'+accounting.formatMoney(fp_terbayar,"", 0, ".",',')+'</p>'+
  //             '<input type="hidden" class="fp_terbayar" name="fp_terbayar[]" value="'+fp_terbayar+'">',

  //             '<input readonly value="0" type="text" class="fp_pelunasan right form-control" name="fp_pelunasan[]">',

  //             '<input readonly value="'+accounting.formatMoney(data.data[i].ik_pelunasan,"", 0, ".",',')+'" type="text" class="fp_sisa_akhir right form-control" name="fp_sisa_akhir[]">',

  //             '<p class="fp_keterangan_text">'+data.data[i].ik_keterangan+'</p>'+
  //             '<input type="hidden" class="fp_keterangan" name="fp_keterangan[]" value="'+data.data[i].ik_keterangan+'">',

  //             '<button onclick="fp_hapus(this)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash " title="Hapus"></i></button>',
  //           ]).draw();
  //           valid.push(data.data[i].ik_nota);
  //         }

  //         var terbayar = parseFloat(data.data[0].ik_total) 
  //                        - parseFloat(data.data[0].ik_pelunasan);

  //         $('.biaya_detail').eq(0).val(accounting.formatMoney(data.data[0].ik_total,"", 2, ".",','));
  //         $('.terbayar_detail').eq(0).val(accounting.formatMoney(terbayar,"", 2, ".",','));
  //         $('.pelunasan_um').eq(0).val(0);
  //         $('.debet_detail').eq(0).val(0);
  //         $('.kredit_detail').eq(0).val(0);
  //         $('.sisa_detail').eq(0).val(accounting.formatMoney(data.data[0].ik_pelunasan,"", 2, ".",','));
  //         $('.flag_detail').eq(0).val(data.data[0].ik_id);
  //         var total = parseFloat(data.data[0].ik_pelunasan) - 0; 
  //         $('.pelunasan_detail').eq(0).val(0);
  //         $('.total_detail').eq(0).val(accounting.formatMoney(total,"", 2, ".",','));
  //         var fp_faktur     = data.data[0].ik_nota;

  //         $.ajax({
  //           url:baseUrl + '/buktikaskeluar/histori_faktur',
  //           type:'get',
  //           data:{fp_faktur,jenis_bayar},
  //           success:function(data){
  //             $('#histori_faktur').html(data);
  //           },
  //           error:function(data){
  //           }
  //         }); 


  //         $.ajax({
  //           url:baseUrl + '/buktikaskeluar/debet_faktur',
  //           type:'get',
  //           data:{fp_faktur,jenis_bayar},
  //           success:function(data){
  //             $('#debet_faktur').html(data);
  //           },
  //           error:function(data){
  //           }
  //         });

  //         $.ajax({
  //           url:baseUrl + '/buktikaskeluar/kredit_faktur',
  //           type:'get',
  //           data:{fp_faktur,jenis_bayar},
  //           success:function(data){
  //             $('#kredit_faktur').html(data);
  //           },
  //           error:function(data){
  //           }
  //         });

  //         $.ajax({
  //           url:baseUrl + '/buktikaskeluar/um_faktur',
  //           type:'get',
  //           data:{fp_faktur,jenis_bayar},
  //           success:function(data){
  //             $('#um_faktur').html(data);
  //           },
  //           error:function(data){
  //           }
  //         });

  //         toastr.info('Data Berhasil Diinisialisasi');
  //         $('.faktur_nomor').val('');
  //       },
  //       error:function(data){
  //       }
  //     }); 
  //   }else{
  //     $.ajax({
  //       url:baseUrl + '/buktikaskeluar/cari_faktur',
  //       type:'get',
  //       data:{jenis_bayar,cabang,supplier_faktur,periode,filter_faktur,valid},
  //       success:function(data){
  //         $('.tabel_modal_faktur').html(data);
  //         $('.modal_faktur').modal('show');
  //       },
  //       error:function(data){

  //       }
  //     }); 
  //   }
  // }

  $('.nota_bonsem').click(function(){
    var cabang = $('.cabang').val();
    var nota = '{{ $data->bkk_nota }}';
    $.ajax({
        url:'{{ url('buktikaskeluar/table_bonsem') }}',
        type:'get',
        data:{cabang,nota},
        success:function(data){
          $('.tabel_modal_bonsem').html(data);
          $('.modal_bonsem').modal('show');
        },
        error:function(data){
        }
    });
  })

  function pilih_bonsem(par) {
    var bp_nota = $(par).find('.bp_nota').val();
    var bp_sisa = $(par).find('.bp_sisa').val();

    $('.nota_bonsem').val(bp_nota);
    $('.sisa_bonsem').val(accounting.formatMoney(bp_sisa,"", 2, ".",','));
    $('.sisa_bonsem_master').val(bp_sisa);
    hitung_pt();
    $('.modal_bonsem').modal('hide');

  }
  // PILIHAN JENIS BAYAR
  function cari_faktur() {
    var jenis_bayar = $('.jenis_bayar').val();
    if (jenis_bayar == '2' || jenis_bayar == '6' || jenis_bayar == '7' || jenis_bayar == '9') {
      faktur();
    }else if (jenis_bayar == '3') {
      voucher();
    }else if (jenis_bayar == '4') {
      uang_muka();
    }else if (jenis_bayar == '11') {
      bon_sementara();
    }
  }

  @foreach ($data_dt as $i => $val)
    @if ($data->bkk_jenisbayar == 2  or $data->bkk_jenisbayar  == 6 or $data->bkk_jenisbayar  == 7 or $data->bkk_jenisbayar  == 9)

      var terbayar         = '{{$val->fp_sisapelunasan + $val->fp_debitnota - $val->fp_creditnota + $val->fp_uangmuka + $val->bkkd_total}}';
      var fp_terbayar      = parseFloat('{{$val->fp_netto}}') - parseFloat(terbayar);
      var fp_nofaktur      = '{{$val->fp_nofaktur}}';
      var fp_idfaktur      = '{{$val->fp_idfaktur}}';
      var fp_tgl           = '{{$val->fp_tgl}}';
      var fp_acchutang     = '{{$val->fp_acchutang}}';
      var fp_creditnota    = '{{$val->fp_creditnota}}';
      var fp_debitnota     = '{{$val->fp_debitnota}}';
      var fp_netto         = '{{$val->fp_netto}}';
      var fp_sisapelunasan = '{{$val->fp_sisapelunasan}}';
      var fp_keterangan    = '{{$val->fp_keterangan}}';
      var fp_pelunasan     = '{{$val->bkkd_total}}';

      tabel_faktur.row.add([
        '<a onclick="detail_faktur(this)" class="fp_faktur_text">'+fp_nofaktur+'</a>'+
        '<input type="hidden" value="'+fp_nofaktur+'" class="fp_faktur" name="fp_faktur[]">'+
        '<input type="hidden" value="'+fp_idfaktur+'" class="fp_id fp_'+fp_idfaktur+'">',

        '<p class="fp_tanggal_text">'+fp_tgl+'</p>',

        '<p class="fp_akun_text">'+fp_acchutang+'</p>'+
        '<input type="hidden" class="fp_kredit" name="fp_kredit[]" value="'+fp_creditnota+'">'+
        '<input type="hidden" class="fp_debet" name="fp_debet[]" value="'+fp_netto+'">',

        '<p class="fp_total_text">'+accounting.formatMoney(fp_netto,"", 0, ".",',')+'</p>'+
        '<input type="hidden" class="fp_total" name="fp_total[]" value="'+fp_netto+'">',

        '<p class="fp_terbayar_text">'+accounting.formatMoney(fp_terbayar,"", 0, ".",',')+'</p>'+
        '<input type="hidden" class="fp_terbayar" name="fp_terbayar[]" value="'+fp_terbayar+'">',

        '<input readonly value="'+accounting.formatMoney(fp_pelunasan,"", 0, ".",',')+'" type="text" class="fp_pelunasan right form-control" name="fp_pelunasan[]">',

        '<input readonly  type="text" class="fp_sisa_akhir right form-control" value="'+accounting.formatMoney(fp_sisapelunasan,"", 0, ".",',')+'" name="fp_sisa_akhir[]">',

        '<p class="fp_keterangan_text">'+fp_keterangan+'</p>',
        '<input type="hidden" class="fp_keterangan" name="fp_keterangan[]" value="'+fp_keterangan+'">',

        '<button onclick="fp_hapus(this)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash " title="Hapus"></i></button>',
      ]).draw();
      valid.push(fp_nofaktur);
    @elseif($data->bkk_jenisbayar == 3)
      var terbayar         = '{{$val->v_pelunasan + $val->bkkd_total}}';
      var fp_terbayar      = parseFloat('{{$val->v_hasil}}') - parseFloat(terbayar);
      var fp_nofaktur      = '{{$val->v_nomorbukti}}';
      var fp_idfaktur      = '{{$val->v_id}}';
      var fp_tgl           = '{{$val->v_tgl}}';
      var fp_acchutang     = '{{$val->bkkd_akun}}';
      var fp_creditnota    = '0';
      var fp_debitnota     = '0';
      var fp_netto         = '{{$val->v_hasil}}';
      var fp_sisapelunasan = '{{$val->v_pelunasan}}';
      var fp_keterangan    = '{{$val->v_keterangan}}';
      var fp_pelunasan     = '{{$val->bkkd_total}}';

      tabel_faktur.row.add([
        '<a onclick="detail_faktur(this)" class="fp_faktur_text">'+fp_nofaktur+'</a>'+
        '<input type="hidden" value="'+fp_nofaktur+'" class="fp_faktur" name="fp_faktur[]">'+
        '<input type="hidden" value="'+fp_idfaktur+'" class="fp_id fp_'+fp_idfaktur+'">',

        '<p class="fp_tanggal_text">'+fp_tgl+'</p>',

        '<p class="fp_akun_text">'+fp_acchutang+'</p>'+
        '<input type="hidden" class="fp_kredit" name="fp_kredit[]" value="'+fp_creditnota+'">'+
        '<input type="hidden" class="fp_debet" name="fp_debet[]" value="'+fp_netto+'">',

        '<p class="fp_total_text">'+accounting.formatMoney(fp_netto,"", 0, ".",',')+'</p>'+
        '<input type="hidden" class="fp_total" name="fp_total[]" value="'+fp_netto+'">',

        '<p class="fp_terbayar_text">'+accounting.formatMoney(fp_terbayar,"", 0, ".",',')+'</p>'+
        '<input type="hidden" class="fp_terbayar" name="fp_terbayar[]" value="'+fp_terbayar+'">',

        '<input readonly value="'+accounting.formatMoney(fp_pelunasan,"", 0, ".",',')+'" type="text" class="fp_pelunasan right form-control" name="fp_pelunasan[]">',

        '<input readonly  type="text" class="fp_sisa_akhir right form-control" value="'+accounting.formatMoney(fp_sisapelunasan,"", 0, ".",',')+'" name="fp_sisa_akhir[]">',

        '<p class="fp_keterangan_text">'+fp_keterangan+'</p>',

        '<button onclick="fp_hapus(this)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash " title="Hapus"></i></button>',
         ]).draw();
      valid.push(fp_nofaktur);
    @elseif($data->bkk_jenisbayar == 4)
      var terbayar         = '{{$val->um_sisapelunasan + $val->bkkd_total}}';
      var fp_terbayar      = parseFloat('{{$val->um_jumlah}}') - parseFloat(terbayar);
      var fp_nofaktur      = '{{$val->um_nomorbukti}}';
      var fp_idfaktur      = '{{$val->um_id}}';
      var fp_tgl           = '{{$val->um_tgl}}';
      var fp_acchutang     = '{{$val->bkkd_akun}}';
      var fp_creditnota    = '0';
      var fp_debitnota     = '0';
      var fp_netto         = '{{$val->um_jumlah}}';
      var fp_sisapelunasan = '{{$val->um_sisapelunasan}}';
      var fp_keterangan    = '{{$val->um_keterangan}}';
      var fp_pelunasan     = '{{$val->bkkd_total}}';

      tabel_faktur.row.add([
        '<a onclick="detail_faktur(this)" class="fp_faktur_text">'+fp_nofaktur+'</a>'+
        '<input type="hidden" value="'+fp_nofaktur+'" class="fp_faktur" name="fp_faktur[]">'+
        '<input type="hidden" value="'+fp_idfaktur+'" class="fp_id fp_'+fp_idfaktur+'">',

        '<p class="fp_tanggal_text">'+fp_tgl+'</p>',

        '<p class="fp_akun_text">'+fp_acchutang+'</p>'+
        '<input type="hidden" class="fp_kredit" name="fp_kredit[]" value="'+fp_creditnota+'">'+
        '<input type="hidden" class="fp_debet" name="fp_debet[]" value="'+fp_netto+'">',

        '<p class="fp_total_text">'+accounting.formatMoney(fp_netto,"", 0, ".",',')+'</p>'+
        '<input type="hidden" class="fp_total" name="fp_total[]" value="'+fp_netto+'">',

        '<p class="fp_terbayar_text">'+accounting.formatMoney(fp_terbayar,"", 0, ".",',')+'</p>'+
        '<input type="hidden" class="fp_terbayar" name="fp_terbayar[]" value="'+fp_terbayar+'">',

        '<input readonly value="'+accounting.formatMoney(fp_pelunasan,"", 0, ".",',')+'" type="text" class="fp_pelunasan right form-control" name="fp_pelunasan[]">',

        '<input readonly  type="text" class="fp_sisa_akhir right form-control" value="'+accounting.formatMoney(fp_sisapelunasan,"", 0, ".",',')+'" name="fp_sisa_akhir[]">',

        '<p class="fp_keterangan_text">'+fp_keterangan+'</p>',

        '<button onclick="fp_hapus(this)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash " title="Hapus"></i></button>',
         ]).draw();
      valid.push(fp_nofaktur);
    @else
      var akun_biaya       = '{{$val->bkkd_akun}}'
      @for($a = 0 ; $a<count($akun); $a++)
        @if($akun[$a]->id_akun == $val->bkkd_akun)
          var akun_biaya_text  = '{{$akun[$a]->nama_akun}}';
        @endif
      @endfor
      var nominal_patty    = '{{(int)$val->bkkd_total}}';
      var keterangan_patty = '{{$val->bkkd_keterangan}}';
      var fp_acchutang     = '{{$val->bkkd_akun}}';
      var dk_patty         = '{{$val->bkkd_debit}}';

      table_patty.row.add([
        '<p class="pt_seq_text">'+seq+'</p>'+
        '<input type="hidden" name="pt_seq[]" class="pt_seq_'+seq+' pt_seq" value="'+seq+'">',

        '<p class="pt_akun_biaya_text">'+akun_biaya+ ' - ' +akun_biaya_text+'</p>'+
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
      seq += 1;
    @endif
  @endforeach


  function printing() {
    var id = $('.id_header').val();
    $.ajax({
        url:baseUrl + '/buktikaskeluar/print',
        type:'get',
        data:{id},
        success:function(data){
          window.open().document.write(data);
        },
        error:function(data){
        }
    });
  }
</script>
@endsection
