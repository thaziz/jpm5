@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
.id {display:none; }
.cssright { text-align: right; }

.disabled {
    pointer-events: none;
    opacity: 1;
}
.center{
    text-align: center;
}
</style>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> INVOICE DETAIL
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <a href="../sales/invoice" class="pull-right" style="color: grey; float: right;"><i class="fa fa-arrow-left"> Kembali</i></a>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                        <div class="col-sm-12">
                            <form class="col-sm-6"> 
                                <table class="table table-bordered tabel-header table-striped"> 
                                    <tr>
                                        <td>Nomor</td>
                                        <td><input type="text" name="nomor_do" class="nomor_do form-control input-sm"></td>
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
                                        <td><input type="text" name="nomor_do_awal" class="nomor_do_awal form-control input-sm"></td>
                                    </tr>
                                    <tr>
                                        <td>No Surat Jalan</td>
                                        <td><input type="text" name="surat_jalan" class="surat_jalan form-control input-sm"></td>
                                    </tr>
                                    <tr>
                                        <td>Cabang</td>
                                        <td>
                                            <select disabled="" class="form-control cabang_select">
                                            @foreach($cabang as $val)
                                                @if(Auth::user()->kode_cabang == $val->kode)
                                                <option selected value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                @else
                                                <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                            <input type="hidden" name="cabang_input" class="cabang_input form-control input-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Customer</td>
                                        <td>
                                            <select class="form-control customer_do chosen-select-width" name="customer_do">
                                                <option value="0">Pilih - Customer</option>
                                            @foreach($customer as $val)
                                                <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                            @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kota Asal</td>
                                        <td>
                                            <select name="asal_do" class="form-control asal_do chosen-select-width">
                                                <option value="0">Pilih - Kota Asal</option>
                                            @foreach($kota as $val)
                                                <option value="{{$val->id}}">{{$val->id}} - {{$val->nama}}</option>
                                            @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kota Tujuan</td>
                                        <td>
                                            <select name="tujuan_do" class="form-control tujuan_do chosen-select-width">
                                                <option value="0">Pilih - Kota Tujuan</option>
                                            @foreach($kota as $val)
                                                <option value="{{$val->id}}">{{$val->id}} - {{$val->nama}}</option>
                                            @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Tarif</td>
                                        <td>
                                            <select name="jenis_tarif_do" class="form-control jenis_tarif_do chosen-select-width">
                                            @foreach($jenis_tarif as $val)
                                                <option value="{{$val->jt_id}}">{{$val->jt_nama_tarif}}</option>
                                            @endforeach
                                            </select>
                                            <input type="hidden" class="jenis_tarif_temp">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status Kendaraan</td>
                                        <td>
                                            <select name="status_kendaraan" onchange="cari_nopol_kargo()" class="form-control status_kendaraan chosen-select-width">
                                                <option value="OWN">OWN</option>
                                                <option value="SUB">SUB</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="nama_subcon_tr" hidden="">
                                        <td>Nama Subcon</td>
                                        <td>
                                            <select name="nama_subcon" onchange="cari_nopol_kargo()" class="form-control nama_subcon chosen-select-width">
                                                <option value="0">Pilih - Subcon</option>
                                                @foreach($subcon as $i=>$val)
                                                <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
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
                                                    <option value="{{$val->kode}}">{{$val->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <form class="col-sm-6" style="margin-bottom: 80px">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td>Nopol</td>
                                        <td class="nopol_dropdown" colspan="2">
                                            <select name="tipe_kendaraan" class="form-control tipe_kendaraan chosen-select-width input-sm">
                                                <option></option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class=" buat_nopol btn btn-warning"><i class="fa fa-car"> Buat Nopol</i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nama Subcon</td>
                                        <td colspan="3"><input type="text" readonly="" class="nama_subcon_detail form-control input-sm"></td>
                                    </tr>
                                    <tr>
                                        <td>Driver</td>
                                        <td colspan="3"><input type="text" name="driver" class="driver form-control input-sm"></td>
                                    </tr>
                                    <tr>
                                        <td>Co Driver</td>
                                        <td colspan="3"><input type="text" name="co_driver" class="co_driver form-control input-sm"></td>
                                    </tr>
                                    <tr>
                                        <td>Ritase</td>
                                        <td colspan="3">
                                            <select name="ritase" class="form-control ritase chosen-select-width input-sm">
                                                <option value="driver">Driver</option>
                                                <option value="driver_co">Driver & Co driver</option>
                                            </select>
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
                                                        <input type="text" class="form-control ed_awal_shuttle" name="ed_awal_shuttle" value="{{$now}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" class="form-control ed_akhir_shuttle" name="ed_akhir_shuttle" value="{{$bulan_depan}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="kontrak_tr">
                                        <td>
                                            <div class="checkbox checkbox-info checkbox-circle">
                                                <input onchange="centang()" class="kontrak_tarif" type="checkbox" name="kontrak_tarif">
                                                <label>
                                                    Kontrak
                                                </label>
                                            </div> 
                                        </td>
                                        <td style="padding-bottom: 0.1cm">
                                            <span class="input-group-btn">
                                                <button type="button" id="btn_cari_tarif" class="btn btn-primary">
                                                    Search Tarif
                                                </button>
                                            </span>
                                        </td>
                                        <td style="padding-top: 0.4cm">Satuan</td>
                                        <td>
                                            <input type="text" readonly="readonly" class="form-control satuan" name="satuan" value="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top: 0.4cm">Jumlah</td>
                                        <td>
                                            <input type="text" class="form-control jumlah" name="jumlah" style="text-align:right" value="0">
                                            <input type="hidden" readonly="readonly" class="form-control acc_penjualan" name="acc_penjualan" value="">
                                        </td>
                                        <td>Tarif Dasar</td>
                                        <td>
                                            <input type="text" class="form-control tarif_dasar" name="tarif_dasar" style="text-align:right" readonly="readonly" value="0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Discount</td>
                                        <td colspan="3">
                                            <input type="text" value="0" name="discount" class=" form-control discount input-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td colspan="3">
                                            <input type="text" readonly="" value="0" name="total" class=" form-control total input-sm">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <div class="col-sm-12" >
                            <form class="col-sm-6">
                                <table class="table table-bordered table-striped" >
                                    <tr>
                                        <td align="center" colspan="2">
                                            <h3>Data Pengirim</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Marketing</td>
                                        <td>
                                            <select name="marketing" class="form-control marketing chosen-select-width">
                                                @foreach($marketing as $val)
                                                    <option value="{{$val->kode}}">{{$val->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Company Name</td>
                                        <td>
                                            <input type="text" name="company_pengirim" class="company_pengirim form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Nama</td>
                                        <td>
                                            <input type="text" name="nama_pengirim" class="nama_pengirim form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Alamat</td>
                                        <td>
                                            <input type="text" name="alamat_pengirim" class="alamat_pengirim form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Kode Pos</td>
                                        <td>
                                            <input type="text" name="kode_pos_pengirim" class="kode_pos_pengirim form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Telpon</td>
                                        <td>
                                            <input type="text" name="telpon_pengirim" class="telpon_pengirim form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button class="pull-right btn btn-primary save">
                                                <i class="fa fa-save"> Simpan</i>
                                            </button>
                                            <button class="pull-right btn btn-warning reload" style="margin-right: 30px">
                                                <i class="fa fa-refresh"> Reload</i>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <form class="col-sm-6">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td align="center" colspan="2">
                                            <h3>Data Penerima</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Company Name</td>
                                        <td>
                                            <input type="text" name="company_" class="company_penerim form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Nama</td>
                                        <td>
                                            <input type="text" name="nama_penerima" class="nama_penerima form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Alamat</td>
                                        <td>
                                            <input type="text" name="alamat_penerima" class="alamat_penerima form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Kab/Kota</td>
                                        <td>
                                            <input type="text" name="kota_penerima" class="kota_penerima form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Kode Pos</td>
                                        <td>
                                            <input type="text" name="kode_pos_penerima" class="kode_pos_penerima form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Telpon</td>
                                        <td>
                                            <input type="text" name="telpon_penerima" class="telpon_penerima form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Deskripsi</td>
                                        <td>
                                            <input type="text" name="deskripsi_penerima" class="deskripsi_penerima form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:110px; padding-top: 0.4cm">Intruksi</td>
                                        <td>
                                            <input type="text" name="intruksi_penerima" class="intruksi_penerima form-control">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                <!-- modal -->
                <div id="modal_tarif" class="modal" >
                  <div class="modal-dialog">
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
//menentukan cabang
$(document).ready(function(){
   var cabang = $('.cabang_select').val();
   var jenis_tarif_do  = $('.jenis_tarif_do').val();
   $('.cabang_input').val(cabang);
   $('.jenis_tarif_do').val(jenis_tarif_do);
   $('.jumlah').maskMoney({precision:0});
   $('.jenis_tarif_temp').val(jenis_tarif_do);
})
//hide unhide subcon
$('.status_kendaraan').change(function(){
    if ($(this).val() == 'SUB'){
        $('.nama_subcon_tr').attr('hidden',false);
    }else{
        $('.nama_subcon_tr').attr('hidden',true);
    }
});
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
            console.log(data);
            $('.nopol_dropdown').html(data);
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
        $('.tarif_dasar').val(1);
    }else{      
        $('.kontrak_tr').attr('hidden',false);
        $('.jenis_tarif_temp').val($(this).val());
        $('.tarif_dasar').val(0);
    }
});

$('#btn_cari_tarif').click(function(){
    var check = $('.kontrak_tarif').is(':checked'); 
    var asal = $('.asal_do').val(); 
    var tujuan = $('.tujuan_do').val(); 
    var jenis_tarif = $('.jenis_tarif_do').val(); 
    var cabang_select = $('.cabang_select').val(); 
    var tipe_angkutan = $('.tipe_angkutan ').val(); 
    $.ajax({
        url:baseUrl + '/sales/cari_kontrak_tarif',
        data:{check,asal,tujuan,jenis_tarif,cabang_select,tipe_angkutan },
        success:function(data){
            $('.modal_tarif').html(data);
        },
        error:function(){
            toastr.warning('Periksa Kembali Data Anda');
        }
    })
});
</script>
@endsection
