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
    text-align: center ;
  }
  tbody .right:{
    align-content: right;
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
                      <a href="{{ url('form_tanda_terima_pembelian') }}" class="pull-right" style="color: #999"><i class="fa fa-arrow-left"> Kembali</i></a>
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
                        <td width="150">Nomor</td>
                        <td width="300"><input type="text" readonly="" name="nomor" class="nomor form-control"></td>
                        <td width="150">Pihak Ketiga</td>
                        <td colspan="2">
                          <select  name="supplier" class="supplier form-control chosen-select-width">
                              <option value="0">Pilih - Supplier</option>
                            @foreach ($all as $val)
                              <option value="{{ $val->kode }}">{{ $val->kode }} - {{ $val->nama }}</option>
                            @endforeach
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Cabang</td>
                        @if(Auth::user()->punyaAkses('Form Tanda Terima Pembelian','cabang'))
                        <td colspan="2">
                          <select name="cabang" class="cabang form-control chosen-select-width">
                            @foreach ($cabang as $val)
                              <option @if($val->kode == Auth::user()->kode_cabang) @endif value="{{ $val->kode }}">{{ $val->kode }} - {{ $val->nama }}</option>
                            @endforeach
                          </select>
                        </td>
                        @else
                        <td colspan="2" class="disabled">
                          <select name="cabang" class="cabang form-control chosen-select-width">
                            @foreach ($cabang as $val)
                              <option @if($val->kode == Auth::user()->kode_cabang) @endif value="{{ $val->kode }}">{{ $val->kode }} - {{ $val->nama }}</option>
                            @endforeach
                          </select>
                        </td>
                        @endif
                        <td width="150">Tanggal</td>
                        <td width="300">
                          <input type="text" class="tanggal form-control" name="tanggal" value="{{ Carbon\carbon::now()->format('d/m/Y') }}">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="5">
                          <div class="row">
                            <div class="col-sm-2"> 
                              <div class="checkbox checkbox-info checkbox-circle">
                                  <input id="Kwitansi" type="checkbox" checked="" name="kwitansi">
                                    <label for="Kwitansi">
                                        Kwitansi / Invoice / No
                                    </label>
                              </div> 
                            </div>
                            <div class="col-sm-2"> 
                              <div class="checkbox checkbox-info checkbox-circle">
                                  <input id="FakturPajak" type="checkbox" checked="" name="faktur_pajak">
                                    <label for="FakturPajak">
                                        Faktur Pajak
                                    </label>
                              </div> 
                            </div>
                            <div class="col-sm-3"> 
                              <div class="checkbox checkbox-info checkbox-circle">
                                  <input id="SuratPerananAsli" type="checkbox" checked="" name="surat_peranan">
                                    <label for="SuratPerananAsli">
                                        Surat Peranan Asli
                                    </label>
                              </div> 
                            </div>
                             <div class="col-sm-3"> 
                              <div class="checkbox checkbox-info checkbox-circle">
                                  <input id="SuratJalanAsli" type="checkbox" checked="" name="surat_jalan">
                                    <label for="SuratJalanAsli">
                                       Surat Jalan Asli
                                    </label>
                              </div> 
                            </div>
                            <div class="col-sm-2"> 
                              <div class="checkbox checkbox-info checkbox-circle">
                                  <input id="lampiran_po" type="checkbox" checked="" name="lampiran_po">
                                    <label for="lampiran_po">
                                       Lampiran PO
                                    </label>
                              </div> 
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Lain-lain</td>
                        <td colspan="2"><input type="text" class="lain form-control" name="lain"></td>
                      
                        <td>Jatuh Tempo</td>
                        <td>
                          <input type="text" name="tanggal_kembali" value="" class="tanggal_kembali form-control">
                        </td>
                      </tr>
                    </table>
                  </form>
                  <div class="col-sm-12">
                    <table class="table table-bordered">
                      <tr>
                        <td>Nomor Invoice</td>
                        <td>
                          <input type="text" class="form-control"  id="invoice">
                          <input type="hidden" class="form-control"  id="dex">
                        </td>
                        <td>Nominal</td>
                        <td><input type="text" class="form-control"  id="nominal"></td>
                      </tr>
                      <tr>
                        <td>Tanggal Invoice</td>
                        <td align="center">
                          <input type="text" value="{{ Carbon\carbon::now()->format('d/m/Y') }}" id="tanggal_detil" class="form-control">
                        </td>
                        <td align="center" colspan="2">
                          <button type="button" class="btn btn-success append"><i class="fa fa-plus"> Append</i></button>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <form class="col-sm-12 table-responsive form_detail">
                    <table class="table table-bordered table-striped table_tt " style="width: 100%" >
                      <thead style="color: white">
                        <tr align="center">
                          <td>Nomor</td>
                          <td>Tanggal Invoice</td>
                          <td>Nominal</td>
                          <td>Aksi</td>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </form>
                  <div class="col-sm-12" align="right">
                    <button class="btn btn-success"><i class="fa fa-save simpan_form"> Save</i></button>
                  </div>
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
    


    


<div class="row" style="padding-bottom: 50px;"></div>


@endsection

@section('extra_scripts')
<script type="text/javascript">

  $('.supplier').change(function(){
    var supplier = $(this).val();
    var tanggal = $('.tanggal').val();
    $.ajax({
      url  : '{{ route('ganti_jt_pembelian') }}',
      data : {supplier,tanggal},
      dataType:'json',
      success:function(data){
        $('.tanggal_kembali').val(data.tgl);
      }
    })
  })

  function nota() {
    var cabang = $('.cabang').val();
    var tanggal = $('.tanggal').val();
    $.ajax({
      url  : '{{ url('form_tanda_terima_pembelian/nota') }}',
      data : {cabang,tanggal},
      dataType:'json',
      success:function(data){
        $('.nomor').val(data.nota);
      }
    })
  }
  $(document).ready(function(){
    var cabang = $('.cabang').val();
    var tanggal = $('.tanggal').val();
    $.ajax({
      url  : '{{ url('form_tanda_terima_pembelian/nota') }}',
      data : {cabang,tanggal},
      dataType:'json',
      success:function(data){
        $('.nomor').val(data.nota);
      }
    })
  })
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

  $('.append').click(function(){
    var dex           = $('#dex').val();
    var invoice       = $('#invoice').val();
    var nominal       = $('#nominal').val();
    var tanggal_detil = $('#tanggal_detil').val();
    if (invoice == '') {
      return toastr.warning('Invoice Harus Diisi');
    }
    if (nominal == '') {
      return toastr.warning('Nominal Harus Diisi');
    }
    var par = $('.dex_'+dex).parents('tr');
    table.row(par).remove().draw();

    table.row.add([
      '<p class="invoice_text">'+invoice+'</p>'+
      '<input type="hidden" class="invoice" name="invoice[]" value="'+invoice+'">'+
      '<input type="hidden" class="dex dex_'+index+'" value="'+index+'">',

      '<p class="tanggal_detil_text">'+tanggal_detil+'</p>'+
      '<input type="hidden" class="tanggal_detil" name="tanggal_detil[]" value="'+tanggal_detil+'">',

      '<p class="nominal_text">'+nominal+'</p>'+
      '<input type="hidden" class="nominal" name="nominal[]" value="'+nominal+'">',

      '<div class=" btn-group">'+
      '<a class="btn btn-warning" onclick="edit(this)"><i class="fa fa-edit"></i></a>'+
      '<a class="btn btn-danger trash" onclick="trash(this)"><i class="fa fa-trash"></i></a>'+
      '</div>',
    ]).draw();
    index++;
    $('.right').css('text-align','right');
    $('.center').css('text-align','center');
    $('#index').val('');
    $('#invoice').val('');
    $('#tanggal_detil').val('{{ Carbon\carbon::now()->format('d/m/Y') }}');
    $('#nominal').val('');
  });

  function edit(a) {
    console.log('asd');
    var par           = $(a).parents('tr');
    var dex           = $(par).find('.dex').val();
    var invoice       = $(par).find('.invoice').val();
    var nominal       = $(par).find('.nominal').val();
    var tanggal_detil = $(par).find('.tanggal_detil').val();

    $('#dex').val(dex);
    $('#invoice').val(invoice);
    $('#nominal').val(nominal);
    $('#tanggal_detil').val(tanggal_detil);
  }

  function trash(a) {
    var par     = $(a).parents('tr');
    table.row(par).remove().draw();
  }

  $('.simpan_form').click(function(){
    var temp = 0
    var validator = [];
    var cabang   = $('.cabang').val();
    var supplier = $('.supplier').val();

    if (supplier == 0) {
      toastr.warning('Supplier harus Diisi');
      return false;
    }
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
        url:baseUrl + '/form_tanda_terima_pembelian/save',
        type:'get',
        data:$('.form_header input').serialize()+'&'+table.$('input').serialize()+'&cabang='+cabang+'&supplier='+supplier,
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
                    location.href = '{{ url('form_tanda_terima_pembelian') }}';
                       
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
</script>
@endsection
