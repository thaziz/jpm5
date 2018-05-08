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
.tabel_tarif tbody tr{
    cursor: pointer;
}
.form-control{
    text-transform: uppercase;
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
                     <a href="../sales/deliveryorderkargo" class="pull-right" style="color: grey; float: right;"><i class="fa fa-arrow-left"> Kembali</i></a>
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
                                            <input style="text-transform: uppercase;" type="text" name="nomor_do" class="nomor_do new_do form-control input-sm">
                                            <input style="text-transform: uppercase;" type="hidden" name="nomor_do" class="nomor_do old_do form-control input-sm">
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
                                        <td><input type="text" name="nomor_do_awal" class="nomor_do_awal form-control input-sm"></td>
                                    </tr>
                                    <tr>
                                        <td>No Surat Jalan</td>
                                        <td>
                                            <input type="text" name="surat_jalan" class="surat_jalan form-control input-sm">
                                            <input type="hidden" name="nomor_print" class="nomor_print form-control input-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cabang</td>
                                        <td>

                                            @if(Auth::user()->punyaAkses('Delivery Order','cabang'))
                                                <select onchange="ganti_nota()" class="form-control cabang_select">
                                                @foreach($cabang as $val)
                                                    @if(Auth()->user()->kode_cabang == $val->kode)
                                                    <option selected="" value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                    @else
                                                    <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                    @endif
                                                @endforeach
                                                </select>
                                            @else
                                                <select disabled="" class="form-control cabang_select">
                                                @foreach($cabang as $val)
                                                @if(Auth::user()->kode_cabang == $val->kode)
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
                                        <td class="customer_td">
                                            <div >
                                                <select onchange="cari_kontrak()" class="form-control customer chosen-select-width" name="customer">
                                                <option value="0">Pilih - Customer</option>
                                                @foreach($customer as $val)
                                                    @foreach($kota as $i)
                                                    @if($val->kota == $i->id)
                                                    <option value="{{$val->kode}}">{{$val->kode}}-{{$val->nama}}-{{$i->nama}}</option>
                                                    @endif
                                                    @endforeach
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
                                                <option value="{{$val->id}}">{{$val->id}}-{{$val->nama}}</option>
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
                                                <option value="{{$val->id}}">{{$val->id}}-{{$val->nama}}</option>
                                            @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Tarif</td>
                                        <td>
                                            <select name="jenis_tarif_do" onchange="cari_nopol_kargo()" class="form-control jenis_tarif_do chosen-select-width">
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
                                                <option value="SUB">SUBCON</option>
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
                                    <tr class="kontrak_tr">
                                        <td class="kontrak_td disabled">
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
                                        
                                    </tr>
                                </table>
                            </form>
                            <form class="col-sm-6" style="margin-bottom: 80px">
                                <table class="table table-bordered table-striped tabel_detail">
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
                                        <td>Ritase</td>
                                        <td colspan="3">
                                            <select  name="ritase" class="form-control ritase chosen-select-width input-sm">
                                                <option value="driver">Driver</option>
                                                <option value="driver_co">Driver & Co driver</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="driver_tr">
                                        <td>Driver</td>
                                        <td colspan="3"><input type="text" name="driver" class="driver form-control input-sm"></td>
                                    </tr>
                                    <tr class="co_driver_tr" hidden="">
                                        <td>Co Driver</td>
                                        <td colspan="3"><input type="text" name="co_driver" class="co_driver form-control input-sm"></td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td colspan="3">
                                            <input type="text" name="keterangan_detail" style="text-transform: uppercase;" class="keterangan_detail form-control">
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
                                    

                                    <tr>
                                        <td style="padding-top: 0.4cm">Jumlah</td>
                                        <td>
                                            <input type="text" onkeyup="hitung()" class="form-control jumlah" name="jumlah" style="text-align:right" value="0">
                                            <input type="hidden" readonly="readonly" class="form-control acc_penjualan" name="acc_penjualan" value="">
                                        </td>
                                        <td>Tarif Dasar</td>
                                        <td>
                                            <input type="text" class="form-control tarif_dasar_text" style="text-align:right" readonly="readonly" value="0">
                                            <input type="hidden" class="form-control tarif_dasar" name="tarif_dasar" style="text-align:right" readonly="readonly" value="0">
                                            <input type="hidden" name="harga_master" class="harga_master" >
                                            <input type="hidden" id="kode_tarif" name="kode_tarif">
                                            <input type="hidden" class="kcd_id" name="kcd_id">
                                            <input type="hidden" class="kcd_dt" name="kcd_dt">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Biaya Tambahan</td>
                                        <td colspan="3">
                                            <input type="text" onkeyup="hitung()" value="0" name="biaya_tambahan" class=" form-control biaya_tambahan input-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Discount</td>
                                        <td colspan="">
                                            <input type="text" onkeyup="hitung()" value="0" name="discount" class=" form-control discount input-sm">
                                            <input type="hidden" value="" class=" form-control master_diskon input-sm">
                                        </td>
                                        <td style="padding-top: 0.4cm" colspan="">Satuan</td>
                                        <td>
                                            <input type="text" readonly="readonly" class="form-control satuan" name="satuan" value="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td colspan="3">
                                            <input type="text" readonly="" value="0" class="total_text form-control  input-sm">
                                            <input type="hidden" readonly="" value="0" name="total" class=" form-control total input-sm">
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
                                            <button type="button" class="pull-right btn btn-danger disabled ngeprint" style="margin-left: 30px">
                                                <i class="fa fa-print"> Print</i>
                                            </button>
                                            <button type="button" class="pull-right btn btn-primary save">
                                                <i class="fa fa-save"> Simpan</i>
                                            </button>
                                            <button type="button" class="pull-right btn btn-warning reload" style="margin-right: 30px">
                                                <i class="fa fa-refresh"> Reload</i>
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
                                            <input type="text" readonly="" name="kota_penerima" class="kota_penerima form-control">
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
//menentukan cabang
$(document).ready(function(){
   var cabang = $('.cabang_select').val();
   var jenis_tarif_do  = $('.jenis_tarif_do').val();
   $('.cabang_input').val(cabang);
   $('.jenis_tarif_do').val(jenis_tarif_do);
   $('.jenis_tarif_temp').val(jenis_tarif_do);
   $('.discount').maskMoney({precision:0,thousands:'.',allowZero:true,defaultZero: true});
   $('.biaya_tambahan').maskMoney({precision:0,thousands:'.',allowZero:true,defaultZero: true});
   $.ajax({
        url:baseUrl + '/sales/nomor_do_kargo',
        data:{cabang},
        dataType:'json',
        success:function(data){
            $('.nomor_do').val(data.nota);
            $('.master_diskon').val(data.diskon);
        },
        error:function(){
            location.reload();
        }
    })
})

//hide unhide subcon
$('.status_kendaraan').change(function(){
    if ($(this).val() == 'SUB'){
        $('.nama_subcon_tr').attr('hidden',false);
    }else{
        $('.nama_subcon_tr').attr('hidden',true);
    }
});

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
$('.status_kendaraan').change(function(){
    if ($(this).val() == 'OWN') {
        $('.nama_subcon_detail ').val('');
    }
})

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
    var new_do = $('.new_do').val();
    var old_do = $('.old_do').val();

    if (new_do == old_do) {
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
                $('.master_diskon').val(data.diskon);
                cari_nopol_kargo();
                cari_kontrak();
                reseting();
            },
            error:function(){
                location.reload();
            }
        })
    }
    
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
        reseting(); 
        $('.kontrak_tr').attr('hidden',true);
        $('.tarif_dasar').val(1);
        $('.harga_master').val(1);
        $('#kode_tarif').val(0);
        $('.kcd_id').val(0);
        $('.kcd_dt').val(0);
        $('.satuan').val('RP');
        $('.discount ').attr('readonly',true);

    }else{      
        $('.kontrak_tr').attr('hidden',false);
        $('.jenis_tarif_temp').val($(this).val());
        $('.tarif_dasar').val(0);
        $('.discount ').attr('readonly',false);
        reseting(); 
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
    var tarif_dasar1     = $('.tarif_dasar').val();
    var discount         = $('.discount').val();
    var biaya_tambahan   = $('.biaya_tambahan').val();
    var master_diskon    = $('.master_diskon').val();
    if (master_diskon == 'NONE') {
        master_diskon = 100;
    }
    discount        = discount.replace(/[^0-9\-]+/g,"");
    biaya_tambahan  = biaya_tambahan.replace(/[^0-9\-]+/g,"");
    var temp        = 0;
    var temp1       = 0;
    jumlah          = parseInt(jumlah);
    tarif_dasar     = parseInt(tarif_dasar);
    discount        = parseInt(discount);
    biaya_tambahan  = parseInt(biaya_tambahan);
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
    temp            = temp1  - discount + biaya_tambahan;
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
      url:baseUrl + '/sales/save_do_kargo',
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
                       // window.location.href='../sales/deliveryorderkargo';
                    $('.save').addClass('disabled');
                    $('.ngeprint').removeClass('disabled');
                    $('.nomor_print').val(response.nota);
                    // $('#seragam_box').addClass('disabled');
                       
            });
            
        }else if (response.status == 4) {
                swal({
                    title: "Akun Piutang Untuk Cabang Ini Belum Tersedia",
                            type: 'error',
                            timer: 900,
                            showConfirmButton: true

                });
        }else{
            swal({
                title: "Data "+response.text+" Harus Diisi",
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
