@extends('main')

@section('title', 'dashboard')

@section('content')

<style type="text/css">
  .asw{
    color: grey;
  }
  .asw:hover{
    color: red;
  }
  .center:{
    text-align: center;
  }
  tbody .right:{
    align-content: right;
  }
  .sorting_asc{
    background: #9999;
  }

/*  .table_tt td{
    text-align: center !important;
  }*/
</style>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
      <h2> Form Tanda Terima </h2>
      <ol class="breadcrumb">
          <li>
              <a>Home</a>
          </li>
          <li>
              <a>Purchase</a>
          </li>
          <li>
            <a>Transaksi Hutang</a>
          </li>
          <li class="active">
              <strong>Form Tanda Terima Pembelian</strong>
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
                <div class="ibox-title" style="background: white">
                    <div  style="background: white" >
                      <h5>Form Tanda Terima Pembelian</h5>
                      <a  href="{{ url('sales/form_tanda_terima_penjualan/index') }}" class="pull-right" style="color: #999"><i class="fa fa-arrow-left"> Kembali</i></a>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
                  <form class="col-sm-12 form_header">
                    <table class="table table-bordered">
                      <tr>
                        <td width="150">Kode Transaksi</td>
                        <td width="300"><input type="text" readonly="" name="nomor" class="nomor form-control" value="{{ $data->ft_nota }}"></td>
                        <td width="150">Customer</td>
                        <td colspan="2" class="disabled">
                          <select  name="customer" class="customer form-control chosen-select-width">
                              <option value="0">Pilih - Customer</option>
                            @foreach ($customer as $val)
                              <option @if($data->ft_customer == $val->kode) selected="" @endif value="{{ $val->kode }}">{{ $val->kode }} - {{ $val->nama }}</option>
                            @endforeach
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Cabang</td>
                        <td colspan="2" class="disabled">
                          <select name="cabang" class="cabang form-control chosen-select-width">
                            @foreach ($cabang as $val)
                              <option @if($val->kode == $data->ft_kode_cabang) selected="" @endif value="{{ $val->kode }}">{{ $val->kode }} - {{ $val->nama }}</option>
                            @endforeach
                          </select>
                        </td>
                        <td width="150">Tanggal</td>
                        <td width="300" class="disabled">
                          <input type="text" readonly="" class="tanggal form-control" name="tanggal" value="{{ Carbon\carbon::now()->format('d/m/Y') }}">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="5">
                          <div class="row">
                            <div class="col-sm-3"> 
                              <div class="checkbox checkbox-info checkbox-circle">
                                  <input id="Kwitansi" type="checkbox" @if($data->ft_kwitansi == 'on') checked="" @endif name="kwitansi">
                                    <label for="Kwitansi">
                                        Kwitansi / Invoice / No
                                    </label>
                              </div> 
                            </div>
                            <div class="col-sm-3"> 
                              <div class="checkbox checkbox-info checkbox-circle">
                                  <input id="FakturPajak" type="checkbox" @if($data->ft_faktur == 'on') checked="" @endif name="faktur_pajak">
                                    <label for="FakturPajak">
                                        Faktur Pajak
                                    </label>
                              </div> 
                            </div>
                            <div class="col-sm-3"> 
                              <div class="checkbox checkbox-info checkbox-circle">
                                  <input id="SuratPerananAsli" type="checkbox" @if($data->ft_suratperan == 'on') checked="" @endif name="surat_peranan">
                                    <label for="SuratPerananAsli">
                                        Surat Peranan Asli
                                    </label>
                              </div> 
                            </div>
                             <div class="col-sm-3"> 
                              <div class="checkbox checkbox-info checkbox-circle">
                                  <input id="SuratJalanAsli" type="checkbox" @if($data->ft_suratjalanasli == 'on') checked="" @endif name="surat_jalan">
                                    <label for="SuratJalanAsli">
                                       Surat Jalan Asli
                                    </label>
                              </div> 
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Lain-lain</td>
                        <td colspan="2"><input type="text" class="lain form-control" name="lain" value="{{ $data->ft_lainlain }}"></td>
                      
                        <td>Jatuh Tempo</td>
                        <td>
                          <input type="text" name="jatuh_tempo" readonly="" class="jatuh_tempo form-control" value="{{ Carbon\carbon::parse($data->ft_jatuh_tempo)->format('d/m/Y') }}">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <button type="button" class="btn btn-primary add"><i class="fa fa-plus"> Tambah Invoice</i></button>
                          <button type="button"  class="btn btn-success simpan_form"><i class="fa fa-save "> Save</i></button>
                          {{-- <button type="button"  class="btn btn-warning"><i class="fa fa-print "> </i></button> --}}
                        </td>
                        <td colspan="1">Total</td>
                        <td colspan="2"><input type="text" readonly="" value="{{ number_format($data->ft_total, 2, ",", ".") }}" name="total_tt" class="form-control total_tt"></td>
                      </tr>
                    </table>
                  </form>
                  <form class="col-sm-12 table-responsive form_detail">
                    <table class="table table-bordered table-striped table_tt " style="width: 100%" >
                      <thead style="color: white">
                        <tr align="center">
                          <td style="width: 15%">Invoice</td>
                          <td style="width: 10%">Tanggal Invoice</td>
                          <td style="width: 15%">Nominal</td>
                          <td style="width: 45%">Catatan</td>
                          <td style="width: 5%">Aksi</td>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </form>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
            
                  </div>
                  </div><!-- /.box-footer --> 
              </div><!-- /.box -->
            </div><!-- /.col -->
            </div>
          </div><!-- /.row -->
                </div>
            </div>
    </div>
</div>
    
@include('sales.form_tanda_terima.modal_tt')



<div class="row" style="padding-bottom: 50px;"></div>


@endsection

@section('extra_scripts')
<script type="text/javascript">
var array_simpan = [0];

  var index = 1 ;
  var table = $('.table_tt').DataTable({
    searching:true,
    sorting:false,
    columnDefs: [
        {
           targets: 2,
           className: 'right'
        },
        {
           targets: 3,
           className: 'center'
        },
        {
           targets: 4,
           className: 'center'
        },
    ],
  });
  $('#tanggal_detil').datepicker({format:'dd/mm/yyyy'}).on('changeDate', function (ev) {
      $('#tanggal_detil').change();
      $(this).datepicker('hide');
  });

  $('.tanggal').datepicker({format:'dd/mm/yyyy'}).on('changeDate', function (ev) {
      $('.tanggal').change();
      $(this).datepicker('hide');
  });

  $('.tanggal').change(function () {
      nota();
  });

  $('.cabang').change(function(){
      nota();
  });
  $('.tanggal_kembali').datepicker({format:'dd/mm/yyyy'}).on('changeDate', function (ev) {
      $('.tanggal_kembali').change();
      $(this).datepicker('hide');
  });

  $("#nominal").maskMoney({
      precision:0,
      thousands:'.',
      allowZero:true,
  });

  function trash(a) {
    var par     = $(a).parents('tr');
    var invoice = $(par).find('.invoice').val();
    var index   = array_simpan.indexOf(invoice);
    array_simpan.splice(index,1);
    if (array_simpan.length = 1) {
      $('.customer_td').removeClass('disabled');
      $('.cabang_td').removeClass('disabled');
    }
    table.row(par).remove().draw();
    total();
  }

  $('.add').click(function(){
    var id = '{{ $id }}';
    var customer = $('.customer').val();
    var cabang = $('.cabang').val();
    if (customer == '0') {
        toastr.warning('Customer Harus Diisi');
        return false;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $.ajax({
      url  : '{{ route('cari_invoice') }}',
      data : {customer,cabang,array_simpan,id},
      type : 'post',
      success:function(data){
        $('.invoice_div').html(data);
        $('.right').css('text-align','right');
        $('.center').css('text-align','center');
        $('#modal_tt').modal('show');
      },
      error:function(data){
        toastr.warning('Terjadi Kesalahan Periksa Kembali Data Anda');
      }
    })
  })

  $('.append_invoice').click(function(){
    var array_invoice = [];
    invoice.$('.child_check').each(function(){
      if ($(this).is(':checked') == true) {
        var nomor = $(this).parents('tr').find('.nomor_invoice').val();
        array_invoice.push(nomor);
      }
    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $.ajax({
      url  : '{{ route('append_invoice') }}',
      data : {array_invoice},
      dataType:'json',
      type : 'post',
      success:function(data){

        for (var i = 0; i < data.data.length; i++) {
          table.row.add([
            '<p class="invoice_text">'+data.data[i].i_nomor+'</p>'+
            '<input type="hidden" class="invoice" name="invoice[]" value="'+data.data[i].i_nomor+'">',

            '<p class="tanggal_detil_text">'+data.data[i].i_tanggal+'</p>',

            '<p class="nominal_text">'+accounting.formatMoney(data.data[i].i_total_tagihan,"", 2, ".",',')+'</p>'+
            '<input type="hidden" class="form-control nominals" name="nominal[]" value="'+data.data[i].i_total_tagihan+'">',

            '<input type="text" class="form-control" name="catatan[]" style="width:100%">',

            '<div class=" btn-group">'+
            '<a class="btn btn-danger trash" onclick="trash(this)"><i class="fa fa-trash"></i></a>'+
            '<input type="hidden" value="on" class="form-control" name="revisi[]" >'+
            '</div>',
          ]).draw();

          array_simpan.push(data.data[i].i_nomor);
        }
        $('.right').css('text-align','right');
        $('.center').css('text-align','center');
        $('.customer_td').addClass('disabled');
        $('.cabang_td').addClass('disabled');
        total();
      },
      error:function(data){
        toastr.warning('Terjadi Kesalahan Periksa Kembali Data Anda');
      }
    })
    $('#modal_tt').modal('hide');
  })
  function total() {
    var total = 0;
    table.$('.nominals').each(function(){
      console.log($(this));
      var nominal = $(this).val();
      nominal     = nominal.replace(/[^0-9\-]+/g,"")*1;
      total       += nominal;
    })
    $('.total_tt').val(accounting.formatMoney(total,"", 2, ".",','));
  }
  $('.simpan_form').click(function(){
    var temp = 0
    var validator = [];
    var cabang   = $('.cabang').val();
    var customer = $('.customer').val();
    swal({
    title: "Apakah anda yakin?",
    text: "Simpan Tanda Terima!",
    type: "warning",
    showCancelButton: true,
    showLoaderOnConfirm: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Simpan!",
    cancelButtonText: "Batal",
    closeOnConfirm: false,
    showLoaderOnConfirm: true
    },function(){
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      $.ajax({
        url:baseUrl + '/sales/form_tanda_terima_penjualan/update',
        type:'post',
        data:$('.form_header input').serialize()+'&'+table.$('input').serialize()+'&cabang='+cabang+'&customer='+customer,
        dataType:'json',
        success:function(data){
          if (data.status == 1) {
            swal({
            title: "Berhasil!",
                    type: 'success',
                    text: "Data Berhasil Disimpan",
                    timer: 2000,
                    showConfirmButton: true
                    },function(){
                     window.location  = '{{ url('sales/form_tanda_terima_penjualan/index') }}';
            });
          }else if (data.status == 0) {
            swal({
            title: "Berhasil!",
                type: 'error',
                text: data.message,
                timer: 2000,
                showConfirmButton: true
                },function(){
            });
          }
          
        },
        error:function(data){
        }
      }); 
    });
  })

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
@foreach ($detail as $i => $val)
    var invoice       = '{{ $val->ftd_invoice }}';
    var nominal       = '{{ $val->ftd_total_invoice }}';
    var tanggal_detil = '{{ Carbon\carbon::parse($val->ftd_tanggal_invoice)->format('d/m/Y') }}';
    var catatan       = '{{ $val->ftd_keterangan }}';
    var catatan       = '{{ $val->ftd_keterangan }}';
    @if($val->ftd_status == 'APPROVED')
      var aksi =  '<input type="checkbox" checked class="form-control" name="revisi[]" >';
    @else
      var aksi =  '<input type="checkbox" class="form-control disabled" name="revisi[]" >';
    @endif

    table.row.add([
      '<p class="invoice_text">'+invoice+'</p>'+
      '<input type="hidden" class="invoice" name="invoice[]" value="'+invoice+'">',

      '<p class="tanggal_detil_text">'+tanggal_detil+'</p>',

      '<p class="nominal_text">'+accounting.formatMoney(nominal,"", 2, ".",',')+'</p>'+
      '<input type="hidden" class="form-control nominals" name="nominal[]" value="'+parseInt(nominal)+'">',

      '<input type="text" class="form-control" name="catatan[]" value="'+catatan+'" style="width:100%">',

      '<div class=" btn-group">'+
      aksi+
      '</div>',
    ]).draw();
    $('.right').css('text-align','right');
    $('.center').css('text-align','center');
    index++;
    array_simpan.push(invoice);

  @endforeach
</script>
@endsection
