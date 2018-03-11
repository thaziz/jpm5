@extends('main')

@section('title', 'dashboard')

@section('content')


<style type="text/css">
  #addColumn thead tr th{
    text-align: center;
  }
  .asw{
    color: grey;
  }
  .asw:hover{
    color: red;
  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Pembayaran Kas </h2>
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
                            <strong> Kas </strong>
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
                    <h5> Pembayaran Kas
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('biaya_penerus/createkas')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
               
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                    
                <div class="box-body">
                  <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead align="center">
                     <tr>
                        <th> No. BBM </th>
                        <th> Tanggal </th>
                        <th> Nama Cabang </th>
                        <th> Biaya Penerus </th>
                        <th> Detail </th>   
                        <th> Allow Edit </th>
                        <th> aksi </th>
                    </tr>
                    </thead>
                    <tbody>  
                      @foreach($data as $val)
                      <tr>
                        <td>{{$val->bpk_nota}}</td>
                        <td>{{$val->bpk_tanggal}}</td>
                        <td>{{$val->nama}}</td>
                        <td align="center">{{"Rp " . number_format($val->bpk_tarif_penerus,2,",",".")}}</td>
                        <td align="left" style="width: 9%">
                          <a class="fa asw fa-print" align="center"  title="edit" href="{{route('detailkas', ['id' => $val->bpk_id])}}"> detail</a><br>
                          <a class="fa asw fa-print" align="center"  title="print" href="{{route('buktikas', ['id' => $val->bpk_id])}}"> Bukti Kas</a>
                        </td>
                        <td align="center"><input type="checkbox" class="allow" name="cek[]"></td>
                        <td align="left" style="width: 6%">
                          <a class="fa asw fa-pencil" align="center" href="{{route('editkas', ['id' => $val->bpk_id])}}" title="edit"> Edit</a><br>
                          <a class="fa fa-trash asw" align="center" onclick="hapus({{$val->bpk_id}})" title="hapus"> Hapus</a>
                        </td>
                      </tr>
                      @endforeach 
                    </tbody>
                   
                  </table>
                </div><!-- /.box-body -->

                <div class="box-footer">
                  <div class="pull-right">
            
                                     
                    </div>
                  </div><!-- /.box-footer --> 
              </div><!-- /.box -->
            </div><!-- /.col -->
            </div>
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
    
  function hapus(id){
    swal({
    title: "Apakah anda yakin?",
    text: "Hapus Data Biaya Penerus!",
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
      url:baseUrl + '/biaya_penerus/hapuskas/'+id,
      type:'get',
      success:function(data){

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
  });
  });
}



</script>
@endsection
