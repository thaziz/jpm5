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
                            <strong> Master Bank </strong>
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
                    <h5> Master Bank
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('masterbank/createmasterbank')}}"> <i class="fa fa-plus"> Tambah Data </i> </a> 
                    </div>

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
               
                    
                <div class="box-body">
                 <table class="table tbl-bank table-bordered table-stripped">
                    <thead>
                    <tr>
                      <th> No </th>
                      <th> Kode Bank </th>
                      <th> Nama Bank </th>
                      <th> Cabang </th>
                      <th> Alamat </th>
                      <th> No Account </th>
                      <th> Nama Rekening </th> 
                      <th> Aksi </th>                
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['bank'] as $index=>$bank)
                    <tr>
                      <td>  {{$index + 1}} </td>
                      <td> {{$bank->mb_kode}}</td>
                      <td> {{$bank->mb_nama}} </td>
                      <td> {{$bank->mb_cabang}}</td>
                      <td> {{$bank->mb_alamat}}</td>
                      <td> {{$bank->mb_accno}}</td>
                      <td> {{$bank->mb_namarekening}}</td>
                      <td>   <a class="btn btn-sm btn-success" href={{url('masterbank/detailbank/'. $bank->mb_id .'')}}> <i class="fa fa-arrow-right" aria-hidden="true"></i> </a> &nbsp; 
                       <a href="#" class="btn btn-danger" onclick="hapusData('{{ $bank->mb_id }}')"><i class="fa fa-trash-o" aria-hidden="true"></i></a></a>
                                    {{ Form::open(['url'=>'masterbank/deletebank/'.$bank->mb_id, 'method' => 'delete', 'id' =>$bank->mb_id ]) }}

                                    {{ Form::close() }}     </td>

                  
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


    tableDetail = $('.tbl-bank').DataTable({
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
