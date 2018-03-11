@extends('main')

@section('title', 'dashboard')

@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Master Jenis Item </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a >Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Master Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Create Master Jenis Item </strong>
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
                  <h5>  Tambah Data Jenis Item </h5>
                    <div class="text-right">
                    </div>
                </div>
                <div class="ibox-content">
                        <form method="post" action="{{url('masterjenisitem/savemasterjenisitem')}}"  enctype="multipart/form-data" class="form-horizontal">
          
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                  <div class="box-body">
                          <div class="row">
                          <div class="col-xs-6">

                          <table border="0" class="table">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly="">

                          <tr>
                            <td width="200px"> Kode Jenis Item </td>
                            <td> <input type="text"   class="form-control kode" name="kodejenisitem" > </td>
                          </tr>

                       

                          <tr>
                            <td>
                            Keterangan
                            </td>
                            <td>
                               <input type="text" class="form-control" name="keterangan">
                            </td>
                          </tr>

                          <tr>
                            <td> Apakah memiliki stock ? </td>
                            <td> <select class="form-control" name="penerimaan"> <option value="Y"> YA </option> <option value="T"> TIDAK </option> </select> </td>
                          </tr>

                          </table>

                         </div>
                         </div>
                    </div>
                    </form>

                   
                    
         
                <div class="box-footer">
                  <div class="pull-right">
                  
                    <a class="btn btn-warning" href={{url('masterjenisitem/masterjenisitem')}}> Kembali </a>
                   <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-success">
         
                    
                    
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

     $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    $('.kode').change(function(){
        kode = $(this).val();
        $.ajax({    
            type :"post",
            data : {kode},
            url : baseUrl + '/masterjenisitem/kodejenis',
            dataType:'json',
            success : function(data){
              var length = data.length;
              console.log(length);
              if(data.length > 0){
                alert('Kode sudah digunakan :) ');
                $('.kode').val(' ');
              }
            }
          })
    })

    
  
   

</script>
@endsection
