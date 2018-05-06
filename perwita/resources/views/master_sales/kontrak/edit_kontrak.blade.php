@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
      .id {display:none; }
      .center {text-align:center; }
      .lebar {width:150px }
      .right{text-align: right;}
    </style>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> KONTRAK
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <a href="../kontrak" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                <form id="form_header" class="form-horizontal">
                    <table class="table table-striped table-bordered table-hover">
                        {{csrf_field()}}
                        <tbody>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Nomor</td>
                                <td colspan="3">
                                    <input type="text" name="kontrak_nomor" value="{{$data->kc_nomor}}" id="ed_nomor" readonly="readonly" class="form-control" style="text-transform: uppercase" >
                                    <input type="hidden" readonly="readonly" class="form-control success" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td colspan="3">
                                    <input type="text" class="form-control tgl" name="ed_tanggal" value="{{Carbon\Carbon::parse($data->kc_tanggal)->format('d/m/Y')}}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Mulai</td>
                                <td >
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" class="tgl1 form-control" name="ed_mulai" value="{{Carbon\Carbon::parse($data->kc_mulai)->format('d/m/Y')}}">
                                    </div>
                                </td>
                                <td style="padding-top: 0.4cm">Berakhir</td>
                                <td>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="tgl2 form-control" name="ed_akhir" value="{{Carbon\Carbon::parse($data->kc_akhir)->format('d/m/Y')}}">
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td colspan="3">
                                    <select class="form-control cabang chosen-select-width" disabled="" name="cabang" >
                                      <option selected="" disabled="">- Pilih Cabang -</option>
                                      @foreach($cabang as $val)
                                      @if($data->kc_kode_cabang== $val->kode)
                                      <option selected="" value="{{$val->kode}}">{{$val->kode}}-{{$val->nama}}</option>
                                      @else
                                      <option  value="{{$val->kode}}">{{$val->kode}}-{{$val->nama}}</option>
                                      @endif
                                      @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Customer</td>
                                <td colspan="3">
                                    <input type="text" class="form-control" readonly="" value="{{$data->kc_kode_customer}}- {{$data->nama}} - {{$data->nama_kota}}">
                                    <input type="hidden" readonly="" name="customer" class="customer" id="customer" value="{{$data->kc_kode_customer}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td colspan="3">
                                    <input type="text" name="ed_keterangan" class="form-control ed_keterangan" style="text-transform: uppercase" value="{{$data->kc_keterangan}}" >
                                </td>
                            </tr>
                            <tr>
                                <td>Aktif</td>
                                <td colspan="3">
                                    @if($data->kc_aktif == 'AKTIF')
                                    <input type="checkbox" name="ck_aktif" checked="">
                                    @else
                                    <input type="checkbox" name="ck_aktif">
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info " id="btnadd" name="btnadd" >
                                <i class="glyphicon glyphicon-plus"></i>Tambah</button>
                        </div>


                    </div>
                </form>
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Jenis Tarif</th>
                            <th>Satuan</th>
                            <th>Tipe Angkutan</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                            @if(Auth::user()->punyaAkses('Verifikasi','aktif'))
                            <th>Active</th>
                            @endif
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <!-- modal -->

                  <!-- modal -->
                <div id="modal_customer" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Kontrak Customer</h4>
                      </div>
                      <div class="modal-body">
                        <table class="table table_modal table-striped">
                            <tr>
                                <td>Kota Asal</td>
                                <td>
                                    <select class="kota_asal_modal form-control chosen-select-width" name="asal_modal">
                                        <option value="0">Pilih - Asal</option>
                                        @foreach($kota as $val)
                                        <option value="{{$val->id}}">{{$val->id}} - {{$val->nama}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <input type="hidden" class="id_detail" name="id_detail">
                            </tr>
                            <tr>
                                <td>Kota Tujuan</td>
                                <td>
                                    <select class="kota_tujuan_modal form-control chosen-select-width" name="tujuan_modal">
                                        <option value="0">Pilih - Tujuan</option>
                                        @foreach($kota as $val)
                                        <option value="{{$val->id}}">{{$val->id}} - {{$val->nama}}</option>
                                        @endforeach
                                    </select>   
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis</td>
                                <td>
                                    <select class="jenis_modal form-control chosen-select-width" name="jenis_modal">
                                        <option value="0">Pilih - Jenis</option>
                                        <option value="PAKET">PAKET</option>
                                        <option value="KORAN">KORAN</option>
                                        <option value="KARGO">KARGO</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="grup_item_tr">
                                <td>Grup Item</td>
                                <td>
                                    <select class="form-control chosen-select-width cb_grup_item"  name="grup_item_modal" style="width:100%">
                                        <option value="0"> Pilih - Group </option>
                                    @foreach ($grup_item as $row)
                                        <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                    @endforeach
                                    </select>
                                <td>
                            </tr>
                            <tr class="type_tarif_tr">
                                <td>Tipe Tarif</td>
                                <td>
                                    <select class="type_tarif_modal form-control chosen-select-width" name="tipe_tarif_modal">
                                        <option value="0">Pilih - Jenis</option>
                                        <option value="DOKUMEN">DOKUMEN</option>
                                        <option value="KOLI">KOLI</option>
                                        <option value="KILO">KILO</option>
                                        <option value="SEPEDA">SEPEDA</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis Tarif</td>
                                <td>
                                    <select class="jenis_tarif_modal form-control chosen-select-width" name="jenis_tarif_modal">
                                        <option value="0">Pilih - Jenis Tarif</option>
                                        @foreach($jenis_tarif as $val)
                                        <option value="{{$val->jt_id}}">{{$val->jt_nama_tarif}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Tipe Angkutan</td>
                                <td>
                                    <select name="tipe_angkutan_modal" class="form-control tipe_angkutan_modal chosen-select-width" >
                                        <option value="0">Pilih - Tipe Angkutan</option>
                                        @foreach($tipe_angkutan as $val)
                                            <option value="{{$val->kode}}">{{$val->nama}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Harga</td>
                                <td>
                                    <input class="form-control harga_modal" type="text" style="text-align: right" name="harga_modal">
                                </td>
                            </tr>
                            <tr>
                                <td>Satuan</td>
                                <td>
                                    <select class="satuan_modal form-control chosen-select-width" name="satuan_modal">
                                        <option value="0">Pilih - Satuan</option>
                                        @foreach($satuan as $val)
                                        <option value="{{$val->kode}}">{{$val->nama}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>
                                    <input class="form-control keterangan_modal" type="text" name="keterangan_modal">
                                </td>
                            </tr>
                            <tr >
                                <td>Acc Penjualan</td>
                                <td class="acc_tr">
                                    <select class="acc_akun_modal form-control chosen-select-width" name="acc_akun_modal">
                                        <option></option>
                                    </select>
                                </td>
                            </tr>
                            <tr >
                                <td>CSF Penjualan</td>
                                <td class="csf_tr">
                                    <select class="csf_akun_modal form-control chosen-select-width" name="csf_akun_modal">
                                        <option></option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="tambah()">Simpan</button>
                      </div>
                    </div>

                  </div>
                </div>
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



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
  $('.tgl').datepicker({
    format:'dd/mm/yyyy'
  });
  $('.tgl1').datepicker({
    format:'dd/mm/yyyy'
  });
  $('.tgl2').datepicker({
    format:'dd/mm/yyyy'

  });

 $(document).ready( function () {
            
    $('.harga_modal').maskMoney({precision:0});
    var asd = $('.harga').maskMoney({thousands:',', precision:0});
    var cabang = $('.cabang').val();

    var config2 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width'     : {width:"100%"}
             }
             for (var selector in config2) {
               $(selector).chosen(config2[selector]);
             }


    $.ajax({
        url:baseUrl +'/master_sales/set_kode_akun_acc',
        data:{cabang},
        success:function(response){
            $('.acc_tr').html(response);
        },
        error:function(){
            location.reload();
        }
    });

    $.ajax({
        url:baseUrl +'/master_sales/set_kode_akun_csf',
        data:{cabang},
        success:function(response){
            $('.csf_tr').html(response);
        },
        error:function(){
            location.reload();
        }
    });

     var nota = $('#ed_nomor').val();
     $('#table_data').DataTable({
                  processing: true,
                  serverSide: true,
                  ajax: {
                      url:'{{ route('datatable_kontrak') }}',
                      data:{nota: function() { return $('#ed_nomor').val() }}
                  },
                  columnDefs: [
                
                  {
                     targets: 0 ,
                     className: 'center kcd_dt'
                  },
                  {
                     targets: 6 ,
                     className: 'right'
                  },
                  {
                     targets: 8 ,
                     className: 'center'
                  },
                  {
                     targets: 9 ,
                     className: 'center'
                  },
                  {
                     targets: 1 ,
                     className: 'lebar'
                  },
                  {
                     targets: 2 ,
                     className: 'lebar'
                  },
               
                ],
                columns: [
                    {data: 'kcd_dt', name: 'kcd_dt'},
                    {data: 'asal', name: 'asal'},
                    {data: 'tujuan', name: 'tujuan'},
                    {data: 'kcd_jenis', name: 'kcd_jenis'},
                    {data: 'kcd_kode_satuan', name: 'kcd_kode_satuan'},
                    {data: 'angkutan', name: 'angkutan'},
                    {data: 'harga', name: 'harga'},
                    {data: 'kcd_keterangan', name: 'kcd_keterangan'},
                    {data: 'active', name: 'active'},
                    {data: 'aksi', name: 'aksi'}
                ]

            });
});

$('#btnadd').click(function(){

    var cabang = $('.cabang').val();
    var customer= $('.customer').val();
    var harga_modal              = $('.harga_modal').val(0);
    var keterangan_modal         = $('.keterangan_modal ').val('');
    var kota_asal_modal          = $('.kota_asal_modal').val(0).trigger('chosen:updated');
    var kota_tujuan_modal        = $('.kota_tujuan_modal ').val(0).trigger('chosen:updated');
    var jenis_modal              = $('.jenis_modal').val(0).trigger('chosen:updated');
    var jenis_tarif_modal        = $('.jenis_tarif_modal').val(0).trigger('chosen:updated');
    var acc_akun_modal           = $('.acc_akun_modal ').val(0).trigger('chosen:updated');
    var type_tarif_modal         = $('.type_tarif_modal ').val(0).trigger('chosen:updated');
    var csf_akun_modal           = $('.csf_akun_modal').val(0).trigger('chosen:updated');
    var satuan_modal             = $('.satuan_modal').val(0).trigger('chosen:updated');
    var customer                 = $('.customer').val();
    var ed_keterangan            = $('.ed_keterangan').val();
    var cb_grup_item             = $('.cb_grup_item').val('0').trigger('chosen:updated');
    var validasi                 = [];
    var id_detail                = $('.id_detail').val(0);
    if (cabang == '0') {
        return toastr.warning('Cabang Harus Diisi');
    }
    if (customer == '0') {
        return toastr.warning('Customer Harus Diisi');
    }

    if (customer != 0) {
        validasi.push(1);
    }else{
        validasi.push(0);
    }

    if (ed_keterangan != '') {
        validasi.push(1);
    }else{
        validasi.push(0);
    }
    var index = validasi.indexOf(0)
    if (index == -1) {
        $('#modal_customer').modal('show');  
    }else{
        toastr.warning("Harap Periksa Data Anda Kembali");
    }


});
$('.jenis_modal').change(function(){
    if ($(this).val() == 'PAKET') {
        $('.type_tarif_tr').attr('hidden',false);
        $('.grup_item_tr').prop('hidden',true);
    }else if($(this).val() == 'KORAN'){
        $('.grup_item_tr').prop('hidden',false);
        $('.type_tarif_tr').prop('hidden',true);
        $('.type_tarif_modal').val(0).trigger('chosen:updated');
    }else{
        $('.type_tarif_modal').val(0).trigger('chosen:updated');
        $('.type_tarif_tr').attr('hidden',true);
        $('.grup_item_tr').prop('hidden',true);
    }
});




var count = 1;
function tambah(){
var cabang = $('.cabang').val();
var customer= $('.customer').val();
var kota_asal_modal_text     = $('.kota_asal_modal  option:selected').text();
var kota_tujuan_modal_text   = $('.kota_tujuan_modal  option:selected').text();
var jenis_modal_text         = $('.jenis_modal option:selected').text();
var jenis_tarif_modal_text   = $('.jenis_tarif_modal option:selected').text();
var acc_akun_modal_text      = $('.acc_akun_modal option:selected ').text();
var csf_akun_modal_text      = $('.csf_akun_modal option:selected').text();
var satuan_modal_text        = $('.satuan_modal option:selected').text();
var tipe_angkutan_text       = $('.tipe_angkutan_modal option:selected').text();
var id_detail                = $('.id_detail').val();
var harga_modal              = $('.harga_modal').val();
var keterangan_modal         = $('.keterangan_modal ').val();
var kota_asal_modal          = $('.kota_asal_modal').val();
var type_tarif_modal         = $('.type_tarif_modal').val();
var kota_tujuan_modal        = $('.kota_tujuan_modal ').val();
var jenis_modal              = $('.jenis_modal').val();
var jenis_tarif_modal        = $('.jenis_tarif_modal').val();
var acc_akun_modal           = $('.acc_akun_modal ').val();
var csf_akun_modal           = $('.csf_akun_modal').val();
var satuan_modal             = $('.satuan_modal').val();
var tipe_angkutan            = $('.tipe_angkutan_modal').val();
var cb_grup_item             = $('.cb_grup_item').val();
var nota                     = $('#ed_nomor').val();

if (kota_asal_modal == '0') {
    return toastr.warning('Kota Asal Harus Diisi');
}
if (kota_tujuan_modal == '0') {
    return toastr.warning('Kota Tujuan Harus Diisi');
}
if (kota_tujuan_modal == '0') {
    return toastr.warning('Kota Tujuan Harus Diisi');
}
if (jenis_modal == '0') {
    return toastr.warning('Jenis Harus Diisi');
}
if (jenis_tarif_modal == '0') {
    return toastr.warning('Jenis Tarif Harus Diisi');
}
if (tipe_angkutan == '0') {
    return toastr.warning('Tipe Angkutan Harus Diisi');
}

if (harga_modal == '0') {
    return toastr.warning('Harga Tidak Boleh Nol');
}

if (satuan_modal == '0') {
    return toastr.warning('Satuan Harus Diisi');
}

if (keterangan_modal == '') {
    return toastr.warning('Keterangan Harus Diisi');
}

if (acc_akun_modal == '0') {
    return toastr.warning('Akun Acc Harus Diisi');
}


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
    url:baseUrl + '/master_sales/save_kontrak',
    type:'post',
    data:$('#form_header').serialize()+'&'+$('.table_modal :input').serialize()+'&cabang='+cabang+'&customer='+customer,
    success:function(response){
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data berhasil disimpan",
                timer: 900,
               showConfirmButton: true
                },function(){
                    $('.success').val('success');
                    var table = $('#table_data').DataTable();
                    table.ajax.reload(null,false);
                    $('.cabang_td').addClass('disabled');
                    $('.customer_td').addClass('disabled');

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
  
  $('.id_detail').val('');
  $('.modal_customer').modal('hide');
}
  
function hapus(p){
var auth = '{{ Auth::user()->punyaAkses('Kontrak Customer','hapus') }}';

if (auth == 0) {
return toastr.warning('User tidak memiliki akses untuk menghapus');
}

var par    = $(p).parents('tr');
var nota   = $('#ed_nomor').val();
var kcd_dt = $(par).find('.kcd_dt').text();

swal({
    title: "Apakah anda yakin?",
    text: "Hapus Data!",
    type: "warning",
    showCancelButton: true,
    showLoaderOnConfirm: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Hapus!",
    cancelButtonText: "Batal",
    closeOnConfirm: false
},

function(){
     $.ajax({
      url:baseUrl + '/master_sales/hapus_d_kontrak',
      data:{nota,kcd_dt},
      type:'get',
      success:function(data){
          swal({
          title: "Berhasil!",
                  type: 'success',
                  text: "Data Berhasil Dihapus",
                  timer: 2000,
                  showConfirmButton: true
                  },function(){
                    var table = $('#table_data').DataTable();
                    table.ajax.reload(null,false);
                  });
      },
      error:function(data){

        swal({
        title: "Terjadi Kesalahan",
                type: 'error',
                timer: 2000,
                showConfirmButton: false
    });
   }
  });
});


}

function edit(p){
var auth = '{{ Auth::user()->punyaAkses('Kontrak Customer','ubah') }}';
if (auth == 0) {
return toastr.warning('User tidak memiliki akses untuk merubah');
}
var par = $(p).parents('tr');
var nota   = $('#ed_nomor').val();
var kcd_dt = $(par).find('.kcd_dt').text();
console.log(kcd_dt);
$.ajax({
    url:baseUrl + '/master_sales/set_modal',
    type:'get',
    data:{nota,kcd_dt},
    dataType:'json',
    success:function(data){
       
        $('.cabang_td').addClass('disabled');
        $('.customer_td').addClass('disabled');

        if (data.data.kcd_jenis == 'PAKET') {
            $('.type_tarif_tr').prop('hidden',false);
            $('.grup_item_tr').prop('hidden',true);
        }else if(data.data.kcd_jenis == 'KORAN'){
            $('.grup_item_tr').prop('hidden',false);
            $('.type_tarif_tr').prop('hidden',true);
        }else{
            $('.grup_item_tr').prop('hidden',true);
            $('.type_tarif_tr').prop('hidden',true);
        }
        $('.kota_asal_modal').val(data.data.kcd_kota_asal).trigger('chosen:updated');
        $('.kota_tujuan_modal').val(data.data.kcd_kota_tujuan).trigger('chosen:updated');
        $('.jenis_modal').val(data.data.kcd_jenis).trigger('chosen:updated');
        $('.jenis_tarif_modal').val(data.data.kcd_jenis_tarif).trigger('chosen:updated');
        $('.type_tarif_modal ').val(data.data.kcd_type_tarif).trigger('chosen:updated');
        $('.tipe_angkutan_modal').val(data.data.kcd_kode_angkutan).trigger('chosen:updated');
        $('.harga_modal').val(accounting.formatMoney(data.data.kcd_harga,"",0,'.',','));
        $('.satuan_modal').val(data.data.kcd_kode_satuan).trigger('chosen:updated');
        $('.keterangan_modal').val(data.data.kcd_keterangan);
        $('.acc_akun_modal').val(data.data.kcd_acc_penjualan).trigger('chosen:updated');
        $('.csf_akun_modal').val(data.data.kcd_csf_penjualan).trigger('chosen:updated');
        $('.id_detail').val(kcd_dt);
        $('.cb_grup_item').val(data.data.kcd_grup).trigger('chosen:updated');
        $('#modal_customer').modal('show');
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
}

function check(p) {

    var par    = $(p).parents('tr');
    var nota   = $('#ed_nomor').val();
    var kcd_dt = $(par).find('.kcd_dt').text();
    var check  = $(par).find('.check').is(':checked');
    var id     = '{{ $id }}';

    $.ajax({
      url:baseUrl + '/master_sales/check_kontrak',
      data:{nota,kcd_dt,check,id},
      type:'get',
      success:function(data){
          swal({
          title: "Berhasil!",
                  type: 'success',
                  text: "Data Berhasil Diupdate",
                  timer: 2000,
                  showConfirmButton: true
                  },function(){
                    var table = $('#table_data').DataTable();
                    table.ajax.reload(null,false);
                  });
      },
      error:function(data){

        swal({
        title: "Terjadi Kesalahan",
                type: 'error',
                timer: 2000,
                showConfirmButton: false
    });
   }
  });
}

$.fn.serializeArray = function () {
    var rselectTextarea= /^(?:select|textarea)/i;
    var rinput = /^(?:color|date|datetime|datetime-local|email|hidden|month|number|password|range|search|tel|text|time|url|week)$/i;
    var rCRLF = /\r?\n/g;
    
    return this.map(function () {
        return this.elements ? jQuery.makeArray(this.elements) : this;
    }).filter(function () {
        return this.name && !this.disabled && (this.checked || rselectTextarea.test(this.nodeName) || rinput.test(this.type) || this.type == "checkbox");
    }).map(function (i, elem) {
        var val = jQuery(this).val();
        if (this.type == 'checkbox' && this.checked === false) {
            val = 'off';
        }
        return val == null ? null : jQuery.isArray(val) ? jQuery.map(val, function (val, i) {
            return {
                name: elem.name,
                value: val.replace(rCRLF, "\r\n")
            };
        }) : {
            name: elem.name,
            value: val.replace(rCRLF, "\r\n")
        };
    }).get();
}
</script>
@endsection
