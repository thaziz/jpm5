@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Pelunasan Hutang / Pembayaran Kas </h2>
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
                            <strong> Pelunasan Hutang / Pembayaran Kas </strong>
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
                                        <a class="btn btn-info" > <i class="fa fa-search" aria-hidden="true"></i> &nbsp; Master BKK </a>
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

                <div class="col-xs-12">
                <h3 style="text-align: center"> PT JAWA PRATAMA MANDIRI  <br> Register Pembayaran Hutang Cash (Master) <br>
                Tanggal : 01 July 2017 s/d 31 July 2017
                </h3>

                  <div class="row"> &nbsp; &nbsp; <a class="btn btn-info"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>

                  <table id="addColumn" class="table">
                    <thead>
                     <tr>
                        <th style="width:10px;text-align:center" colspan="2"> Nomor </th>
                        <th colspan="2"  style="text-align: center"> Tanggal </th>
                        <th rowspan="2"  style="text-align: center"> Keterangan </th>
                        <th colspan="2" style="text-align: center"> Jumlah </th>
                        <th rowspan="2"  style="text-align: center"> Total Bayar </th> 
                    </tr>
                    <tr>
                        <th  style="text-align: center"> BKK </th>
                        <th  style="text-align: center"> Pengajuan </th>
                        <th  style="text-align: center"> BKK </th>
                        <th  style="text-align: center"> Pengajuan </th>
                        <th  style="text-align: center"> Uang Muka </th>
                        <th  style="text-align: center"> Cash </th>

                    </tr>
                    </thead>
                    
                    <tbody>
                    <tr>
                      <td> KK0717/03/P0001 </td>
                      <td> REM-105/AP/0717 </td>
                      <td> 01/07/2017 </td>
                      <td> 13/07/2017 </td>
                      <td> Kas Kecil JP-M Nganjuk/Biaya Cargo Ambil Surabaya </td>
                      <td> 0 </td>
                      <td style="text-align: center"> Rp 814.000,00 </td>
                      <td style="text-align: center"> Rp 814.000,00</td>
                    </tr>
                    <tr>
                      <td> KK0717/03/P0002 </td>
                      <td> REM-106/AP/0717 </td>
                      <td> 01/07/2017 </td>
                      <td> 13/07/2017 </td>
                      <td> Kas Kecil JP-M Nganjuk/Biaya Cargo Ambil Surabaya </td>
                      <td> 0 </td>
                      <td style="text-align: center"> Rp 814.000,00 </td>
                      <td style="text-align: center"> Rp 814.000,00</td>
                    </tr>

                 

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



    tableDetail = $('.tbl-item').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

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
