@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
  .disabled {
    pointer-events: none;
    opacity: 1;
  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2> Diskon Penjualan </h2>
        <ol class="breadcrumb">
            <li>
                <a>Home</a>
            </li>
            <li>
                <a>Sales</a>
            </li>
            <li class="active">
                <strong> Diskon Penjualan </strong>
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
                    <h5> Tambah Data Diskon per-Cabang
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
                        <div class="col-xs-6">
                          <table border="0" class="header table">
                            <tr>
                              <td>Cabang</td>
                              <td><input type="text" value="" class="so form-control" name="so"></td>
                            </tr>
                            <tr>
                              <td>Diskon</td>
                              <td><input type="text" value="" class="so form-control" name="so"></td>
                            </tr>
                          </table>
                        </div>
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

</script>
@endsection
