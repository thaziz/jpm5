@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright { text-align: right; }
</style>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 style="margin-left : 5px"> DELIVERY ORDER
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        @if(count($jurnal_dt)!=0)
                            <div class="pull-right"><strong><h5><a onclick="lihatjurnal()">Lihat Jurnal</a></h5></strong></div>
                        @endif
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

                <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <div class="box-body">
                       <!--  <div class="form-group">

                            <div class="form-group">
                            <label for="bulan_id" class="col-sm-1 control-label">Bulan</label>
                            <div class="col-sm-2">
                             <select id="bulan_id" name="bulan_id" class="form-control">
                                                      <option value="">Pilih Bulan</option>

                              </select>
                            </div>
                          </div>
                          </div>
                           <div class="form-group">

                            <div class="form-group">
                            <label for="tahun" class="col-sm-1 control-label">Tahun</label>
                            <div class="col-sm-2">
                             <select id="tahun" name="tahun" class="form-control">
                                                      <option value="">Pilih Tahun</option>

                              </select>
                            </div>
                          </div>
                          </div> -->
                        <div class="x_content">
                            <form id="form_header" class="form-horizontal kirim">                                
                                <div class="row">
                                    <div class="col-md-7">
                                        <table class="table table-striped table-bordered dt-responsive nowrap table-hover">
                                            <tbody>
                                                <tr style="max-height: 15px !important; height: 15px !important; overflow:hidden;">
                                                    <td style="width:110px; padding-top: 0.4cm">Nomor</td>
                                                    <td colspan="5">
                                                        <input type="text" class="form-control" id="ed_nomor" name="ed_nomor" style="text-transform: uppercase" value="{{ $do->nomor or null }}" >
                                                        <input type="hidden" class="form-control" id="ed_nomor_old" name="ed_nomor_old" value="{{ $do->nomor or null }}">
                                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly >
                                                        <input type="hidden" class="form-control" name="crud_h" @if ($do === null) value="N" @else value="E" @endif>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Tanggal</td>
                                                    <td colspan="5">
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tanggal" value="{{ $do->tanggal or  date('Y-m-d') }}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Kota Asal</td>
                                                    <td colspan="5">
                                                        <select class="chosen-select-width"  name="cb_kota_asal" style="width:100%" >
                                                            <option value=""></option>
                                                        @foreach ($kota as $row)
                                                            <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                                        @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Kota Tujuan</td>
                                                    <td colspan="5">
                                                        <select class="chosen-select-width"  name="cb_kota_tujuan" style="width:100%" >
                                                            <option value=""></option>
                                                        @foreach ($kota as $row)
                                                            <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                                        @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <select class="form-control" name="pendapatan" id="pendapatan" class="form-control" style="display:none" >
                                                            <option value="PAKET">PAKET</option>
                                                        </select>
                                                    <td style="width:110px; padding-top: 0.4cm">Type Kiriman</td>
                                                    <td colspan="5">
                                                        <select class="form-control"  name="type_kiriman" id="type_kiriman"  >
                                                            <option value="DOKUMEN">DOKUMEN</option>
                                                            <option value="KILOGRAM">KILOGRAM</option>
                                                            <option value="KOLI">KOLI</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Jenis Kiriman</td>
                                                    <td colspan="5">
                                                        <select class="form-control" name="jenis_kiriman" id="jenis_kiriman" >
                                                            <option value="REGULER">REGULER</option>
                                                            <option value="EXPRESS">EXPRESS</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="jenis_kendaraan">
                                                    <td style="width:120px; padding-top: 0.4cm">Jenis Kendaraan</td>
                                                    <td colspan="5">
                                                        <select class="select2_single form-control"  name="cb_angkutan" id="cb_angkutan" style="width: 100% !important;">
                                                            <option></option>
                                                        @foreach ($angkutan as $row)
                                                            <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                        @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="surat_jalan">
                                                    <td style="padding-top: 0.4cm">No Surat Jalan</td>
                                                    <td colspan="5">
                                                        <input type="text" class="form-control" name="ed_surat_jalan" style="text-transform: uppercase" value="{{ $do->no_surat_jalan or null }}" >
                                                    </td>
                                                </tr>
                                                <tr id="nopol">
                                                    <td style="padding-top: 0.4cm">Nopol</td>
                                                    <td colspan="5">
                                                        <select class="chosen-select-width"  name="cb_nopol" style="width:100%">
                                                            <option></option>
                                                        @foreach ($kendaraan as $row)
                                                            <option value="{{ $row->nopol }}"> {{ $row->nopol }} </option>
                                                        @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="berat">
                                                    <td style="padding-top: 0.4cm">Berat</td>
                                                    <td colspan="5">
                                                        <input type="text" class="form-control" name="ed_berat" style="text-align:right" @if ($do === null) value="0" @else value="{{ number_format($do->berat, 0, ",", ".") }}" @endif>
                                                    </td>
                                                </tr>
                                                <tr id="dimensi">
                                                    <td style="padding-top: 0.4cm">Panjang</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_panjang" style="text-align:right" @if ($do === null) value="0" @else value="{{ number_format($do->panjang, 0, ",", ".") }}" @endif>
                                                    </td>
                                                    <td style="padding-top: 0.4cm">Lebar</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_lebar" style="text-align:right" @if ($do === null) value="0" @else value="{{ number_format($do->lebar, 0, ",", ".") }}" @endif>
                                                    </td>
                                                    <td style="padding-top: 0.4cm">Tinggi</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_tinggi" style="text-align:right" @if ($do === null) value="0" @else value="{{ number_format($do->tinggi, 0, ",", ".") }}" @endif>
                                                    </td>
                                                </tr>
                                                
                                                <tr id="koli">
                                                    <td style="padding-top: 0.4cm">Koli</td>
                                                    <td colspan="5">
                                                        <input type="text" class="form-control" name="ed_koli" style="text-align:right" @if ($do === null) value="0" @else value="{{ number_format($do->koli, 0, ",", ".") }}" @endif>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                                    <td colspan="5">
                                                        <select class="form-control"  name="cb_cabang" style="width:100%" id="cb_cabang">
                                                            <option value=""></option>
                                                        @foreach ($cabang as $row)
                                                            <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                        @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">DO Outlet</td>
                                                    <td colspan="4">
                                                        <select class="chosen-select-width"  name="cb_outlet" style="width:100%" id="cb_outlet">
                                                            <option value="">NON OUTLET</option>
                                                        @foreach ($outlet as $row)
                                                            <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                        @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="width: 80px">
                                                        <span class="input-group-btn"> <button type="button" id="btn_cari_harga" class="btn btn-primary">Search
                                                    </td>
                                                        
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="col-md-5">
                                        <table class="table table-striped table-bordered dt-responsive nowrap table-hover">
                                            <tbody>
                                                <tr style="max-height: 15px !important; height: 15px !important; overflow:hidden;">
                                                    <td style="padding-top: 0.4cm">Tarif Dasar</td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="ed_tarif_dasar" style="text-align:right" readonly="readonly" tabindex="-1" @if ($do === null) value="0" @else value="{{ number_format($do->tarif_dasar, 0, ",", ".") }}" @endif >
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Tarif Penerus</td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="ed_tarif_penerus" style="text-align:right" readonly="readonly" tabindex="-1" @if ($do === null) value="0" @else value="{{ number_format($do->tarif_penerus, 0, ",", ".") }}" @endif>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Biaya Tambahan</td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="ed_biaya_tambahan" style="text-align:right"  @if ($do === null) value="0" @else value="{{ number_format($do->biaya_tambahan, 0, ",", ".") }}" @endif>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm" id="div_kom">Discount</td>
                                                    <td colspan="2" id="div_kom">
                                                        <input type="text" class="form-control" name="ed_diskon_h" id="ed_diskon_h" style="text-align:right" @if ($do === null) value="0" @else value="{{ number_format($do->diskon, 0, ",", ".") }}" @endif>
                                                    </td>
                                                </tr>
                                                <tr id="komisi">
                                                    <td style="padding-top: 0.4cm" id="div_kom">Biaya Komisi</td>
                                                    <td colspan="2" id="div_kom">
                                                        <input type="text" class="form-control" name="ed_biaya_komisi" id="biaya_komisi" style="text-align:right" @if ($do === null) value="0" @else value="{{ number_format($do->biaya_komisi, 0, ",", ".") }}" @endif>
                                                    </td>
                                                </tr>
												<tr>
													<td style="width:110px; padding-top: 0.4cm; ">Jenis PPN</td>
													<td>
														<select class="form-control" name="cb_jenis_ppn" id="cb_jenis_ppn" >
															<option value="3" ppnrte="1" ppntpe="npkp" >INCLUDE 1 %</option>
															<option value="2" ppnrte="1" ppntpe="pkp" >EXCLUDE 1 %</option>
															<option value="4" ppnrte="0" ppntpe="npkp" >NON PPN</option>
															
														</select>
                                                         <input type="hidden" name="acc_penjualan" class="form-control"  value="{{ $do->acc_penjualan or null }}">
													</td>
													<td style="width:35%">
                                                        <input type="text" class="form-control" name="ed_jml_ppn" readonly="readonly" tabindex="-1" style="text-align:right" @if ($do === null) value="0" @else value="{{ number_format($do->biaya_komisi, 0, ",", ".") }}" @endif>
													</td>
												</tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm" id="div_kom">Total</td>
                                                    <td colspan="2" id="div_kom">
                                                        <input type="text" class="form-control" name="ed_total_h" id="ed_total_h" style="text-align:right" readonly="readonly" tabindex="-1"@if ($do === null) value="0" @else value="{{ number_format($do->total, 0, ",", ".") }}" @endif>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-striped table-bordered dt-responsive nowrap table-hover">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" style="text-align:center">
                                                        <h3>DATA PENGIRIM</h3>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Customer</td>
                                                    <td colspan="">
                                                        <select class="chosen-select-width"  name="cb_customer" id="cb_customer" style="width:100%" >
                                                            <option> </option>
                                                        @foreach ($customer as $row)
                                                            <option value="{{ $row->kode }}" data-alamat="{{$row->alamat}}" data-telpon="{{$row->telpon}}"  > {{ $row->nama }} </option>
                                                        @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Marketing</td>
                                                    <td colspan="">
                                                        <select class="chosen-select-width"  name="cb_marketing" style="width:100%">
                                                            <option> </option>
                                                        @foreach ($marketing as $row)
                                                            <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                        @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px;">Company Name</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_company_name_pengirim" style="text-transform: uppercase" value="{{ $do->company_name_pengirim or null }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Nama</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_nama_pengirim" style="text-transform: uppercase" value="{{ $do->nama_pengirim or null }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Alamat</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_alamat_pengirim"  style="text-transform: uppercase" value="{{ $do->alamat_pengirim or null }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Kode Pos</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_kode_pos_pengirim"  style="text-transform: uppercase" value="{{ $do->kode_pos_pengirim or null }}">
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td style="width:110px; padding-top: 0.4cm">Telpon</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_telpon_pengirim"  style="text-transform: uppercase" value="{{ $do->telpon_pengirim or null }}">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <table class="table table-striped table-bordered dt-responsive nowrap table-hover">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" style="text-align:center">
                                                        <h3>DATA PENERIMA</h3>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px;">Company Name</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_company_name_penerima"style="text-transform: uppercase" value="{{ $do->company_name_penerima or null }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Nama</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_nama_penerima" required style="text-transform: uppercase" value="{{ $do->nama_penerima or null }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Alamat</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_alamat_penerima"  style="text-transform: uppercase" value="{{ $do->alamat_penerima or null }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Kab/Kota</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_kota" readonly="readonly" tabindex="-1" required style="text-transform: uppercase">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Kode Pos</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_kode_pos_penerima"  style="text-transform: uppercase" value="{{ $do->kode_pos_penerima or null }}">
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td style="width:110px; padding-top: 0.4cm">Telpon</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_telpon_penerima"  style="text-transform: uppercase" value="{{ $do->telpon_penerima or null }}">
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td style="width:110px; padding-top: 0.4cm">Deskripsi</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_deskripsi"  style="text-transform: uppercase" value="{{ $do->deskripsi or null }}">
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td style="width:110px; padding-top: 0.4cm">Instruksi</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_instruksi"  style="text-transform: uppercase" value="{{ $do->instruksi or null }}">
                                                    </td>
                                                </tr>
                                                <tr style="display:none;">
                                                    <td style="width:110px; ">Jenis Pembayaran</td>
                                                    <td colspan="5">
                                                        <select class="form-control" name="cb_jenis_pembayaran"  >
                                                            <option value="CASH">CASH</option>
                                                            <option value="KREDIT">KREDIT</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-success " id="btnsimpan" name="btnsimpan" ><i class="glyphicon glyphicon-save"></i>Simpan</button>
                                        <button type="button" class="btn btn-success " id="btnsimpan_tambah" name="btnsimpan_tambah" ><i class="glyphicon glyphicon-save"></i>Simpan & Tambah Baru</button>
                                    </div>

                                    
                                </div>
                            </form>
                        </div>
                        <!--TIPE PENDAPATAN PAKET-->
                        <!-- modal dokumen-->
                        <div id="modal_dokumen" class="modal" >
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title">Insert Edit Delivery Order Cabang</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal kirim_detail">
                                        <table id="table_data" class="table table-striped table-bordered table-hover">
                                            <tbody>
                                                <tr>
                                                    <td style="width:120px; padding-top: 0.4cm">No Sales Order</td>
                                                    <td colspan="5">
                                                        <div class="input-group" style="width : 100%">
                                                            <input  type="text" class="form-control" name="ed_so" readonly="readonly" tabindex="-1"> <span class="input-group-btn"> <button type="button" id="btn_pilih_so" class="btn btn-primary">Search
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:120px; padding-top: 0.4cm">Item</td>
                                                    <td colspan="5">
                                                        <div class="input-group" style="width : 100%">
                                                            <input  type="text" class="form-control" name="ed_item" disabled="disabled"> <span class="input-group-btn"> <button type="button" id="btn_pilih_item" class="btn btn-primary">Search
                                                            <input type="hidden" class="form-control" name="ed_kode_item" >
                                                            <input type="hidden" class="form-control" name="ed_id">
                                                            <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly >
                                                            <input type="hidden" class="form-control" name="crud" value="N">
                                                            <input type="hidden" class="form-control" name="ed_nomor_d">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr id="kargo">
                                                    <td style="width:120px; padding-top: 0.4cm">Jenis Kendaraan</td>
                                                    <td>
                                                        <select class="select2_single form-control"  name="cb_angkutan" id="cb_angkutan" style="width: 100% !important;" disabled="disabled">
                                                            <option></option>
                                                        @foreach ($angkutan as $row)
                                                            <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                        @endforeach
                                                        </select>
                                                    </td>

                                                    <td style="padding-top: 0.4cm">No Surat Jalan</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_surat_jalan" style="text-transform: uppercase">
                                                    </td>
                                                    <td style="padding-top: 0.4cm">Nopol</td>
                                                    <td>
                                                        <select class="chosen-select-width"  name="cb_nopol" style="width:100%">
                                                            <option></option>
                                                        @foreach ($kendaraan as $row)
                                                            <option value="{{ $row->nopol }}"> {{ $row->nopol }} </option>
                                                        @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="dimensi">
                                                    <td style="padding-top: 0.4cm">Panjang</td>
                                                    <td><input type="text" class="form-control" name="ed_panjang" style="text-align:right"></td>
                                                    <td style="padding-top: 0.4cm">Lebar</td>
                                                    <td><input type="text" class="form-control" name="ed_lebar" style="text-align:right"></td>
                                                    <td style="padding-top: 0.4cm">Tinggi</td>
                                                    <td><input type="text" class="form-control" name="ed_tinggi" style="text-align:right"></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Jumlah</td>
                                                    <td><input type="text" class="form-control" name="ed_jumlah" id="ed_jumlah" style="text-align:right"></td>
                                                    <td style="padding-top: 0.4cm">Satuan</td>
                                                    <td colspan="3"><input type="text" class="form-control" id="edsatuan" name="ed_satuan" readonly="readonly" tabindex="-1"></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Harga</td>
                                                    <td><input type="text" class="form-control" name="ed_harga" style="text-align:right"></td>
                                                    <td style="padding-top: 0.4cm; width: 105px">Biaya Penerus</td>
                                                    <td colspan="3"><input type="text" class="form-control" name="ed_biaya_penerus" style="text-align:right" ></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Discount</td>
                                                    <td><input type="text" class="form-control" name="ed_diskon" style="text-align:right"></td>
                                                    <td style="padding-top: 0.4cm">Total</td>
                                                    <td colspan="3"><input type="text" class="form-control" name="ed_total_harga" style="text-align:right" readonly="readonly" tabindex="-1" ></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Keterangan</td>
                                                    <td colspan="5"><textarea class="form-control" rows="3" name="ed_keterangan" id="ed_keterangan"  style="text-transform: uppercase"></textarea></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="btnsave">Save changes</button>
                                </div>
                              </div>
                            </div>
                        </div>
                        <!-- end modal dokumen-->



                        <!--- END TIPE PENDAPATAN PAKET-->

                        <!----modal pilih nomor sales order--->

                        <div id="modal_pilih_nomor_so" class="modal" >
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h2>Pilih Nomor SO dari Pelanggan 1</h2>
                              </div>
                              <div class="modal-body">
                                <form class="form-horizontal">
                                    <table id="table_data_so" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nomor SO</th>
                                                <th>Tanggal</th>
                                                <th>Item</th>
                                                <th>Qty</th>
                                                <th>Jml Harga</th>
                                                <th>Pilih</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </form>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!----modal pilih item--->
                        <div id="modal_pilih_item" class="modal" >
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4>Pilih Item</h4>
                              </div>
                              <div class="modal-body">
                                <form class="form-horizontal">
                                    <table id="tableitem" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th> Kode</th>
                                                <th> Nama </th>
                                                <th> Satuan </th>
                                                <th style="width:50px"> Aksi </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- modal -->




                    </div>
                </form>
                <div class="box-body" style="display:none">
                    <table id="table_data_detail" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> No SO</th>
                                <th> Kode Item</th>
                                <th> Nama Item </th>
                                <th> Keterangan </th>
                                <th> Qty </th>
                                <th> Satuan </th>
                                <th> Ttl Harga </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
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



<div class="row" style="padding-bottom: 50px;"></div>




@if(count($jurnal_dt)!=0)
 <div id="jurnal" class="modal" >
                  <div class="modal-dialog">
                    <div class="modal-content no-padding">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title">Laporan Jurnal</h5>
                        <h4 class="modal-title">No DO:  <u>{{ $do->nomor or null }}</u> </h4>
                        
                      </div>
                      <div class="modal-body" style="padding: 15px 20px 15px 20px">                            
                                <table id="table_jurnal" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Akun</th>
                                            <th>Debit</th>
                                            <th>Kredit</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                             $totalDebit=0;
                                             $totalKredit=0;
                                        @endphp
                                        @foreach($jurnal_dt as $data)
                                            <tr>
                                                <td>{{$data->nama_akun}}</td>
                                                <td> @if($data->dk=='D') 
                                                        @php
                                                        $totalDebit+=$data->jrdt_value;
                                                        @endphp
                                                        {{number_format($data->jrdt_value,2,',','.')}} 
                                                    @endif
                                                </td>
                                                <td>@if($data->dk=='K') 
                                                    @php
                                                        $totalKredit+=$data->jrdt_value;
                                                    @endphp
                                                    {{number_format($data->jrdt_value,2,',','.')}}
                                                     @endif
                                                </td>
                                            <tr> 
                                        @endforeach                                           
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                                <th>Total</th>                                                
                                                <th>{{number_format($totalDebit,2,',','.')}}</th>
                                                <th>{{number_format($totalKredit,2,',','.')}}</th>
                                        <tr>
                                    </tfoot>
                                </table>                            
                          </div>                          
                    </div>
                  </div>
                </div>
@endif



@endsection



@section('extra_scripts')
<script type="text/javascript">
    Number.prototype.format = function(n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&.');
    };
    
    $(document).ready( function () {
        $("#surat_jalan").hide();
        $("#dimensi").hide();
        $("#nopol").hide();
        $("#koli").hide();
        $("#berat").hide();
        $("#jenis_kendaraan").hide();
        $("#komisi").hide();
        $("select[name='cb_kota_asal']").val('{{ $do->id_kota_asal or ''  }}').trigger('chosen:updated');
        $("select[name='cb_kota_tujuan']").val('{{ $do->id_kota_tujuan or ''  }}').trigger('chosen:updated');
        $("select[name='pendapatan']").val('{{ $do->pendapatan or 'PAKET'  }}').change();
        $("select[name='type_kiriman']").val('{{ $do->type_kiriman or ''  }}').change();
        $("select[name='jenis_kiriman']").val('{{ $do->jenis_pengiriman or ''  }}');
        $("select[name='cb_jenis_pembayaran']").val('{{ $do->jenis_pembayaran or ''  }}');
        $("select[name='cb_customer']").val('{{ $do->kode_customer or ''  }}').trigger('chosen:updated');
        $("select[name='cb_angkutan']").val('{{ $do->kode_tipe_angkutan or ''  }}').trigger('chosen:updated');
        $("select[name='cb_nopol']").val('{{ $do->nopol or ''  }}').trigger('chosen:updated');
        $("select[name='cb_outlet']").val('{{ $do->kode_outlet or ''  }}').trigger('chosen:updated');
        $("select[name='cb_cabang']").val('{{ $do->kode_cabang or ''  }}').change();
        $("select[name='cb_jenis_ppn']").val('{{ $do->jenis_ppn or '3'  }}').change();
        $("select[name='cb_marketing']").val('{{ $do->kode_marketing or ''  }}').trigger('chosen:updated');
        $("input[name='ck_ppn']").attr('checked', {{ $do->ppn or null}});
        var data = $("select[name='cb_kota_tujuan'] option:selected").text();
        $("input[name='ed_kota']").val(data);
        var jumlah = {{ $jml_detail->jumlah or '0'}};
        if (jumlah == 0 ) {
            $("#ed_nomor").focus();
        }else{
            $("input[name='ed_biaya_tambahan']").focus();
            $("input[name='ed_nomor']").attr('readonly','readonly');
            $("select[name='cb_kota_asal']").attr('disabled','disabled');
            $("select[name='cb_kota_tujuan']").attr('disabled','disabled');
            $("select[name='pendapatan']").attr('disabled','disabled');
            $("select[name='jenis_kiriman']").attr('disabled','disabled');
            $("select[name='type_kiriman']").attr('disabled','disabled');
        }       
        $("#ed_nomor").focus();
        
        var config = {
                '.chosen-select'           : {search_contains:true},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"100%",search_contains:true}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

        //$("input[name='ed_harga'],input[name='ed_jumlah'],input[name='ed_biaya_penerus'],input[name='ed_diskon']").maskMoney({thousands:'.', decimal:',', precision:-1});
        $("input[name='ed_biaya_tambahan'],input[name='ed_biaya_komisi'],input[name='ed_diskon_h'],input[name='ed_berat']").maskMoney({thousands:'.', decimal:',', precision:-1});

    });



    //window.scrollTo(0, 120);
    /*
    function tkir(){
        if (document.getElementById('pendapatan').value != ''){if (document.getElementById('pendapatan').value == "KERTAS"){document.getElementById('type_kiriman').innerHTML = "<option value='KARGO KERTAS'>KARGO KERTAS</option><option value='KERTAS'>KERTAS</option>"}
        } else {document.getElementById('type_kiriman').innerHTML = "<option value=''>-- Pilih Type Kiriman --</option>"}
        if (document.getElementById('pendapatan').value != ''){if (document.getElementById('pendapatan').value == "koran"){document.getElementById('type_kiriman').innerHTML = ""}
        } else {document.getElementById('type_kiriman').innerHTML = "<option value=''>-- Pilih Type Kiriman --</option>"}
        if (document.getElementById('pendapatan').value != ''){if (document.getElementById('pendapatan').value == "PAKET"){document.getElementById('type_kiriman').innerHTML = "<option value='DOKUMEN'>DOKUMEN</option><option value='KARGO PAKET'>KARGO PAKET</option><option value='KILOGRAM'>KILOGRAM</option><option value='KOLI'>KOLI</option>"}
        } else {document.getElementById('type_kiriman').innerHTML = "<option value=''>-- Pilih Type Kiriman --</option>"}
        $('#type_kiriman').change()
    }
    */
    
    function hitung(){
        var tarif_dasar = $("input[name='ed_tarif_dasar']").val();
        var biaya_penerus = $("input[name='ed_tarif_penerus']").val();
        var biaya_tambahan = $("input[name='ed_biaya_tambahan']").val();
        var diskon  = $("input[name='ed_diskon_h']").val();
        var biaya_komisi  = $("input[name='ed_biaya_komisi']").val();
        var tarif_dasar = tarif_dasar.replace(/[A-Za-z$. ,-]/g, "");
        var biaya_penerus = biaya_penerus.replace(/[A-Za-z$. ,-]/g, "");
        var biaya_tambahan = biaya_tambahan.replace(/[A-Za-z$. ,-]/g, "");
        var biaya_komisi = biaya_komisi.replace(/[A-Za-z$. ,-]/g, "");
        var diskon = diskon.replace(/[A-Za-z$. ,-]/g, "");
        var jenis_ppn = $("select[name='cb_jenis_ppn']").val();
        if (diskon > 0 && biaya_tambahan > 0) {
            alert("Diskon dan biaya tambahan di isi salah satu");
            $("input[name='ed_diskon_h']").val('0');
            $("input[name='ed_biaya_tambahan']").val('0');
            diskon = 0;
            biaya_tambahan = 0;
            $("input[name='ed_biaya_tambahan']").focus();
        }
        if ($("select[name='cb_outlet']").val() == '' ) {
            biaya_komisi = 0;
        }
        var total  = parseFloat(tarif_dasar) + parseFloat(biaya_penerus) + parseFloat(biaya_tambahan) - parseFloat(diskon) + parseFloat(biaya_komisi)  ;
        var ppn  = 0;//parseFloat(total)/parseFloat(10)    ;
        if (jenis_ppn == 1) {
            ppn =Math.round(parseFloat(total) * parseFloat(0.1));
			total = total + ppn;
        }else if (jenis_ppn == 2) {
            ppn =Math.round(parseFloat(total) * parseFloat(0.01));
			total = total + ppn;
        }else if (jenis_ppn == 4) {
            ppn =0;
        }else if (jenis_ppn == 3) {
            ppn =Math.round(parseFloat(total) / parseFloat(100.1));
            //total = total - ppn;
        }else if (jenis_ppn == 5) {
            ppn =Math.round(parseFloat(total) / parseFloat(10.1));
            total = total - ppn;
        }
      //  if ($("input[name='ck_ppn']").is(':checked') ) {
      //      total = parseFloat(total) + parseFloat(ppn);
      //  }
		$("input[name='ed_jml_ppn']").val(ppn.format());
        $("input[name='ed_total_h']").val(total.format());
    }

    $('#cb_outlet').change(function(){
        x=$(this).val();
            if(x!=''){
                $('#komisi').show();
            } else {
                $('#komisi').hide();
        }
        hitung();
    });
    
    $('#cb_customer').change(function(){
        var nama = $(this).find(':selected').text();
        var alamat = $(this).find(':selected').data('alamat');
        var telpon = $(this).find(':selected').data('telpon');
        $("input[name='ed_nama_pengirim']").val(nama);
        $("input[name='ed_telpon_pengirim']").val(telpon);
        $("input[name='ed_alamat_pengirim']").val(alamat);
        /*
        var value = {
            kode_customer : $("select[name='cb_customer']").val(),
        };
        $.ajax(
        {
            url : baseUrl + "/sales/deliveryorderform/cari_customer",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='ed_nama_pengirim']").val(data.nama);
                $("input[name='ed_telpon_pengirim']").val(data.telpon);
                $("input[name='ed_alamat_pengirim']").val(data.alamat);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               // swal("Error!", textStatus, "error");
            }
        });
        */
    });

    $("select[name='cb_jenis_ppn']").change(function(){
        hitung();
    });

    $("select[name='cb_kota_tujuan']").change(function(){
        var data = $("select[name='cb_kota_tujuan'] option:selected").text();
        $("input[name='ed_kota']").val(data);
    });
    
    $(document).on("click","#ck_ppn",function(){
        hitung();
    });
    $('#type_kiriman').change(function(){
        type_kiriman=$(this).val();
        if ( type_kiriman =='DOKUMEN') {
            $("#surat_jalan").hide();
            $("#dimensi").hide();
            $("#nopol").hide();
            $("#koli").hide();
            $("#berat").hide();
            $("#jenis_kendaraan").hide();
        }else if ( type_kiriman =='KARGO PAKET') {
            $("#surat_jalan").show();
            $("#dimensi").hide();
            $("#nopol").show();
            $("#koli").hide();
            $("#berat").hide();
            $("#jenis_kendaraan").show();
        }else if ( type_kiriman =='KILOGRAM') {
            $("#surat_jalan").hide();
            $("#dimensi").show();
            $("#nopol").hide();
            $("#koli").show();
            $("#berat").show();
            $("#jenis_kendaraan").hide();
        }else if ( type_kiriman =='KOLI') {
            $("#surat_jalan").hide();
            $("#dimensi").hide();
            $("#nopol").hide();
            $("#koli").show();
            $("#berat").show();
            $("#jenis_kendaraan").hide();
        }else if ( type_kiriman =='KERTAS') {
            $("#surat_jalan").show();
            $("#dimensi").hide();
            $("#nopol").show();
            $("#koli").hide();
            $("#berat").show();
            $("#jenis_kendaraan").hide();
        }else if ( type_kiriman =='KARGO KERTAS') {
            $("#surat_jalan").show();
            $("#dimensi").hide();
            $("#nopol").show();
            $("#koli").hide();
            $("#berat").hide();
            $("#jenis_kendaraan").show();
        }
    });
    
    $(document).on("click","#btn_cari_harga",function(){
        var kota_asal = $("select[name='cb_kota_asal']").val();
        var kota_tujuan = $("select[name='cb_kota_tujuan']").val();
        var pendapatan = $("select[name='pendapatan']").val();
        var type = $("select[name='type_kiriman']").val();
        var jenis = $("select[name='jenis_kiriman']").val();
        var angkutan = $("select[name='cb_angkutan']").val();
        var cabang = $("select[name='cb_cabang']").val();
        var berat = $("input[name='ed_berat']").val();
        $("input[name='ed_harga']").val(0);
        if (kota_asal == '') {
            alert('Kota asal harus di isi');
            $("select[name='cb_kota_asal']").focus();
            return false;
        }else if (kota_tujuan == '') {
            alert('Kota tujuan harus di isi');
            $("select[name='cb_kota_tujuan']").focus();
            return false;
        }else if (pendapatan == '') {
            alert('Pendapatan harus di isi');
            $("select[name='pendapatan']").focus();
            return false;
        }else if (type_kiriman == '') {
            alert('Type kiriman harus di isi');
            $("select[name='type_kiriman']").focus();
            return false;
        }else if (jenis_kiriman == '') {
            alert('Jenis kiriman harus di isi');
            $("select[name='jenis_kiriman']").focus();
            return false;
        }else if (cabang == '') {
            alert('cabang harus di isi');
            $("select[name='cb_cabang']").focus();
            return false;
        }
        
        var value = {
            pendapatan: $("select[name='pendapatan']").val(),
            asal: $("select[name='cb_kota_asal']").val(),
            tujuan: $("select[name='cb_kota_tujuan']").val(),
            tipe: $("select[name='type_kiriman']").val(),
            tujuan: $("select[name='cb_kota_tujuan']").val(),
            jenis: $("select[name='jenis_kiriman']").val(),
            angkutan: $("select[name='cb_angkutan']").val(),
            cabang: $("select[name='cb_cabang']").val(),
            berat : $("input[name='ed_berat']").val(),
        };
        $.ajax(
        {
            url : baseUrl + "/sales/deliveryorderform/cari_harga",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='ed_tarif_dasar']").val(data.harga);
                $("input[name='ed_tarif_penerus']").val(data.biaya_penerus);
                $("input[name='acc_penjualan']").val(data.acc_penjualan);
                if (data.jumlah_data == 0){
                    alert('Harga tidak ditemukan');
                }
                hitung();
                
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               // swal("Error!", textStatus, "error");
            }
        });
    });


    $(document).on("click","#btnadd",function(){
        if ( $("#type_kiriman").val() =='DOKUMEN') {
            $("#dimensi").hide();
            $("#kargo").hide();
            $("#modal_dokumen").modal("show");
            $("#btn_pilih_item").focus();
        }else if ( $("#type_kiriman").val() =='KARGO PAKET' || $("#type_kiriman").val() =='KARGO KERTAS') {
            $("#dimensi").hide();
            $("#kargo").show();
            $('#cb_angkutan').removeAttr('disabled');
            $("#modal_dokumen").modal("show");
            $("#btn_pilih_item").focus();
        }else if ( $("#type_kiriman").val() =='KILOGRAM') {
            $("#dimensi").show();
            $("#kargo").hide();
            $("#modal_dokumen").modal("show");
            $("#btn_pilih_item").focus();
        }else if ( $("#type_kiriman").val() =='KOLI') {
            $("#dimensi").hide();
            $("#kargo").hide();
            $("#modal_dokumen").modal("show");
            $("#btn_pilih_item").focus();
        }else if ( $("#type_kiriman").val() =='KERTAS') {
            $("#dimensi").hide();
            $("#kargo").show();
            $('#cb_angkutan').attr('disabled','disabled');
            $("#modal_dokumen").modal("show");
            $("#btn_pilih_item").focus();
        }
        var kota_asal = $("select[name='cb_kota_asal']").val();
        var kota_tujuan = $("select[name='cb_kota_tujuan']").val();
        var pendapatan = $("select[name='pendapatan']").val();
        var type_kiriman = $("select[name='type_kiriman']").val();
        var jenis_kiriman = $("select[name='jenis_kiriman']").val();
        if (kota_asal == '') {
            alert('Kota asal harus di isi');
            $("select[name='cb_kota_asal']").focus();
            return false;
        }else if (kota_tujuan == '') {
            alert('Kota tujuan harus di isi');
            $("select[name='cb_kota_tujuan']").focus();
            return false;
        }else if (pendapatan == '') {
            alert('Pendapatan harus di isi');
            $("select[name='pendapatan']").focus();
            return false;
        }else if (type_kiriman == '') {
            alert('Type kiriman harus di isi');
            $("select[name='type_kiriman']").focus();
            return false;
        }else if (jenis_kiriman == '') {
            alert('Jenis kiriman harus di isi');
            $("select[name='jenis_kiriman']").focus();
            return false;
        }
        
        $("input[name='crud']").val('N');
        $("input[name='ed_harga']").val(0);
        $("input[name='ed_jumlah']").val(0);
        $("input[name='ed_biaya_penerus']").val(0);
        $("input[name='ed_diskon']").val(0);
        $("input[name='ed_panjang']").val(0);
        $("input[name='ed_lebar']").val(0);
        $("input[name='ed_tinggi']").val(0);
        $("#ed_keterangan").val('');
        $("input[name='ed_so']").val('');
        $("input[name='ed_item']").val('');
        $("input[name='ed_satuan']").val('');
        $("input[name='ed_kode_item']").val('');
        $("select[name='cb_angkutan']").val('').trigger('chosen:updated');
        $("select[name='cb_nopol']").val('').trigger('chosen:updated');
        $.ajax(
        {
            url :  baseUrl + "/sales/deliveryorderform/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {

                if(data.status == 'gagal'){
                    alert(data.info);
                    return false;
                }
				if(data.terpakai == 1){
					alert('Nomor Do sudah terpakai. Data tidak bisa di edit');
					return false;
				}
                if(data.crud == 'N'){
                    if(data.result != 1){
                        alert("Gagal menyimpan data!");
                    }else{
                        var nomor = $("input[name='ed_nomor']").val();
                        $("input[name='ed_nomor_old']").val(nomor);
                    }
                }else if(data.crud == 'E'){
					if(data.terpakai == 1){
						alert('Nomor Do sudah terpakai. Data tidak bisa di edit');
						return false;
					}else if(data.result != '1'){
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }else{
                        var nomor = $("input[name='ed_nomor']").val();
                        $("input[name='ed_nomor_old']").val(nomor);
                    }
                }else{
                    swal("Error","invalid order","error");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Error!", textStatus, "error");
            }
        });
    });
    
    $(document).on("click","#btnsimpan",function(){
        var kota_asal = $("select[name='cb_kota_asal']").val();
        var kota_tujuan = $("select[name='cb_kota_tujuan']").val();
        var pendapatan = $("select[name='pendapatan']").val();
        var type_kiriman = $("select[name='type_kiriman']").val();
        var jenis_kiriman = $("select[name='jenis_kiriman']").val();
        if (kota_asal == '') {
            alert('Kota asal harus di isi');
            $("select[name='cb_kota_asal']").focus();
            return false;
        }else if (kota_tujuan == '') {
            alert('Kota tujuan harus di isi');
            $("select[name='cb_kota_tujuan']").focus();
            return false;
        }else if (pendapatan == '') {
            alert('Pendapatan harus di isi');
            $("select[name='pendapatan']").focus();
            return false;
        }else if (type_kiriman == '') {
            alert('Type kiriman harus di isi');
            $("select[name='type_kiriman']").focus();
            return false;
        }else if (jenis_kiriman == '') {
            alert('Jenis kiriman harus di isi');
            $("select[name='jenis_kiriman']").focus();
            return false;
        }
        
        $.ajax(
        {
            url :  baseUrl + "/sales/deliveryorderform/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                 if(data.status == 'gagal'){
                    alert(data.info);
                    return false;
                }
				if(data.terpakai == 1){
					alert('Nomor Do sudah terpakai. Data tidak bisa di edit');
					return false;
				}
                if(data.crud == 'N'){
                    if(data.result != 1){
                        alert("Gagal menyimpan data!");
                    }else{
                        window.location.href = baseUrl + '/sales/deliveryorder'
                    }
                }else if(data.crud == 'E'){
                    if(data.result != 1){
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }else{
                        window.location.href = baseUrl + '/sales/deliveryorder';
                    }
                }else{
                    swal("Error","invalid order","error");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Error!", textStatus, "error");
            }
        });
    });
    
    $(document).on("click","#btnsimpan_tambah",function(){
        var kota_asal = $("select[name='cb_kota_asal']").val();
        var kota_tujuan = $("select[name='cb_kota_tujuan']").val();
        var pendapatan = $("select[name='pendapatan']").val();
        var type_kiriman = $("select[name='type_kiriman']").val();
        var jenis_kiriman = $("select[name='jenis_kiriman']").val();
        if (kota_asal == '') {
            alert('Kota asal harus di isi');
            $("select[name='cb_kota_asal']").focus();
            return false;
        }else if (kota_tujuan == '') {
            alert('Kota tujuan harus di isi');
            $("select[name='cb_kota_tujuan']").focus();
            return false;
        }else if (pendapatan == '') {
            alert('Pendapatan harus di isi');
            $("select[name='pendapatan']").focus();
            return false;
        }else if (type_kiriman == '') {
            alert('Type kiriman harus di isi');
            $("select[name='type_kiriman']").focus();
            return false;
        }else if (jenis_kiriman == '') {
            alert('Jenis kiriman harus di isi');
            $("select[name='jenis_kiriman']").focus();
            return false;
        }
        
        $.ajax(
        {
            url :  baseUrl + "/sales/deliveryorderform/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {   
                if(data.status == 'gagal'){
                    alert(data.info);
                    return false;
                }
				if(data.terpakai == 1){
					alert('Nomor Do sudah terpakai. Data tidak bisa di edit');
					return false;
				}
                if(data.crud == 'N'){
                    if(data.result != 1){
                        alert("Gagal menyimpan data!");
                    }else{
                        window.location.href = baseUrl + '/sales/deliveryorderform'
                    }
                }else if(data.crud == 'E'){
                    if(data.result != 1){
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }else{
                        window.location.href = baseUrl + '/sales/deliveryorderform';
                    }
                }else{
                    swal("Error","invalid order","error");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Error!", textStatus, "error");
            }
        });
    });
    
    $(document).on("click","#btn_pilih_so",function(){
        $("#modal_pilih_nomor_so").modal("show");
    });

    $(document).on("click","#btn_pilih_item",function(){
        $("#modal_pilih_item").modal("show");
        $('#tableitem_filter input').focus();
    });

    $(document).on( "click",".btnpilih", function() {
        var id=$(this).attr("id");
        var value = {
            id: id
        };
        $.ajax(
        {
            url : baseUrl + "/sales/deliveryorderform/get_item",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='ed_satuan']").val(data[0].kode_satuan);
                //$("input[name='ed_harga']").val(data[0].harga);
                $("input[name='ed_item']").val(data[0].nama);
                $("input[name='ed_kode_item']").val(data[0].kode);
                $("#modal_pilih_item").modal("hide");
                if ($("select[name='type_kiriman']").val()== 'KARGO PAKET' || $("select[name='type_kiriman']").val()== 'KARGO KERTAS') {
                    $("#cb_angkutan").focus();
                }else if ($("select[name='type_kiriman']").val()== 'KERTAS'){
                    $("input[name='ed_surat_jalan']").focus();
                }else{
                    $("#ed_jumlah").focus();
                }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    });

    
    $("input[name='ed_biaya_tambahan'],input[name='ed_diskon_h'],input[name='ed_biaya_komisi']").keyup(function(){
        hitung();
    });
    
    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    function lihatjurnal(){
        $('#jurnal').modal('show');
    }

    

</script>
@endsection
