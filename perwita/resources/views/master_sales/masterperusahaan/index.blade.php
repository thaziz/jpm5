@extends('main')

@section('title', 'dashboard')

@section('content')

<style type="text/css">
    .borderless td, .borderless th {
    border: none;
}
</style>

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
                    <form  id="ajax" enctype="multipart/form-data" method="post" action="master_perusahaan/save_data" class="form-horizontal" >
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-xs-6">
                            
                             <div class="form-group">
                                <label for="Nama" class="col-sm-2 control-label">Nama</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" name="ed_nama" style="text-transform: uppercase" >
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="Alamat" class="col-sm-2 control-label">Alamat</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" name="ed_alamat" style="text-transform: uppercase" >
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="No tlp" class="col-sm-2 control-label">No tlp</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" name="ed_tlp" style="text-transform: uppercase" >
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="Signature 1" class="col-sm-2 control-label">Signature1</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" name="mp_signature1" style="text-transform: uppercase" >
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="Signature 2" class="col-sm-2 control-label">Signature2</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" name="mp_signature2" style="text-transform: uppercase" >
                                </div>
                              </div>
                                                    
                                <div class="file-upload">
                                  <div class="file-select">
                                    <div class="file-select-button" id="fileName">Gambar</div>
                                    <div class="file-select-name" id="noFile">Pilih Gambar...</div> 
                                    <input type="file" name="ed_img" id="chooseFile">
                                  </div>
                                </div> 
                            
                            <br>
                            <input type="submit" name="simpan" class="btn btn-success">
                        </div>
                  </form>
                  <div class="col-xs-6">
                    @if ($data == null)
                    @else
                    @foreach ($data as $e)
                            <table class="table borderless">
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
                                    <th>Signature 1</th>
                                    <td>:</td>
                                    <td>{{ $e->mp_signature1 }}</td>
                                </tr>
                                <tr>
                                    <th>Signature 2</th>
                                    <td>:</td>
                                    <td>{{ $e->mp_signature2 }}</td>
                                </tr>
                                <tr>
                                    <th>Gambar</th>
                                    <td>:</td>
                                    <td><img src="{{ asset('perwita/storage/app/upload/images.jpg') }}"  width="200" height="100"></td>
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
$('#chooseFile').bind('change', function () {
  var filename = $("#chooseFile").val();
  if (/^\s*$/.test(filename)) {
    $(".file-upload").removeClass('active');
    $("#noFile").text("No file chosen..."); 
  }
  else {
    $(".file-upload").addClass('active');
    $("#noFile").text(filename.replace("C:\\fakepath\\", "")); 
  }
});

</script>
@endsection
