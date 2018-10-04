@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright 
    { 
        text-align: right; 
    }
    .table td,th,tr{
        border:none;
    }
    .pointer_none{
        pointer-events: none;
    }
    .
</style>
                

<div class="wrapper wrapper-content animatdo fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 style="margin-left : 5px"> DELIVERY ORDER
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        <input type="text" class="pull-right" style="border: none; text-align: right;" readonly="" name="crud_atas" id="crud_atas" 
                    </div>
                </div>
                <div class="ibox-content" >
                <div class="drop_here">
                    
                </div>
                <div class="btn-group">
                  <button type="button" class="btn btn-primary" onclick="jurnal_awal()">Jurnal Awal</button>

                  <button type="button" class="btn btn-primary" onclick="jurnal_balik()">Jurnal Balik</button>
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
                                        <table class="table dt-responsive nowrap table-hover">
                                            <tbody>
                                                <tr style="max-height: 15px !important; height: 15px !important; overflow:hidden;">
                                                    <td style="width:110px; padding-top: 0.4cm">Nomor</td>
                                                    <td colspan="5">
                                                        <input type="text" class="form-control" id="do_nomor" name="do_nomor" style="text-transform: uppercase"  value="{{ $data->nomor }}" readonly="" >
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Tanggal</td>
                                                    <td colspan="1">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control " name="do_tanggal" id="" readonly="" value="{{ $data->tanggal }}">
                                                        </div>
                                                    </td>

                                                    <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                                    <td colspan="3">
                                                        <select class="form-control"  name="do_cabang" {{-- onclick="setMaxDisc()" --}} style="width:100%;pointer-events: none" id="do_cabang">
                                                            <option value="" >- Pilih -</option>

                                                        @foreach ($cabang as $row)
                                                            @if ($row->kode == $data->kode_cabang)
                                                                @if($row->diskon != null)
                                                                    <option selected="" value="{{ $row->kode }}" data-diskon="{{ $row->diskon }}">{{ $row->kode }} - {{ $row->nama }} -- (Diskon {{ $row->diskon }}%)</option>
                                                                @else
                                                                    <option selected="" value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }}</option>
                                                                @endif
                                                            @else
                                                                @if($row->diskon != null)
                                                                    <option value="{{ $row->kode }}" data-diskon="{{ $row->diskon }}">{{ $row->kode }} - {{ $row->nama }} -- (Diskon {{ $row->diskon }}%)</option>
                                                                @else
                                                                    <option value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }}</option>
                                                                @endif
                                                            @endif
                                                            
                                                        @endforeach
                                                        </select>
                                                    </td>


                                                </tr>
                                             
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Customer</td>
                                                    <td colspan="5">
                                                        <select class="chosen-select-width customerpengirim"  name="do_customer" onchange="" id="do_customer" style="width:100%" >
                                                        <option value="">- Pilih -</option>
                                                        @foreach ($customer as $row)
                                                        @if ($data->kode_customer == $row->kode)
                                                            @if ( $row->kc_aktif  == 'AKTIF' && $row->kcd_jenis)
                                                                <option selected="" style="background-color: #79fea5;" value="{{ $row->kode }}" data-alamat="{{$row->alamat}}" data-telpon="{{$row->telpon}}"  data-status="{{ $row->kc_aktif }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                                            @endif
                                                        @else
                                                             @if ( $row->kc_aktif  == 'AKTIF' && $row->kcd_jenis)
                                                                <option style="background-color: #79fea5;" value="{{ $row->kode }}" data-alamat="{{$row->alamat}}" data-telpon="{{$row->telpon}}"  data-status="{{ $row->kc_aktif }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                                            @endif
                                                        @endif
                                                        @endforeach

                                                        @foreach ($cus as $row1)
                                                        @if ($data->kode_customer == $row1->kode)
                                                                <option selected="" value="{{ $row1->kode }}" data-alamat="{{$row1->alamat}}" data-telpon="{{$row1->telpon}}"  >{{ $row1->kode }} - {{ $row1->nama }} </option>
                                                        @else
                                                                <option value="{{ $row1->kode }}" data-alamat="{{$row1->alamat}}" data-telpon="{{$row1->telpon}}"  >{{ $row1->kode }} - {{ $row1->nama }} </option>
                                                        @endif
                                                        @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Kota Asal</td>
                                                    <td colspan="5">
                                                        <select class="chosen-select-width replace_deskripsi" id="do_kota_asal" onchange="asal()" name="do_kota_asal" style="width:100%" >
                                                            <option value="">- Pilih -</option>
                                                            @foreach ($kota as $row)
                                                                @if ($row->id == $data->id_kota_asal)
                                                                    <option selected="" value="{{ $row->id }}" data-nama="{{ $row->nama }}">{{ $row->id }} - {{ $row->nama }} </option>
                                                                @else
                                                                    <option value="{{ $row->id }}" data-nama="{{ $row->nama }}">{{ $row->id }} - {{ $row->nama }} </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Kota Tujuan</td>
                                                    <td colspan="5">
                                                        <select class="chosen-select-width replace_deskripsi" id="do_kota_tujuan" onchange="getKecamatan()" id="do_kota_tujuan" name="do_kota_tujuan" style="width:100%" >
                                                            <option value="">- Pilih -</option>
                                                            @foreach ($kota as $row)
                                                                @if ($row->id == $data->id_kota_tujuan)
                                                                    <option selected="" value="{{ $row->id }}" data-nama="{{ $row->nama }}">{{ $row->id }} - {{ $row->nama }} </option>
                                                                @else
                                                                    <option value="{{ $row->id }}" data-nama="{{ $row->nama }}">{{ $row->id }} - {{ $row->nama }} </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm" class="kecamatantujuanlabel">Kecamatan Tujuan</td>
                                                    <td colspan="5">
                                                        <select class="chosen-select-width form-control" id="do_kecamatan_tujuan" name="do_kecamatan_tujuan" style="width:100%" >
                                                            <option value="">- Pilih -</option>
                                                             @foreach ($kecamatan as $row)
                                                                @if ($row->id == $data->id_kecamatan_tujuan )
                                                                    <option selected="" value="{{ $row->id }}" data-nama="{{ $row->nama }}">{{ $row->id }} - {{ $row->nama }} </option>
                                                                @else
                                                                    <option value="{{ $row->id }}" data-nama="{{ $row->nama }}">{{ $row->id }} - {{ $row->nama }} </option>
                                                                @endif
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
                                                        <select class="form-control"  name="type_kiriman" id="type_kiriman">

                                                            <option value="">- Pilih -</option>
                                                            <option value="DOKUMEN">DOKUMEN</option>
                                                            <option value="KILOGRAM">KILOGRAM</option>
                                                            <option value="KOLI">KOLI</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="tr_jenis_kiriman">
                                                    <td style="width:110px; padding-top: 0.4cm">Jenis Kiriman</td>
                                                    <td colspan="5">
                                                        <select class="form-control" name="jenis_kiriman" id="jenis_kiriman" >
                                                            <option value="">- Pilih -</option>
                                                            <option value="REGULER" selected="">REGULER</option>
                                                            <option value="EXPRESS">EXPRESS</option>
                                                            <option value="DARAT" selected="">DARAT (Khusus Vendor)</option>
                                                            <option value="LAUT">LAUT (Khusus Vendor)</option>
                                                            <option value="UDARA">UDARA (Khusus Vendor)</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                
                                                <tr id="jenis_kendaraan">
                                                    <td style="width:120px; padding-top: 0.4cm">Jenis Kendaraan</td>
                                                    <td colspan="5">
                                                        <select class="select2_single form-control"  name="do_angkutan" id="do_angkutan" style="width: 100% !important;">
                                                            <option value="">- Pilih -</option>
                                                            @foreach ($angkutan as $row)
                                                                <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="surat_jalan">
                                                    <td style="padding-top: 0.4cm">No Surat Jalan</td>
                                                    <td colspan="5">
                                                        <input type="text" class="form-control" name="do_surat_jalan" style="text-transform: uppercase" value="" >
                                                    </td>
                                                </tr>
                                                <tr id="nopol">
                                                    <td style="padding-top: 0.4cm">Nopol</td>
                                                    <td colspan="5">
                                                        <select class="chosen-select-width"  name="do_nopol" style="width:100%">
                                                            <option value="">- Pilih -</option>
                                                            @foreach ($kendaraan as $row)
                                                                <option value="{{ $row->nopol }}"> {{ $row->nopol }} </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="berat">
                                                    <td style="padding-top: 0.4cm">Berat</td>
                                                    <td colspan="5">
                                                        <input onkeyup="BeratDefault()" type="text" class="form-control" value="{{ $data->berat }}" name="do_berat" style="text-align:right">
                                                    </td>
                                                </tr>
                                                <tr id="jml_unit">
                                                    <td style="padding-top: 0.4cm">Jumlah Unit</td>
                                                    <td colspan="5">
                                                        <input type="text" class="form-control jmlunit" onkeyup="setJml()" value="{{ $data->berat }}" name="do_jml_unit" style="text-align:right" >
                                                    </td>
                                                </tr>
                                                <div id="drop"></div>
                                                <tr id="dimensi">
                                                    <td style="padding-top: 0.4cm">Panjang</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="do_panjang" value="{{ $data->panjang }}" style="text-align:right" >
                                                    </td>
                                                    <td style="padding-top: 0.4cm">Lebar</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="do_lebar" value="{{ $data->lebar }}" style="text-align:right">
                                                    </td>
                                                    <td style="padding-top: 0.4cm">Tinggi</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="do_tinggi" value="{{ $data->tinggi }}" style="text-align:right">
                                                    </td>
                                                </tr>
                                                
                                                <tr id="koli">
                                                    <td style="padding-top: 0.4cm">Koli</td>
                                                    <td colspan="5">
                                                        <input type="text" class="form-control" name="do_koli" value="{{ $data->koli }}" style="text-align:right">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    {{-- <td style="width:110px; padding-top: 0.4cm">Tarif Vendor</td>
                                                    <td colspan="2">
                                                        <select class="chosen-select-width pointer_none" name="do_vendor_pilih" style="width:100%" id="do_vendor_pilih">
                                                            <option value="">- Pilih -</option>
                                                        </select>
                                                    </td> --}}
                                                    <td style="width:110px; padding-top: 0.4cm">Tarif Vendor</td>
                                                    <td colspan="5">
                                                        <div>
                                                             <label class="radio-inline">
                                                              <input type="radio" class="cek_vendor_ya" name="cek_vendor">Ya
                                                            </label>
                                                            <label class="radio-inline">
                                                              <input type="radio" class="cek_vendor_tidak" name="cek_vendor">Tidak
                                                            </label>
                                                        </div>
                                                        <div>
                                                        @if ($data->tarif_vendor_bol == true)
                                                             <p>NB: data lama tarif vendor aktif / pilih sekali lagi sebelum save</p>
                                                        @else
                                                             <p>NB: data lama tarif vendor tidak aktif / pilih sekali lagi sebelum save</p>
                                                        @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">DO Outlet</td>
                                                    <td colspan="2">
                                                        <select class="chosen-select-width"  name="do_outlet" style="width:100%" id="do_outlet">
                                                            <option value="">- Pilih -</option>
                                                            <option value="NON OUTLET">NON OUTLET</option>
                                                            @foreach ($outlet as $row)
                                                                @if ($row->kode == $data->kode_outlet)
                                                                    <option selected="" value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                                @else 
                                                                    <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="width: 80px" class="disabldo" >
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
                                    

                                    {{-- HIDDEN --}}

                                    <!-- temporari data total-->
                                    <input type="hidden" name="do_total_temp" value="{{ $data->total_net }}">

                                    <input type="hidden" name="tarif_vendor_bol" id="tarif_vendor_bol" value="{{ $data->tarif_vendor_bol }}">

                                    <input type="hidden" name="id_tarif_vendor" id="id_tarif_vendor">
                                    <input type="hidden" name="nama_tarif_vendor" id="nama_tarif_vendor">

                                    <!-- PATOKAN BERAT DI KALI TARIF DASAR ,  -->
                                    <input type="hidden" name="tarif_dasar_patokan" id="tarif_dasar_patokan">

                                    <!-- Berat Minimum-->
                                    <input type="hidden" name="berat_minimum">

                                    <!-- Non Customer-->
                                    <input type="hidden" name="nama_customer_hidden">

                                    {{-- END OF HIDDEN --}}

                                    
                                    <div class="col-md-5">
                                        <table class="table dt-responsive nowrap table-hover">
                                            <tbody>
                                                <tr style="max-height: 15px !important; height: 15px !important; overflow:hidden;">
                                                    <td style="padding-top: 0.4cm">Tarif Dasar</td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control mask_money_dn hitung_keyup" name="do_tarif_dasar" id="do_tarif_dasar" value="{{ number_format($data->tarif_dasar,0,'.','.') }}" style="text-align:right" tabindex="-1" >
                                                    </td>
                                                </tr>
                                                <tr class="do_tarif_penerus">
                                                    <td style="padding-top: 0.4cm">Tarif Penerus</td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="do_tarif_penerus" id="do_tarif_penerus" value="{{ number_format($data->tarif_penerus,0,'.','.') }}" style="text-align:right" readonly="readonly" tabindex="-1">
                                                        <div id="button_a" hidden=""></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Biaya Tambahan</td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control hitung_keyup mask_money_dn" name="do_biaya_tambahan" id="do_biaya_tambahan" value="{{ number_format($data->biaya_tambahan,0,'.','.') }}" style="text-align:right"  >
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm" id="div_kom">Discount</td>
                                                    <td  id="div_kom">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control hanyaangkadiskon mask_money_dn " name="do_diskon_p" id="do_diskon_p" value="{{ number_format($data->diskon_value,0,'.','.') }}" onkeyup="diskon_persen()" style="text-align:right">
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </td>
                                                    <td  id="div_kom">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">Rp</span>
                                                            <input type="text" class="form-control mask_money_dn" name="do_diskon_v" id="do_diskon_v" value="{{ number_format($data->diskon,0,'.','.') }}" onkeyup="diskon_value()" style="text-align:right">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr id="komisi">
                                                    <td style="padding-top: 0.4cm" id="div_kom">Biaya Komisi</td>
                                                    <td colspan="2" id="div_kom">
                                                        <input type="text" class="form-control hitung_keyup mask_money_dn" name="do_biaya_komisi" id="do_biaya_komisi" value="{{ number_format($data->biaya_komisi,0,'.','.') }}" style="text-align:right">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm" id="div_kom">Dpp</td>
                                                    <td colspan="2" id="div_kom">
                                                        <input type="text" class="form-control dv mask_money_dn check_harga_vendor"  name="do_dpp" id="do_dpp" value="{{ number_format($data->total_dpp,0,'.','.') }}" style="text-align:right" tabindex="-1"
                                                        
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
                                                        <input type="text" class="form-control dv mask_money_dn check_harga_vendor" name="do_vendor" id="do_vendor" value="{{ number_format($data->total_vendo,0,'.','.') }}" style="text-align:right" tabindex="-1"
                                                        
                                                    >
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm; ">Jenis PPN</td>
                                                    <td>
                                                        <select class="form-control" name="do_jenis_ppn" id="do_jenis_ppn" onchange="setJmlPPN()">
                                                            <option value="3" ppnrte="1" ppntpe="npkp" >INCLUDE 1 %</option>
                                                            <option value="2" ppnrte="1" ppntpe="pkp" >EXCLUDE 1 %</option>
                                                            <option value="4" ppnrte="0" ppntpe="npkp" >NON PPN</option>
                                                        </select>
                                                         <input type="hidden" name="acc_penjualan" class="form-control"  value="">
                                                    </td>
                                                    <td style="width:35%">
                                                        <input type="text" class="form-control jml_ppn" name="do_jml_ppn" readonly="readonly" tabindex="-1" style="text-align:right">
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 0.4cm" id="div_kom">Total</td>
                                                    <td colspan="2" id="div_kom">
                                                        <input type="text" class="form-control" name="do_total_h" id="do_total_h" value="{{ number_format($data->total_net,0,'.','.') }}" style="text-align:right" readonly="readonly" tabindex="-1">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="hidden" name="do_total_total"></td>
                                                </tr>
                                                <input type="hidden" name="do_total_temp">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table dt-responsive nowrap table-hover">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" style="text-align:center">
                                                        <h3>DATA PENGIRIM</h3>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Marketing</td>
                                                    <td colspan="">
                                                        <select class="chosen-select-width marketingpengirim"  name="do_marketing" style="width:100%">
                                                            <option>- Pilih -</option>
                                                            @foreach ($marketing as $row)
                                                                @if ($row->kode == $data->kode_marketing)
                                                                    <option selected="" value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                                @else 
                                                                    <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px;">Company Name</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="do_company_name_pengirim" style="text-transform: uppercase" value="{{ $data->company_name_pengirim }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Nama</td>
                                                    <td>
                                                        <input type="text" class="form-control namapengirim" name="do_nama_pengirim" style="text-transform: uppercase" value="{{ $data->nama_pengirim }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Alamat</td>
                                                    <td>
                                                        <input type="text" class="form-control alamatpengirim hanyaangka" name="do_alamat_pengirim"  style="text-transform: uppercase" value="{{ $data->alamat_pengirim }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Kode Pos</td>
                                                    <td>
                                                        <input type="text" class="form-control kodepospengirim hanyaangka" name="do_kode_pos_pengirim"  style="text-transform: uppercase" value="{{ $data->kode_pos_pengirim }}">
                                                        <span id="errmsg"></span>
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td style="width:110px; padding-top: 0.4cm">Telpon</td>
                                                    <td>
                                                        <input type="text" class="form-control teleponpengirim hanyaangka" name="do_telpon_pengirim"  style="text-transform: uppercase" value="{{ $data->telpon_pengirim }}">
                                                        <span id="errmsg"></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <table class="table dt-responsive nowrap table-hover">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" style="text-align:center">
                                                        <h3>DATA PENERIMA</h3>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px;">Company Name</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="do_company_name_penerima"style="text-transform: uppercase" value="{{ $data->company_name_penerima }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Nama</td>
                                                    <td>
                                                        <input type="text" class="form-control namapenerima replace_deskripsi" name="do_nama_penerima" style="text-transform: uppercase" value="{{ $data->nama_penerima }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Alamat</td>
                                                    <td>
                                                        <input type="text" class="form-control alamarpenerima" name="do_alamat_penerima"  style="text-transform: uppercase" value="{{ $data->alamat_penerima }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Kab/Kota</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="do_kota" readonly="readonly" value="{{ $data->kota_nama }}" tabindex="-1" required style="text-transform: uppercase">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Kecamatan</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="do_kecamatan" readonly="readonly" value="{{ $data->kecamatan_nama }}" tabindex="-1" required style="text-transform: uppercase">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:110px; padding-top: 0.4cm">Kode Pos</td>
                                                    <td>
                                                        <input type="text" class="form-control kodepospenerima hanyaangka" name="do_kode_pos_penerima"  style="text-transform: uppercase" value="{{ $data->kode_pos_pengirim }}">
                                                        <span id="errmsg"></span>
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td style="width:110px; padding-top: 0.4cm">Telpon</td>
                                                    <td>
                                                        <input type="text" class="form-control teleponpenerima hanyaangka" name="do_telpon_penerima"  style="text-transform: uppercase" value="{{ $data->telpon_pengirim }}">
                                                        <span id="errmsg"></span>
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td style="width:110px; padding-top: 0.4cm">Deskripsi</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="do_deskripsi"  style="text-transform: uppercase" value="{{ $data->deskripsi }}">
                                                    </td>
                                                </tr>
                                                <tr>    
                                                    <td style="width:110px; padding-top: 0.4cm">Instruksi</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="do_instruksi"  style="text-transform: uppercase" value="{{ $data->instruksi }}">
                                                    </td>
                                                </tr>
                                                <tr style="display:none;">
                                                    <td style="width:110px; ">Jenis Pembayaran</td>
                                                    <td colspan="5">
                                                        <select class="form-control" name="do_jenis_pembayaran"  >
                                                            <option value="">- Pilih -</option>
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
                                        <button type="button" class="btn btn-success " id="btnsimpan" name="btnsimpan" ><i class="glyphicon glyphicon-save"></i> Simpan</button>
                                        <button type="button" class="btn btn-success " onclick="cetak()"><i class="glyphicon glyphicon-print "></i> Cetak</button>
                                        <button type="button" class="btn btn-success " id="btnsimpan_tambah" name="btnsimpan_tambah" ><i class="glyphicon glyphicon-save"></i> Simpan & Tambah Baru</button>
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
                                  <h4 class="modal-title">Insert doit Delivery Order Cabang</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal kirim_detail">
                                        <table id="table_data" class="table table-stripdo table-borderdo table-hover">
                                            <tbody>
                                                <tr>
                                                    <td style="width:120px; padding-top: 0.4cm">No Sales Order</td>
                                                    <td colspan="5">
                                                        <div class="input-group" style="width : 100%">
                                                            <input  type="text" class="form-control" name="do_so" readonly="readonly" tabindex="-1"> <span class="input-group-btn"> <button type="button" id="btn_pilih_so" class="btn btn-primary">Search
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:120px; padding-top: 0.4cm">Item</td>
                                                    <td colspan="5">
                                                        <div class="input-group" style="width : 100%">
                                                            <input  type="text" class="form-control" name="do_item" disabldo="disabldo"> <span class="input-group-btn"> <button type="button" id="btn_pilih_item" class="btn btn-primary">Search
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr id="kargo">
                                                    <td style="width:120px; padding-top: 0.4cm">Jenis Kendaraan</td>
                                                    <td>
                                                        <select class="select2_single form-control"  name="do_angkutan" id="do_angkutan" style="width: 100% !important;" disabldo="disabldo">
                                                            <option value="">- Pilih -</option>

                                                        </select>
                                                    </td>

                                                    <td style="padding-top: 0.4cm">No Surat Jalan</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="do_surat_jalan" style="text-transform: uppercase">
                                                    </td>
                                                    <td style="padding-top: 0.4cm">Nopol</td>
                                                    <td>
                                                        <select class="chosen-select-width"  name="do_nopol" style="width:100%">
                                                            <option value="">- Pilih -</option>

                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="dimensi">
                                                    <td style="padding-top: 0.4cm">Panjang</td>
                                                    <td><input type="text" class="form-control" name="do_panjang" style="text-align:right"></td>
                                                    <td style="padding-top: 0.4cm">Lebar</td>
                                                    <td><input type="text" class="form-control" name="do_lebar" style="text-align:right"></td>
                                                    <td style="padding-top: 0.4cm">Tinggi</td>
                                                    <td><input type="text" class="form-control" name="do_tinggi" style="text-align:right"></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Jumlah</td>
                                                    <td><input type="text" class="form-control" name="do_jumlah" id="do_jumlah" style="text-align:right"></td>
                                                    <td style="padding-top: 0.4cm">Satuan</td>
                                                    <td colspan="3"><input type="text" class="form-control" id="dosatuan" name="do_satuan" readonly="readonly" tabindex="-1"></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Harga</td>
                                                    <td><input type="text" class="form-control" name="do_harga" style="text-align:right"></td>
                                                    <td style="padding-top: 0.4cm; width: 105px">Biaya Penerus</td>
                                                    <td colspan="3"><input type="text" class="form-control" name="do_biaya_penerus" style="text-align:right" ></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Discount</td>
                                                    <td><input type="text" class="form-control" name="do_diskon" style="text-align:right"></td>
                                                    <td style="padding-top: 0.4cm">Total</td>
                                                    <td colspan="3"><input type="text" class="form-control" name="do_total_harga" style="text-align:right" readonly="readonly" tabindex="-1" ></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Keterangan</td>
                                                    <td colspan="5"><textarea class="form-control" rows="3" name="do_keterangan" id="do_keterangan"  style="text-transform: uppercase"></textarea></td>
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
                    </div>
                </form>
                <div class="box-body" style="display:none">
                    <table id="table_data_detail" class="table table-borderdo table-stripdo">
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

@endsection
@section('extra_scripts')
<script type="text/javascript">

$('.radio-inline').click(function() {
   if($('.cek_vendor_ya').is(':checked')) { 
        toastr.info("Tarif vendor aktif", "Pemberitahuan!")
        $('#tarif_vendor_bol').val('true');
   }else if($('.cek_vendor_tidak').is(':checked'))  {
        toastr.info("Tarif vendor tidak aktif", "Pemberitahuan!")
        $('#tarif_vendor_bol').val('false');
   }
});

//WILAYAH EDIT/PENGAMBILAN DATA / MENAMPILKAN DATA

//SEMUNYIKAN BEBERAPA FIELD
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

        //CEK TIPE
        if ($('#type_kiriman').val() == 'KILOGRAM' ) {
            $("#dimensi").show();
            $("#koli").show();
            $("#berat").show();
        }else if ($('#type_kiriman').val() == 'KOLI' ) {
            $("#koli").show();
            $("#berat").show();
        }

        //MENGELUARKAN FIELD KOMISI
        if ($("#do_biaya_komisi").val() != 0) {
            $("#komisi").show();
        } 

        //CEK CENTANG PADA TARIF VENDOR
        if ('{{ $data->tarif_vendor_bol }}' == true) {
            // $('.cek_vendor_ya').prop('checked',true);
        }else{
            // $('.cek_vendor_tidak').prop('checked',true);
        }
        
    });

$('#type_kiriman').val('{{ $data->type_kiriman }}');
$('#jenis_kiriman').val('{{ $data->jenis_pengiriman }}');
$('#do_jenis_ppn').val('{{ $data->jenis_ppn }}');
$('.jml_ppn').val('{{ $data->ppn_val }}');

if ($('#do_vendor').val() != 0 ) {
    $('.vendor_tarif').prop('checked',true);
}
if ($('#do_jenis_ppn').val() == 3) {

    var tarif_dasar = $("input[name='do_tarif_dasar']").val();
    var biaya_tambahan = $("input[name='do_biaya_tambahan']").val();
    var biaya_komisi  = $("input[name='do_biaya_komisi']").val();
    var jenis_ppn = $("select[name='do_jenis_ppn']").val();
    var biaya_penerus = $("input[name='do_tarif_penerus']").val();
    var do_diskon_v = $("input[name='do_diskon_v']").val();

    var biaya_penerus = biaya_penerus.replace(/[A-Za-z$. ,-]/g, "");
    var do_diskon_v = do_diskon_v.replace(/[A-Za-z$. ,-]/g, "");
    var tarif_dasar = tarif_dasar.replace(/[A-Za-z$. ,-]/g, "");
    var biaya_tambahan = biaya_tambahan.replace(/[A-Za-z$. ,-]/g, "");
    var biaya_komisi = biaya_komisi.replace(/[A-Za-z$. ,-]/g,"");
    var jenis_ppn = jenis_ppn.replace(/[A-Za-z$. ,-]/g, "");



    var total  = parseFloat(tarif_dasar)+parseFloat(biaya_penerus)+parseFloat(biaya_tambahan)+parseFloat(biaya_komisi)-parseFloat(do_diskon_v);
    var ppn  = 0;
    if (jenis_ppn == 3) {
        ppn = 1/101*parseFloat(total);
    }

    $(".jml_ppn").val(ppn.toFixed(2));
}

//END OF

//VARIABLE GLOBAL 
$("input[name='do_vendor']").prop('readonly',true);

    
//CARI NOMOR DO
    $('#do_cabang').change(function(){

        var cabang_this = $(this).val();
        var tanggal_this = $('#do_tanggal').val();

        $.ajax({
           url:('{{ route('cari_nomor_deliveryorder_paket') }}'),
           type:'get',
           data:{a:cabang_this,b:tanggal_this},
           success:function(response){
            console.log(response);
                if ($('#do_nomor').val() == '') {
                    $('#do_nomor').val(response.nomor);
                }else{
                    var rep = $('#do_nomor').val();
                    var rep_nom = rep.substr(0,3);
                        if (rep_nom == 'PAK') {
                            $('#do_nomor').val(response.nomor);
                        }else{
                        }
                }
           }
        })
    })

//------- FUNGSI KETIKA MERUBAH ASAL/TUJUAN UNCHECK VENDOR -------//

//CARI KECAMATAN
    function getKecamatan() {
        $('#do_kecamatan_tujuan').append('<option value="">- Pilih -</option>').trigger('chosen:updated');
        var kot = $('#do_kota_tujuan').find(':selected').val();
        
        $('.cek_vendor_ya').prop("checked",false);
        $.ajax({
            type: "GET",
            data : {a:kot},
            url : ('{{ route('cari_kecamatan_deliveryorder_paket') }}'),
            dataType:'json',
            success: function(data)
            {   
                 for (var i = 0; i < data.length; i++) {
                    $('#do_kecamatan_tujuan').append('<option value="'+data[i].id+'" data-nama="'+data[i].nama+'">'+data[i].id+' - '+data[i].nama+'</option>').trigger('chosen:updated');
                 }
                             
            }
        })

        var kot_replace = $('#do_kota_tujuan').find(':selected').data('nama');
        $("input[name='do_kota']").val(kot_replace);
    }
//RUBAH KOLOM ASAL KOTA
    function asal() {
        $('.cek_vendor_ya').prop("checked",false);
    }
//CLOSE MODAL VENDOR
    function close_vendor() {
        $('.cek_vendor_ya').prop("checked",false);
    }

//----------------------- FUNFSI BERAKIR ------------------------//


//CARI DAN REPLACE DATA PADA KECAMTAN
    $('#do_kecamatan_tujuan').change(function(){
        var kec_replace = $(this).find(':selected').data('nama');
        $("input[name='do_kecamatan']").val(kec_replace);
    })


//CARI TYPE KIRIMAN
    $('#type_kiriman').change(function(){
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
            }else if ( type_kiriman =='SEPdoA') {
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
            }else if (type_kiriman ==''){
                $("#surat_jalan").hide();
                $("#dimensi").hide();
                $("#nopol").hide();
                $("#koli").hide();
                $("#berat").hide();
                $("#jenis_kendaraan").hide();
                $("#do_biaya_komisi").hide();
                $("#jml_unit").hide();
                $(".jenis_unit").hide();
            }
    });


//HITUNG FUNGSI 1 UNTUK SEMUA
function hitung() {
    //--Field
    var jenis_ppn = $("select[name='do_jenis_ppn']").val();
    var tarif_dasar = $("input[name='do_tarif_dasar']").val();
    var biaya_tambahan = $("input[name='do_biaya_tambahan']").val();
    var biaya_penerus = $("input[name='do_tarif_penerus']").val();
    var diskon_p  = $("input[name='do_diskon_p']").val();
    var diskon_v  = $("input[name='do_diskon_v']").val();
    var biaya_komisi  = $("input[name='do_biaya_komisi']").val();
    var do_vendor  = $("input[name='do_vendor']").val();
    
    var this_selected_value = $('#do_cabang').find(':selected').data('diskon');
        
    //--Regex
    var jenis_ppn = jenis_ppn.replace(/[A-Za-z$. ,-]/g, "");
    var tarif_dasar = tarif_dasar.replace(/[A-Za-z$. ,-]/g, "");
    var biaya_tambahan = biaya_tambahan.replace(/[A-Za-z$. ,-]/g, "");
    var biaya_penerus = biaya_penerus.replace(/[A-Za-z$. ,-]/g, "");
    var diskon_p = diskon_p.replace(/[A-Za-z$. ,-]/g, "");
    var diskon_v = diskon_v.replace(/[A-Za-z$. ,-]/g, "");
    var biaya_komisi = biaya_komisi.replace(/[A-Za-z$. ,-]/g,"");
    var do_vendor = do_vendor.replace(/[A-Za-z$. ,-]/g,"");



    if (diskon_p > 100) {
        toastr.error("Tidak boleh memasukkan diskon melebihi ketentuan", "Peringatan!")
        $("input[name='do_diskon_p']").val(0);
        $("input[name='do_diskon_v']").val(0);
    }

    if(diskon_p > this_selected_value){
        toastr.error("Tidak boleh memasukkan diskon melebihi ketentuan", "Peringatan!")
        $("input[name='do_diskon_p']").val(0);
        $("input[name='do_diskon_v']").val(0);
    }

    //alert ketika diskon dan biaya tambahan di pakai 2-2nya
    if (diskon_p > 0 && biaya_tambahan > 0) {
        toastr.error('Diskon dan biaya tambahan di isi salah satu!!','Peringatan!');
        $("input[name='do_diskon_p']").val(0);
        $("input[name='do_diskon_v']").val(0);
        $("input[name='do_biaya_tambahan']").val(0);
    }

    //menghitung atas
    var total  = parseFloat(tarif_dasar)+parseFloat(biaya_tambahan)+parseFloat(biaya_komisi)+parseFloat(biaya_penerus);
    if (diskon_p != 0) {
        var diskon_value_utama = diskon_p / 100 * total;
        $("input[name='do_diskon_v']").val(Math.round(diskon_value_utama));
    }else if (diskon_p == 0) {  
        var diskon_value_utama = diskon_p / 100 * total;
        $("input[name='do_diskon_v']").val(Math.round(diskon_value_utama));
    }

    //PENGURANGAN DISKON
    var total_dpp = total - diskon_value_utama;
    var sub_dpp = total_dpp - do_vendor;

    if ($('.vendor_tarif').is(':checked') == true) {
        $("input[name='do_dpp']").val(accounting.formatMoney(sub_dpp,"",0,'.',','));
    }else{
        $("input[name='do_dpp']").val(accounting.formatMoney(total_dpp,"",0,'.',','));
    }
        
    //CHECKBOX VENDOR
    


    //--PPN
    var ppn  = 0;
    if (jenis_ppn == 1) {
        ppn =parseFloat(total_dpp) * parseFloat(0.1);
        total = total_dpp + ppn;
    }else if (jenis_ppn == 2) {
        ppn =parseFloat(total_dpp) / parseFloat(100);
        total = total_dpp + ppn;
    }else if (jenis_ppn == 4) {
        ppn =0;
    }else if (jenis_ppn == 3) {
        ppn = 1 / parseFloat(100+1) * parseFloat(total_dpp) ;
    }else if (jenis_ppn == 5) {
        ppn =parseFloat(total_dpp) / parseFloat(10.1);
        total = total_dpp - ppn;
    }

    var total_h = total-diskon_value_utama; 

    //--hasil perhitungan
    $("input[name='do_jml_ppn']").val(ppn.toFixed(2));
    $("input[name='do_total_h']").val(accounting.formatMoney(total_h,"",0,'.',','));

}


//CEK VENDOR / CARI MODAL / MEMUNCULKAN MODAL
    $(".cek_vendor_ya").click(function() {
        if ($('#do_kota_asal').val() == '' 
            || $('#do_kota_tujuan').val() == '' 
            || $('#do_cabang').val() == '' ) {
            toastr.warning('Data Kurang Lengkap ,Ada data yg Tidak Boleh Kosong!!');
            $('.cek_vendor_ya').prop("checked",false);
        }else{
            var asal = $('#do_kota_asal').find(':selected').val();
            var tujuan = $('#do_kota_tujuan').find(':selected').val();
            var cabang = $('#do_cabang').find(':selected').val();
            var jenis = $('#jenis_kiriman').find(':selected').val();
            var tipe = $('#type_kiriman').find(':selected').val();
            var berat = $('#do_berat').val();

            if ($('.cek_vendor_ya').is(":checked") == true) {
                $('.do_tarif_penerus').hide();
                $.ajax({
                type: "GET",
                data : {a:asal,b:tujuan,c:cabang,d:jenis,e:tipe,f:berat,cek:'YA'},
                url : ('{{ route('cari_vendor_deliveryorder_paket') }}'),
                success: function(data){   
                    $('#drop').html(data);
                    $("#modal_vendor").modal("show");
                    $('#datatable').DataTable();
                }})
            }else{
                console.log('b');
            }
        }
    });
    

//CEK OUTLET / CEK KOMISI
    $("#do_outlet").change(function() {
        if ($(this).val() == 'NON OUTLET' || $(this).val() == '') {
            $('#komisi').hide();
        }else{
            $('#komisi').show();
        }     
    });


//PILIH VENDOR
 function Pilih_vendor(a){
        var id_vendor = $(a).find('.id_vendor').val();

         $.ajax({
            data: {a:id_vendor},
            url:('{{ route('replace_vendor_deliveryorder_paket') }}'),
            type:'get',
            success:function(data){
                $("input[name='do_vendor']").prop('readonly',true);
                $("input[name='do_dpp']").prop('readonly',true);
                $("input[name='vendor_tarif']").prop('checked'  ,true);
                $("#modal_vendor").modal("hide");
                

                if ($('.vendor_tarif').is(':checked') == true) {
                    $("input[name='do_vendor']").val(accounting.formatMoney(data[0].tarif_vendor,"",0,'.',','));
                }

                $("input[name='do_tarif_dasar']").val(accounting.formatMoney(data[0].tarif_vendor,"",0,'.',','));
                hitung();

                $('#id_tarif_vendor').val(data[0].kode);
                $('#nama_tarif_vendor').val(data[0].nama);
            }
        });
        
    }
    
//SET PPN / CHNGE PPN / GANTI PPN
    function setJmlPPN(){
        hitung();
    }


//ONKEUP BIAYA TAMBAHANN
    $(".hitung_keyup").keyup(function() {
        hitung();
    });


//DISKON VALUE
    function diskon_value(){
        if ($("input[name='do_diskon_v']").val() != 0) {

            $("input[name='do_diskon_p']").attr('readonly',true);

            var jenis_ppn = $("select[name='do_jenis_ppn']").val();
            var tarif_dasar = $("input[name='do_tarif_dasar']").val();
            var biaya_penerus = $("input[name='do_tarif_penerus']").val();
            var biaya_tambahan = $("input[name='do_biaya_tambahan']").val();
            var diskon_p  = $("input[name='do_diskon_p']").val();
            var diskon_v  = $("input[name='do_diskon_v']").val();
            var biaya_komisi  = $("input[name='do_biaya_komisi']").val();
            var do_vendor  = $("input[name='do_vendor']").val();

            
            var this_selected_value = $('#do_cabang').find(':selected').data('diskon');

            //--Regex
            var jenis_ppn = jenis_ppn.replace(/[A-Za-z$. ,-]/g, "");
            var tarif_dasar = tarif_dasar.replace(/[A-Za-z$. ,-]/g, "");
            var biaya_tambahan = biaya_tambahan.replace(/[A-Za-z$. ,-]/g, "");
            var biaya_penerus = biaya_penerus.replace(/[A-Za-z$. ,-]/g, "");
            var diskon_p = diskon_p.replace(/[A-Za-z$. ,-]/g, "");
            var diskon_v = diskon_v.replace(/[A-Za-z$. ,-]/g, "");
            var biaya_komisi = biaya_komisi.replace(/[A-Za-z$. ,-]/g,"");
            var do_vendor = do_vendor.replace(/[A-Za-z$. ,-]/g,"");

            //alert ketika diskon dan biaya tambahan di pakai 2-2nya
            if (diskon_p > 0 && biaya_tambahan > 0) {
                toastr.error('Diskon dan biaya tambahan di isi salah satu!!','Peringatan !');
                $("input[name='do_diskon_p']").val(0);
                $("input[name='do_diskon_v']").val(0);
                $("input[name='do_biaya_tambahan']").val(0);
            }

            //-- menghitung atas
            var total  = parseFloat(tarif_dasar)+parseFloat(biaya_penerus)+parseFloat(biaya_tambahan)+parseFloat(biaya_komisi);

            var diskon_total = parseFloat(diskon_v)/parseFloat(total)*100;
        
            


            $('#do_diskon_p').val(Math.round(diskon_total,2));
            if(diskon_v == 0 || diskon_v == ''){
                $('#do_diskon_p').val(0);
            }

            //PENGURANGAN DISKON
            var total_dpp = total - diskon_v;
            var sub_dpp = total_dpp - do_vendor;

            var total_hitung_ppn = total - diskon_v;


            if ($('.vendor_tarif').is(':checked') == true) {
                $("input[name='do_dpp']").val(accounting.formatMoney(sub_dpp,"",0,'.',','));
            }else{
                $("input[name='do_dpp']").val(accounting.formatMoney(total_dpp,"",0,'.',','));
            }
            //END

            var temp_total  = $('input[name="do_total_temp"]').val(total_dpp);

            var ppn  = 0;
            if (jenis_ppn == 1) {
                ppn =parseFloat(total_hitung_ppn) * parseFloat(0.1);
                total = total_hitung_ppn + ppn;
            }else if (jenis_ppn == 2) {
                ppn =parseFloat(total_hitung_ppn) / parseFloat(100.1);
                total = total_hitung_ppn + ppn;
            }else if (jenis_ppn == 4) {
                ppn =0;
            }else if (jenis_ppn == 3) {
                ppn = 1 / parseFloat(100+1) * parseFloat(total_hitung_ppn) ;
            }else if (jenis_ppn == 5) {
                ppn =parseFloat(total_hitung_ppn) / parseFloat(10.1);
                total = total_hitung_ppn - ppn;
            }
            
            var total_h = total-diskon_v; 
            $('.jml_ppn').val(ppn.toFixed(2));
            if(diskon_total > this_selected_value){
                toastr.error("Tidak boleh memasukkan diskon melebihi ketentuan", "Peringatan !")
                $("input[name='do_diskon_v']").val(0);
                $('#do_diskon_p').val(0);
                $('#do_total_h').val(accounting.formatMoney(1,"",0,'.',','));
            }
            $("input[name='do_total_h']").val(accounting.formatMoney(total_h,"",0,'.',','));
            console.log('a');


        }else{
            var jenis_ppn = $("select[name='do_jenis_ppn']").val();
            var tarif_dasar = $("input[name='do_tarif_dasar']").val();
            var biaya_tambahan = $("input[name='do_biaya_tambahan']").val();
            var biaya_penerus = $("input[name='do_tarif_penerus']").val();
            var biaya_komisi  = $("input[name='do_biaya_komisi']").val();
            var diskon_p  = $("input[name='do_diskon_p']").val();
            var diskon_v  = $("input[name='do_diskon_v']").val();

            //--Regex
            var jenis_ppn = jenis_ppn.replace(/[A-Za-z$. ,-]/g, "");
            var tarif_dasar = tarif_dasar.replace(/[A-Za-z$. ,-]/g, "");
            var biaya_tambahan = biaya_tambahan.replace(/[A-Za-z$. ,-]/g, "");
            var biaya_penerus = biaya_penerus.replace(/[A-Za-z$. ,-]/g, "");
            var diskon_p = diskon_p.replace(/[A-Za-z$. ,-]/g, "");
            var diskon_v = diskon_v.replace(/[A-Za-z$. ,-]/g, "");
            var biaya_komisi = biaya_komisi.replace(/[A-Za-z$. ,-]/g,"");


            $("input[name='do_diskon_p']").attr('readonly',false);          

            var total  = parseFloat(tarif_dasar)+parseFloat(biaya_penerus)+parseFloat(biaya_tambahan)+parseFloat(biaya_komisi);

            var diskon_total = parseFloat(diskon_v)/parseFloat(total)*100;

            $('#do_diskon_p').val(Math.round(diskon_total,2));
            
            //PENGURANGAN DISKON
            var total_dpp   = total - diskon_v;
            var sub_dpp     = total_dpp - do_vendor;

            var total_hitung_ppn = total - diskon_v;

            var temp_total  = $('input[name="do_total_temp"]').val(total_dpp);

            if ($('.vendor_tarif').is(':checked') == true) {
                $("input[name='do_dpp']").val(accounting.formatMoney(sub_dpp,"",0,'.',','));
            }else{
                $("input[name='do_dpp']").val(accounting.formatMoney(total_dpp,"",0,'.',','));
            }

            var ppn  = 0;
            if (jenis_ppn == 1) {
                ppn =parseFloat(total_hitung_ppn) * parseFloat(0.1);
                total = total_hitung_ppn + ppn;
            }else if (jenis_ppn == 2) {
                ppn =parseFloat(total_hitung_ppn) / parseFloat(100.1);
                total = total_hitung_ppn + ppn;
            }else if (jenis_ppn == 4) {
                ppn =0;
            }else if (jenis_ppn == 3) {
                ppn = 1 / parseFloat(100+1) * parseFloat(total_hitung_ppn) ;
            }else if (jenis_ppn == 5) {
                ppn =parseFloat(total_hitung_ppn) / parseFloat(10.1);
                total = total_hitung_ppn - ppn;
            }

            $('.jml_ppn').val(ppn.toFixed(2));
            console.log('b');

            var total_h = total-diskon_v; 
            $("input[name='do_total_h']").val(accounting.formatMoney(total_h,"",0,'.',','));


        }

    }


//DISKON PERCENT / DISKON PERSEN
    function diskon_persen(){

        if ($("input[name='do_diskon_p']").val() != 0) {
            $("input[name='do_diskon_v']").attr('readonly',true);
        }else{
            $("input[name='do_diskon_v']").attr('readonly',false);
        }

        hitung();
    }


//VENDOR PADA PERHITUNGAN
    $(".vendor_tarif").change(function() {
        //FIELD
        var dpp    = $('#do_dpp').val();
        var vendor = $('#do_vendor').val();
        //REGEX
        var dpp = dpp.replace(/[A-Za-z$. ,-]/g, "");
        var vendor = vendor.replace(/[A-Za-z$. ,-]/g, "");

        if ($('.vendor_tarif').is(':checked') == true) {
            $("input[name='do_vendor']").prop('readonly',false);

            if (dpp == 0) {
                $("input[name='do_vendor']").val(accounting.formatMoney(dpp,"",0,'.',','));
                $("input[name='do_dpp']").val(accounting.formatMoney(0,"",0,'.',','));
            }else{
                $("input[name='do_vendor']").val(accounting.formatMoney(dpp,"",0,'.',','));
                $("input[name='do_dpp']").val(accounting.formatMoney(vendor,"",0,'.',','));
            }
            
            
        }else{
            $("input[name='do_vendor']").prop('readonly',true);
            if (vendor == 0) {
                $("input[name='do_dpp']").val(accounting.formatMoney(vendor,"",0,'.',','));
                $("input[name='do_vendor']").val(accounting.formatMoney(0,"",0,'.',','));
            }else{
                $("input[name='do_dpp']").val(accounting.formatMoney(vendor,"",0,'.',','));
                $("input[name='do_vendor']").val(accounting.formatMoney(dpp,"",0,'.',','));
            }
            
        }
    });


//CEK VENDOR TAMBAH , JIKA MELEBIHI DARI TOTAL PENJUMLAHAN AKAN ERROR
    $('.check_harga_vendor').keyup(function(){

        var dpp    = $('#do_dpp').val();
        var vendor = $('#do_vendor').val();
        var harga_temp = $("input[name='do_total_temp']").val();

        var dpp = dpp.replace(/[A-Za-z$. ,-]/g, "");
        var vendor = vendor.replace(/[A-Za-z$. ,-]/g, "");
        var harga_temp = harga_temp.replace(/[A-Za-z$. ,-]/g, "");

        var cek = parseInt(dpp)+parseInt(vendor);

        if (cek > harga_temp) {
            toastr.warning('Tidak boleh meleihi batas!');
            $('#do_dpp').val(0);
            $('#do_vendor').val(0);
        }
    })


//SIMPAN DATA
    $(document).on("click","#btnsimpan",function(){
        $.ajax(
        {
            url :  ("{{ route('update_deliveryorder_paket') }}"),
            type: "GET",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {   
                if (data.status == 'sukses') {
                    toastr.success('Data Telah Tersimpan!','Pemberitahuan!');
                }else if (data.status == 'gagal') {
                    toastr.error('Akun Piutang Pada Cabang Ini Belum Tersedia !','Peringatan!');
                }
                else{
                    toastr.error('Gagal Tersimpan! WA developer segera','Peringatan!');
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               toastr.error('Gagal Tersimpan!');
            }
        });
    });



// UNTUK FORM PER 1 TENTANG BERAT DO

    $('#btn_cari_harga').click(function(){
        //FIELD
        var kota_asal = $("select[name='do_kota_asal']").val();
        var kecamatan_tujuan = $("select[name='do_kecamatan_tujuan']").val();
        var kota_tujuan = $("select[name='do_kota_tujuan']").val();
        var type = $("select[name='type_kiriman']").val();
        var jenis =$("select[name='jenis_kiriman']").val();
        var cabang = $("select[name='do_cabang']").val();
        var berat = $("input[name='do_berat']").val();
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

        //VALIDASI
        if (cabang == '') {
            toastr.error('Cabang Harus di isi !','Peringatan!');
            return false;
        }else if (kota_asal == '') {
            toastr.error('Kota Asal Harus di isi !','Peringatan!');
            return false;
        }else if (kota_tujuan == '') {
            toastr.error('Kota Tujuan Harus di isi !','Peringatan!');
            return false;
        }else if (kecamatan_tujuan == '' || kecamatan_tujuan == null) {
            toastr.error('kecamatan Tujuan Harus di isi !','Peringatan!');
            return false;
        }else if (type == '') {
            toastr.error('Type Kiriman Harus di isi !','Peringatan!');
            return false;
        }else if (jenis == '') {
            toastr.error('Jenis Kiriman Harus di isi !','Peringatan!');
            return false;
        }

        //VALUE DATA 
        var value = {
            pendapatan: $("select[name='pendapatan']").val(),
            asal: $("select[name='do_kota_asal']").val(),
            tujuan: $("select[name='do_kota_tujuan']").val(),
            tipe: $("select[name='type_kiriman']").val(),
            tujuan: $("select[name='do_kota_tujuan']").val(),
            jenis: $("select[name='jenis_kiriman']").val(),
            angkutan: $("select[name='do_angkutan']").val(),
            cabang: $("select[name='do_cabang']").val(),
            berat : $('#do_berat').val(),
            kecamatan : $("select[name='do_kecamatan_tujuan']").val(),
            berat : berat,
            sepeda: jenis_sepeda,
            berat_sepeda: berat_sepeda
        };

        //AJAX
        $.ajax({
            url : ("{{ route('cari_harga_reguler_deliveryorder_paket') }}"),
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {

                //jika penrus == 0
                if (data.biaya_penerus == 0) {
                    toastr.warning('Tarif Penerus tidak ditemukan / Belum dibuat','Pemberitahuan!')
                }
                //replace
                $("input[name='acc_penjualan']").val(data.acc_penjualan);
                $("#do_tarif_penerus").val(accounting.formatMoney(data.biaya_penerus,"",0,'.',','));
                $('#do_tarif_dasar').val(accounting.formatMoney(data.harga,"",0,'.',','));
                $('#tarif_dasar_patokan').val(data.harga);
                
                //kondisi jika berat kurang dari batas minimum
                var berat_minimum_field  = $("input[name='do_berat']").val();
                var koli                 = $("input[name='do_koli']").val();
                var tarif_dasar_patokan  = $("input[name='tarif_dasar_patokan']").val();
                
                if (data.tipe == 'KILOGRAM') {
                    if (data.batas != 0 || data.batas != null) {
                        toastr.info('Berat minimum adalah '+'<b style="color:red">'+data.batas+'</b>'+' KG','Pemberitahuan!')
                        if (berat_minimum_field < data.batas) {
                            //hitung hasil dari pencarian
                            var hitung_berat = parseFloat(data.batas)*parseFloat(data.harga);
                            //replace berat dan tarif dasar
                            $("input[name='do_berat']").val(data.batas);
                            $("input[name='berat_minimum']").val(data.batas);
                            $('#do_tarif_dasar').val(accounting.formatMoney(hitung_berat,"",0,'.',','));
                            $('#tarif_dasar_patokan').val(data.harga);
                        }else{
                            //replace berat dan tarif dasar
                            $("input[name='berat_minimum']").val(data.batas);
                            $('#do_tarif_dasar').val(accounting.formatMoney(data.harga,"",0,'.',','));
                            $('#tarif_dasar_patokan').val(data.harga);
                        }
                    }else{
                        toastr.error('Berat minimum belum di set / kosong ','Peringatan!')
                    }
                }

                if (data.tipe == 'KOLI') {
                    //kondisi
                    if (koli ==  0 || koli == null) {
                        koli = 1;            
                    }else{
                        koli = koli;
                    }
                    //hitung hasil dari pencarian
                    var hitung_berat = parseFloat(koli)*parseFloat(data.harga);
                    //replace berat dan tarif dasar
                    $('#do_tarif_dasar').val(accounting.formatMoney(hitung_berat,"",0,'.',','));
                    $('#tarif_dasar_patokan').val(data.harga);

                }
                
                console.log(data);
                hitung();
            }   
        })

    });    

    function BeratDefault(){
        var tipe          = $('#type_kiriman').val();
        var berat         = $("input[name='do_berat']").val();
        var berat_minimum = $("input[name='berat_minimum']").val();
        var tarif_dasar   = $("#tarif_dasar_patokan").val();
        

        //perhitungan berat dikali 

        if (tipe == 'KOLI') {
            if (berat > 50) {
                toastr.error("Maksimal berat KOLI yang dilayani 50 Kg", "Peringatan!");
                $("input[name='do_berat']").val(1);

                return false;
            }
        }else if (tipe == 'KILOGRAM'){
            if (berat < berat_minimum) {
                toastr.error('Berat minimum adalah '+'<b style="color:blue">'+berat_minimum+'</b>'+' KG','Peringatan!')
                $("input[name='do_berat']").val(berat_minimum);
            }
        }

        
    }



// END FORM PER 1 


//JURNAL AWAL
    function jurnal_awal() {
        var id = $('#do_nomor').val();
        $.ajax(
        {
            url :  ("{{ route('jurnal_awal_deliveryorder_paket') }}"),
            type: "GET",
            data : {id:id} ,
            success: function(data, textStatus, jqXHR)
            {  
                if (data.status == 'kosong') {
                    toastr.error('Data Tidak Ditemukan! / Do bukan Non-cust','Peringatan!');
                }
                else{
                   $('.drop_here').html(data);
                   $('#modal_jurnal_awal').modal('show');
                   var kredit_l = 0;
                   $('.kredit_jurnal_awal').each(function(i) {
                        var kredit_total = parseFloat($(this).val());
                        kredit_l += kredit_total;
                   })
                   $('.total_kredit_jurnal_awal').text(kredit_l);

                   var debet_jurnal_awal = $('.debet_jurnal_awal').val();
                   $('.total_debet_jurnal_awal').text(debet_jurnal_awal);
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               toastr.error('Error!','Error!');
            }
        });
    }


    $("#do_nomor").keypress(function (e) {
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122)) {
            return false;
    }
   });


//JURNAL BALIK
    function jurnal_balik() {
        var id = $('#do_nomor').val();
        $.ajax(
        {
            url :  ("{{ route('jurnal_balik_deliveryorder_paket') }}"),
            type: "GET",
            data : {id:id} ,
            success: function(data, textStatus, jqXHR)
            {  
                if (data.status == 'kosong') {
                    toastr.error('Data Tidak Ditemukan! / Do bukan Non-cust','Peringatan!');
                }
                else{
                   $('.drop_here').html(data);
                   $('#modal_jurnal_balik').modal('show');
                   var kredit_l = 0;
                   $('.kredit_jurnal_balik').each(function(i) {
                        var kredit_total = parseFloat($(this).val());
                        kredit_l += kredit_total;
                   })
                   $('.total_kredit_jurnal_balik').text(kredit_l);

                   var debet_jurnal_balik = $('.debet_jurnal_balik').val();
                   $('.total_debet_jurnal_balik').text(debet_jurnal_balik);
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               toastr.error('Error!','Error!');
            }
        });
    }
    
</script>
@endsection