@extends('main')

@section('title', 'dashboard')

@section('content')



<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> DO KERTAS
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>

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
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Nomor</td>
                                <td colspan="3">
                                    <input type="text" name="ed_nomor" id="ed_nomor" class="form-control" readonly="readonly" style="text-transform: uppercase" value="{{ $data->nomor or null }}" >
                                    <input type="hidden" name="ed_nomor_old" class="form-control" style="text-transform: uppercase" value="{{ $data->nomor or null }}" >
                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                    <input type="hidden" class="form-control" name="ed_tampil" >
                                    <input type="hidden" class="form-control" name="crud_h" class="form-control" @if ($data === null) value="N" @else value="E" @endif>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td colspan="3">
                                    <div class="input-group date" style="width: 100%">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tanggal" value="{{carbon\carbon::now()->format('d/m/Y')}}">
                                    </div>
                                </td>
                            </tr>                        
                           @if(Auth::user()->punyaAkses('Delivery Order','cabang'))
                            <tr class="">
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td colspan="4">
                                    <select onchange="ganti_nota()" class="form-control chosen-select-width cabang "  name="cb_cabang">
                                    @foreach ($cabang as $row)
                                        @if(Auth::user()->kode_cabang == $row->kode)
                                        <option selected="" value="{{ $row->kode }}">{{ $row->kode }} -  {{ $row->nama }} </option>
                                        @else
                                        <option value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                        @endif
                                    @endforeach
                                    </select>
                                </td>
                            </tr>
                            @else
                            <tr class="disabled">
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td colspan="4">
                                    <select onchange="ganti_nota()" class="form-control chosen-select-width cabang "  name="cb_cabang">
                                    @foreach ($cabang as $row)
                                        @if(Auth::user()->kode_cabang == $row->kode)
                                        <option selected="" value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                        @else
                                        <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                        @endif
                                    @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td>Customer</td>
                                <td class="customer_td">
                                    <select onchange="cari_customer()" class="form-control customer chosen-select-width" name="customer">
                                        <option value="0">Pilih - Customer</option>
                                    @foreach($customer as $val)
                                        <option value="{{$val->kode}}">{{$val->kode}}-{{$val->nama}}</option>
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
                                    <input type="text" class="form-control ed_diskon_h" name="ed_diskon_h" readonly="readonly" tabindex="-1"  style="text-align:right" @if ($data === null) value="0" @else value="{{ number_format($data->diskon, 0, ",", ".") }}" @endif>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Total</td>
                                <td colspan="3">
                                    <input type="text" class="form-control ed_total_h" name="ed_total_h" readonly="readonly" tabindex="-1"  style="text-align:right" @if ($data === null) value="0" @else value="{{ number_format($data->total, 0, ",", ".") }}" @endif>
                                     
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info " onclick="tambah_kertas()"><i class="glyphicon glyphicon-plus"></i>Tambah</button>
                            <button type="button" class="btn btn-success " id="btnsimpan" name="btnsimpan" ><i class="glyphicon glyphicon-save"></i>Simpan</button>
                        </div>
                    </div>
                </form>
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Kode Item</th>
                            <th>Nama Item</th>
                            <th>Keterangan</th>
                            <th>Jml</th>
                            <th>Satuan</th>
                            <th>Tarif Dasar</th>
                            <th>Diskon</th>
                            <th>Total</th>
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
                                            <tr style="display:none;">
                                                <td style="padding-top: 0.4cm; width:11%">Seq Id</td>
                                                <td>   
                                                    <input type="number" class="form-control" name="ed_id">
                                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                                    <input type="hidden" class="form-control" name="crud" class="form-control" >
                                                    <input type="hidden" class="form-control" name="ed_id_old">
                                                    <input type="hidden" class="form-control" name="ed_nomor_do">
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



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
// datatable
$('#table_data').DataTable();
$('.date').datepicker({
        format:'dd/mm/yyyy'
});
$('.ed_diskon_modal').maskMoney({precision:0,thousands:'.'});
$(document).ready(function(){
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
});

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

function tambah_kertas() {
    var customer = $('.customer').val();
    if (customer == '0') {
        toastr.warning('Customer Harus Diisi');
        return 1;
    }

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

   $('.ed_total').val(ed_jumlah * ed_harga);
   $('.ed_total_text').val(accounting.formatMoney(ed_jumlah * ed_harga,"",2,'.',','));

   $('.ed_netto').val(ed_jumlah * ed_harga - ed_diskon_modal);
   $('.ed_netto_text').val(accounting.formatMoney(ed_jumlah * ed_harga - ed_diskon_modal,"",2,'.',','));
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
}
</script>
@endsection
