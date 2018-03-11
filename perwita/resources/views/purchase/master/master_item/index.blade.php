@extends('main')

@section('title', 'dashboard')

@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                  <br>
                    <h3> Master Item</h3>
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
                            <strong> Master Item </strong>
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
                    <h5> Master Item
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('masteritem/createitem')}}"> <i class="fa fa-plus"> Tambah Data </i> </a> 
                    </div>

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
               
                    
                <div class="box-body">
                    
                    <table border="0"> 
                    <tr>
                      <th> Lihat Master Item di Cabang : </th> <td> &nbsp; &nbsp;</td>
                        <td> <select class="form-control">

                            @foreach($data['cabang'] as $cbg)
                              <option value="{{$cbg->kode}}" name="cbg_id"> {{$cbg->nama_cabang}} </option>
                              

                            @endforeach
                            </select>
                        </td>
                    </tr>
                    </table>

                    <br>
                    <br>

                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                        <th style="width:40px">Kode</th>
                 
                        <th style="width:100px"> Nama Item </th>
                        <th> Jenis Item</th>
                        <th style="width:30px"> Satuan </th>
                        <th style="width:30px"> Minimum Stock </th>
                        <th> Harga </th>
                       
                        <th> Update Stock </th>
                        <th> Aksi </th>
                       
                    </tr>
                 
                    </thead>
                    
                    <tbody>
              

                    @foreach($data['item'] as $item) 
                    <tr>
                      <td> {{$item->kode_item}} </td>
                      <td>{{$item->nama_masteritem}} </td>
                      <td>{{$item->keterangan_jenisitem}} </td>
                      <td>{{$item->unitstock}} </td>
                      <td>{{$item->minstock}} </td>
                      <td> {{$item->harga}} </td>
                      <td>{{$item->updatestock}} </td>
                    
                       <td> 


                     <!--   <a class="btn btn-danger demo4('A-000001')" data-method="delete"> <i class="fa fa-trash"> </i></a> -->


                            <a class="btn-sm btn btn-success" href={{url('masteritem/edititem/'.$item->kode_item .'')}}> <i class="fa fa-pencil"> </i> </a>
                           &nbsp;
                           <a href="#" class="btn-sm btn btn-danger" onclick="hapusData('{{$item->kode_item}}')"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
                                    {{ Form::open(['url'=>'masteritem/deleteitem/'.$item->kode_item, 'method' => 'delete', 'id' => $item->kode_item ]) }}

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
    


      /* $('.demo4').click(function (id) {
            swal({
                title: "apa anda yakin?",
                text: "data yang dihapus tidak akan dapat dikembalikan!",
                type: "warning",
               showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
            }, function(){                        
                    $('#' +id).submit();
            });
        });*/
   

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
                  /*  swal("Deleted!", "Your imaginary file has been deleted.", "success");*/
                    });
            }

</script>
@endsection
