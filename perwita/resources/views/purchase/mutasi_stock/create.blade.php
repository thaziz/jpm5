@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Mutasi Hutang </h2>
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
                            <strong> Create Mutasi Hutang </strong>
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
                    <h5> Tambah Data Mutasi Stock
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
                      <div class="row">
                      <div class="col-xs-6">
                           <table border="0">
                          <tr>
                            <td width="150px">
                              Pilihan :
                            </td>
                            <td>
                               <select class="form-control"> <option value=""> Mutasi Debet </option> <option value=""> Mutasi Kredit </option></select>
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>   No Bukti  </td>
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
                            <td> Tanggal  </td>
                            <td>   <input type="text" class="form-control"> </td>
                            </td>
                          </tr>


                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>

                            <td>
                              Jenis Mutasi 
                            </td>
                            <td>
                               <select class="form-control"> <option value=""> Return Pemakaian Barang </option> <option value=""> Penerimaan Lain - Lain  </option> </select>
                            </td>

                          </tr>

                          <tr>
                            <td>
                              &nbsp;
                            </td>
                          </tr>

                          
                          </table>
                      </div>

                        <div class="col-xs-6">
                          <table border="0">
                              <tr>
                            <td>
                             Gudang
                            </td>
                            <td>
                                <select class="form-control"> <option value=""> Gudang A </option> <option value=""> Gudang B </option></select>
                            </td>
                          </tr>

                          <tr>
                            <td>
                              &nbsp;
                            </td>
                          </tr>

                          <tr>
                            <td>
                              Acc Persediaan 
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
                            <td> 
                             Acc Biaya
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
                            <td>
                              Keterangan
                            </td>
                            <td> <input type="text" class="form-control"> </td>
                          </tr>
                          </table>
                        </div>
                      
                    
                      </div>

                      <hr>

                      <h4> Detail Voucher Hutang </h4>
                      
                       <table border="0">
                       <tr>
                        <td> &nbsp; </td>
                       </tr>
                        <tr>
                          <td> Total Qty </td> <td> &nbsp; </td> <td> <input type="text" readonly="" class="form-control"></td>
                        </tr>
                        <tr>
                          <td> &nbsp; </td>
                        </tr>
                        <tr>
                          <td> Total Harga </td> <td> &nbsp; </td> <td> <input type="text" readonly="" class="form-control"></td>
                        </tr>
                       </table>
                   

                       <br>
                       <a class="btn btn-success" id="tmbh_data_barang"> Tambah Data </a>
                       <br>

                       <br>
                      <div class="table-responsive">
                      <table class="table table-bordered table-striped tbl-penerimabarang" id="addColumn">
                      <tr>
                        <thead>
                        <th>
                          No
                        </th>
                          <th>
                           Nama Item
                          </th>

                          <th>
                           Satuan
                          </th>

                          <th>
                           Qty
                          </th>

                          <th>
                           Harga
                          </th>

                          <th>
                          </th>
                        
                        </thead>

                      </tr>
                      <tbody>
                          <tr>
                              <td colspan ="6">
                             
                              </td>
                          </tr>
                      </tbody>
                      </table>
                      </div>
                    
                      <br>
                      <br>

                    </div>
                    </form>

             
                   
  

                <div class="box-footer">
                  <div class="pull-right">
                  
                    <a class="btn btn-warning" href={{url('mutasi_stock/mutasi_stock')}}> Kembali </a>
                   <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-success">
         
                    
                    
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
      /* Account Biaya*/    '<td> <select class="form-control"> <option value=""> Barang A </option> <option value=""> Barang B </option </select>  </td>' + 
      /* keterangan */       '<td> <input type="text" class="form-control"> </td>' +
      /* Debet  */  '<td> <input type="text" class="form-control"> </td>' +
      /* Kredit */    '<td> <input type="text" class="form-control"> </td>'  +
      
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
