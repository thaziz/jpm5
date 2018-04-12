@extends('main')

@section('title', 'dashboard')

@section('content')

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> CN / DN Pembelian </h2>
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
                            <strong> CN / DN Pembelian </strong>
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
                    <h5> CN / DN Pembelian
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-sm btn-success" aria-hidden="true" href="{{ url('cndnpembelian/createcndnpembelian')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
              
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                  
                </div>        
                    
                <div class="box-body">
               
                  <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead>
                     <tr>
                        <th style="width:10px">NO</th>
                        <th> No CN / DN </th>
                        <th> Supplier </th>
                        <th> Jenis CN / DN</th>                      
                        <th> Nilai CN / DN </th>
                        <th> Keterangan </th>
                        <th> Detail </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $n = 1 ?>
                    @for($i = 0; $i < count($data['cndn']); $i++)
                     
                      <tr>
                        <td> <?php echo $n ?> </td>
                        <td>  {{$data['cndn'][$i][0]->cndn_nota}}  </td>
                        <td>  @if($data['jenisbayar'][$i] == 2)
                               {{$data['cndn'][$i][0]->nama_supplier}}
                              @else
                                 {{$data['cndn'][$i][0]->nama}}
                              @endif
                        </td>
                        <td> {{$data['cndn'][$i][0]->cndn_jeniscndn}} </td>
                        <td style='text-align: right'> {{ number_format($data['cndn'][$i][0]->cndn_bruto, 2) }} </td>
                        <td> {{$data['cndn'][$i][0]->cndn_keterangan}} </td>
                      
                        <td> <a class="btn btn-sm btn-success" href={{url('cndnpembelian/detailcndnpembelian/'. $data['cndn'][$i][0]->cndn_id.'')}}><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>  <a class="btn btn-sm btn-danger" onclick="hapusData({{$data['cndn'][$i][0]->cndn_id.''}})"><i class="fa fa-trash" aria-hidden="true"></i> </a> </td>
                        
                      </tr>
                      <?php $n++ ?>
                   
                     
                   @endfor
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

  
   function hapusData(id){
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
      url:baseUrl + '/cndnpembelian/hapusdata/'+id,
      type:'get',
      dataType : 'json',
      success:function(data){
       if(data.status == "gagal"){       
          swal({
              title: "error",
              text: data.info,
              type: "error",
              
          });         
      }
       else {
          swal({
          title: "Berhasil!",
                  type: 'success',
                  text: "Data Berhasil Dihapus",
                  timer: 2000,
                  showConfirmButton: true
                  },function(){
                     location.reload();
          });
       }   
      },
      error:function(data){

        swal({
        title: "Terjadi Kesalahan",
                type: 'error',
                timer: 2000,
                showConfirmButton: false
    });
   }
  });
  });
}
    

</script>
@endsection
