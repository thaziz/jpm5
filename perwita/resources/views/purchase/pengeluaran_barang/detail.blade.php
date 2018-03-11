@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Detail Pengeluaran Barang
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <div class="text-right">
                       <a class="btn btn-danger" aria-hidden="true" href="{{ url('pengeluaranbarang/pengeluaranbarang')}}"> <i class="fa fa-arrow-circle-left"> </i> &nbsp; Kembali  </a> 
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
                          <div class="col-xs-6">
                            <table border="0">
                          <tr>
                            <td width="200px">
                              No BPPB
                            </td>
                            <td>
                               <input type="text" class="form-control" disabled value="BPPB04">
                            </td>
                          </tr>

                          <tr>
                            <td>
                              &nbsp;
                            </td>

                          </tr>

                           <tr>
                            <td width="200px">
                            Tanggal
                            </td>
                            <td>
                               <input type="text" class="form-control" disabled value="12 Januari 2017">
                            </td>
                          </tr>

                          <tr>
                            <td> &nbsp; </td>
                          </tr>
                          
                          <tr>
                            <td> Cabang Peminta </td>
                            <td> Cabang Sumengko </td>
                          </tr>

                          <tr>
                            <td> &nbsp; </td>
                          </tr>

                          <tr>
                            <td> Nama Peminta </td>
                            <td> Ramadhani Wulan</td>
                          </tr>

                          <tr>
                            <td> &nbsp; </td>
                          </tr>


                          <tr>
                            <td> Keperluan untuk </td>
                            <td> Membuat Ban </td>
                          </tr>
                          </table>
                          </div>
                          
                         </div>

                    </div>
                    </form>

                

                    <hr>
                    
                    <h4> Data Detail Barang </h4>

                    <hr>
                    
                <div class="box-body">
                
                 <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead>
                     <tr>
                        <th style="width:10px">NO</th>
                        <th> Uraian Barang </th>
                        <th> Satuan </th>
                        <th> Jumlah Satuan yang diminta  </th>
                        <th> Jumlah Satuan yang diberi </th>
                      
                        <th> Keterangan </th>
                        <th> Cetak </th>                      
                    </tr>
                  

                    </thead>
                    <tbody>
                      
                      <tr>
                        <td> 1 </td>
                        <td> Ban</td>
                        <td>  Pcs</td>
                        <td> 10 </td>
                        <td>  Belum dikonfirmasi </td>
                        <td> - </td>
                        </td> <td> <a class="btn btn-warning" href="{{url('pengeluaranbarang/bppb')}}">  <i class="fa fa-print" aria-hidden="true"></i> </a> </td>
                       
                        
                      </tr>
                      <!-- <tr> <td rowspan="4"> 1 </td> <td rowspan="4"> </td> <td rowspan="4"> </td> <td> halo </td> <td> halo </td> <td> halo </td> <tr> <td> halo </td> <td> halo </td> <td> halo </td> </tr> <tr> <td> halo </td> <td> halo</td><td> halo</td>
                      </tr> -->
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
        format: 'yyyy-mm-dd'
    });
    
      $no = 0;
    $('.btn').click(function(){
      
      $row = '<table class="table table-bordered table-striped">' + 
      '<thead> <tr> <th> No </th> <th> Surat Jalan </th> <th width="200px"> Tanggal Terima </th>  <th> Barang diterima </th>  <th> Jumlah diterima </th> <th> Harga </th> <th> Total Harga </th> </tr> </thead>' +
      '<tbody>' +
      '<tr>' +
      '<td> 1' +
      '</td>' +
      '<td>  <input type="text" class="form-control">' +
      '</td> ' +
      '<td> <select class="form-control"> <option value=""> Barang A </option> <option value=""> </option> </select> </td>'  +
      '<td>  <input type="text" class="form-control">' +
    
        '<td>  <input type="text" class="form-control">' +
      '</td>' +
       '</td>' +
        '<td>  <input type="text" class="form-control">' +
      '</td>' +
       '</td>' +
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
