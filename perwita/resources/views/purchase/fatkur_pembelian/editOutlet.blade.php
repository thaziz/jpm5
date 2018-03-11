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
  <table class="table " style="font-size: 14px;">
    <tr>
      <td>No Faktur</td>
      <td><input type="text" name="no_faktur" readonly="" value="{{$data[0]->fp_nofaktur}}" class="form-control"></td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td>
       <div class="input-group date">
         <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
         <input type="text" name="tgl" readonly="" class="form-control" value="<?php echo date('d/F/Y',strtotime($data[0]->fp_tgl)) ?>">
       </div>
     </td>
    </tr>
    <tr>
      <td>Agen/Vendor/Outlet</td>
      <td><input type="text" name="pihak_ketiga" readonly="" value="{{$data[0]->nama}}" class="form-control pihak_ketiga"></td>
    </tr>
    <tr>
      <td>Keterangan</td>
      <td><textarea onkeyup="autoNote()" class="form-control note_po" id="note1" readonly="" name="note" style="min-width: 100%;max-width: 310px;min-height: 100px; max-height: 100px">{{$data[0]->fp_keterangan}}</textarea></td>
    </tr>
    <tr>
      <td>Editable</td>
      <td><input style="width: 20px;height: 20px;" type="checkbox" name="check" readonly="" class=" checker " onchange="checker()"></td>
    </tr>
    <tr>
      <td style="border:none;" colspan="2">
        @if($valid_cetak[0]->tt_nofp != null)
        <div class="cetak_tt">
         <a class="btn btn-warning pull-right" onclick="tt_print()"><i class="fa fa-print">&nbsp;Cetak Tanda Terima</i></a>
        </div>
        @else
        <div class="cetak_tt" hidden="">
         <a class="btn btn-warning pull-right" onclick="tt_print()"><i class="fa fa-print">&nbsp;Cetak Tanda Terima</i></a>
        </div>
        @endif
        <button class="btn btn-primary pull-right" style="margin-right: 10px;" type="text" onclick="modal_tt()"><i class="fa fa-book">&nbsp;Buat Tanda Terima</i></button>
      </td>
    </tr>
  </table>           
</div>  
<div class="col-sm-6 outlet">
  
</div>
  <div class="table-outlet1">
    
  </div>
<!-- SEBELUM EDIT -->
  <div class="col-sm-12 msh_hdn">
<h3>Tabel Detail Resi</h3>
  <hr>
    <div class="col-sm-5">
    <table class="table table-stripped">

      <tr>
        <td>Total Tarif</td>
        <td>:</td>
        <td><input style="width: 150px;" readonly="" type="text" value="{{'Rp ' . number_format($data[0]->pot_total_tarif)}}" name="total_tarif" class="form-control form-inline"></td>
      </tr>
      <tr>
        <td>Total Komisi Outlet</td>
        <td>:</td>
        <td><input style="width: 150px;" readonly="" type="text" value="{{'Rp ' . number_format($data[0]->pot_total_komisi_outlet)}}" name="total_komisi_outlet" class="form-control form-inline"></td>
      </tr>
    </table>
    </div>
    <div class="col-sm-5" style="margin-left: 10%">
    <table class="table table-stripped">
      <tr>
        <td>Total Komisi Tambahan</td>
        <td>:</td>
        <td><input style="width: 150px;" readonly="" type="text" name="total_komisi_tambahan" value="{{'Rp ' . number_format($data[0]->pot_total_komisi_tambah)}}" class="form-control form-inline"></td>
      </tr>
      <tr>
        <td>Total Jumlah Komisi</td>
        <td>:</td>
        <td><input style="width: 150px;" readonly="" type="text" name="total_all_komisi" value="{{'Rp ' . number_format($data[0]->pot_total_komisi)}}" class="form-control form-inline"></td>
      </tr>
    </table>
    </div>
      <table class="table table-bordered table-hover table_1" style="font-size: 12px; ">
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
          <td>
            {{$val->potd_tgl}}
          </td>
          <td>
            {{$val->potd_tarif_resi}}
          </td>
          <td>
            {{$val->potd_komisi}}
          </td>
          <td>
            {{$val->potd_komisi_tambahan}}
          </td>
          <td>
            {{$val->potd_komisi_total}}
          </td>
        </tr>
        @endforeach
      </tbody>    
      </table>
      <a href="../fakturpembelian" class="pull-right"><button class="btn btn-primary" type="button">Confirm</button></a>
  </div>
</div>
</div>

    <!-- MODAL TANDA TERIMA-->
<div id="modal_tt" class="modal fade" role="dialog">
  <div class="modal-dialog" style="min-width: 800px !important; min-height: 800px">
    <div class="modal-content" >
      <div class="modal-header">
        <button style="min-height:0;" type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title" style="text-align: center;"><b>Tambah Data Tanda Terima</h2>
      </div>
      <div class="modal-body">
        <table class="table table_terima" style="font-size: 14px;">
          <tr>
            <td>No Tanda Terima</td>
            <td>
              @if($valid_cetak[0]->tt_noform == null)
              <input type="text" name="no_tt" readonly="" class="form-control" value="{{$nota}}">
              @else
              <input type="text" name="no_tt" readonly="" class="form-control" value="{{$valid_cetak[0]->tt_noform}}">
              @endif
            </td>
          </tr>
          <tr>
            <td>Tanggal</td>
            <td>
              @if($valid_cetak[0]->tt_tgl == null)
              <input type="text" name="modal_tanggal" class="form-control modal_tanggal" value="">
              @else
               <input type="text" name="modal_tanggal" class="form-control modal_tanggal" value="<?php echo date('d-F-Y',strtotime($valid_cetak[0]->tt_tgl)); ?>">
              @endif
            </td>
          </tr>
          <tr>
            <td>Agen/Vendor/Outlet</td>
            <td><input type="text" name="modal_vendor" class="form-control" readonly="" value="{{$data[0]->nama}}"></td>
          </tr>
          <tr>  
            <td colspan="2" style="font-size: 12px;">
              @if($valid_cetak[0]->tt_noform == null)
              <input type="checkbox" name="Kwitansi" style="margin-right: 10px;" checked=""><label style=" margin-right: 10%;">Kwitansi/Invoice/No</label>
              <input type="checkbox" name="Faktur" style="margin-right: 10px;" checked=""><label style=" margin-right: 10%;">Faktur Pajak</label>
              <input type="checkbox" name="Peranan" style="margin-right: 10px;" checked=""><label style=" margin-right: 10%;">Surat Peranan Asli</label>
              <input type="checkbox" name="Jalan" style="margin-right: 10px;" checked=""><label style=" margin-right: 0%;">Surat Jalan Asli</label>
              @else

                @if($valid_cetak[0]->tt_kwitansi == 'TIDAK ADA')
                  <input type="checkbox" name="Kwitansi" style="margin-right: 10px;">
                  <label style=" margin-right: 10%;">Kwitansi/Invoice/No</label>
                @else
                  <input type="checkbox" name="Kwitansi" style="margin-right: 10px;" checked="">
                  <label style=" margin-right: 10%;">Kwitansi/Invoice/No</label>
                @endif

                @if($valid_cetak[0]->tt_faktur == 'TIDAK ADA')
                  <input type="checkbox" name="Faktur" style="margin-right: 10px;">
                  <label style=" margin-right: 10%;">Faktur Pajak</label>
                @else
                  <input type="checkbox" name="Faktur" style="margin-right: 10px;" checked="">
                  <label style=" margin-right: 10%;">Faktur Pajak</label>
                @endif

                @if($valid_cetak[0]->tt_suratperan == 'TIDAK ADA')
                  <input type="checkbox" name="Peranan" style="margin-right: 10px;">
                  <label style=" margin-right: 10%;">Surat Peranan Asli</label>
                @else
                  <input type="checkbox" name="Peranan" style="margin-right: 10px;" checked="">
                  <label style=" margin-right: 10%;">Surat Peranan Asli</label>
                @endif

                @if($valid_cetak[0]->tt_suratjalanasli == 'TIDAK ADA')
                  <input type="checkbox" name="Jalan">
                  <label style=" margin-right: 0%;">Surat Jalan Asli</label>
                @else
                  <input type="checkbox" name="Jalan"@ checked="">
                  <label style=" margin-right: 0%;">Surat Jalan Asli</label>
                @endif
              @endif
            </td>
          </tr>
          <tr>
            <td>Lain Lain</td>
             <td>
              @if($valid_cetak[0]->tt_noform == null)
              <input type="text" name="modal_lain" class="form-control" value="">
              @else
              <input type="text" name="modal_lain" class="form-control" value="{{$valid_cetak[0]->tt_lainlain}}">
              @endif
             </td>
          </tr>
          <tr>
          <td>Tanggal Kembali</td>
          <td>
           <div class="input-group date">
             <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
             @if($valid_cetak[0]->tt_noform == null)
             <input type="text" name="tgl_terima"  class="form-control tgl_terima" >
             @else
             <input type="text" name="tgl_terima"  class="form-control tgl_terima" value="<?php echo date('d-F-Y',strtotime($valid_cetak[0]->tt_tglkembali)); ?>">
             @endif
           </div>
         </td>
        </tr>
          <tr>
            <td>Total di Terima</td>
             <td>
              @if($valid_cetak[0]->tt_noform == null)
              <input type="text" name="total_terima" class="form-control total_terima" value="{{'Rp ' . number_format($data[0]->pot_total_komisi,2,',','.')}}">
              @else
              <input type="text" name="total_terima" class="form-control total_terima" value="{{'Rp ' . number_format($valid_cetak[0]->tt_totalterima,2,',','.')}}">
              @endif
            </td>
          </tr>
        </table>
      <div align="right">
        <hr>
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" id="save-tt" onclick="save_tt()"  data-dismiss="modal">Save changes</button>
      </div> 
      </div>    
    </div> 
  </div>
</div>
@endsection
@section('extra_scripts')
<script type="text/javascript">



  var asd = $('.total_terima').maskMoney({thousands:'.', decimal:',', prefix:'Rp '});


var table_1 = $('.table_1').DataTable({searching:false});

var addDays = new Date();
addDays.setDate(addDays.getDate() + 30);
var d = new Date();
d.setDate(d.getDate());

@if($valid_cetak[0]->tt_tgl == null)
   $('.tgl_terima').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
    }).datepicker("setDate", addDays);
@else
   $('.tgl_terima').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
    });
@endif

@if($valid_cetak[0]->tt_tgl == null)
$('.modal_tanggal').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
    }).datepicker("setDate", d);
@else
$('.modal_tanggal').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
    });
@endif

function modal_tt(){
  $('#modal_tt  ').modal('show');
}

function checker(){

var checker =$('.checker:checked').val();
var harga =  "{{'Rp ' . number_format($data[0]->pot_total_komisi)}}";
console.log(checker);
if(checker != undefined){
   $.ajax({
        url:baseUrl + '/fakturpembelian/getpembayaranoutlet',
        type:'get',
        success:function(data){
          $('.outlet').html(data);
         $('.reportrange').daterangepicker({
                autoclose: true,
                "opens": "left",
            locale: {
              format: 'DD/MM/YYYY'
          }
            
         });

         $('.reportrange').val('{{$tgl1}} - {{$tgl2}}'  );
        }

      })

    cari_outlet();
    $('.msh_hdn').attr('hidden',true);
}else{
  $('.outlet').html('');
  $('.table-outlet1').html('');
  $('.msh_hdn').attr('hidden',false);
  $('.total_terima').val(harga);
}
}

function  cari_outlet(){
   $('.loading').css('display', 'block');
 var agen = $('.selectOutlet').val();
      $.ajax({
      url:baseUrl + '/fakturpembelian/cari_outlet1/'+agen,
      type:'post',
      data:'id={{$id}}'+'&'+$('.head-outlet :input').serialize(),
      success:function(data){
         $('.loading').css('display', 'none');
        $('.table-outlet1').html(data);
      }

    })
}
function replace_outlet(){
  var outlet = $('option:selected').val();
  @foreach($agen as $val)
    if('{{$val->kode}}' == outlet){
      $('.pihak_ketiga').val('{{$val->nama}}');
    }
  @endforeach
}

function rubahNote(){
  var note_awal = $('#note').val();
  console.log(note_awal)
  $('#note1').val(note_awal);
}

function save_outlet1(){
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      $.ajax({
      url:baseUrl + '/fakturpembelian/update_outlet',
      type:'post',
      data:'id='+id+'&'+ $('.header_total_outlet1 :input').serialize()+'&'+ $('.header_total_outlet2 :input').serialize()+'&'+ $('.head-outlet :input').serialize()+'&'+ datatable2.$('input').serialize(),
      success:function(response){

      },
      error:function(data){

   }
  }); 
}


function save_tt1(){
  var faktur = "{{$data[0]->fp_nofaktur}}";
  faktur = faktur.toString();

  $.ajax({
      url:baseUrl + '/fakturpembelian/simpan_tt',
      type:'get',
      data:'id={{$id}}'+'&'+'nota='+faktur+'&'+'supplier='+"{{$data[0]->pot_kode_outlet}}"+'&'+$('.table_terima :input').serialize(),
      success:function(response){
        if(response.status[0] == '1'){
        toastr.success("Data Berhasil Disimpan")
      }else{
        toastr.success("Data Berhasil Diupdate");
      }
      },
      error:function(data){
        toastr.success("Terjadi kesalahan");
   }
  }); 
}

function save_tt(){

  var faktur = "{{$data[0]->fp_nofaktur}}";
  faktur = faktur.toString();

  try{
  save_outlet1();
  }catch(err){

  }
  swal({
    title: "Apakah anda yakin?",
    text: "Update Biaya Penerus!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Simpan!",
    cancelButtonText: "Batal",
    closeOnConfirm: true
  },
  function(){

   $.ajax({
      url:baseUrl + '/fakturpembelian/simpan_tt',
      type:'get',
      data:'id={{$id}}'+'&'+'nota='+faktur+'&'+'supplier='+"{{$data[0]->pot_kode_outlet}}"+'&'+$('.table_terima :input').serialize(),
      success:function(response){
        if(response.status[0] == '1'){
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data berhasil disimpan",
                timer: 900,
               showConfirmButton: true
                },function(){
                   // location.href='../fakturpembelian';
                   $('.cetak_tt').attr('hidden',false);
        });
      }else{
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data berhasil disimpan",
                timer: 900,
               showConfirmButton: true
                },function(){
                   // location.href='../fakturpembelian';
                   $('.cetak_tt').attr('hidden',false);
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

function tt_print(){
  @if($valid_cetak[0]->tt_tgl == null)
  var win = window.open('../cetak_tt?nota={{$nota}}&id={{$id}}');
  @else
  var win = window.open('../cetak_tt?nota={{$valid_cetak[0]->tt_noform}}&id={{$id}}');
  @endif
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
