@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Historis Uang Muka Pembelian </h2>
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
                            <strong> Historis Uang Muka Pembelian </strong>
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
                <div class="col-xs-12">
                   <table border="0">
                      <tr>
                          <td>  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#NoFaktur">
                                 <i class="fa fa-search" aria-hidden="true"></i>  Cari No BBK
                                </button>
                          </td>

                            <td> &nbsp; &nbsp; </td>

                          <td>
                              <input type="text" class="form-control" disabled="">
                          </td>

                      </tr>
                   </table>

                    <hr>

                    <div class="row">
                        <div class="col-xs-6">
                            <h4> BK Uang Muka Pembelian</h4>
                            <table class="table table-bordered">
                               
                                    <tr>
                                        <th> No BBK </th>
                                        <td colspan="3"> <input type="text" class="form-control" disabled=""> </td>
                                    </tr>
                                    <tr>
                                        <th> Tanggal </th>
                                        <td>01 Juli 2017 </td>
                                        <th> </th>
                                    </tr>
                                    <tr>
                                        <th> Supplier </th>
                                        <td> SP/EM/538</td>
                                        <td > JACKY JAYA, CV </td>
                                    </tr>
                                  
                                    <tr>
                                        <th> Keterangan </th>
                                        <td colspan="3"> RENOVASI GEDUNG (JPM PAKET BAWAH) JAWAPOS KARAH </td>
                                    </tr>
                                    <tr>
                                        <th> Jumlah </th>
                                        <td> <input type="text" class="form-control" disabled=""> </td>
                                    </tr>

                               
                            </table>
                        </div>

                        <hr>

                        <div class="col-xs-12">
                            
                            <table class="table table-bordered">
                            <tr>
                                <th> No BBK </th>
                                <th> No Cek / BG </th>
                                <th> Tanggal </th>
                                <th> C/T </th>
                                <th> Jumlah </th>
                                </tr>
                                <tr>
                                    <td> FB-0009/AP/0717</td>
                                    <td> 01 Juli 2017 </td>
                                    <td> Renovasi Gedung JPM</td>
                                    <td>  </td>
                                    <td style="text-align: right"> Rp 61.249.607,00</td>
                                </tr>
                            </table>

                              <br>
                              <hr>
                              <br>

                              <h4> Historis Uang Muka Pembelian </h4>

                               <table class="table table-bordered">
                               <tr>
                                  <th> No Bukti </th>
                                  <th> Tanggal </th>
                                  <th> Debet </th>
                                  <th> Kredit </th>
                               </tr>

                               <tr>
                                  <td> </td>
                                  <td> </td>
                                  <td> </td>
                                  <td> </td>
                                
                               </tr>
                               </table>

                               <hr>
                               <h4> Uang Muka Pembelian </h4>
                               <table class="table table-bordered table-stripped">
                                <tr>
                                  <th> No Bukti </th>
                                  <th> Tanggal </th>
                                  <th> No. BBk </th>
                                  <th> NO. FPG </th>
                                  <th> Jumlah </th>
                                  <th> Supplier </th>
                                </tr>
                               </table>
                        </div>

                    </div>


                     <div class="modal inmodal fade" id="NoFaktur" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title"> No Faktur </h4>
                                           
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                                                printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
                                                remaining essentially unchanged.</p>
                                            <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                                                printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
                                                remaining essentially unchanged.</p>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
