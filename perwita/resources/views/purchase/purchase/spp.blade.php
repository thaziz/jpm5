@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> SPP Purchase
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                      
                     <table>
                      <td> <h3> Lihat Detail SPP berdasarkan  </h3>
                      </td>

                      <td> &nbsp; : &nbsp; </td>
                      <td>
                        <select  class="form-control">
                                 <option value="">SPP yang di ajukan</option>
                                 <option value="">SPP yang di gunakan</option>
                                                      
                              </select>
                      </td>
                     </table>                        
                       

                    </div>
                    </form>

                    <br>

                    
                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped tbl_purchase">
                    <thead>
                     <tr>
                        <th style="width:10px">No</th>
                        <th> Tanggal </th>
                        <th> No PO </th>
                        <th> Pembayaran </th>
                        <th> Total Biaya </th>
                        <th> SPP </th>
                        <th>  Lihat Detail   </th>
                        <th> Aksi </th>
                    </tr>
                  

                    </thead>
                    <tbody>
                      <tr>
                        <td> 1 </td>
                        <td> 21 Juli 2016 </td>
                        <td> PO034 </td>
                        <td> Tunai </td>
                        <td> Rp 3.900.000 </td>
                        <td>   <button class="btn btn-primary " type="button">  <i class="fa fa-eye" aria-hidden="true"> </i> Lihat Detail SPP </button> </td>
                        <td>   <button class="btn btn-primary " type="button">  <i class="fa fa-eye" aria-hidden="true"> </i> Lihat detail PO </button> </td>
                        <td> <button class="btn btn-warning " type="button"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Pembetulan PO </button> <br>
                          <button class="btn btn-danger " type="button"> <i class="fa fa-trash" aria-hidden="true"></i> Hapus </button>
                        </td>
                      </tr>

                      <tr>
                        <td> 1 </td>
                        <td> 22 Juli 2016 </td>
                        <td> PO56 </td>
                        <td> Tempo </td>
                        <td> Rp 3.900.000 </td>
                        <td>   <button class="btn btn-primary " type="button">  <i class="fa fa-eye" aria-hidden="true"> </i> Lihat Detail SPP </button> </td>
                        <td>   <button class="btn btn-primary " type="button">  <i class="fa fa-eye" aria-hidden="true"> </i> Lihat detail PO </button> </td>
                        <td> <button class="btn btn-warning " type="button"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Pembetulan PO </button> <br>
                          <button class="btn btn-danger " type="button"> <i class="fa fa-trash" aria-hidden="true"></i> Hapus </button>
                        </td>
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

    tableDetail = $('.tbl_purchase').DataTable({
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
