@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Form Pengajuan Cek /  BG (AJU) </h2>
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
                            <strong> Create Form Pengajuan Cek / BG </strong>
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
                    <h5> Reimburs / Cek BG
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
                              No Reimburs / BG 
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
                            <td> Account Kas</td>
                            <td> <input type="text" class="form-control"></td>
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
                            <td>
                            <input type="text" class="form-control">
                             </td>

                          </tr>


                          <tr>
                            <td> &nbsp; </td>
                          </tr>

                          <tr>
                            <td> Total Reimburs </td>
                            <td>  <input type="text" class="form-control"> </td>
                          </tr>


                           </table>
                      </div>
                      </div>

                      <hr>

                      <h3> Faktur / Voucher yang belum di Reimburs Cek / BG  </h3>
                
                   <br>


                     <div class="box-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped tbl-penerimabarang" id="addColumn">
                      <tr>
                        <thead>
                        <th>
                         No Bukti
                        </th>
                          <th width="150px">
                           Tanggal
                          </th>


                          <th width="150px">
                            Keterangan
                          </th>

                          <th width="100px">
                            Cash 
                          </th>

                          <th>
                            Supplier
                          </th>

                        
                        </thead>

                      </tr>
                      <tbody>
                          <tr>
                            <td> <input type="text" class="form-control"> </td>
                            <td>   <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                              </div> </td>
                            <td> <input type="text" class="form-control"></td>
                            <td> <input type="text" class="form-control"> </td>
                            <td>  <input type="text" class="form-control"> </td>
                      </tbody>
                      </table>
                      </div>
                   </div>

                   <hr>
                    <h3>  Detail Pengajuan BG </h3>
                   <hr>

                   <div class="box-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped tbl-penerimabarang" id="addColumn">
                      <tr>
                        <thead>
                        <th>
                         No Reimburs BG
                        </th>
                          <th width="150px">
                            No Bukti
                          </th>


                          <th width="150px">
                           Cek Rem
                          </th>

                          <th width="100px">
                            Tanggal Rem
                          </th>

                          <th>
                            Jumlah 
                          </th>

                          <th>
                            Acc Kas Bank
                          </th>
                          
                          <th>
                            Supp No
                          </th>

                          <th>
                          No Reff
                          </th>

                          <th>
                            Keterangan
                          </th>

                        </thead>

                      </tr>
                      <tbody>
                          <tr>
                            <td> <input type="text" class="form-control"> </td>
                            <td> <input type="text" class="form-control"> </td>
                            <td> <input type="text" class="form-control"> </td>
                            <td> <input type="text" class="form-control"></td>
                            <td> <input type="text" class="form-control"> </td>
                            <td> <input type="text" class="form-control"> </td>
                            <td> <input type="text" class="form-control"> </td>
                            <td> <input type="text" class="form-control"> </td>
                            <td> <input type="text" class="form-control"></td>
                            
                          
                      </tbody>
                      </table>
                      </div>
                   </div>
                   
  

                <div class="box-footer">
                 <div class="pull-right">
                  <a class="btn btn-danger" href="{{ url('formaju/formaju')}}"> Kembali </a>
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
      /* brg*/       '<td> <select class="form-control"> <option value=""> Brg A </option> <option value=""> Brg B </option> </select> </td>' + 
      /* qty*/       '<td> <input type="text" class="form-control"> </td>' +
      /* gudang  */  '<td> <input type="text" class="form-control"> </td>' +
      /* harga */    '<td> <input type="text" class="form-control"> </td>'  +
      /* amount*/    '<td> <input type="text" class="form-control">  </td>' +
      /* stok */     '<td> <select class="form-control"> <option value=""> ya </option> <option value=""> tidak </option></select></td>'  +
      /* biaya */   '<td> <input type"text" class="form-control">  </td>' +
      /* ppn */     '<td> <input type="text" class="form-control"> </td>' +
      /* netto */   '<td> <input type="text" class="form-control"> </td>' +
      /* account */ '<td> <select class="form-control"> <option value=""> A </option> <option value="B"> B </option></select></td>' +
      /* keterangan */  '<td> <input type="text" class="form-control"> </td>' +

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
