@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
.excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Faktur Pembelian </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Laporan Purchase </a>
                        </li>
                        <li class="active">
                            <strong> Faktur Pembelian </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
             
                <div class="box-body">
                
                <div class="row">
                <div class="col-xs-12">
                  <h3 style="text-align: center"> PT JAWA PRATAMA MANDIRI  <br> Register Faktur Pembelian & Voucher (Master) <br>
                {{-- Tanggal : 01 July 2017 s/d 31 July 2017 --}}
                </h3>
                <table class="table table-bordered table-striped">
                     {{--   <tr>
                        <td> Dimulai Tanggal </td> <td> <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input name="min" id="min" type="text" class="form-control date_to date_range_filter
                                              date" onchange="tgl()">

                              </div> </td>  <td> Diakhiri Tanggal </td> 
                              <td> <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input type="text" class="form-control date_to date_range_filter
                                              date" name="max" id="max" onchange="tgl()" >
                              </div> </td>
                      </tr> --}}
                     
                        
                        
                          <th> Pilih Laporan : </th>
                          <td >
                            <select class="form-control" onchange="location = this.value;">
                  <option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Master Item</option>
                  <option value="/jpm/reportmasterdepartment/reportmasterdepartment">Laporan Data Department</option>
                  <option value="/jpm/reportmastergudang/reportmastergudang" >Laporan Data Master Gudang</option>
                  <option value="/jpm/reportmastersupplier/reportmastersupplier">Laporan Data Supplier</option>
                  <option value="/jpm/reportspp/reportspp">Laporan Data Surat Permintaan Pembelian</option>
                  <option value="/jpm/reportpo/reportpo">Laporan Data Order</option>
                  <option value="/jpm/reportfakturpembelian/reportfakturpembelian" selected="" disabled="" style="background-color: #DDD; ">Laporan Data Faktur Pembelian</option>
                  <option value="/jpm/buktikaskeluar/patty_cash">Laporan Data Patty Cash</option>
                  <option value="/jpm/reportbayarkas/reportbayarkas">Laporan Data Pelunasan Hutang/Bayar Kas</option>
                  <option value="/jpm/reportbayarbank/reportbayarbank">Laporan Data Pelunasan Hutang/Bayar Bank</option>
                  {{-- <option value="/jpm/reportbayarbank/reportbayarbank">Laporan Data Kartu Hutang</option>
                  <option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Mutasi Hutang</option>
                  <option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Historis Faktur vs Pelunasan</option>
                  <option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Analisa Usia Hutang</option>
                  <option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Faktur Pajak Masukan</option>
                  <option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Historis Uang Muka Pembelian</option> --}}
                 </select>
                          </td>
                        </tr>
                  
                  </table>
                </div>
 

                <div class="col-xs-12">
                

                  <div class="row"> &nbsp; &nbsp; <a class="btn btn-info"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>

                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                        <th style="width:10px"> No Faktur </th>
                        <th> Tanggal </th>
                        <th> Discount </th>
                        <th> D P P </th>
                        <th> PPn </th>
                        <th> Pajak </th>
                        <th> Netto </th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $index => $element)
                    <tr>
                      <td> {{ $index+1 }} </td>
                      <td> {{ $element->fp_tgl }}</td>
                      <td style="text-align: right"> {{ $element->fp_discount }} </td>
                      <td style="text-align: right"> {{ $element->fp_dpp }} </td>
                      <td style="text-align: right"> {{ $element->fp_ppn }} </td>
                      <td style="text-align: right"> {{ $element->fp_fakturpajak }} </td>
                      <td style="text-align: right"> {{ $element->fp_netto }} </td>
                    </tr>
                      @endforeach

                    </tbody>
                   
                  </table>
                  </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  
                  </div><!-- /.box-footer --> 
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

$(document).ready(function(){

  $('.cetak').attr('disabled', true);

})
     $("#min").datepicker({format:"dd/mm/yyyy"});
     $("#max").datepicker({format:"dd/mm/yyyy"});
    


    var d = new Date();
    var a = d.getDate();
    var b = d.getSeconds();
    var c = d.getMilliseconds();
    var tgl1 = '1/1/2018';
    var tgl2 = '2/2/2018';

  $('#addColumn').DataTable({
    paging:true,
       dom: 'Bfrtip',
       buttons: [
          {
                extend: 'excel',
               /* messageTop: 'Hasil pencarian dari Nama : ',*/
                text: ' Excel',
                className:'excel',
                title:'LAPORAN PATTY CASH',
                filename:'PATTYCASH-'+a+b+c,
                init: function(api, node, config) {
                $(node).removeClass('btn-default'),
                $(node).addClass('btn-warning'),
                $(node).css({'margin-top': '-50px','margin-left': '1435px'})
                },
                exportOptions: {
                modifier: {
                    page: 'all'
                }
            }
            
            }
        ]
  });

  function filterColumn ( ) {
    $('#addColumn').DataTable().column(2).search(
        $('#col0_filter').val()
    ).draw();    
} 


     

</script>
@endsection
