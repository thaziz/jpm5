@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Konfirmasi Order
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
                          <div class="row">
                           <table bprder="0">
                            <tr>
                              <td style="width:10px"> </td>
                              <td style="width:70px"> Tanggal  </td>


                              <td>   <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                              </div> </td>
                               <td style="width:10px"> </td>
                              <td>  <button class="btn btn-primary carispp" type="button"><i class="fa fa-search"></i>&nbsp;Cari</button> </td>
                            </tr>
                           </table>
                           </div>                         
                       

                    </div>
                    </form>

                    <br>

                    <hr>
                    
                    <h4> Daftar Surat Permintaan Pembelian </h4>

                    <hr>
                    
                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped">
                    <thead>
                     <tr>
                        <th style="width:10px">No</th>
                        <th> Supplier </th>
                        <th> Tanggal di Butuhkan</th>
                        <th> No SPP </th>
                        <th> Aksi </th>
                        <th> Status </th>
                       
                    </tr>
                    <tr>
                      
                    </tr>

                    </thead>
                    
                    <tbody>
                      <td> 1 </td>
                      <td> Surya Indah </td>
                      <td> 22 Juli 2017 </td>
                      <td> 1. SP034 <br> 2. SP032 <br> 3. SP031  </td>
                      <td> <a  href="{{ url('purchase/konfirmasi_orderdetail')}}" class="btn btn-danger btn-flat" id="tmbh_data_barang">Lihat Detail</a> </td>
                      <td> <b style="color:red"> Belum di Setujui </b></td>
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
