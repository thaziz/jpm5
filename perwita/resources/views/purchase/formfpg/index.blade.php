@extends('main')

@section('title', 'dashboard')

@section('content')

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Form Permintaan Cek / BG (FPG) </h2>
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
                            <strong> Form Permintaan Cek / BG (FPG) </strong>
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
                    <h5> Form Permintaan Cek / BG (FPG)
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                         @if(Auth::user()->punyaAkses('Form Permintaan Giro','tambah'))
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('formfpg/createformfpg')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
                    </div>
                        @endif
                </div>
                <div class="ibox-content">
                        <div class="row">
              <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
               
              <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                    
                <div class="box-body">

                 {{--  <table class="table table-bordered" style="width:60%">
                    <tr>
                        <td style="width:40%"> No FPG </td> <td style="width:5%"> : </td> <td> </td>
                    </tr>
                    <tr>
                        <td> Jenis Bayar </td> <td> : </td> <td> </td>
                    </tr>
                    <tr>
                        <td> Tanggal </td> <td> : </td> <td> </td>
                    </tr>
                    <tr>
                      <td colspan="3"> <button class="btn btn-success btn-md"> <i class="fa fa-search"> </i> Cari </button> </td>
                    </tr>
                  </table> --}}


                  <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead>
                     <tr>
                        <th  style="width:10px">No </th>
                        <th > No FPG </th>
                        <th > Tanggal </th>
                        <th > Jenis Bayar </th>
                        <th > Keterangan </th>
                        <th > Total Bayar </th>
                        <th > Uang Muka  </th>
                        <th > Cek / BG  </th>
                      
                        <th > Detail </th>
                     
                    </tr>
                  

                    </thead>
                    <tbody>
                      @foreach($data['fpg'] as $index=>$fpg)
                      <tr>
                        <td> {{$index + 1}} </td>
                        <td>  {{$fpg->fpg_nofpg}} </td>
                        <td>  {{$fpg->fpg_tgl}} </td>
                        <td> {{$fpg->jenisbayar}} </td>
                       
                        <td> {{$fpg->fpg_keterangan}}
                        
                           {{--  @if($fpg->fpg_posting == 'DONE')
                              <span class="label label-success"> Sudah Terposting </span> &nbsp;
                            @else
                               <span class="label label-warning">  Belum di Posting </span> &nbsp;
                            @endif  --}} </td>
                        <td> {{number_format($fpg->fpg_totalbayar, 2)}} </td>
                        <td> - </td>
                        <td> {{number_format($fpg->fpg_cekbg , 2)}} </td>
                        
                        <td>
                        @if(Auth::user()->punyaAkses('Form Permintaan Giro','ubah'))
                        <a class="btn btn-sm btn-success" href={{url('formfpg/detailformfpg/'.$fpg->idfpg.'')}}> <i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                              @endif

                        @if(Auth::user()->punyaAkses('Form Permintaan Giro','print'))

                          @if($fpg->fpg_jenisbayar == '5' || $fpg->fpg_jenisbayar == '12')
                            <a class="btn btn-sm btn-info" href="{{url('formfpg/printformfpg2/'.$fpg->idfpg.'')}}"> <i class="fa fa-print" aria-hidden="true"></i> </a>
                          @else
                              <a class="btn btn-sm btn-info" href="{{url('formfpg/printformfpg/'.$fpg->idfpg.'')}}"> <i class="fa fa-print" aria-hidden="true"></i> </a>
                          @endif
                        @endif

                             @if(Auth::user()->punyaAkses('Form Permintaan Giro','hapus'))
                        <a class="btn btn-sm btn-danger" onclick="hapusdata({{$fpg->idfpg}})"> <i class="fa fa-trash" aria-hidden="true"></i> </a>  </td>
                                @endif
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
      url:baseUrl + '/formfpg/hapusfpg/' + id,
      type:'get',
      dataType : 'json',
      success:function(data){

        if(data.status == "sukses") {
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
        else if(data.status == "gagal") {
       
          swal({
            title: "ERROR!",
                    type: 'error',
                    text: data.info,
                    timer: 2000,
                    showConfirmButton: true
                    })
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
