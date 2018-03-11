@extends('main')

@section('title', 'dashboard')

@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Master Group Item  </h2>
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
                            <strong> Master Group Item </strong>
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
                    <h5> Master Group Item
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('masterjenisitem/createmasterjenisitem')}}"> <i class="fa fa-plus"> Tambah Data </i> </a> 
                    </div>

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
              
                    
                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                        <th style="width:10px">Kode</th>
                        <th> Keterangan </th>
                        <th> Aksi </th>     
                    </tr>
                 
                    </thead>
                    
                    <tbody>
                      @foreach($data as $gitem)
                        <tr>
                        
                          <td> {{$gitem->kode_jenisitem}} </td>
                          <td> {{$gitem->keterangan_jenisitem}} </td>
                          <td> 
                        
                          <a class="btn btn-success" href="{{url('masterjenisitem/detailmasterjenisitem/'.$gitem->kode_jenisitem .'')}}"> <i class="fa fa-arrow-right" aria-hidden="true"></i>  </a>

                            <a href="#" class="btn btn-danger" onclick="hapusData('{{$gitem->kode_jenisitem}}')"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
                                        {{ Form::open(['url'=>'masterjenisitem/deletemasterjenisitem/'. $gitem->kode_jenisitem, 'method' => 'delete', 'id' => $gitem->kode_jenisitem ]) }}
                                        {{ Form::close() }}
                          </td>
                        </tr>

                      @endforeach
                    </tbody>
                   
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  
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


    tableDetail = $('.tbl-item').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    
    $no = 0;
    $('.carispp').click(function(){
      $no++;
      $("#addColumn").append('<tr> <td> ' + $no +' </td> <td> no spp </td> <td> 21 Juli 2016  </td> <td> <a href="{{ url('purchase/konfirmasi_orderdetail')}}" class="btn btn-danger btn-flat" id="tmbh_data_barang">Lihat Detail</a> </td> <td> <i style="color:red" >Disetujui </i> </td> </tr>');   
    })
  

 

     function hapusData(id){
            swal({
            title: "apa anda yakin?",
                    text: "data yang dihapus tidak akan dapat dikembalikan",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya, Hapus!",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
            },
                    function(){   
                               
                    $('#' +id).submit();
                    swal("Terhapus!", "Data Anda telah terhapus.", "success");
                    });
            }
   

</script>
@endsection
