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
        <select class="form-control selectOutlet chosen-select-width1" name="selectOutlet">
          @foreach($agen as $val)
          <option @if() selected="" @endif value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
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
<div class="col-sm-6 outlet">
  
</div>
</div>

@endsection
@section('extra_scripts')
<script type="text/javascript">




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
