@extends('main')

@section('title', 'dashboard')
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
  .dataTables_length{
    display: none;
  }
  .disabled {
    pointer-events: none;
    opacity: 0.4;
}
</style>
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">

  <div class="col-lg-10">
    <h2> Faktur Pembelian </h2>
    <ol class="breadcrumb">
      <li>
        <a>Home</a>
      </li>
      <li>
        <a>Purchase</a>
      </li>
      <li>
        <a> Transaksi Purchase</a>
      </li>
      <li class="active">
        <strong> Detail Faktur Pembelian </strong>
      </li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <!-- HEADER -->

    <!-- body -->
<div class="ibox" style="padding-top: 10px;" >
<div class="ibox-title"><h5>Detail Faktur Pembelian</h5>
<a href="../fakturpembelian" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
</div>
<div class="ibox-content col-sm-12">
<div class="col-sm-6">          
  <form class="head_outlet2">
      {{ csrf_field() }}
    <table class="table head_outlet">
    <h3 style="text-align: center;">Form Pembayaran Outlet</h3>
    <tr>
      <td>No Faktur</td>
      <td>:</td>
      <td>
         <input type="text" value="{{$data->fp_nofaktur}}" class="form-control nofaktur" name="nofaktur" required="" readonly="">
         <input type="hidden" value="{{$data->fp_idfaktur}}" class="form-control idfaktur" name="idfaktur" required="" readonly="">
      
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </td>
    </tr>
    <tr>
      <td> Cabang </td>
      <td>:</td>
      <td>  
        <select class="form-control disabled cabang" name="cabang">
          @foreach($cabang as $i)
          <option value="{{$i->kode}}" @if($i->kode == $data->fp_comp) selected @endif> {{$i->nama}} </option>
          @endforeach
        </select> 
      </td>
     </tr>
     <tr>
      
      <td>Outlet</td>
      <td width="10">:</td>
      <td class="disabled">
        <select class="form-control selectOutlet chosen-select-width" name="selectOutlet">
          @foreach($agen as $val)
          <option @if($val->kode == $data->fp_supplier) selected="" @endif value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
          @endforeach
        </select>
      </td>
     </tr>
      <tr>
      <td>Tanggal</td>
      <td width="10">:</td>
      <td>
        <input  class="form-control reportrange" type="text" value="{{$start}} - {{$second}}" name="rangepicker"  >
      </td>
     </tr>
     <tr>
      <td>Jatuh Tempo</td>
      <td width="10">:</td>
      <td>
        <input  class="form-control jatuh_tempo_outlet" type="text" value="{{$jt}}" name="jatuh_tempo_outlet"  >
      </td>
     </tr>
    <tr>
      <td width="111">Note</td>
      <td width="20">:</td>
      <td>
        <textarea onkeyup="autoNote()" class="form-control note_po" id="note" name="note" style="min-height: 100px">{{$data->fp_keterangan}}</textarea> 
      </td>
     </tr>
     </table>
     <button style="margin-right: 20px" type="button" class="btn btn-warning pull-left  print-penerus" id="print-penerus" onclick="print_penerus()" ><i class="fa fa-print"></i> Print</button>
      <button type="button" class="btn btn-warning pull-left print-penerus" id="print-penerus" onclick="print_penerus_tt()" ><i class="fa fa-print"></i> Print Tanda Terima</button>
     <button type="button" class="btn btn-primary pull-right cari_outlet" onclick="cari_outlet()"><i class="fa fa-search">&nbsp;Search</i></button>
    </form>
</div>  
<hr>
<div class="col-sm-12 outlet">
    <h3>Tabel Detail Resi</h3>
  <div class="col-sm-5">
    <table class="table table-stripped header_total_outlet1">
      <tr>
        <td>Total Tarif</td>
        <td>:</td>
        <td><input style="text-align: right" readonly="" type="text" value="{{'Rp ' . number_format($data->pot_total_tarif,2,",",".")}}" name="total_tarif" class="form-control form-inline total_tarif"></td>
      </tr>
      <tr>
        <td>Total Komisi Outlet</td>
        <td>:</td>
        <td><input style="text-align: right" readonly="" type="text" value="{{'Rp ' . number_format($data->pot_total_komisi_outlet,2,",",".")}}" name="total_komisi_outlet" class="form-control form-inline total_komisi_outlet"></td>
      </tr>
    </table>
    </div>

    <div class="col-sm-5" style="margin-left: 10%">
    <table class="table table-stripped header_total_outlet2">
      <tr>
        <td>Total Komisi Tambahan</td>
        <td>:</td>
        <td><input style="text-align: right"  readonly="" type="text" name="total_komisi_tambahan" value="{{'Rp ' . number_format($data->pot_total_komisi_tambah,2,",",".")}}" class="form-control form-inline total_komisi_tambahan"></td>
      </tr>
      <tr>
        <td>Total Jumlah Komisi</td>
        <td>:</td>
        <td><input style="text-align: right"  readonly="" type="text" name="total_all_komisi" value="{{"Rp " . number_format($data->pot_total_komisi,2,",",".")}}" class="form-control form-inline total_all_komisi"></td>
      </tr>
    </table>
    </div>

      <table class="table table-bordered table-hover table_outlet" style="font-size: 12px; ">
      <button onclick="tt_penerus_outlet()" class="btn btn-info modal_outlet_tt" style="margin-right: 10px;" type="button" data-toggle="modal" data-target="#modal_tt_outlet" type="button"> <i class="fa fa-book"> </i> &nbsp; Form Tanda Terima </button>
      <button type="button" class="btn btn-primary pull-right " id="save_update_outlet" onclick="save_outlet()" data-dismiss="modal">Simpan Data</button>
      <hr>
      <div class="loading text-center" style="display: none;">
          <img src="{{ asset('assets/img/loading1.gif') }}" width="100px">
        </div>
      <thead align="center">
        <tr>
        <th>
          No.Order
        </th>
        <th>
          Tanggal
        </th>
        <th>
          Tarif
        </th>
        <th>
          Komisi Outlet
        </th>
        <th>
          Komisi Tambahan
        </th>
        <th>
          Jumlah Komisi
        </th>
        </tr>
      </thead> 
      <tbody align="center" class="body-outlet">

        @foreach($data_dt as $index => $val)
        <tr>
          <td >
            {{$val->potd_pod}}
          </td>
           <input type="hidden" name="chck[]" value="on" class="form-control child_check" >
            <input type="hidden" name="no_resi[]" class="form-control" value="{{$val->potd_pod}}">
          </td>
          <td>
            {{$val->potd_tgl}}
          </td>
          <td>
            {{$val->potd_tarif_resi}}
            <input type="hidden" name="tarif[]" class="form-control tarif_dasar" value="{{$val->potd_tarif_resi}}">
          </td>
          <td>
            {{$val->potd_komisi}}
            <input type="hidden" name="komisi[]" class="form-control komisi" value=" {{$val->potd_komisi}}">
            <input type="hidden" name="comp[]" class="form-control" value=" {{$val->kode_cabang}}">
          </td>
          <td>
            {{$val->potd_komisi_tambahan}}
            <input type="hidden" name="komisi_tambahan[]" onload="hitung_komisi(this)" class="form-control komisi_tambah" value="{{$val->potd_komisi_tambahan}}">
          </td>
          <td>
            {{$val->potd_komisi_total}}
            <input type="hidden" name="total_komisi[]" class="form-control total_komisi" value="{{$val->potd_komisi_total}}">
          </td>
        </tr>
        @endforeach
      </tbody>
      </table>
    </div>

</div>
</div>


<!-- {{-- MODAL TT OUTLET --}} -->

<div class="modal fade" id="modal_tt_outlet" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document" style="min-width: 800px !important; min-height: 800px">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Form Tanda Terima</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-stripped tabel_tt_outlet">
          <tr>
            <td width="150px">
                  No Tanda Terima 
                </td>
                <td>
                  <input value="{{$valid_cetak->tt_noform}}" type='text' name="nota_tt" class='input-sm form-control notandaterima'>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </td>
          </tr>
          <tr>
            <td> Tanggal </td>
                <td>
                   <div class="input-group date">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tgl_tt" readonly="" value="{{carbon\carbon::parse($valid_cetak->tt_tgl)->format('d/m/Y')}}" name="tgl_tt">
                  </div>
                </td>
          </tr>
          <tr>
              <td> Supplier </td>
              <td> <input type='text' class="form-control supplier_tt" value="{{$valid_cetak->tt_idagen}}" name="supplier_tt" readonly=""></td>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                 <div class="row">
                    <div class="col-sm-3"> 
                      <div class="checkbox checkbox-info checkbox-circle">
                          <input id="Kwitansi" type="checkbox" @if($valid_cetak->tt_kwitansi == 'ADA') checked="" @endif name="kwitansi">
                            <label for="Kwitansi">
                                Kwitansi / Invoice / No
                            </label>
                      </div> 
                    </div>
                    <div class="col-sm-3"> 
                      <div class="checkbox checkbox-info checkbox-circle">
                          <input id="FakturPajak" type="checkbox" @if($valid_cetak->tt_faktur == 'ADA') checked="" @endif name="faktur_pajak">
                            <label for="FakturPajak">
                                Faktur Pajak
                            </label>
                      </div> 
                    </div>

                    <div class="col-sm-3"> 
                      <div class="checkbox checkbox-info checkbox-circle">
                          <input id="SuratPerananAsli" type="checkbox" @if($valid_cetak->tt_suratperan == 'ADA') checked="" @endif name="surat_peranan">
                            <label for="SuratPerananAsli">
                                Surat Peranan Asli
                            </label>
                      </div> 
                    </div>

                     <div class="col-sm-3"> 
                      <div class="checkbox checkbox-info checkbox-circle">
                          <input id="SuratJalanAsli" type="checkbox" @if($valid_cetak->tt_suratjalanasli == 'ADA') checked="" @endif name="surat_jalan">
                            <label for="SuratJalanAsli">
                               Surat Jalan Asli
                            </label>
                      </div> 
                    </div>
                  </div>
              </td>
            </tr>
            <tr>
              <td>
               Lain Lain
              </td>
              <td>                      
                <input type="text" value="{{$valid_cetak->tt_lainlain}}" class="form-control lain_outlet" name="lainlain_penerus">
              </td>
            </tr>
            <tr>
              <td> Tanggal Kembali </td>
              <td><div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input value="{{$valid_cetak->tt_tglkembali}}" type="text" class="form-control jatuhtempo_tt" readonly="" name="tgl_kembali">
                </div>
              </td>
            </tr>
            <tr>
              <td>Total di Terima</td>
              <td>
                <div class="row">
                  <div class="col-sm-3">
                    <label class="col-sm-3 label-control"> Rp </label>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" value="{{$valid_cetak->tt_tglkembali}}" class="form-control totalterima_tt" name="total_diterima" style="text-align:right;" readonly="">
                  </div>
                </div>
              </td>
            </tr>
        </table>
      </div>
      <div class="modal-footer inline-form">
        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary simpan_outlet" onclick="simpan_tt()" data-dismiss="modal">Simpan</button>
      </div>
    </div>
  </div>
</div>

@endsection
@section('extra_scripts')
<script type="text/javascript">
var datatable2 = $('.table_outlet').DataTable({
              responsive: true,
              searching:false,
              //paging: false,
              "pageLength": 10,
              "language": dataTableLanguage,
      });
 function cari_outlet() {
  var  selectOutlet = $('.selectOutlet').val();
  var  cabang     = $('.cabang').val();
  var  reportrange  = $('.reportrange').val();
  var  id  = '{{$id}}';
  $.ajax({
      url:baseUrl +'/fakturpembelian/cari_outlet1',
      data: {selectOutlet,cabang,reportrange,id},
      success:function(data){
        datatable2.clear().draw();
        $('.outlet').html(data);

      },error:function(){
        toastr.warning('Terjadi Kesalahan');
      }
    })
 }

$(document).ready(function(){
  $('.reportrange').daterangepicker({
          autoclose: true,
          "opens": "right",
          locale: {
          format: 'DD/MM/YYYY'
      }         
});
})

  function tt_penerus_outlet() {

    var total_all_komisi  = $('.total_all_komisi').val();
    var jatuh_tempo_outlet  = $('.jatuh_tempo_outlet').val();

    $('.jatuhtempo_tt').val(jatuh_tempo_outlet);
    $('.totalterima_tt').val(total_all_komisi);


  }


   function save_outlet(){

    swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data Pembayaran Outlet!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Simpan!",
    cancelButtonText: "Batal",
    closeOnConfirm: true
  },
  function(){
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      $.ajax({
      url:baseUrl + '/fakturpembelian/update_outlet',
      type:'post',
      data: $('.head_outlet :input').serialize()+'&'+datatable2.$('input').serialize()+'&'+$('.header_total_outlet1 :input').serialize()+'&'+$('.header_total_outlet2 :input').serialize()+'&id='+'{{$id}}',
      success:function(response){
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data berhasil disimpan",
                timer: 900,
               showConfirmButton: true
                },function(){
       

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
 });
}


function simpan_tt() {
  var totalterima_tt = $('.totalterima_tt').val();
  var  selectOutlet = $('.selectOutlet').val();
  var cabang = $('.cabang').val();

      swal({
        title: "Apakah anda yakin?",
        text: "Simpan Data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Simpan!",
        cancelButtonText: "Batal",
        closeOnConfirm: true
      },
      function(){
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
          $.ajax({
          url:baseUrl + '/fakturpembelian/simpan_tt',
          type:'get',
          data:$('.tabel_tt_outlet :input').serialize()+'&'+'agen='+selectOutlet+'&'+$('.head1 .nofaktur').serialize()+'&cabang='+cabang,
          success:function(response){
                swal({
                    title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                    showConfirmButton: true
                    },function(){
                    $('.save_update_outlet').removeClass('disabled');
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
     });
  }
 function print_penerus() {
    var idfaktur = $('.idfaktur').val();
     window.open('{{url('fakturpembelian/detailbiayapenerus')}}'+'/'+idfaktur);
  }

  function print_penerus_tt() {
    var idfaktur = $('.notandaterima').val();
    idfaktur = idfaktur.replace('/','-')
    idfaktur = idfaktur.replace('/','-')
     window.open('{{url('fakturpembelian/cetak_tt')}}'+'/'+idfaktur);
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
