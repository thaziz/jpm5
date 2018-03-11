@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
  .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
  .anjay{
  }

</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Pelunasan Hutang / Pembayaran Bank </h2>
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
                            <strong> Pelunasan Hutang / Pembayaran Bank </strong>
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
                
               {{--  <div class="row">
                <div class="col-xs-6">
                <table class="table table-bordered table-striped">
                      <tr>
                        <td> Dimulai Tanggal </td> <td> <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                              </div> </td>  <td> Diakhiri Tanggal </td> <td> <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                              </div> </td>
                      </tr>
                      <br>

                 
                        
                        <tr>
                          <th colspan="2"> Supplier </th>
                          <td colspan=2"> <select class="form-control"> <option value="">  Supplier A </option> <option value="">  Supplier B </option> </select></td>
                        </tr>

                        <tr>
                          <th colspan="2"> Group Supplier </th>
                          <td colspan="2"> <select class="form-control"> <option value="">  1001 </option> <option value="">      10002 </option> </select></td>
                        </tr>

                  
                  </table>
                </div>
                    <div class="col-xs-6">
                           <br> 

                           <table class="table table-bordered table-striped">
                              <thead>
                                  <tr>
                                      <th colspan="3" style="text-align: center"> Model Laporan </th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                      <th style="text-align: center"> 
                                        <a class="btn btn-info" > <i class="fa fa-search" aria-hidden="true"></i> &nbsp; Master BBK </a>
                                      </th>
                                         <th style="text-align: center"> 
                                        <a class="btn btn-info" > <i class="fa fa-search" aria-hidden="true"></i> &nbsp; Rekap Supplier </a>
                                      </th>
                                      <th style="text-align: center">
                                            <a class="btn btn-info" > <i class="fa fa-search" aria-hidden="true"></i> &nbsp; Master Pengajuan </a>
                                      </th>
                                  </tr>
                                  <tr>
                                       <th style="text-align: center"> 
                                        <a class="btn btn-info" > <i class="fa fa-search" aria-hidden="true"></i> &nbsp; Detail BKK </a>
                                      </th>
                                       <th style="text-align: center"> 
                                        <a class="btn btn-info" > <i class="fa fa-search" aria-hidden="true"></i> &nbsp; Rekap Bulanan  </a>
                                      </th>
                                       <th style="text-align: center"> 
                                        <a class="btn btn-info" > <i class="fa fa-search" aria-hidden="true"></i> &nbsp; Detail Pengajuan </a>
                                      </th>
                                  </tr>                                 
                            </tbody>
                           </table>
                    </div>
                </div>
  --}}

                <div class="col-xs-12">
                <h3 style="text-align: center"> PT JAWA PRATAMA MANDIRI  <br> Register Pembayaran Hutang Cash (Master) <br>
                Tanggal : 01 July 2017 s/d 31 July 2017
                </h3>
               <table class="table table-bordered datatable table-striped">
                      <br>
                                                                                
                        <tr id="filter_col1" data-column="0">
                           <th > Cari Nama Flag :  </th>
                          <td >
                            <input type="text" id="col0_filter" name="filter_cabang"  onkeyup="filterColumn()" value="" class="col-sm-12 asal form-control column_filter" placeholder="Pencarian.." >
                          </td>
                        
                        
                          <th> Pilih Laporan : </th>
                          <td >
                            <select class="form-control" onchange="location = this.value;">
                  <option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Master Item</option>
                  <option value="/jpm/reportmasterdepartment/reportmasterdepartment">Laporan Data Department</option>
                  <option value="/jpm/reportmastergudang/reportmastergudang" >Laporan Data Master Gudang</option>
                  <option value="/jpm/reportmastersupplier/reportmastersupplier">Laporan Data Supplier</option>
                  <option value="/jpm/reportspp/reportspp">Laporan Data Surat Permintaan Pembelian</option>
                  <option value="/jpm/reportpo/reportpo">Laporan Data Order</option>
                  <option value="/jpm/reportfakturpembelian/reportfakturpembelian">Laporan Data Faktur Pembelian</option>
                  <option value="/jpm/buktikaskeluar/patty_cash">Laporan Data Patty Cash</option>
                  <option value="/jpm/reportbayarkas/reportbayarkas">Laporan Data Pelunasan Hutang/Bayar Kas</option>
                  <option value="/jpm/reportbayarbank/reportbayarbank" selected="" disabled="" style="background-color: #DDD; ">Laporan Data Pelunasan Hutang/Bayar Bank</option>
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
                  <div class="row"> &nbsp; &nbsp; <a class="btn btn-info anjay"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>

                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                    <tr>
                        <th  style="text-align: center"> No. BBK </th>
                        <th  style="text-align: center"> Tanggal </th>
                        <th   style="text-align: center"> Keterangan </th>

                        <th  style="text-align: center"> Cek / BG </th>
                        <th  style="text-align: center"> Biaya </th>
                        <th   style="text-align: center"> Total Bayar </th> 

                        <th  style="text-align: center;"> Flag</th>


                    </tr>
                    </thead>
                    
                    <tbody>
                      @foreach ($array as $element)
                        {{-- expr --}}
                      
                    <tr>
                      <td>{{ $element->bbk_nota  }}</td>
                      <td>{{ $element->bbk_tgl  }}  </td>
                      <td>{{ $element->bbk_keterangan  }}  </td>
                      <td style="text-align: right">{{ $element->bbk_cekbg  }}  </td>
                      <td style="text-align: right">{{ $element->bbk_biaya  }} </td>
                      <td style="text-align: right">{{ $element->bbk_total  }} </td>
                      <td >{{ $element->bbk_flag  }}  </td>
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

    var d = new Date();
    var a = d.getDate();
    var b = d.getSeconds();
    var c = d.getMilliseconds();
    var tgl1 = '1/1/2018';
    var tgl2 = '2/2/2018';
    console.log(tgl1);  
    tableDetail = $('.tbl-item').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
               dom: 'Bfrtip',
       buttons: [
          {
                extend: 'excel',
                messageTop: 'Pencarian bedasarkan range tanggal : ' + tgl1 + ' - ' + tgl2,
                text: ' Excel',
                className:'excel',
                title:'LAPORAN PELUNASAN HUTANG / BAYAR BANK',
                filename:'BPP-'+a+b+c,
                init: function(api, node, config) {
                $(node).removeClass('btn-default'),
                $(node).addClass('btn-warning'),
                $(node).css({'margin-top': '-50px','margin-left': '80px'})
                },
                exportOptions: {
                modifier: {
                    page: 'current'
                }
            }
            
            }
        ]

    });

  function filterColumn ( ) {
    $('#addColumn').DataTable().column(6).search(
        $('#col0_filter').val()
    ).draw();    
} 


    $('.date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    
    $no = 0;
    $('.carispp').click(function(){
      $no++;
      $("#addColumn").append('<tr> <td> ' + $no +' </td> <td> no spp </td> <td> 21 Juli 2016  </td> <td> <a href="{{ url('purchase/konfirmasi_orderdetail')}}" class="btn btn-danger btn-flat" id="tmbh_data_barang">Lihat Detail</a> </td> <td> <i style="color:red" >Disetujui </i> </td> </tr>');   
    })
 
   

</script>
@endsection
