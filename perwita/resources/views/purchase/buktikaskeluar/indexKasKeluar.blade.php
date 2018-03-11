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
                            <strong> Kas Keluar</strong>
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
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('buktikaskeluar/create')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
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
                        <th> No. BKK </th>
                        <th> Tanggal </th>
                        <th> Nama Cabang </th>
                        <th> Jenis Bayar</th>
                        <th> Keterangan </th> 
                        <th> Total </th>   
                        <th> Print </th>   
                        <th> Allow Edit </th>
                        <th> Aksi </th>
                    </tr>
                    </thead>
                    <tbody>  
                      @foreach($data as $val)
                        <tr>
                          <td>
                            {{$val->bkk_nota}}
                          </td>
                          <td><?php echo date('d/m/Y',strtotime($val->bkk_tgl));?></td>
                          <td>{{$val->nama}}</td>
                          <td>{{$val->jenisbayar}}</td>
                          @if($val->bkk_keterangan == '')
                          <td align="center"> - </td>
                          @else
                          <td>{{$val->bkk_keterangan}}</td>
                          @endif
                          <td align="right">{{'Rp ' . number_format($val->bkk_total,2,',','.')}}</td>
                          <td align="right">
                            <input type="hidden" class="id_print" value="{{$val->bkk_id}}">
                            <a title="Print" class="" onclick="printing(this)" >
                              <i class="fa fa-print" aria-hidden="true">&nbsp; Print</i>
                            </a> 
                          </td>
                          <td align="center"><input type="checkbox" class="checker"></td>
                          <td align="center" class="form-inline"> 

                              <a title="Edit" class="btn btn-xs btn-success" href={{url('buktikaskeluar/edit/'.$val->bkk_id.'')}}>
                              <i class="fa fa-arrow-right" aria-hidden="true"></i>
                              </a> 
                              <a title="Hapus" class="btn btn-xs btn-success" onclick="hapus({{$val->bkk_id}})">
                              <i class="fa fa-trash" aria-hidden="true"></i>
                              </a> 
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
            "order": [[ 0, "desc" ]]
            // "ordering": false
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
      url:baseUrl + '/buktikaskeluar/hapus/'+id,
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

function printing(p){
  var par = p.parentNode.parentNode;
  var id  = $(par).find('.id_print').val();
  
  window.open("{{url('buktikaskeluar/detailkas')}}"+'/'+id)
}

</script>
@endsection
