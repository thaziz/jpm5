@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Faktur Pajak Masukan </h2>
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
                            <strong> Faktur Pajak Masukan </strong>
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
                        <td> Masa Pajak </td> <td> <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                              </div> </td>  <td> s/d </td> <td> <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                              </div> </td>
                      </tr>
                      <br>

                 
                        
                        <tr>
                          <td colspan="2" style="text-align: center"> <a class="btn btn-primary"> Supplier </a> </td>
                          <td colspan="2"> <!-- <select class="form-control"> <option value="">  Supplier A </option> <option value="">  Supplier B </option> </select> --> <input type="text" class="form-control" disabled=""></td>
                        </tr>

                         <tr>
                                    <th colspan="4" style="text-align: center"> <a class="btn btn-info" style="width:200px"> PREVIEW </a> </th>
                          </tr>

                  
                  </table>
                </div>
                    <div class="col-xs-6">
                           <br> 

                           <table class="table table-bordered table-striped">
                              <thead>
                                  <tr>
                                      <th colspan="2" style="text-align: center"> Model Laporan </th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                      <th style="text-align: center"> 
                                        <a class="btn btn-info" > <i class="fa fa-search" aria-hidden="true"></i> &nbsp; Master Faktur Pajak </a>
                                      </th>
                                         <th style="text-align: center"> 
                                        <a class="btn btn-info" > <i class="fa fa-search" aria-hidden="true"></i> &nbsp; Rekap Per Supplier </a>
                                      </th>
                                  </tr>
                                  <tr>
                                       <th style="text-align: center"> 
                                        <a class="btn btn-info" > <i class="fa fa-search" aria-hidden="true"></i> &nbsp; Lapor Pajak </a>
                                      </th>
                                       <th style="text-align: center"> 
                                        <a class="btn btn-info" > <i class="fa fa-search" aria-hidden="true"></i> &nbsp; Rekap Bulanan / 1 Tahun </a>
                                      </th>
                                  </tr>
                                 
                            </tbody>
                           </table>
                    </div>
                </div>

                <div class="col-xs-12">
                <h3 style="text-align: center"> PT JAWA PRATAMA MANDIRI  <br> Register Faktur Pembelian & Voucher (Master) <br>
                Tanggal : 01 July 2017 s/d 31 July 2017
                </h3>

                 

                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                      <tr>
                        <th colspan="2"> Faktur Pajak Masukan </th>
                        <th colspan="2"> Faktur Pembelian </th>
                        <th rowspan="2"> Bruto </th>
                        <th rowspan="2"> Discount </th>
                        <th rowspan="2"> D P P </th>
                        <th rowspan="2"> PPn </th>
                        <th rowspan="2"> Pajak Lain </th>
                        <th rowspan="2"> MTs </th>
                        <th rowspan="2"> Keterangan </th>

                       </tr>

                       <tr>
                          <th> No Fakur Pajak </th>
                          <th> Tanggal </th>
                          <th> No Faktur Beli </th>
                          <th> Tanggal </th>

                       </tr>

                    </thead>
                    <tbody>
                        <tr>
                          <td> 01001719438754</td>
                          <td> 05 Juli 2017 </td>
                          <td> FB-0023/AP/0717 </td>
                          <td> 13 Juli 2017 </td>
                          <td style="text-align: "> Rp 9.200.000,00 </td>
                          <td> 0  </td>
                          <td style="text-align: "> Rp 920.000,00 </td>
                          <td> 0 </td>
                          <td> Rp 27.600 </td>
                          <td> </td>
                          <td> DELTALUBE 757 Multi Purpose Sae Engine </td>

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
