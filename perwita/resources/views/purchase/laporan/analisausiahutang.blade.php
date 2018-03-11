@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Analisa Usia Hutang </h2>
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
                            <strong> Laporan Analisa Usia Hutang </strong>
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
                        <td style="width:170px"> Umur Hutang s/d Tanggal </td> <td> <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                          </div>
                          <td>
                              s/d
                           </td>

                           <td>  <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                          </div></td>
                           </td>  
                      </tr>
                    
                      <tr>
                        <td style="width:120px" rowspan="2"> Lihat Berdasarkan </td>
                        <td> <a class="btn btn-warning" style="width:120px"> Kode Supplier </a>
                        <td  colspan="2">
                        <input type="text" class="form-control">

                      <!--      <select class=" form-control select2"> <option value=""> Supplier A </option> <option value=""> Supplier B </option> </select> -->
                                
                            <!--     <select data-placeholder="Choose a Country..." class="chosen-select" style="width:120px;" tabindex="2">
                                <option value="">Select</option>
                                <option value="United States">United States</option>
                                <option value="United Kingdom">United Kingdom</option>
                                </select> -->
                              
                        </td>
                      </tr>

                      <tr>
                          <td> <a class="btn btn-warning" style="width: 120px"> Acc Hutang </a></td>
                          <td colspan="2"> <input type="text" class="form-control"></td>
                      </tr>
                      <br>
                  </table>

                </div>
                    <div class="col-xs-6">
                    <br>
                        <table class="table table-bordered table-striped">
                            <tr>
                                  <td style="width:120px"> Lihat Berdasarkan </td>
                                  <td> <a class="btn btn-info" style="width:120px"> Rekap </a> &nbsp; &nbsp;  <a class="btn btn-info" style="width:120px"> Detail </a> </td>
                                 
                            </tr>
                            <tr>
                                   <td colspan="3" style="text-align: center"> <a class="btn btn-success" style="width:200px"> CETAK </a> </td>
                            </tr>
                        </table>
                    </div>
                </div>

                  <hr>

                <div class="col-xs-12">
                    <br>

                <h3 style="text-align: center"> PT JAWA PRATAMA MANDIRI  <br> Laporan Register Rekap Kartu Hutang <br>
                  Periode : July - 2017
                </h3>

                  <br>
               
                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                        <th style="width:10px;text-align:center"> No Faktur </th>
                        <th style="text-align:center"> Tanggal  </th>
                        <th style="text-align:center"> Jatuh Tempo </th>
                        <th style="text-align:center"> Jumlah Faktur  </th>
                        <th style="text-align:center"> TerBayar  </th>
                        <th style="text-align:center"> Sisa Faktur </th>
                        <th style="text-align:center"> Umur </th>
                        <th style="text-align:center"> Belum Jatuh Tempo </th>
                        <th style="text-align:center"> Umur 0 s/d 30 </th>
                        <th style="text-align:center"> Umur 31 s/d 45 </th>
                        <th style="text-align:center"> Umur 36 s/d 60 </th>
                        <th style="text-align:center"> Umur 61 s/d 90 </th>
                        <th style="text-align:center"> Lebih dari 90 </th>
                    </tr>
                   
                    </thead>
                    
                    <tbody>
                    <tr>
                      <td> FB-0018/AP/0717  </td>
                      <td> 17-07-2017 </td>
                      <td style="text-align: right"> Rp 36.015.000,00 </td>
                      <td> 0 </td>
                      <td style="text-align: right"> Rp 36.015.000,00 </td>
                      <td> -29 </td>
                      <td style="text-align: right"> Rp 36.015.000,00 </td>
                      <td> </td>
                      <td> </td>
                      <td> </td>
                      <td> </td>
                      <td> </td>
                    </tr>
                    
                  <tr>
                    <td colspan="3"> Total </td>
                    <td style="text-align: right"> Rp 36.015.000,00 </td>
                    <td> 0 </td>
                    <td style="text-align: right"> Rp 36.015.000,00 </td>
                    <td> </td>
                    <td style="text-align: right">  Rp 36.015.000,00 </td>
                    <td> 0 </td>
                    <td> 0 </td>
                    <td> 0 </td>
                    <td> 0 </td>
                    <td> 0 </td>
                  </tr>

                   <tr>
                    <td colspan="3"> Grand Total </td>
                    <td style="text-align: right"> Rp 36.015.000,00 </td>
                    <td> 0 </td>
                    <td style="text-align: right"> Rp 36.015.000,00 </td>
                    <td> </td>
                    <td style="text-align: right">  Rp 36.015.000,00 </td>
                    <td> 0 </td>
                    <td> 0 </td>
                    <td> 0 </td>
                    <td> 0 </td>
                    <td> 0 </td>
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
         $(document).ready(function(){
      var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
        })
        

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
