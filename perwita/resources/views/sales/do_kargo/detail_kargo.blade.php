@extends('main')

@section('title', 'dashboard')

@section('content')
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
.tabel_tarif tbody tr{
    cursor: pointer;
}
</style>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Delivery Order Kargo
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <a href="../deliveryorderkargo" class="pull-right" style="color: grey; float: right;"><i class="fa fa-arrow-left"> Kembali</i></a>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                        <div class="col-sm-12">
                            <form class="col-sm-6"> 
                                <table class="table table-bordered tabel_header table-striped"> 
                                    <tr>
                                        <td style="width: 150px;">Nomor</td>
                                        <td>
                                            <input type="text" style="text-transform: uppercase;" name="nomor_do" value="{{$data->nomor}}" class="nomor_do form-control input-sm">
                                            <input type="hidden" name="nomor_do_old" value="{{$data->nomor}}" class="nomor_do_old form-control input-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td>
                                            <div class="input-group date" style="width:100%">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control tanggal_do" name="tanggal_do" value="{{$now}}">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>DO Awal</td>
                                        <td><input type="text" value="{{$data->nomor_do_awal}}" name="nomor_do_awal" class="nomor_do_awal form-control input-sm"></td>
                                    </tr>
                                    <tr>
                                        <td>No Surat Jalan</td>
                                        <td>
                                            <input type="text" value="{{$data->nomor_surat_jalan}}" name="surat_jalan" class="surat_jalan form-control input-sm">
                                            <input type="hidden" name="nomor_print" class="nomor_print form-control input-sm">
                                        </td>
                                    </tr>
                                    <tr class="disabled">
                                        <td>Cabang</td>
                                        <td>

                                            @if(Auth::user()->punyaAkses('Delivery Order','cabang'))
                                                <select onchange="ganti_nota()" class="form-control cabang_select">
                                                @foreach($cabang as $val)
                                                    @if($data->kode_cabang == $val->kode)
                                                    <option selected="" value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                    @else
                                                    <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                    @endif
                                                @endforeach
                                                </select>
                                            @else
                                                <select disabled="" class="form-control cabang_select">
                                                @foreach($cabang as $val)
                                                @if($data->kode_cabang == $val->kode)
                                                    <option selected value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                @else
                                                    <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                @endif
                                                @endforeach
                                                </select>
                                            @endif
                                            <input type="hidden" name="cabang_input" class="cabang_input form-control input-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Customer</td>
                                        <td class="">
                                            <div style="width: 380px">
                                            <select onchange="cari_kontrak()" class="form-control customer chosen-select-width" name="customer_do">
                                                <option value="0">Pilih - Customer</option>
                                            @foreach($customer as $val)
                                                @if($data->kode_customer == $val->kode)
                                                <option selected value="{{$val->kode}}">{{$val->kode}}-{{$val->nama}}</option>
                                                @else
                                                <option value="{{$val->kode}}">{{$val->kode}}-{{$val->nama}}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kota Asal</td>
                                        <td>
                                            <select onchange="reseting()" name="asal_do" class="form-control asal_do chosen-select-width">
                                                <option value="0">Pilih - Kota Asal</option>
                                            @foreach($kota as $val)
                                                @if($data->id_kota_asal == $val->id)
                                                <option selected="" value="{{$val->id}}">{{$val->id}}-{{$val->nama}}</option>
                                                @else
                                                <option value="{{$val->id}}">{{$val->id}}-{{$val->nama}}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kota Tujuan</td>
                                        <td>
                                            <select onchange="reseting()" name="tujuan_do" class="form-control tujuan_do chosen-select-width">
                                                <option value="0">Pilih - Kota Tujuan</option>
                                            @foreach($kota as $val)
                                                @if($data->id_kota_tujuan == $val->id)
                                                <option selected="" value="{{$val->id}}">{{$val->id}}-{{$val->nama}}</option>
                                                @else
                                                <option value="{{$val->id}}">{{$val->id}}-{{$val->nama}}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Tarif</td>
                                        <td>
                                            <select name="jenis_tarif_do" onchange="cari_nopol_kargo()" class="form-control jenis_tarif_do chosen-select-width">
                                            @foreach($jenis_tarif as $val)
                                                @if($data->jenis_tarif == $val->jt_nama_tarif)
                                                <option value="{{$val->jt_id}}">{{$val->jt_nama_tarif}}</option>
                                                @else
                                                <option value="{{$val->jt_id}}">{{$val->jt_nama_tarif}}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                            <input type="hidden" class="jenis_tarif_temp">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status Kendaraan</td>
                                        <td>
                                            <select name="status_kendaraan" onchange="cari_nopol_kargo()" class="form-control status_kendaraan chosen-select-width">
                                                @if($data->status_kendaraan == 'OWN')
                                                <option selected="" value="OWN">OWN</option>
                                                <option value="SUB">SUB</option>
                                                @else
                                                <option value="OWN">OWN</option>
                                                <option selected value="SUB">SUBCON</option>
                                                @endif
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="nama_subcon_tr" hidden="">
                                        <td>Nama Subcon</td>
                                        <td>
                                            <select name="nama_subcon" onchange="cari_nopol_kargo()" class="form-control nama_subcon chosen-select-width">
                                                <option value="0">Pilih - Subcon</option>
                                                @foreach($subcon as $i=>$val)
                                                @if($data->kode_subcon == $val->kode)
                                                <option selected="" value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                @else
                                                <option  value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tipe Angkutan</td>
                                        <td>
                                            <select name="tipe_angkutan" onchange="cari_nopol_kargo()" class="form-control tipe_angkutan chosen-select-width">
                                                <option value="0">Pilih - Tipe Angkutan</option>
                                                @foreach($tipe_angkutan as $val)
                                                @if($data->kode_tipe_angkutan == $val->kode)
                                                <option selected="" value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                @else
                                                <option  value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="kontrak_tr">
                                        <td class="kontrak_td disabled">
                                            <div class="checkbox checkbox-info checkbox-circle">
                                                @if($data->kontrak == true)
                                                <input checked="" onchange="centang()" class="kontrak_tarif" type="checkbox" name="kontrak_tarif">
                                                @else
                                                <input onchange="centang()" class="kontrak_tarif" type="checkbox" name="kontrak_tarif">
                                                @endif
                                                <label>
                                                    Kontrak
                                                </label>
                                            </div> 
                                        </td>
                                        <td style="padding-bottom: 0.1cm">
                                            <span class="input-group-btn">
                                               -
                                            </span>
                                        </td>
                                        
                                    </tr>
                                </table>
                            </form>
                            <form class="col-sm-6" style="margin-bottom: 80px">
                                <table class="table table-bordered table-striped tabel_detail">
                                    <tr>
                                        <td>Nopol</td>
                                        <td class="nopol_dropdown" colspan="3">
                                            <select name="tipe_kendaraan" class="form-control tipe_kendaraan chosen-select-width input-sm">
                                                <option></option>
                                            </select>
                                        </td>
                                   
                                    </tr>
                                    <tr>
                                        <td>Nama Subcon</td>
                                        <td colspan="3">
                                            <input type="text" readonly="" value="{{$subcon_detail->nama}}" class="nama_subcon_detail form-control input-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ritase</td>
                                        <td colspan="3">
                                            <select  name="ritase" class="form-control ritase chosen-select-width input-sm">
                                                @if($data->ritase == 'DRIVER')
                                                <option selected="" value="driver">Driver</option>
                                                <option value="driver_co">Driver & Co driver</option>
                                                @else
                                                <option value="driver">Driver</option>
                                                <option selected="" value="driver_co">Driver & Co driver</option>
                                                @endif
                                            </select>
                                        </td>
                                    </tr>
                                    
                                    <tr class="driver_tr">
                                        <td>Driver</td>
                                        <td colspan="3"><input type="text" value="{{$data->driver}}" name="driver" class="driver form-control input-sm"></td>
                                    </tr>
                                    <tr class="co_driver_tr" hidden="">
                                        <td>Co Driver</td>
                                        <td colspan="3"><input type="text" value="{{$data->co_driver}}" name="co_driver" class="co_driver form-control input-sm"></td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td colspan="3">
                                            <input type="text" name="keterangan_detail" value="{{$data->keterangan_tarif}}" class="keterangan_detail form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top: 0.4cm">Shuttle Periode</td>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" class="form-control ed_awal_shuttle" name="ed_awal_shuttle" value="{{carbon\carbon::parse($data->awal_shutle)->format('d/m/Y')}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" class="form-control ed_akhir_shuttle" name="ed_akhir_shuttle" value="{{carbon\carbon::parse($data->akhir_shutle)->format('d/m/Y')}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td style="padding-top: 0.4cm">Jumlah</td>
                                        <td>
                                            <input type="text" onkeyup="hitung()" class="form-control jumlah" name="jumlah" style="text-align:right" value="{{$data->jumlah}}">
                                            <input type="hidden" readonly="readonly" value="{{$data->acc_penjualan}}" class="form-control acc_penjualan" name="acc_penjualan" value="">
                                        </td>
                                        <td>Tarif Dasar</td>
                                        <td>
                                            <input type="text" class="form-control tarif_dasar_text" style="text-align:right" readonly="readonly" value="{{number_format($data->total, 2, ",", ".")}}">
                                            <input type="hidden" class="form-control tarif_dasar" name="tarif_dasar" style="text-align:right" readonly="readonly" value="{{$data->total}}">
                                            <input type="hidden" name="harga_master" class="harga_master" value="{{$data->tarif_dasar}}" >
                                            <input type="hidden" id="kode_tarif" name="kode_tarif" value="{{$data->kode_tarif}}">
                                            <input type="hidden" class="kcd_id" name="kcd_id" value="{{$data->kontrak_cus}}">
                                            <input type="hidden" class="kcd_dt" name="kcd_dt" value="{{$data->kontrak_cus_dt}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Discount</td>
                                        <td colspan="1">
                                            <input type="text" onkeyup="hitung()" value="{{number_format($data->diskon, 0, ",", ".")}}" name="discount" class=" form-control discount input-sm">

                                            <input type="hidden"  class=" form-control master_diskon input-sm" value="{{$diskon}}">
                                        </td>
                                        <td style="padding-top: 0.4cm">Satuan</td>
                                        <td>
                                            <input type="text" value="{{$data->kode_satuan}}" readonly="readonly" class="form-control satuan" name="satuan" value="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td colspan="3">
                                            <input type="text" readonly="" value="{{number_format($data->total_net, 2, ",", ".")}}" class="total_text form-control total input-sm">
                                            <input type="hidden" readonly="" value="{{$data->total_net}}" name="total" class=" form-control total input-sm">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <div class="col-sm-12" >
                            <form class="col-sm-6">
                                <table class="table table-bordered table-striped tabel_pengirim">
                                    <tr>
                                        <td align="center" colspan="2">
                                            <h3>Data Pengirim</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Marketing</td>
                                        <td>
                                            <select name="marketing" class="form-control marketing chosen-select-width">
                                                    <option value="0">Pilih - Marketing</option>
                                                @foreach($marketing as $val)
                                                @if($data->kode_marketing == $val->kode)
                                                    <option selected="" value="{{$val->kode}}">{{$val->nama}}</option>
                                                @else
                                                    <option  value="{{$val->kode}}">{{$val->nama}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Company Name</td>
                                        <td>
                                            <input type="text" name="company_pengirim" value="{{$data->company_name_pengirim}}" class="company_pengirim form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Nama</td>
                                        <td>
                                            <input type="text" name="nama_pengirim" value="{{$data->nama_pengirim}}" class="nama_pengirim form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Alamat</td>
                                        <td>
                                            <input type="text" name="alamat_pengirim" value="{{$data->alamat_pengirim}}" class="alamat_pengirim form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Kode Pos</td>
                                        <td>
                                            <input type="text" name="kode_pos_pengirim" value="{{$data->kode_pos_pengirim}}" class="kode_pos_pengirim form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Telpon</td>
                                        <td>
                                            <input type="text" name="telpon_pengirim"  value="{{$data->telpon_pengirim}}" class="telpon_pengirim form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="button" class="pull-right btn btn-danger ngeprint" style="margin-left: 30px">
                                                <i class="fa fa-print"> Print</i>
                                            </button>
                                            
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <form class="col-sm-6">
                                <table class="table table-bordered table-striped tabel_penerima">
                                    <tr>
                                        <td align="center" colspan="2">
                                            <h3>Data Penerima</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Company Name</td>
                                        <td>
                                            <input type="text" value="{{$data->company_name_penerima}}" name="company_" class="company_penerim form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Nama</td>
                                        <td>
                                            <input type="text" value="{{$data->nama_penerima}}" name="nama_penerima" class="nama_penerima form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Alamat</td>
                                        <td>
                                            <input type="text" value="{{$data->alamat_penerima}}" name="alamat_penerima" class="alamat_penerima form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Kab/Kota</td>
                                        <td>
                                            <input type="text" readonly="" value="" name="kota_penerima" class="kota_penerima form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Kode Pos</td>
                                        <td>
                                            <input type="text" name="kode_pos_penerima" value="{{$data->kode_pos_penerima}}" class="kode_pos_penerima form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Telpon</td>
                                        <td>
                                            <input type="text" name="telpon_penerima" value="{{$data->telpon_penerima}}" class="telpon_penerima form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Deskripsi</td>
                                        <td>
                                            <input type="text" name="deskripsi_penerima" value="{{$data->deskripsi}}" class="deskripsi_penerima form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Intruksi</td>
                                        <td>
                                            <input type="text" name="intruksi_penerima" value="{{$data->instruksi}}" class="intruksi_penerima form-control">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                <!-- modal -->
                <div id="modal_tarif" class="modal" >
                  <div class="modal-dialog" style="min-width: 800px;max-width: 800px">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Pilih Tarif</h4>
                      </div>
                      <div class="modal-body">
                            <form class="form-horizontal  modal_tarif">
                                
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btnsave">Save changes</button>
                          </div>
                    </div>
                  </div>
                </div>
                  <!-- modal -->
                <div class="box-footer">
                  <div class="pull-right">


                  </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>

<div id="data-jurnal">
</div>

<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
//tanggal do 
$('.tanggal_do').datepicker({
    format:'dd/mm/yyyy',
    endDate:'today'
})
$('.date').datepicker({
    format:'dd/mm/yyyy'
})

$('.status_kendaraan').change(function(){
    if ($(this).val() == 'OWN') {
        $('.nama_subcon_detail ').val('');
    }
})
//menentukan cabang
$(document).ready(function(){
   var cabang = $('.cabang_select').val();
   var jenis_tarif_do  = $('.jenis_tarif_do').val();
   $('.cabang_input').val(cabang);
   $('.jenis_tarif_do').val(jenis_tarif_do);
   $('.jenis_tarif_temp').val(jenis_tarif_do);
   $('.discount').maskMoney({precision:0,thousands:'.'});

    var status_kendaraan = $('.status_kendaraan').val();
    var nama_subcon      = $('.nama_subcon').val();
    var tipe_angkutan    = $('.tipe_angkutan').val();
    var cabang_select    = $('.cabang_select').val();
    
    $.ajax({
        url:baseUrl + '/sales/cari_nopol_kargo',
        data:{status_kendaraan,nama_subcon,tipe_angkutan,cabang_select},
        success:function(data){
            $('.nopol_dropdown').html(data);
        }
    })

    var tujuan =  $('.tujuan_do option:selected').text();
   

    tujuan     =  tujuan.split('-');
    $('.kota_penerima').val(tujuan[1]);

})
//hide unhide subcon
    if ($('.status_kendaraan').val() == 'SUB'){
        $('.nama_subcon_tr').attr('hidden',false);
    }else{
        $('.nama_subcon_tr').attr('hidden',true);
    }

//tujuan do
$('.tujuan_do').change(function(){
   var tujuan =  $('.tujuan_do option:selected').text();
   
   $('.tipe_angkutan').val(0).trigger('chosen:updated');

   tujuan     =  tujuan.split('-');
   $('.kota_penerima').val(tujuan[1]);
})

//membuat nopol
$('.buat_nopol').click(function(){
    window.open('{{route('form_kendaraan')}}');
});

//fungsi cari nopol
function cari_nopol_kargo() {
    var status_kendaraan = $('.status_kendaraan').val();
    var nama_subcon      = $('.nama_subcon').val();
    var tipe_angkutan    = $('.tipe_angkutan').val();
    var cabang_select    = $('.cabang_select').val();
    
    $.ajax({
        url:baseUrl + '/sales/cari_nopol_kargo',
        data:{status_kendaraan,nama_subcon,tipe_angkutan,cabang_select},
        success:function(data){
            $('.nopol_dropdown').html(data);
        }
    })
}
function reseting() {
    $('.satuan').val('');
    $('.tarif_dasar_text').val('');
    $('.tarif_dasar').val('');
    $('.harga_master').val('');
    $('.harga_master').val('');
    $('#kode_tarif').val('');
    $('.kcd_id').val('');
    $('.kcd_dt').val('');
    $('.total_text').val('0');
    $('.total').val('0');

    toastr.info('Data Diubah Mohon Memasukan Tarif Kembali')
}
// cari kontrak
function cari_kontrak() {
    var cabang      = $('.cabang_select').val();
    var customer_do = $('.customer').val();
     $.ajax({
        url:baseUrl + '/sales/cari_kontrak',
        data:{cabang,customer_do},
        dataType:'json',
        success:function(data){
            if (data.status == 1) {
                $('.kontrak_tarif').prop('checked',true);
                $('.discount ').addClass('disabled')
                $('.discount ').attr('readonly',true)
                // $('.kontrak_td').addClass('disabled');
            }else{
                $('.kontrak_tarif').prop('checked',false);
                // $('.kontrak_td').addClass('disabled');
                $('.discount ').removeClass('disabled')
                $('.discount ').attr('readonly',false)
            }

            $('.company_pengirim').val(data.data.nama);
            $('.nama_pengirim').val(data.data.nama);
            $('.alamat_pengirim').val(data.data.alamat);
            $('.telpon_pengirim').val(data.data.telpon);

            $('.satuan').val('');
            $('.tarif_dasar_text').val('');
            $('.tarif_dasar').val('');
            $('.harga_master').val('');
            $('.harga_master').val('');
            $('#kode_tarif').val('');
            $('.kcd_id').val('');
            $('.kcd_dt').val('');
            reseting();
        },
        error:function(){
        }
    })
}

// ganti nota untuk admin
function ganti_nota(argument) {
   var cabang = $('.cabang_select').val();
     $.ajax({
        url:baseUrl + '/sales/nomor_do_kargo',
        data:{cabang},
        dataType:'json',
        success:function(data){
            $('.nomor_do').val(data.nota);
            $('.satuan').val('');
            $('.tarif_dasar_text').val('');
            $('.tarif_dasar').val('');
            $('.harga_master').val('');
            $('.harga_master').val('');
            $('#kode_tarif').val('');
            $('.kcd_id').val('');
            $('.kcd_dt').val('');
            cari_nopol_kargo();
            cari_kontrak();
            reseting();
        },
        error:function(){
            location.reload();
        }
    })

    
}
//nama subcon
$('.nama_subcon').change(function(){
    var nama_subcon = $('.nama_subcon').val();
    $.ajax({
        url:baseUrl + '/sales/nama_subcon',
        data:{nama_subcon},
        dataType:'json',
        success:function(data){
            $('.nama_subcon_detail').val(data.nama);  
        }
    });
});
// jika check kontrak checked
function centang() {
    var check = $('.kontrak_tarif').is(':checked'); 
    var temp  = $('.jenis_tarif_temp').val();

    if (check == true) {
        $('.jenis_tarif_do').val(5).trigger('chosen:updated');
    }else{
        $('.jenis_tarif_do').val(temp).trigger('chosen:updated');
    }
}
//menghilangkan kontrak
$('.jenis_tarif_do').change(function(){
    if ($(this).val() == 9) {
        $('.kontrak_tr').attr('hidden',true);
        $('.harga_master').val(1);
        $('.discount ').attr('readonly',true);

    }else{      
        $('.kontrak_tr').attr('hidden',false);
        $('.jenis_tarif_temp').val($(this).val());
        $('.tarif_dasar').val(0);
        $('.discount ').attr('readonly',false);
    }
});

$('#btn_cari_tarif').click(function(){
    var check = $('.kontrak_tarif').is(':checked'); 
    var asal = $('.asal_do').val(); 
    var tujuan = $('.tujuan_do').val(); 
    var jenis_tarif = $('.jenis_tarif_do').val(); 
    var cabang_select = $('.cabang_select').val(); 
    var tipe_angkutan = $('.tipe_angkutan ').val(); 
    var tipe_angkutan = $('.tipe_angkutan ').val(); 
    var customer = $('.customer ').val(); 
    $.ajax({
        url:baseUrl + '/sales/cari_kontrak_tarif',
        data:{check,asal,tujuan,jenis_tarif,cabang_select,tipe_angkutan,customer },
        success:function(data){
            $('.modal_tarif').html(data);
            $('#modal_tarif').modal('show');
        },
        error:function(){
            toastr.warning('Periksa Kembali Data Anda');
        }
    })
});
//hitung
$('.jumlah').focus(function(){
    $('.jumlah').select();
})
function hitung() {
    var jumlah           = $('.jumlah').val();
    var tarif_dasar      = $('.harga_master').val();
    var tarif_dasar1      = $('.tarif_dasar').val();
    var discount         = $('.discount').val();
    var master_diskon    = $('.master_diskon').val();
    if (master_diskon == 'NONE') {
        master_diskon = 100;
    }
    discount        = discount.replace(/[^0-9\-]+/g,"");
    var temp        = 0;
    var temp1       = 0;
    jumlah          = parseInt(jumlah);
    tarif_dasar     = parseInt(tarif_dasar);
    discount        = parseInt(discount);
    if (discount == '') {
        discount = 0;
    }
    var max_diskon = parseInt(master_diskon)/100*tarif_dasar1;
    console.log(max_diskon);
    if (discount > max_diskon) {
        discount = max_diskon;
        $('.discount').val(discount);
        toastr.warning('MAX Diskon '+master_diskon+'%');
    }
    temp1           = jumlah * tarif_dasar;
    temp            = temp1  - discount;
    if (temp < 0) {
        temp = 0;
    }
        
    $('.total').val(temp);
    $('.total_text').val(accounting.formatMoney(temp,"",2,'.',','));
    $('.tarif_dasar_text').val(accounting.formatMoney(temp1,"",2,'.',','));
    $('.tarif_dasar').val(temp1);

}
// jika menggunakan tarif
function pilih_tarif(a) {
    var kode = $(a).find('.kode_tarif').val();

    $.ajax({
        url:baseUrl + '/sales/pilih_tarif_kargo',
        data:{kode},
        dataType:'json',
        success:function(response){
            $('.tarif_dasar_text').val(accounting.formatMoney(response.data.harga,"",2,'.',','));
            $('.tarif_dasar').val(response.data.harga);
            $('.harga_master').val(response.data.harga);
            $('.satuan').val(response.data.kode_satuan);
            $('.kcd_id').val(0);
            $('.kcd_dt').val(0);
            $('#kode_tarif').val(response.data.kode);
            $('.acc_penjualan').val(response.data.acc_penjualan);
            $('.jumlah').val(1);
            $('#modal_tarif').modal('hide');
            hitung();
        },
        error:function(){
            toastr.warning('Terjadi Kesalahan');
        }
    })
}
//jika menggunakan kontrak

function pilih_kontrak(a) {
    var kcd_id = $(a).find('.kcd_id').val();
    var kcd_dt = $(a).find('.kcd_dt').val();

    $.ajax({
        url:baseUrl + '/sales/pilih_kontrak_kargo',
        data:{kcd_id,kcd_dt},
        dataType:'json',
        success:function(response){
            $('.satuan').val(response.data.kcd_satuan);
            $('.tarif_dasar_text').val(accounting.formatMoney(response.data.kcd_harga,"",2,'.',','));
            $('.tarif_dasar').val(response.data.kcd_harga);
            $('.harga_master').val(response.data.kcd_harga);
            $('.kcd_id').val(response.data.kcd_id);
            $('.kcd_dt').val(response.data.kcd_dt);
            $('#kode_tarif').val(0);
            $('.acc_penjualan').val(response.data.kcd_acc_penjualan);
            $('.satuan').val(response.data.kcd_kode_satuan);
            $('.tipe_angkutan').val(response.data.kcd_kode_angkutan).trigger('chosen:updated');
            console.log($('.tipe_angkutan').val());
            $('.asal_do').val(response.data.kcd_kota_asal).trigger('chosen:updated');
            $('.tujuan_do').val(response.data.kcd_kota_tujuan).trigger('chosen:updated');
            $('.jumlah').val(1);
            var tujuan =  $('.tujuan_do option:selected').text();
   
            tujuan     =  tujuan.split('-');
            $('.kota_penerima').val(tujuan[1]);
            $('#modal_tarif').modal('hide');
            cari_nopol_kargo();
            toastr.info('Data Telah Dirubah Harap Periksa Kembali');
            hitung();

        },
        error:function(){
            toastr.warning('Terjadi Kesalahan');
        }
    })
}


// save

$('.save').click(function(){
   var cabang = $('.cabang_select').val();
   var customer = $('.customer').val();
   swal({
    title: "Apakah anda yakin?",
    text: "Simpan Delivery Order!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Simpan!",
    cancelButtonText: "Batal",
    closeOnConfirm: false
  },
  function(){
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      $.ajax({
      url:baseUrl + '/sales/update_do_kargo',
      type:'get',
      dataType:'json',
      data:$('.tabel_header :input').serialize()+'&'+
           $('.tabel_detail :input').serialize()+'&'+
           $('.tabel_penerima :input').serialize()+'&'+
           $('.tabel_pengirim :input').serialize()
           +'&cabang='+cabang
           +'&customer='+customer,
      success:function(response){
        if (response.status == 2) {
            swal({
                title: "Berhasil!",
                type: 'success',
                text: "Data berhasil disimpan dengan nomor resi "+response.nota,
                timer: 900,
               showConfirmButton: true
                },function(){
                    $('.nomor_do').val(response.nota);
                    $('.save').addClass('disabled');
                    $('.ngeprint').removeClass('disabled');
                    $('.nomor_print').val(response.nota);
            });
        }else if (response.status == 1){
            swal({
            title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){
                       // window.location.href='../deliveryorderkargo';
                    $('.save').addClass('disabled');
                    $('.ngeprint').removeClass('disabled');
                    $('.nomor_print').val(response.nota);
                    // $('#seragam_box').addClass('disabled');
                       
            });
        }else{
            swal({
                title: "Harap Lengkapi Data Anda",
                type: 'warning',
                timer: 900,
                showConfirmButton: true

            });
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
});
$('.reload').click(function(){
    location.reload();
});


$('.ritase').change(function(){
    var ini = $(this).val();
    console.log(ini);
    if (ini == 'driver') {
        $('.driver_tr').attr('hidden',false);
        $('.co_driver_tr').attr('hidden',true);
    }else{
        $('.driver_tr').attr('hidden',false);
        $('.co_driver_tr').attr('hidden',false);
    }
});

// ngeprint
$('.ngeprint').click(function(){
    var print = $('.nomor_print').val();

    window.open('{{ url('sales/deliveryorderkargoform/nota')}}'+'/'+print);
})
</script>
@endsection
