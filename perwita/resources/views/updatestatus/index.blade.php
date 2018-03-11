@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                
                <div class="ibox-content" style="min-height: 300px;">
                        <div class="row">
            <div class="col-xs-12">
          
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->                   
                <div class="col-sm-offset-4" style="margin-top: 10%;">
                    <h5 style="margin-left: 12%;">Pilih Salah Satu untuk Update:</h5>
                    <a href="{{url('updatestatus/up1')}}" class="btn btn-primary fa fa-search">&nbsp; Update Dengan No.Trayek</a>
                    <a href="{{url('updatestatus/up2')}}" class="btn btn-primary fa fa-search">&nbsp; Update Dengan No.Do</a>
                </div>
                    </div>
                  </div>
                </div>
                  <!-- modal -->
                <div class="box-footer">
                  <div class="pull-right">


                  </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
       </form>
   </div>
</div>


<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

 
</script>
@endsection
