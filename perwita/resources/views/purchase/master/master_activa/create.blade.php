@extends('main')

@section('title', 'dashboard')

@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Master Activa </h2>
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
                            <strong> Create Master Activa </strong>
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
                    <h5> Tambah Data Master Activa
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
                           Kode Activa
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
                            <td>    Nama Activa </td>
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
                            <td> Tanggal Perolehan </td>
                            <td>     <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                              </div> </td>
                            </td>
                          </tr>


                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>

                            <td>
                              Nilai Perolehan
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
                              Acc Debet
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
                             CSF Kredit
                            </td>
                            <td>
                              <input type="text" class="form-control">
                            </td>
                          </tr>

                           <tr>
                            <td width="150px">
                           Keterangan
                            </td>
                            <td>
                               <input type="text" class="form-control">
                            </td>
                          </tr>

                          </table>

                         </div>

                         <div class="col-xs-6">
                          <table border="0">
                         

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td width="150px">   Kode Golongan Activa  </td>
                            <td>
                               <select class="form-control select2">
                                <option value="ASD"> ASD
                                </option>
                                <option valie="F123"> FISIKAL 123 </option>
                               </select>
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Nama Golongan Activa </td>
                             <td>
                               <input type="text" class="form-control">
                            </td>
                          </tr>

                        

                          </table>

                          <br>
                          <br>

                           <table class="table table-bordered table-striped tbl-item">
                          <thead>
                          <tr>
                            <th width="100px">
                              Metode
                            </th>
                            <th width="200px">
                              Masa Manfaat (th)
                            </th>
                            <th width="200px">
                            Porsentase (%)
                            </th>
                          </tr>
                          </thead>
                         
                          <tbody>
                            <tr>
                              <td>
                                Garis Lurus
                              </td>
                              <td>
                                <input type="text" class="form-control">
                              </td>
                              <td> <input type="text" class="form-control"> </td>
                            </tr>
                           
                            <tr>
                              <td>  Saldo Menurun
                              </td>
                              <td>
                                <input type="text" class="form-control">
                              </td>
                              <td>
                                <input type="text" class="form-control">
                              </td>
                            </tr>
                          </tbody>
                          
                         

                          </table>

                         </div>
                         </div>

                         <hr>
                    

                          


                    </div>
                    </form>
      
                <div class="box-footer">
                  <div class="pull-right">
                  
                    <a class="btn btn-warning" href={{url('masteractiva/masteractiva')}}> Kembali </a>
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

   $('.select2').select2();
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
