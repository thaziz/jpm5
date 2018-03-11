@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Return Pembelian </h2>
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
                            <strong> Create Return Pembelian  </strong>
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
                    <h5> Tambah Data
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
                          No Return
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
                            <td>   Tanggal </td>
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
                            <td> No Faktur </td>
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
                              Tanggal Faktur
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
                              Supplier
                            </td>
                            <td>
                              <input type="text" class="form-control">
                            </td>
                          </tr>
                          </table>
                      </div>

                    
                      </div>

                      <hr>

                      <h4> Detail Return Pembelian</h4>
                      <br>
                       <a class="btn btn-success" id="tmbh_data_barang"> Tambah Data </a>
                       <br>
                      <div class="table-responsive">
                      <table class="table table-bordered table-striped tbl-penerimabarang" id="addColumn">
                      <tr>
                        <thead>
                        <th>
                          No
                        </th>
                          <th>
                          Item
                          </th>

                          <th>
                            Update Stock
                          </th>

                          <th>
                            Qty
                          </th>

                          <th>
                            Gudang
                          </th>

                          <th>
                            Harga
                           </th>

                           <th>
                            Jumlah
                           </th>

                           <th>
                            Acc Persediaan
                           </th>
                        </thead>

                      </tr>
                      <tbody>
                          <tr>
                              <td colspan ="12">
                             
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
                  
                    <a class="btn btn-warning" href={{url('purchase/returnpembelian')}}> Kembali </a>
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
      /* Barang */    '<td>  </td>' + 
      /* Update Stock */       '<td> <select class="form-control"> <option value=""> Ya </option> <option value="tidak"> </option> </select> </td>' +
      /* Qty  */              '<td> <input type="text" class="form-control"> </td>' +
      /* Gudang */    '<td> <input type="text" class="form-control"> </td>'  +
      /* Harga */     '<td> <input type="text" class="form-control"> </td>' +
      /* Jumlah */    '<td> <input type="text" class="form-control" readonly=""> </td>' +
      /* Acc Persediaan */   '<td> <input type="text" class="form-control"></td>' +           
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
