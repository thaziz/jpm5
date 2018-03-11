@extends('main')

@section('title', 'dashboard')

@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Master Department </h2>
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
                            <strong> Create Master Department </strong>
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
                    <h5> Tambah Data Master Departement
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="text-right">
                         <div class="text-right">
                         <a class="btn btn-info edit"> Edit Data ? </a>
                        </div>
                    </div>
                </div>

                @foreach($data as $d)
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
                   <form method="post" action="{{url('masterdepartment/updatemasterdepartment/'. $d->kode_department .'')}}"  enctype="multipart/form-data" class="form-horizontal">
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    
                <div class="box-body">
                  
                  <table class="table">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly="">

                    <tr>
                      <td style="width:150px"> Kode </td>
                      <td> <input class="form-control kode_department" type="text" value="{{$d->kode_department}}" name="kode_department" readonly="" style="width:200px"> </td>
                    </tr>
                    <tr>
                      <td style="width:150px"> Keterangan </td>
                      <td> <input type="text" class="form-control keterangan" value="{{$d->nama_department}}" name="keterangan" style="width:200px" readonly=""> </td>
                    </tr>
                  </table>

                  
                </div>
                <div class="box-footer">
                  <div class="pull-right">
                  
                    <a class="btn btn-warning" href={{url('masterdepartment/masterdepartment')}}> Kembali </a>
                   <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-success">
                    </form>
                    
                    @endforeach
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
    
   /* $('#tmbh_data_barang').click(function(){
      $("#addColumn").append('<tr> <td rowspan="3"> 1 </td> <td rowspan="3"> </td> <td rowspan="3"> </td>  <td rowspan="3"> </td> <td> halo </td> <td> 3000 </td>  <tr> <td> halo </td> <td>  5.000 </td> </tr> <tr><td> halo </td> <td> 3000 </td> </tr>');
    })*/
     $no = 0;
    $('#tmbh_data_barang').click(function(){
         $no++;
     $("#addColumn").append('<tr id=item-'+$no+'> <td> <b>' + $no +' </b> </td> <td> <input type="text" class="form-control"> <td><a class="btn btn-danger removes-btn" data-id='+ $no +'> <i class="fa fa-trash"> </i>  </a> </td> </tr>');



        $(document).on('click','.removes-btn',function(){
              var id = $(this).data('id');
       //       alert(id);
              var parent = $('#item-'+id);

             parent.remove();
          })


    })

       $('.edit').click(function(){
       $('.keterangan').attr('readonly', false);
       $('.kode_department').attr('readonly', false);
     })
  
   

</script>
@endsection
