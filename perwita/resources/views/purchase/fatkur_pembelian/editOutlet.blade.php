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
      <td>Pilih Outlet</td>
      <td width="10">:</td>
      <td>
        <select class="form-control selectOutlet chosen-select-width" name="selectOutlet">
          @foreach($agen as $val)
          <option @if($val) selected="" @endif value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
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
        <textarea onkeyup="autoNote()" class="form-control note_po" id="note" name="note" style="min-height: 100px"></textarea> 
      </td>
     </tr>
     </table>
     <button type="button" class="btn btn-warning pull-left disabled print-penerus" id="print-penerus" onclick="print_penerus()" ><i class="fa fa-print"></i> Print</button>
     <button type="button" class="btn btn-primary pull-right cari_outlet" onclick="cari_outlet()"><i class="fa fa-search">&nbsp;Search</i></button>
    </form>
</div>  
<hr>
<div class="col-sm-12 outlet">

  <div class="col-sm-1">
<h3>Tabel Detail Resi</h3>
  <hr>
    <div class="col-sm-5">

    <table class="table table-stripped header_total_outlet1">
  {{ csrf_field() }}
      
      <tr>
        <td>Total Tarif</td>
        <td>:</td>
        <td><input style="width: 150px;" readonly="" type="text" name="total_tarif" class="form-control total_tarif form-inline"></td>
      </tr>
      <tr>
        <td>Total Komisi Outlet</td>
        <td>:</td>
        <td><input style="width: 150px;" readonly="" type="text" name="total_komisi_outlet" class="form-control total_komisi_outlet form-inline"></td>
      </tr>
    </table>
    </div>
    <div class="col-sm-5" style="margin-left: 10%">
    <table class="table table-stripped header_total_outlet2">
      <tr>
        <td>Total Komisi Tambahan</td>
        <td>:</td>
        <td><input style="width: 150px;" readonly="" type="text" name="total_komisi_tambahan" class="form-control total_komisi_tambahan form-inline"></td>
      </tr>
      <tr>
        <td>Total Jumlah Komisi</td>
        <td>:</td>
        <td><input style="width: 150px;" readonly="" type="text" name="total_all_komisi" class="form-control total_all_komisi form-inline"></td>
      </tr>
    </table>
    </div>

      <table class="table table-bordered table-hover table_outlet" style="font-size: 12px; ">
      <button onclick="tt_penerus_outlet()" class="btn btn-info modal_outlet_tt" style="margin-right: 10px;" type="button" data-toggle="modal" data-target="#modal_tt_outlet" type="button"> <i class="fa fa-book"> </i> &nbsp; Form Tanda Terima </button>
      <button type="button" class="btn btn-primary pull-right disabled" id="save_update_outlet" onclick="save_outlet()" data-dismiss="modal">Simpan Data</button>
        
      <div class="loading text-center" style="display: none;">
          <img src="{{ asset('assets/img/loading1.gif') }}" width="100px">
        </div>
      <thead align="center">
        <tr>
        <th><input type="checkbox" class="form-control parent_check" onchange="check_parent()"></th>
        <th>
          No.Order
        </th>
        <th>
          Tanggal
        </th>
        <th>
          Kota Asal
        </th>
        <th>
          Kota Tujuan
        </th>
        <th>
          Status
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
        @foreach($data as $index => $val)
        @if($data[$index]['potd_pod'] == null or $data[$index]['potd_potid'] == $id->pot_id)
        <tr>
          <td><input @if($data[$index]['potd_pod'] != null ) checked="" @endif type="checkbox" name="chck[]" onchange="hitung_outlet(this)" class="form-control child_check" ></td>
          <td >
            {{$data[$index]['nomor']}}
            <input type="hidden" name="no_resi[]" class="form-control" value="{{$data[$index]['nomor']}}">
          </td>
          <td>
          <?php echo date('d/m/Y',strtotime($data[$index]['tanggal'])); ?>
            <input type="hidden" name="tgl[]" class="form-control" value="{{$data[$index]['tanggal']}}">
          </td>
          <td>
            {{$data[$index]['asal']}}
            <!-- <input type="hidden" name="kota_asal[]" class="form-control" value="{{$data[$index]['id_asal']}}"> -->
          </td>
          <td>
            {{$data[$index]['tujuan']}}
            <!-- <input type="hidden" name="kota_tujuan[]" class="form-control" value="{{$data[$index]['id_tujuan']}}"> -->
          </td>
          <td>
            {{$data[$index]['status']}}
            <!-- <input type="hidden" name="status[]" class="form-control" value="{{$data[$index]['status']}}"> -->
          </td>
          <td>
            {{$data[$index]['total_net']}}
            <input type="hidden" name="tarif[]" class="form-control tarif_dasar" value="{{$data[$index]['total_net']}}">
          </td>
          <td>
            {{$data[$index]['komisi']}}
            <input type="hidden" name="komisi[]" class="form-control komisi" value="{{$data[$index]['komisi']}}">
            <input type="hidden" name="comp[]" class="form-control" value="{{$data[$index]['kode_cabang']}}">
          </td>
          <td>
            {{$data[$index]['biaya_komisi']}}
            <input type="hidden" name="komisi_tambahan[]" onload="hitung_komisi(this)" class="form-control komisi_tambah" value="{{$data[$index]['biaya_komisi']}}">
          </td>
          <td >
            <span class="komisi_total">{{$data[$index]['total_komisi']}}</span>
            <input type="hidden" name="total_komisi[]" class="form-control total_komisi" value="{{$data[$index]['total_komisi']}}">
          </td>
        </tr>
        @endif
        @endforeach
      </tbody>    
      </table>
  </div>
</div>
</div>

@endsection
@section('extra_scripts')
<script type="text/javascript">

 function cari_outlet() {
  var  selectOutlet = $('.selectOutlet').val();
  var  cabang     = $('.cabang').val();
  var  reportrange  = $('.reportrange').val();
  var  id  = '{{$id}}';
  $.ajax({
      url:baseUrl +'/fakturpembelian/cari_outlet1',
      data: {selectOutlet,cabang,reportrange,id},
      success:function(data){
    
        $('.outlet').html(data);

      },error:function(){
        toastr.warning('Terjadi Kesalahan');
      }
    })
 }

$(document).ready(function(){
  cari_outlet();
});


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
