@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Penerimaan Barang
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
                            <td width="200px">
                              No SPP
                            </td>
                            <td>
                               <input type="text" class="form-control" disabled value="SP034">
                            </td>
                          </tr>

                          <tr>
                            <td>
                              &nbsp;
                            </td>

                          </tr>

                           <tr>
                            <td width="200px">
                             Status
                            </td>
                            <td>
                               <input type="text" class="form-control" disabled value="Belum Lengkap">
                            </td>
                          </tr>
                         

                          </table>

                         </div>

                         </div>
                    </div> 
                </div>        
                    <br>
                    <br>
                    <br>
                 <table border=0> 
                
                  <tr>
                    <td style="width:10px">
                    </td>
                    <td>  <h4> Terima Barang ? </h4> </td>
               
                   <td style="width:10px"> </td>
                   <td>     <button class="btn btn-primary btn" type="button"> Terima </button> </div>     </td>

               
                  </tr>

                  </table>

                  <br>
                  <br>



                 <div class="tmbh"> </div>

                 <hr>
                  <h4> Daftar Detail Penerimaan Barang </h4>
                 <hr>

                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead>
                     <tr>
                        <th style="width:10px">NO</th>
                        <th> Tanggal </th>
                        <th> Jumlah barang di setujui </th>
                        <th> Jumlah yang diterima </th>
                     
                       
                      
                    </tr>
                  

                    </thead>
                    <tbody>
                      
                      <tr>
                        <td> 1 </td>
                        <td>  12 Juli 2017 </td>
                        <td>  12</td>
                        <td> 2 </td>
                       
                        
                      </tr>
                      <!-- <tr> <td rowspan="4"> 1 </td> <td rowspan="4"> </td> <td rowspan="4"> </td> <td> halo </td> <td> halo </td> <td> halo </td> <tr> <td> halo </td> <td> halo </td> <td> halo </td> </tr> <tr> <td> halo </td> <td> halo</td><td> halo</td>
                      </tr> -->
                    </tbody>
                   
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
            
                   <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-info">
         
                    
                    
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
</div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

     tableDetail = $('.tbl-penerimabarang').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
   /* $('#tmbh_data_barang').click(function(){
      $("#addColumn").append('<tr> <td rowspan="3"> 1 </td> <td rowspan="3"> </td> <td rowspan="3"> </td>  <td rowspan="3"> </td> <td> halo </td> <td> 3000 </td>  <tr> <td> halo </td> <td>  5.000 </td> </tr> <tr><td> halo </td> <td> 3000 </td> </tr>');
    })*/
     $no = 0;
    $('.btn').click(function(){
      
      $row = '<table class="table table-bordered table-striped">' + 
      '<thead> <tr> <th> No </th> <th> Tanggal Terima </th> <th> Jumlah diterima </th></tr> </thead>' +
      '<tbody>' +
      '<tr>' +
      '<td> 1' +
      '</td>' +
      '<td>  <div class="input-group date">' +
      '<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014"> </div>' +
      '</td> ' +
      '<td>  <input type="text" class="form-control">' +
      '</td>' +
      '</tr>' +
      '</tbody>' +
      '</table>' +
      '<a class="btn btn-primary"> SIMPAN</a> <br> <br>';
      $('.tmbh').html($row);

      $(document).on('click','.remove-btn',function(){
              var id = $(this).data('id');
              var parent = $('#field-'+id);

              parent.remove();
          })


    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });


    })

  
  
    

</script>
@endsection
