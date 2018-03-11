@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Mutasi Hutang </h2>
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
                            <strong> Mutasi Hutang </strong>
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
                        <td style="width:120px"> Periode</td> <td> <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                          </div> </td>  
                      </tr>
                      <br>

                        <tr>
                          <td> Lihat Berdasarkan : </td>
                             <td colspan="2"> <a class="btn btn-warning" style="width:120px"> Rekap </a>  &nbsp; &nbsp; <a class="btn btn-warning" style="width:120px"> Rinci </a> </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="text-align: center"> <div class="row"> &nbsp; &nbsp; <a class="btn btn-info" style="width:50%"> <i class="fa fa-print" aria-hidden="true"></i> PREVIEW </a> </div> </td>
                        </tr>
                     

                  
                  </table>
                </div>
                    
                </div>

                <div class="col-xs-12">
                <h3 style="text-align: center"> PT JAWA PRATAMA MANDIRI  <br> Laporan Register Master Hutang <br>
                  Periode : July - 2017
                </h3>

                  

                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                  
                      <tr>
                      <th rowspan="2"> No </th>
                      <th colspan="2" style="text-align: center"> Kode Account </th>
                      <th rowspan="2"> Saldo Awal </th>
                      <th colspan="3" style="text-align: center"> Mutasi Debet </th>
                      <th colspan="5" style="text-align: center"> Mutasi Kredit </th>
                      <th rowspan="2"  style="text-align: center"> Saldo Akhir </th>
                      <th rowspan="2" style="text-align: center"> Sisa Uang </th>
                      </tr>
               
                  
                      <tr>
                        <th> Kode </th>
                        <th> Nama </th>
                        <th> Hutang Baru </th>
                        <th> Hutang Voucher </th>
                        <th> Nota Kredit </th>
                        <th> Bayar Cash </th>
                        <th> Byr Uang Muka </th>
                        <th> CEK/ BG / Trans </th>
                        <th> Return Beli </th>
                        <th> Nota Debet </th>
                        
                      </tr>
                      

                      <tr>
                        <td> 1 </td>
                        <td> 20101 </td>
                        <td> Hutang Biaya </td>
                        <td style="text-align: right"> Rp 1.612.252.319,68 </td>
                        <td style="text-align: center"> Rp 297.040.376,00 </td>
                        <td> 0 </td>
                        <td> 0 </td>
                        <td style="text-align: center"> Rp 1.582.000,00</td>
                        <td> 0 </td>
                        <td> Rp 266.848.614,00</td>
                        <td> 0 </td>
                        <td> 0 </td>
                        <td> Rp 1.640.862.081,00 </td>
                        <td> 0 </td>
                        </tr>
                   
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
