@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Master Perusahaan </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Master</a>
                        </li>
                        <li>
                          <a> Master Penjualan</a>
                        </li>
                        
                        <li class="active">
                            <strong> Master Perusahaan </strong>
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
                    <h5> 
                        INSERT / UPDATE DATA MASTER PERUSAHAAN
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     
                </div>
                <div class="ibox-content">

                        <div class="row">
            <div class="col-xs-12">
              <div class="box" id="seragam_box">
                    <form  id="ajax" enctype="multipart/form-data" method="post" action="master_perusahaan/save_data">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-xs-6">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="ed_nama" style="text-transform: uppercase" >
                        
                            <label>Alamat</label>
                            <input type="text" class="form-control" name="ed_alamat" style="text-transform: uppercase" >
                        
                            <label>No tlp</label>
                            <input type="text" class="form-control" name="ed_tlp" style="text-transform: uppercase" >
                        
                            <label>Gambar</label>
                            <input name="ed_img" type="file" >
                            <br>
                            <input type="submit" name="simpan" class="btn btn-success">
                        </div>
                  </form>
                  <div class="col-xs-6">
                    @if ($data == null)
                    @else
                    @foreach ($data as $e)
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama</th>
                                    <td>:</td>
                                    <td>{{ $e->mp_nama }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>:</td>
                                    <td>{{ $e->mp_alamat }}</td>
                                </tr>
                                <tr>
                                    <th>No tlp</th>
                                    <td>:</td>
                                    <td>{{ $e->mp_tlp }}</td>
                                </tr>
                                <tr>
                                    <th>Gambar</th>
                                    <td>:</td>
                                    <td><img src="/jpm5/perwita/storage/app/upload/images.jpg" width="200" height="100"></td>
                                </tr>

                            </table>
                    @endforeach
                    @endif
                    
                  </div>
                       
                    
                  <!-- modal -->
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

</script>
@endsection
