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
        <a class="pull-right jurnal" style="margin-right: 20px;"><i class="fa fa-eye"> Lihat Jurnal Form</i></a>
        <a class="pull-right jurnal_um" style="margin-right: 20px;"><i class="fa fa-eye"> Lihat Jurnal Uang Muka</i></a>
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
              <input type="text" name="Invoice_biaya" readonly="" class="form-control invoice_tt" value="{{$cari_fp->fp_noinvoice}}" placeholder="No Invoice">
            </td>
           </tr>
           <tr>
            <td style="width: 100px">Tanda terima</td>
            <td width="10">:</td>
            <td width="200">
              <input type="text" readonly="" name="tanda_terima" class="form-control tanda_terima" value="{{ $tt->tt_noform }}">
              <input type="hidden" readonly="" name="invoice_tt" class="form-control invoice_tt" value="{{ $tt->ttd_invoice }}">
              <input type="hidden" readonly="" name="id_tt" class="form-control id_tt" value="{{ $tt->ttd_id }}">
              <input type="hidden" readonly="" name="dt_tt" class="form-control dt_tt" value="{{ $tt->ttd_detail }}">
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

               <button type="button" style="margin-right: 20px;" class="btn btn-warning pull-left @if($cari_fp->fp_pending_status == 'PENDING') disabled @endif " id="print-tt" onclick="cetak_tt('{{$form_tt->tt_noform or $nota}}')"><i class="fa fa-print"></i> Print Tanda Terima</button>
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
                <td class="disabled">
                  <select class="form-control akun_biaya chosen-select-width1" style="text-align: center; ">
                    <option value="0" selected="">Pilih - akun</option>
                    @foreach($akun as $val)
                      <option @if($val->id_akun == '531512000') selected="" @endif value="{{$val->id_akun}}" >{{$val->id_akun}} - {{$val->nama_akun}}</option>
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
                  <button class="btn btn-primary btn_modal_bp" type="button" > Bayar dengan Uang Muka </button>
               <button onclick="tt_penerus()" class="btn btn-info modal_penerus_tt "  type="button" data-toggle="modal"  type="button"> <i class="fa fa-book"> </i> &nbsp; Form Tanda Terima </button>
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
@include('purchase.pembayaran_vendor.modal_do_vendor')




{{-- modal uang muka --}}

<div id="modal_um_bp" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document" style="width: 1200px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pembayaran Uang Muka</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-sm-8">
              <table class="table bp_tabel_um">
              <tr>
                <td>No Transaksi Kas / Bank</td>
                <td colspan="2">
                  <input placeholder="klik disini" type="text" name="bp_nomor_um" class=" form-control bp_nomor_um">
                  <input type="hidden" name="bp_id_um" class=" form-control bp_id_um">
                </td>
              </tr>
              <tr>
                <td>Tanggal</td>
                <td colspan="2">
                  <input type="text" name="bp_tanggal_um" class=" form-control bp_tanggal_um">
                </td>
              </tr>
              <tr>
                <td>Jumlah</td>
                <td colspan="2">
                  <input readonly="" type="text" name="bp_jumlah_um" class=" form-control bp_jumlah_um">
                </td>
              </tr>
              <tr>
                <td>Sisa Uang Muka</td>
                <td colspan="2">
                  <input readonly="" type="text" name="bp_sisa_um" class=" form-control bp_sisa_um">
                </td>
              </tr>
              <tr>
                <td>Keterangan</td>
                <td colspan="2">
                  <input readonly="" type="text" name="bp_keterangan_um" class=" form-control bp_keterangan_um">
                </td>
              </tr>
              <tr>
                <td>Dibayar</td>
                <td>
                  <input type="text" name="bp_dibayar_um" class=" form-control bp_dibayar_um">
                </td>
                <td align="right">
                    <button class="btn btn-primary bp_tambah_um "type="button" ><i class="fa fa-plus"> Tambah</i></button> 
                  </div>
                </td>
              </tr>
            </table>
            </div>
            <div class="col-sm-4">
              <table class="table ">
                <tr>
                  <td align="center">
                   <h3>Total Jumlah Uang Muka</h3>
                  </td>
                </tr>
              <tr>
                <td>
                  <input readonly="" type="text" name="bp_total_um" class="bp_total_um form-control ">
                </td>
              </tr>
            </table>
            </div>

              <div class="col-sm-12">
               <table class="table table-bordered bp_tabel_detail_um" style="font-size: 12px">
                <thead>
                <tr class="tableum">
                  <th style="width:120px"> No Faktur </th>
                  <th> No Kas / Bank</th>
                  <th> Tanggal </th>
                  <th> No Uang Muka</th>
                  <th> Jumlah Uang Muka </th>
                  <th> Sisa Uang Muka </th>
                  <th> Dibayar </th>
                  <th> Keterangan</th>
                  <th> Aksi </th> 
                </tr>
                </thead>
                <tbody>
              
               </tbody>
            </table>
          </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save_bp_um " >Save changes</button>
      </div>
      </div>
     
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->


<div id="modal_show_um" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document" style="width: 1200px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pilih Uang Muka</h4>
      </div>
      <div class="modal-body bp_div_um">
        
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal modal_jurnal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width: 1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body tabel_jurnal">
          
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        location.reload();
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
    datatable1.$('.bayar_biaya').each(function(){
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
      @for($i = 0; $i<count($akun); $i++)
        @if($val->bpd_akun_biaya == $akun[$i]->id_akun)
          var akun_biaya_text     = '{{$akun[$i]->id_akun}}-{{$akun[$i]->nama_akun}}';
          @else
          var akun_biaya_text     = '{{$val->bpd_akun_biaya}}';
        @endif
      @endfor
      var keterangan_biaya    = "{{$val->bpd_memo}}";
      var nominal             = "{{$val->bpd_nominal}}";
      var harga_do            = "{{$val->bpd_tarif_resi}}";
      // nominal                 = nominal.replace(/[^0-9\-]+/g,"");

      console.log('{{ $val->bpd_akun_biaya }}');
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
            ] ).draw();  

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

  var um = $('.bp_total_um').val();
  um = um.replace(/[^0-9\-]+/g,"")/100;
  var bayar_biaya = $(par).find('.bayar_biaya').val();
  bayar_biaya = bayar_biaya.replace(/[^0-9\-]+/g,"")/1;
  var temp = 0;
  datatable1.$('.bayar_biaya').each(function(){
    temp+=parseInt($(this).val());
  })

  temp = temp - bayar_biaya + e_nominal;

  if (temp < um) {
  toastr.warning('Pembayaran Uang Muka Melebihi Total');
  return false;
  }

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
    var um = $('.bp_total_um').val();
    um = um.replace(/[^0-9\-]+/g,"")/100;

    var parent = $(par).parents('tr');
    var pod = $(parent).find('.no_do').val();
    var bayar_biaya = $(parent).find('.bayar_biaya').val();
    bayar_biaya = bayar_biaya.replace(/[^0-9\-]+/g,"")/1;

    var temp = 0;
    datatable1.$('.bayar_biaya').each(function(){
      temp+=parseInt($(this).val());
    })
    temp = temp - bayar_biaya;
    console.log(um);
    console.log(temp);

    if (temp < um) {
      toastr.warning('Pembayaran Uang Muka Melebihi Total');
      return false;
    }

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

    var cabang = $('.cabang').val();
    var agen_vendor = $('.agen_vendor ').val();
    $.ajax({
      url:baseUrl +'/fakturpembelian/nota_tt',
      data: {cabang,agen_vendor},
      success:function(data){
        $('.div_tt').html(data);
        $('#modal_tt_penerus').modal('show');
      },error:function(){
        toastr.warning('Terjadi Kesalahan');
      }
    })

  }
  function select_tt(a) {
    var tt_form = $(a).find('.tt_form').text();
    var tt_invoice = $(a).find('.tt_invoice').text();
    var tt_id = $(a).find('.tt_id').val();
    var tt_dt = $(a).find('.tt_dt').val();

    $('.tanda_terima').val(tt_form);
    $('.invoice_tt').val(tt_invoice);
    $('.Invoice_biaya').val(tt_invoice);
    $('.id_tt').val(tt_id);
    $('.dt_tt').val(tt_dt);
    $('#modal_tt_penerus').modal('hide');
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

  function print_penerus() {
   window.open('{{url('fakturpembelian/detailbiayapenerus')}}'+'/'+'{{$cari_fp->fp_idfaktur}}');
  }
  function cetak_tt(id) {
   var id = id.replace(/\//g, "-");
   window.open('{{url('fakturpembelian/cetak_tt')}}'+'/'+id);
  }


function hitung_um() {
  var temp = 0;
  datatable2.$('.tb_bayar_um').each(function(){
    var b = $(this).val();
    b   = b.replace(/[^0-9\-]+/g,"")/100;
    console.log(b);
    temp+=b;
  })
  $('.bp_total_um').val(accounting.formatMoney(temp, "", 2, ".",','));

}
  

$('.btn_modal_bp').click(function(){
  $('#modal_um_bp').modal('show');
})


var array_um1 = [0];
var array_um2 = [0];
$('.bp_nomor_um').focus(function(){
  var sup = $('.agen_vendor').val();
  var id  = $('.nofaktur').val();
  if (sup == '0') {
    toastr.warning('Agen/Vendor Harus Diisi');
    return false;
  }

  $.ajax({
    url:baseUrl +'/fakturpembelian/biaya_penerus_um',
    data: {sup,array_um1,array_um2,id},
    success:function(data){
      console.log('asd');
      $('.bp_div_um').html(data);
      $('#modal_show_um').modal('show');
    },error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
  })

})


var id_um    = 1;

$('.bp_tambah_um').click(function(){
  var nota = $('.bp_nomor_um').val();
  var sup = $('.agen_vendor').val();
  var nofaktur = $('.nofaktur').val();
  var bp_id_um = $('.bp_id_um').val();
  var bp_dibayar_um = $('.bp_dibayar_um').val();
  bp_dibayar_um   = bp_dibayar_um.replace(/[^0-9\-]+/g,"")/1;
  var id  = $('.nofaktur').val();




  if (nota == '') {
    toastr.warning("Uang Muka Harus dipilih");
    return false;
  }
  if (bp_dibayar_um == '' || bp_dibayar_um == '0') {
    toastr.warning("Pembayaran Tidak Boleh 0");
    return false;
  }

  
  

  $.ajax({
    url:baseUrl +'/fakturpembelian/biaya_penerus/append_um',
    data: {nota,sup,id},
    dataType:'json',
    success:function(data){

      $('.bp_nomor_um').val(data.data.nomor);
      $('.bp_tanggal_um').val(data.data.um_tgl);
      $('.bp_jumlah_um').val(accounting.formatMoney(data.data.total_um, "", 2, ".",','));
      $('.bp_sisa_um').val(accounting.formatMoney(data.data.sisa_um, "", 2, ".",','));
      $('.bp_keterangan_um').val(data.data.um_keterangan);

      if (bp_dibayar_um > data.data.sisa_um) {
        toastr.warning("Pembayaran Melebihi Sisa Uang Muka");
        return false;
      }
      if (bp_id_um == '') {
        datatable2.row.add([
            '<p class="tb_faktur_um_text">'+nofaktur+'</p>'+
            '<input type="hidden" class="tb_faktur_um_'+id_um+' tb_faktur_um" value="'+id_um+'">',

            '<p class="tb_transaksi_um_text">'+data.data.nomor+'</p>'+
            '<input type="hidden" class="tb_transaksi_um" name="tb_transaksi_um[]" value="'+data.data.nomor+'">',

            '<p class="tb_tanggal_text">'+data.data.um_tgl+'</p>',

            '<p class="tb_um_um_text">'+data.data.um_nomorbukti+'</p>'+
            '<input type="hidden" class="tb_um_um" name="tb_um_um[]" value="'+data.data.um_nomorbukti+'">',

            '<p class="tb_jumlah_um_text">'+accounting.formatMoney(data.data.total_um, "", 2, ".",',')+'</p>',

            '<p class="tb_sisa_um_text">'+accounting.formatMoney(data.data.sisa_um, "", 2, ".",',')+'</p>',

            '<p class="tb_bayar_um_text">'+accounting.formatMoney(bp_dibayar_um, "", 2, ".",',')+'</p>'+
            '<input type="hidden" class="tb_bayar_um" name="tb_bayar_um[]" value="'+accounting.formatMoney(bp_dibayar_um, "", 2, "",'.')+'">',

            '<p class="tb_keterangan_um_text">'+data.data.um_keterangan+'</p>',

            '<div class="btn-group ">'+
            '<a  onclick="edit_um(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
            '<a  onclick="hapus_um(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
            '</div>',
          ]).draw();
        id_um++;
        array_um1.push(data.data.nomor);
        array_um2.push(data.data.um_nomorbukti);
      }else{
        var par = $('.tb_faktur_um_'+bp_id_um).parents('tr');
        $(par).find('.tb_bayar_um').val(accounting.formatMoney(bp_dibayar_um, "", 2, "",'.'));
        $(par).find('.tb_bayar_um_text').text(accounting.formatMoney(bp_dibayar_um, "", 2, ".",','));
      }
      hitung_um();
      $('.bp_tabel_um :input').val('');
    },error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
  })
})


function edit_um(a) {
  var par = $(a).parents('tr');
  var tb_faktur_um          = $(par).find('.tb_faktur_um').val();
  var tb_transaksi_um       = $(par).find('.tb_transaksi_um').val();
  var tb_tanggal_text       = $(par).find('.tb_tanggal_text').text();
  var tb_um_um              = $(par).find('.tb_um_um').val();
  var tb_jumlah_um_text     = $(par).find('.tb_jumlah_um_text').text();
  var tb_sisa_um_text       = $(par).find('.tb_sisa_um_text').text();
  var tb_bayar_um           = $(par).find('.tb_bayar_um').val();
  console.log(tb_bayar_um);
  var tb_keterangan_um_text = $(par).find('.tb_keterangan_um_text').text();

  $('.bp_id_um').val(tb_faktur_um);
  $('.bp_nomor_um').val(tb_transaksi_um);
  $('.bp_tanggal_um').val(tb_tanggal_text);
  $('.bp_jumlah_um').val(tb_jumlah_um_text);
  $('.bp_sisa_um').val(tb_sisa_um_text);
  $('.bp_keterangan_um').val(tb_keterangan_um_text)
  $('.bp_dibayar_um').val(accounting.formatMoney(tb_bayar_um, "", 0, ".",','));

}

function hapus_um(a) {
  var par             = $(a).parents('tr');
  var tb_transaksi_um = $(par).find('.tb_transaksi_um').val();
  var tb_um_um        = $(par).find('.tb_um_um').val();

  var index1 = array_um1.indexOf(tb_transaksi_um);
  var index2 = array_um2.indexOf(tb_um_um);

  array_um1.splice(index1,1);
  array_um2.splice(index2,1);

  datatable2.row(par).remove().draw(false);

  hitung_um();
}


$('.save_bp_um').click(function(){

  var temp = 0;
  var bp_total_um = $('.bp_total_um').val();
  datatable2.$('.tb_bayar_um').each(function(){
    var b = $(this).val();
    b   = b.replace(/[^0-9\-]+/g,"")/100;
    console.log(b);
    temp+=b;
  })
  var total_jml = $('.total_jml').val();
  total_jml   = total_jml.replace(/[^0-9\-]+/g,"")/100;

  if (temp > total_jml) {
    toastr.warning("Pembayaran Lebih Besar Dari Total Faktur");
    return false;
  }

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
        url:baseUrl + '/fakturpembelian/update_bp_um',
        type:'post',
        data:$('.head1 :input').serialize()
              +'&'+$('.head_biaya :input').serialize()
              +'&'+datatable2.$('input').serialize()+'&bp_total_um='+bp_total_um,
        success:function(response){
          if (response.status == 1) {
              swal({
                  title: "Berhasil!",
                  type: 'success',
                  text: "Data berhasil disimpan",
                  timer: 900,
                  showConfirmButton: true
                  },function(){
                   $('.save_bp_um').addClass('disabled');
                   $('.btn_modal_bp').addClass('disabled');
                   
                  });
          }else if(response.status == 0){
            swal({
              title: "Data Faktur Tidak Ada",
              type: 'error',
              timer: 900,
              showConfirmButton: true

            });
          }else if(response.status == 2){
            swal({
              title: "Status Faktur Pending",
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
})


var datatable2 = $('.bp_tabel_detail_um').DataTable({
            responsive: true,
            searching:false,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
            columnDefs: [
              {
                 targets: 4,
                 className: 'right'
              },
              {
                 targets: 5,
                 className: 'right'
              },
              {
                 targets: 6,
                 className: 'right'
              },
              {
                 targets: 8,
                 className: 'center'
              }
            ]
    });
$('.bp_dibayar_um').maskMoney({
        precision : 0,
        thousands:'.',
        allowZero:true,
        defaultZero: true
    });


@foreach($um as $i=>$val)

  var nofaktur        = '{{$val->umfp_nofaktur}}';
  var nomor           = '{{$val->umfpdt_transaksibank}}';
  var um_tgl          = '{{$val->umfp_tgl}}';
  var um_nomorbukti   = '{{$val->umfpdt_notaum}}';
  var total_um        = '{{$val->umfpdt_jumlahum}}';
  var sisa_um         = '{{$val->bkkd_sisa_um + $val->umfpdt_dibayar}}';
  var bp_dibayar_um   = '{{$val->umfpdt_dibayar}}';
  var um_keterangan   = '{{$val->umfpdt_keterangan}}';
  console.log(nofaktur);

  datatable2.row.add([
            '<p class="tb_faktur_um_text">'+nofaktur+'</p>'+
            '<input type="hidden" class="tb_faktur_um_'+id_um+' tb_faktur_um" value="'+id_um+'">',

            '<p class="tb_transaksi_um_text">'+nomor+'</p>'+
            '<input type="hidden" class="tb_transaksi_um" name="tb_transaksi_um[]" value="'+nomor+'">',

            '<p class="tb_tanggal_text">'+um_tgl+'</p>',

            '<p class="tb_um_um_text">'+um_nomorbukti+'</p>'+
            '<input type="hidden" class="tb_um_um" name="tb_um_um[]" value="'+um_nomorbukti+'">',

            '<p class="tb_jumlah_um_text">'+accounting.formatMoney(total_um, "", 2, ".",',')+'</p>',

            '<p class="tb_sisa_um_text">'+accounting.formatMoney(sisa_um, "", 2, ".",',')+'</p>',

            '<p class="tb_bayar_um_text">'+accounting.formatMoney(bp_dibayar_um, "", 2, ".",',')+'</p>'+
            '<input type="hidden" class="tb_bayar_um" name="tb_bayar_um[]" value="'+bp_dibayar_um+'">',

            '<p class="tb_keterangan_um_text">'+um_keterangan+'</p>',

            '<div class="btn-group ">'+
            '<a  onclick="edit_um(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
            '<a  onclick="hapus_um(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
            '</div>',
          ]).draw();
    id_um++;
    array_um1.push(nomor);
    array_um2.push(um_nomorbukti);
    hitung_um();
    $('.bp_tabel_um :input').val('');
@endforeach



  function jurnal() {
    var id = '{{ $id }}';
    $.ajax({
        url:baseUrl + '/fakturpembelian/biaya_penerus/jurnal',
        type:'get',
        data:{id},
        success:function(data){
           $('.tabel_jurnal').html(data);
        },
        error:function(data){
            // location.reload();
        }
    }); 
  }

  function jurnal_um() {
    var id = '{{ $id }}';
    $.ajax({
        url:baseUrl + '/fakturpembelian/biaya_penerus/jurnal_um',
        type:'get',
        data:{id},
        success:function(data){
           $('.tabel_jurnal').html(data);
        },
        error:function(data){
            // location.reload();
        }
    }); 
  }

$('.jurnal').click(function(){
  $('.modal_jurnal').modal('show');
  jurnal();
})

// $('.jurnal_um').click(function(){
//   $('.modal_jurnal').modal('show');
//   jurnal_um();
// })

</script>


@endsection
