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
                        <input type="text" class="pull-right" style="border: none; text-align: right;" readonly="" name="crud_atas" id="crud_atas" @if ($do === null) value="N" @else value="E" @endif>
                        @if(count($jurnal_dt)!=0)
                            <div class="pull-right"><strong><h5><a onclick="lihatjurnal()">Lihat Jurnal</a></h5></strong></div>
                        @endif
                    </div>
                </div>
                <div class="ibox-content" >
                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Petunjuk Input
                    </button>
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" style="width: 800px;" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Point-Point Yang Harus Diperhatikan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <span><b style="color: red">1 .*Data Customer Berwarna <g style="color: green">Hijau</g> Menandakan Bahwa Customer Tersebut Memiliki Kontrak</b></span><br>
                            <span><b style="color: red">2 .*Pencarian Tarif Penerus Pada Customer Yang Memiliki  <g style="color: green">Kontrak</g> ,Cari Dengan tombol </b> <span class="input-group-btn"> <button type="button"  class="btn btn-warning"> <i class="fa fa-search"></i> Tipe </span>
                          </div>
                          <div class="modal-footer">                            
                          </div>
                        </div>
                      </div>
                    </div>
                                
                    
                </div>
                <br>
                        <div class="row">
            <div class="col-xs-12">

                <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <div class="box-body">
                        <div class="x_content">
                            <form id="form_header" class="form-horizontal kirim">                                
                                <div class="row">
                                    <div class="col-md-7">
                                        <table class="table table-striped table-bordered dt-responsive nowrap table-hover">
                                            <tbody>
                                                <tr style="max-height: 15px !important; height: 15px !important; overflow:hidden;">
                                                    <td style="width:110px; padding-top: 0.4cm">Nomor</td>
                                                    <td colspan="5">
                                                        <input type="text" class="form-control" id="ed_nomor" name="ed_nomor" style="text-transform: uppercase"  value="{{ $do->nomor or null }}" >
                                                        <input type="hidden" class="form-control" id="ed_nomor_old" name="ed_nomor_old" value="{{ $do->nomor or null }}">
                                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly >
                                                        <input type="hidden" class="form-control" name="crud_h" @if ($do === null) value="N" @else value="E" @endif>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Tanggal</td>
                                                    <td colspan="5">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control date-do" name="ed_tanggal" value="{{ $do->tanggal or  date('Y-m-d') }}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                                    <td colspan="5">
                                                        <select class="form-control"  name="cb_cabang" onclick="setMaxDisc()" style="width:100%" id="cb_cabang">
                                                            <option selected="true" value="" ></option>
                                                        @foreach ($cabang as $row)
                                                            @if($row->diskon != null)
                                                            <option value="{{ $row->kode }}" data-diskon="{{ $row->diskon }}">{{ $row->kode }} - {{ $row->nama }} -- (Diskon {{ $row->diskon }}%)</option>
                                                            @else
                                                            <option value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }}</option>
                                                            @endif
                                                        @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Customer</td>
                                                    <td colspan="5">
                                                        <select class="chosen-select-width customerpengirim"  name="cb_customer" onchange="" id="cb_customer" style="width:100%" >
                                                            <option> </option>
                                                        @foreach ($customer as $row)
                                                            @if ( $row->kc_aktif  == 'AKTIF' && $row->kcd_jenis)
                                                                <option style="background-color: #79fea5;" value="{{ $row->kode }}" data-alamat="{{$row->alamat}}" data-telpon="{{$row->telpon}}"  data-status="{{ $row->kc_aktif }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                                            @endif
                                                        @endforeach
                                                        @foreach ($cus as $row1)
                                                                <option value="{{ $row1->kode }}" data-alamat="{{$row1->alamat}}" data-telpon="{{$row1->telpon}}"  >{{ $row1->kode }} - {{ $row1->nama }} </option>
                                                        @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Kota Asal</td>
                                                    <td colspan="5">
                                                        <select class="chosen-select-width replace_deskripsi"  name="cb_kota_asal" style="width:100%" >
                                                            <option value=""></option>
                                                        @foreach ($kota as $row)
                                                            <option value="{{ $row->id }}" data-nama="{{ $row->nama }}">{{ $row->id }} - {{ $row->nama }} </option>
                                                        @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Kota Tujuan</td>
                                                    <td colspan="5">
                                                        <select class="chosen-select-width replace_deskripsi" id="kota" onchange="getKecamatan()" name="cb_kota_tujuan" style="width:100%" >
                                                            <option value=""></option>
                                                        @foreach ($kota as $row)
                                                            <option value="{{ $row->id }}" data-nama="{{ $row->nama }}">{{ $row->id }} - {{ $row->nama }} </option>
                                                        @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm" class="kecamatantujuanlabel">Kecamatan Tujuan</td>
                                                    <td colspan="5">
                                                        <select class="form-control replace_deskripsi" id="kecamatan" name="cb_kecamatan_tujuan" style="width:100%" >
                                                        @if($kec != null)
                                                            <option value=""></option>
                                                            @foreach ($kec as $row)
                                                                @if($do->id_kecamatan_tujuan == $row->id)
                                                                    <option value="{{ $row->id }}" selected data-nama="{{ $row->nama }}"> {{ $row->nama }} </option>
                                                                @else
                                                                    <option value="{{ $row->id }}" data-nama="{{ $row->nama }}"> {{ $row->nama }} </option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <option value=""></option>
                                                            @foreach ($kecamatan as $row)
                                                                <option value="{{ $row->id }}" data-nama="{{ $row->nama }}"> {{ $row->nama }} </option>
                                                            @endforeach
                                                        @endif
                                                        </select>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <select class="form-control" name="pendapatan" id="pendapatan" class="form-control" style="display:none" >
                                                            <option value="PAKET">PAKET</option>
                                                        </select>
                                                    <td style="width:110px; padding-top: 0.4cm">Type Kiriman</td>
                                                    <td colspan="5">
                                                        <select class="form-control"  name="type_kiriman" id="type_kiriman">
                                                        @if($do !== null)
                                                            @if($do->type_kiriman == "DOKUMEN")
                                                                <option value="DOKUMEN" selected>DOKUMEN</option>
                                                                <option value="KILOGRAM">KILOGRAM</option>
                                                                <option value="KOLI">KOLI</option>
                                                                <option value="SEPEDA">SEPEDA</option>
                                                            @elseif($do->type_kiriman == "KILOGRAM")
                                                                <option value="DOKUMEN">DOKUMEN</option>
                                                                <option value="KILOGRAM" selected>KILOGRAM</option>
                                                                <option value="KOLI">KOLI</option>
                                                                <option value="SEPEDA">SEPEDA</option>
                                                            @elseif($do->type_kiriman == "KOLI")
                                                                <option value="DOKUMEN">DOKUMEN</option>
                                                                <option value="KILOGRAM">KILOGRAM</option>
                                                                <option value="KOLI" selected>KOLI</option>
                                                                <option value="SEPEDA">SEPEDA</option>
                                                            @elseif($do->type_kiriman == "SEPEDA")
                                                                <option value="DOKUMEN">DOKUMEN</option>
                                                                <option value="KILOGRAM">KILOGRAM</option>
                                                                <option value="KOLI">KOLI</option>
                                                                <option value="SEPEDA" selected>SEPEDA</option>
                                                            @endif
                                                        @else
                                                            <option value="DOKUMEN">DOKUMEN</option>
                                                            <option value="KILOGRAM">KILOGRAM</option>
                                                            <option value="KOLI">KOLI</option>
                                                            <option value="SEPEDA">SEPEDA</option>
                                                        @endif
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="tr_jenis_kiriman">
                                                    <td style="width:110px; padding-top: 0.4cm">Jenis Kiriman</td>
                                                    <td colspan="5">
                                                        <select class="form-control" name="jenis_kiriman" id="jenis_kiriman" >
                                                        @if($do !== null)
                                                            @if($do->jenis_pengiriman == "REGULER")
                                                                <option value="REGULER" selected>REGULER</option>
                                                                <option value="EXPRESS">EXPRESS</option>
                                                            @elseif($do->jenis_pengiriman == "EXPRESS")
                                                                <option value="REGULER">REGULER</option>
                                                                <option value="EXPRESS" selected>EXPRESS</option>
                                                            @endif
                                                        @else
                                                            <option value="REGULER">REGULER</option>
                                                            <option value="EXPRESS">EXPRESS</option>
                                                        @endif
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
                                                        <input onkeyup="BeratDefault()" type="text" class="form-control" name="ed_berat" style="text-align:right" @if ($do === null) value="0" @else value="{{ number_format($do->berat, 0, ",", ".") }}" @endif>
                                                    </td>
                                                </tr>
                                                <tr id="jml_unit">
                                                    <td style="padding-top: 0.4cm">Jumlah Unit</td>
                                                    <td colspan="5">
                                                        <input type="text" class="form-control jmlunit" onkeyup="setJml()" name="cb_jml_unit" style="text-align:right" @if ($do === null) value="1" @elseif($do !== null && isset($do_dt)) value="{{ count($do_dt) }}" @endif>
                                                    </td>
                                                </tr>
                                                @if(isset($do_dt))
                                                @foreach($do_dt as $row)
                                                <tr id="jenis_unit" class="jenis_unit">
                                                    <td style="padding-top: 0.4cm">Jenis Unit</td>
                                                    <td colspan="2" class="jenisunit">
                                                        <select class="form-control jns_unit" name="cb_jenis_unit[]" >
                                                            @if($row->jenis == "SEPEDA")
                                                            <option value="SEPEDA" selected>SEPEDA</option>
                                                            <option value="SPORT">MOTOR SPORT</option>
                                                            <option value="BETIC">MOTOR BEBEK/MATIC</option>
                                                            <option value="MOGE">MOGE</option>
                                                            @elseif($row->jenis == "SPORT")
                                                            <option value="SEPEDA">SEPEDA</option>
                                                            <option value="SPORT" selected>MOTOR SPORT</option>
                                                            <option value="BETIC">MOTOR BEBEK/MATIC</option>
                                                            <option value="MOGE">MOGE</option>
                                                            @elseif($row->jenis == "BETIC")
                                                            <option value="SEPEDA">SEPEDA</option>
                                                            <option value="SPORT">MOTOR SPORT</option>
                                                            <option value="BETIC" selected>MOTOR BEBEK/MATIC</option>
                                                            <option value="MOGE">MOGE</option>
                                                            @elseif($row->jenis == "MOGE")
                                                            <option value="SEPEDA">SEPEDA</option>
                                                            <option value="SPORT">MOTOR SPORT</option>
                                                            <option value="BETIC">MOTOR BEBEK/MATIC</option>
                                                            <option value="MOGE" selected>MOGE</option>
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td style="padding-top: 0.4cm">Berat Unit</td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control beratunit" name="cb_berat_unit[]" style="text-align:right" value="{{ $row->berat }}">
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr id="jenis_unit" class="jenis_unit">
                                                    <td style="padding-top: 0.4cm">Jenis Unit</td>
                                                    <td colspan="2" class="jenisunit">
                                                        <select class="form-control jns_unit" name="cb_jenis_unit[]" >
                                                            <option value="SEPEDA">SEPEDA</option>
                                                            <option value="SPORT">MOTOR SPORT</option>
                                                            <option value="BETIC">MOTOR BEBEK/MATIC</option>
                                                            <option value="MOGE">MOGE</option>
                                                        </select>
                                                    </td>
                                                    <td style="padding-top: 0.4cm">Berat Unit</td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control beratunit" name="cb_berat_unit[]" style="text-align:right" >
                                                    </td>
                                                </tr>
                                                @endif
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
                                                    <td style="width:110px; padding-top: 0.4cm">DO Outlet</td>
                                                    <td colspan="2">
                                                        <select class="chosen-select-width"  name="cb_outlet" style="width:100%" id="cb_outlet">
                                                            <option value="">NON OUTLET</option>
                                                        @foreach ($outlet as $row)
                                                            <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                        @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="width: 80px" class="disabled" >
                                                       <div class="checkbox checkbox-info checkbox-circle">
                                                            <input onchange="centang()" class="kontrak_tarif" type="checkbox" name="kontrak_tarif">
                                                            <label>
                                                                Kontrak
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 80px">
                                                        <span class="input-group-btn"> <button type="button" id="btn_cari_harga" class="btn btn-primary"> <i class="fa fa-search"></i> Search
                                                    </td>
                                                    <td style="width: 80px" id="hidden_button" hidden="">
                                                        <span class="input-group-btn"> <button type="button" id="btn_cari_tipe" class="btn btn-warning"> <i class="fa fa-search"></i> Tipe
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
                                                        <input type="text" class="form-control" name="ed_tarif_dasar" id="ed_tarif_dasar" style="text-align:right" readonly="readonly" tabindex="-1" @if ($do === null) value="0" @else value="{{ number_format($do->tarif_dasar, 0, ",", ".") }}" @endif >
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Tarif Penerus</td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="ed_tarif_penerus" id="ed_tarif_penerus" style="text-align:right" readonly="readonly" tabindex="-1" @if ($do === null) value="0" @else value="{{ number_format($do->tarif_penerus, 0, ",", ".") }}" @endif>
                                                        <div id="button_a" hidden=""></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Biaya Tambahan</td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="ed_biaya_tambahan" id="ed_biaya_tambahan" style="text-align:right"  @if ($do === null) value="0" @else value="{{ number_format($do->biaya_tambahan, 0, ",", ".") }}" @endif>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm" id="div_kom">Discount</td>
                                                    <td  id="div_kom">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control hanyaangkadiskon" name="ed_diskon_h" id="ed_diskon_h" style="text-align:right" 
                                                            @if ($do === null) value="0" 
                                                            @else value="{{ number_format($do->diskon, 0, "", "") }}" 
                                                            @endif>
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </td>
                                                    <td  id="div_kom">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">Rp</span>
                                                            <input type="text" class="form-control" name="ed_diskon_v" id="ed_diskon_v" onkeyup="dikonval()" style="text-align:right" @if ($do === null) value="0" @else value="{{ number_format($do->diskon, 0, ",", ".") }}" @endif>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr id="komisi">
                                                    <td style="padding-top: 0.4cm" id="div_kom">Biaya Komisi</td>
                                                    <td colspan="2" id="div_kom">
                                                        <input type="text" class="form-control" name="ed_biaya_komisi" id="biaya_komisi" style="text-align:right" @if ($do === null) value="0" @else value="{{ number_format($do->biaya_komisi, 0, ",", ".") }}" @endif>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm" id="div_kom">Dpp</td>
                                                    <td colspan="2" id="div_kom">
                                                        <input type="text" class="form-control dv" name="ed_dpp" id="ed_dpp" style="text-align:right" tabindex="-1"
                                                        @if ($do === null) value="0" 
                                                        @else value="{{ number_format($do->total_dpp, 0, ",", ".") }}" 
                                                        @endif
                                                    >
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="padding-top: 0.4cm" id="div_kom">Vendor</td>
                                                    <td style="width: 80px">
                                                       <div class="checkbox checkbox-info checkbox-circle">
                                                                <input class="vendor_tarif" type="checkbox"  name="vendor_tarif">
                                                                <label>
                                                                    Vendor
                                                                </label>
                                                        </div>
                                                    </td>
                                                    <td colspan="2" id="div_kom">
                                                        <input type="text" class="form-control dv" name="ed_vendor" id="ed_vendor" style="text-align:right" tabindex="-1"
                                                        @if ($do === null) value="0" 
                                                        @else value="{{ number_format($do->total_vendo, 0, ",", ".") }}" 
                                                        @endif
                                                    >
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm; ">Jenis PPN</td>
                                                    <td>
                                                        <select class="form-control" name="cb_jenis_ppn" id="cb_jenis_ppn" onchange="setJmlPPN()">
                                                            <option value="3" ppnrte="1" ppntpe="npkp" >INCLUDE 1 %</option>
                                                            <option value="2" ppnrte="1" ppntpe="pkp" >EXCLUDE 1 %</option>
                                                            <option value="4" ppnrte="0" ppntpe="npkp" >NON PPN</option>
                                                        </select>
                                                         <input type="hidden" name="acc_penjualan" class="form-control"  value="{{ $do->acc_penjualan or null }}">
                                                    </td>
                                                    <td style="width:35%">
                                                        <input type="text" class="form-control jml_ppn" name="ed_jml_ppn" readonly="readonly" tabindex="-1" style="text-align:right" @if ($do === null) value="0" @else value="{{ number_format($do->biaya_komisi, 0, ",", ".") }}" @endif>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 0.4cm" id="div_kom">Total</td>
                                                    <td colspan="2" id="div_kom">
                                                        <input type="text" class="form-control" name="ed_total_h" id="ed_total_h" style="text-align:right" readonly="readonly" tabindex="-1"
                                                        @if ($do === null) value="0" 
                                                        @else value="{{ number_format($do->total_net, 0, ",", ".") }}" 
                                                        @endif
                                                    >
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="hidden" name="ed_total_total"></td>
                                                </tr>
                                                

                                                <input type="hidden" name="ed_total_temp">


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
                                                    <td style="width:110px; padding-top: 0.4cm">Marketing</td>
                                                    <td colspan="">
                                                        <select class="chosen-select-width marketingpengirim"  name="cb_marketing" style="width:100%">
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
                                                        <input type="text" class="form-control namapengirim" name="ed_nama_pengirim" style="text-transform: uppercase" value="{{ $do->nama_pengirim or null }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Alamat</td>
                                                    <td>
                                                        <input type="text" class="form-control alamatpengirim hanyaangka" name="ed_alamat_pengirim"  style="text-transform: uppercase" value="{{ $do->alamat_pengirim or null }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Kode Pos</td>
                                                    <td>
                                                        <input type="text" class="form-control kodepospengirim hanyaangka" name="ed_kode_pos_pengirim"  style="text-transform: uppercase" value="{{ $do->kode_pos_pengirim or null }}">
                                                        <span id="errmsg"></span>
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td style="width:110px; padding-top: 0.4cm">Telpon</td>
                                                    <td>
                                                        <input type="text" class="form-control teleponpengirim hanyaangka" name="ed_telpon_pengirim"  style="text-transform: uppercase" value="{{ $do->telpon_pengirim or null }}">
                                                        <span id="errmsg"></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="taruh_sini">
                                        
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
                                                        <input type="text" class="form-control namapenerima replace_deskripsi" name="ed_nama_penerima" style="text-transform: uppercase" value="{{ $do->nama_penerima or null }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Alamat</td>
                                                    <td>
                                                        <input type="text" class="form-control alamarpenerima" name="ed_alamat_penerima"  style="text-transform: uppercase" value="{{ $do->alamat_penerima or null }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Kab/Kota</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_kota" readonly="readonly" tabindex="-1" required style="text-transform: uppercase">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Kecamatan</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ed_kecamatan" readonly="readonly" tabindex="-1" required style="text-transform: uppercase">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Kode Pos</td>
                                                    <td>
                                                        <input type="text" class="form-control kodepospenerima hanyaangka" name="ed_kode_pos_penerima"  style="text-transform: uppercase" value="{{ $do->kode_pos_penerima or null }}">
                                                        <span id="errmsg"></span>
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td style="width:110px; padding-top: 0.4cm">Telpon</td>
                                                    <td>
                                                        <input type="text" class="form-control teleponpenerima hanyaangka" name="ed_telpon_penerima"  style="text-transform: uppercase" value="{{ $do->telpon_penerima or null }}">
                                                        <span id="errmsg"></span>
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
                                                <tr>
                                                    <td><input type="hidden" name="kontrak_tr" value="{{ $do->kontrak or null }}"></td>
                                                    <td><input type="hidden" name="kontrak_cus" value="{{ $do->kontrak_cus or null }}"></td>
                                                    <td><input type="hidden" name="kontrak_cus_dt" value="{{ $do->kontrak_cus_dt or null }}"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-success " id="btnsimpan" name="btnsimpan" ><i class="glyphicon glyphicon-save"></i> Simpan</button>
                                        <button type="button" class="btn btn-success " onclick="cetak()"><i class="glyphicon glyphicon-print "></i> Cetak</button>
                                        <button type="button" class="btn btn-success " id="btnsimpan_tambah" name="btnsimpan_tambah" ><i class="glyphicon glyphicon-save"></i> Simpan & Tambah Baru</button>
                                    </div>

                                    
                                </div>
                            </form>
                        </div>
                        <!--TIPE PENDAPATAN PAKET-->


                        {{-- HIDDEN --}}







                        <input type="hidden" name="tarif_vendor_bol" id="tarif_vendor_bol">
                        <input type="hidden" name="id_tarif_vendor" id="id_tarif_vendor">
                        <input type="hidden" name="nama_tarif_vendor" id="nama_tarif_vendor">

                        <!-- PATOKAN BERATI DI KALI TARIF DASAR ,  -->
                        <input type="hidden" name="tarif_dasar_patokan" id="tarif_dasar_patokan">

                        <!-- Berat Minimum-->
                        <input type="hidden" name="berat_minimum">






                        {{-- END OF HIDDEN --}}


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


                                        {{-- HIDDEN --}}


                                        <input type="hidden" name="berat_minimum">


                                        {{-- HIDDEN --}}

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="btnsave">Save changes</button>
                                </div>
                              </div>
                            </div>
                        </div>
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



    var crud_atas = $('#crud_atas').val(); 
    
  
    $('#cb_cabang').change(function(){
        var cabang_this = $(this).val();
        var tanggal_this = $('input[name="tanggal_this"]').val();
        if (crud_atas == 'N') {
            $.ajax({
               url:baseUrl+'/cari_kodenomor/cari_kodenomor',
               type:'get',
               data:{cabang_this:cabang_this,tanggal_this:tanggal_this},
               success:function(data){
                    if ($('#ed_nomor').val() == '') {
                            $('#ed_nomor').val(data.data);
                    }else{
                        var rep = $('#ed_nomor').val();
                        var rep_nom = rep.substr(0,3);
                        console.log(rep_nom);
                            if (rep_nom == 'PAK') {
                                $('#ed_nomor').val(data.data);
                            }else{

                            }
                    }
               }
           })
        }else{

        }

        
       
    })
    if (crud_atas == 'E') {
        
            $('#cb_cabang').attr('readonly','true');
            var hit_disc = $('#ed_diskon_h').val();
            var hit_pen = $("#ed_tarif_penerus").val();
            var hit_das = $("input[name='ed_tarif_dasar']").val();

            hit_disc_rep = hit_disc.replace(/[A-Za-z$. ,-]/g, "");
            hit_pen_rep = hit_pen.replace(/[A-Za-z$. ,-]/g, "");
            hit_das_rep = hit_das.replace(/[A-Za-z$. ,-]/g, "");
            // alert(hit_pen_rep);
            // alert(hit_das_rep);

            var tot_tot = parseInt(hit_pen_rep)+parseInt(hit_das_rep);

            // alert(tot_tot);
            // alert(hit_disc);
            var hit_tot = parseInt(hit_disc)/parseInt(tot_tot)*100;
            // alert(hit_tot);
            $('#ed_diskon_h').val(hit_tot);
    }
    

    

    Number.prototype.format = function(n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&.');
    };

    var listCabang = [];
    var listDiskon = [];
    var maxdiskon = 100;
    var maxvalue = 0;
    
    $(document).ready( function () {
        $("#surat_jalan").hide();
        $("#dimensi").hide();
        $("#nopol").hide();
        $("#koli").hide();
        $("#berat").hide();
        $("#jenis_kendaraan").hide();
        $("#komisi").hide();
        $("#jml_unit").hide();
        $(".jenis_unit").hide();
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
        $(".kontrak_tarif").attr('checked', {{ $do->kontrak or null}});

        var data = $("select[name='cb_kota_tujuan'] option:selected").text();
        $("input[name='ed_kota']").val(data);
        var datakec = $("select[name='cb_kecamatan_tujuan'] option:selected").text();
        $("input[name='ed_kecamatan']").val(datakec);
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
                '.chosen-select-no-results': {form_header:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"100%",search_contains:true}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

        //$("input[name='ed_harga'],input[name='ed_jumlah'],input[name='ed_biaya_penerus'],input[name='ed_diskon']").maskMoney({thousands:'.', decimal:',', precision:-1});
        $("input[name='ed_biaya_tambahan'],input[name='ed_biaya_komisi'],input[name='ed_berat'],input[name='ed_dpp'],input[name='ed_vendor']").maskMoney({thousands:'', decimal:'', precision:-1});
    @if($do != null)
        $('#btn_cari_harga').click();
    @endif

    @foreach ($cabang as $index=>$element)
        listCabang[{{ $index }}] = '{{ $element->kode }}';
        @if ($element->diskon == null)
            listDiskon[{{ $index }}] = 0;
        @else
            listDiskon[{{ $index }}] = {{ $element->diskon }};
        @endif
    @endforeach

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

    $("input[name='ed_diskon_h']").keyup(function(){
        if ($(this).val() != 0) {
            $("input[name='ed_diskon_v']").attr('readonly',true);
        }else{
            $("input[name='ed_diskon_v']").attr('readonly',false);
        }
    })

    $("#ed_diskon_v").keyup(function(){
        // console.log('asd');
        if ($(this).val() != 0) {
            $("input[name='ed_diskon_h']").attr('readonly',true);
        }else{
            $("input[name='ed_diskon_h']").attr('readonly',false);
        }
    })
    
    function hitung(){
        if (crud_atas == 'N') {
            $("input[name='ed_vendor']").prop('readonly',true);
            var tarif_dasar = $("input[name='ed_tarif_dasar']").val();
            var biaya_penerus = $("input[name='ed_tarif_penerus']").val();
            var biaya_tambahan = $("input[name='ed_biaya_tambahan']").val();
            var berat_val = $("input[name='ed_berat']").val();
            var koli_val = $("input[name='ed_koli']").val();
            if (berat_val == 0) { 
                berat_val == 1;
            }else{
                berat_val = $("input[name='ed_berat']").val();
            }

            if (koli_val == 0) {
                koli_val == 1;
            }else{
                koli_val = $("input[name='ed_koli']").val();
            }
            var diskon  = $("input[name='ed_diskon_h']").val();
            var diskon_value  = $("input[name='ed_diskon_v']").val();
            var diskon_val  = $("input[name='ed_diskon_h']").val();
            var biaya_komisi  = $("input[name='ed_biaya_komisi']").val();
            var dpp_val  = $("input[name='ed_dpp']").val();

            var tarif_dasar = tarif_dasar.replace(/[A-Za-z$. ,-]/g, "");
            var berat_val = berat_val.replace(/[A-Za-z$. ,-]/g, "");
            var koli_val = koli_val.replace(/[A-Za-z$. ,-]/g, "");
            var biaya_penerus = biaya_penerus.replace(/[A-Za-z$. ,-]/g, "");
            var biaya_tambahan = biaya_tambahan.replace(/[A-Za-z$. ,-]/g, "");

            var biaya_komisi = biaya_komisi.replace(/[A-Za-z$. ,-]/g, "");
            var dpp_val = dpp_val.replace(/[A-Za-z$. ,-]/g, "");
            // var diskon = diskon.replace(/[A-Za-z$. ,-]/g, "");
            var jenis_ppn = $("select[name='cb_jenis_ppn']").val();
            var this_selected_value = $('#cb_cabang').find(':selected').data('diskon');
            // alert(this_selected_value);
                if(diskon_val > this_selected_value){
                     Command: toastr["warning"]("Tidak boleh memasukkan diskon melebihi ketentuan", "Peringatan !")

                    toastr.options = {
                      "closeButton": false,
                      "debug": true,
                      "newestOnTop": false,
                      "progressBar": true,
                      "positionClass": "toast-top-right",
                      "preventDuplicates": true,
                      "onclick": null,
                      "showDuration": "300",
                      "hideDuration": "1000",
                      "timeOut": "5000",
                      "extendedTimeOut": "1000",
                      "showEasing": "swing",
                      "hideEasing": "linear",
                      "showMethod": "fadeIn",
                      "hideMethod": "fadeOut"
                    }
                    $("input[name='ed_diskon_h']").val(0);
                }
            // 
            if (diskon > 0 && biaya_tambahan > 0) {
                alert("Diskon dan biaya tambahan di isi salah satu");
                parseFloat($("input[name='ed_diskon_h']").val(0));
                $("input[name='ed_biaya_tambahan']").val(0);
                diskon = 0;
                biaya_tambahan = 0;
                $("input[name='ed_biaya_tambahan']").focus();
            }
            if ($("select[name='cb_outlet']").val() == '' ) {
                biaya_komisi = 0;
            }
            var total  = parseFloat(tarif_dasar) + parseFloat(biaya_penerus) + parseFloat(biaya_tambahan) + parseFloat(biaya_komisi);
            var dpp  = parseFloat(tarif_dasar) + parseFloat(biaya_penerus) + parseFloat(biaya_tambahan) + parseFloat(biaya_komisi);
            var vendor  = parseFloat(tarif_dasar) + parseFloat(biaya_penerus) + parseFloat(biaya_tambahan) + parseFloat(biaya_komisi);
            var total_total  = parseFloat(tarif_dasar) + parseFloat(biaya_penerus);
            //--
            if (diskon != 0) {

                var diskon_value_utama = diskon / 100 * total;

                $("input[name='ed_diskon_v']").val(Math.round(diskon_value_utama));

            }else if (diskon == 0) {
                var diskon_value_utama = diskon / 100 * total;

                $("input[name='ed_diskon_v']").val(Math.round(diskon_value_utama));
            }
           
            // alert(diskon_value_utama);
            //--
            var ppn  = 0;//parseFloat(total)/parseFloat(10)    ;
            if (jenis_ppn == 1) {
                ppn =parseFloat(total) * parseFloat(0.1);
                total = total + ppn;
            }else if (jenis_ppn == 2) {
                ppn =parseFloat(total) * parseFloat(0.01);
                total = total + ppn;
            }else if (jenis_ppn == 4) {
                ppn =0;
            }else if (jenis_ppn == 3) {
                ppn =parseFloat(total) / parseFloat(100.1);
                //total = total - ppn;
            }else if (jenis_ppn == 5) {
                ppn =parseFloat(total) / parseFloat(10.1);
                total = total - ppn;
            }
          
            // console.log(diskon_value_utama);
          
            var total_h = total-diskon_value_utama;
            var dpp_h = dpp-diskon_value_utama;

            $("input[name='ed_jml_ppn']").val(accounting.formatMoney(ppn,"",0,'.',','));
            
            $("input[name='ed_total_h']").val(accounting.formatMoney(total_h,"",0,'.',','));
            
            $("input[name='ed_total_total']").val(total);

            if ($('.vendor_tarif').is(':checked') == false) {
                
                $("input[name='ed_dpp']").val(accounting.formatMoney(dpp_h,"",0,'.',','));
            }else{
                $("input[name='ed_vendor']").prop('readonly',false);
                $("input[name='ed_vendor']").val(accounting.formatMoney(dpp_h,"",0,'.',','));
                
            }
        }else if(crud_atas == 'E'){
            $(document).ready(function() {
                if ($('input[name="kontrak_tarif"]').is(':checked') ==true) {
                    $('#hidden_button').show(); 
                    var berat_val = $("input[name='ed_berat']").val();
                    var koli_val = $("input[name='ed_koli']").val();
                    if (berat_val == 0) { 
                        berat_val == 1;
                    }else{
                        berat_val = $("input[name='ed_berat']").val();
                    }

                    if (koli_val == 0) {
                        koli_val == 1;
                    }else{
                        koli_val = $("input[name='ed_koli']").val();
                    }
                    var cek_kondisi_penerus = $("input[name='ed_tarif_penerus']").val();

                    var tarif_dasar = $("input[name='ed_tarif_dasar']").val(accounting.formatMoney('{{ $do->tarif_dasar or null }}',"",0,'.',','));
                    var biaya_penerus = $("input[name='ed_tarif_penerus']").val(accounting.formatMoney('{{ $do->tarif_penerus or null }}',"",0,'.',','));
                    var biaya_tambahan = $("input[name='ed_biaya_tambahan']").val(accounting.formatMoney('{{ $do->biaya_tambahan or null }}',"",0,'.',','));
                    var biaya_komisi = $("input[name='ed_biaya_komisi']").val(accounting.formatMoney('{{ $do->biaya_komisi or null }}',"",0,'.',','));


                    var diskon = $("input[name='ed_diskon_h']").val();
                    var diskon_value = $("input[name='ed_diskon_v']").val();
                    var dpp_val = $("input[name='ed_dpp']").val();
                    var dpp_vendo = $("input[name='ed_vendor']").val();
                    var tarif_dasar = tarif_dasar.replace(/[A-Za-z$. ,-]/g, "");
                    
                    var biaya_penerus = biaya_penerus.replace(/[A-Za-z$. ,-]/g, "");
                    var biaya_tambahan = biaya_tambahan.replace(/[A-Za-z$. ,-]/g, "");
                    var berat_val = berat_val.replace(/[A-Za-z$. ,-]/g, "");
                    var koli_val = koli_val.replace(/[A-Za-z$. ,-]/g, "");
                    var biaya_komisi = biaya_komisi.replace(/[A-Za-z$. ,-]/g, "");
                    var dpp_val = dpp_val.replace(/[A-Za-z$. ,-]/g, "");

                    var total  = parseFloat(tarif_dasar) + parseFloat(biaya_penerus) + parseFloat(biaya_tambahan) + parseFloat(biaya_komisi);
                    var dpp  = parseFloat(tarif_dasar) + parseFloat(biaya_penerus) + parseFloat(biaya_tambahan) + parseFloat(biaya_komisi);
                    var vendor  = parseFloat(tarif_dasar) + parseFloat(biaya_penerus) + parseFloat(biaya_tambahan) + parseFloat(biaya_komisi);
                    var total_total  = parseFloat(tarif_dasar) + parseFloat(biaya_penerus);
                    //--
                    
                    
                    
                    if (diskon != 0) {

                        var diskon_value_utama = diskon / 100 * total;

                        $("input[name='ed_diskon_v']").val(Math.round(diskon_value_utama));

                    }else if (diskon == 0) {
                        var diskon_value_utama = diskon / 100 * total;

                        $("input[name='ed_diskon_v']").val(Math.round(diskon_value_utama));
                    }
                   
                    // alert(diskon_value_utama);
                    //--
                    var ppn  = 0;//parseFloat(total)/parseFloat(10)    ;
                    if (jenis_ppn == 1) {
                        ppn =parseFloat(total) * parseFloat(0.1);
                        total = total + ppn;
                    }else if (jenis_ppn == 2) {
                        ppn =parseFloat(total) * parseFloat(0.01);
                        total = total + ppn;
                    }else if (jenis_ppn == 4) {
                        ppn =0;
                    }else if (jenis_ppn == 3) {
                        ppn =parseFloat(total) / parseFloat(100.1);
                        //total = total - ppn;
                    }else if (jenis_ppn == 5) {
                        ppn =parseFloat(total) / parseFloat(10.1);
                        total = total - ppn;
                    }
                  
                    // console.log(diskon_value_utama);
                  
                    var total_h = total-diskon_value_utama;
                    var dpp_h = dpp-diskon_value_utama;
                    // console.log(total_h);
                    $("input[name='ed_jml_ppn']").val(accounting.formatMoney(ppn,"",0,'.',','));
                    
                    $("input[name='ed_total_h']").val(accounting.formatMoney(total_h,"",0,'.',','));
                    

                    if ($('.vendor_tarif').is(':checked') == false) {
                        $("input[name='ed_dpp']").val(accounting.formatMoney(dpp_h,"",0,'.',','));
                    }else{
                        $("input[name='ed_vendor']").prop('readonly',false);
                        $("input[name='ed_vendor']").val(accounting.formatMoney(dpp_h,"",0,'.',','));
                        
                    }

                }else{
                    var tarif_dasar = $("input[name='ed_tarif_dasar']").val();
                    var biaya_penerus = $("input[name='ed_tarif_penerus']").val();
                    var biaya_tambahan = $("input[name='ed_biaya_tambahan']").val();
                    var berat_val = $("input[name='ed_berat']").val();
                    var koli_val = $("input[name='ed_koli']").val();
                    if (berat_val == 0) { 
                        berat_val == 1;
                    }else{
                        berat_val = $("input[name='ed_berat']").val();
                    }

                    if (koli_val == 0) {
                        koli_val == 1;
                    }else{
                        koli_val = $("input[name='ed_koli']").val();
                    }
                    var diskon  = $("input[name='ed_diskon_h']").val();
                    var diskon_value  = $("input[name='ed_diskon_v']").val();
                    var diskon_val  = $("input[name='ed_diskon_h']").val();
                    var biaya_komisi  = $("input[name='ed_biaya_komisi']").val();
                    var dpp_val  = $("input[name='ed_dpp']").val();

                    var tarif_dasar = tarif_dasar.replace(/[A-Za-z$. ,-]/g, "");
                    var berat_val = berat_val.replace(/[A-Za-z$. ,-]/g, "");
                    var koli_val = koli_val.replace(/[A-Za-z$. ,-]/g, "");
                    var biaya_penerus = biaya_penerus.replace(/[A-Za-z$. ,-]/g, "");
                    var biaya_tambahan = biaya_tambahan.replace(/[A-Za-z$. ,-]/g, "");

                    var biaya_komisi = biaya_komisi.replace(/[A-Za-z$. ,-]/g, "");
                    var dpp_val = dpp_val.replace(/[A-Za-z$. ,-]/g, "");
                    // var diskon = diskon.replace(/[A-Za-z$. ,-]/g, "");
                    var jenis_ppn = $("select[name='cb_jenis_ppn']").val();
                    var this_selected_value = $('#cb_cabang').find(':selected').data('diskon');
                    // alert(this_selected_value);
                        if(diskon_val > this_selected_value){
                             Command: toastr["warning"]("Tidak boleh memasukkan diskon melebihi ketentuan", "Peringatan !")

                            toastr.options = {
                              "closeButton": false,
                              "debug": true,
                              "newestOnTop": false,
                              "progressBar": true,
                              "positionClass": "toast-top-right",
                              "preventDuplicates": true,
                              "onclick": null,
                              "showDuration": "300",
                              "hideDuration": "1000",
                              "timeOut": "5000",
                              "extendedTimeOut": "1000",
                              "showEasing": "swing",
                              "hideEasing": "linear",
                              "showMethod": "fadeIn",
                              "hideMethod": "fadeOut"
                            }
                            $("input[name='ed_diskon_h']").val(0);
                        }
                    // 
                    if (diskon > 0 && biaya_tambahan > 0) {
                        alert("Diskon dan biaya tambahan di isi salah satu");
                        parseFloat($("input[name='ed_diskon_h']").val(0));
                        $("input[name='ed_biaya_tambahan']").val(0);
                        diskon = 0;
                        biaya_tambahan = 0;
                        $("input[name='ed_biaya_tambahan']").focus();
                    }
                    if ($("select[name='cb_outlet']").val() == '' ) {
                        biaya_komisi = 0;
                    }
                    var total  = parseFloat(tarif_dasar) + parseFloat(biaya_penerus) + parseFloat(biaya_tambahan) + parseFloat(biaya_komisi);
                    var dpp  = parseFloat(tarif_dasar) + parseFloat(biaya_penerus) + parseFloat(biaya_tambahan) + parseFloat(biaya_komisi);
                    var vendor  = parseFloat(tarif_dasar) + parseFloat(biaya_penerus) + parseFloat(biaya_tambahan) + parseFloat(biaya_komisi);
                    var total_total  = parseFloat(tarif_dasar) + parseFloat(biaya_penerus);
                    //--
                    if (diskon != 0) {

                        var diskon_value_utama = diskon / 100 * total;

                        $("input[name='ed_diskon_v']").val(Math.round(diskon_value_utama));

                    }else if (diskon == 0) {
                        var diskon_value_utama = diskon / 100 * total;

                        $("input[name='ed_diskon_v']").val(Math.round(diskon_value_utama));
                    }
                   
                    // alert(diskon_value_utama);
                    //--
                    var ppn  = 0;//parseFloat(total)/parseFloat(10)    ;
                    if (jenis_ppn == 1) {
                        ppn =parseFloat(total) * parseFloat(0.1);
                        total = total + ppn;
                    }else if (jenis_ppn == 2) {
                        ppn =parseFloat(total) * parseFloat(0.01);
                        total = total + ppn;
                    }else if (jenis_ppn == 4) {
                        ppn =0;
                    }else if (jenis_ppn == 3) {
                        ppn =parseFloat(total) / parseFloat(100.1);
                        //total = total - ppn;
                    }else if (jenis_ppn == 5) {
                        ppn =parseFloat(total) / parseFloat(10.1);
                        total = total - ppn;
                    }
                  
                    // console.log(diskon_value_utama);
                  
                    var total_h = total-diskon_value_utama;
                    var dpp_h = dpp-diskon_value_utama;

                    $("input[name='ed_jml_ppn']").val(accounting.formatMoney(ppn,"",0,'.',','));
                    
                    $("input[name='ed_total_h']").val(accounting.formatMoney(total_h,"",0,'.',','));
                    
                    $("input[name='ed_total_total']").val(total);

                    if ($('.vendor_tarif').is(':checked') == false) {
                        
                        $("input[name='ed_dpp']").val(accounting.formatMoney(dpp_h,"",0,'.',','));
                    }else{
                        $("input[name='ed_vendor']").prop('readonly',false);
                        $("input[name='ed_vendor']").val(accounting.formatMoney(dpp_h,"",0,'.',','));
                        
                    }
                }
            })
            
        }
              
     
    }
    
    $('.dv').keyup(function(){
        var dpp_hit = $("input[name='ed_dpp']").val();
        var vendor_hit = $("input[name='ed_vendor']").val();
        var total_hit = $("input[name='ed_total_h']").val();

        var dpp_hit = dpp_hit.replace(/[A-Za-z$. ,-]/g, "");
        var vendor_hit = vendor_hit.replace(/[A-Za-z$. ,-]/g, "");
        var total_hit = total_hit.replace(/[A-Za-z$. ,-]/g, "");


        var cek = parseInt(dpp_hit)+parseInt(vendor_hit);
        $('input[name="ed_total_total"]').val(cek);
        // console.log(total_hit);
        if (cek > total_hit) {
             Command: toastr["warning"]("Dpp Melebihi Batas Ketentuan", "Peringatan!")

                toastr.options = {
                  "closeButton": false,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": true,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
            $("input[name='ed_dpp']").val(0);
            $("input[name='ed_vendor']").val(0);

        }   
     })

     
         
    
    

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
        var status = $(this).find(':selected').data('status');
        var customer = $(this).val();
        var cabang = $('select[name="cb_cabang"]').val();
        $("input[name='ed_nama_pengirim']").val(nama);
        $("input[name='ed_telpon_pengirim']").val(telpon);
        $("input[name='ed_alamat_pengirim']").val(alamat);
        if (cabang == '') {
            Command: toastr["warning"]("Cabang Harap Di isi Terlebih dahulu", "Peringatan!")

                    toastr.options = {
                      "closeButton": false,
                      "debug": false,
                      "newestOnTop": false,
                      "progressBar": true,
                      "positionClass": "toast-top-right",
                      "preventDuplicates": true,
                      "onclick": null,
                      "showDuration": "300",
                      "hideDuration": "1000",
                      "timeOut": "5000",
                      "extendedTimeOut": "1000",
                      "showEasing": "swing",
                      "hideEasing": "linear",
                      "showMethod": "fadeIn",
                      "hideMethod": "fadeOut"
                    }
                        $('#cb_customer').val('').trigger('chosen:updated');

                    return false;

        }

        $.ajax(
        {
            url : baseUrl + "/sales/deliveryorderform/cari_customer_kontrak",
            type: "GET",
            data : {a:status,b:cabang,c:customer},
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                console.log(data);
                if (data.data == 0) {
                    Command: toastr["warning"]("Customer Tidak Memiliki Kontrak. Harap Isi Data Dengan Benar", "Pemberitahuan")

                    toastr.options = {
                      "closeButton": false,
                      "debug": false,
                      "newestOnTop": false,
                      "progressBar": true,
                      "positionClass": "toast-top-right",
                      "preventDuplicates": true,
                      "onclick": null,
                      "showDuration": "300",
                      "hideDuration": "1000",
                      "timeOut": "5000",
                      "extendedTimeOut": "1000",
                      "showEasing": "swing",
                      "hideEasing": "linear",
                      "showMethod": "fadeIn",
                      "hideMethod": "fadeOut"
                    }
                    $(".kontrak_tarif").prop('checked',false); 
                }else{
                    if(data.data[0].kc_aktif == 'AKTIF'){
                        // alert('a');
                        Command: toastr["info"]("Customer Memiliki Kontrak. Harap Tekan Tombol Search", "Pemberitahuan")

                        toastr.options = {
                          "closeButton": false,
                          "debug": false,
                          "newestOnTop": false,
                          "progressBar": true,
                          "positionClass": "toast-top-right",
                          "preventDuplicates": true,
                          "onclick": null,
                          "showDuration": "300",
                          "hideDuration": "1000",
                          "timeOut": "5000",
                          "extendedTimeOut": "1000",
                          "showEasing": "swing",
                          "hideEasing": "linear",
                          "showMethod": "fadeIn",
                          "hideMethod": "fadeOut"
                        }

                        $(".kontrak_tarif").prop('checked',true);            
                    }else{
                        
                        $(".kontrak_tarif").prop('checked',false);            
                    }
                }
                
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               // swal("Error!", textStatus, "error");
            }
        });
        
        
    });

     $('input[name="vendor_tarif"]').change(function() {
        hitung();
        var check = $(this).is(':checked'); 
        var vendor = $("input[name='ed_dpp']").val();
        var dpp = $("input[name='ed_vendor']").val();
        if (check == true) {
            $("input[name='ed_vendor']").val(vendor);
            $("input[name='ed_dpp']").val(0);
        }else{
            $("input[name='ed_dpp']").val(dpp);
            $("input[name='ed_vendor']").val(0);
        }

        
    });

    $("select[name='cb_jenis_ppn']").change(function(){
        hitung();
    });

    $("select[name='cb_kota_tujuan']").change(function(){
        var data = $("select[name='cb_kota_tujuan'] option:selected").text();
        $("input[name='ed_kota']").val(data);
    });
    $("select[name='cb_kecamatan_tujuan']").change(function(){
        var data = $("select[name='cb_kecamatan_tujuan'] option:selected").text();
        $("input[name='ed_kecamatan']").val(data);
    });
    
    $(document).on("click","#ck_ppn",function(){
        hitung();
    });
    
        $('#type_kiriman').change(function(){
            $("input[name='ed_tarif_dasar']").val(0);
            $("input[name='ed_tarif_penerus']").val(0);
            $("input[name='acc_penjualan']").val(0);
            hitung();
            type_kiriman=$(this).val();
            if ( type_kiriman =='DOKUMEN') {
                $("#surat_jalan").hide();
                $("#dimensi").hide();
                $("#nopol").hide();
                $("#koli").hide();
                $("#berat").hide();
                $("#jenis_kendaraan").hide();
                $("#jml_unit").hide();
                $('#tr_jenis_kiriman').show();
                $(".jenis_unit").hide();
            }else if ( type_kiriman =='KARGO PAKET') {
                $("#surat_jalan").show();
                $("#dimensi").hide();
                $("#nopol").show();
                $("#koli").hide();
                $("#berat").hide();
                $("#jenis_kendaraan").show();
                $("#jml_unit").hide();
                $('#tr_jenis_kiriman').show();
                $(".jenis_unit").hide();
            }else if ( type_kiriman =='KILOGRAM') {
                $("#surat_jalan").hide();
                $("#dimensi").show();
                $("#nopol").hide();
                $("#koli").show();
                $("#berat").show();
                $("#jenis_kendaraan").hide();
                $("#jml_unit").hide();
                $('#tr_jenis_kiriman').show();
                $(".jenis_unit").hide();
            }else if ( type_kiriman =='KOLI') {
                $("#surat_jalan").hide();
                $("#dimensi").hide();
                $("#nopol").hide();
                $("#koli").show();
                $("#berat").show();
                $("#jenis_kendaraan").hide();
                $("#jml_unit").hide();
                $('#tr_jenis_kiriman').show();
                $(".jenis_unit").hide();
            }else if ( type_kiriman =='SEPEDA') {
                $("#surat_jalan").hide();
                $("#dimensi").hide();
                $("#nopol").hide();
                $("#koli").hide();
                $("#berat").hide();
                $("#jenis_kendaraan").hide();
                $("#jml_unit").show();
                $(".jenis_unit").show();
                $("#tr_jenis_kiriman").hide();
            }else if ( type_kiriman =='KERTAS') {
                $("#surat_jalan").show();
                $("#dimensi").hide();
                $("#nopol").show();
                $("#koli").hide();
                $("#berat").show();
                $("#jenis_kendaraan").hide();
                $("#jml_unit").hide();
                $('#tr_jenis_kiriman').show();
                $(".jenis_unit").hide();
            }else if ( type_kiriman =='KARGO KERTAS') {
                $("#surat_jalan").show();
                $("#dimensi").hide();
                $("#nopol").show();
                $("#koli").hide();
                $("#berat").hide();
                $("#jenis_kendaraan").show();
                $('#tr_jenis_kiriman').show();
                $("#jml_unit").hide();
                $(".jenis_unit").hide();
            }
        });


    $(document).on("click","#btn_cari_tipe",function(){
            var berat = $("input[name='ed_berat']").val();
            var berat = berat.replace(/[A-Za-z$. ,-]/g, "");
            var jenis_sepeda;
            var berat_sepeda;
            var input = document.getElementsByClassName( 'jns_unit' ),
            jenis_sepeda  = [].map.call(input, function( input ) {
                return input.value;
            });
            var berat_sepeda;
            var input = document.getElementsByClassName( 'beratunit' ),
            berat_sepeda  = [].map.call(input, function( input ) {
                return input.value;
            });


            var value = {
                    pendapatan: $("select[name='pendapatan']").val(),
                    asal: $("select[name='cb_kota_asal']").val(),
                    tujuan: $("select[name='cb_kota_tujuan']").val(),
                    tipe: $("select[name='type_kiriman']").val(),
                    tujuan: $("select[name='cb_kota_tujuan']").val(),
                    jenis: $("select[name='jenis_kiriman']").val(),
                    angkutan: $("select[name='cb_angkutan']").val(),
                    cabang: $("select[name='cb_cabang']").val(),
                    berat : berat,
                    kecamatan : $("select[name='cb_kecamatan_tujuan']").val(),
                    sepeda: jenis_sepeda,
                    berat_sepeda: berat_sepeda
                };
            var kecamatan = $('#kecamatan').find(':selected').val();
            if (kecamatan == '') {
                Command: toastr["warning"]("Pilih Kecamatan Terlebih Dahulu", "Peringatan!")

                toastr.options = {
                  "closeButton": false,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": true,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }

                return false;

            }

                $.ajax(
                {
                    url : baseUrl + "/sales/deliveryorderform/cari_tipe",
                    type: "GET",
                    data : value,
                    dataType:'json',
                    success: function(data, textStatus, jqXHR)
                    {
                        console.log(data);
                        $('input[name="ed_tarif_dasar"]').val(accounting.formatMoney(data.harga,"",0,'.',','));
                        $('input[name="ed_tarif_penerus"]').val(accounting.formatMoney(data.biaya_penerus,"",0,'.',','));
                        var koli_dikali =$("input[name='ed_koli']").val() ;
                        if (koli_dikali == 0 ) {
                            // alert('a');
                            var hit = data.harga  * 1;
                        }else{
                            // alert('b');
                            var hit = parseInt($("input[name='ed_koli']").val())  *  data.harga;
                        }
                        if (data.biaya_penerus == 0){
                             Command: toastr["warning"]("Zona/Penerus tidak ditemukan", "Peringatan !")
                                toastr.options = {
                                  "closeButton": false,
                                  "debug": true,
                                  "newestOnTop": false,
                                  "progressBar": true,
                                  "positionClass": "toast-top-right",
                                  "preventDuplicates": false,
                                  "onclick": null,
                                  "showDuration": "300",
                                  "hideDuration": "1000",
                                  "timeOut": "5000",
                                  "extendedTimeOut": "1000",
                                  "showEasing": "swing",
                                  "hideEasing": "linear",
                                  "showMethod": "fadeIn",
                                  "hideMethod": "fadeOut"
                                }
                            $("input[name='ed_tarif_penerus']").css('width','220px');
                            $("#button_a").show();

                            if (type_kiriman == 'DOKUMEN') {
                                $("#button_a").html('<button class="btn btn-warning" type="button" style="margin-top: -50px;margin-left: 230px;" onclick="dokumen_tipe()"><i class="fa fa-plus"></i></button>')
                            }else if (type_kiriman == 'KILOGRAM') {
                                $("input[name='ed_tarif_penerus']").css('width','220px');
                                $("#button_a").html('<button class="btn btn-info"type="button"  style="margin-top: -50px;margin-left: 230px;" onclick="kilogram_tipe()"><i class="fa fa-plus"></i></button>')
                            }else if (type_kiriman == 'KOLI') {
                                $("input[name='ed_tarif_penerus']").css('width','220px');
                                $("#button_a").html('<button class="btn btn-primary" type="button" style="margin-top: -50px;margin-left: 230px;" onclick="koli_tipe()"><i class="fa fa-plus"></i></button>')
                            }else if (type_kiriman == 'SEPEDA') {
                                $("input[name='ed_tarif_penerus']").css('width','220px');
                                $("#button_a").html('<button class="btn btn-danger" type="button" style="margin-top: -50px;margin-left: 230px;" onclick="sepeda_tipe()"><i class="fa fa-plus"></i></button>')
                            } 
                        }else{
                            $("input[name='ed_tarif_penerus']").css('width','100%');
                            $("#button_a").hide();  
                        }
                        $('input[name="ed_tarif_dasar"]').val(accounting.formatMoney(hit,"",0,'.',','));
                        hitung();
                    }
                })


    })



    
    $(document).on("click","#btn_cari_harga",function(){
        
        var kota_asal = $("select[name='cb_kota_asal']").val();
        var kecamatan_tujuan = $("select[name='cb_kecamatan_tujuan']").val();
        var kota_tujuan = $("select[name='cb_kota_tujuan']").val();
        var pendapatan = $("select[name='pendapatan']").val();
        var type = $("select[name='type_kiriman']").val();
        var jenis =$("select[name='jenis_kiriman']").val();
        var angkutan = $("select[name='cb_angkutan']").val();
        var cabang = $("select[name='cb_cabang']").val();
        var berat = $("input[name='ed_berat']").val();
        var berat = berat.replace(/[A-Za-z$. ,-]/g, "");
        var jenis_sepeda;
        var input = document.getElementsByClassName( 'jns_unit' ),
        jenis_sepeda  = [].map.call(input, function( input ) {
            return input.value;
        });
        var berat_sepeda;
        var input = document.getElementsByClassName( 'beratunit' ),
        berat_sepeda  = [].map.call(input, function( input ) {
            return input.value;
        });
        $("input[name='ed_harga']").val(0);
        
        if ($('.kontrak_tarif').is(":checked"))
        {
        
           if (crud_atas == 'N') {
              var cabang_kontrak = $('select[name="cb_cabang"]').val();
                var customer_kotrak = $('#cb_customer').find(':selected').val();
                $.ajax({
                            url : baseUrl + "/sales/deliveryorderform/cari_kontrak",
                            type: "GET",
                            data : {a:customer_kotrak,b:cabang_kontrak},
                            // dataType:'json',
                            success: function(data)
                            {   
                                console.log(data);
                                var cabang_kontrak = $('select[name="cb_cabang"]').val();
                                var customer_kotrak = $('#cb_customer').find(':selected').val()
                                $.ajax({
                                        url:baseUrl+'/sales/cari_modalkontrakcustomer',
                                        data : {a:customer_kotrak,b:cabang_kontrak},
                                        type:'get',
                                            success:function(data){
                                                $('#taruh_sini').html(data);
                                                $("#modal").modal("show");
                                                $('#ajax_modal_kontrak').DataTable();
                                                if (koli_dikali == 0 ) {
                                
                                                    var hit = data.harga  * 1;
                                                }else{
                                                    // alert('b');
                                                    var hit = parseInt($("input[name='ed_koli']").val())  * data.harga;
                                                }

                                            },
                                            complete:function(){
                                            }
                                        }); 

                            }
                        }); 
           }else{
            // alert('a');
           }
        // $('#btn_cari_tipe').show();

               


        }else{
              if (kota_asal == '') {
            Command: toastr["warning"]("Kota Asal harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (kota_tujuan == '') {
          Command: toastr["warning"]("Kota Tujuan harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
            }else if (kecamatan_tujuan == '' || kecamatan_tujuan == null) {
              Command: toastr["warning"]("Kecamatan Tujuan harus diisi", "Peringatan !")

                toastr.options = {
                  "closeButton": false,
                  "debug": true,
                  "newestOnTop": false,
                  "progressBar": true,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
                return false;
            }else if (pendapatan == '') {
           Command: toastr["warning"]("Pendapatan harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (type_kiriman == '') {
             Command: toastr["warning"]("Tipe Kiriman harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (jenis_kiriman == '') {
           Command: toastr["warning"]("Jenis Kiriman harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (cabang == '') {
           Command: toastr["warning"]("Cabang harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
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
                    berat : berat,
                    kecamatan : $("select[name='cb_kecamatan_tujuan']").val(),
                    sepeda: jenis_sepeda,
                    berat_sepeda: berat_sepeda
                };

                $.ajax(
                {
                    url : baseUrl + "/sales/deliveryorderform/cari_harga",
                    type: "GET",
                    data : value,
                    dataType:'json',
                    success: function(data, textStatus, jqXHR)
                    {
                        console.log(data);
                        if (data.status == 'kosong' || data.create_indent == 0 ) {
                            
                            
                                 Command: toastr["warning"]("Tidak ada data terkait", "Peringatan !")

                                toastr.options = {
                                  "closeButton": false,
                                  "debug": true,
                                  "newestOnTop": false,
                                  "progressBar": true,
                                  "positionClass": "toast-top-right",
                                  "preventDuplicates": false,
                                  "onclick": null,
                                  "showDuration": "300",
                                  "hideDuration": "1000",
                                  "timeOut": "5000",
                                  "extendedTimeOut": "1000",
                                  "showEasing": "swing",
                                  "hideEasing": "linear",
                                  "showMethod": "fadeIn",
                                  "hideMethod": "fadeOut"
                                }

                                $("input[name='ed_tarif_dasar']").val(0);
                                $("input[name='ed_tarif_penerus']").val(0);
                                $("input[name='acc_penjualan']").val(0);
                                hitung();
                            
                           
                        } else if (data.create_indent == 1) {
                            var harga = convertToRupiah(parseInt(data.harga));
                            
                            var koli_dikali =$("input[name='ed_koli']").val() ;
                            var berat_minimum  =$("input[name='ed_berat']").val();
                            if (data.tipe == 'KILOGRAM') {
                                if (data.batas != 0 || data.batas != null) {
                                    toastr.info('Berat minimum adalah '+'<b style="color:red">'+data.batas+'</b>'+' KG','Pemberitahuan!')
                                    if (berat_minimum < data.batas) {
                                        //hitung hasil dari pencarian
                                        var hitung_berat = parseFloat(data.batas)*parseFloat(data.harga);
                                        //replace berat dan tarif dasar
                                        $("input[name='ed_berat']").val(data.batas);
                                        $("input[name='berat_minimum']").val(data.batas);
                                        $('#ed_tarif_dasar').val(accounting.formatMoney(hitung_berat,"",0,'.',','));
                                        $('#tarif_dasar_patokan').val(data.harga);
                                    }else{
                                        //replace berat dan tarif dasar
                                        $("input[name='berat_minimum']").val(data.batas);
                                        $('#ed_tarif_dasar').val(accounting.formatMoney(data.harga,"",0,'.',','));
                                        $('#tarif_dasar_patokan').val(data.harga);
                                    }
                                }else{
                                    toastr.error('Berat minimum belum di set / kosong ','Peringatan!')
                                }
                            }
                                        
                            var biaya = convertToRupiah(parseInt(data.biaya_penerus));
                            var cek_tipe = $('#type_kiriman').find(':selected').val();
                            if (koli_dikali == 0 ) {
                                // alert('a');
                                if (cek_tipe != 'KILOGRAM') {
                                    var hit = data.harga  * 1;
                                }else{
                                    var hit = data.harga;
                                }
                                
                            }else{
                                // alert('b');
                                if (cek_tipe != 'KILOGRAM') {
                                    var hit = parseInt($("input[name='ed_koli']").val())  * data.harga;
                                }else{
                                    var hit = data.harga;
                                }
                                
                            }

                            // alert(hit);
                            var acc_penjualan = data.acc_penjualan;
                            $("input[name='ed_tarif_dasar']").val(accounting.formatMoney(hit,"",0,'.',','));
                            // $("input[name='ed_tarif_dasar']").val(hit);
                            var cek_data = $("#ed_tarif_penerus").val();
                            // var cek_data = cek_data.replace(/[A-Za-z$. ,-]/g, "");
                            if (crud_atas == 'E') {
                                $("input[name='ed_tarif_penerus']").val('{{ $do->tarif_penerus or null}}');
                                $(document).on("click","#btn_cari_harga",function(){
                                    $("input[name='ed_tarif_penerus']").val(biaya);

                                    })  
                            }else{
                                $("input[name='ed_tarif_penerus']").val(biaya);

                            }
                           
                            $("input[name='ed_tarif_penerus']").attr('width','100%');
                            $("#button_a").hide();
                            $("input[name='acc_penjualan']").val(acc_penjualan);
                            if (biaya == 0 || biaya == '0' || biaya == null || biaya == '') {
                                Command: toastr["warning"]("Zona/Penerus tidak ditemukan / Data Terduplicate ", "Peringatan !")
                                toastr.options = {
                                  "closeButton": false,
                                  "debug": true,
                                  "newestOnTop": false,
                                  "progressBar": true,
                                  "positionClass": "toast-top-right",
                                  "preventDuplicates": false,
                                  "onclick": null,
                                  "showDuration": "300",
                                  "hideDuration": "1000",
                                  "timeOut": "5000",
                                  "extendedTimeOut": "1000",
                                  "showEasing": "swing",
                                  "hideEasing": "linear",
                                  "showMethod": "fadeIn",
                                  "hideMethod": "fadeOut"
                                }
                                $("#button_a").show();

                                if (data.tipe == 'DOKUMEN') {
                                    $("input[name='ed_tarif_penerus']").css('width','220px');
                                    $("#button_a").html('<button class="btn btn-warning" type="button" style="margin-top: -50px;margin-left: 230px;" onclick="dokumen_tipe()"><i class="fa fa-plus"></i></button>')
                                }else if (data.tipe == 'KILOGRAM') {
                                    $("input[name='ed_tarif_penerus']").css('width','220px');
                                    $("#button_a").html('<button class="btn btn-info"type="button"  style="margin-top: -50px;margin-left: 230px;" onclick="kilogram_tipe()"><i class="fa fa-plus"></i></button>')
                                }else if (data.tipe == 'KOLI') {
                                    $("input[name='ed_tarif_penerus']").css('width','220px');
                                    $("#button_a").html('<button class="btn btn-primary" type="button" style="margin-top: -50px;margin-left: 230px;" onclick="koli_tipe()" ><i class="fa fa-plus"></i></button>')
                                }else if (data.tipe == 'SEPEDA') {
                                    $("input[name='ed_tarif_penerus']").css('width','220px');
                                    $("#button_a").html('<button class="btn btn-danger" type="button" style="margin-top: -50px;margin-left: 230px;"  onclick="sepeda_tipe()"><i class="fa fa-plus"></i></button>')
                                }   
                            }
                            if (data.jumlah_data == 0){
                                alert('Tarif penerus tidak ditemukan');
                                $("input[name='ed_tarif_penerus']").css('width','220px');
                                $("#button_a").show();

                                if (data.tipe == 'DOKUMEN') {
                                    $("#button_a").html('<button class="btn btn-warning" type="button" style="margin-top: -50px;margin-left: 230px;" onclick="dokumen_tipe()"><i class="fa fa-plus"></i></button>')
                                }else if (data.tipe == 'KILOGRAM') {
                                    $("input[name='ed_tarif_penerus']").css('width','220px');
                                    $("#button_a").html('<button class="btn btn-info"type="button"  style="margin-top: -50px;margin-left: 230px;" onclick="kilogram_tipe()"><i class="fa fa-plus"></i></button>')
                                }else if (data.tipe == 'KOLI') {
                                    $("input[name='ed_tarif_penerus']").css('width','220px');
                                    $("#button_a").html('<button class="btn btn-primary" type="button" style="margin-top: -50px;margin-left: 230px;" onclick="koli_tipe()"><i class="fa fa-plus"></i></button>')
                                }else if (data.tipe == 'SEPEDA') {
                                    $("input[name='ed_tarif_penerus']").css('width','220px');
                                    $("#button_a").html('<button class="btn btn-danger" type="button" style="margin-top: -50px;margin-left: 230px;" onclick="sepeda_tipe()"><i class="fa fa-plus"></i></button>')
                                } 
                            }
                            var dasar = $('input[name="ed_tarif_dasar"]').val();
                            dasar = dasar.replace(/[A-Za-z$. ,-]/g, "");
                            var penerus = $("input[name='ed_tarif_penerus']").val();
                            penerus = penerus.replace(/[A-Za-z$. ,-]/g, "");
                            var hasil = parseInt(dasar)+parseInt(penerus);
                            maxvalue = hasil*maxdiskon/100;
                            hitung();
                        } else if (data.create_indent == 2) {
                            var harga = convertToRupiah(parseInt(data.harga));
                            var biaya = convertToRupiah(parseInt(data.biaya_penerus));
                            var acc_penjualan = data.acc_penjualan;
                            $("input[name='ed_tarif_dasar']").val(harga);
                            $("input[name='ed_tarif_penerus']").val(biaya);
                            $("input[name='ed_tarif_penerus']").css('width','220px');
                            $("#button_a").show();


                            if (data.tipe == 'DOKUMEN') {
                                $("input[name='ed_tarif_penerus']").css('width','220px');
                                $("#button_a").html('<button class="btn btn-warning" type="button" style="margin-top: -50px;margin-left: 230px;" onclick="dokumen_tipe()"><i class="fa fa-plus"></i></button>')
                            }else if (data.tipe == 'KILOGRAM') {
                                $("input[name='ed_tarif_penerus']").css('width','220px');
                                $("#button_a").html('<button class="btn btn-info"type="button"  style="margin-top: -50px;margin-left: 230px;" onclick="kilogram_tipe()"><i class="fa fa-plus"></i></button>')
                            }else if (data.tipe == 'KOLI') {
                                $("input[name='ed_tarif_penerus']").css('width','220px');
                                $("#button_a").html('<button class="btn btn-primary" type="button" style="margin-top: -50px;margin-left: 230px;" onclick="koli_tipe()"><i class="fa fa-plus"></i></button>')
                            }else if (data.tipe == 'SEPEDA') {
                                $("input[name='ed_tarif_penerus']").css('width','220px');
                                $("#button_a").html('<button class="btn btn-danger" type="button" style="margin-top: -50px;margin-left: 230px;" onclick="sepeda_tipe()"i class="fa fa-plus"></i></button>')
                            }   


                            
                            $("input[name='acc_penjualan']").val(acc_penjualan);
                            if (biaya == 0 || biaya == '0' || biaya == null || biaya == '') {
                                Command: toastr["warning"]("Zona/Penerus tidak ditemukan, periksa tujuan anda", "Peringatan !")
                                toastr.options = {
                                  "closeButton": false,
                                  "debug": true,
                                  "newestOnTop": false,
                                  "progressBar": true,
                                  "positionClass": "toast-top-right",
                                  "preventDuplicates": false,
                                  "onclick": null,
                                  "showDuration": "300",
                                  "hideDuration": "1000",
                                  "timeOut": "5000",
                                  "extendedTimeOut": "1000",
                                  "showEasing": "swing",
                                  "hideEasing": "linear",
                                  "showMethod": "fadeIn",
                                  "hideMethod": "fadeOut"
                                }
                            }
                            if (data.jumlah_data == 0){
                                alert('Tarif penerus tidak ditemukan');
                            }
                            var dasar = $('input[name="ed_tarif_dasar"]').val();
                            dasar = dasar.replace(/[A-Za-z$. ,-]/g, "");
                            var penerus = $("input[name='ed_tarif_penerus']").val();
                            penerus = penerus.replace(/[A-Za-z$. ,-]/g, "");
                            var hasil = parseInt(dasar)+parseInt(penerus);
                            maxvalue = hasil*maxdiskon/100;
                            hitung();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                       swal("Error!", textStatus, "error");
                    }
                });
        }
        
        
    });
    

    function Pilih_kontrak(a){
        var kcd_id = $(a).find('.kcd_id').val();
        var kcd_dt = $(a).find('.kcd_dt').val();
        // alert('a');
         $.ajax({
            data: {a:kcd_dt,b:kcd_id},
            url:baseUrl+'/sales/cari_replacekontrakcustomer',
            type:'get',
            success:function(data){
                console.log(data.data.biaya_penerus);
                 
                type_kiriman=data.data.kcd_type_tarif;

                

                $("#modal").modal("hide");
                $('select[name="cb_kota_asal"]').val(data.data.kcd_kota_asal).trigger('chosen:updated');
                $('select[name="cb_kota_tujuan"]').val(data.data.kcd_kota_tujuan).trigger('chosen:updated');
                $('select[name="type_kiriman"]').val(data.data.kcd_type_tarif);
                $('input[name="ed_kota"]').val(data.data.asal);
                $('input[name="kontrak_tr"]').val('t');
                $('input[name="kontrak_cus"]').val(data.data.kcd_id);
                $('input[name="kontrak_cus_dt"]').val(data.data.kcd_dt);



                $('input[name="ed_tarif_dasar"]').val(accounting.formatMoney(data.data.kcd_harga,"",0,'.',','));

                if(data.data.tarif == 'REGULER' || data.data.tarif == 'EXPRESS'){
                    $('select[name="jenis_kiriman"]').val(data.data.tarif);
                }else{
                    Command: toastr["warning"]("Tipe tarif tidak sesuai dengan ketentuan", "Peringatan !")
                    toastr.options = {
                      "closeButton": false,
                      "debug": true,
                      "newestOnTop": false,
                      "progressBar": true,
                      "positionClass": "toast-top-right",
                      "preventDuplicates": true,
                      "onclick": null,
                      "showDuration": "300",
                      "hideDuration": "1000",
                      "timeOut": "5000",
                      "extendedTimeOut": "1000",
                      "showEasing": "swing",
                      "hideEasing": "linear",
                      "showMethod": "fadeIn",
                      "hideMethod": "fadeOut"
                    }
                }
                    

                    if ( type_kiriman =='DOKUMEN') {
                        $("#surat_jalan").hide();
                        $("#dimensi").hide();
                        $("#nopol").hide();
                        $("#koli").hide();
                        $("#berat").hide();
                        $("#jenis_kendaraan").hide();
                        $("#jml_unit").hide();
                        $('#tr_jenis_kiriman').show();
                        $(".jenis_unit").hide();
                    }else if ( type_kiriman =='KILOGRAM') {
                        $("#surat_jalan").hide();
                        $("#dimensi").show();
                        $("#nopol").hide();
                        $("#koli").show();
                        $("#berat").show();
                        $("#jenis_kendaraan").hide();
                        $("#jml_unit").hide();
                        $('#tr_jenis_kiriman').show();
                        $(".jenis_unit").hide();
                    }else if ( type_kiriman =='KOLI') {
                        $("#surat_jalan").hide();
                        $("#dimensi").hide();
                        $("#nopol").hide();
                        $("#koli").show();
                        $("#berat").show();
                        $("#jenis_kendaraan").hide();
                        $("#jml_unit").hide();
                        $('#tr_jenis_kiriman').show();
                        $(".jenis_unit").hide();
                    }else if ( type_kiriman =='SEPEDA') {
                        $("#surat_jalan").hide();
                        $("#dimensi").hide();
                        $("#nopol").hide();
                        $("#koli").hide();
                        $("#berat").hide();
                        $("#jenis_kendaraan").hide();
                        $("#jml_unit").show();
                        $(".jenis_unit").show();
                        $("#tr_jenis_kiriman").hide();
                    }
                    $('#hidden_button').show();
                hitung();  
                getKecamatan();

            }
        });
    } 

    function dokumen_tipe(){
        $.ajax({
            url:baseUrl+'/sales/cari_modaldeliveryorder',
            type:'get',
            success:function(data){
                $('#taruh_sini').html(data);
                $("#modal").modal("show");


                $('#provinsi').change(function(){
                    var prov = $('#provinsi').find(':selected').val();
                     $.ajax({
                        type: "GET",
                        data : {kota:prov},
                        url : baseUrl + "/sales/tarif_penerus_dokumen/get_kota",
                        dataType:'json',
                        success: function(data)
                        {   
                            console.log(data);
                             var kotakota = '<option value="" selected="" disabled="">-- Pilih Kota --</option>';

                             $.each(data, function(i,n){
                                kotakota = kotakota + '<option value="'+n.id+'" data-kota="'+n.kode_kota+'">'+n.nama+'</option>';
                             })
                            $('#kota_penerus').addClass('form-control'); 
                            $('#kota_penerus').attr('readonly',false); 
                            $('#kota_penerus').html(kotakota); 
                            $('#kota_penerus').change(function(){
                                var kode_kota = $(this).find(':selected').data('kota');
                                $('input[name="kode_kota"]').val(kode_kota);
                            })
                            $('#kecamatan_penerus').html('<option value="" selected="" disabled=""></option>'); 
                        }
                    });
                });


                $('#kota_penerus').change(function(){
                    var kot = $(this).find(':selected').val();
                     $.ajax({
                        type: "GET",
                        data : {kecamatan:kot},
                        url : baseUrl + "/sales/tarif_penerus_dokumen/get_kec",
                        dataType:'json',
                        success: function(data)
                        {   
                            console.log(data);
                             var kecamatan = '<option value="" selected="" disabled="">-- Pilih Kecamatan --</option>';

                             $.each(data, function(i,n){
                                kecamatan = kecamatan + '<option value="'+n.id+'">'+n.nama+'</option>';
                             })
                            $('#kecamatan_penerus').addClass('form-control'); 
                            $('#kecamatan_penerus').html(kecamatan); 
                            $('#kecamatan_penerus').attr('readonly',false); 

                        }
                    })
                });





            },
        })
    }
    function kilogram_tipe(){
        $.ajax({
            url:baseUrl+'/sales/cari_modaldeliveryorder_kilogram',
            type:'get',
            success:function(data){
                $('#taruh_sini').html(data);
                $("#modal").modal("show");

                $('#penerus_provinsikilo').change(function(){
                    var prov = $('#penerus_provinsikilo').find(':selected').val();
                     $.ajax({
                        type: "GET",
                        data : {kota:prov},
                        url : baseUrl + "/sales/tarif_penerus_dokumen/get_kota",
                        dataType:'json',
                        success: function(data)
                        {   
                            console.log(data);
                             var kotakota = '<option value="" selected="" disabled="">-- Pilih Kota --</option>';

                             $.each(data, function(i,n){
                                kotakota = kotakota + '<option value="'+n.id+'" data-kota="'+n.kode_kota+'">'+n.nama+'</option>';
                             })
                            $('#penerus_kotakilo').addClass('form-control'); 
                            $('#penerus_kotakilo').attr('readonly',false); 
                            $('#penerus_kotakilo').html(kotakota); 
                            $('#penerus_kotakilo').change(function(){
                                var kode_kota = $(this).find(':selected').data('kota');
                                $('#penerus_kodekotakilo').val(kode_kota);
                            })
                            $('#penerus_kecamatankilo').html('<option value="" selected="" disabled=""></option>'); 
                        }
                    });
                });


                $('#penerus_kotakilo').change(function(){
                    var kot = $(this).find(':selected').val();
                     $.ajax({
                        type: "GET",
                        data : {kecamatan:kot},
                        url : baseUrl + "/sales/tarif_penerus_dokumen/get_kec",
                        dataType:'json',
                        success: function(data)
                        {   
                            console.log(data);
                             var kecamatan = '<option value="" selected="" disabled="">-- Pilih Kecamatan --</option>';

                             $.each(data, function(i,n){
                                kecamatan = kecamatan + '<option value="'+n.id+'">'+n.nama+'</option>';
                             })
                            $('#penerus_kecamatankilo').addClass('form-control'); 
                            $('#penerus_kecamatankilo').html(kecamatan); 
                            $('#penerus_kecamatankilo').attr('readonly',false); 

                        }
                    })
                });





            },
        })
    }

    function koli_tipe(){
        $.ajax({
            url:baseUrl+'/sales/cari_modaldeliveryorder_koli',
            type:'get',
            success:function(data){
                $('#taruh_sini').html(data);
                $("#modal").modal("show");

                $('#penerus_provinsikoli').change(function(){
                    var prov = $('#penerus_provinsikoli').find(':selected').val();
                     $.ajax({
                        type: "GET",
                        data : {kota:prov},
                        url : baseUrl + "/sales/tarif_penerus_dokumen/get_kota",
                        dataType:'json',
                        success: function(data)
                        {   
                            console.log(data);
                             var kotakota = '<option value="" selected="" disabled="">-- Pilih Kota --</option>';

                             $.each(data, function(i,n){
                                kotakota = kotakota + '<option value="'+n.id+'" data-kota="'+n.kode_kota+'">'+n.nama+'</option>';
                             })
                            $('#penerus_kotakoli').addClass('form-control'); 
                            $('#penerus_kotakoli').attr('readonly',false); 
                            $('#penerus_kotakoli').html(kotakota); 
                            $('#penerus_kotakoli').change(function(){
                                var kode_kota = $(this).find(':selected').data('kota');
                                $('#penerus_kodekotakoli').val(kode_kota);
                            })
                            $('#penerus_kecamatankoli').html('<option value="" selected="" disabled=""></option>'); 
                        }
                    });
                });


                $('#penerus_kotakoli').change(function(){
                    var kot = $(this).find(':selected').val();
                     $.ajax({
                        type: "GET",
                        data : {kecamatan:kot},
                        url : baseUrl + "/sales/tarif_penerus_dokumen/get_kec",
                        dataType:'json',
                        success: function(data)
                        {   
                            console.log(data);
                             var kecamatan = '<option value="" selected="" disabled="">-- Pilih Kecamatan --</option>';

                             $.each(data, function(i,n){
                                kecamatan = kecamatan + '<option value="'+n.id+'">'+n.nama+'</option>';
                             })
                            $('#penerus_kecamatankoli').addClass('form-control'); 
                            $('#penerus_kecamatankoli').html(kecamatan); 
                            $('#penerus_kecamatankoli').attr('readonly',false); 

                        }
                    })
                });
            },
        })
    }

     function sepeda_tipe(){
        $.ajax({
            url:baseUrl+'/sales/cari_modaldeliveryorder_sepeda',
            type:'get',
            success:function(data){
                $('#taruh_sini').html(data);
                $("#modal").modal("show");
                $('#penerus_provinsisepeda').change(function(){
                    var prov = $('#penerus_provinsisepeda').find(':selected').val();
                     $.ajax({
                        type: "GET",
                        data : {kota:prov},
                        url : baseUrl + "/sales/tarif_penerus_dokumen/get_kota",
                        dataType:'json',
                        success: function(data)
                        {   
                            console.log(data);
                             var kotakota = '<option value="" selected="" disabled="">-- Pilih Kota --</option>';

                             $.each(data, function(i,n){
                                kotakota = kotakota + '<option value="'+n.id+'" data-kota="'+n.kode_kota+'">'+n.nama+'</option>';
                             })
                            $('#penerus_kotasepeda').addClass('form-control'); 
                            $('#penerus_kotasepeda').attr('readonly',false); 
                            $('#penerus_kotasepeda').html(kotakota); 
                            $('#penerus_kotasepeda').change(function(){
                                var kode_kota = $(this).find(':selected').data('kota');
                                // alert(kode_kota);
                                $('#penerus_kodekotasepeda').val(kode_kota);
                            })
                            $('#penerus_kecamatansepeda').html('<option value="" selected="" disabled=""></option>'); 
                        }
                    });
                });

                $('#penerus_kotasepeda').change(function(){
                    var kot = $(this).find(':selected').val();
                     $.ajax({
                        type: "GET",
                        data : {kecamatan:kot},
                        url : baseUrl + "/sales/tarif_penerus_dokumen/get_kec",
                        dataType:'json',
                        success: function(data)
                        {   
                            console.log(data);
                             var kecamatan = '<option value="" selected="" disabled="">-- Pilih Kecamatan --</option>';

                             $.each(data, function(i,n){
                                kecamatan = kecamatan + '<option value="'+n.id+'">'+n.nama+'</option>';
                             })
                            $('#penerus_kecamatansepeda').addClass('form-control'); 
                            $('#penerus_kecamatansepeda').html(kecamatan); 
                            $('#penerus_kecamatansepeda').attr('readonly',false); 

                        }
                    })
                });
            },
        })
    }


    function save_penerus(){
        var penerus_tipe = $('select[name="ed_tipe"]').val();
        var penerus_prov = $('select[name="ed_provinsi"]').val();
        var penerus_kota = $('select[name="ed_kota"]').val();
        var penerus_kec = $('select[name="ed_kecamatan"]').val();
        var penerus_reg = $('select[name="ed_reguler"]').val();
        var penerus_ex = $('select[name="ed_express"]').val();
        var penerus_kode_kota = $('input[name="kode_kota"]').val();
        var h = $('select[name="ed_reguler"]').data('penerus_reg');
        var i = $('select[name="ed_express"]').data('penerus_ex');
        var j = $('select[name="jenis_kiriman"]').find(':selected').val();
        var find_kecamatan = $('#kecamatan').find(":selected").val();

        $.ajax(
        {
            url : baseUrl + "/sales/tarif_penerus_dokumen_indentdo/save_data",
            type: "get",
            dataType:"JSON",
            data : {a:penerus_tipe,b:penerus_prov,c:penerus_kota,d:penerus_kec,e:penerus_reg,f:penerus_ex,g:penerus_kode_kota,h:h,i:i,j:j},
            success: function(data, textStatus, jqXHR)
            {
               
                        $("#modal").modal('hide');
                        $('.button_a').hide();
                        // alert('data berhasil di simpan');
                        var replace_data = $('input[name="ed_tarif_penerus"]').val();
                        console.log(data);
                        $('#kecamatan').val(data.error[0].id_kecamatan);
                        alert('Untuk perubahaan Silahkan Tekan Tombol "Search" sekali lagi');
                        $("input[name='ed_tarif_penerus']").css('width','290px');
                        // $('#kecamatan').val(data.error[0].id_kecamatan);

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Terjadi Kesalahan!", 'Error !!', "warning");
            }
        });
    }



    function save_penerus_kilogram(){
        var penerus_tipe = $('select[name="ed_tipe"]').val();
        var penerus_prov = $('select[name="ed_provinsi"]').val();
        var penerus_kota = $('select[name="ed_kota"]').val();
        var penerus_kec = $('select[name="ed_kecamatan"]').val();

        var h = $('select[name="ed_10reguler"]').find(':selected').val();
        var i = $('select[name="ed_20reguler"]').find(':selected').val();
        var j = $('select[name="ed_10express"]').find(':selected').val();
        var k = $('select[name="ed_20express"]').find(':selected').val();

        var l = $('select[name="ed_reguler"]').data('penerus_reg');
        var m = $('select[name="ed_express"]').data('penerus_ex');
        var n = $('select[name="jenis_kiriman"]').find(':selected').val();

        var penerus_kode_kota = $('input[name="kode_kota"]').val();

        var find_kecamatan = $('#kecamatan').find(":selected").val();

        $.ajax(
        {
            url : baseUrl + "/sales/tarif_penerus_kilogram_indentdo/save_data",
            type: "get",
            dataType:"JSON",
            data : {a:penerus_tipe,b:penerus_prov,c:penerus_kota,d:penerus_kec,h:h,i:i,j:j,k:k,l:l,m:m,n:n,p:penerus_kode_kota},
            success: function(data, textStatus, jqXHR)
            {
                        $("#modal").modal('hide');
                        $('.button_a').hide();
                        // alert('data berhasil di simpan');
                        var replace_data = $('input[name="ed_tarif_penerus"]').val();
                        console.log(data);
                        alert('Untuk perubahaan Silahkan Tekan Tombol "Search" sekali lagi');
                        $("input[name='ed_tarif_penerus']").css('width','290px');
                        // $('#kecamatan').val(data.error[0].id_kecamatan);

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Terjadi Kesalahan!", 'Error !!', "warning");
            }
        });
    }

    function save_penerus_koli(){
        var j = $('select[name="jenis_kiriman"]').find(':selected').val();
        

        $.ajax(
        {
            url : baseUrl + "/sales/tarif_penerus_koli_indentdo/save_data",
            type: "get",
            dataType:"JSON",
            data : $('#form_peneruskoli').serialize()+'&j='+j ,
            success: function(data, textStatus, jqXHR)
            {
                        $("#modal").modal('hide');
                        $('.button_a').hide();
                        // alert('data berhasil di simpan');
                        var replace_data = $('input[name="ed_tarif_penerus"]').val();
                        console.log(data);
                        alert('Untuk perubahaan Silahkan Tekan Tombol "Search" sekali lagi');
                        $("input[name='ed_tarif_penerus']").css('width','290px');
                        // $('#kecamatan').val(data.error[0].id_kecamatan);

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Terjadi Kesalahan!", 'Error !!', "warning");
            }
        });
    }

     function save_penerus_sepeda(){
        

        $.ajax(
        {
            url : baseUrl + "/sales/tarif_penerus_sepeda_indentdo/save_data",
            type: "get",
            dataType:"JSON",
            data : $('#form_header').serialize(),
            success: function(data, textStatus, jqXHR)
            {
                        $("#modal").modal('hide');
                        $('.button_a').hide();
                        // alert('data berhasil di simpan');
                        var replace_data = $('input[name="ed_tarif_penerus"]').val();
                        console.log(data);
                        alert('Untuk perubahaan Silahkan Tekan Tombol "Search" sekali lagi');
                        $("input[name='ed_tarif_penerus']").css('width','290px');
                        // $('#kecamatan').val(data.error[0].id_kecamatan);

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Terjadi Kesalahan!", 'Error !!', "warning");
            }
        });
    }


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
        var namapenerima = $(".namapenerima").val();
        var alamarpenerima = $(".alamarpenerima").val();
        var kodepospenerima = $(".kodepospenerima").val();
        var teleponpenerima = $(".teleponpenerima").val();

        var customerpengirim = $(".customerpengirim").val();
        var marketingpengirim = $(".marketingpengirim").val();
        var namapengirim = $(".namapengirim").val();
        var alamartpengirim = $(".alamatpengirim").val();
        var kodepospengirim = $(".kodepospengirim").val();
        var teleponpengirim = $(".teleponpengirim").val();

        if (kota_asal == '') {
            Command: toastr["warning"]("Kota Asal harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (kota_tujuan == '') {
          Command: toastr["warning"]("Kota Tujuan harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (pendapatan == '') {
           Command: toastr["warning"]("Pendapatan harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (type_kiriman == '') {
             Command: toastr["warning"]("Tipe Kiriman harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (jenis_kiriman == '') {
           Command: toastr["warning"]("Jenis Kiriman harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (customerpengirim == '') {
            Command: toastr["warning"]("Cutomer Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (marketingpengirim == '') {
            Command: toastr["warning"]("Marketing Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (namapengirim == '') {
            Command: toastr["warning"]("Nama Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (alamatpengirim == '') {
            Command: toastr["warning"]("Alamat Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (kodepospengirim == '') {
            Command: toastr["warning"]("KodePos Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (teleponpengirim == '') {
            Command: toastr["warning"]("Nomor Telepon Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (marketingpengirim == '') {
            Command: toastr["warning"]("Marketing Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (namapenerima == '') {
            Command: toastr["warning"]("Nama Penerima harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
                        return false;
        }else if (alamarpenerima == '') {
           Command: toastr["warning"]("Alamat Penerima harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
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
            type: "get",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {

                 if(data.ada == 1){
                    toastr.error('Data Telah Digunakan !','Peringatan !');
                    return false;
                }

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
        var namapenerima = $(".namapenerima").val();
        var alamarpenerima = $(".alamarpenerima").val();
        var kodepospenerima = $(".kodepospenerima").val();
        var teleponpenerima = $(".teleponpenerima").val();

        var customerpengirim = $(".customerpengirim").val();
        var marketingpengirim = $(".marketingpengirim").val();
        var namapengirim = $(".namapengirim").val();
        var alamatpengirim = $(".alamatpengirim").val();
        var kodepospengirim = $(".kodepospengirim").val();
        var teleponpengirim = $(".teleponpengirim").val();
        var ed_total_total = $(".ed_total_total").val();

        if (kota_asal == '') {
            Command: toastr["warning"]("Kota Asal harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (kota_tujuan == '') {
          Command: toastr["warning"]("Kota Tujuan harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (pendapatan == '') {
           Command: toastr["warning"]("Pendapatan harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (type_kiriman == '') {
             Command: toastr["warning"]("Tipe Kiriman harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (jenis_kiriman == '') {
           Command: toastr["warning"]("Jenis Kiriman harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (customerpengirim == '') {
            Command: toastr["warning"]("Cutomer Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (marketingpengirim == '') {
            Command: toastr["warning"]("Marketing Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (namapengirim == '') {
            Command: toastr["warning"]("Nama Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (alamatpengirim == '') {
            Command: toastr["warning"]("Alamat Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (kodepospengirim == '') {
            Command: toastr["warning"]("KodePos Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (teleponpengirim == '') {
            Command: toastr["warning"]("Nomor Telepon Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (marketingpengirim == '') {
            Command: toastr["warning"]("Marketing Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (namapenerima == '' || namapenerima == null) {
            Command: toastr["warning"]("Nama Penerima harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
                        return false;
        }else if (alamarpenerima == '') {
           Command: toastr["warning"]("Alamat Penerima harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        } else if (teleponpenerima == '') {
           Command: toastr["warning"]("No Telepon Penerima harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }
        
        $.ajax(
        {
            url :  baseUrl + "/sales/deliveryorderform/save_data",
            type: "GET",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                 if(data.ada == 1){
                    toastr.error('Data Telah Digunakan !','Peringatan !');
                    return false;
                }
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
        var namapenerima = $(".namapenerima").val();
        var alamarpenerima = $(".alamarpenerima").val();
        var kodepospenerima = $(".kodepospenerima").val();
        var teleponpenerima = $(".teleponpenerima").val();

        var customerpengirim = $(".customerpengirim").val();
        var marketingpengirim = $(".marketingpengirim").val();
        var namapengirim = $(".namapengirim").val();
        var alamatpengirim = $(".alamatpengirim").val();
        var kodepospengirim = $(".kodepospengirim").val();
        var teleponpengirim = $(".teleponpengirim").val();
        var ed_total_total = $(".ed_total_total").val();

        if (kota_asal == '') {
            Command: toastr["warning"]("Kota Asal harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (kota_tujuan == '') {
          Command: toastr["warning"]("Kota Tujuan harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (pendapatan == '') {
           Command: toastr["warning"]("Pendapatan harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (type_kiriman == '') {
             Command: toastr["warning"]("Tipe Kiriman harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (jenis_kiriman == '') {
           Command: toastr["warning"]("Jenis Kiriman harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (customerpengirim == '') {
            Command: toastr["warning"]("Cutomer Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (marketingpengirim == '') {
            Command: toastr["warning"]("Marketing Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (namapengirim == '') {
            Command: toastr["warning"]("Nama Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (alamatpengirim == '') {
            Command: toastr["warning"]("Alamat Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (kodepospengirim == '') {
            Command: toastr["warning"]("KodePos Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (teleponpengirim == '') {
            Command: toastr["warning"]("Nomor Telepon Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (marketingpengirim == '') {
            Command: toastr["warning"]("Marketing Pengirim harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }else if (namapenerima == '' || namapenerima == null) {
            Command: toastr["warning"]("Nama Penerima harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
                        return false;
        }else if (alamarpenerima == '') {
           Command: toastr["warning"]("Alamat Penerima harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        } else if (teleponpenerima == '') {
           Command: toastr["warning"]("No Telepon Penerima harus diisi", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
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
                if(data.ada == 1){
                    toastr.error('Data Telah Digunakan !','Peringatan !');
                    return false;
                }
                if(data.crud == 'N'){
                    if(data.result != 1){
                        alert("Gagal menyimpan data!");
                    }else{

                           Command: toastr["success"]("Data Telah Tersimpan", "Pemberitahuan !")

                            toastr.options = {
                              "closeButton": false,
                              "debug": true,
                              "newestOnTop": false,
                              "progressBar": true,
                              "positionClass": "toast-top-right",
                              "preventDuplicates": false,
                              "onclick": null,
                              "showDuration": "300",
                              "hideDuration": "1000",
                              "timeOut": "5000",
                              "extendedTimeOut": "1000",
                              "showEasing": "swing",
                              "hideEasing": "linear",
                              "showMethod": "fadeIn",
                              "hideMethod": "fadeOut"
                            }
                            return false;
                            $('input[name="btnsimpan"]').prop('disabled','true');
                            $('input[name="btnsimpan_tambah"]').prop('disabled','true');

                        
                        // window.location.href = baseUrl + '/sales/deliveryorderform'
                    }
                }else if(data.crud == 'E'){
                    if(data.result != 1){
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }else{
                        Command: toastr["success"]("Data Telah Tersimpan", "Pemberitahuan !")

                            toastr.options = {
                              "closeButton": false,
                              "debug": true,
                              "newestOnTop": false,
                              "progressBar": true,
                              "positionClass": "toast-top-right",
                              "preventDuplicates": false,
                              "onclick": null,
                              "showDuration": "300",
                              "hideDuration": "1000",
                              "timeOut": "5000",
                              "extendedTimeOut": "1000",
                              "showEasing": "swing",
                              "hideEasing": "linear",
                              "showMethod": "fadeIn",
                              "hideMethod": "fadeOut"
                            }
                            return false;
                            $('input[name="btnsimpan"]').prop('disabled','true');
                            $('input[name="btnsimpan_tambah"]').prop('disabled','true');
                            $("form").each(function(){
                                $(this).find(':input') //<-- Should return all input elements in that specific form.
                            });
                    }
                }else{
                    if(data.ada == 1){
                    toastr.error('Data Telah Digunakan !','Peringatan !');
                        return false;
                    }

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

    $("input[name='ed_diskon_h']").blur(function(){
        if ($("input[name='ed_diskon_h']").val() == '') {
            $("input[name='ed_diskon_h']").val(0);
            hitung();
        }
    });
    
    $("input[name='ed_biaya_tambahan'],input[name='ed_diskon_h'],input[name='ed_biaya_komisi']").keyup(function(){
        if ($("input[name='ed_diskon_h']").val() > 100 || $("input[name='ed_diskon_h']").val() > maxdiskon) {
            Command: toastr["warning"]("Tidak boleh memasukkan diskon melebihi ketentuan", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": true,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            $("input[name='ed_diskon_h']").val(0);
        }
        hitung();
    });
    
    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    $('.date-do').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    function lihatjurnal(){
        $('#jurnal').modal('show');
    }

    // call

  //called when key is pressed in textbox
  // $("#ed_diskon_h").keypress(function (e) {
  //    //if the letter is not digit then display error and don't type anything
  //    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
  //       //display error message
  //       $("#errmsg").html("Hanya angka yang diperbolehkan").show().fadeOut(1500);
  //       $("#errmsg").css('color','red');
  //              return false;
  //   }
  //  });
  $(".hanyaangka").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0  && (e.which < 48 || e.which > 57)) {
        //display error message
        
               return false;
    }
   });

  $(".hanyaangkadiskon").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
        //display error message
        
               return false;
    }
   });


   $("#ed_nomor").keypress(function (e) {
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122)) {
            return false;
    }
   });


   

   function convertToRupiah(angka) {
        var rupiah = '';        
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        var hasil = rupiah.split('',rupiah.length-1).reverse().join('');
        return hasil;
    
    }

    function convertToAngka(rupiah)
    {
        return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
    }

    function setJmlPPN(){

    }

    function getKecamatan(){
        var kota = $('#kota').val();
        $.ajax({
            type: "GET",
            data : {kecamatan:kota},
            url : baseUrl + "/sales/tarif_penerus_kilogram/get_kec",
            dataType:'json',
            success: function(data)
            {   
                var kecamatan = '<option value="" selected="" disabled="">-- Pilih Kecamatan --</option>';

                $.each(data, function(i,n){
                    kecamatan = kecamatan + '<option value="'+n.id+'" data-nama="'+n.nama+'">'+n.nama+'</option>';
                });

                $('#kecamatan').addClass('form-control chosen-select-width');
                $('#kecamatan').html(kecamatan);
            }
        })
    }

    function setJml(){
        var jumlah = $('.jmlunit').val();
        $('.jenis_unit').remove();
        var jenis = '<tr id="jenis_unit" class="jenis_unit"><td style="padding-top: 0.4cm">Jenis Unit</td><td colspan="2" class="jenisunit"><select class="form-control jns_unit" name="cb_jenis_unit[]" ><option value="SEPEDA">SEPEDA</option><option value="SPORT">MOTOR SPORT</option><option value="BETIC">MOTOR BEBEK/MATIC</option><option value="MOGE">MOGE</option></select></td><td style="padding-top: 0.4cm">Berat Unit</td><td colspan="2"><input type="text" class="form-control beratunit" name="cb_berat_unit[]" style="text-align:right" ></td></tr>';
        for (var i = 0; i < jumlah; i++) {
            $(jenis).insertAfter('#jml_unit');
        }

    }
            $('#type_kiriman').change(function(){
                var cek_tipe = $(this).val();
                if (cek_tipe == 'KILOGRAM') {
                    if(crud_atas == 'E'){
                        if($("input[name='ed_berat']").val() != '' || $("input[name='ed_koli']").val() != '' ){
                            $("input[name='ed_berat']").val({{ $do->berat or null}} );
                            $("input[name='ed_koli']").val({{ $do->koli or null}});
                            
                        }else{
                            $("input[name='ed_berat']").val(0);
                            $("input[name='ed_koli']").val(0);
                        }
                    }else{
                        var berat = $("input[name='ed_berat']").val(0);
                        var berat = $("input[name='ed_koli']").val(0);
                    }  
                }else{
                        var berat = $("input[name='ed_berat']").val(0);
                        var berat = $("input[name='ed_koli']").val(0);
                }
            })
                function BeratDefault(){
                    var tipetipe = $('#type_kiriman').val();
                    if (tipetipe == 'KOLI') {
                        // alert('a');
                        var berat = $("input[name='ed_berat']").val();

                        if (berat > 50) {
                            Command: toastr["warning"]("Maksimal berat KOLI yang dilayani 50 Kg", "Peringatan !")

                            toastr.options = {
                              "closeButton": false,
                              "debug": true,
                              "newestOnTop": false,
                              "progressBar": true,
                              "positionClass": "toast-top-right",
                              "preventDuplicates": true,
                              "onclick": null,
                              "showDuration": "300",
                              "hideDuration": "1000",
                              "timeOut": "5000",
                              "extendedTimeOut": "1000",
                              "showEasing": "swing",
                              "hideEasing": "linear",
                              "showMethod": "fadeIn",
                              "hideMethod": "fadeOut"
                            }
                            $("input[name='ed_berat']").val(1);
                            return false;
                        }
                    }else{
                        // alert('b');
                    }
                    
                }

    function setMaxDisc(){
        var cabang = $("select[name='cb_cabang']").val();
        for (var i = 0; i < listCabang.length; i++) {
            if (listCabang[i] == cabang) {
                maxdiskon = listDiskon[i];
                i = listCabang.length + 1;
            }
        }
    }
    function dikonval(){
        var tarif_dasar = $("input[name='ed_tarif_dasar']").val();
        var biaya_penerus = $("input[name='ed_tarif_penerus']").val();
        var biaya_tambahan = $("input[name='ed_biaya_tambahan']").val();

        var diskon  = $("input[name='ed_diskon_h']").val();
        var diskon_value  = $("input[name='ed_diskon_v']").val();
        var diskon_val  = $("input[name='ed_diskon_h']").val();
        var biaya_komisi  = $("input[name='ed_biaya_komisi']").val();
        var tarif_dasar = tarif_dasar.replace(/[A-Za-z$. ,-]/g, "");
        var biaya_penerus = biaya_penerus.replace(/[A-Za-z$. ,-]/g, "");
        var biaya_tambahan = biaya_tambahan.replace(/[A-Za-z$. ,-]/g, "");
        var biaya_komisi = biaya_komisi.replace(/[A-Za-z$. ,-]/g, "");
        // var diskon = diskon.replace(/[A-Za-z$. ,-]/g, "");
        var jenis_ppn = $("select[name='cb_jenis_ppn']").val();
        if (diskon > 0 && biaya_tambahan > 0) {
            alert("Diskon dan biaya tambahan di isi salah satu");
            parseFloat($("input[name='ed_diskon_h']").val(0));
            $("input[name='ed_biaya_tambahan']").val(0);
            diskon = 0;
            biaya_tambahan = 0;
            $("input[name='ed_biaya_tambahan']").focus();
        }
        if ($("select[name='cb_outlet']").val() == '' ) {
            biaya_komisi = 0;
        }
        var total  = parseFloat(tarif_dasar) + parseFloat(biaya_penerus) + parseFloat(biaya_tambahan) + parseFloat(biaya_komisi);
        var total_total  = parseFloat(tarif_dasar) + parseFloat(biaya_penerus)+ parseFloat(biaya_tambahan) + parseFloat(biaya_komisi);
        //--
        //--
        var ppn  = 0;//parseFloat(total)/parseFloat(10)    ;
        if (jenis_ppn == 1) {
            ppn =parseFloat(total) * parseFloat(0.1);
            total = total + ppn;
        }else if (jenis_ppn == 2) {
            ppn =parseFloat(total) * parseFloat(0.01);
            total = total + ppn;
        }else if (jenis_ppn == 4) {
            ppn =0;
        }else if (jenis_ppn == 3) {
            ppn =parseFloat(total) / parseFloat(100.1);
            //total = total - ppn;
        }else if (jenis_ppn == 5) {
            ppn =parseFloat(total) / parseFloat(10.1);
            total = total - ppn;
        }

        var diskon_tot = parseFloat(diskon_value)/parseFloat(total_total)*100;
        
        $('#ed_diskon_h').val(Math.round(diskon_tot,2));
        if(diskon_value == 0){
            $('#ed_diskon_h').val(0);
        }
        // alert(maxvalue);
        // var max_dis = 
        var this_selected_value = $('#cb_cabang').find(':selected').data('diskon');
        // alert(this_selected_value);
        var tot = parseFloat(this_selected_value)*parseFloat(total_total)/100; 
        var diskon_value_utama = $("input[name='ed_diskon_v']").val();
        var total_h = total-diskon_value_utama;
        var dpp_h = total-diskon_value_utama;

        $("input[name='ed_jml_ppn']").val(accounting.formatMoney(ppn,"",0,'.',','));
        
        $("input[name='ed_total_h']").val(accounting.formatMoney(total_h,"",0,'.',','));
        
        $("input[name='ed_total_total']").val(accounting.formatMoney(total,"",0,'.',','));

        if ($('.vendor_tarif').is(':checked') == false) {
            
            $("input[name='ed_dpp']").val(accounting.formatMoney(dpp_h,"",0,'.',','));
        }else{
            $("input[name='ed_vendor']").prop('readonly',false);
            $("input[name='ed_vendor']").val(accounting.formatMoney(dpp_h,"",0,'.',','));
            
        } 

        if (diskon_value > tot) {
            
            Command: toastr["warning"]("Tidak boleh memasukkan diskon melebihi ketentuan", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": true,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            $('#ed_diskon_v').val(0);
            $('#ed_diskon_h').val(0);
            $("input[name='ed_total_h']").val(total_total);
        }

        if($('#ed_biaya_tambahan').val() != 0){
            Command: toastr["warning"]("Pilih salah Satu", "Peringatan !")

            toastr.options = {
              "closeButton": true,
              "debug": true,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": true,
              "onclick": null,
            }
            $('#ed_diskon_v').val(0);
            $('#ed_diskon_h').val(0);
            $('#ed_biaya_tambahan').val(0)
            $("input[name='ed_total_h']").val(total_total);
        }



        $("input[name='ed_jml_ppn']").val(Math.round(ppn));
        $("input[name='ed_total_h']").val(Math.round(total-diskon_value));
        // $("input[name='ed_total_h']").val(Math.round(total-diskon_value));
        
        $("input[name='ed_total_total']").val(Math.round(total_total));
        // hitung();   
    }
    function cetak(){
        $.ajax({
            data:$('#form_header').serialize(),
            type:'get',
            url: baseUrl + '/cetak_deliveryorderform/cetak_deliveryorderform',
            
            success:function(data){
                var win = window.open();
                win.document.write(data);
            }
        })
    }
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
    $('.replace_deskripsi').change(function(){
        var asal = $("select[name='cb_kota_asal']").find(':selected').data('nama');
        var tujuan = $("select[name='cb_kota_tujuan']").find(':selected').data('nama');
        var kecamatan = $("select[name='cb_kecamatan_tujuan']").find(':selected').data('nama');
        var nama_penerima = $("input[name='ed_nama_penerima']").val();
        console.log(asal);
        console.log(tujuan);
        console.log(kecamatan);
        var deskripsi_rep =  $("input[name='ed_deskripsi']").val(asal +' - '+ tujuan +' - '+ kecamatan +' - '+ nama_penerima);
    })
    // $( document ).ready(function() {
    //   if ($('input[name="kontrak_tarif"]').is(':checked') ==true) {
    //             alert('o');
    //         }else{
    //             alert('i');
    //     }
    // });
        
    
</script>
@endsection
