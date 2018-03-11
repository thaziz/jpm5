@extends('main')

@section('title', 'dashboard')

@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Jenis Kendaraan</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index-2.html">Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Master Purchase</a>
                        </li>
                        <li class="active">
                            <strong>Jenis Kendaraan</strong>
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
                <div class="ibox-title">
                    <h5> Jenis Kendaraan
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('jeniskendaraan/createjeniskendaraan')}}"> <i class="fa fa-plus"> Tambah Data Kendaraan </i> </a> 
                    </div>

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                
                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                        <th style="width:10px">No</th>
                        <th> Keterangan </th>
                        <th> Detail </th>
                        
                    </tr>
                 
                    </thead>
                    
                    <tbody>
                    <tr>
                      <td> 1 </td>
                      <td> Jenis Kendaraan </td>
                      <td> <a class="btn btn-success" href={{url('purchase/detailjeniskendaraan')}}><i class="fa fa-arrow-right" aria-hidden="true"> </td>
                    
                    </tr>
                    <tr>
                      <td> 2 </td>
                      <td> Alat Berat </td>
                      <td> <a class="btn btn-success" href={{url('purchase/detailjeniskendaraan')}}><i class="fa fa-arrow-right" aria-hidden="true"> </td>
                     
                    </tr>

                    <tr>
                      <td> 3 </td>
                      <td> Mesin </td>
                      <td> <a class="btn btn-success" href={{url('purchase/detailjeniskendaraan')}}><i class="fa fa-arrow-right" aria-hidden="true"> </td>
                     
                    </tr>


                    </tbody>
                   
                  </table>
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
