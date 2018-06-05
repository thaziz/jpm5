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
      <td style="width: 100px">Tanggal Faktur</td>
      <td width="10">:</td>
      <td width="200">
        <input type="text" name="tgl_biaya_head" class="form-control tgl-biaya" value="{{$date}}" readonly="" style="">
        <input type="hidden" class="form-control tgl_resi"  readonly="" style="">
        <input type="hidden" name="master_persen" class="form-control master_persen"  readonly="" style="">
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
      <button type="button" class="btn btn-warning pull-left print-penerus" id="print-penerus" onclick="print_penerus_tt()" style="margin-right: 20px"><i class="fa fa-print"></i> Print Tanda Terima</button>
        <button class="btn btn-primary btn_modal_ot " type="button" > Bayar dengan Uang Muka </button>
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
                  <input value="{{$valid_cetak->tt_noform or $nota}}" type='text' name="nota_tt" class='input-sm form-control notandaterima'>
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



{{-- modal uang muka outlet --}}

<div id="modal_um_ot" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document" style="width: 1200px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pembayaran Uang Muka</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-sm-8">
              <table class="table ot_tabel_um">
              <tr>
                <td>No Transaksi Kas / Bank</td>
                <td colspan="2">
                  <input placeholder="klik disini" type="text" name="ot_nomor_um" class=" form-control ot_nomor_um">
                  <input type="hidden" name="ot_id_um" class=" form-control ot_id_um">
                </td>
              </tr>
              <tr>
                <td>Tanggal</td>
                <td colspan="2">
                  <input type="text" name="ot_tanggal_um" class=" form-control ot_tanggal_um">
                </td>
              </tr>
              <tr>
                <td>Jumlah</td>
                <td colspan="2">
                  <input readonly="" type="text" name="ot_jumlah_um" class=" form-control ot_jumlah_um">
                </td>
              </tr>
              <tr>
                <td>Sisa Uang Muka</td>
                <td colspan="2">
                  <input readonly="" type="text" name="ot_sisa_um" class=" form-control ot_sisa_um">
                </td>
              </tr>
              <tr>
                <td>Keterangan</td>
                <td colspan="2">
                  <input readonly="" type="text" name="ot_keterangan_um" class=" form-control ot_keterangan_um">
                </td>
              </tr>
              <tr>
                <td>Dibayar</td>
                <td>
                  <input type="text" name="ot_dibayar_um" class=" form-control ot_dibayar_um">
                </td>
                <td align="right">
            
                    <button class="btn btn-primary ot_tambah_um" type="button" ><i class="fa fa-plus"> Tambah</i></button> 
     
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
                  <input readonly="" type="text" name="ot_total_um" class="ot_total_um form-control ">
                </td>
              </tr>
            </table>
            </div>

              <div class="col-sm-12">
               <table class="table table-bordered ot_tabel_detail_um" style="font-size: 12px">
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
        <button type="hidden" class="btn btn-primary save_ot_um" >Save changes</button>
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

  $('.tgl-biaya').datepicker({
    format:'dd/mm/yyyy'
  })
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





function hitung_um_ot() {
  var temp = 0;
  datatable5.$('.tb_bayar_um').each(function(){
    var b = $(this).val();
    b   = b.replace(/[^0-9\-]+/g,"")/100;
    console.log(b);
    temp+=b;
  })
  $('.ot_total_um').val(accounting.formatMoney(temp, "", 2, ".",','));

}
  



$('.btn_modal_ot').click(function(){
  $('#modal_um_ot').modal('show');
})


var array_um1 = [0];
var array_um2 = [0];
$('.ot_nomor_um').focus(function(){
  var sup = $('.selectOutlet').val();
  var id  = $('.nofaktur').val();
  if (sup == '0') {
    toastr.warning('Agen/Vendor Harus Diisi');
    return false;
  }

  $.ajax({
    url:baseUrl +'/fakturpembelian/outlet_um',
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

$('.ot_tambah_um').click(function(){
  var nota = $('.ot_nomor_um').val();
  var sup = $('.selectOutlet').val();
  var nofaktur = $('.nofaktur').val();
  var ot_id_um = $('.ot_id_um').val();
  var ot_dibayar_um = $('.ot_dibayar_um').val();
  ot_dibayar_um   = ot_dibayar_um.replace(/[^0-9\-]+/g,"")/1;
  var id  = $('.nofaktur').val();





  if (nota == '') {
    toastr.warning("Uang Muka Harus dipilih");
    return false;
  }
  if (ot_dibayar_um == '' || ot_dibayar_um == '0') {
    toastr.warning("Pembayaran Tidak Boleh 0");
    return false;
  }

  
  

  $.ajax({
    url:baseUrl +'/fakturpembelian/biaya_penerus/append_um',
    data: {nota,sup,id},
    dataType:'json',
    success:function(data){

      $('.ot_nomor_um').val(data.data.nomor);
      $('.ot_tanggal_um').val(data.data.um_tgl);
      $('.ot_jumlah_um').val(accounting.formatMoney(data.data.total_um, "", 2, ".",','));
      $('.ot_sisa_um').val(accounting.formatMoney(data.data.sisa_um, "", 2, ".",','));
      $('.ot_keterangan_um').val(data.data.um_keterangan);

      if (ot_dibayar_um > data.data.sisa_um) {
        toastr.warning("Pembayaran Melebihi Sisa Uang Muka");
        return false;
      }
      if (ot_id_um == '') {
        datatable5.row.add([
            '<p class="tb_faktur_um_text">'+nofaktur+'</p>'+
            '<input type="hidden" class="tb_faktur_um_'+id_um+' tb_faktur_um" value="'+id_um+'">',

            '<p class="tb_transaksi_um_text">'+data.data.nomor+'</p>'+
            '<input type="hidden" class="tb_transaksi_um" name="tb_transaksi_um[]" value="'+data.data.nomor+'">',

            '<p class="tb_tanggal_text">'+data.data.um_tgl+'</p>',

            '<p class="tb_um_um_text">'+data.data.um_nomorbukti+'</p>'+
            '<input type="hidden" class="tb_um_um" name="tb_um_um[]" value="'+data.data.um_nomorbukti+'">',

            '<p class="tb_jumlah_um_text">'+accounting.formatMoney(data.data.total_um, "", 2, ".",',')+'</p>',

            '<p class="tb_sisa_um_text">'+accounting.formatMoney(data.data.sisa_um, "", 2, ".",',')+'</p>',

            '<p class="tb_bayar_um_text">'+accounting.formatMoney(ot_dibayar_um, "", 2, ".",',')+'</p>'+
            '<input type="hidden" class="tb_bayar_um" name="tb_bayar_um[]" value="'+ot_dibayar_um+'">',

            '<p class="tb_keterangan_um_text">'+data.data.um_keterangan+'</p>',

            '<div class="btn-group ">'+
            '<a  onclick="edit_um_ot(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
            '<a  onclick="hapus_um_ot(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
            '</div>',
          ]).draw();
        id_um++;
        array_um1.push(data.data.nomor);
        array_um2.push(data.data.um_nomorbukti);
      }else{
        var par = $('.tb_faktur_um_'+ot_id_um).parents('tr');
        $(par).find('.tb_bayar_um').val(accounting.formatMoney(ot_dibayar_um, "", 2, "",'.'));
        $(par).find('.tb_bayar_um_text').text(accounting.formatMoney(ot_dibayar_um, "", 2, ".",','));
      }
      hitung_um_ot();
      $('.ot_tabel_um :input').val('');
    },error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
  })
})


function edit_um_ot(a) {
  var par = $(a).parents('tr');
  var tb_faktur_um          = $(par).find('.tb_faktur_um').val();
  var tb_transaksi_um       = $(par).find('.tb_transaksi_um').val();
  var tb_tanggal_text       = $(par).find('.tb_tanggal_text').text();
  var tb_um_um              = $(par).find('.tb_um_um').val();
  var tb_jumlah_um_text     = $(par).find('.tb_jumlah_um_text').text();
  var tb_sisa_um_text       = $(par).find('.tb_sisa_um_text').text();
  var tb_bayar_um           = $(par).find('.tb_bayar_um').val();
  var tb_keterangan_um_text = $(par).find('.tb_keterangan_um_text').text();

  $('.ot_id_um').val(tb_faktur_um);
  $('.ot_nomor_um').val(tb_transaksi_um);
  $('.ot_tanggal_um').val(tb_tanggal_text);
  $('.ot_jumlah_um').val(tb_jumlah_um_text);
  $('.ot_sisa_um').val(tb_sisa_um_text);
  $('.ot_keterangan_um').val(tb_keterangan_um_text)
  $('.ot_dibayar_um').val(accounting.formatMoney(tb_bayar_um, "", 0, ".",','));

}

function hapus_um_ot(a) {
  var par             = $(a).parents('tr');
  var tb_transaksi_um = $(par).find('.tb_transaksi_um').val();
  var tb_um_um        = $(par).find('.tb_um_um').val();

  var index1 = array_um1.indexOf(tb_transaksi_um);
  var index2 = array_um2.indexOf(tb_um_um);

  array_um1.splice(index1,1);
  array_um2.splice(index2,1);

  datatable5.row(par).remove().draw(false);

  hitung_um_ot();
}


$('.save_ot_um').click(function(){

  var temp = 0;
  var ot_total_um = $('.ot_total_um').val();
  datatable5.$('.tb_bayar_um').each(function(){
    var b = $(this).val();
    b   = b.replace(/[^0-9\-]+/g,"")/100;
    console.log(b);
    temp+=b;
  })
  var total_jml = $('.total_all_komisi').val();
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
              +'&'+$('.head_outlet :input').serialize()
              +'&'+datatable5.$('input').serialize()+'&bp_total_um='+ot_total_um+'&flag=outlet',
        success:function(response){
          if (response.status == 1) {
              swal({
                  title: "Berhasil!",
                  type: 'success',
                  text: "Data berhasil disimpan",
                  timer: 900,
                  showConfirmButton: true
                  },function(){
                   $('.save_ot_um').addClass('disabled');
                   $('.btn_modal_ot').addClass('disabled');
                   
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


var datatable5 = $('.ot_tabel_detail_um').DataTable({
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
$('.ot_dibayar_um').maskMoney({
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

  datatable5.row.add([
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
            '<input type="hidden" class="tb_bayar_um" name="tb_bayar_um[]" value="'+accounting.formatMoney(bp_dibayar_um, "", 2, "",'.')+'">',

            '<p class="tb_keterangan_um_text">'+um_keterangan+'</p>',

            '<div class="btn-group ">'+
            '<a  onclick="edit_um_ot(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
            '<a  onclick="hapus_um_ot(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
            '</div>',
          ]).draw();
    id_um++;
    array_um1.push(nomor);
    array_um2.push(um_nomorbukti);
    hitung_um_ot();
    $('.bp_tabel_um :input').val('');
@endforeach

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
