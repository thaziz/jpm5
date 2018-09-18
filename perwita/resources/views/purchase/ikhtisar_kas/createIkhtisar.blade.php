@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
  .table-biaya{
    overflow-x: auto;
  }
  tbody tr{
    cursor: pointer;
  }
  th{
    text-align: center !important;
  }
  .tengah{
    text-align: center;
  }
  .kecil{
    width: 50px;
    
  }
  .datatable tbody tr td{
    padding-top: 16px;
  }
  .dataTables_paginate{
    float: right;
  }
  #modal-biaya .modal-dialog .modal-body{
    min-height: 340px;
  }
  .disabled {
    pointer-events: none;
    opacity: 0.4;
  }
  .search{
    margin-left: 5px;
  }
  h3{
    margin: 20px 5px;

  }
  .my-bg{
    background: #f0b7d6;
  }
  td{
    vertical-align: top !important;
  }
</style>
<!-- <link href="{{ asset('assets/vendors/chosen/chosen.css')}}" rel="stylesheet"> -->
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
      <div class="col-lg-10">
      <h2> Ikhtisar kas </h2>
      <ol class="breadcrumb">
          <li>
              <a>Home</a>
          </li>
          <li>
              <a>Pembelian</a>
          </li>
          <li>
              <a>Transaksi Kas</a>
          </li>
          <li class="active">
              <strong>Ikhtisar Kas</strong>
          </li>
      </ol>
  </div>
 </div>
<div hidden="" class="alert-class alert-info row wrapper border-bottom my-bg page-heading " style="margin-top: 10px; padding: 0 0;">
<h3 class="pending" style="padding: 10px 0 margin:0px 0px !important;"></h3>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <!-- HEADER -->
    <div class="ibox">&nbsp;
      <div class="ibox-title">
        <h5>Laporan Patty Cash</h5>
        <a href="../ikhtisar_kas/index" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-md-4" style="min-height: 100px">
          <div class="alert alert-danger alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <h2 style="text-align:left"> <b>Notice</b></h2> <h4 style="text-align:left">Ikhtisar Bonsem Masih Dalam Perbaikan Terima Kasih.</h4>
          </div>
        </div>
      </div>
      <div class="ibox-content col-sm-12">
        <div class="col-sm-6">
          <table class="table table_header ">
            {{ csrf_field() }}
            <tr>
              <td>Nomor Ikhtisar</td>
              <td>
                <input  class="form-control nomor_ik" type="text" value="" name="ik" readonly=""  >
              </td>
            </tr>
            <tr>
              <td>Tanggal</td>
              <td>
                <input  class="form-control tanggal" type="text" value="{{ carbon\carbon::now()->format('d/m/Y') }}" name="tanggal" readonly=""  >
              </td>
            </tr>
            <tr>
              <td>Filter Tanggal</td>
              <td>
                <input  class="form-control reportrange" type="text" value="{{$start}} - {{$second}}" name="rangepicker"  >
              </td>
            </tr>
            <tr>
              <td>Status</td>
              <td>
                <input  class="form-control status" type="text" readonly="" value="Released"  >
              </td>
            </tr>
            <tr>
                <td style="padding-top: 0.4cm">Cabang</td>
                @if(Auth::user()->punyaAkses('Ikhtisar Kas','cabang'))
                <td>
                    <select class="form-control chosen-select-width cabang" name="cabang">
                        @foreach ($cabang as $row)
                        <option @if(Auth::user()->kode_cabang == $row->kode) selected="" @endif value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                        @endforeach
                    </select>
                </td>
                @else
                <td class="disabled">
                    <select class="form-control chosen-select-width cabang" name="cabang">
                        @foreach ($cabang as $row)
                        <option @if(Auth::user()->kode_cabang == $row->kode) selected="" @endif value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                        @endforeach
                    </select>
                </td>
                @endif
            </tr>
            <tr class="disabled">
              <td>Jenis Ikhtisar Kas</td>
              <td>
                  <select class="jenis_ik form-control" name="jenis_ik ">
                    <option selected="" value="REGULER">REGULER</option>
                    <option value="BONSEM">PEMAKAIAN BONSEM</option>
                  </select>                        
              </td>
            </tr>
            <tr>
              <td>Keterangan</td>
              <td>
                  <input type="text" name="Keterangan" class="form-control">                         
              </td>
            </tr>
            <tr>
              <td>Total</td>
              <td>
                  <input style="font-size: 16px;font-weight: bold;color: red!important" readonly="" type="text" name="total" class="form-control total">                         
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <button type="button" class="btn btn-warning" onclick="cari_patty()"><i class="fa fa-search">&nbsp;Search</i></button>  
                <button type="button" class="btn btn-primary" onclick="simpan()"><i class="fa fa-save">&nbsp;Simpan</i></button>           

              </td>
            </tr>
            <hr>
          </table>
        </div>
        <div class="col-sm-6">
          <p style="color: red">Note:Maximal Data Adalah 5000<br>Gunakan Filter Tanggal Untuk Memilah Petty Cash Berdasarkan Range Tanggal</p>
        </div>
      </div>
    </div>  
    <!-- body Patty Cash-->
<div class="ibox patty_cash" hidden="" style="padding-top: 10px;">
  <div class=" ibox-content col-sm-12 tb_sb_hidden tabel_patty" >
  
  </div>
</div>
<!-- End Body Patty Cash -->
    <!-- tabel data resi -->
  </div>
</div> 
@endsection



@section('extra_scripts')


<script type="text/javascript">
$('.reportrange').daterangepicker({
          autoclose: true,
          "opens": "left",
          locale: {
          format: 'DD/MM/YYYY'
      }         
});

$('.tanggal').datepicker({format:'dd/mm/yyyy'}).on('changeDate', function (ev) {
    $('.tanggal').change();
}); 

$('.tanggal').change(function () {
    var tanggal = $('.tanggal').val();
    var cabang = $('.cabang_select').val();
    $.ajax({
      url:baseUrl +'/ikhtisar_kas/nota',
      data:$('.table_header :input').serialize(),
      success:function(response){
        $('.nomor_ik').val(response.nota);
      },error:function(){
        location.reload();
      }
    });
 });


$(document).ready(function(){
  $.ajax({
    url:baseUrl +'/ikhtisar_kas/cari_patty',
    data:$('.table_header :input').serialize(),
    success:function(response){
      $('.tabel_patty').html(response);
      $('.patty_cash').attr('hidden',false);
    }
  });

  $.ajax({
    url:baseUrl +'/ikhtisar_kas/nota',
    data:$('.table_header :input').serialize(),
    success:function(response){
      $('.nomor_ik').val(response.nota);
    }
  });
})



function cari_patty(){

  $.ajax({
    url:baseUrl +'/ikhtisar_kas/cari_patty',
    data:$('.table_header :input').serialize(),
    success:function(response){
      if (response.status == 2) {
        toastr.warning('Harap isi dengan benar')
        return 1;
      }
      if (response.status == 3) {
        toastr.warning(response.message)
        return 1;
      }
      $('.tabel_patty').html(response);
      // $('.patty_cash').attr('hidden',false);

    }
  });
}

$('.cabang').change(function(){
  $.ajax({
    url:baseUrl +'/ikhtisar_kas/nota',
    data:$('.table_header :input').serialize(),
    success:function(response){
      $('.nomor_ik').val(response.nota);
      cari_patty();
    }
  });
})

function ck(a) {
  var cek = $(a).find('.ck');
  if (cek.is(':checked') == true) {
    $(a).find('.ck').prop('checked',false);
  }else{
    $(a).find('.ck').prop('checked',true);
  }
  var total = 0;
  tabel_patty.$('.ck').each(function(){
    if($(this).is(':checked') == true){
      var par = $(this).parents('tr');
      var nominal = $(par).find('.nominal').val();
      total += (nominal*1);
    }
  })
  $('.total').val(accounting.formatMoney(total,"", 2, ".",','))
}


function ceek(a) {
  var cek = $(a).is(':checked');
  if (cek == true) {
    $(a).prop('checked',false);
  }else{
    $(a).prop('checked',true);
  }
  var total = 0;
  tabel_patty.$('.ck').each(function(){
    if($(this).is(':checked') == true){
      var par = $(this).parents('tr');
      var nominal = $(par).find('.nominal').val();
      total += (nominal*1);
    }
  })
  $('.total').val(accounting.formatMoney(total,"", 2, ".",','))
}
function simpan(){
    $.ajax({
    url:baseUrl +'/ikhtisar_kas/simpan',
    data:$('.table_header :input').serialize()+'&'+tabel_patty.$('input').serialize(),
    success:function(response){
      if (response.status == 2) {
        toastr.warning('Harap isi dengan benar')
        return 1;
      }
      // $('.tabel_patty').html(response);
      // $('.patty_cash').attr('hidden',false);

    }
  });
}

function simpan(){


  swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data Ikhtisar!",
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
         url:baseUrl +'/ikhtisar_kas/simpan',
         data:$('.table_header :input').serialize()+'&'+tabel_patty.$('input').serialize(),
         type:'post',
      success:function(response){
        if(response.status == 1){
          swal({
            title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){
                       location.href='../ikhtisar_kas/index';
            });
        }else{
          swal({
          title: "Terjadi Kesalahan",
                type: 'error',
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
