@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Pelunasan Hutang / Pembayaran Bank </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Transaksi Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Create Pelunasan Hutang / Pembayaran Kas </strong>
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
                    <h5> Detail Pelunasan Hutang / Pembayaran Kas
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
            
                      
               
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST"> 
                  <div class="box-body">
                      <div class="row">
                      <div class="col-xs-6">
                           <table border="0">
                          <tr>
                            <td width="150px">
                          No Bukti
                            </td>
                            <td>
                              <input type="text" class="form-control">
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td> Tanggal </td>
                            <td>
                               <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                              </div>
                            </td>
                          </tr>
                          <tr>
                          <td>
                            &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td> Jenis Bayar </td>
                            <td> <select class="form-control"> <option value=""> Cash </option></select></td>
                            </td>
                          </tr>


                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>

                            <td>
                              Kepada
                            </td>
                            <td>
                             
                             <input type="text" class="form-control">

                            </td>

                          </tr>


                          <tr>
                            <td> &nbsp; </td>
                          </tr>

                          <tr>
                            <td> Keterangan </td>
                            <td> <input type="text" class="form-control"> </td>
                          </tr>

                          <tr>
                            <td> &nbsp; </td>
                          </tr>

                          <tr>
                            <td> Account Biaya</td>
                            <td>
                              <input type="text" class="form-control">
                            </td>
                          </tr>

                          <tr>
                            <td> &nbsp; </td>
                          </tr>

                          <tr>
                            <td> Jumlah Bayar</td>
                            <td>   <input type="text" class="form-control"> </td>
                          </tr>
                           </table>
                      </div>

                        <div class="col-xs-3">
                           <table class="table table-bordered table-striped">
                              <tr width="300px">
                                <td colspan="2"> <b> Posting / Jurnal </b> </td>
                              </tr>
                              <tr>
                                <td > <b> Kas </b> </td>
                                <td> <b> Uang Muka </b> </td>
                              </tr>
                              <tr>
                                <td> <input type="text" class="form-control"> </td>
                                <td> <input type="text" class="form-control"> </td>
                              </tr>
                           </table>
                        </div>
                        </div>

                      </div>

                      <hr>


                      <h4> Pembayaran Cash </h4>
                      <br>
                        <a class="btn btn-success" id="tmbh_data_barang" > Tambah Data Pembayaran Cash </a>


                      <div class="box-body">
                       <br>
                        <table class="table table-bordered table-striped tbl-penerimabarang" id="addColumn">
                        <tr>
                        <th>
                          No
                        </th>
                        <th>
                          Acc Biaya 
                        </th>
                        <th>
                          Keterangan
                        </th>
                        <th>
                          Debit / Kredit
                        </th>
                        <th>
                        Nominal
                        </th>

                        <th>
                        </th>
                        </tr>

                       
                        </table>
                      </div>


                   <br>

                   
                   
                  

                <div class="box-footer">
                    <div class="text-right">
                      <a class="btn btn-success"> Simpan </a>
                    </div>
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


    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
   /* $('#tmbh_data_barang').click(function(){
      $("#addColumn").append('<tr> <td rowspan="3"> 1 </td> <td rowspan="3"> </td> <td rowspan="3"> </td>  <td rowspan="3"> </td> <td> halo </td> <td> 3000 </td>  <tr> <td> halo </td> <td>  5.000 </td> </tr> <tr><td> halo </td> <td> 3000 </td> </tr>');
    })*/
     $no = 0;
    $('#tmbh_data_barang').click(function(){
         $no++;
     $("#addColumn").append('<tr id=item-'+$no+'> <td> <b>' + $no +' </b> </td>' + 
      /* brg*/       '<td> <input type="text" class="form-control"> </td>' + 
      /* qty*/       '<td> <input type="text" class="form-control"> </td>' +
      /* gudang  */  '<td> <input type="text" class="form-control"> </td>' +
      /* harga */    '<td> <input type="text" class="form-control"> </td>'  +
      /* amount*/   

                   '<td><a class="btn btn-danger removes-btn" data-id='+ $no +'> <i class="fa fa-trash"> </i>  </a> </td>' +
                
      '</tr>');+ 




        $(document).on('click','.removes-btn',function(){
              var id = $(this).data('id');
       //       alert(id);
              var parent = $('#item-'+id);

             parent.remove();
          })


    })

    
  
   

</script>
@endsection
