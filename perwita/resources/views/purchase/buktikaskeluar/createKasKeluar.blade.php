@extends('main')

@section('title', 'dashboard')

@section('content')
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
 
  .search{
    margin-left: 5px;
  }
  h3{
    margin: 20px 5px;

  }
  .my-bg{
    background: #f0b7d6;
  }

  .tinggi{
    height: 500px;
  }
  .chosen-container-single{
    width: 74%;
  }
  #DataTables_Table_0_info{
    display: none;
  }
  #DataTables_Table_1_info{
    display: none;
  }
  #DataTables_Table_2_info{
    display: none;
  }
  #DataTables_Table_3_info{
    display: none;
  }
  #DataTables_Table_4_info{
    display: none;
  }
  #DataTables_Table_5_info{
    display: none;
  }
  #DataTables_Table_6_info{
    display: none;
  }
</style>
<!-- <link href="{{ asset('assets/vendors/chosen/chosen.css')}}" rel="stylesheet"> -->
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
      <h2> Transaksi Kas </h2>
      <ol class="breadcrumb">
          <li>
              <a>Home</a>
          </li>
          <li>
              <a>Purchase</a>
          </li>
          <li>
            <a> BUkti Kas Keluar</a>
          </li>
          <li class="active">
              <strong> Tambah Data</strong>
          </li>
      </ol>
  </div>
 </div>
<div hidden="" class="alert-class alert-info row wrapper border-bottom my-bg page-heading " style="margin-top: 10px; padding: 0 0;">
<h3 class="pending" style="padding: 10px 0 margin:0px 0px !important;"></h3>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <!-- HEADER -->
    <div class="ibox">&nbsp;
      <div class="ibox-title head1">
        <h5>Bukti Kas Keluar</h5>
        <a href="../buktikaskeluar/index" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
      </div>
      <div class="ibox-content col-sm-12 box_head">
        <div class="col-sm-6">
          <table class="table table_header table-bordered table-striped">
            {{ csrf_field() }}
            <tr>
              <td>No Transaksi</td>
              <td>
                <input readonly="" value="{{$bkk}}" class="form-control" type="text" name="no_trans">
                <input  class="form-control id_bkk" type="hidden" >
              </td>
            </tr>
            <tr>
              <td>Tanggal</td>
              <td><input readonly="" class="form-control" value="{{$now}}" type="text" name="tanggal"></td>
            </tr>
            <tr>
              <td>Jenis Bayar</td>
              <td>
                  <input readonly="" value="8" class="form-control kode_bayar" style="width: 20%; display: inline-block;" value="" type="text" name="kode_bayar">     
                  <select onchange="jenis_bayar()"  class="jenis_bayar  form-control" style="width: 79%; display: inline-block;">
                    <option>- Pilih Jenis Bayar -</option>
                    @foreach($jenisbayar as $val)
                    @if($val->idjenisbayar == 8)
                    <option selected="" value="{{$val->idjenisbayar}}">{{$val->jenisbayar}}</option>
                    @else
                    <option value="{{$val->idjenisbayar}}">{{$val->jenisbayar}}</option>
                    @endif
                    @endforeach
                  </select>                  
              </td>
            </tr>
            <tr class="supp_head">
              <td>Supplier</td>
              <td class="">
                  <div class="untuk_faktur supplier_drop" hidden="">
                  </div> 
                  <div class="untuk_patty" >
                    <input readonly="" class="form-control kode_patty"  style="width: 30%; display: inline-block;" name="kode_supplier" value="cash" type="text" name="nama_supplier"> 
                    <input  class="form-control nama_orang" onblur="jenis_bayar()" style="width: 69%; display: inline-block;" value="" type="text" name="nama_orang"> 
                  </div>                        
              </td>
            </tr>
            <tr>
              <td>Keterangan</td>
              <td>
                  <input  class="form-control keterangan" style="width: 100%; display: inline-block;" value="" type="text" name="keterangan">                        
              </td>
            </tr>
          </table>
        </div>
        <div class="col-sm-6">
          <!-- tabel jurnal patty -->
          <table class="table table-striped table-bordered table_jurnal">
            <tr>
              <td colspan="2" align="center">POSTING/JURNAL</td>
            </tr>
            <tr>
              <td>HUTANG</td>
              <td>
                <div class="input-group">
                  <span class="input-group-addon" style="padding-bottom: 12px;">(D)</span>
                  <input readonly="" style="width: 100%" class="form-control hutang" type="text" readonly="" value="" name="hutang">
                </div>
              </td>
            </tr>
            <tr>
              <td>KAS</td>
              <td>
                <div class="input-group">
                  <span class="input-group-addon" style="padding-bottom: 12px;">(K)</span>
                  <select name="nama_akun" class="form-control nama_akun chosen-select-width1" onchange="jenis_bayar()" style="width: 100% !important;">
                        <option value="0">- Pilih-Akun -</option>
                        @foreach($akun_kas as $val)
                        @if($val->id_akun == 100111001)
                        <option selected="" value="{{$val->id_akun}}">{{$val->id_akun}} - {{$val->nama_akun}}</option>
                        @else
                        <option value="{{$val->id_akun}}">{{$val->id_akun}} - {{$val->nama_akun}}</option>
                        @endif
                        @endforeach
                  </select> 
                </div>
              </td>
            </tr>
            <tr>
              <td>UANG MUKA</td>
              <td>
                <div class="input-group">
                  <span class="input-group-addon" style="padding-bottom: 12px;">(K)</span>
                  <input readonly="" style="width: 100%" class="form-control kas" type="text" readonly="" value="" name="kas">
                </div>
              </td>
            </tr>
          </table>
  
          <table class="table table-bordered total_pembayaran_table">
            <tr>
              <td colspan="2" align="center">Total Pembayaran</td>
            </tr>
            <tr>
              <td colspan="2">     
                  <input readonly=""  style="width: 100%;text-align: right;" class="form-control total_pembayaran" type="text"  value="" name="total_pembayaran">
              </td>
            </tr>         
          </table>
        </div>
      </div>
    </div>  
    <!-- body Patty Cash-->
<div class="ibox patty_cash" hidden=""  style="padding-top: 10px;">
      <div class="ibox-title">
        <h5>Form  Patty Cash</h5>
      </div>
  <div class="ibox-content col-sm-12 ">
   <div class="col-sm-6 " >
    <form class="form kepunyaan_patty">
     <table class="table">
     <div align="center" style="width: 100%;">  
    <h3 >Patty Cash</h3>
   </div> 
    <tr>
    <td style="width: 100px">Nomor</td>
    <td width="10">:</td>
    <td ><input type="text" name="jml_data" class="form-control no_patty"  readonly=""></td>
    </tr>
    <tr>
    <td style="width: 100px">Account Biaya</td>
    <td width="10">:</td>
    <td class="form-inline">
      <input type="text" name="kode_akun" class="form-control kode_akun" style="width: 25%;" readonly="">
      <select class="form-control nama_akun_biaya chosen-select-width5" style="width: 74% !important;">
            <option value="0">- Pilih-Akun -</option>
            @foreach($akun as $val)
            <option value="{{$val->id_akun}}">{{$val->id_akun}} - {{$val->nama_akun}}</option>
            @endforeach
      </select> 
    </td>
    </tr>
     <tr>
    <td style="width: 100px">Debet/Kredit</td>
    <td width="10">:</td>
    <td>
      <select name="debit" class="form-control debit_patty" style="text-align: center;">
        <option value="debit" selected="">DEBIT</option>
        <option value="kredit">KREDIT</option>
      </select>
    </td>
    </tr>
    <tr>
    <td style="width: 100px">Keterangan</td>
    <td width="10">:</td>
    <td ><input type="text" name="ket-biaya" class="form-control keterangan_pattycash"></td>
   </tr>
    <tr>
    <td style="width: 100px">Nominal</td>
    <td width="10">:</td>
    <td >
      <input type="number" name="nominal" class="form-control nominal_patty">
    </td>
    </tr>
     </table>

    </form>
    <button style="margin-left: 5px;" type="button" class="btn btn-info pull-right reload" onclick="reload()" ><i class="fa fa-refresh">&nbsp;Reload</i></button>
     <button style="margin-left: 5px;" type="button" class="btn btn-warning pull-right print_patty disabled"  onclick="printing()"><i class="fa fa-print">&nbsp;print</i></button>
      <button style="margin-left: 5px;" type="button" class="btn btn-primary pull-right" id="save_patty" onclick="save_pat()"><i class="fa fa-save">&nbsp;Simpan Data</i></button>
      <button style="margin-left: 5px;" type="button" class="btn btn-danger pull-right cari-pod" ><i class="fa fa-plus">&nbsp;Append</i></button>
  </div>

</div>
 <div class=" ibox-content col-sm-12 tb_sb_hidden" >
  <h3>Tabel Detail Patty Cash</h3>
  <hr>
      <table class="table table-bordered table-hover tabel_patty_cash">
      <thead align="center">
        <tr>
        <th>No</th>
        <th width="90">Keterangan</th>
        <th>Acc Biaya</th>
        <th>Jumlah bayar</th>
        <th>Debet/Kredit</th>
        <th width="50">Aksi</th>
        </tr>
      </thead> 
      <tbody align="center" class="">

      </tbody>    
      </table>
      
  </div>
</div>
<!-- End Body Patty Cash -->
<!-- FORM BODY UANG MUKA -->
<div class="ibox uang_muka" hidden=""  style="padding-top: 10px;">
      <div class="ibox-title">
        <h5>Form Uang Muka</h5>
      </div>
  <div class="ibox-content col-sm-12 ">
   <div class="col-sm-6 " >
    <form class="form kepunyaan_um">
     <table class="table">
     <div align="center" style="width: 100%;">  
    <h3 >Detail Uang Muka</h3>
   </div> 
    <tr>
    <td style="width: 100px">Nomor</td>
    <td width="10">:</td>
    <td >
      <input type="text" name="jml_data" class="form-control seq_um" value="1"  readonly="">
      <input type="hidden" class="form-control id_um"  readonly="">
    </td>
    </tr>
     <tr>
    <td style="width: 100px">Supplier</td>
    <td width="10">:</td>
    <td>
      <select onchange="clear_um()" class="form-control supplier_um chosen-select-width1">
        @foreach($supplier as $val)
        <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
        @endforeach
      </select>
    </td>
    </tr>
    <tr>
    <td style="width: 100px">No. Uang Muka</td>
    <td width="10">:</td>
    <td class="form-inline">
      <input type="text" name="kode_akun" class="form-control no_um" style="width: 81%;" readonly="">
      <button type="button" onclick="cari_um()" class="btn btn-primary"><i class="fa fa-search"> Cari</i></button>
      
    </td>
    </tr>
    <tr>
    <td style="width: 100px">Keterangan</td>
    <td width="10">:</td>
    <td ><input type="text" name="ket-biaya" class="form-control ket_um"></td>
   </tr>
   <tr>
    <td style="width: 100px">Total Uang Muka</td>
    <td width="10">:</td>
    <td >
      <input type="text" readonly="" name="total_um" class="form-control total_um">
    </td>
    </tr>
    <tr>
    <td style="width: 100px">Sisa Pembayaran</td>
    <td width="10">:</td>
    <td >
      <input type="text" readonly="" name="sisa_um_det" class="form-control sisa_um_det">
    </td>
    </tr>
    <tr>
    <td style="width: 100px">Nominal</td>
    <td width="10">:</td>
    <td >
      <input type="text" name="nominal" class="form-control nominal_um">
    </td>
    </tr>
     </table>

    </form>
    <button style="margin-left: 5px;" type="button" class="btn btn-info pull-right reload" onclick="reload()" ><i class="fa fa-refresh">&nbsp;Reload</i></button>
     <button style="margin-left: 5px;" type="button" class="btn btn-warning pull-right print_um disabled"  onclick="printing()"><i class="fa fa-print">&nbsp;print</i></button>
      <button style="margin-left: 5px;" type="button" class="btn btn-primary pull-right" id="save_um" onclick="save_um()"><i class="fa fa-save">&nbsp;Simpan Data</i></button>
      <button style="margin-left: 5px;" type="button" class="btn btn-danger pull-right cari_um" ><i class="fa fa-plus">&nbsp;Append</i></button>
  </div>

</div>
 <div class=" ibox-content col-sm-12 tb_sb_hidden" >
  <h3>Tabel Detail Uang Muka</h3>
  <hr>
      <table class="table table-bordered table-hover tabel_um">
      <thead align="center">
        <tr>
        <th width="50">No</th>
        <th>No Bukti</th>
        <th>Supplier</th>
        <th>Keterangan</th>
        <th width="150">Total Um</th>
        <th width="150">Jumlah Bayar</th>
        <th width="50">Aksi</th>
        </tr>
      </thead> 
      <tbody align="center" class="">

      </tbody>    
      </table>
      
  </div>
</div>
<!-- END UANG MUKA -->
<!-- FORM FAKTUR -->
<div class="ibox faktur" hidden=""  style="padding-top: 10px;">
      <div class="ibox-title">
        <h5>Detail Pembayaran</h5>
      </div>
  <div class="ibox-content col-sm-12 kiri">
  <div class="col-sm-8 " >
    <table class="table" style="margin-bottom: 20px;">
      <tr>
        <td width="170">
          Per Tanggal :
        </td>
        <td>
          <input type="text" value="{{$start}} - {{$second}}" class="range form-control" style="width: 300px; display: inline-block;" name="range">
        </td>
        <td width="200">
          <button class="btn btn-primary " onclick="cari_faktur()" ><i class="fa fa-search"> Cari Faktur</i></button>
        </td>
      </tr>
    </table>
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#Pembayaran" aria-controls="Pembayaran" role="tab" data-toggle="tab">Pembayaran</a></li>
      <li role="presentation"><a href="#Retur" aria-controls="Retur" role="tab" data-toggle="tab">Retur Beli</a></li>
      <li role="presentation"><a href="#Credit" aria-controls="Credit" role="tab" data-toggle="tab">Credit Nota</a></li>
      <li role="presentation"><a href="#Debit" aria-controls="Debit" role="tab" data-toggle="tab">Debit Nota</a></li>
    </ul>
      <!-- Tab panes -->
  <div style="background: #fff; border:  1px solid #ddd; border-top: 1px solid white;">
<div class="tab-content">
    <div role="tabpanel"  class="tab-pane fade in active" id="Pembayaran">
     
        <table style="width: 95%; margin: auto;" class="table table-bordered table-hover table-striped pembayaran_faktur">
          <thead>
            <th>No Trans</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>No Faktur</th>
          </thead>
          <tbody>
            
          </tbody>
        </table>
     
    </div>
    <div role="tabpanel" class="tab-pane fade" id="Retur">
        <table style="width: 95%; margin: auto;" class="table table-bordered table-hover table-striped ">
          <thead>
            <th>No Trans</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>No Faktur</th>
          </thead>
          <tbody>
            
          </tbody>
        </table>
    </div>
    <div role="tabpanel" class="tab-pane fade " id="Credit">
      <table style="width: 95%; margin: auto;" class="table table-bordered table-hover table-striped ">
          <thead>
            <th>No Trans</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>No Faktur</th>
          </thead>
          <tbody>
            
          </tbody>
        </table>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="Debit">
      <table style="width: 95%; margin: auto;" class="table table-bordered table-hover table-striped ">
          <thead>
            <th>No Trans</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>No Faktur</th>
          </thead>
          <tbody>
            
          </tbody>
        </table>

    </div>
</div>
</div>
  </div>
  <!-- KANAN -->
  <div class="col-sm-4 kanan" >
    <form class="form" style="border:1px solid #888">
     <table class="table">
     <div align="center" style="width: 100%;">  
   </div> 
    <tr>
    <td style="width: 100px">Total Biaya Faktur</td>
    <td width="10">:</td>
    <td >
      <input readonly="" type="text" class="form-control total_faktur"  >
      <input readonly="" type="hidden" class="form-control faktur_ini"  >
    </td>
    </tr>
    <tr>
    <td style="width: 100px">Pembayaran</td>
    <td width="10">:</td>
    <td>
      <input type="text" readonly="" name="bayar_faktur" class="form-control bayar_faktur" >
    </td>
    </tr>
     <tr>
      <td style="width: 100px">Retur Beli</td>
      <td width="10">:</td>
      <td>
        <input type="text" readonly="" name="retur_faktur" class="form-control retur_faktur" >
      </td>
    </tr>
    <tr>
      <td style="width: 100px">Credit Nota</td>
      <td width="10">:</td>
      <td ><input type="text" readonly="" name="Credit_faktur" class="form-control Credit_faktur"></td>
   </tr>
    <tr>
      <td style="width: 100px">Debet Nota</td>
      <td width="10">:</td>
      <td >
        <input type="text" readonly="" name="debit_faktur" class="form-control debit_faktur">
      </td>
    </tr>
    <tr>
      <td style="width: 100px">Sisa Terbayar</td>
      <td width="10">:</td>
      <td >
        <input type="text" readonly="" name="sisa_bayar_faktur" class="form-control sisa_bayar_faktur">
      </td>
    </tr>
    <tr>
      <td style="width: 100px">Pelunasan</td>
      <td width="10">:</td>
      <td >
        <input type="text" name="lunas"  class="form-control lunas">
      </td>
    </tr>
    <tr>
      <td style="width: 100px">Sisa Faktur</td>
      <td width="10">:</td>
      <td >
        <input type="text" readonly="" name="sisa_faktur" class="form-control sisa_faktur">
      </td>
    </tr>
     </table>
    </form>
  </div>
</div>
 <div class=" ibox-content col-sm-12 tb_sb_hidden" >
  <h3 >Tabel Detail Faktur</h3>
  <hr>
  <button style="margin-left: 5px;" type="button" class="btn btn-info pull-right reload" onclick="reload()" ><i class="fa fa-refresh">&nbsp;Reload</i></button>
     <button style="margin-left: 5px;" type="button" class="btn btn-warning pull-right print_faktur disabled"  onclick="printing()"><i class="fa fa-print">&nbsp;print</i></button>
       <button type="button" class="btn btn-primary pull-right save_faktur disabled"  id="save_faktur" onclick="save_faktur()" data-dismiss="modal">
         <i class="fa fa-save">&nbsp;Simpan Data</i>
       </button>
      <table class="table table-bordered table-hover tabel_faktur">
      <thead align="center">
        <tr>
        <th width="30">No</th>
        <th >No Faktur</th>
        <th>Tanggal</th>
        <th>Acc</th>
        <th>Total Faktur</th>
        <th>Pelunasan</th>
        <th>Keterangan</th>
        <th>Aksi</th>
        </tr>
      </thead> 
      <tbody align="center" class="">

      </tbody>    
      </table>
      
  </div>
</div>
<!-- END FORM FAKTUR -->

    <!-- tabel data resi -->
  </div>
</div> 
<!-- MODAL APPEND FAKTUR -->


<div id="modal_faktur" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div id="subcon_modal" class="modal-content">
      <div class="modal-header">
        <button style="min-height:0;" type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Kontrak Subcon</h4>
      </div>
        <div class="modal-body faktur_modal">
          
      </div>     
      <div class="modal-footer">
        <div class="pull-right">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="appended()" data-dismiss="modal">append</button>
        </div>
      </div> 
    </div>
      
  </div>
</div>
<!-- MODAL UANG MUKA -->
<div id="modal_um" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 80%">

    <!-- Modal content-->
    <div id="subcon_modal" class="modal-content">
      <div class="modal-header">
        <button style="min-height:0;" type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Kontrak Subcon</h4>
      </div>
        <div class="modal-body um_modal">
          
      </div>     
      <div class="modal-footer">
        <div class="pull-right">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="appended()" data-dismiss="modal">append</button>
        </div>
      </div> 
    </div>
      
  </div>
</div>
<!-- MODAL EDIT PATTY -->
<div id="modal_patty" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div id="subcon_modal" class="modal-content">
      <div class="modal-header">
        <button style="min-height:0;" type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Kontrak Subcon</h4>
      </div>
        <div class="modal-body subcon_modal">
            <table class="table">
    <tr>
    <td style="width: 100px ;padding-left: 65px;">Account Biaya</td>
    <td width="10">:</td>
    <td width="200" class="form-inline">
      <input type="text" name="kode_akun" class="form-control kode_akun_patty_update" style="width: 70px;" value="0" readonly="">
       <select class="form-control nama_akun_patty_update chosen-select-width" style="width: 74% !important;">
            <option value="0">- Pilih-Akun -</option>
            @foreach($akun as $val)
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
    <td style="width: 100px ;padding-left: 65px;">Keterangan</td>
    <td width="10">:</td>
    <td width="200">
      <input type="text"  class="form-control ket_patty_update" style="width: 250px;">
      <input type="hidden"  class="form-control patt_sequence" style="width: 250px;">
   </td>
   </tr>
    <tr>
    <td style="width: 100px ;padding-left: 65px;">Nominal</td>
    <td width="10">:</td>
    <td width="200"><input type="number" name="nominal" class="form-control nominal_patty_update"  style="width: 250px;"></td>
    </tr>
     </table>
        <div class="pull-right">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-update" onclick="sve()" data-dismiss="modal">Update</button>
      </div>
      </div>      
    </div>
      
  </div>
</div>
<!-- end modal patty -->
@endsection



@section('extra_scripts')


<script type="text/javascript">
// patty cash
var id=[];
var patty_array = [];
var total_pembayaran = [];
$('.box_head').addClass('tinggi');
$('.range').daterangepicker({
          autoclose: true,
          "opens": "right",
          locale: {
          format: 'DD/MM/YYYY'
      }         
});


function validasi_simpan(){
  var length_patty = patty.column( 0 ).data().length;
  if (length_patty == 0) {
    $('#save_patty').addClass('disabled');
  }else{
    $('#save_patty').removeClass('disabled');
  }
}
function seq_patty(){
  $('.no_patty').val(patty_array.length+1);
}
seq_patty();
var patty  = $('.tabel_patty_cash').DataTable({
                  'searching' :false
              })

function validasi(){
  var val2 = $('.kode_supplier').val();
  var val = $('.jenis_bayar').val();
  var val3 = $('.nama_orang').val();
 


}

function jenis_bayar(){
  tabel_faktur.clear().draw();
  $('.total_pembayaran').val('');
  id.splice(0,id.length);
  var val = $('.jenis_bayar').val();
  var val2 = $('.nama_akun').val();
  var val3 = $('.nama_orang').val();
$('.kode_supplier').val('- kode -');
  // $('.nama_orang').val('');
  $('.kode_bayar').val(val);
  validasi_simpan();
  if (val == 8 && val3 != '0') {
    $('.nama_supplier').addClass('disabled');
    $('.kode_supplier').addClass('disabled');
    $('.supp_head').attr('hidden',true);
    $('.patty_cash').attr('hidden',false);
    $('.supp_head').attr('hidden',false);
    $('.uang_muka').attr('hidden',true);
    $('.faktur').attr('hidden',true);
    $('.untuk_patty').attr('hidden',false);
    $('.untuk_faktur').attr('hidden',true);
    $('.box_head').removeClass('tinggi');
    
    console.log('asdvvv');

  }

  if (val == 2 && val2 != '0') {
    $('.nama_supplier').removeClass('disabled');
    $('.kode_supplier').removeClass('disabled');
    $('.patty_cash').attr('hidden',true);
    $('.supp_head').attr('hidden',false);
    $('.uang_muka').attr('hidden',true);
    $('.faktur').attr('hidden',false);
    $('.untuk_patty').attr('hidden',true);
    $('.supp_head').attr('hidden',false);
    $('.untuk_faktur').attr('hidden',false);
    $('.box_head').removeClass('tinggi');

    $.ajax({
      url:baseUrl +'/buktikaskeluar/supp_drop',
      data:'id='+val,
      success:function(data){
        $('.supplier_drop').html(data);
      }
    })
  }

  if (val == 3 && val2 != '0') {
    $('.nama_supplier').removeClass('disabled');
    $('.kode_supplier').removeClass('disabled');
    $('.supp_head').attr('hidden',false);
    $('.patty_cash').attr('hidden',true);
    $('.uang_muka').attr('hidden',true);
    $('.faktur').attr('hidden',false);
    $('.untuk_patty').attr('hidden',true);
    $('.supp_head').attr('hidden',false);
    $('.untuk_faktur').attr('hidden',false);
    $('.box_head').removeClass('tinggi');

    $.ajax({
      url:baseUrl +'/buktikaskeluar/supp_drop',
      data:'id='+val,
      success:function(data){
        $('.supplier_drop').html(data);
      }
    })
  }

  if (val == 6 && val2 != '0') {
    $('.nama_supplier').removeClass('disabled');
    $('.kode_supplier').removeClass('disabled');
    $('.patty_cash').attr('hidden',true);
    $('.supp_head').attr('hidden',false);
    $('.faktur').attr('hidden',false);
    $('.supp_head').attr('hidden',false);
    $('.uang_muka').attr('hidden',true);
    $('.box_head').removeClass('tinggi');
    $('.untuk_patty').attr('hidden',true);
    $('.untuk_faktur').attr('hidden',false);

    $.ajax({
      url:baseUrl +'/buktikaskeluar/supp_drop',
      data:'id='+val,
      success:function(data){
        $('.supplier_drop').html(data);
      }
    })
  }

  if (val == 7 && val2 != '0') {
    $('.nama_supplier').removeClass('disabled');
    $('.kode_supplier').removeClass('disabled');
    $('.patty_cash').attr('hidden',true);
    $('.uang_muka').attr('hidden',true);
    $('.supp_head').attr('hidden',false);
    $('.faktur').attr('hidden',false);
    $('.box_head').removeClass('tinggi');
    $('.untuk_patty').attr('hidden',true);
    $('.untuk_faktur').attr('hidden',false);

    $.ajax({
      url:baseUrl +'/buktikaskeluar/supp_drop',
      data:'id='+val,
      success:function(data){
        $('.supplier_drop').html(data);
      }
    })
  }

  if (val == 9 && val2 != '0') {
    $('.nama_supplier').removeClass('disabled');
    $('.kode_supplier').removeClass('disabled');
    $('.patty_cash').attr('hidden',true);
    $('.supp_head').attr('hidden',false);
    $('.uang_muka').attr('hidden',true);
    $('.faktur').attr('hidden',false);
    $('.box_head').removeClass('tinggi');
    $('.supp_head').attr('hidden',false);
    $('.untuk_patty').attr('hidden',true);
    $('.untuk_faktur').attr('hidden',false);
    $.ajax({
      url:baseUrl +'/buktikaskeluar/supp_drop',
      data:'id='+val,
      success:function(data){
        $('.supplier_drop').html(data);
      }
    })
  }

  if (val == 4 && val2 != '0') {
    $('.nama_supplier').addClass('disabled');
    $('.kode_supplier').addClass('disabled');
    $('.patty_cash').attr('hidden',true);
    $('.faktur').attr('hidden',true);
    $('.uang_muka').attr('hidden',false);
    $('.supp_head').attr('hidden',true);
    $('.box_head').removeClass('tinggi');

  }

  validasi();
}

$('.nama_akun_biaya').change(function(){
  var val = $(this).val();
  var val2 = $('.nama_akun').val();
  $('.kode_akun').val(val);

});



var config5 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width5'     : {width:"74% !important"}
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

               for (var selector in config5) {
               $(selector).chosen(config5[selector]);
              } 

              

$('.cari-pod').click(function(){
  var seq_pat = $('.no_patty').val();
  var keterangan = $('.keterangan_pattycash').val();
  var acc = $('.kode_akun').val();
  var bayar = $('.nominal_patty').val();
  var debit = $('.debit_patty').val();
  var temp = 0;

  if(acc != '' && bayar != '' && bayar != '' && keterangan != ''){
  var index = patty_array.indexOf(seq_pat);
  patty.row.add( [
                  '<label class="seq_pat_text">'+seq_pat+'</label>'+'<input type="hidden" class="pat_sub pat_seq_'+seq_pat+'"  value="'+seq_pat+'" >',
                  '<label class="keterangan_text">'+keterangan+'</label>'+'<input type="hidden" class="ket_patty"  name="ket_patty[]" value="'+keterangan+'" >',
                  '<label class="acc_text">'+acc+'</label>'+'<input type="hidden" class="acc_patty"  name="acc_patty[]" value="'+acc+'" >',
                  '<label class="bayar_text">'+bayar+'</label>'+'<input type="hidden" name="bayar_patty[]" class="bayar_patty" value="'+bayar+'" >',
                  '<label class="debit_text">'+debit+'</label>'+'<input type="hidden" class="debit_patty_table" name="debit_patty[]" value="'+debit+'" >',
                  '<a class="btn btn-primary btn-xs fa fa-pencil" align="center" onclick="edit_patty(this)" title="Edit"></i></a>'+'&nbsp;'+'<a class="btn btn-danger fa fa-trash btn-xs"  align="center" onclick="hapus_patty(this)" title="hapus"></i></a>'
              ] ).draw( false ); 

  patty_array.push(seq_pat);
  bayar = parseInt(bayar);
  total_pembayaran.push(bayar);
  for(var i =0; i < total_pembayaran.length; i++){
    temp = temp + total_pembayaran[i];
  }
  console.log(temp);
  temp = accounting.formatMoney(temp, "Rp ", 2, ".",',');

  $('.total_pembayaran').val(temp);
  seq_patty();
  validasi_simpan();

  $('.keterangan_pattycash').val('');
  $('.kode_akun').val('');
  $('.nominal_patty').val('');
  $('.nama_akun_biaya').val('0').trigger('chosen:updated');


  toastr.success('append sukses');
}else{
  toastr.warning('Harap isi data dengan benar');
}

});

function hapus_patty(p){
  var par = p.parentNode.parentNode;
  var temp = 0;
  var bayar = $(par).find('.bayar_patty').val();

  var index = total_pembayaran.indexOf(bayar);
  total_pembayaran.splice(index,1);

  for(var i =0; i < total_pembayaran.length; i++){
    temp = temp + total_pembayaran[i];
  }

  patty.row(par).remove().draw(false);
  temp = accounting.formatMoney(temp, "Rp ", 2, ".",',');
  $('.total_pembayaran').val(temp);
  validasi_simpan();


}
var sequence_class_patty;
function edit_patty(p){
  var par = p.parentNode.parentNode;
  var pat_sub = $(par).find('.pat_sub').val();
  sequence_class_patty = 'pat_seq_'+pat_sub;
  var keterangan = $(par).find('.ket_patty').val();
  var acc = $(par).find('.acc_patty').val();
  var bayar = $(par).find('.bayar_patty').val();
  var debit = $(par).find('.debit_patty_table').val();

  $('.nama_akun_patty_update').val(acc).trigger('chosen:updated');
  $('.kode_akun_patty_update').val(acc).trigger('chosen:updated');
  $('.debit_update').val(debit)
  $('.ket_patty_update').val(keterangan)
  $('.nominal_patty_update').val(bayar)
  $('.patt_sequence').val(sequence_class_patty)

  

  $('#modal_patty').modal('show');
}
$('.nama_akun_patty_update').change(function(){
var ini = $(this).val();
$('.kode_akun_patty_update').val(ini);
});
function sve(){
var patt_sequence = $('.patt_sequence').val();
var updt = $('.'+patt_sequence).parents('tr');


var acc = $('.nama_akun_patty_update').val();
var debit = $('.debit_update').val();
var keterangan = $('.ket_patty_update').val();
var bayar = $('.nominal_patty_update').val();
var bayar_lama = $(updt).find('.bayar_patty').val();
bayar   = parseInt(bayar);
bayar_lama   = parseInt(bayar_lama);
var cariIndex = total_pembayaran.indexOf(bayar_lama)
var temp = 0;
total_pembayaran.splice(cariIndex,1);
total_pembayaran.push(bayar);



$(updt).find('.acc_patty').val(acc);
$(updt).find('.ket_patty').val(keterangan);
$(updt).find('.bayar_patty').val(bayar);
$(updt).find('.debit_patty_table').val(debit);


$(updt).find('.acc_text').html(acc);
$(updt).find('.keterangan_text').html(keterangan);
$(updt).find('.bayar_text').html(bayar);
$(updt).find('.debit_text').html(debit);





for(var i =0; i < total_pembayaran.length; i++){
  temp = temp + total_pembayaran[i];
} 
console.log(total_pembayaran);
temp = accounting.formatMoney(temp, "Rp ", 2, ".",',');
$('.total_pembayaran').val(temp);
}

function save_pat(){


  swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data Bukti Kas Keluar!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Simpan!",
    cancelButtonText: "Batal",
    closeOnConfirm: false
  },
  function(){
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      $.ajax({
        url:baseUrl+'/buktikaskeluar/simpan_patty',
        data: $('.table_header :input').serialize()
        +'&'+$('.table_jurnal :input').serialize()
        +'&'+patty.$('input').serialize()
        +'&'+$('.total_pembayaran_table :input').serialize(),
        type:'post',
      success:function(response){

            swal({
            title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){
                       // location.href='../buktikaskeluar/index';
                       $('.id_bkk').val(response.id);
                       $('.print_patty').removeClass('disabled');
                       $('#save_patty').addClass('disabled');
                       $('.kepunyaan_patty').addClass('disabled');
                       $('.box_head').addClass('disabled');
          
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
// end patty cash
// faktur asd
$(document).ready(function(){
if (! tabel_faktur.data().count()) {
  $('#save_faktur').addClass('disabled');
}
});
$('.lunas').blur(function(){
// MERUBAH PELUNASAN
var pelunasan = $(this).val();
if (pelunasan < 0) {
  pelunasan = 0;
}
// variabel
var sisa_bayar_faktur = $('.sisa_bayar_faktur').val();
// 
sisa_bayar_faktur     = sisa_bayar_faktur.replace(/[^0-9\-]+/g,"");
sisa_bayar_faktur     = sisa_bayar_faktur/100;
if (pelunasan > sisa_bayar_faktur) {
  // variabel
  pelunasan = sisa_bayar_faktur;
  // 
}

  var account_pelunasan = accounting.formatMoney(pelunasan, "Rp ", 2, ".",',');
  $(this).val(account_pelunasan);

//MERUBAH SISA FAKTUR
// variabel
var sisa_faktur = sisa_bayar_faktur - pelunasan;
// 
var account_sisa_faktur = accounting.formatMoney(sisa_faktur, "Rp ", 2, ".",',');
$('.sisa_faktur').val(account_sisa_faktur);
// MERUBAH VALUE
var id  = $('.faktur_ini').val();
var par = $('.fak_seq'+id).parents('tr');
$(par).find('.pelunasan_detail').val(account_pelunasan);
var par_dt = $('.bkkd_id_detail').parents('tr');
$(par_dt).find('.total_faktur').html(Math.round(pelunasan).toFixed(2));
// MERUBAH TOTAL

  var temp1 = 0;
    $('.pelunasan_detail').each(function(){
      if ($(this).val() != '') {
        var terlunas = $(this).val().replace(/[^0-9\-]+/g,"");
        terlunas     = terlunas/100;
        temp1 += terlunas;
      }else{
        temp1 += 0;
      }
    });
  temp1 = accounting.formatMoney(temp1, "Rp ", 2, ".",',');
  $('.total_pembayaran').val(temp1);

});

var data_faktur = $('.pembayaran_faktur').DataTable({
                      'paging':false,
                      'searching':false
                  });
// var retur_faktur = $('.retur_faktur').DataTable({
//                       'paging':false,
//                       'searching':false
//                   });
// var dn_faktur = $('.dn_faktur').DataTable({
//                       'paging':false,
//                       'searching':false
//                   });
var tabel_faktur = $('.tabel_faktur').DataTable({
                      'paging':false,
                      'searching':false
                  });

function supplier(){
  var nama = $('.kode_supplier').val();
  var jb = $('.kode_bayar').val();
  id.splice(0,id.length);
  console.log(id);
  tabel_faktur.clear().draw();
  $('.total_pembayaran').val('');
  $.ajax({
      url:baseUrl +'/buktikaskeluar/nama_supp',
      data:'id='+nama+'&'+'jb='+jb,
      success:function(data){
        $('.nama_supplier').val(data.data);
      }
    })
  validasi();
}
$('.confirm').click(function(){
  $(this).addClass('disabled');
});

function cari_faktur(){
  var tgl = $('.range').val();
  var kode = $('.kode_supplier').val();
  var jb = $('.kode_bayar').val();
  $.ajax({
    url:baseUrl + '/buktikaskeluar/cari_faktur',
    data:{tgl:tgl,kode:kode,id:id,jb:jb},
    success:function(data){
      $('.faktur_modal').html(data);
      $('#modal_faktur').modal('show');
    },error:function(){
      toastr.warning('Error Dalam pencarian')
    }
  })
}

 $('.range').keypress(function(e){

    if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
        cari_faktur();
        return false;
     }
 });

function appended(){

$('.checker:checked').each(function(){  

      var par = $(this).parents('tr');
      var idfaktur = $(par).find('.id_faktur').val();
      var nofaktur = $(par).find('.fp_nofaktur').val();
      var fP_keterangan = $(par).find('.fP_keterangan').val();
      var fp_netto = $(par).find('.netto_faktur').val();
      var fp_tgl = $(par).find('.fp_tgl').val();
      var length = tabel_faktur.page.info().recordsTotal;
      length += 1;
      var index = id.indexOf(idfaktur);
        console.log(id);

      if (index == -1) {
        id.push(idfaktur);
        seq_fak = id.length;
        tabel_faktur.row.add([
            '<label class="seq_fak_text">'+length+'</label>'
            +'<input type="hidden" class="fak_sub fak_seq'+length+'" value="'+length+'">'
            +'<input type="hidden" class="bkkd_id" name="bkkd_id[]"  value="0" >',
            '<label class="nofaktur_text">'+nofaktur+'</label>'
            +'<input type="hidden" name="nofaktur[]" class="nofaktur"  value="'+nofaktur+'" >',
            '<label class="nofaktur_text">'+fp_tgl+'</label>',
            '<label>{{210111000}}</label>',
            '<label>'+accounting.formatMoney(fp_netto, "", 2, ".",',')+'</label>',
            '<input style="width: 130px;text-align: right;" readonly="" type="text" class="pelunasan_detail form-control" name="pelunasan[]" value="'+accounting.formatMoney(0, "Rp ", 2, ".",',')+'">'
            +'<input style="width: 130px"  type="hidden" class="sisa_terbayar_detail form-control"  value="">',
            '<input type="text" class="keterangan_bkkd form-control" name="keterangan_bkkd[]"  value="'+fP_keterangan+'">',
            '<a onclick="hapus_faktur(this)" type="button" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'              
        ]).draw(false);
        $('#save_faktur').removeClass('disabled');

        toastr.success('Append sukses');
      }
  
    });
}




$('.tabel_faktur tbody').on('click', 'tr', function () {
        var par = $(this).find('.nofaktur').val();
        var id_bkk = $(this).find('.bkkd_id').val();
        var id = $(this).find('.fak_sub').val();
        var jb = $('.kode_bayar').val();
        var pelunasan = $(this).find('.pelunasan_detail').val();
        pelunasan = pelunasan.replace(/[^0-9\-]+/g,"");
        pelunasan = pelunasan/100;


        
        $.ajax({
          url:baseUrl + '/buktikaskeluar/cari_detail_edit',
          data:'nota='+par+'&'+'par='+id+'&'+'jb='+jb+'&'+'bkkd_id='+id_bkk,
          success:function(data){
            $('#Pembayaran').html(data);
            pelunasan_accounting = accounting.formatMoney(pelunasan, "Rp ", 2, ".",',');
            var sisa_bayar_faktur = $('.sisa_bayar_faktur').val();
            sisa_bayar_faktur = sisa_bayar_faktur.replace(/[^0-9\-]+/g,"");
            sisa_bayar_faktur = sisa_bayar_faktur/100;

            sisa_faktur = sisa_bayar_faktur - pelunasan;
            // console.log(sisa_faktur);

            sisa_faktur = accounting.formatMoney(sisa_faktur, "Rp ", 2, ".",',');

            $('.lunas').val(pelunasan_accounting);
            $('.sisa_faktur').val(sisa_faktur);

        },error:function(){
            toastr.warning('Error Dalam pencarian')
        }
    })
});

function hapus_faktur(p){
  var par = p.parentNode.parentNode;
  var idfaktur = $(par).find('.id_faktur').val();
  var indexing = id.indexOf(idfaktur);

  id.splice(indexing,1);
  tabel_faktur.row(par).remove().draw(false);

  var tot_temp = 0;
      $('.pelunasan').each(function(){
        if ($(this).val() != '') {
          var terlunas = $(this).val().replace(/[^0-9\-]+/g,"");
          terlunas     = terlunas/100;
          tot_temp += terlunas;
        }else{
          tot_temp += 0;
        }
      });
    tot_temp = accounting.formatMoney(tot_temp, "Rp ", 2, ".",',');
    $('.total_pembayaran').val(tot_temp);
}


function save_faktur(){

    swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data Bukti Kas Keluar!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Simpan!",
    cancelButtonText: "Batal",
    closeOnConfirm: false
  },
  function(){
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      $.ajax({
        url:baseUrl+'/buktikaskeluar/simpan_faktur',
        data: $('.table_header :input').serialize()
        +'&'+$('.table_jurnal :input').serialize()
        +'&'+tabel_faktur.$('input').serialize()
        +'&'+$('.total_pembayaran_table :input').serialize(),
        type:'post',
      success:function(response){

            swal({
            title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){
                       // location.href='../buktikaskeluar/index';
                       $('.id_bkk').val(response.id);
                       $('.save_faktur').addClass('disabled');
                       $('.kanan').addClass('disabled');
                       $('.kiri').addClass('disabled');
                       $('.box_head').addClass('disabled');
                       $('.print_faktur').removeClass('disabled');
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

function printing(){
  var id = $('.id_bkk').val();
  window.open("{{url('buktikaskeluar/detailkas')}}"+'/'+id)
}

function reload(){
  location.reload();
}

// uang muka 




var tabel_um = $('.tabel_um').DataTable({
                  'searching':false
               });

function validate_um(){
  var length = tabel_um.page.info().recordsTotal;
  // console.log(length);

  if (length == 0) {
    $('#save_um').addClass('disabled');
  }else{
    $('#save_um').removeClass('disabled');
  }
}
validate_um();

function cari_um(){

  // var tgl = $('.range').val();
  var um  = $('.supplier_um').val();
  var jb = $('.kode_bayar').val();
  $.ajax({
    url:baseUrl + '/buktikaskeluar/cari_faktur',
    data:{um:um,id:id,jb:jb},
    success:function(data){
      $('#modal_um').modal('show');
      $('.um_modal').html(data);
    },error:function(){
      toastr.warning('Error Dalam pencarian')
    }
  })
}

function set_um(p){

  var um = $(p).find('.no_um').val();
  var id_um = $(p).find('.id_um').val();
  var jml = $(p).find('.jumlah_um').val();
  var sisa = $(p).find('.sisa_um').val();
  var temp = accounting.formatMoney(jml,"", 2, ".",',');
  var temp1 = accounting.formatMoney(sisa,"", 2, ".",',');
  console.log(temp1);

  $('.no_um').val(um);
  $('.id_um').val(id_um);
  $('.total_um').val(temp);
  $('.sisa_um_det').val(temp1);
  $('#modal_um').modal('hide');
}

// $('.nominal_um').maskMoney({precision:0,thousands:'.'});
function clear_um(){
  $('.no_um').val('');
  $('.ket_um').val('');
  $('.total_um').val('');
  $('.sisa_um_det').val('');
  $('.nominal_um').val('');
}

$('.nominal_um').blur(function(){
  var total_um    = $('.sisa_um_det').val();
  total_um = total_um.replace(/[^0-9\-]+/g,"");
  total_um = total_um/100;
  var temp = $(this).val();
  if ($(this).val() > total_um) {
    temp = total_um;
  }
  temp = accounting.formatMoney(temp,"", 2, ".",',');
  $(this).val(temp);
});

var count_um = 1;
var um_array=[];

$('.cari_um').click(function(){

  var seq_um      = $('.seq_um').val();
  var supplier_um = $('.supplier_um').val();
  var no_um       = $('.no_um').val();
  var ket_um      = $('.ket_um').val();
  var total_um    = $('.total_um').val();
  var nominal_um  = $('.nominal_um').val();
  var total_pembayaran = 0;
  var index = um_array.indexOf(no_um);
  if (no_um != '' && nominal_um != '' && ket_um != '') {
   if (index == -1) {
    count_um += 1;
    um_array.push(no_um);
     tabel_um.row.add( [
                    '<label class="seq_um_text">'+seq_um+'</label>'+'<input type="hidden" class="um_sub um_seq_'+seq_um+'"  value="'+seq_um+'" >',
                    '<label class="no_um_text">'+no_um+'</label>'+'<input type="hidden" class="no_um_table"  name="no_um[]" value="'+no_um+'" >',
                    '<label class="supp_um_text">'+supplier_um+'</label>'+'<input type="hidden" class="supp_um_table"  name="supp_um_table[]" value="'+supplier_um+'" >',
                    '<label class="ket_um_text">'+ket_um+'</label>'+'<input type="hidden" class="ket_um_table"  name="ket_um[]" value="'+ket_um+'" >',
                    '<label class="total_um_text">'+total_um+'</label>'+'<input type="hidden" name="total_um[]" class="total_um_table" value="'+total_um+'" >',
                    '<label class="nominal_um_text">'+nominal_um+'</label>'+'<input type="hidden" name="nominal_um[]" class="nominal_um_table" value="'+nominal_um+'" >',
                    '<a class="btn btn-danger fa fa-trash btn-xs"  align="center" onclick="hapus_um(this)" title="hapus"></i></a>'
                ] ).draw( false ); 

      $('.seq_um').val(count_um);
      toastr.success("Append Berhasil");
      validate_um();
      $('.no_um').val('');
      $('.ket_um').val('');
      $('.nominal_um').val('');
      $('.total_um').val('');
     
      $('.nominal_um_table').each(function(){
        var temp2 = $(this).val();
        temp2 = temp2.replace(/[^0-9\-]+/g,"");
        temp2 = temp2/100;

        total_pembayaran +=temp2;

      });
      total_pembayaran = accounting.formatMoney(total_pembayaran,"Rp ", 2, ".",',');

      $('.total_pembayaran').val(total_pembayaran);
    }else{
     toastr.warning("Data Sudah Ada");
    } 
  }else{
     toastr.warning("Harap Melengkapi Data");
  }

});

function hapus_um(p){
  var par    = p.parentNode.parentNode;
  var resi   = $(par).find('.no_um_table').val();
  var index = um_array.indexOf(resi);
  var total_pembayaran = 0;
  um_array.splice(index,1);

  tabel_um.row(par).remove().draw(false);

  validate_um();


  $('.nominal_um_table').each(function(){
        var temp2 = $(this).val();
        temp2 = temp2.replace(/[^0-9\-]+/g,"");
        temp2 = temp2/100;

        total_pembayaran +=temp2;

      });
      total_pembayaran = accounting.formatMoney(total_pembayaran,"Rp ", 2, ".",',');

      $('.total_pembayaran').val(total_pembayaran);
}

function save_um(){
   swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data Bukti Kas Keluar!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Simpan!",
    cancelButtonText: "Batal",
    closeOnConfirm: false
  },
  function(){
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      $.ajax({
        url:baseUrl+'/buktikaskeluar/simpan_faktur',
        data: $('.table_header :input').serialize()
        +'&'+$('.table_jurnal :input').serialize()
        +'&'+tabel_um.$('input').serialize()
        +'&'+$('.total_pembayaran_table :input').serialize(),
        type:'post',
      success:function(response){

            swal({
            title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){
                       // location.href='../buktikaskeluar/index';
                       $('.id_bkk').val(response.id);
                       $('#save_um').addClass('disabled');
                       $('.kepunyaan_um').addClass('disabled');
                       $('.box_head').addClass('disabled');
                       $('.print_um').removeClass('disabled');
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
</script>
@endsection













































































