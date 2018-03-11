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
  td{
    font-size: 14px;
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
  {{ csrf_field() }}
  <div class="row">
    <!-- HEADER -->

    <!-- body -->
<div class="ibox" style="padding-top: 10px;" >
<div class="ibox-title"><h5>Detail Faktur Pembelian</h5>
  <a href="../fakturpembelian" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
</div>
<div class="ibox-content col-sm-12">

<div class="col-sm-5 header_biaya"  >
  {{ csrf_field() }}
<form >
<table class="table head_subcon">
  <h3 style="text-align: center;">Form Subcon</h3>
 <tr>
  <td style="width: 100px">Jatuh Tempo</td>
  <td width="10">:</td>
  <td width="200">
    <input type="text" readonly="" name="tempo_subcon" class="form-control tempo_subcon" value="{{$data->fp_jatuhtempo}}" style="width: 250px;">
  </td>
 </tr>
<tr>
  <td style="width: 100px">Status </td>
  <td width="10">:</td>
  <td width="200"><input type="text" name="status" class="form-control" value="Released" readonly="" style="width: 250px;"></td>
 </tr>
 <tr class=" hd2" >
  <td style="width: 100px">Persentase</td>
  <td width="10">:</td>
  <td width="200">
    <select class="form-control persen_subcon chosen-select-width1" name="persen_subcon">
        <option value="0">- Cari - Subcon -</option>
      @foreach($persen as $sub)
        @if($sub->kode == $data->pb_id_persen )
        <option selected="" value="{{$sub->kode}}">{{$sub->kode_akun}} - {{$sub->nama}}</option>
        @else
        <option value="{{$sub->kode}}"> {{$sub->kode_akun}} - {{$sub->nama}}</option>
        @endif
      @endforeach
    </select>
  </td>
  </tr>
  <tr class=" hd2" >
  <td style="width: 100px">Nama Subcon</td>
  <td width="10">:</td>
  <td width="200">
    <input type="text" style="width: 250px;" readonly="" class="form-control nama_sc" name="nama_subcon" value="{{$data->nama}}">
  </td>
  </tr> 
<!--  <tr class=" hd2" >
  <td style="width: 100px">Kontrak Subcon</td>
  <td width="10">:</td>
  <td width="200" class="kontrak_subcon">
    <select class="form-control">
      <option> - Cari-Kontrak - </option>
    </select>
  </td>
 </tr> -->
 <tr>
  <td style="width: 100px">No Invoice </td>
  <td width="10">:</td>
  <td width="200"><input type="text" name="invoice_subcon" value="{{$data->fp_noinvoice}}" class="form-control invoice_subcon"  style="width: 250px;"></td>
 </tr>  
 <tr>
  <td style="width: 100px">Keterangan </td>
  <td width="10">:</td>
  <td width="200"><input type="text" name="keterangan_subcon" value="{{$data->fp_keterangan}}" class="form-control keterangan_subcon"  style="width: 250px;"></td>
 </tr>  
 <tr>
      <td style="border:none;" colspan="3">
        @if($valid_cetak[0]->tt_nofp != null)
        <div class="cetak_tt">
         <a class="btn btn-warning pull-right" onclick="tt_print()"><i class="fa fa-print">&nbsp;Cetak Tanda Terima</i></a>
        </div>
        @else
        <div class="cetak_tt" hidden="">
         <a class="btn btn-warning pull-right" onclick="tt_print()"><i class="fa fa-print">&nbsp;Cetak Tanda Terima</i></a>
        </div>
        @endif
        <button type="button" class="btn btn-primary pull-right" style="margin-right: 10px;" type="text" onclick="modal_tt()"><i class="fa fa-book">&nbsp;Buat Tanda Terima</i>
        </button>
      </td>
</tr>
</table>
</form>
</div>


<div class="col-sm-5 table_filter_subcon"   style="margin-left: 100px;">
    <form class="form">
     <table class="table">
     <div align="center" style="width: 100%;">  
    <h3 >Detail Kontrak Subcon</h3>
   </div> 
    <tr>
    <td style="width: 100px">Nomor</td>
    <td width="10">:</td>
    <td width="200">
      <input type="text" name="no_kontrak_subcon" class="form-control nota_subcon" value="{{$pilih[0]->ks_nota}}" readonly="">
      <input type="hidden" value="{{$pilih[0]->ks_id}}" name="id_subcon" class="form-control id_subcon"  readonly="">
      <input type="hidden" name="dt_subcon" value="{{$pilih[0]->ksd_id}}" class="form-control dt_subcon"  readonly="">
      <input type="hidden" name="id_fp" value="{{$id}}" class="form-control id_fp"  readonly="">
    </td>
    </tr>
    <tr>
    <td style="width: 100px">Biaya Subcon</td>
    <td width="10">:</td>
    <td width="200">
      <input type="text" class="form-control biaya_subcon"  readonly="" value="{{number_format($pilih[0]->ksd_harga,2,',','.')}}" >
      <input type="hidden" class="form-control biaya_subcon_dt" value="{{$pilih[0]->ksd_harga}}" >
    </td>
    </tr>
    <tr>
    <td style="width: 100px">Jenis Tarif</td>
    <td width="10">:</td>
    <td width="200">

      <input type="text" name="tarif_subcon" class="form-control tarif_subcon" readonly="" value="{{$pilih[0]->ksd_jenis_tarif}}" >
      <input type="hidden" name="kode_tarif_subcon" class="form-control tarif_subcon" style="width: 250px;">
    </td>
    </tr>
    <tr>
    <td style="width: 100px">Kendaraaan</td>
    <td width="10">:</td>
    <td width="200">

      <input type="text" class="form-control kendaraan_subcon" readonly=""  value="{{$angkutan->nama}}">
      <input type="hidden" class="form-control kode_angkutan" style="width: 250px;">
    </td>
    </tr>
  </table>
<!--    <tr>
    <td colspan="3">
      <div style="display: inline-block; width: 49%;">
        <label>Asal</label>
        <input type="text" readonly="" class="asal_table_subcon form-control"  >
      </div>
      <div style="display: inline-block; width: 50%;">
        <label>Tujuan</label>
        <input type="text" readonly="" class="tujuan_table_subcon form-control"  >
      </div>
    </td>
    </tr> -->
    <table class="table">
      <div align="center" style="width: 100%;"> 
      <h3 >Form Resi Subcon</h3>
    </div>  
    <tr>
    <td style="width: 100px">Nomor Seq</td>
    <td width="10">:</td>
    <td width="200">

      <input type="text" class="form-control seq_subcon" readonly="" >
      <input type="hidden" class="form-control status_seq" style="width: 250px;">
    </td>
    </tr>
     <tr>
    <td style="width: 100px">Nomor POD</td>
    <td width="10">:</td>
    <td width="200">

      <input type="text" class="form-control pod_subcon" onkeyup="cariDATASUBCON(this.value)" >
      <input type="hidden" class="form-control status_pod_subcon" style="width: 250px;">
    </td>
    </tr>
    <tr>
    <td style="width: 100px">Tarif POD</td>
    <td width="10">:</td>
    <td width="200">
      <input type="text" class="tarif_pod_subcon form-control" readonly="" >
    </td>
    </tr>
     <tr>
    <td style="width: 100px" class="label_satuan">Berat (KG)</td>
    <td width="10">:</td>
    <td class="form-inline form_satuan">
      <div class="input-group" style="width: 100%">
                <input  style="width: 100%" class="form-control berat_subcon" type="text" value="" >
                <span class="input-group-addon" style="padding-bottom: 12px;">KG</span>
             </div>
    </td>
    </tr>
    <tr>
    <td style="width: 100px">Total Biaya</td>
    <td width="10">:</td>
    <td width="200"><input type="text" readonly=""  class="form-control total_subcon"></td>
    </tr>
    <tr>
    <td style="width: 100px">Memo</td>
    <td width="10">:</td>
    <td width="200">
      <input type="text"  class="form-control memo_subcon" >
      <input type="hidden"  class="form-control comp_subcon" >

    </td>
   </tr>
     </table>
     <button type="button" class="btn btn-primary pull-right" onclick="cariSUB();"><i class="fa fa-search">&nbsp;Append</i></button>
    </form>
</div>

<div class="col-sm-5 table_filter_resi disabled " hidden   style="margin-left: 100px;">
    <form class="form">
     <table class="table">
     <div align="center" style="width: 100%;">  
    <h3 >Detail Biaya Penerus Hutang</h3>
   </div> 
    
     </table>
     <button type="button" class="btn btn-primary pull-right cari-pod" onclick="cariSUB();"><i class="fa fa-search">&nbsp;Search</i></button>
    </form>
</div>

 <div class=" col-sm-12 tb_sb_hidden">
  <h3>Tabel Detail Resi</h3>
  <hr>
      <table class="table table-bordered table-hover tabel_subcon">
      <thead align="center" style="font-size: 12px;">
        <tr>
        <th>No</th>
        <th width="90">Nomor Resi</th>
        <th>Harga Resi</th>
        <th>Tarif Subcon</th>
        <th>Multiply</th>
        <th>Keterangan</th>
        <th width="50">Aksi</th>
        </tr>
      </thead> 
      <tbody align="center" class="body-biaya">
        @foreach($data_dt as $i => $val)
          <tr>
            <td>
              {{$i+1}}
              <div class="checkbox checkbox-info checkbox-circle">
              <input type="hidden" class="seq_sub sub_seq_'+seq+'"  value="{{$i+1}}" >
            </td>
            <td>
              {{$val->pbd_resi}}
              <input type="hidden" class="dt_resi_subcon"  name="resi_subcon[]" value="{{$val->pbd_resi}}" >
            </td>
            <td>
              {{$val->pbd_tarif_resi}}
              <input type="hidden" class="harga_resi"  name="harga_resi[]" value="{{$val->pbd_tarif_resi}}" >
            </td>
            <td>
              {{$val->pbd_tarif_harga}}
              <input type="hidden" class="harga_tarif"  name="harga_tarif[]" value="{{$val->pbd_tarif_harga}}" >
            </td>
            <td>
              @if($pilih[0]->ksd_jenis_tarif == 'KILOGRAM')
              {{$val->pbd_berat}}
              <input type="hidden" name="kg[]" class="berat_tabel" value="{{$val->pbd_berat}}" >
              @else
              {{$val->pbd_berat}}
              <input type="hidden" name="trip[]" class="berat_tabel" value="{{$val->pbd_berat}}" >
              @endif
            </td>
            <td>
              {{$val->pbd_keterangan}}
              <input type="hidden" name="ket_subcon[]" value="{{$val->pbd_keterangan}}" >
            </td>
            <td>
              <a class="btn btn-danger fa fa-trash" align="center" onclick="hapus_subcon(this)" title="hapus"></i></a>
            </td>
          </tr>
        @endforeach
      </tbody>    
      </table>
      <button type="button" class="btn btn-primary pull-right" id="save-update" onclick="save_subcon()" data-dismiss="modal">Simpan Data</button>
  </div>
  
<div id="modal_subcon" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 800px;">

    <!-- Modal content-->
    <div id="subcon_modal" class="modal-content" >
      <div class="modal-header">
        <button style="min-height:0;" type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Kontrak Subcon</h4>
      </div>
        <div class="modal-body subcon_modal">

      <div class="pull-right">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-update" onclick="sve()" data-dismiss="modal">Save changes</button>
      </div>
      </div>      
    </div>
      
  </div>
</div>
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
               <input type="text" name="modal_tanggal" class="form-control modal_tanggal" value="<?php echo date('d/m/Y',strtotime($valid_cetak[0]->tt_tgl)); ?>">
              @endif
            </td>
          </tr>
          <tr>
            <td>Subcon</td>
            <td><input type="text" name="modal_vendor" class="form-control" readonly="" value="{{$data->nama}}"></td>
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
                <div class="checkbox checkbox-info checkbox-circle" style="display: inline-block;">
                  <input type="checkbox" name="Kwitansi" style="margin-right: 10px;">
                  <label style=" margin-right: 10%;">Kwitansi/Invoice/No</label>
                </div>

                @else
                <div class="checkbox checkbox-info checkbox-circle" style="display: inline-block;">
                  <input type="checkbox" name="Kwitansi" style="margin-right: 10px;" checked="">
                  <label style=" margin-right: 10%;">Kwitansi/Invoice/No</label>
                </div>

                @endif

                @if($valid_cetak[0]->tt_faktur == 'TIDAK ADA')
                <div class="checkbox checkbox-info checkbox-circle" style="display: inline-block; width: ">
                  <input type="checkbox" name="Faktur" style="margin-right: 10px;">
                  <label style=" margin-right: 10%;">Faktur Pajak</label>
                </div>

                @else
                <div class="checkbox checkbox-info checkbox-circle" style="display: inline-block;">
                  <input type="checkbox" name="Faktur" style="margin-right: 10px;" checked="">
                  <label style=" margin-right: 10%;">Faktur Pajak</label>
                </div>

                @endif

                @if($valid_cetak[0]->tt_suratperan == 'TIDAK ADA')
                <div class="checkbox checkbox-info checkbox-circle" style="display: inline-block;">
                  <input type="checkbox" name="Peranan" style="margin-right: 10px;">
                  <label style=" margin-right: 10%;">Surat Peranan Asli</label>
                </div>

                @else
                <div class="checkbox checkbox-info checkbox-circle" style="display: inline-block;">
                  <input type="checkbox" name="Peranan" style="margin-right: 10px;" checked="">
                  <label style=" margin-right: 10%;">Surat Peranan Asli</label>
                </div>

                @endif

                @if($valid_cetak[0]->tt_suratjalanasli == 'TIDAK ADA')
                <div class="checkbox checkbox-info checkbox-circle" style="display: inline-block;">
                  <input type="checkbox" name="Jalan">
                  <label style=" margin-right: 0%;">Surat Jalan Asli</label>
                </div>
                @else
                <div class="checkbox checkbox-info checkbox-circle" style="display: inline-block;">
                  <input type="checkbox" name="Jalan" checked="">
                  <label style=" margin-right: 0%;">Surat Jalan Asli</label>
                </div>
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
             <input type="text" name="tgl_terima"  class="form-control tgl_terima" value="">
             @else
             <input type="text" name="tgl_terima"  class="form-control tgl_terima" value="<?php echo date('d/m/Y'); ?>">
             @endif
           </div>
         </td>
        </tr>
          <tr>
            <td>Total di Terima</td>
             <td>
              <input type="text" name="total_terima" class="form-control total_terima" value="{{'Rp ' . number_format($data->fp_netto,2,',','.')}}"> 
            </td>
          </tr>
        </table>
      <div align="right">
        <hr>
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" id="saver" onclick="save_tt()"  data-dismiss="modal">Save changes</button>
      </div> 
      </div>    
    </div> 
  </div>
</div>
@endsection
@section('extra_scripts')
<script type="text/javascript">
var sequence=[];
var total = [];
$(document).ready(function(){
  var asd = $('.total_terima').maskMoney({thousands:'.', decimal:',', prefix:'Rp '});
  @foreach($data_dt as $val)
    sequence.push({{$val->pbd_pb_dt}})
    total.push({{$val->pbd_tarif_resi}})
  @endforeach

  $('.seq_subcon').val(sequence.length+1);
  $('.id_subcon').val('{{$pilih[0]->ks_id}}');
  $('.dt_subcon').val('{{$pilih[0]->ksd_ks_dt}}');

  var a = 0
  for(var i = 0; i<total.length; i++){
    a+=Math.round(total).toFixed(0);
  }

  
  if ($('.tarif_subcon').val() == 'KILOGRAM') {
          var label = 'Berat (KG)';
          var html  = '<div class="input-group" style="width: 100%">'
                     +'<input  style="width: 100%" class="form-control berat_subcon" type="text" value="" >'
                       +'<span class="input-group-addon" style="padding-bottom: 12px;">KG</span>'
                   +'</div>';
              $('.label_satuan').html(label);
              $('.form_satuan').html(html);

              $('.berat_subcon').keyup(function(){
          var data = $(this).val();
          var total_subcon = $('.biaya_subcon_dt').val();
          total_subcon = Math.round(total_subcon).toFixed(0);
          $('.total_subcon').val(accounting.formatMoney(data * total_subcon,'', 2, ".",','));

        });
        }else{
          var label = 'Trip';
          var html  = '<div class="input-group" style="width: 100%">'
                     +'<input  style="width: 100%" class="form-control trip_subcon" type="number" value="" >'
                       +'<span class="input-group-addon" style="padding-bottom: 12px;">Trip</span>'
                   +'</div>';
              $('.label_satuan').html(label);
              $('.form_satuan').html(html);

              $('.trip_subcon').keyup(function(){
          var data = $(this).val();
          var total_subcon = $('.biaya_subcon_dt').val();
          total_subcon = Math.round(total_subcon).toFixed(0);
          $('.total_subcon').val(accounting.formatMoney(data * total_subcon,'', 2, ".",','));

        });
        }

});


$('.modal_tanggal').datepicker();
$('.tgl_terima').datepicker();
var config1 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width1'     : {width:"250px"}
             }
             for (var selector in config1) {
               $(selector).chosen(config1[selector]);
             }   
var subcon = $('.tabel_subcon').DataTable({
          // 'paging':false,
          'searching':false,
          "ordering": false
        });

$('.tempo_subcon').datepicker();
function modal_tt(){
  $('#modal_tt  ').modal('show');
}
function cari_subcon(){
  var asal  = $('.asal_subcon').val();
  var tujuan  = $('.tujuan_subcon').val();
  console.log(asal);
  if(asal != null && tujuan != null){
    $.ajax({
      url : baseUrl +'/fakturpembelian/cari_subcon',
      data: 'asal='+asal+'&'+'tujuan='+tujuan,
      type:'get',
      success:function(response){
        if(response.status == 1){
          $('.nama_sc').html('');
          $('.nama_sc').html('<option value="">- Pilih Subcon -</option>');
          
          for(var i = 0; i<response.data.length;i++){
            var html = '<option value="'+response.data[i].ks_nama+'">'+response.data[i].nama+'</option>';

            $('.nama_sc').append(html);
            $('.nama_sc').trigger("chosen:updated");
            $('.tr_disabled').removeClass('disabled');
          }
        }else{
          console.log('asd');
          $('.nama_sc').html('');

          var html = '<option value="0">Data tidak Ditemukan</option>';

            $('.nama_sc').html(html);
            $('.nama_sc').trigger("chosen:updated");
            $('.tr_disabled').removeClass('disabled');

            

        }
      }
    });
  }
}

function radio(){
  var rad = $('.rad:checked').val();
  if (rad == 1) {
    $('.hd1').attr('hidden',false);
    $('.hd2').attr('hidden',false);
    $('.hd3').attr('hidden',true);
    $('.table_filter_subcon').attr('hidden',false);
    $('.table_filter_resi').attr('hidden',true);


    $('.hd').addClass('animated')
    $('.hd').addClass('fadeInRight')

  }else{
    $('.hd1').attr('hidden',true);
    $('.hd2').attr('hidden',true);
    $('.hd3').attr('hidden',false);
    $('.table_filter_subcon').attr('hidden',true);
    $('.table_filter_resi').attr('hidden',false);

  }
}

$('.btn_cari').click(function(){

// $('.detail_biaya ').removeClass('disabled');
var id = $('.nama_sc').val();
if (id == '0') {
  toastr.warning('data tidak ada')
  return 1;
}

$.ajax({
  url:baseUrl +'/master_subcon/cari_kontrak/'+id,
  success:function(response){
    $('.subcon_modal').html(response);
    $('#modal_subcon').modal('show');
  },
  error:function(){
    toastr.warning('Data tidak ditemukan');
  }
});

});

function pilih_kontrak(asd){
  var id = $(asd).find('.id_kontrak').val();
  // var dt = $(asd).find('.dt_kontrak').val();

  $.ajax({
    url : baseUrl +'/fakturpembelian/pilih_kontrak',
      data: 'id='+id,
      type:'get',
      success:function(response){
        console.log(response.subcon_dt[0].ksd_nota);
        $('.nota_subcon').val(response.subcon_dt[0].ksd_nota);
        $('.biaya_subcon').val(response.subcon_dt[0].ksd_harga);
        $('.biaya_subcon_dt').val(response.subcon_dt[0].ksd_harga2);
        $('.id_subcon').val(response.subcon_dt[0].ksd_id);
        $('.dt_subcon').val(response.subcon_dt[0].ksd_dt);
        $('.tarif_subcon').val(response.subcon_dt[0].ksd_jenis_tarif);
        $('.kendaraan_subcon').val(response.subcon_dt[0].ksd_angkutan);
        $('.table_filter_subcon').removeClass('disabled');

        if (response.subcon_dt[0].ksd_jenis_tarif == 'KILOGRAM') {
          var label = 'Berat (KG)';
          var html  = '<div class="input-group" style="width: 100%">'
                     +'<input  style="width: 100%" class="form-control berat_subcon" type="text" value="" >'
                       +'<span class="input-group-addon" style="padding-bottom: 12px;">KG</span>'
                   +'</div>';
              $('.label_satuan').html(label);
              $('.form_satuan').html(html);

              $('.berat_subcon').keyup(function(){
          var data = $(this).val();
          var total_subcon = $('.biaya_subcon_dt').val();
          total_subcon = Math.round(total_subcon).toFixed(0);
          $('.total_subcon').val(accounting.formatMoney(data * total_subcon,'', 2, ".",','));

        });
        }else{
          var label = 'Trip';
          var html  = '<div class="input-group" style="width: 100%">'
                     +'<input  style="width: 100%" class="form-control trip_subcon" type="number" value="" >'
                       +'<span class="input-group-addon" style="padding-bottom: 12px;">Trip</span>'
                   +'</div>';
              $('.label_satuan').html(label);
              $('.form_satuan').html(html);

              $('.trip_subcon').keyup(function(){
          var data = $(this).val();
          var total_subcon = $('.biaya_subcon_dt').val();
          total_subcon = Math.round(total_subcon).toFixed(0);
          $('.total_subcon').val(accounting.formatMoney(data * total_subcon,'', 2, ".",','));

        });
        }
      }
  })

  $('#modal_subcon').modal('hide');
}

function cariDATASUBCON(asd){
    // console.log(asd);
    $('.pod_subcon').autocomplete({
      source:baseUrl + '/fakturpembelian/caripodsubcon', 
      minLength: 3,
       change: function(event, ui) {
        try{
        console.log(ui.item.validator);
        if(ui.item.validator != null){
            toastr.warning('Data sudah didaftarkan');
            $(this).val("");
            $('.tarif_pod_subcon').val("0");
            $('.status_pod_subcon').val("");
            
          }else{
            $('.status_pod_subcon').val(ui.item.id);
            $('.status_pod_subcon').val(ui.item.id);
            $('.seq_subcon').val(sequence.length+1);
            $('.comp_subcon').val(ui.item.comp);
            var asd = accounting.formatMoney(ui.item.harga,'', 2, ".",',');
          $('.tarif_pod_subcon').val(asd);
          }
        
      }catch(err){

      }
    }

    });
}


function cariSUB(){

    var valPo        = $('.status_pod_subcon').val();
    var tarif_subcon = $('.tarif_subcon').val();
    tarif_subcon
    var seq          = $('.seq_subcon').val();
    var bayar        = $('.tarif_pod_subcon ').val();
    bayar        = bayar.replace(/[^0-9\-]+/g,"");
    bayar            = bayar/100;
    var ket          = $('.memo_subcon').val();
    var tot_sub      = $('.total_subcon').val();
    var comp         = $('.comp_subcon').val();
    tot_sub      = tot_sub.replace(/[^0-9\-]+/g,"");
    tot_sub          = tot_sub/100;
    // var harga_resi    = $('.total_pod').val();
    var berat_subcon = $('.berat_subcon').val();
    var trip_subcon  = $('.trip_subcon').val();

    var index = sequence.indexOf(valPo);
    console.log(berat_subcon)
    if (valPo != '') {
       if(index == -1){

        if (tarif_subcon == 'KILOGRAM') {
          var html = berat_subcon+'<input type="hidden" name="kg[]" class="berat_tabel" value="'+berat_subcon+'" >';
        }else{
          var html = trip_subcon+'<input type="hidden" name="trip[]" class="berat_tabel" value="'+trip_subcon+'" >';
        }

        subcon.row.add( [
                  seq+'<input type="hidden" class="seq_sub sub_seq_'+seq+'"  value="'+seq+'" >'
                  +'<input type="hidden" name="comp_subcon[]" value="'+comp+'" >',
                  valPo+'<input type="hidden" class="dt_resi_subcon"  name="resi_subcon[]" value="'+valPo+'" >',
                  Math.round(bayar).toFixed(2)+'<input type="hidden" class="harga_resi"  name="harga_resi[]" value="'+bayar+'" >',
                  Math.round(tot_sub).toFixed(2)+'<input type="hidden" name="harga_tarif[]" class="harga_tarif" value="'+tot_sub+'" >',
                  html,
                  ket+'<input type="hidden" name=ket_subcon[]" value="'+ket+'" >',
                  '<a class="btn btn-danger fa fa-trash" align="center" onclick="hapus_subcon(this)" title="hapus"></i></a>'
              ] ).draw( false );   
  // class="seq_sub sub_seq_'+seq+'"
        sequence.push(valPo); 
       
       $('.tb_sb_hidden').attr('hidden',false);
       $('.status_pod_subcon').val('');
       $('.berat_subcon').val('');
       $('.memo_subcon').val('');


      }else{
        toastr.warning('Data Sudah Ada');
      }
  }else{
      toastr.warning('Data Tidak Ada');

  }
       $('.pod_subcon ').focus();
       $('.pod_subcon ').val('');
       $('.tarif_pod_subcon ').val('');
       $('.total_subcon ').val('');
       $('.trip_subcon ').val('');
       $('.berat_subcon ').val('');

      var temp = 0;
      $('.harga_tarif').each(function(){
        temp += parseInt($(this).val());

      });
      temp = accounting.formatMoney(temp,'Rp. ', 2, ".",',')
      $('.total_terima').val(temp);

}
// var cariSUb = [];
// function hapus_subcon(p){
// var par = p.parentNode.parentNode;

//     var resi = $(par).find('.dt_resi_subcon').val();
//     var kg = $(par).find('.bayar_biaya').val();
//     var debet = $(par).find('.debet_biaya').val();
//     var ket = $(par).find('.ket_biaya').val();
//     cariSeq[0] = 'sub_seq_'+$(par).find('.seq_sub').val();

//     $('#subcon_modal').modal('show');
//     $(".kode_akun_update").val(kode);
//     $(".nama_akun_update").val(kode).trigger("chosen:updated");
//     $(".debit_update").val(debet);
//     $(".ket_biaya_update").val(ket);
//     $(".nominal_update").val(bayar);
// }

function hapus_subcon(o){
    var ini = o.parentNode.parentNode;
    var cari = $(ini).find('.dt_resi_subcon').val();
    var temp1=0;
    var cariIndex = sequence.indexOf(cari);
    sequence.splice(cariIndex,1);
    
 
    subcon.row(ini).remove().draw(false);

     var temp = 0;
      $('.harga_tarif').each(function(){
        temp += parseInt($(this).val());

      });
      temp = accounting.formatMoney(temp,'Rp. ', 2, ".",',')
      $('.total_terima').val(temp);
   }



function save_subcon(){
  var id_subcon = $('.id_subcon').val();
  var id_fp = $('.id_fp').val();
  var persen = $('.persen_subcon').val();
  var dt_subcon = $('.dt_subcon').val();
  var invoice_subcon = $('.invoice_subcon').val();
  var tempo_subcon = $('.tempo_subcon').val();
  var nofaktur = $('.tempo_subcon').val();
  var tempo_subcon = $('.tempo_subcon').val();
  var tarif_subcon = $('.tarif_subcon').val();
  var ket = $('.keterangan_subcon').val();

  swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data Subcon!",
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
      url:baseUrl + '/fakturpembelian/subcon_update',
    data:'id='+id_subcon
        +'&'+'dt='+dt_subcon
        +'&'+'persen='+persen
        +'&'+'id_fp='+id_fp
        +'&'+'tarif_subcon='+tarif_subcon
        +'&'+'ket='+ket
        +'&'+'nofaktur='+'{{$data->fp_nofaktur}}'
        +'&'+'tempo='+tempo_subcon
        +'&'+'invoice='+invoice_subcon
        +'&'+subcon.$('input').serialize()
        +'&'+$('.head1 .nofaktur').serialize(),
    type:'GET',
      success:function(response){


        if (response.status == 1) {
          save_tt1();
          swal({
          title: "Berhasil!",
                  type: 'success',
                  text: "Data berhasil disimpan",
                  timer: 900,
                 showConfirmButton: true
                  },function(){
                     location.href='../fakturpembelian';
          });
      }else{
        swal({
          title: "Harap isi form dengan benar",
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


function save_tt1(){

      $.ajax({
      url:baseUrl + '/fakturpembelian/simpan_tt_subcon',
      data:'id={{$id}}'+'&'+'nota='+'{{$data->fp_nofaktur}}'+'&'+'supplier='+"{{$nota[0]->ks_nama}}"+'&'+$('.table_terima :input').serialize(),
      type:'GET',
      success:function(response){
        toastr.success('Tanda Terima Diupdate')
      },
      error:function(data){

   }
  });  
}

 $('.memo_subcon').keypress(function(e){

    if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
        cariSUB();
        return false;
     }
 });

function save_tt(){
   swal({
    title: "Apakah anda yakin?",
    text: "Simpan Tanda Terima!",
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
      url:baseUrl + '/fakturpembelian/simpan_tt_subcon',
      data:'id={{$id}}'+'&'+'nota='+'{{$data->fp_nofaktur}}'+'&'+'supplier='+"{{$nota[0]->ks_nama}}"+'&'+$('.table_terima :input').serialize(),
      type:'GET',
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

   }
  });  
 });
}

function tt_print(){
  @if($valid_cetak[0]->tt_tgl == null)
  var win = window.open('../cetak_tt?nota={{$nota}}&id={{$data->fp_idfaktur}}');
  @else
  var win = window.open('../cetak_tt?nota={{$valid_cetak[0]->tt_noform}}&id={{$data->fp_idfaktur}}');
  @endif
}

</script>

@endsection
