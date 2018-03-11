@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> INSERT/EDIT LEVEL
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    
                <div class="box-body">
                    <form action="{{ url('setting/hak_akses/save_data') }}" class="form-horizontal kirim" method="post" >
                        <table class="table table-striped table-bordered table-hover">
                            <tbody>
                              <tr>
                                    <td style="width:110px; padding-top: 0.4cm">Level</td>
                                    <td>
                                        <input type="text" name="ed_level" class="form-control" style="text-transform: uppercase" value="{{ $level->level or null }}" >
                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                        <input type="hidden" name="ed_level_old" class="form-control" style="text-transform: uppercase" value="{{ $level->level or null }}" >
                                        <input type="hidden" class="form-control" name="crud" class="form-control" name="crud_h" @if ($level === null) value="N" @else value="E" @endif>
                                    </td>
                              </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary " id="btnsave" >Simpan</button>
                            </div>
                        </div>
                    </form>

                </div><!-- /.box-body -->

                <div class="box-footer">
                  <div class="pull-right">


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
    $(document).ready( function () {
        $("input[name='ed_level']").focus();
    });



    
    /*
    $(document).on("click","#btnsave",function(){
        $.ajax(
        {
            url : baseUrl + "/setting/hak_akses/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result != 1){
                        alert("Gagal menyimpan data!");
                    }else{
                        window.location.href = baseUrl + '/setting/hak_akses'
                    }
                }else if(data.crud == 'E'){
                    if(data.result != 1){
                        alert("Gagal menyimpan data!");
                    }else{
                        window.location.href = baseUrl + '/setting/hak_akses'
                    }
                }else{
                    swal("Error","invalid order","error");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Error!", textStatus, "error");
            }
        });
    });
    */
    


</script>
@endsection
