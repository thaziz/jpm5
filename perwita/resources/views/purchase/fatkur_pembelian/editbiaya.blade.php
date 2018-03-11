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
<div class="col-sm-6">          
  <table class="table " style="font-size: 14px;">
    <tr>
      <td>No Faktur</td>
      <td>
        <input type="text" name="no_faktur" readonly="" value="{{$data[0]->fp_nofaktur}}" class="form-control">
        <input type="text" name="akun_agen" readonly="" value="{{$data[0]->bp_akun_agen}}" class="form-control">
      </td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td>
       <div class="input-group date">
         <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
         <input type="text" name="tgl" readonly="" class="form-control" value="<?php echo date('d/M/Y',strtotime($data[0]->fp_tgl)) ?>">
         <input type="hidden" name="tgl_biaya_head" class="form-control tgl-biaya" value="<?php echo date('d/M/Y',strtotime($data[0]->fp_tgl)) ?>" readonly="" style="width: 250px;">
       </div>
     </td>
    </tr>
    <tr>
      <td>Agen/Vendor/Outlet</td>
      <td><input type="text" name="pihak_ketiga" readonly="" value="{{$data[0]->nama}}" class="form-control"></td>
    </tr>
    <tr>
      <td>Keterangan</td>
      <td><input type="text" name="Keterangan" readonly="" value="{{$data[0]->bp_keterangan}}" class="form-control"></td>
    </tr>
    <tr>
      <td>No. Invoice</td>
      <td><input type="text" name="invoice" readonly="" value="{{$data[0]->fp_noinvoice}}" class="form-control"></td>
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

<div class="col-sm-6 detail_biaya" hidden="">
  {{ csrf_field() }}
    <form class="form">
     <table class="table" style="font-size: 14px">
    <tr>
    <td style="width: 100px">Nomor</td>
     <td><input type="text" name="jml_data" class="form-control jml_data" readonly="" ></td>
    </tr>
    <tr>
    <td style="width: 100px">Nomor POD</td>
    <td width="200"><input type="text" name="no_pod" id="tags" class="form-control no_pod" onkeyup="cariDATA()" onblur="seq();" >
      <input type="hidden" class="form-control status_pod" style="width: 250px;">
    </td>
    </tr>
    <tr>
    <td style="width: 100px">Account Biaya</td>
    <td width="200" class="form-inline">
      <input type="text" name="kode_akun" class="form-control kode_akun" style="width: 23.8%;" readonly="">
      <select name="nama_akun" class="form-control nama_akun chosen-select-width"  style="width: 75%;" onchange="setNo()">
        @foreach($akun_biaya as $val)
        <option value="{{$val->id_akun}}">{{$val->nama_akun}}</option>
        @endforeach
      </select> 
    </td>
    </tr>
     <tr>
    <td style="width: 100px">Debet/Kredit</td>
    <td>
      <select name="debit" class="form-control debit" style="text-align: center">
        <option value="debit" selected="">DEBIT</option>
        <option value="kredit">KREDIT</option>
      </select>
    </td>
    </tr>
    <tr>
    <td style="width: 100px">Memo</td>
    <td ><input type="text" name="ket-biaya" class="form-control ket-biaya" ></td>
   </tr>
    <tr>
    <td style="width: 100px">Total</td>
    <td ><input type="text" name="total_jml" class="form-control total_jml"  readonly=""></td>
    </tr>
    <tr>
    <td style="width: 100px">Nominal</td>
    <td>
      <input type="text" name="nominal" class="form-control nominal" onkeyup="hitung()">
      <input type="hidden" class="form-control total_pod" style="width: 250px;">
    </td>
    </tr>
     </table>
     <button type="button" class="btn btn-primary pull-right cari-pod" onclick="cariPOD();"><i class="fa fa-search">&nbsp;Search</i></button>
    </form>
</div>
<div class="table-biaya col-sm-12"  >
  {{ csrf_field() }}
  <h3>Tabel Detail Resi</h3>
  <hr>
      <table class="table table-bordered table-hover datatable" style="font-size: 14px;">
      <thead align="center">
        <tr>
        <th>No</th>
        <th width="90">Nomor Bukti</th>
        <th>Tanggal</th>
        <th width="90">AccBiaya</th>
        <th>Jumlah Bayar</th>
        <th>Tipe Debet</th>
        <th>Keterangan</th>
        <th width="40">Aksi</th>
        </tr>
      </thead> 
      <tbody align="center" class="body-biaya">
          @foreach($data_dt as $index => $val)
          <tr>
            <td class="sorting_1" tabindex="0">
              <input type="hidden" class="form-control tengah kecil seq seq_biaya_{{$index+1}}" name="seq_biaya[]" value="{{$index+1}}" readonly="">
              <div class="seq-app">{{$index+1}}</div>
            </td>
            <td>
              <input type="hidden" class="form-control tengah kecil pod_biaya" name="pod_biaya[]" value="{{$val->bpd_pod}}" readonly="">
              <div class="val-app">{{$val->bpd_pod}}</div>
            </td>
            <td>
               <input type="hidden" class="form-control tengah tgl_biaya" name="tgl_biaya[]" value="{{$val->bpd_tgl}}" readonly="">
              <div class="seq-app">{{$val->bpd_tgl}}</div>
            </td>
            <td>
              <input type="hidden" class="form-control tengah kecil kode_biaya" name="kode_biaya[]" value="{{$val->bpd_akun_biaya}}" readonly="">
              <div class="kode-app">{{$val->bpd_akun_biaya}}</div>
            </td>
            <td>
              <input type="hidden" class="form-control tengah bayar_biaya" name="bayar_biaya[]" value="{{$val->bpd_nominal}}" readonly=""><input type="hidden" class="form-control tengah bayar_biaya_resi" name="harga_resi[]" value="{{$val->bpd_tarif_resi}}" readonly="">
              <div class="bayar-app">{{$val->bpd_nominal}}</div>
            </td>
            <td>
              <input type="hidden" class="form-control tengah debet_biaya" name="debet_biaya[]" value="{{$val->bpd_debit}}" readonly=""><div class="debet-app">{{$val->bpd_debit}}
              </div>
            </td>
            <td>
              <input type="hidden" class="form-control tengah ket_biaya" name="ket_biaya[]" value="{{$val->bpd_memo}}" readonly="">
              <div class="ket-app">{{$val->bpd_memo}}</div>
            </td>
            <td ><a class="btn btn-success btn-xs fa fa-pencil" align="center" onclick="edit_biaya(this)" title="edit"></i></a>&nbsp;&nbsp;<a class="btn btn-danger fa fa-minus btn-xs" align="center" onclick="hapus_biaya(this)" title="hapus"></i></a>
            </td>
          </tr>
          @endforeach
      </tbody>    
      </table>
      <button type="button" class="btn btn-primary pull-right" id="save-update" onclick="save_biaya()" data-dismiss="modal">Simpan Data</button>
</div>
</div>
</div>
<div id="modal-biaya" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button style="min-height:0;" type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Data</h4>
      </div>
      <div class="modal-body">
     <table class="table">
    <tr>
    <td style="width: 100px ;padding-left: 65px;">Account Biaya</td>
    <td width="10">:</td>
    <td width="200" class="form-inline">
      <input type="text" name="kode_akun" class="form-control kode_akun_update" style="width: 20%;" readonly="">
      <select name="nama_akun" class="form-control nama_akun_update chosen-select-width" style="width: 79% !important;" onchange="updt()">
        @foreach($akun_biaya as $val)
        <option value="{{$val->id_akun}}">{{$val->nama_akun}}</option>
        @endforeach
      </select> 
    </td>
    </tr>
     <tr>
    <td style="width: 100px ; padding-left: 65px;">Debet/Kredit</td>
    <td width="10">:</td>
    <td>
      <select name="debit" class="form-control debit_update" style="text-align: center; width: 250px;">
        <option value="debit" selected="">DEBIT</option>
        <option value="kredit">KREDIT</option>
      </select>
    </td>
    </tr>
    <tr>
      <td style="width: 100px ;padding-left: 65px;">Memo</td>
      <td width="10">:</td>
      <td width="200"><input type="text" name="ket-biaya" class="form-control ket_biaya_update" style="width: 250px;"></td>
   </tr>
    <tr>
      <td style="width: 100px ;padding-left: 65px;">Nominal</td>
      <td width="10">:</td>
      <td width="200"><input type="text" name="nominal" class="form-control nominal_update" onkeyup="hitung()" style="width: 250px;"></td>
    </tr>
    <tr>
      <td style="width: 100px">Nominal Resi</td>
      <td width="10">:</td>
      <td width="200"><input type="text" name="" class="form-control nom_resi" style="width: 250px;" readonly=""></td>
    </tr>
     </table>
      <div class="pull-right">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-update" onclick="sve()" data-dismiss="modal">Save changes</button>
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
              <input type="text" name="total_terima" class="form-control total_terima" value="">
              @else
              <input type="text" name="total_terima" class="form-control total_terima" value="{{'Rp ' . number_format($valid_cetak[0]->tt_totalterima,2,'.',',')}}">
              @endif
            </td>
          </tr>
        </table>
      <div align="right">
        <hr>
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" id="save-tt" onclick="save_tt()" data-dismiss="modal">Save changes</button>
      </div> 
      </div>    
    </div> 
  </div>
</div>
@endsection
@section('extra_scripts')
<script type="text/javascript">
var asd = $('.total_terima').maskMoney({thousands:'.', decimal:',', prefix:'Rp '});
var dsa = $('.nominal').maskMoney({precision:0, prefix:'Rp '});

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
var arrayPo=[];
var total = [];
var temp =[];

var faktur = "{{$data[0]->fp_nofaktur}}";
    faktur = faktur.toString();


$(document).ready(function(){

  var temp1 = 0;
  
@foreach($data_dt as $index => $val)
  arrayPo.push({{$val->bpd_id}});
  temp.push(parseInt({{$val->bpd_nominal}}));
  console.log(temp);
  temp1=parseInt(temp1)+parseInt(temp[{{$index}}]);
  // temp1 = temp1.toLocaleString();
@endforeach
@if($valid_cetak[0]->tt_tgl == null)
  if(isNaN(temp[0])){
    $('.total_jml').val('Rp '+0+',00');
    $('.total_terima').val('Rp '+0+',00');
  }else{
    temp1 = temp1.toLocaleString();
    $('.total_jml').val('Rp '+temp1+',00');
    $('.total_terima').val('Rp '+temp1+',00');
  }
@else
  if(isNaN(temp[0])){
    $('.total_jml').val('Rp '+0+',00');
  }else{
    temp1 = temp1.toLocaleString();
    $('.total_jml').val('Rp '+temp1+',00');
  }
@endif


});
  function checker(){

    var edit =  $('.checker:checkbox:checked').val();

    if(edit != undefined){
      $('.detail_biaya').attr('hidden',false);
    }else if(edit == undefined){
      $('.detail_biaya').attr('hidden',true);
    }
  }
  var datatable1 = $('.datatable').DataTable({
            responsive: true,
            searching:false,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

  var config = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width'     : {width:"75%"}
             }
             for (var selector in config) {
               $(selector).chosen(config[selector]);
             }
    var config1 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width1'     : {width:"100%"}
             }
             for (var selector in config1) {
               $(selector).chosen(config1[selector]);
             }

    $(".nama_akun").chosen(config); 

    $(".nama-kontak-agen1").chosen(config1);

    $(".nama-kontak-vendor1").chosen(config1);
$(document).ready(function(){
  var isi =  $('.nama_akun').val();
    $('.kode_akun').val(isi);
});
    
 $('#tags').keypress(function(e){

    if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
        $('.cari-pod').click();
        return false;
     }
 })

 $('.nominal').keypress(function(e){

    if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
        $('.cari-pod').click();
        return false;
     }
 })

 function cariDATA(){
    var pod = $('.no_pod').val();
    $( "#tags" ).autocomplete({
      source:baseUrl + '/fakturpembelian/caripod', 
      minLength: 3,
       change: function(event, ui) {
        if (ui.item) {
          if(ui.item.validator != null){
            toastr.warning('Data sudah didaftarkan');
            $(this).val("");
          }
        }
    }

    });

   }
   function seq(){

    var pod = $('.no_pod').val();
    var jumlahData = arrayPo.length + 1;
    $('.jml_data').val(jumlahData);


      $.ajax({
      url:baseUrl + '/fakturpembelian/auto/'+pod,
      type:'get',
      success:function(response){
        if(response.status == 1){
            var total = parseInt(response.data.tarif_dasar);
          $('.total_pod').val(total);
          $('.nom_resi').val(accounting.formatMoney(total,'Rp. ', 2, ".",','));
          

        }else{
            $('.total_pod').val(0);
        }
      }
    })
   }

function hitung(){

    var bayar = $('.nominal').val();
    var temp1=0;
    var total_tes=0;

    try{
        bayar = bayar.replace(/[^0-9\.-]+/g,"");
      }catch(err){

      }

    bayar1 = parseInt(bayar);

    $('.total_jml').val(total_tes);
    $('.total_terima').val(total_tes);

    if(isNaN(temp[0])){
      total_tes=bayar1;
    }else{
      for(var i = 0 ; i<temp.length;i++){
        temp1+=parseInt(temp[i]);
      }

      try{
        temp1 = temp1.replace(/[^0-9\.-]+/g,"");
      }catch(err){

      }
      total_tes=temp1+bayar1 ;
    }
      
    if(bayar == ""){
      temp1 = temp1.toLocaleString();
      $('.total_jml').val('Rp '+temp1);
      $('.total_terima').val('Rp '+temp1+',00');
    }else{
      total_tes = total_tes.toLocaleString();
      $('.total_terima').val('Rp '+total_tes+',00');
      $('.total_jml').val('Rp '+total_tes);
    }
  
   }

   function cariPOD(){
    var master= $('.master_persen').val();
    var valPo = $('.no_pod').val();
    var tgl   = $('.tgl-biaya').val();
    var cariIndex = arrayPo.indexOf(valPo);
    var count = arrayPo.length;
    var seq   = arrayPo.length + 1;
    var kode  = $('.kode_akun').val();
    var bayar = $('.nominal').val();
    var ket   = $('.ket-biaya').val();
    var debet = $('.debit').val();
    var harga_resi = $('.total_pod').val();
    try{
        bayar = bayar.replace(/[^0-9\.-]+/g,"");
      }catch(err){

      }
    if(cariIndex == -1 && valPo != "" && harga_resi != 0){
      if(count == 0){
        count = 1;
      }
      arrayPo.push(valPo);  
      datatable1.row.add( [
                '<input type="hidden" class="form-control tengah kecil seq seq_biaya_'+seq+'" name="seq_biaya[]" value="'+seq+'" readonly>'+'<div class="seq-app">'+seq+'</div>',
                '<input  type="hidden" class="form-control tengah kecil pod_biaya" name="pod_biaya[]" value="'+valPo+'" readonly>'+'<div class="val-app">'+valPo+'</div>',
                '<input type="hidden" class="form-control tengah tgl_biaya" name="tgl_biaya[]" value="'+tgl+'" readonly>'+'<div class="seq-app">'+tgl+'</div>',
                '<input type="hidden" class="form-control tengah kecil kode_biaya" name="kode_biaya[]" value="'+kode+'" readonly>'+'<div class="kode-app">'+kode+'</div>',
                '<input type="hidden" class="form-control tengah bayar_biaya" name="bayar_biaya[]" value="'+parseFloat(bayar).toFixed(2)+'" readonly>'+'<input type="hidden" class="form-control tengah bayar_biaya_resi" name="harga_resi[]" value="'+harga_resi+'" readonly>'+'<div class="bayar-app">'+parseFloat(bayar).toFixed(2)+'</div>',
                '<input type="hidden" class="form-control tengah debet_biaya" name="debet_biaya[]" value="'+debet+'" readonly>'+'<div class="debet-app">'+debet+'</div>',
                '<input type="hidden" class="form-control tengah ket_biaya" name="ket_biaya[]" value="'+ket+'" readonly>'+'<div class="ket-app">'+ket+'</div>',
                '<a class="btn btn-success btn-xs fa fa-pencil" align="center" onclick="edit_biaya(this)" title="edit"></i></a>&nbsp;&nbsp;<a class="btn btn-danger fa btn-xs fa-minus" align="center" onclick="hapus_biaya(this)" title="hapus"></i></a>'
            ] ).draw( false );   
      $('.table-biaya').css('display','block');
      bayar = parseInt(bayar);
      temp.push(bayar); 

      $('.no_pod').val("");
      $('.nominal').val("");

    }else if(valPo == ""){
      toastr.warning("Nomor POD tidak boleh kosong");
    }else if(harga_resi == 0){
      toastr.warning("Nomor POD tidak ada");
    }else{
      toastr.warning("Data sudah ada");
    }

   }

    cariSeq=[];
   function edit_biaya(o){

    var ini = o.parentNode.parentNode;
    var pod = $(ini).find('.pod_biaya').val();
    var kode = $(ini).find('.kode_biaya').val();
    var bayar = $(ini).find('.bayar_biaya').val();
    var debet = $(ini).find('.debet_biaya').val();
    var ket = $(ini).find('.ket_biaya').val();
    cariSeq[0] = 'seq_biaya_'+$ (ini).find('.seq').val();
    console.log(kode);
    $('#modal-biaya').modal('show');
    $(".kode_akun_update").val(kode);
    $(".nama_akun_update").val(kode).trigger("chosen:updated");
    console.log($(".nama_akun_update").val());
    $(".debit_update").val(debet);
    $(".ket_biaya_update").val(ket);
    $(".nominal_update").val(bayar);
    
      
    }
    function setNo(){   
    var isi =  $('.nama_akun').val();
    $('.kode_akun').val(isi);
   }

    function hapus_biaya(o){
    var ini = o.parentNode.parentNode;
    var cari = $(ini).find('.pod_biaya').val();
    var byr = $(ini).find('.bayar_biaya').val();
    var byr = parseInt(byr);
    var temp1=0;
    var cariIndex = arrayPo.indexOf(cari);
    var cariIndex1 = temp.indexOf(byr);
    console.log(byr);
    console.log(cariIndex1);
    console.log(temp);
    arrayPo.splice(cariIndex,1);
    temp.splice(cariIndex1,1);


    for(var i = 0 ; i<temp.length;i++){
        temp1+=parseInt(temp[i]);
      }
      try{
        temp1 = temp1.replace(/[^0-9\.-]+/g,"");
      }catch(err){

      }
      if(temp.length == 0){

        $('.total_terima').val('Rp '+0+',00');
       $('.total_jml').val(0); 

      }else{
        temp1 = temp1.toLocaleString();
        $('.total_terima').val('Rp '+temp1+',00');
        $('.total_jml').val('Rp '+temp1);  
      }
      

    datatable1.row(ini).remove().draw(false);
   }

    function sve(){
      var kode = $(".kode_akun_update").val();
      var debit = $(".debit_update").val();
      var ket = $(".ket_biaya_update").val();
      var bayar = $(".nominal_update").val();
      var updt = $('.'+cariSeq[0]).parents('tr');
      var cariNom = $(updt).find('.bayar_biaya').val();
      cariNom = parseInt(cariNom);
      if(bayar == ''){
        bayar = 0;
      }
      bayar   = parseInt(bayar);
      var cariIndex = temp.indexOf(cariNom)
      var temp1 = 0;
      temp[cariIndex]=bayar;
      console.log(cariIndex);
      for(var i = 0 ; i<temp.length;i++){
        temp1+=parseInt(temp[i]);
      }
      if(temp.length == 0){
       $('.total_jml').val(0); 
       $('.total_terima').val('Rp '+0+',00');
      }else{
       temp1 = temp1.toLocaleString();
       $('.total_jml').val('Rp '+temp1);  
       $('.total_terima').val('Rp '+temp1+',00');  
      }
      bayar =parseFloat(bayar).toFixed(2);
      $(updt).find('.kode_biaya').val(kode);
      $(updt).find('.debet_biaya').val(debit);
      $(updt).find('.ket_biaya').val(ket);
      $(updt).find('.bayar_biaya').val(bayar);
      $(updt).find('.kode-app').html(kode);
      $(updt).find('.debet-app').html(debit);
      $(updt).find('.ket-app').html(ket);
      $(updt).find('.bayar-app').html(bayar);

    }

    function updt(){
      var isi =  $('.nama_akun_update').val();
      $('.kode_akun_update').val(isi);
    }

function save_tt1(){
  $.ajax({
      url:baseUrl + '/fakturpembelian/simpan_tt',
      type:'get',
      data:'id={{$id}}'+'&'+'nota='+faktur+'&'+'supplier='+"{{$data[0]->bp_kode_vendor}}"+'&'+$('.table_terima :input').serialize(),
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

  function save_biaya(){  
    swal({
    title: "Apakah anda yakin?",
    text: "Update Biaya Penerus",
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
      save_tt1();
      $.ajax({
      url:baseUrl + '/fakturpembelian/update_agen',
      type:'post',
      data:'id={{$id}}'+'&'+'nota='+faktur+'&'+datatable1.$('input').serialize(),
      success:function(response){
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data berhasil disimpan",
                timer: 900,
               showConfirmButton: true
                },function(){
                   location.reload();
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
function modal_tt(){
  $('#modal_tt  ').modal('show');
}

function save_biaya1(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      $.ajax({
      url:baseUrl + '/fakturpembelian/update_agen',
      type:'post',
      data:'id={{$id}}'+'&'+'nota='+faktur+'&'+'persen='+persen+'&'+datatable1.$('input').serialize(),
      success:function(response){

      },
      error:function(data){
      toastr.warning('Terjadi Kesalahan Saat Update');
   }
  }); 
}

function save_tt(){

  try{
  save_biaya1()
  }catch(err){

  }
   swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Simpan!",
    cancelButtonText: "Batal",
    closeOnConfirm: false
  },
  function(){
   $.ajax({
      url:baseUrl + '/fakturpembelian/simpan_tt',
      type:'get',
      data:'nota='+faktur+'&'+'supplier='+"{{$data[0]->bp_kode_vendor}}"+'&'+$('.table_terima :input').serialize(),
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
        y
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
