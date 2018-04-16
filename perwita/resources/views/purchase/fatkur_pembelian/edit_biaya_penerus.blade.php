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
    opacity: 0.6;
}
  .right{
      text-align: right;
  }
  .table-hover tbody tr{
    cursor: pointer;
  }

  .center{
      text-align: center;
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
    <div class="ibox" style="padding-top: 10px;" >
      <div class="ibox-title"><h5>Detail Faktur Pembelian</h5>
        <a href="../fakturpembelian" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
      </div>
      <div class="ibox-content col-sm-12">

          <div class="col-sm-5 header_biaya"  >
            {{ csrf_field() }}
          <form class="head_atas">
          <table class="table head_biaya">
            <h3 style="text-align: center;">Form Biaya Penerus Hutang</h3>
            
          <tr>
            <td width="150px">
          No Faktur
            </td>
            <td width="10">:</td>
            <td>
               <input type="text" name="nofaktur"  class="form-control nofaktur" value="{{$cari_fp->fp_nofaktur}}" required="" readonly="">
               <input type="hidden" class="form-control idfaktur" name="idfaktur" value="{{$cari_fp->fp_idfaktur}}" required="" readonly="">
            
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </td>
          </tr>
          <tr>
            <td> Cabang </td>
            <td width="10">:</td>
            <td class="disabled">  
              <select class="form-control cabang" name="cabang">
                @foreach($cabang as $val)
                <option value="{{$val->kode}}" @if($val->kode == $cari_fp->fp_comp) selected @endif> {{$val->nama}} </option>
                @endforeach
              </select> 
            </td>
           </tr>
           <tr>
            <td style="width: 100px">Tanggal</td>
            <td width="10">:</td>
            <td width="200">
              <input type="text" name="tgl_biaya_head" class="form-control tgl-biaya" value="{{$date}}" readonly="" style="">
              <input type="hidden" class="form-control tgl_resi"  readonly="" style="">
              <input type="hidden" name="master_persen" class="form-control master_persen"  readonly="" style="">
            </td>
           </tr>
           <tr>
            <td style="width: 100px">Jatuh Tempo</td>
            <td width="10">:</td>
            <td width="200">
              <input type="text" name="jatuh_tempo" class="form-control jatuh_tempo" value="{{carbon\carbon::parse($cari_fp->fp_jatuhtempo)->format('d/m/Y')}}" placeholder="Jatuh tempo" style="">
            </td>
           </tr>
          <tr>
            <td style="width: 100px">Status </td>
            <td width="10">:</td>
            <td width="200"><input type="text" name="status" class="form-control" value="{{$cari_fp->fp_status}}" readonly="" style=""></td>
           </tr>
            <tr class="vendor">
            <td style="width: 100px">Tipe Vendor </td>
            <td width="10">:</td>
            <td width="200" class="vendor_td disabled">
              <select onchange="ganti_agen(this.value)" name="vendor" class="form-control vendor1 "  style="text-align: center; " >
                <option @if($bp->bp_tipe_vendor == 'kosong') selected @endif value="kosong">-PILIH TIPE VENDOR-</option>
                <option @if($bp->bp_tipe_vendor == 'AGEN') selected @endif value="AGEN">Agen Penerus </option>
                <option @if($bp->bp_tipe_vendor == 'VENDOR') selected @endif value="VENDOR">Vendor Penerus</option>
              </select>
            </td>
           </tr>
           <tr class="nama-kontak-kosong">
            <td style="width: 100px">Nama Agen/Vendor </td>
            <td width="10">:</td>
            <td width="200" class="nama_kontak_td disabled">
              <select name="" class="form-control agen_vendor" style="text-align: center; ">
                <option value="0" selected="">-PILIH NAMA AGEN/VENDOR-</option>
              </select>
            </td>
           </tr>
           <tr>
            <td style="width: 100px">No Invoice</td>
            <td width="10">:</td>
            <td width="200">
              <input type="text" name="Invoice_biaya" class="form-control" value="{{$cari_fp->fp_noinvoice}}" placeholder="No Invoice">
            </td>
           </tr>
            <tr>
            <td style="width: 100px">Keterangan</td>
            <td width="10">:</td>
            <td width="200"><input type="text" value="{{$cari_fp->fp_keterangan}}" name="Keterangan_biaya" style="text-transform: uppercase;" class="form-control" style=""></td>
           </tr>  
          <tr>
            <td colspan="3">
                <button type="button" class="btn btn-primary pull-right save_biaya" style="margin-right: 20px" id="save-update"  onclick="save_biaya()" ><i class="fa fa-save"></i> Simpan Data</button>

               <button onclick="tt_penerus()" class="btn btn-info modal_penerus_tt "  type="button" data-toggle="modal" data-target="#modal_tt_penerus" type="button"> <i class="fa fa-book"> </i> &nbsp; Form Tanda Terima </button>
               <button type="button" style="margin-right: 20px;" class="btn btn-warning pull-left @if($cari_fp->fp_pending_status == 'PENDING') disabled @endif " id="print-tt"><i class="fa fa-print"></i> Print Tanda Terima</button>
               <button type="button" style="margin-right: 20px;" class="btn btn-warning pull-left " id="print-penerus" onclick="print_penerus()" ><i class="fa fa-print"></i> Print</button>

            </td>
          </tr>
          </table>
          </form>
          </div>


          <div class="col-sm-5 detail_biaya"   style="margin-left: 100px;">
              <form class="form">
               <table class="table table_detail">
               <div align="center" style="width: 100%;">  
              <h3 >Detail Biaya Penerus Hutang</h3>
             </div> 
              <tr>
              <td style="width: 100px">Nomor</td>
              <td width="10">:</td>
              <td width="200">
                <input type="text" name="jml_data" value="1" class="form-control jml_data" style="" readonly="">
              </td>
              </tr>
              <tr>
                <td style="width: 100px">Nomor POD</td>
                <td width="10">:</td>
                <td width="200">
                  <input type="text" name="no_pod" id="tages" class="form-control no_pod" onkeyup="cari_do()"  style="">
                  <input type="hidden" class="form-control status_pod" style="">
                </td>
              </tr>
               <tr>
              <td style="width: 100px">DEBET/Kredit</td>
              <td width="10">:</td>
              <td>
                <select name="DEBET" class="form-control DEBET" style="text-align: center; ">
                  <option value="DEBET" selected="">DEBET</option>
                  <option value="kredit">KREDIT</option>
                </select>
              </td>
              </tr>
              <tr>
                <td style="width: 100px ;">Akun</td>
                <td width="10">:</td>
                <td>
                  <select class="form-control akun_biaya chosen-select-width1" style="text-align: center; ">
                    <option value="0" selected="">Pilih - akun</option>
                    @foreach($akun as $val)
                      <option value="{{$val->id_akun}}" selected="">{{$val->id_akun}} - {{$val->nama_akun}}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
              <td style="width: 100px">Memo</td>
              <td width="10">:</td>
              <td width="200"><input type="text" class="form-control keterangan_biaya" style="text-transform: uppercase;" style=""></td>
             </tr>
              <tr>
              <td style="width: 100px">Total</td>
              <td width="10">:</td>
              <td width="200"><input type="text" name="total_jml" class="form-control total_jml" style="" readonly=""></td>
              </tr>
              <tr>
              <td style="width: 100px">Nominal</td>
              <td width="10">:</td>
              <td width="200">
                <input type="text" name="nominal" class="form-control nominal" onkeyup="hitung()" style="">
                <input type="hidden" readonly="" class="form-control harga_do" style="">
              </td>
              </tr>
              <tr>
                <td colspan="3">
                  <button type="button" class="btn btn-primary pull-right cari-pod" onclick="appendDO();"><i class="fa fa-search">&nbsp;Append</i></button>
                </td>
              </tr>
               </table>
              </form>
          </div>

           <div class="table_biaya col-sm-12" >
            <h3>Tabel Detail Resi</h3>
            <hr>

                <table class="table table-bordered table-hover datatable" style="font-size: 12px">
                <thead align="center">
                  <tr>
                  <th>No</th>
                  <th>Nomor Bukti</th>
                  <th >AccBiaya</th>
                  <th>Jumlah Bayar</th>
                  <th>Tipe debet</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
                  </tr>
                </thead> 
                <tbody class="body-biaya">

                </tbody>    
                </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal_biaya_update" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button style="min-height:0;" type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Data</h4>
      </div>
      <div class="modal-body">
     <table class="table table_detail">
         <div align="center" style="width: 100%;">  
        <h3 >Detail Biaya Penerus Hutang</h3>
       </div> 
        <tr>
        <td style="width: 100px">Nomor</td>
        <td width="10">:</td>
        <td width="200">
          <input type="text" name="e_jml_data" value="1" class="form-control e_jml_data" style="" readonly="">
        </td>
        </tr>
        <tr>
          <td style="width: 100px">Nomor DO</td>
          <td width="10">:</td>
          <td width="200">
            <input type="text"  readonly="" name="no_pod" id="tages" class="form-control e_no_pod" style="">
          </td>
        </tr>
         <tr>
        <td style="width: 100px">Debet/Kredit</td>
        <td width="10">:</td>
        <td>
          <select name="DEBET" class="form-control e_DEBET" style="text-align: center; ">
            <option value="DEBET" selected="">DEBET</option>
            <option value="kredit">KREDIT</option>
          </select>
        </td>
        </tr>
        <tr>
          <td style="width: 100px ;">Akun</td>
          <td width="10">:</td>
          <td>
            <select class="form-control e_akun_biaya chosen-select-width1" style="text-align: center; ">
              <option value="0" selected="">Pilih - akun</option>
              @foreach($akun as $val)
                <option value="{{$val->id_akun}}" selected="">{{$val->id_akun}} - {{$val->nama_akun}}</option>
              @endforeach
            </select>
          </td>
        </tr>
        <tr>
        <td style="width: 100px">Memo</td>
        <td width="10">:</td>
        <td width="200"><input type="text" class="form-control e_keterangan_biaya" style=""></td>
       </tr>
        <tr>
        <td style="width: 100px">Nominal</td>
        <td width="10">:</td>
        <td width="200">
          <input type="text" name="nominal" class="form-control e_nominal" onkeyup="hitung()" style="">
        </td>
        </tr>
        <tr>
          <td colspan="3">
            <div class="pull-right">
              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="save-update" onclick="update_biaya()" data-dismiss="modal">Update</button>
            </div>
          </td>
        </tr>
     </table>
      </div>      
    </div>
      
  </div>
</div>

<!--  MODAL TT PENERUS  -->

<div class="modal fade" id="modal_tt_penerus" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document" style="min-width: 800px !important; min-height: 800px">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Form Tanda Terima</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-stripped tabel_tt_penerus">
          <tr>
            <td width="150px">
                  No Tanda Terima 
                </td>
                <td>
                  <input type='text' name="nota_tt" value="{{$form_tt->tt_noform or null}}" class='input-sm form-control notandaterima'>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </td>
          </tr>
          <tr>
            <td> Tanggal </td>
                <td>
                   <div class="input-group date">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tgl_tt" value="@if(isset($form_tt->tt_tgl)){{carbon\carbon::parse($form_tt->tt_tgl )->format('d/m/Y')}}@else{{carbon\carbon::now()->format('d/m/Y')}}@endif" readonly="" name="tgl_tt">
                  </div>
                </td>
          </tr>
          <tr>
              <td> Supplier </td>
              <td> <input type='text' class="form-control supplier_tt" value="{{$form_tt->tt_idagen or null}}" name="supplier_tt" readonly=""></td>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                 <div class="row">
                    <div class="col-sm-3"> 
                      <div class="checkbox checkbox-info checkbox-circle">
                          <input id="Kwitansi" type="checkbox"@if(isset($form_tt)) @if($form_tt->tt_kwitansi == 'ADA') checked=""  @endif @endif name="kwitansi">
                            <label for="Kwitansi">
                                Kwitansi / Invoice / No
                            </label>
                      </div> 
                    </div>
                    <div class="col-sm-3"> 
                      <div class="checkbox checkbox-info checkbox-circle">
                          <input id="FakturPajak" type="checkbox"@if(isset($form_tt)) @if($form_tt->tt_faktur == 'ADA') checked=""  @endif @endif name="faktur_pajak">
                            <label for="FakturPajak">
                                Faktur Pajak
                            </label>
                      </div> 
                    </div>

                    <div class="col-sm-3"> 
                      <div class="checkbox checkbox-info checkbox-circle">
                          <input id="SuratPerananAsli" type="checkbox"@if(isset($form_tt)) @if($form_tt->tt_suratperan == 'ADA') checked=""  @endif @endif name="surat_peranan">
                            <label for="SuratPerananAsli">
                                Surat Peranan Asli
                            </label>
                      </div> 
                    </div>

                     <div class="col-sm-3"> 
                      <div class="checkbox checkbox-info checkbox-circle">
                          <input id="SuratJalanAsli" type="checkbox"@if(isset($form_tt)) @if($form_tt->tt_suratjalanasli == 'ADA') checked=""  @endif @endif name="surat_jalan">
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
                <input type="text" class="form-control lain_penerus" value="{{$form_tt->tt_lainlain or null}}" name="lainlain">
              </td>
            </tr>
            <tr>
              <td> Tanggal Kembali </td>
              <td>
                <div class="input-group date">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control jatuh_tempo" value="@if(isset($form_tt->tt_tgl)){{carbon\carbon::parse($form_tt->tt_tgl )->format('d/m/Y')}}@else{{carbon\carbon::now()->format('d/m/Y')}}@endif" readonly="" name="tgl_kembali">
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
                    <input type="text" class="form-control totalterima_tt" name="total_diterima" style="text-align:right;" readonly="">
                  </div>
                </div>
              </td>
            </tr>
        </table>
      </div>
      <div class="modal-footer inline-form">
        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
        <button onclick="simpan_tt()" type="button" class="btn btn-primary simpan_penerus" data-dismiss="modal">Simpan</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('extra_scripts')
<script type="text/javascript">
 var array_do = [];
  var jt = $('.jatuh_tempo').datepicker({
        format:'dd/mm/yyyy',
        autoclose: true
        });

  var jt = $('.tgl_tt').datepicker({
        format:'dd/mm/yyyy',
        autoclose: true
        });
  var dsa = $('.nominal').maskMoney({precision:0,thousands:'.'});
  var dsa = $('.e_nominal').maskMoney({precision:0,thousands:'.'});
  var datatable1 = $('.datatable').DataTable({
            responsive: true,
            searching:false,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
            columnDefs: [

          {
             targets: 0,
             className: 'center'
          },
          {
             targets: 3,
             className: 'right'
          },
          {
             targets: 6,
             className: 'center'
          }
       ]
    });


  

  function ganti_agen(val) {
    var agen = '{{$cari_fp->fp_supplier}}';
    var acc  = '{{$cari_fp->fp_acchutang}}';
    var val = $('.vendor1 ').val();
    $.ajax({
      url:baseUrl +'/fakturpembelian/rubahVen',
      data: {val,agen,acc},
      success:function(data){
        $('.nama_kontak_td').html(data);
      },error:function(){
        toastr.warning('Terjadi Kesalahan');
      }
    })
  }

  function cari_do() {
    if ($('.agen_vendor').val()  == '0') {
      toastr.warning('Harap Mengisi Nama Agen/Vendor');
      return 1;
    }

    $( ".no_pod" ).autocomplete({
      source:baseUrl + '/fakturpembelian/cari_do', 
      data:{},
      minLength: 1,
      select: function(event, ui) {
          if (ui.item.validator != null) {
            $('.status_pod').val('Terdaftar');
          }
          $('.harga_do').val(ui.item.harga);

      }

    });
  }
  $(document).ready(function(){
    ganti_agen();

    var acc = $('.agen_vendor').find(':selected').data('acc_penjualan');
    var csf = $('.agen_vendor').find(':selected').data('csf_penjualan');
    console.log(acc);
    $('.acc_penjualan_penerus').val(acc);
    $('.csf_penjualan_penerus').val(csf);
  })

  $('.no_pod').blur(function(){
    var index = array_do.indexOf($(this).val());
    if (index != -1) {
      toastr.warning('Data Telah Ada');
      $('.no_pod').val('');
      $('.status_pod').val('');
      $('.harga_do').val('');
      return 1;
    }

    if ($('.status_pod').val() != '') {
      toastr.warning('Data Telah Terdaftar Di Sistem');
      $('.no_pod').val('');
      $('.status_pod').val('');
      $('.harga_do').val('');
      return 1;
    }else if($('.harga_do').val() == ''){
      toastr.warning('Nomor Do Tidak Ada');
      $('.no_pod').val('');
      $('.status_pod').val('');
      $('.harga_do').val('');
      return 1;
    }else{
      toastr.success('Data Berhasil Diinisialisasi');
      return 1;
    }
  })



  function hitung() {
    var temp = 0;
    $('.bayar_biaya').each(function(){
      temp+=parseInt($(this).val());
    })
    $('.total_jml').val(accounting.formatMoney(temp, "", 2, ".",','));
  }


  var count = 1;


  @foreach($bpd as $val)
      var jml_data            = count;
      var no_pod              = "{{$val->bpd_pod}}";
      var DEBET               = "{{$val->bpd_debit}}";
      var akun_biaya          = "{{$val->bpd_akun_biaya}}";
      @foreach($akun as $i)
        @if($val->bpd_akun_biaya == $i->id_akun)
          var akun_biaya_text     = '{{$i->id_akun}}-{{$i->nama_akun}}';
        @endif
      @endforeach
      var keterangan_biaya    = "{{$val->bpd_memo}}";
      var nominal             = "{{$val->bpd_nominal}}";
      var harga_do            = "{{$val->bpd_tarif_resi}}";
      // nominal                 = nominal.replace(/[^0-9\-]+/g,"");



      datatable1.row.add( [
                '<input type="hidden" class="form-control tengah kecil seq seq_biaya_'+jml_data+'" name="seq_biaya[]" value="'+jml_data+'" readonly>'+'<div class="seq_text">'+jml_data+'</div>',

                '<input type="hidden" class="form-control tengah kecil no_do" name="no_do[]" value="'+no_pod+'" readonly>'+'<div class="no_do_text">'+no_pod+'</div>',

                '<input type="hidden" class="form-control tengah kecil kode_biaya" name="kode_biaya[]" value="'+akun_biaya+'" readonly>'+'<div class="kode_biaya_text">'+akun_biaya_text+'</div>',

                '<input type="hidden" class="form-control tengah bayar_biaya" name="bayar_biaya[]" value="'+parseFloat(nominal)+'" readonly>'+'<div class="bayar_biaya_text">'+accounting.formatMoney(nominal, "Rp ", 2, ".",',')+'</div>'+
                '<input type="hidden" class="form-control tengah do_harga" name="do_harga[]" value="'+harga_do+'" readonly>',

                '<input type="hidden" class="form-control tengah DEBET_biaya" name="DEBET_biaya[]" value="'+DEBET+'" readonly>'+'<div class="DEBET_biaya_text">'+DEBET+'</div>',

                '<input type="hidden" class="form-control tengah ket_biaya" name="ket_biaya[]" value="'+keterangan_biaya+'" readonly>'+'<div class="ket_biaya_text">'+keterangan_biaya+'</div>',

                
                '<div class="btn-group ">'+
                '<a  onclick="edit_biaya(this)" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></a>'+
                '<a  onclick="hapus_biaya(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>'+
                '</div>',
            ] ).draw( false );   
      count++;
      array_do.push(no_pod);
      $('.table_biaya').prop('hidden',false);
      $('.table_detail input').val(''); 
      $('.jml_data').val(count); 
      hitung();
  @endforeach





  function appendDO(){

      var jml_data            = $('.jml_data').val();
      var no_pod              = $('.no_pod ').val();
      var DEBET               = $('.DEBET').val();
      var akun_biaya          = $('.akun_biaya').val();
      var akun_biaya_text     = $('.akun_biaya :selected').text();
      var keterangan_biaya    = $('.keterangan_biaya ').val();
      var nominal             = $('.nominal').val();
      var harga_do            = $('.harga_do').val();
      nominal                 = nominal.replace(/[^0-9\-]+/g,"");

      if (no_pod == '') {
        toastr.warning('Harap Isi Nomor DO');
        return 1;
      }
      if (keterangan_biaya == '') {
        toastr.warning('Memo Harus Diisi');
        return 1;
      }


      datatable1.row.add( [
                '<input type="hidden" class="form-control tengah kecil seq seq_biaya_'+jml_data+'" name="seq_biaya[]" value="'+jml_data+'" readonly>'+'<div class="seq_text">'+jml_data+'</div>',

                '<input type="hidden" class="form-control tengah kecil no_do" name="no_do[]" value="'+no_pod+'" readonly>'+'<div class="no_do_text">'+no_pod+'</div>',

                '<input type="hidden" class="form-control tengah kecil kode_biaya" name="kode_biaya[]" value="'+akun_biaya+'" readonly>'+'<div class="kode_biaya_text">'+akun_biaya_text+'</div>',

                '<input type="hidden" class="form-control tengah bayar_biaya" name="bayar_biaya[]" value="'+parseFloat(nominal)+'" readonly>'+'<div class="bayar_biaya_text">'+accounting.formatMoney(nominal, "Rp ", 2, ".",',')+'</div>'+
                '<input type="hidden" class="form-control tengah do_harga" name="do_harga[]" value="'+harga_do+'" readonly>',

                '<input type="hidden" class="form-control tengah DEBET_biaya" name="DEBET_biaya[]" value="'+DEBET+'" readonly>'+'<div class="DEBET_biaya_text">'+DEBET+'</div>',

                '<input type="hidden" class="form-control tengah ket_biaya" name="ket_biaya[]" value="'+keterangan_biaya+'" readonly>'+'<div class="ket_biaya_text">'+keterangan_biaya+'</div>',

                
                '<div class="btn-group ">'+
                '<a  onclick="edit_biaya(this)" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></a>'+
                '<a  onclick="hapus_biaya(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>'+
                '</div>',
            ] ).draw( false );   
      count++;
      array_do.push(no_pod);
      $('.table_biaya').prop('hidden',false);
      $('.table_detail input').val(''); 
      $('.jml_data').val(count); 
      toastr.success('Data Berhasil Di Append, Buat Tanda Terima Untuk Mengaktifkan fitur Simpan');
      $('.save_biaya').removeClass('disabled');
      $('.vendor_td').addClass('disabled');
      $('.nama_kontak_td').addClass('disabled');
      hitung();

  } 

  $('.nominal').on('keydown', function(e) {
    if (e.which == 13) {
      console.log('asd');
      appendDO();
        e.preventDefault();
    }
  });

  function edit_biaya(par) {
    var parent = $(par).parents('tr');
    var seq    = $(parent).find('.seq').val();
    var no_do    = $(parent).find('.no_do').val();
    var kode_biaya    = $(parent).find('.kode_biaya').val();
    var bayar_biaya    = $(parent).find('.bayar_biaya').val();
    var DEBET_biaya    = $(parent).find('.DEBET_biaya').val();
    var ket_biaya    = $(parent).find('.ket_biaya').val();

    console.log(kode_biaya);
    $('.e_jml_data').val(seq);
    $('.e_no_pod').val(no_do);
    $('.e_akun_biaya').val(kode_biaya).trigger('chosen:updated');
    $('.e_nominal').val(accounting.formatMoney(bayar_biaya,'',0, ".",','));
    $('.e_DEBET').val(DEBET_biaya);
    $('.e_keterangan_biaya').val(ket_biaya);

    $('#modal_biaya_update').modal('show');
  }

  function update_biaya() {
   var e_jml_data = $('.e_jml_data').val();
   var e_no_pod = $('.e_no_pod').val();
   var e_akun_biaya = $('.e_akun_biaya').val();
   var e_nominal = $('.e_nominal').val();
   e_nominal = e_nominal.replace(/[^0-9\-]+/g,"");
   var e_DEBET = $('.e_DEBET').val();
   var e_keterangan_biaya = $('.e_keterangan_biaya').val();

   var e_akun_biaya_text = $('.e_akun_biaya :selected').text();

   var par = $('.seq_biaya_'+e_jml_data).parents('tr');


   $(par).find('.seq').val(e_jml_data);
   $(par).find('.no_do').val(e_no_pod);
   $(par).find('.kode_biaya').val(e_akun_biaya);
   $(par).find('.bayar_biaya').val(e_nominal);
   $(par).find('.DEBET_biaya').val(e_DEBET);
   $(par).find('.ket_biaya').val(e_keterangan_biaya);

   $(par).find('.seq_text').text(e_jml_data);
   $(par).find('.bayar_biaya_text').text(accounting.formatMoney(e_nominal, "Rp ", 2, ".",','));
   $(par).find('.no_do_text').text(e_no_pod);
   $(par).find('.kode_biaya_text').text(e_akun_biaya_text);
   $(par).find('.DEBET_biaya_text').text(e_DEBET);
   $(par).find('.ket_biaya_text').text(e_keterangan_biaya);
   hitung();

  }

  function hapus_biaya(par) {
    var parent = $(par).parents('tr');
    var pod = $(parent).find('.no_do').val();
    
    var index = array_do.indexOf(pod);
  
    array_do.splice(index,1);
    datatable1.row(parent).remove().draw(false);

    var temp = 0;
    $('.no_do').each(function(){
      temp+=1;
    })
    if (temp == 0) {
      $('.vendor_td').removeClass('disabled');
      $('.nama_kontak_td').removeClass('disabled');
      $('.save_biaya').addClass('disabled');
    }
    
    hitung();
  }

  function tt_penerus() {
    var total_jml = $('.total_jml').val();
    total_jml = total_jml.replace(/[^0-9\-]+/g,"")/100;
    $('.totalterima_tt').val(accounting.formatMoney(total_jml, "Rp ", 2, ".",','));
  }

  function save_biaya() {
      var temp = 0;
      $('.no_do').each(function(){
        temp+=1;
      })

      if (temp == 0) {
        toastr.warning('Tidak Ada Data');
        return 1;
      }
      tt_penerus();
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
          url:baseUrl + '/fakturpembelian/update_agen',
          type:'get',
          data:$('.head_biaya :input').serialize()
               +'&'+datatable1.$('input').serialize(),
          success:function(response){
            if (response.status == 1) {
                swal({
                    title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                    showConfirmButton: true
                    },function(){
                      $.ajax({
                          url:baseUrl + '/fakturpembelian/simpan_tt',
                          type:'get',
                          data:$('.tabel_tt_penerus :input').serialize()
                               +'&'+$('.head1 :input').serialize(),
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
            }else{

              swal({
                title: "Data Sudah Ada",
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

  function simpan_tt(argument) {
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
          data:$('.tabel_tt_penerus :input').serialize()
               +'&'+$('.head1 :input').serialize(),
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

  function print_penerus() {
   window.open('{{url('fakturpembelian/detailbiayapenerus')}}'+'/'+'{{$cari_fp->fp_idfaktur}}');
  }




</script>


@endsection
