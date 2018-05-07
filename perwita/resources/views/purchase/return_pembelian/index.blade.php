@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Return Pembelian </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Transaksi Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Return Pembelian  </strong>
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
                    <h5> Return Pembelian
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                         @if(Auth::user()->punyaAkses('Return Pembelian','tambah'))
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('returnpembelian/createreturnpembelian')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
                    </div>
                    @endif
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                     
                    
                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead>
                     <tr>
                        <th style="width:10px">NO</th>
                        <th> No Return </th>
                        <th> Tanggal </th>
                        <th> Supplier </th>
                        <th> No Po </th>
                        <th> Detail </th>                    
                      
                    </tr>
                  

                    </thead>
                    <tbody>
                      @foreach($data['rn'] as $index=>$rn)
                      <tr>
                        <td> {{$index + 1}} </td>
                        <td> {{$rn->rn_nota}} </td>
                        <td> {{ Carbon\Carbon::parse($rn->rn_tgl)->format('d-M-Y ') }} </td>
                        <td> {{$rn->nama_supplier}} </td>
                        <td> {{$rn->po_no}} </td>
                        <td> <a class="btn btn-sm btn-success" href={{url('returnpembelian/detailreturnpembelian/'. $rn->rn_id.'')}}><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>  <a class="btn btn-sm btn-danger" onclick="hapusdata({{$rn->rn_id}})">
                              <i class="fa fa-trash"> </i> 
                            </a> </td>
                        
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

     tableDetail = $('.tbl-penerimabarang').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
  
    function hapusdata(id){
       swal({
        title: "Apakah anda yakin?",
        text: "Hapus Data!",
        type: "warning",
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
        closeOnConfirm: false
      },
      function(){
     $.ajax({
      data : {id},
      url : baseUrl + '/returnpembelian/delete/'+id,
      type : "get",
      success : function(response){
           swal({
            title: "Berhasil!",
                    type: 'success',
                    text: "Data Berhasil Dihapus",
                    timer: 2000,
                    showConfirmButton: true
                    },function(){
                       location.reload();
            });
           
      },
      error:function(data){ 
        swal({
        title: "Terjadi Kesalahan",
                type: 'error',
                timer: 2000,
                showConfirmButton: false
        });
      }
     })
   })
    }

</script>
@endsection
