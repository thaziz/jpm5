@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> AGEN </h2>
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
                        <li>
                          <a> Tarif DO</a>
                        </li>
                        <li class="active">
                            <strong> Agen </strong>
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
                                <table class="table table-striped table-bordered dt-responsive nowrap table-hover">
                                    
                            </table>
                        <div class="col-xs-6">



                        </div>



                    </div>
                </form>
                        <div class="col-xs-6 col-sm-offset-3">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="ed_nama" style="text-transform: uppercase" >
                        </div>
                        <div class="col-xs-6 col-sm-offset-3">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="ed_nama" style="text-transform: uppercase" >
                        </div>
                            <div class="col-xs-6 col-sm-offset-3">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="ed_nama" style="text-transform: uppercase" >
                        </div>
                               
                                

                            
                          <div class="col-md-12" style="margin:10px; border-bottom: 2px solid #efefef; padding:0px;">
                            <div class="col-md-3" style="padding:0px;">
                              <div class="col-md-12" style="padding:4px;"><label for="exampleInputName2">Gambar Barang</label></div>
                              <div class="col-md-12" style="padding:4px; padding-bottom: 20px;">

                                <label class="btn btn-default" for="upload-file-selector">

                                    <input id="upload-file-selector" name="imageUpload" class="uploadGambar" type="file" >

                                    <i class="fa fa-upload margin-correction"></i>upload gambar

                                </label>

                              </div>
                                   @if ( $errors->has('i_img') )
                                <span style="color: red;">
                                  <strong>{{ $errors->first('i_img') }}</strong>
                                </span>
                              @endif

                            </div>

                            <div class="col-md-5 image-holder" style="padding:0px; padding-bottom: 20px;">

                              

                            </div>

                          </div>
                       
                    <div class="text-right">
                       <button  type="button" class="btn btn-success " id="btn_add" name="btnok"><i class="glyphicon glyphicon-plus"></i>Simpan</button>
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

    $(".uploadGambar").on('change', function () {

      $('.save').attr('disabled', false);

        if (typeof (FileReader) != "undefined") {



            var image_holder = $(".image-holder");

            image_holder.empty();



            var reader = new FileReader();

            reader.onload = function (e) {

              image_holder.html('<img src="{{ asset('image/loading1.gif') }}" class="img-responsive" width="40px">');

              

              $('.save').attr('disabled', true);



              setTimeout(function(){

                image_holder.empty();

                $("<img />", {

                    "src": e.target.result,

                    "class": "thumb-image img-responsive",

                    "height": "80px",

                }).appendTo(image_holder);

                $('.save').attr('disabled', false);

              }, 2000)

            }

            image_holder.show();

            reader.readAsDataURL($(this)[0].files[0]);

        } else {

            alert("This browser does not support FileReader.");

        }



      });
</script>
@endsection
