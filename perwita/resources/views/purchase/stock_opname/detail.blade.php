@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Stock Opname </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Warehouse Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Detail Stock Opname </strong>
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
                    <h5> Detail Stock Gudang
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
                              Lokasi Gudang
                            </td>
                            <td>
                              Spare Part Kendaraan
                            </td>
                          </tr>


                          <tr>
                            <td> &nbsp; </td>
                          </tr>

                          <tr>
                            <td> Bulan </td>
                            <td>  Januari  </td>
                          </tr>

                          <tr>
                            <td>
                              &nbsp;
                            </td>
                          </tr>

                          <tr>
                            <td> Status </td>
                            <td>  Sesuai</td>
                            <td> &nbsp; </td>
                            <td> <a class="btn btn-danger"  href={{url('stockopname/beritaacarastockopname')}}> Buat Berita Acara Stock Opname </a> </td>

                          </tr>

                          </table>
                      </div>

                    
                      </div>

                      <hr>

                      <h4> Detail Stock Opname </h4>
                      
                      <hr>

                      <div class="table-responsive">
                      <table class="table table-bordered table-striped tbl-penerimabarang" id="addColumn">
                      <tr>
                        <td rowspan="2">
                          No
                        </td>
                          <td rowspan="2">
                            Nama Barang
                          </td>

                          <td rowspan="2">
                           Satuan
                          </td>

                          <td colspan="2">
                          Stock Barang
                          </td>
                          
                          <td colspan="2">
                          Jumlah Selisih
                          </td>

                          <td rowspan="2">
                          Keterangan
                          </td>

                          
                      </tr>
                      <tr>
                        <td width="150px"> Fisik Barang </td>
                        <td width="150px"> Sesuai KS </td>
                        <td width="70px"> + </td>
                        <td width="70px"> - </td>
                      </tr>

                      <tbody>
                          <tr>
                          <td>
                          Barang 1
                          </td>
                          <td>
                            Pcs
                          </td>
                          <td>
                            20 Pcs
                          </td>
                          <td>
                            17 Pcs
                          </td>
                          <td>
                            -
                          </td>
                          <td>
                            3 Pcs
                          </td>
                          <td>
                            -
                          </td>
                          <td>
                            Barang hilang
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
                  
                    <a class="btn btn-warning" href={{url('purchase/stockopname')}}> Kembali </a>
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
        format: 'month'
    });
    

     $no = 0;
    $('#tmbh_data_barang').click(function(){
         $no++;
     $("#addColumn").append('<tr id=item-'+$no+'> <td> <b>' + $no +' </b> </td>' + 
      /* nama barang*/    '<td> <select class="form-control"> <option value=""> Oli </option> <option value=""> Solar </option>  </select> </td>' + 
      /* satuan  */       '<td>  </td>' +
      /* fisik barang  */  '<td> <input type="text" class="form-control"> </td>' +
      /* sistem */    '<td>  </td>'  +
      /* + */          '<td> <input type="text" class="form-control"> </td>' +
      /* - */          '<td> <input type="text" class="form-control"> </td>' +
                        '<td> <input type="text" class="form-control"> </td>' +
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
