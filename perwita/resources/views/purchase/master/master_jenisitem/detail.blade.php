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
                    <h5>  Detail Master Jenis Item</h5>

                    <div class="text-right">
                        <a class="btn btn-info edit"> Edit Data ? </a>
                    </div>

                </div>
                <div class="ibox-content">


                  @foreach($data as $gitem)
                        
                        <form method="post" action="{{url('masterjenisitem/updatemasterjenisitem/'. $gitem->kode_jenisitem .'')}}"  enctype="multipart/form-data" class="form-horizontal">
          
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
                            <td width="400px"> <input type="text" value="{{$gitem->kode_jenisitem}}"  class="form-control kode" name="kodegroupitem" readonly=""> </td>
                          </tr>


                          <tr>
                            <td>
                            Keterangan
                            </td>
                            <td>
                               <input type="text" class="form-control keterangan" name="keterangan" value="{{$gitem->keterangan_jenisitem}}" readonly="">
                            </td>
                          </tr>

                          <tr>
                            <td> Penerimaan </td>
                            <td> <select class="form-control penerimaan" name="penerimaan" disabled="">
                            @if($gitem->stock == '') <option value=""> -- Pilih -- </option> <option value="Y"> YA </option>
                            <option value="T" > TIDAK </option>
                            @else
                            <option value="Y" @if($gitem->stock == 'Y') selected="" @endif> YA </option> <option value="T"  @if($gitem->stock == 'T') selected="" @endif> TIDAK </option>  @endif </select> </td>
                          </tr>

                    @endforeach
                          </table>

                         </div>
                         </div>
                    </div>
                   

                   
                    
              <!--   <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped">
                    <thead>
                     <tr>
                        <th style="width:10px">NO</th>
                        <th> Keterangan </th>
                        <th> Hapus </th>

                      
                    </tr>
                    <tr>
                      
                    </tr>

                    </thead>
                    <tbody>
                      
                      <tr>
                        
                        <td colspan="2">  <a  class="btn btn-primary btn-flat" id="tmbh_data_barang">Tambah Data Group Item</a> </td>
                       
                      </tr>
                     
                    </tbody>
                   
                  </table>
                </div> -->
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
       $('.kode').attr('readonly', false);
       $('.penerimaan').attr('disabled' , false);

     })
</script>
@endsection
