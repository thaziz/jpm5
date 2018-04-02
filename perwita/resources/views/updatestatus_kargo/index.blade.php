@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> UPDATE STATUS DELIVERY ORDER KARGO(DO) </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Operasional</a>
                        </li>
                        <li>
                          <a>Penjualan</a>
                        </li>
                        <li>
                          <a>Transaksi Paket</a>
                        </li>
                        <li class="active">
                            <strong>Update Status DO KARGO</strong>
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
                
                <div class="ibox-content" style="min-height: 300px;">
                        <div class="row">
            <div class="col-xs-12">
          
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->                   
                <div class="col-sm-offset-4" style="margin-top: 10%;">
                    <h5 style="margin-left: 12%;">Pilih Salah Satu untuk Update:</h5>
                    <a href="{{url('updatestatus_kargo/up1')}}" class="btn btn-primary fa fa-search">&nbsp; Update Dengan No.Trayek</a>
                    <a href="{{url('updatestatus_kargo/up2')}}" class="btn btn-primary fa fa-search">&nbsp; Update Dengan No.Do</a>
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
