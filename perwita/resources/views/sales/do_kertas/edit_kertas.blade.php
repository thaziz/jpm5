@extends('main')

@section('title', 'dashboard')

@section('content')

<style>
    .details-control {
        background: url('{{ asset('assets/img/details_open.png') }}') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('{{ asset('assets/img/details_close.png') }}') no-repeat center center;
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
                    <h5> DO KERTAS
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <a href="../deliveryorderkertas" class="pull-right" style="color: grey; float: right;"><i class="fa fa-arrow-left"> Kembali</i></a>
                     
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
                    <table class="table table_header table-striped table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Nomor</td>
                                <td colspan="3">
                                    <input type="text" name="ed_nomor" id="ed_nomor" class="form-control" readonly="readonly" style="text-transform: uppercase" value="{{ $data->nomor}}" >

                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >

                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td colspan="3">
                                    <div class="input-group date" style="width: 100%">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tanggal" value="{{carbon\carbon::parse($data->tanggal)->format('d/m/Y')}}">
                                    </div>
                                </td>
                            </tr>                        
                            <tr class="disabled">
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td colspan="4">
                                    <select onchange="ganti_nota()" class="form-control chosen-select-width cabang "  name="cb_cabang">
                                    @foreach ($cabang as $row)
                                        @if($data->kode_cabang == $row->kode)
                                        <option selected="" value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                        @else
                                        <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                        @endif
                                    @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Customer</td>
                                <td class="customer_td disabled">
                                    <select onchange="cari_customer()" class="form-control customer chosen-select-width" name="customer">
                                        <option value="0">Pilih - Customer</option>
                                    @foreach($customer as $val)
                                        @if($data->kode_customer == $val->kode)
                                        <option selected="" value="{{$val->kode}}">{{$val->kode}}-{{$val->nama}}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Alamat</td>
                                <td colspan="3">
                                    <input type="text" class="form-control ed_alamat" name="ed_alamat" readonly="readonly" tabindex="-1" style="text-transform: uppercase" value="">
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Diskon</td>
                                <td colspan="3">
                                    <input type="text" class="form-control ed_diskon_h" readonly="readonly" tabindex="-1"  style="text-align:right" value="{{number_format($data->diskon, 2, ",", ".")}}">
                                    <input type="hidden" class="form-control ed_diskon_m" name="ed_diskon_m" readonly="readonly" tabindex="-1"  style="text-align:right" value="{{$data->diskon}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Total</td>
                                <td colspan="3">
                                    <input type="text" class="form-control ed_total_h" readonly="readonly" tabindex="-1"  style="text-align:right" value="{{number_format($data->total_net, 2, ",", ".")}}" >
                                    <input type="hidden" class="form-control ed_total_m" name="ed_total_m" readonly="readonly" tabindex="-1"  style="text-align:right" value="{{$data->total_net}}" >
                                     
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info " onclick="tambah_kertas()"><i class="glyphicon glyphicon-plus"></i>Tambah</button>
                            <button type="button" class="btn btn-success" onclick="simpan()" id="btnsimpan" name="btnsimpan" ><i class="glyphicon glyphicon-save"></i>Simpan</button>
                            <button type="button" class="btn btn-warning disabled" onclick="ngeprint()" id="print" name="btnsimpan" ><i class="glyphicon glyphicon-print"></i>Print</button>
                            <button type="button" class="btn btn-danger reload" id="print" name="btnsimpan" ><i class="glyphicon glyphicon-refresh"></i>reload</button>
                        </div>
                    </div>
                </form>
                <div class="box-body">
                  <table id="table_detail" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10%">Detail</th>
                            <th style="width: 5%">Id</th>
                            <th>Kode Item</th>
                            <th>Nama Item</th>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                            
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <!-- modal -->
                <div id="modal" class="modal" >
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Insert Edit Item DO Kertas</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal kirim" id="form_detail">
                                    <table class="table table-striped table-bordered table-hover ">
                                        <tbody>
                                            <tr>
                                                <td style="padding-top: 0.4cm; width:11%">Seq Id</td>
                                                <td colspan="5">   
                                                    <input type="text" readonly="" class="form-control ed_id" name="ed_id" value="1">
                                                    <input type="hidden" class="form-control old_id" name="old_id">
                                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                      
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Item</td>
                                                <td colspan="5" class="item_td">
                                                    <select onchange="cari_item()" name="item" class="form-control item chosen-select-width">
                                                        <option value="0">Pilih - Item</option>
                                                        @foreach($item as $val)
                                                        <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td style="padding-top: 0.4cm">Satuan</td>
                                                <td colspan="5">
                                                    <input type="text" class="form-control ed_satuan" readonly="readonly" name="ed_satuan" tabindex="-1" >   
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Jumlah</td>
                                                <td>
                                                    <input type="text" onkeyup="hitung()" class="form-control ed_jumlah" name="ed_jumlah" style="text-align: right;">
                                                </td>
                                            
                                                <td style="padding-top: 0.4cm">Tarif Dasar</td>
                                                <td>
                                                    <input readonly="" type="text" class="form-control ed_harga_text" name="ed_harga" style="text-align: right;">
                                                    <input readonly="" type="hidden" class="form-control ed_harga" name="ed_harga" style="text-align: right;">
                                                </td>
                                            
                                                <td style="padding-top: 0.4cm">Total</td>
                                                <td>
                                                    <input type="text" class="form-control ed_total_text" readonly="readonly" name="ed_total" tabindex="-1" style="text-align: right;">
                                                    <input type="hidden" class="form-control ed_total" readonly="readonly" name="ed_total" tabindex="-1" style="text-align: right;">
                                                    <input type="hidden" readonly="readonly" class="form-control acc_penjualan" name="acc_penjualan" value="" >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Diskon</td>
                                                <td colspan="5">
                                                    <input type="text" onkeyup="hitung()" class="form-control ed_diskon_modal" name="ed_diskon" style="text-align: right;" value="0">
                                                    <input type="hidden"  class="form-control ed_diskon" style="text-align: right;" value="0">
                                                </td>
                                            </tr>                               
                                            <tr>
                                                <td style="padding-top: 0.4cm">Netto</td>
                                                <td colspan="5">
                                                    <input type="text" class="form-control ed_netto_text" readonly="readonly" name="ed_netto" tabindex="-1" style="text-align: right;">
                                                    <input type="hidden" class="form-control ed_netto" readonly="readonly" name="ed_netto" tabindex="-1" style="text-align: right;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Kota Asal</td>
                                                <td colspan="5">   
                                                    <select class="chosen-select-width cb_kota_asal"  name="cb_kota_asal" style="width:100%">
                                                        <option value="0">Pilih - Kota</option>
                                                    @foreach ($kota as $row)
                                                        <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                                    @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Kota Tujuan</td>
                                                <td colspan="5">   
                                                    <select class="chosen-select-width cb_kota_tujuan"  name="cb_kota_tujuan" style="width:100%">
                                                        <option value="0">Pilih - Kota</option>
                                                    @foreach ($kota as $row)
                                                        <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                                    @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Keterangan</td>
                                                <td colspan="5">   
                                                    <input type="text" name="ed_keterangan" class="form-control ed_keterangan" style="text-transform: uppercase" >
                                                </td>                                    
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary simpan_modal" onclick="simpan_modal()" id="btnsave">Save changes</button>
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
// datatable



var table_detail = $('#table_detail').DataTable( {
        ordering:false,
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "id" },
            { "data": "Kode Item" },
            { "data": "Nama Item" },
            { "data": "Asal" },
            { "data": "Tujuan" },
            { "data": "Keterangan" },
            { "data": "Aksi" }
        ],
        columnDefs: [
                      {
                         targets: 1 ,
                         className: 'center'
                      },
                      {
                         targets: 6,
                         className: 'center'
                      },
                      {
                         targets: 7,
                         className: 'center'
                      },
                    ],
    } );
$('.date').datepicker({
        format:'dd/mm/yyyy'
});



$('.ed_diskon_modal').maskMoney({precision:0,thousands:'.'});

function ganti_nota(){
    var cabang = $('.cabang').val();
    $.ajax({
        url:baseUrl + '/sales/nomor_do_kertas',
        data:{cabang},
        dataType:'json',
        success:function(data){
            $('#ed_nomor').val(data.nota);
        },
        error:function(){
            // location.reload();
        }
    })
}

function cari_customer() {
    var cabang   = $('.cabang').val();
    var customer = $('.customer').val();
    $.ajax({
        url:baseUrl + '/sales/cari_customer_kertas',
        data:{customer},
        dataType:'json',
        success:function(data){
            $('.ed_alamat').val(data.alamat);
        },
        error:function(){
            // location.reload();
        }
    })
}
$(document).ready(function(){
    cari_customer();
});
var count = 1;
@foreach($data_dt as $val)
    @foreach($item as $i)
        @if ($i->kode == $val->dd_kode_item)
        var temp = "{{$i->nama}}" 
        @endif
    @endforeach

    @foreach($kota as $i)
        @if ($i->id == $val->dd_id_kota_asal)
        var temp1 = "{{$i->nama}}" 
        @endif

        @if ($i->id == $val->dd_id_kota_tujuan)
        var temp2 = "{{$i->nama}}" 
        @endif
    @endforeach


var dd_diskon = "{{$val->dd_diskon}}";
var dd_harga = "{{$val->dd_harga}}";
var dd_total = "{{$val->dd_total}}";
var dd_kode_satuan = "{{$val->dd_kode_satuan}}";
var dd_jumlah = "{{$val->dd_jumlah}}";
var dd_id_kota_asal = "{{$val->dd_id_kota_asal}}";
var dd_id_kota_tujuan = "{{$val->dd_id_kota_tujuan}}";
var dd_kode_item = "{{$val->dd_kode_item}}";
var dd_acc_penjualan = "{{$val->dd_acc_penjualan}}";
var dd_keterangan = "{{$val->dd_keterangan}}";
console.log(dd_id_kota_asal);
table_detail.row.add({
        'id':'<p class="id_text">'+count+'</p>'+
        '<input type="hidden" class="id_'+count+' id" value="'+count+'">'+
        '<input type="hidden" readonly name="d_diskon[]" class="form-control d_diskon" value="'+dd_diskon+'">'+
        '<input type="hidden" readonly name="d_harga[]" class="form-control d_harga" value="'+dd_harga+'">'+
        '<input type="hidden" readonly name="d_netto[]" class="form-control d_netto" value="'+dd_total+'">'+
        '<input type="hidden" readonly name="d_satuan[]" class="form-control d_satuan" value="'+dd_kode_satuan+'">'+
        '<input type="hidden" readonly name="d_jumlah[]" class="form-control d_jumlah" value="'+dd_jumlah+'">'+
        '<input type="hidden" readonly name="d_asal[]" class="form-control d_asal" value="'+dd_id_kota_asal+'">'+
        '<input type="hidden" readonly name="d_tujuan[]" class="form-control d_tujuan" value="'+dd_id_kota_tujuan+'">',

        'Kode Item':'<p class="kode_item_text">'+dd_kode_item+'</p>'+
        '<input type="hidden" name="d_kode_item[]" class="d_kode_item" value="'+dd_kode_item+'">'+
        '<input type="hidden" name="d_acc[]" class="d_acc" value="'+dd_acc_penjualan+'">',

        'Nama Item':'<p class="nama_item">'+temp+'</p>',

        'Asal':'<p class="asal_text">'+temp1+'</p>',

        'Tujuan':'<p class="tujuan_text">'+temp2+'</p>',

        'Keterangan':'<input type="text" readonly name="d_keterangan[]" class="form-control d_keterangan" value="'+dd_keterangan+'">',

        'Aksi':'<a onclick="edit_detail(this)" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a>'+
        '<a onclick="hapus_detail(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>',

        'jumlah':'<input type="text" readonly  class="form-control d_jumlah_text" value="'+dd_jumlah+'">',

        'satuan':'<input type="text" readonly  class="form-control d_satuan_text" value="'+dd_kode_satuan+'">',

        'harga':'<input type="text" readonly  class="form-control d_harga_text" value="'+accounting.formatMoney(dd_harga,"",2,'.',',')+'">',

        'diskon':'<input type="text" readonly class="form-control d_diskon_text" value="'+accounting.formatMoney(dd_diskon,"",2,'.',',')+'">',

        'netto':'<input type="text" readonly  class="form-control d_netto_text" value="'+accounting.formatMoney(dd_total,"",2,'.',',')+'">',
        }).draw();
count+=1;
@endforeach
function tambah_kertas() {
    var customer = $('.customer').val();
    if (customer == '0') {
        toastr.warning('Customer Harus Diisi');
        return 1;
    }
    $('.ed_id').val(count);
    $('.old_id').val('');
    $('.item').val('0').trigger('chosen:updated');
    $('.cb_kota_asal').val('0').trigger('chosen:updated');
    $('.cb_kota_tujuan').val('0').trigger('chosen:updated');
    $('.ed_jumlah').val('0');
    $('.ed_diskon').val('0');
    $('.ed_diskon_modal').val('0');
    $('.ed_keterangan').val('');
    $('.ed_harga_text').val('0');
    $('.ed_harga').val('0');
    $('.ed_total_text').val('0');
    $('.ed_total').val('0');
    $('.ed_satuan').val('');
    $('.acc_penjualan').val('');


    $('#modal').modal('show');
}
function hitung() {
   var ed_harga  = $('.ed_harga').val();
   if (ed_harga == '') {
    ed_harga = 0;
   }
   ed_harga      = parseFloat(ed_harga);
   var ed_jumlah = $('.ed_jumlah').val();
   ed_jumlah     = parseInt(ed_jumlah);
   var ed_diskon_modal = $('.ed_diskon_modal').val();
   console.log(ed_diskon_modal);
   ed_diskon_modal     = ed_diskon_modal.replace(/[^0-9\-]+/g,"");
   ed_diskon_modal     = parseInt(ed_diskon_modal);
   $('.ed_diskon').val(ed_diskon_modal);
   $('.ed_total').val(ed_jumlah * ed_harga);
   $('.ed_total_text').val(accounting.formatMoney(ed_jumlah * ed_harga,"",2,'.',','));

   $('.ed_netto').val(ed_jumlah * ed_harga - ed_diskon_modal);
   $('.ed_netto_text').val(accounting.formatMoney(ed_jumlah * ed_harga - ed_diskon_modal,"",2,'.',','));

   
}

function hitung_all() {
    var temp = 0;
   table_detail.$('.d_diskon').each(function(){
    var n = parseInt($(this).val())
    temp += n;
   })
   $('.ed_diskon_m').val(temp);
   $('.ed_diskon_h').val(accounting.formatMoney(temp,"",2,'.',','));

   var temp1 = 0;
   table_detail.$('.d_netto').each(function(){
    console.log($(this).val());
    var n = parseInt($(this).val());
    temp1 += n;
   })
   console.log(temp1);
   $('.ed_total_m').val(temp1);
   $('.ed_total_h').val(accounting.formatMoney(temp1,"",2,'.',','));
}
function cari_item() {
    var item = $('.item').val();
     $.ajax({
        url:baseUrl + '/sales/cari_item',
        data:{item},
        dataType:'json',
        success:function(data){
            if (data == null) {
                $('.ed_satuan').val(0);
                $('.ed_harga').val(0);
                $('.ed_harga_text').val(0);
                $('.acc_penjualan').val(0)
                $('.ed_jumlah').val(0);
                $('.ed_total').val(0);
                $('.ed_total_text').val(0);
            }
            $('.ed_satuan').val(data.kode_satuan);
            $('.ed_harga').val(data.harga);
            $('.ed_harga_text').val(accounting.formatMoney(data.harga,"",2,'.',','));
            $('.acc_penjualan').val(data.acc_penjualan)
            $('.ed_jumlah').val(1);
            
            hitung();

        },
        error:function(){
            // location.reload();
        }
    })
}



function simpan_modal() {

    if ($('.item ').val() == '0') {
        toastr.warning('Item Harus Dipilih');
        return 1;
    }
    if ($('.ed_jumlah').val() == '') {
        toastr.warning('Jumlah Harus Diisi');
        return 1;
    }
    if ($('.ed_keterangan').val() == '') {
        toastr.warning('Keterangan Harus Diisi');
        return 1;
    }

    var item                = $('.item').val();
    var old_id              = $('.old_id').val();
    var ed_satuan           = $('.ed_satuan').val();
    var ed_jumlah           = $('.ed_jumlah').val();
    var ed_harga            = $('.ed_harga').val();
    var ed_diskon           = $('.ed_diskon').val();
    var ed_netto            = $('.ed_netto').val();
    var cb_kota_asal        = $('.cb_kota_asal').val();
    var cb_kota_tujuan      = $('.cb_kota_tujuan').val();
    var ed_keterangan       = $('.ed_keterangan').val();
    var acc_penjualan       = $('.acc_penjualan').val();
    var cb_kota_asal_text   = $('.cb_kota_asal option:selected').text();
    var cb_kota_tujuan_text = $('.cb_kota_tujuan option:selected').text();
    var item_text           = $('.item option:selected').text();
if (old_id == '') {
    table_detail.row.add({
        'id':'<p class="id_text">'+count+'</p>'+
        '<input type="hidden" class="id_'+count+' id" value="'+count+'">'+
        '<input type="hidden" readonly name="d_diskon[]" class="form-control d_diskon" value="'+ed_diskon+'">'+
        '<input type="hidden" readonly name="d_harga[]" class="form-control d_harga" value="'+ed_harga+'">'+
        '<input type="hidden" readonly name="d_netto[]" class="form-control d_netto" value="'+ed_netto+'">'+
        '<input type="hidden" readonly name="d_satuan[]" class="form-control d_satuan" value="'+ed_satuan+'">'+
        '<input type="hidden" readonly name="d_jumlah[]" class="form-control d_jumlah" value="'+ed_jumlah+'">'+
        '<input type="hidden" readonly name="d_asal[]" class="form-control d_asal" value="'+cb_kota_asal+'">'+
        '<input type="hidden" readonly name="d_tujuan[]" class="form-control d_tujuan" value="'+cb_kota_tujuan+'">',

        'Kode Item':'<p class="kode_item_text">'+item+'</p>'+
        '<input type="hidden" name="d_kode_item[]" class="d_kode_item" value="'+item+'">'+
        '<input type="hidden" name="d_acc[]" class="d_acc" value="'+acc_penjualan+'">',

        'Nama Item':'<p class="nama_item">'+item_text+'</p>',

        'Asal':'<p class="asal_text">'+cb_kota_asal_text+'</p>',

        'Tujuan':'<p class="tujuan_text">'+cb_kota_tujuan_text+'</p>',


        'Keterangan':'<input type="text" readonly name="d_keterangan[]" class="form-control d_keterangan" value="'+ed_keterangan+'">',

        'Aksi':'<a onclick="edit_detail(this)" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a>'+
        '<a onclick="hapus_detail(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>',

        'jumlah':'<input type="text" readonly  class="form-control d_jumlah_text" value="'+ed_jumlah+'">',

        'satuan':'<input type="text" readonly  class="form-control d_satuan_text" value="'+ed_satuan+'">',

        'harga':'<input type="text" readonly  class="form-control d_harga_text" value="'+accounting.formatMoney(ed_harga,"",2,'.',',')+'">',

        'diskon':'<input type="text" readonly class="form-control d_diskon_text" value="'+accounting.formatMoney(ed_diskon,"",2,'.',',')+'">',

        'netto':'<input type="text" readonly  class="form-control d_netto_text" value="'+accounting.formatMoney(ed_netto,"",2,'.',',')+'">',
        }).draw();
    count++
    $('#btnsimpan').removeClass('disabled');

}else{
        var id = $('.old_id').val();
        var par = $('.id_'+id).parents('tr');
        table_detail.row(par).remove().draw(false);

        table_detail.row.add({
        'id':'<p class="id_text">'+id+'</p>'+
        '<input type="hidden" class="id_'+id+' id" value="'+id+'">'+
        '<input type="hidden" readonly name="d_diskon[]" class="form-control d_diskon" value="'+ed_diskon+'">'+
        '<input type="hidden" readonly name="d_harga[]" class="form-control d_harga" value="'+ed_harga+'">'+
        '<input type="hidden" readonly name="d_netto[]" class="form-control d_netto" value="'+ed_netto+'">'+
        '<input type="hidden" readonly name="d_satuan[]" class="form-control d_satuan" value="'+ed_satuan+'">'+
        '<input type="hidden" readonly name="d_jumlah[]" class="form-control d_jumlah" value="'+ed_jumlah+'">'+
        '<input type="hidden" readonly name="d_asal[]" class="form-control d_asal" value="'+cb_kota_asal+'">'+
        '<input type="hidden" readonly name="d_tujuan[]" class="form-control d_tujuan" value="'+cb_kota_tujuan+'">',

        'Kode Item':'<p class="kode_item_text">'+item+'</p>'+
        '<input type="hidden" name="d_kode_item[]" class="d_kode_item" value="'+item+'">'+
        '<input type="hidden" name="d_acc[]" class="d_acc" value="'+acc_penjualan+'">',

        'Nama Item':'<p class="nama_item">'+item_text+'</p>',

        'Asal':'<p class="asal_text">'+cb_kota_asal_text+'</p>',

        'Tujuan':'<p class="tujuan_text">'+cb_kota_tujuan_text+'</p>',

        'Keterangan':'<input type="text" readonly name="d_keterangan[]" class="form-control d_keterangan" value="'+ed_keterangan+'">',

        'Aksi':'<a onclick="edit_detail(this)" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a>'+
        '<a onclick="hapus_detail(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>',

        'jumlah':'<input type="text" readonly  class="form-control d_jumlah_text" value="'+ed_jumlah+'">',

        'satuan':'<input type="text" readonly  class="form-control d_satuan_text" value="'+ed_satuan+'">',

        'harga':'<input type="text" readonly  class="form-control d_harga_text" value="'+accounting.formatMoney(ed_harga,"",2,'.',',')+'">',

        'diskon':'<input type="text" readonly class="form-control d_diskon_text" value="'+accounting.formatMoney(ed_diskon,"",2,'.',',')+'">',

        'netto':'<input type="text" readonly  class="form-control d_netto_text" value="'+accounting.formatMoney(ed_netto,"",2,'.',',')+'">',
        }).draw();
}


    $('#modal').modal('hide');

    hitung_all();
}

function format ( d ) {
    // console.log(d);
    // `d` is the original data object for the row
    return '<table class="table">'+
        '<tr>'+
            '<td>Jumlah</td>'+
            '<td>:</td>'+
            '<td>'+d.jumlah+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Satuan</td>'+
            '<td>:</td>'+
            '<td>'+d.satuan+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Tarif Dasar</td>'+
            '<td>:</td>'+
            '<td>'+d.harga+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Diskon</td>'+
            '<td>:</td>'+
            '<td>'+d.diskon+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Total</td>'+
            '<td>:</td>'+
            '<td>'+d.netto+'</td>'+
        '</tr>'+
    '</table>';
}

$('#table_detail tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table_detail.row( tr );
 
    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        // Open this row
        row.child( format(row.data()) ).show();
        tr.addClass('shown');
    }
} );

function hapus_detail(p) {
    var temp = 0;
    var par = p.parentNode.parentNode;
    table_detail.row(par).remove().draw();

    $('.id').each(function(){
        temp+=1;
    })
    if (temp == 0) {
        $('#btnsimpan').addClass('disabled');
    }
}

function edit_detail(p) {
    var par = p.parentNode.parentNode;
    var id  = $(par).find('.id').val();
    var d_kode_item  = $(par).find('.d_kode_item').val();
    var d_satuan  = $(par).find('.d_satuan').val();
    var d_satuan  = $(par).find('.d_satuan').val();
    var d_jumlah  = $(par).find('.d_jumlah').val();
    var d_harga  = $(par).find('.d_harga').val();
    var d_diskon  = $(par).find('.d_diskon').val();
    var d_asal  = $(par).find('.d_asal').val();
    var d_acc  = $(par).find('.d_acc').val();
    var d_tujuan  = $(par).find('.d_tujuan').val();
    var d_keterangan  = $(par).find('.d_keterangan').val();

    $('.ed_id').val(id);
    $('.old_id').val(id);
    $('.item').val(d_kode_item).trigger('chosen:updated');
    $('.cb_kota_asal').val(d_asal).trigger('chosen:updated');
    $('.cb_kota_tujuan').val(d_tujuan).trigger('chosen:updated');
    cari_item();
    $('.ed_jumlah').val(d_jumlah);
    $('.ed_diskon').val(d_diskon);
    $('.ed_diskon_modal').val(accounting.formatMoney(d_diskon,"",0,'.',','));
    $('.ed_keterangan').val(d_keterangan);
    $('.acc_penjualan').val(d_acc);
    hitung();    
    $('#modal').modal('show');
}

function ngeprint(){
   var id = $('#ed_nomor').val();
    window.open('{{url('sales/cetak_nota_kertas')}}'+'/'+id);
}

$('.reload').click(function(){
    location.reload();
})


// SIMPAN DATA
    function simpan(){
        var id = "{{$id}}";
      swal({
        title: "Apakah anda yakin?",
        text: "Simpan Data DO!",
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
          url:baseUrl + '/sales/update_do_kertas',
          type:'post',
          dataType:'json',
          data:$('.table_header :input').serialize()
               +'&'+table_detail.$('input').serialize()
               +'&id='+id,
          success:function(response){
             if (response.status =='gagal') {
                
                    toastr.warning(response.info)
                
             }


            if (response.status == 2) {
                swal({
                    title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){
                    toastr.warning('No invoice telah diganti menjadi ' + response.nota)
                    $('#btnsimpan').addClass('disabled');
                        $('#print').removeClass('disabled');
                });
             }

             if (response.status == 1) {
                swal({
                    title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 1000,
                   showConfirmButton: true
                    },function(){
                        // location.reload();
                        $('#btnsimpan').addClass('disabled');
                        $('#print').removeClass('disabled');

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
    }
</script>
@endsection