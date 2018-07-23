@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Surat Permintaan Pembelian
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
                      <!-- <div class="form-group"> 
                          <div class="form-group">
                             <label for="bulan_id" class="col-sm-2 control-label">No SPP </label>
                            <div class="col-sm-2">
                              <input type="text" class="form-control">
                            </div>
                          </div>
                       </div>

                         <div class="form-group"> 
                            <div class="form-group">
                                   <label for="bulan_id" class="col-sm-2 control-label">Tanggal </label>
                                      <div class="col-sm-2">
                                        <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                                        </div>
                                       </div> 
                              </div>
                          </div>


                        <div class="form-group">
                          <div class="form-group">
                              <label for="bulan_id" class="col-sm-2 control-label"> Bagian </label>
                                <div class="col-sm-2">
                                  <input type="text" class="form-control">
                                </div>
                          </div>
                        </div>


                        <div class="form-group">
                          <div class="form-group">
                              <label for="bulan_id" class="col-sm-2 control-label"> Tanggal di Butuhkan </label>
                                <div class="col-sm-2">
                                  <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                                  </div>
                                </div> 
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="form-group">
                              <label for="bulan_id" class="col-sm-2 control-label"> Keperluan </label>
                                <div class="col-sm-2">
                                  <input type="text" class="form-control">
                                </div>
                          </div>
                        </div>

                         <div class="form-group">
                          <div class="form-group">
                              <label for="bulan_id" class="col-sm-2 control-label"> Total Biaya </label>
                                <div class="col-sm-2">
                                  <input type="text" class="form-control">
                                </div>
                          </div>
                        </div>
                  </form>
 -->


                <div class="row">
                   
                </div>
                <div class="box-body">
                  <table id="seragam_table" class="table table-bordered table-striped">
                    <button id="test" type="button"> test </button>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
            
                   <input type="submit" id="submit" name="submit" value="Print" class="btn btn-info" onclick="window.open('Seragam/cetak')">
         
                    
                    
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


     $('#test').click(function(){
      $.ajax({
        type : "get",
        url : baseUrl + '/rekapanalisahutang',
        dataType : "json",
        success:function(response){
          
        }
      })
    })

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
      });

</script>
@endsection

@section('extraScript')
  <script type="text/javascript">
    $('.datepicker').datepicker({
    format: "mm",
    viewMode: "months", 
    minViewMode: "months"
  });

  </script>
@endsection