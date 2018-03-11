@extends('main')

@section('title', 'dashboard')

@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Jenis Kendaraan </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a >Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Master Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Create Jenis Kendaraan </strong>
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
                    <h5> Master Jenis Kendaraan
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
                 <!--  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST"> 
                  <div class="box-body"> -->
                       <!--  <div class="form-group">
                            
                            <div class="form-group">
                            <label for="bulan_id" class="col-sm-1 control-label">Bulan</label>
                            <div class="col-sm-2">
                             <select id="bulan_id" name="bulan_id" class="form-control">
                                                      <option value="">Pilih Bulan</option>
                                                      
                              </select>
                            </div>
                          </div>
                          </div>
                           <div class="form-group">
                            
                            <div class="form-group">
                            <label for="tahun" class="col-sm-1 control-label">Tahun</label>
                            <div class="col-sm-2">
                             <select id="tahun" name="tahun" class="form-control">
                                                      <option value="">Pilih Tahun</option>
                                                      
                              </select>
                            </div>
                          </div>
                          </div> -->
                        <!--   <div class="row">
                          <div class="col-xs-6">

                          <table border="0">
                          <tr>
                            <td width="100px">
                            Nama Item
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
                            <td>    Jenis Item </td>
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
                            <td> Satuan </td>
                            <td>   <input type="text" class="form-control"> </td>
                            </td>
                          </tr>

                          <tr>


                          </tr>

                          </table>

                         </div>

                         <div class="col-xs-6">
                          <table border="0">
                          <tr>
                            <td width="100px">
                              Minimum Stock
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
                            <td>   Group Item  </td>
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
                            <td> Account Persediaan </td>
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
                            <td> Account HPP </td>
                            <td>
                               <input type="text" class="form-control">
                            </td>
                          </tr>

                          </table>

                         </div>
                         </div>

                    </div>
                    </form> -->

                   
                    
                <div class="box-body">
                
                  <table border="0">
                  <tr>
                    <td style="width:150px"> Jenis Kendaraan</td>
                    <td> <select class="form-control"> <option value=""> Kendaraan </option> <option value=""> Alat Berat </option> <option value=""> Mesin </option></select></td>
                  </tr>
                  <tr>
                    <td colspan="2"> &nbsp; </td>
                  </tr>
                  
                  <tr>
                    <td> Kode Jenis </td>
                    <td> <input type="text" class="form-control"></td>
                  </tr> 

                  <tr>
                    <td colspan="2"> &nbsp; </td>
                  </tr>

                   <tr>
                    <td> Nama Jenis </td>
                    <td> <input type="text" class="form-control"></td>
                  </tr> 


                  </table>
                </div>
                <div class="box-footer">
                  <div class="pull-right">
                  
                    <a class="btn btn-warning" href={{url('jeniskendaraan/jeniskendaraan')}}> Kembali </a>
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
     $("#addColumn").append('<tr id=item-'+$no+'> <td> <b>' + $no +' </b> </td> <td> <input type="text" class="form-control"> <td><a class="btn btn-danger removes-btn" data-id='+ $no +'> <i class="fa fa-trash"> </i>  </a> </td> </tr>');



        $(document).on('click','.removes-btn',function(){
              var id = $(this).data('id');
       //       alert(id);
              var parent = $('#item-'+id);

             parent.remove();
          })


    })

    
  
   

</script>
@endsection
