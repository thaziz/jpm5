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
  <a class="pull-right jurnal" style="margin-right: 20px;"><i class="fa fa-eye"> Lihat Jurnal</i></a>
<a class="pull-right jurnal_um" style="margin-right: 20px;"><i class="fa fa-eye"> Lihat Jurnal Uang Muka</i></a>
</div>
<div class="ibox-content col-sm-12">


<div class="col-sm-12 header_biaya"  >
  {{ csrf_field() }}
<form>
<div class="col-sm-6">
<table class="table head_subcon">
  <h3 style="text-align: center;">Form Subcon</h3>
   <tr>
<td> Cabang </td>

  <td width="10">:</td>
  <td class="disabled"> 
  <select class="form-control chosen-select-width disabled cabang" name="cabang">
    @foreach($cabang as $i)
    <option value="{{$i->kode}}" @if($data->fp_comp == $i->kode) selected @endif>{{$i->kode}} - {{$i->nama}} </option>
    @endforeach
  </select> 
  </td>
</tr>
<tr>
<td width="150px">
No Faktur
</td>
  <td width="10">:</td>
<td>
   <input type="text" class="form-control nofaktur" name="nofaktur" value="{{$data->fp_nofaktur}}" required="" readonly="">
   <input type="hidden" class="form-control idfaktur" name="idfaktur" value="{{$data->fp_idfaktur}}" required="" readonly="">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
</td>
</tr>
<tr>
  <td style="width: 100px">Tanggal</td>
  <td width="10">:</td>
  <td width="200">
    <input type="text" name="tgl_biaya_head" class="form-control tgl-biaya" value="{{carbon\carbon::parse($data->fp_tgl)->format('d/m/Y')}}" readonly="" style="">
    <input type="hidden" name="nota_id_tt" class="form-control nota_id_tt" value="{{$valid_cetak->tt_idform}}" readonly="" style="">
    <input type="hidden" name="nota_no_tt" class="form-control nota_no_tt" value="{{$valid_cetak->tt_noform}}" readonly="" style="">
  </td>
 </tr>
 <tr>
  <td style="width: 100px">Jatuh Tempo</td>
  <td width="10">:</td>
  <td width="200">
    <input type="text" name="tempo_subcon" class="form-control tempo_subcon" value="{{carbon\carbon::parse($data->fp_jatuhtempo)->format('d/m/Y')}}" >
  </td>
 </tr>
<tr>
  <td style="width: 100px">Status </td>
  <td width="10">:</td>
  <td width="200"><input type="text" name="status" class="form-control" value="Released" readonly="" ></td>
 </tr>
  <tr class=" hd2" >
  <td style="width: 100px">Nama Subcon</td>
  <td width="10">:</td>
  <td width="200" class="subcon_td disabled" >
    <select class="nama_sc form-control chosen-select-width1" name="nama_subcon">
        <option value="0">- Cari - Subcon -</option>
      @foreach($subcon as $sub)
        <option @if($data->fp_supplier == $sub->kode) selected="" @endif value="{{$sub->kode}}">{{$sub->kode}} - {{$sub->nama}}</option>
      @endforeach
    </select>
  </td>
  </tr> 
 <tr>
  <td style="width: 100px">No Invoice </td>
  <td width="10">:</td>
  <td width="200"><input type="text" readonly="" value="{{$data->fp_noinvoice}}" name="invoice_subcon" class="form-control invoice_tt" ></td>
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
  <td style="width: 100px">Keterangan </td>
  <td width="10">:</td>
  <td width="200"><input type="text" value="{{$data->fp_keterangan}}" name="keterangan_subcon" class="form-control keterangan_subcon"  ></td>
 </tr>  
 <tr>
  <td style="width: 100px">Total Biaya</td>
  <td width="10">:</td>
  <td width="200"><input type="text" readonly="" style="text-align: right" value="{{'Rp ' . number_format($data->fp_netto,2,',','.')}}"  class="form-control total_subcon" name="total_subcon" ></td>
 </tr>
</table>
</div>
<div class="col-sm-12 detail_subcon"  >
  <div class="col-sm-5 table_filter_subcon"   >
    <form class="form">
    <table class="table table_resi">
      <div align="center" style="width: 100%;"> 
      <h3 >Form Resi Subcon</h3>
    </div>  
    <tr hidden="">
    <td style="width: 100px">Nomor Seq</td>
    <td width="10">:</td>
    <td width="200">
      <input type="text" class="form-control m_seq" readonly="" value="1" >
    </td>
    </tr>
     <tr>
    <td style="width: 100px">Nomor POD</td>
    <td width="10">:</td>
    <td width="200">

      <input type="text" placeholder="Klik Disini..." class="form-control m_do_subcon"  >
    </td>
    </tr>
    <tr>
    <td style="width: 100px">Jenis Angkutan DO</td>
    <td width="10">:</td>
    <td width="200">
      <input type="text" readonly="" class="form-control m_jenis_angkutan_do" >
    </td>
   </tr>
    <tr>
    <td style="width: 100px">Tanggal</td>
    <td width="10">:</td>
    <td width="200">
      <input type="text" readonly="" placeholder="" class="form-control m_do_tanggal"  >
    </td>
    </tr>
     <tr>
    <td style="width: 100px" class="label_satuan">Jumlah</td>
    <td width="10">:</td>
    <td class="form-inline form_satuan">
      <div class="input-group" style="width: 100%">
                <input readonly=""  style="width: 100%" class="form-control m_do_jumlah" type="text" value="" >
                <span class="input-group-addon m_satuan" style="padding-bottom: 12px;">satuan</span>
             </div>
    </td>
    </tr>
    
    
   <tr>
    <td style="width: 100px">Asal DO</td>
    <td width="10">:</td>
    <td width="200">
      <input type="text" readonly="" class="form-control m_do_asal" >
      <input type="hidden" readonly="" class="form-control no_do_asal" >
    </td>
   </tr>
   <tr>
    <td style="width: 100px">Tujuan DO</td>
    <td width="10">:</td>
    <td width="200">
      <input type="text" readonly="" class="form-control m_do_tujuan" >
      <input type="hidden" readonly="" class="form-control no_do_tujuan" >
    </td>
   </tr>

   <tr>
    <td style="width: 100px">Tipe Kendaraan DO</td>
    <td width="10">:</td>
    <td width="200">
      <input type="text" readonly="" class="form-control m_tipe_kendaraan" >
      <input type="hidden" readonly="" class="form-control no_tipe_kendaraan" >
    </td>
   </tr>
  
     </table>
    </form>
</div>
  <div class="col-sm-5" style="margin-left: 100px;">
  <table class="table table_kontrak" >
       <div align="center" style="width: 100%;" > 
      <h3 >Form Kontrak Subcon</h3>
     </div> 
      <tr>
      <td style="width: 100px">Nomor</td>
      <td width="10">:</td>
      <td>
        <input type="text" name="sc_nomor_kontrak" class="form-control nota_subcon"  placeholder="Klik Disini...">
        <input type="hidden" name="sc_id_subcon" class="form-control id_subcon"  readonly="">
        <input type="hidden" name="sc_dt_subcon" class="form-control dt_subcon"  readonly="">
      </td>
      </tr>
      <tr>
      <td style="width: 100px">Biaya Subcon</td>
      <td width="10">:</td>
      <td width="200">
        <input type="text" class="form-control sc_biaya_subcon"  readonly="" value="" >
        <input type="hidden" class="form-control sc_biaya_subcon_dt" style="width: 250px;">
      </td>
      </tr>
      <tr>
      <td style="width: 100px">Jumlah</td>
      <td width="10">:</td>
      <td width="200">
        <div class="input-group" style="width: 100%">
                  <input onkeyup="hitung_jumlah()" style="width: 100%" class="form-control sc_jumlah" type="text" value="" >
              </div>
      </td>
     </tr>
     <tr>
      <td style="width: 100px">Total Biaya</td>
      <td width="10">:</td>
      <td width="200">
        <div class="input-group" style="width: 100%">
                  <input readonly=""  style="width: 100%" class="form-control sc_total" type="text" value="" >
                  <input readonly=""  style="width: 100%" class="form-control sc_total_dt" type="hidden" value="" >
              </div>
      </td>
     </tr>
      <tr>
      <td style="width: 100px">Jenis Tarif</td>
      <td width="10">:</td>
      <td width="200">

        <input type="text" name="tarif_subcon" class="form-control sc_tarif_subcon" readonly=""  >
        <input type="hidden" name="kode_tarif_subcon" class="form-control sc_tarif_subcon" style="width: 250px;">
      </td>
      </tr>
      <tr>
      <td style="width: 100px">Akun</td>
      <td width="10">:</td>
      <td width="200" class="disabled">
        <select class="form-control chosen-select-width1 sc_akun">
          @foreach($akun_biaya as $i)
            <option @if($i->id_akun == '521011000') selected="" @endif value="{{$i->id_akun}}">5210 - SUBCON KARGO</option>
          @endforeach
        </select>
      </td>
      </tr>
      
      <tr>
      <td style="width: 100px">Memo</td>
      <td width="10">:</td>
      <td width="200">
        <input type="text"  class="form-control sc__do_memo" >
      </td>
     </tr>
      <tr>
      <td style="width: 100px">Asal Kontrak</td>
      <td width="10">:</td>
      <td width="200">

        <input type="text" readonly="" class="form-control sc_asal_subcon" >
        <input type="hidden" readonly="" class="form-control sc_no_asal_subcon" >
      </td>
      </tr>
      <tr>
      <td style="width: 100px">Tujuan Kontrak</td>
      <td width="10">:</td>
      <td width="200">

        <input type="text" readonly=""  class="form-control sc_tujuan_subcon">
        <input type="hidden" readonly=""  class="form-control sc_no_tujuan_subcon">
      </td>
      </tr>
      <tr>
      <td style="width: 100px">Kendaraaan</td>
      <td width="10">:</td>
      <td width="200">

        <input type="text" class="form-control sc_kendaraan_subcon" readonly=""  >
        <input type="hidden" class="form-control sc_no_kendaraan_subcon" readonly=""  >
        <input type="hidden" class="form-control sc_kode_angkutan" style="width: 250px;">
      </td>
      </tr>
       <tr>
      <td colspan="3">
        <button class="btn btn-info modal_tt_subcon disabled pull-left" style="margin-right: 10px;" type="button" data-toggle="modal"  type="button"> <i class="fa fa-book"> </i> &nbsp; Form Tanda Terima </button>

          <button type="button" class="btn btn-primary pull-right append_subcon" onclick="cariSUB()"><i class="fa fa-plus">&nbsp;Append</i></button>
          <button type="button" style="margin-right: 20px" class="btn  pull-right" onclick="cancel_data()"><i class="fa fa-close">&nbsp;Clear</i></button>
      </td>
     </tr>
  </table>
  </div>
</div>
</form>
</div>



<div class="col-sm-5 table_filter_resi disabled " hidden   style="margin-left: 100px;">
    <form class="form">
     <table class="table">
     <div align="center" style="width: 100%;">  
    <h3 >Detail Biaya Penerus Hutang</h3>
   </div> 
    
     </table>
     <button type="button" class="btn btn-primary pull-right cari_pod" onclick="cariSUB();"><i class="fa fa-search">&nbsp;Search</i></button>
    </form>
</div>

 <div class=" col-sm-12 tb_sb_hidden">
  <h3>Tabel Detail Resi</h3>
  <hr>
      <button type="button" class="btn btn-primary pull-right save_subcon " id="save_subcon" onclick="save_subcon()"><i class="fa fa-save"></i> Simpan Data</button>
      <button type="button" style="margin-right: 20px" class="btn btn-warning pull-right print_subcon" id="print_subcon" onclick="print_penerus()"><i class="fa fa-print"></i> Print</button>
      <button type="button" style="margin-right: 20px" class="btn btn-warning pull-right print-penerus" id="print-penerus" onclick="print_penerus_tt()" ><i class="fa fa-print"></i> Print Tanda Terima</button>
        <button class="btn btn-primary btn_modal_sc  pull-right " style="margin-right: 20px" type="button" > Bayar dengan Uang Muka </button>


      <table class="table table-bordered table-hover tabel_subcon" style="font-size: 12px;">
      <thead align="center">
        <tr>
        <th>No</th>
        <th width="90">Nomor Resi</th>
        <th>Harga Resi</th>
        <th>Asal Subcon</th>
        <th>Tujuan Subcon</th>
        <th>Jenis Tarif</th>
        <th>Akun</th>
        <th>Keterangan</th>
        <th width="100">Aksi</th>
        </tr>
      </thead> 
      <tbody align="center" class="body-biaya">

      </tbody>    
      </table>
  </div>
  
<div id="modal_subcon" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 1000px;">

    <!-- Modal content-->
    <div id="subcon_modal" class="modal-content">
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





<!-- modal DO-->
<div id="modal_do" class="modal fade" >
  <div class="modal-dialog" style="min-width: 1000px !important; min-height: 1000px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pilih Nomor DO</h4>
      </div>
      <div class="modal-body">
            <form class="form-horizontal  tabel_subcon_detail">
               
            </form>
          </div>
          <div class="modal-footer">
          </div>
    </div>
  </div>
</div>

    </div> 
  </div>
</div>



{{-- modal uang muka subcon --}}

<div id="modal_um_sc" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document" style="width: 1200px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pembayaran Uang Muka</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-sm-8">
              <table class="table sc_tabel_um">
              <tr>
                <td>No Transaksi Kas / Bank</td>
                <td colspan="2">
                  <input placeholder="klik disini" type="text" name="sc_nomor_um" class=" form-control sc_nomor_um">
                  <input type="hidden" name="sc_id_um" class=" form-control sc_id_um">
                </td>
              </tr>
              <tr>
                <td>Tanggal</td>
                <td colspan="2">
                  <input type="text" name="sc_tanggal_um" class=" form-control sc_tanggal_um">
                </td>
              </tr>
              <tr>
                <td>Jumlah</td>
                <td colspan="2">
                  <input readonly="" type="text" name="sc_jumlah_um" class=" form-control sc_jumlah_um">
                </td>
              </tr>
              <tr>
                <td>Sisa Uang Muka</td>
                <td colspan="2">
                  <input readonly="" type="text" name="sc_sisa_um" class=" form-control sc_sisa_um">
                </td>
              </tr>
              <tr>
                <td>Keterangan</td>
                <td colspan="2">
                  <input readonly="" type="text" name="sc_keterangan_um" class=" form-control sc_keterangan_um">
                </td>
              </tr>
              <tr>
                <td>Dibayar</td>
                <td>
                  <input type="text" name="sc_dibayar_um" class=" form-control sc_dibayar_um">
                </td>
                <td align="right">
            
                    <button class="btn btn-primary sc_tambah_um" type="button" ><i class="fa fa-plus"> Tambah</i></button> 
     
                </td>
              </tr>
            </table>
            </div>
            <div class="col-sm-4">
              <table class="table ">
                <tr>
                  <td align="center">
                   <h3>Tscal Jumlah Uang Muka</h3>
                  </td>
                </tr>
              <tr>
                <td>
                  <input readonly="" type="text" name="sc_total_um" class="sc_total_um form-control ">
                </td>
              </tr>
            </table>
            </div>

              <div class="col-sm-12">
               <table class="table table-bordered sc_tabel_detail_um" style="font-size: 12px">>
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
        <button type="hidden" class="btn btn-primary save_sc_um " >Save changes</button>
      </div>
      </div>
     
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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

@include('purchase.pembayaran_vendor.modal_do_vendor')

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
  // global variable
  var array_do =[];
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
var subcon = $('.tabel_subcon').DataTable({
          // 'paging':false,
          'searching':false
        });

$('.tempo_subcon').datepicker({
  format:'dd/mm/yyyy'
});


$('.m_do_subcon').focus(function(){
    var  selectOutlet = $('.nama_sc').val();
    if (selectOutlet == '0') {
      toastr.warning('Harap Pilih Customer');
      return 1;
    }

    var  cabang     = $('.cabang').val();

    $.ajax({
        url:baseUrl +'/fakturpembelian/cari_do_subcon',
        data: {selectOutlet,cabang,array_do},
        success:function(data){
          $('.tabel_subcon_detail').html(data);
      $('#modal_do').modal('show');
        },error:function(){
          toastr.warning('Terjadi Kesalahan');
        }
      })
})

$('.nota_subcon').focus(function(){
    var  selectOutlet = $('.nama_sc').val();
    if (selectOutlet == '0') {
      toastr.warning('Harap Pilih Customer');
      return 1;
    }

    var  cabang     = $('.cabang').val();

    $.ajax({
        url:baseUrl +'/fakturpembelian/cari_kontrak_subcon',
        data: {selectOutlet,cabang},
        success:function(data){
          $('.subcon_modal').html(data);
      $('#modal_subcon').modal('show');
        },error:function(){
          toastr.warning('Terjadi Kesalahan');
        }
      })
})




function pilih_do_subcon(par) {
  var d_nomor_do = $(par).find('.d_nomor_do').val();
  var d_tanggal = $(par).find('.d_tanggal').val();
  var d_jumlah = $(par).find('.d_jumlah').val();
  var d_satuan = $(par).find('.d_satuan').val();
  var d_asal = $(par).find('.d_asal').val();
  var d_tujuan = $(par).find('.d_tujuan').val();
  var d_asal_text = $(par).find('.d_asal_text').text();
  var d_tujuan_text = $(par).find('.d_tujuan_text').text();
  var d_jenis_tarif_text = $(par).find('.d_jenis_tarif_text').text();
  var d_tipe_angkutan_text = $(par).find('.d_tipe_angkutan_text').text();
  var d_tipe_angkutan = $(par).find('.d_tipe_angkutan').val();
  
  $('.m_do_subcon').val(d_nomor_do);
  $('.m_do_tanggal').val(d_tanggal);
  $('.m_do_jumlah').val(d_jumlah);
  $('.m_satuan').text(d_satuan);
  $('.m_do_asal').val(d_asal_text);
  $('.m_do_tujuan').val(d_tujuan_text);
  $('.m_jenis_angkutan_do').val(d_jenis_tarif_text);
  $('.m_tipe_kendaraan').val(d_tipe_angkutan_text);
  
  $('.no_do_asal').val(d_asal);
  $('.no_do_tujuan').val(d_tujuan);
  $('.no_tipe_kendaraan').val(d_tipe_angkutan);
  $('#modal_do').modal('hide');




}

function hitung_jumlah() {
    var harga = $('.sc_biaya_subcon_dt').val();
    var jumlah = $('.sc_jumlah').val();
    $('.sc_total').val(accounting.formatMoney(harga * jumlah, "Rp ", 2, ".",','));
    $('.sc_total_dt').val(harga * jumlah);
  
}
function pilih_kontrak(asd){
  var id = $(asd).find('.id_kontrak').val();

  $.ajax({
    url : baseUrl +'/fakturpembelian/pilih_kontrak',
      data: 'id='+id,
      type:'get',
      dataType:'json',
      success:function(response){
        console.log(response.subcon_dt[0].ksd_nota);
        $('.nota_subcon').val(response.subcon_dt[0].ksd_nota);
        $('.sc_biaya_subcon').val(response.subcon_dt[0].ksd_harga);
        $('.sc_biaya_subcon_dt').val(response.subcon_dt[0].ksd_harga2);
        $('.id_subcon').val(response.subcon_dt[0].ksd_id);
        $('.sc_jumlah').val('1');
        $('.dt_subcon').val(response.subcon_dt[0].ksd_dt);
        $('.sc_tarif_subcon').val(response.subcon_dt[0].ksd_jenis_tarif);
        $('.sc_asal_subcon').val(response.subcon_dt[0].ksd_asal);
        $('.sc_tujuan_subcon').val(response.subcon_dt[0].ksd_tujuan);
        $('.sc_kendaraan_subcon').val(response.subcon_dt[0].ksd_angkutan);
        $('.table_filter_subcon').removeClass('disabled');

        $('.sc_no_asal_subcon').val(response.subcon_dt[0].no_asal);
        $('.sc_no_tujuan_subcon').val(response.subcon_dt[0].no_tujuan);
        $('.sc_no_kendaraan_subcon').val(response.subcon_dt[0].ksd_id_angkutan);
        hitung_jumlah();


      
      }
  })

  $('#modal_subcon').modal('hide');
}

function cancel_data() {
  $('.table_resi input').val('');
  $('.table_kontrak input').val('');
}

function hitung_subcon() {
  var temp = 0;
  $('.d_harga_subcon').each(function(){
    var total_subcon = $(this).val();
        ini = total_subcon.replace(/[^0-9\-]+/g,"");
        ini = parseFloat(ini);
    temp += ini;
  })

  $('.total_subcon').val(accounting.formatMoney(temp, "Rp ", 2, ".",','));
}



function cariSUB(){

  var m_seq = $('.m_seq').val();
  var nota_subcon = $('.nota_subcon').val();
  var m_do_subcon = $('.m_do_subcon').val();
  var m_do_asal   = $('.m_do_asal').val();

  var no_do_asal = $('.no_do_asal').val();
  var no_do_tujuan = $('.no_do_tujuan').val();
  var no_tipe_kendaraan = $('.no_tipe_kendaraan').val();


  var sc_no_asal_subcon = $('.sc_no_asal_subcon').val();
  var sc_no_tujuan_subcon = $('.sc_no_tujuan_subcon').val();
  var sc_no_kendaraan_subcon = $('.sc_no_kendaraan_subcon').val();

  if (m_do_subcon == '') {
    toastr.warning('POD Harus Diisi !')
    return 1;
  }

  if (nota_subcon == '') {
    toastr.warning('Harap Memasukkan Kontrak Subcon !')
    return 1;
  }

  if (no_do_asal != sc_no_asal_subcon) {
      toastr.warning('Asal Do Tidak Sama Dengan Asal Kontrak');
      return false;
  }

  if (no_do_tujuan != sc_no_tujuan_subcon) {
      toastr.warning('Tujuan Do Tidak Sama Dengan Tujuan Kontrak');
      return false;
  }

  if (no_tipe_kendaraan != sc_no_kendaraan_subcon) {
      toastr.warning('Tipe Kendaraan Do Tidak Sama Dengan Tipe Kendaraan Kontrak');
      return false;
  }


  var sc_total_dt = $('.sc_total_dt').val();
  var sc_total = $('.sc_total').val();
  var sc_jumlah = $('.sc_jumlah').val();
  var sc_biaya_subcon = $('.sc_biaya_subcon').val();
  var sc_asal_subcon = $('.sc_asal_subcon').val();
  var sc_tujuan_subcon = $('.sc_tujuan_subcon').val();
  var sc_tarif_subcon = $('.sc_tarif_subcon').val();
  var sc__do_memo = $('.sc__do_memo').val();
  var m_seq = $('.m_seq').val();
  var sc_akun = $('.sc_akun').val();
  var id_subcon = $('.id_subcon').val();
  var index = array_do.indexOf(m_do_subcon);

  var sc_no_asal_subcon = $('.sc_asal_subcon').val();
  var sc_no_tujuan_subcon = $('.sc_tujuan_subcon').val();
  var sc_no_tarif_subcon = $('.sc_tarif_subcon').val();

  var no_do_asal = $('.m_do_asal').val();
  var no_do_tujuan = $('.m_do_tujuan').val();
  var no_tipe_kendaraan = $('.m_tipe_kendaraan').val();

  
  if (index == -1) {
      subcon.row.add([
                  m_seq+'<input type="hidden" class="seq_sub sub_seq_'+m_do_subcon+'"  value="'+m_seq+'" >'+
                  '<input type="hidden" name="d_ksd_id[]" class="d_ksd_id"  value="'+id_subcon+'" >',

                  '<p class="d_resi_subcon_text">'+m_do_subcon+'</p>'+'<input type="hidden" class="d_resi_subcon"  name="d_resi_subcon[]" value="'+m_do_subcon+'" >',

                  '<p class="d_harga_subcon_text">'+sc_total+'</p>'+'<input type="hidden" name="d_harga_subcon[]" class="d_harga_subcon" value="'+sc_total_dt+'" >'+'<input type="hidden" name="d_jumlah_subcon[]" class="d_jumlah_subcon" value="'+sc_jumlah+'" >',

                  '<p class="d_asal_subcon_text">'+sc_asal_subcon+'</p>'+'<input type="hidden" name="d_asal_subcon[]" class="d_asal_subcon" value="'+sc_asal_subcon+'" >',

                  '<p class="d_tujuan_subcon_text">'+sc_tujuan_subcon+'</p>'+'<input type="hidden" name="d_tujuan_subcon[]" class="d_tujuan_subcon" value="'+sc_tujuan_subcon+'" >',

                  '<p class="d_jenis_tarif_subcon_text">'+sc_tarif_subcon+'</p>'+'<input type="hidden" name="d_jenis_tarif_subcon[]" class="d_jenis_tarif_subcon" value="'+sc_tarif_subcon+'" >',

                  '<p class="d_akun_text">'+sc_akun+'</p>'+'<input type="hidden" class="d_akun" name=d_akun[]" value="'+sc_akun+'">',

                  '<p class="d_memo_subcon_text">'+sc__do_memo+'</p>'+'<input type="hidden" class="d_memo_subcon" name=d_memo_subcon[]" value="'+sc__do_memo+'" >',
                  '<div class="btn-group">'+
                  '<a class="btn btn-sm btn-warning fa fa-pencil" align="center" onclick="edit_subcon(this)" title="edit"></i></a>'+
                  '<a class="btn btn-sm btn-danger fa fa-trash" align="center" onclick="hapus_subcon(this)" title="hapus"></i></a>'+
                  '<div>'
            ]).draw( false );   
      m_seq++;
        console.log(m_seq);
      
      array_do.push(m_do_subcon);
      $('.table_resi input').val('');
      $('.table_kontrak input').val('');
      $('.m_seq').val(m_seq);
      $('.modal_tt_subcon').removeClass('disabled');
      $('.modal_tt_subcon').removeClass('disabled');
      toastr.success('Append Berhasil, Silahkan Membuat Form Tanda Terima.');
  }else{
    var par = $('.sub_seq_'+m_do_subcon).parents('tr');
    var um = $('.sc_total_um').val();
    um = um.replace(/[^0-9\-]+/g,"")/100;
    var bayar_biaya = $(par).find('.d_harga_subcon').val();
    bayar_biaya = bayar_biaya.replace(/[^0-9\-]+/g,"")/1;
    var temp = 0;

    subcon.$('.d_harga_subcon').each(function(){
      temp+=parseInt($(this).val());
    })

    temp = temp - bayar_biaya + sc_total_dt;

    if (temp < um) {
      toastr.warning('Pembayaran Uang Muka Melebihi Total');
      return false;
    }

    $(par).find('.d_resi_subcon').val(m_do_subcon);
    $(par).find('.d_harga_subcon').val(sc_total_dt);
    $(par).find('.d_jumlah_subcon').val(sc_jumlah);
    $(par).find('.d_asal_subcon').val(sc_asal_subcon);
    $(par).find('.d_tujuan_subcon').val(sc_tujuan_subcon);
    $(par).find('.d_jenis_tarif_subcon').val(sc_tarif_subcon);
    $(par).find('.d_memo_subcon').val(sc__do_memo);
    $(par).find('.d_ksd_id').val(id_subcon);
    $(par).find('.d_akun').val(sc_akun);
    $(par).find('.d_akun_text').text(sc_akun);
    $(par).find('.d_resi_subcon_text').text(m_do_subcon);
    $(par).find('.d_harga_subcon_text').text(sc_total);
    $(par).find('.d_asal_subcon_text').text(sc_asal_subcon);
    $(par).find('.d_tujuan_subcon_text').text(sc_tujuan_subcon);
    $(par).find('.d_jenis_tarif_subcon_text').text(sc_tarif_subcon);
    $(par).find('.d_memo_subcon_text').text(sc__do_memo);
      toastr.success('Update Berhasil, Silahkan Membuat Form Tanda Terima.');
      $('.table_resi input').val('');
      $('.table_kontrak input').val('');
      $('.save_subcon').addClass('disabled');
  }
  $('.head1').addClass('disabled');
  $('.subcon_td').addClass('disabled');
  hitung_subcon();
}


@foreach($data_dt as $val)
  var m_seq = $('.m_seq').val();
  var d_resi_subcon ='{{$val->pbd_resi}}'
  var d_ksd_id ='{{$val->pbd_ksd_id}}'
  var d_memo_subcon = '{{$val->pbd_keterangan}}'
  var d_akun = '{{$val->pbd_acc}}'
  var d_jumlah_subcon = '{{$val->pbd_jumlah}}'
  var d_harga_subcon_text = '{{'' . number_format($val->pbd_tarif_harga,2,",",".")}}'
  var d_harga_subcon = '{{$val->pbd_tarif_harga}}'
  $.ajax({
    url : baseUrl +'/fakturpembelian/pilih_kontrak_all',
      data: {d_resi_subcon,d_ksd_id},
      type:'get',
      dataType:'json',
      success:function(response){

        subcon.row.add([
                  m_seq+'<input type="hidden" class="seq_sub sub_seq_'+d_resi_subcon+'"  value="'+m_seq+'" >'+
                  '<input type="hidden" name="d_ksd_id[]" class="d_ksd_id"  value="'+d_ksd_id+'" >',

                  '<p class="d_resi_subcon_text">'+d_resi_subcon+'</p>'+'<input type="hidden" class="d_resi_subcon"  name="d_resi_subcon[]" value="'+d_resi_subcon+'" >',

                  '<p class="d_harga_subcon_text">'+d_harga_subcon_text+'</p>'+'<input type="hidden" name="d_harga_subcon[]" class="d_harga_subcon" value="'+Math.round(d_harga_subcon).toFixed(0)+'" >'+'<input type="hidden" name="d_jumlah_subcon[]" class="d_jumlah_subcon" value="'+d_jumlah_subcon+'" >',

                  '<p class="d_asal_subcon_text">'+response.kontrak[0].ksd_asal+'</p>'+'<input type="hidden" name="d_asal_subcon[]" class="d_asal_subcon" value="'+response.kontrak[0].ksd_asal+'" >',

                  '<p class="d_tujuan_subcon_text">'+response.kontrak[0].ksd_tujuan +'</p>'+'<input type="hidden" name="d_tujuan_subcon[]" class="d_tujuan_subcon" value="'+response.kontrak[0].ksd_tujuan+'" >',

                  '<p class="d_jenis_tarif_subcon_text">'+response.kontrak[0].ksd_jenis_tarif+'</p>'+'<input type="hidden" name="d_jenis_tarif_subcon[]" class="d_jenis_tarif_subcon" value="'+response.kontrak[0].ksd_jenis_tarif+'" >',

                  '<p class="d_akun_text">'+d_akun+'</p>'+'<input type="hidden" class="d_akun" name=d_akun[]" value="'+d_akun+'">',

                  '<p class="d_memo_subcon_text">'+d_memo_subcon+'</p>'+'<input type="hidden" class="d_memo_subcon" name=d_memo_subcon[]" value="'+d_memo_subcon+'" >',
                  '<div class="btn-group">'+
                  '<a class="btn btn-sm btn-warning fa fa-pencil" align="center" onclick="edit_subcon(this)" title="edit"></i></a>'+
                  '<a class="btn btn-sm btn-danger fa fa-trash" align="center" onclick="hapus_subcon(this)" title="hapus"></i></a>'+
                  '<div>'
            ]).draw( false );   
        m_seq++;
        console.log(m_seq);
        array_do.push(d_resi_subcon);
        $('.table_resi input').val('');
        $('.table_kontrak input').val('');
        $('.m_seq').val(m_seq);
        $('.modal_tt_subcon').removeClass('disabled');
        $('.modal_tt_subcon').removeClass('disabled');
        $('.save_subcon').addClass('disabled');
         hitung_subcon();
      }
  })

@endforeach

function hapus_subcon(o){
    var ini = $(o).parents('tr');
    var cari = $(ini).find('.dt_resi_subcon').val();
    var temp1=0;
    var cariIndex = array_do.indexOf(cari);



    var um = $('.sc_total_um').val();
    um = um.replace(/[^0-9\-]+/g,"")/100;
    var bayar_biaya = $(ini).find('.d_harga_subcon').val();
    bayar_biaya = bayar_biaya.replace(/[^0-9\-]+/g,"")/1;
    var temp = 0;

    subcon.$('.d_harga_subcon').each(function(){
      temp+=parseInt($(this).val());
    })

    temp = temp - bayar_biaya;

    if (temp < um) {
      toastr.warning('Pembayaran Uang Muka Melebihi Total');
      return false;
    }


    array_do.splice(cariIndex,1);
    
 
    subcon.row(ini).remove().draw(false);
    var temp = 0 ;
    $('.seq_sub').each(function(){
      temp+=1;
    })
    if (temp == 0) {
      $('.head1').removeClass('disabled');
    $('.subcon_td').removeClass('disabled');
    }
    $('.head1').addClass('disabled');
  $('.subcon_td').addClass('disabled');
    hitung_subcon();
}

function edit_subcon(a) {
  console.log('asd');
    var par = $(a).parents('tr');
  var d_resi_subcon = $(par).find('.d_resi_subcon').val();
  var d_ksd_id = $(par).find('.d_ksd_id').val();
  var d_memo_subcon = $(par).find('.d_memo_subcon').val();
  var d_akun = $(par).find('.d_akun').val();
  var d_jumlah_subcon = $(par).find('.d_jumlah_subcon').val();
  var d_harga_subcon_text = $(par).find('.d_harga_subcon_text').text();
  var d_harga_subcon = $(par).find('.d_harga_subcon').val();
  $.ajax({
    url : baseUrl +'/fakturpembelian/pilih_kontrak_all',
      data: {d_resi_subcon,d_ksd_id},
      type:'get',
      dataType:'json',
      success:function(response){
        console.log(response.kontrak[0].ksd_nota);
        $('.nota_subcon').val(response.kontrak[0].ksd_nota);
        $('.sc_biaya_subcon').val(response.kontrak[0].ksd_harga);
        $('.sc_biaya_subcon_dt').val(response.kontrak[0].ksd_harga2);
        $('.sc_total').val(d_harga_subcon_text);
        $('.sc_total_dt').val(d_harga_subcon);
        $('.id_subcon').val(response.kontrak[0].ksd_id);
        $('.dt_subcon').val(response.kontrak[0].ksd_dt);
        $('.sc_tarif_subcon').val(response.kontrak[0].ksd_jenis_tarif);
        $('.sc_asal_subcon').val(response.kontrak[0].ksd_asal);
        $('.sc_tujuan_subcon').val(response.kontrak[0].ksd_tujuan);
        $('.sc_kendaraan_subcon').val(response.kontrak[0].ksd_angkutan);
        $('.sc_jumlah').val(d_jumlah_subcon);
        $('.table_filter_subcon').removeClass('disabled');
        $('.sc__do_memo').val(d_memo_subcon); 
        $('.sc_akun').val(d_akun).trigger('chosen:updated');  
        $('.m_do_subcon').val(response.do.nomor);
        $('.m_do_tanggal').val(response.do.tanggal);
        $('.m_satuan').text(response.do.kode_satuan);
        $('.m_do_asal').val(response.do.nama_asal);
        $('.m_do_tujuan').val(response.do.nama_tujuan);
        $('.m_jenis_angkutan_do').val(response.do.nama_tarif);
        $('.m_tipe_kendaraan').val(response.do.nama_angkutan);
        $('.m_do_jumlah').val(response.do.jumlah);

        $('.no_do_asal').val(response.do.id_kota_asal);
        $('.no_do_tujuan').val(response.do.id_kota_tujuan);
        $('.no_tipe_kendaraan').val(response.do.kode_tipe_angkutan);

        $('.sc_no_asal_subcon').val(response.kontrak[0].no_asal);
        $('.sc_no_tujuan_subcon').val(response.kontrak[0].no_tujuan);
        $('.sc_no_kendaraan_subcon').val(response.kontrak[0].ksd_id_angkutan);
      toastr.info('Inisialisasi Berhasil');
      }
  })
}

$('.modal_tt_subcon').click(function(){
  var cabang = $('.cabang').val();
    var agen_vendor = $('.nama_sc').val();
    $.ajax({
      url:baseUrl +'/fakturpembelian/nota_tt',
      data: {cabang,agen_vendor},
      success:function(data){
        $('.div_tt').html(data);
    $('#modal_tt_subcon').modal('show');
      },error:function(){
        toastr.warning('Terjadi Kesalahan');
      }
    })
})

function select_tt(a) {
    var tt_form = $(a).find('.tt_form').text();
    var tt_invoice = $(a).find('.tt_invoice').text();
    var tt_id = $(a).find('.tt_id').val();
    var tt_dt = $(a).find('.tt_dt').val();

    $('.tanda_terima').val(tt_form);
    $('.invoice_tt').val(tt_invoice);
    $('.invoice_subcon').val(tt_invoice);
    $('.id_tt').val(tt_id);
    $('.dt_tt').val(tt_dt);
  $('#modal_tt_subcon').modal('show');
}




function save_subcon(){
  var id_subcon = $('.id_subcon').val();
  var dt_subcon = $('.dt_subcon').val();
  var invoice_subcon = $('.invoice_subcon').val();
  var tempo_subcon = $('.tempo_subcon').val();
  var nota_subcon =$('.nota_subcon').val();
  var jenis_kendaraan = $('.kode_angkutan').val();
  var tarif_subcon = $('.tarif_subcon').val();
  var selectOutlet = $('.nama_sc').val();
  var cabang = $('.cabang').val();

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
    data:subcon.$('input').serialize()
       +'&'+$('.head1 :input').serialize()
       +'&'+$('.head_subcon :input').serialize(),
    type:'GET',
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
                      dataType:'json',
                      data:$('.tabel_tt_subcon :input').serialize()+'&'+'agen='+selectOutlet+'&'+$('.head_subcon :input').serialize()+'&cabang='+cabang,
                      success:function(response){
                            toastr.info('Tanda Terima Telah Disimpan');

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
                $('.print_subcon').removeClass('disabled');
                $('.save_subcon').addClass('disabled');
                $('.modal_tt_subcon').addClass('disabled');
                $('.append_subcon').addClass('disabled');
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
    var idfaktur = $('.idfaktur').val();
     window.open('{{url('fakturpembelian/detailbiayapenerus')}}'+'/'+idfaktur);
  }


  function print_penerus_tt() {
    var idfaktur = $('.nota_no_tt').val();
    idfaktur = idfaktur.replace('/','-')
    idfaktur = idfaktur.replace('/','-')
    
     window.open('{{url('fakturpembelian/cetak_tt')}}'+'/'+idfaktur);
  }




$('.btn_modal_sc').click(function(){
  $('#modal_um_sc').modal('show');
})

function hitung_um_sc() {
  var temp = 0;
  datatable7.$('.tb_bayar_um').each(function(){
    var b = $(this).val();
    b   = b.replace(/[^0-9\-]+/g,"")/100;
    temp+=b;
  })
  $('.sc_total_um').val(accounting.formatMoney(temp, "", 2, ".",','));
}


var array_um1 = [0];
var array_um2 = [0];
$('.sc_nomor_um').focus(function(){
  var sup = $('.nama_sc').val();
  if (sup == '0') {
    toastr.warning('Agen/Vendor Harus Diisi');
    return false;
  }
var id = $('.nofaktur').val();


  $.ajax({
    url:baseUrl +'/fakturpembelian/subcon_um',
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

$('.sc_tambah_um').click(function(){
  var nota = $('.sc_nomor_um').val();
  var sup = $('.nama_sc').val();
  var nofaktur = $('.nofaktur').val();
  var sc_id_um = $('.sc_id_um').val();
  var sc_dibayar_um = $('.sc_dibayar_um').val();
  sc_dibayar_um   = sc_dibayar_um.replace(/[^0-9\-]+/g,"")/1;
  var id = $('.nofaktur').val();





  if (nota == '') {
    toastr.warning("Uang Muka Harus dipilih");
    return false;
  }
  if (sc_dibayar_um == '' || sc_dibayar_um == '0') {
    toastr.warning("Pembayaran Tidak Boleh 0");
    return false;
  }

  
  

  $.ajax({
    url:baseUrl +'/fakturpembelian/biaya_penerus/append_um',
    data: {nota,sup,id},
    dataType:'json',
    success:function(data){

      $('.sc_nomor_um').val(data.data.nomor);
      $('.sc_tanggal_um').val(data.data.um_tgl);
      $('.sc_jumlah_um').val(accounting.formatMoney(data.data.total_um, "", 2, ".",','));
      $('.sc_sisa_um').val(accounting.formatMoney(data.data.sisa_um, "", 2, ".",','));
      $('.sc_keterangan_um').val(data.data.um_keterangan);

      if (sc_dibayar_um > data.data.sisa_um) {
        toastr.warning("Pembayaran Melebihi Sisa Uang Muka");
        return false;
      }
      if (sc_id_um == '') {
        datatable7.row.add([
            '<p class="tb_faktur_um_text">'+nofaktur+'</p>'+
            '<input type="hidden" class="tb_faktur_um_'+id_um+' tb_faktur_um" value="'+id_um+'">',

            '<p class="tb_transaksi_um_text">'+data.data.nomor+'</p>'+
            '<input type="hidden" class="tb_transaksi_um" name="tb_transaksi_um[]" value="'+data.data.nomor+'">',

            '<p class="tb_tanggal_text">'+data.data.um_tgl+'</p>',

            '<p class="tb_um_um_text">'+data.data.um_nomorbukti+'</p>'+
            '<input type="hidden" class="tb_um_um" name="tb_um_um[]" value="'+data.data.um_nomorbukti+'">',

            '<p class="tb_jumlah_um_text">'+accounting.formatMoney(data.data.total_um, "", 2, ".",',')+'</p>',

            '<p class="tb_sisa_um_text">'+accounting.formatMoney(data.data.sisa_um, "", 2, ".",',')+'</p>',

            '<p class="tb_bayar_um_text">'+accounting.formatMoney(sc_dibayar_um, "", 2, ".",',')+'</p>'+
            '<input type="hidden" class="tb_bayar_um" name="tb_bayar_um[]" value="'+accounting.formatMoney(sc_dibayar_um, "", 2, "",'.')+'">',

            '<p class="tb_keterangan_um_text">'+data.data.um_keterangan+'</p>',

            '<div class="btn-group ">'+
            '<a  onclick="edit_um_sc(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
            '<a  onclick="hapus_um_sc(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
            '</div>',
          ]).draw();
        id_um++;
        array_um1.push(data.data.nomor);
        array_um2.push(data.data.um_nomorbukti);
      }else{
        var par = $('.tb_faktur_um_'+sc_id_um).parents('tr');
        $(par).find('.tb_bayar_um').val(accounting.formatMoney(sc_dibayar_um, "", 2, "",'.'));
        $(par).find('.tb_bayar_um_text').text(accounting.formatMoney(sc_dibayar_um, "", 2, ".",','));
      }
      hitung_um_sc();
      $('.sc_tabel_um :input').val('');
    },error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
  })
})


function edit_um_sc(a) {
  var par = $(a).parents('tr');
  var tb_faktur_um          = $(par).find('.tb_faktur_um').val();
  var tb_transaksi_um       = $(par).find('.tb_transaksi_um').val();
  var tb_tanggal_text       = $(par).find('.tb_tanggal_text').text();
  var tb_um_um              = $(par).find('.tb_um_um').val();
  var tb_jumlah_um_text     = $(par).find('.tb_jumlah_um_text').text();
  var tb_sisa_um_text       = $(par).find('.tb_sisa_um_text').text();
  var tb_bayar_um           = $(par).find('.tb_bayar_um').val();
  var tb_keterangan_um_text = $(par).find('.tb_keterangan_um_text').text();

  $('.sc_id_um').val(tb_faktur_um);
  $('.sc_nomor_um').val(tb_transaksi_um);
  $('.sc_tanggal_um').val(tb_tanggal_text);
  $('.sc_jumlah_um').val(tb_jumlah_um_text);
  $('.sc_sisa_um').val(tb_sisa_um_text);
  $('.sc_keterangan_um').val(tb_keterangan_um_text)
  $('.sc_dibayar_um').val(accounting.formatMoney(tb_bayar_um, "", 0, ".",','));

}

function hapus_um_sc(a) {
  var par             = $(a).parents('tr');
  var tb_transaksi_um = $(par).find('.tb_transaksi_um').val();
  var tb_um_um        = $(par).find('.tb_um_um').val();

  var index1 = array_um1.indexOf(tb_transaksi_um);
  var index2 = array_um2.indexOf(tb_um_um);

  array_um1.splice(index1,1);
  array_um2.splice(index2,1);

  datatable7.row(par).remove().draw(false);

  hitung_um_sc();
}


$('.save_sc_um').click(function(){

  var temp = 0;
  var sc_total_um = $('.sc_total_um').val();
  datatable7.$('.tb_bayar_um').each(function(){
    var b = $(this).val();
    b   = b.replace(/[^0-9\-]+/g,"")/100;
    console.log(b);
    temp+=b;
  })
  var total_jml = $('.total_subcon').val();
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
              +'&'+$('.head_subcon :input').serialize()
              +'&'+datatable7.$('input').serialize()+'&bp_total_um='+sc_total_um,
        success:function(response){
          if (response.status == 1) {
              swal({
                  title: "Berhasil!",
                  type: 'success',
                  text: "Data berhasil disimpan",
                  timer: 900,
                  showConfirmButton: true
                  },function(){
                   // $('.save_sc_um').addClass('disabled');
                   // $('.btn_modal_sc').addClass('disabled');
                   
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



var datatable7 = $('.sc_tabel_detail_um').DataTable({
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

$('.sc_dibayar_um').maskMoney({
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

  datatable7.row.add([
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
            '<a  onclick="edit_um_sc(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
            '<a  onclick="hapus_um_sc(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
            '</div>',
          ]).draw();
    id_um++;
    array_um1.push(nomor);
    array_um2.push(um_nomorbukti);
    hitung_um_sc();
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

$('.jurnal_um').click(function(){
  $('.modal_jurnal').modal('show');
  jurnal_um();
})

</script>

@endsection
