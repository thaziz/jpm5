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
                    <h2> Pending  </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Pending</a>
                        </li>
                        <li class="active">
                            <strong>Index</strong>
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
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
               
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                    
                <div class="box-body">
                  <table id="addColumn" class="table table-bordered table-striped tbl1">
                    <thead align="center">
                        <th> No. Transaksi </th>
                        <th> Tanggal </th>
                        <th> Tarif </th>  
                        <th> Jenis Biaya </th>
                        <th> Pembiayaan </th>
                        <th> Persentase Master</th>
                        <th> Persentase Biaya</th>
                        <th> Aksi </th>
                    </thead>
                    <tbody>  
                      @foreach($data as $i=>$val)
                      <tr>
                        <td>
                          {{$val->bpk_nota}}
                          <input type="hidden" class="id" value="{{$val->bpk_id}}" name="">
                        </td>
                        <td><?php echo date('d/F/Y',strtotime($val->bpk_tanggal)) ?></td>
                        <td>{{$val->bpk_tarif_penerus}}</td>
                        <td>{{$val->bpk_jenis_biaya}}</td>
                        <td>{{$val->nama}}</td>
                        <td align="right">{{$val->persen}} %</td>
                        <td align="right">{{$hasil[$i]}} %</td>
                        <td align="center"><a onclick="saving(this)" class="fa fa-check">Approve</a></td>
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

     tableDetail = $('.tbl1').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
            "sorting" :false
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


function saving(p){
    
    var par     = p.parentNode.parentNode;
    var id = $(par).find('.id').val();
    // console.log(par);
    swal({
    title: "Apakah anda yakin?",
    text: "Update Data!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Update!",
    cancelButtonText: "Batal",
    closeOnConfirm: false
  },
  function(){

       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      $.ajax({
      url:baseUrl + '/pending_kas/save_kas/'+id,
      success:function(response){
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data berhasil disimpan",
                timer: 900,
               showConfirmButton: true
                });
        tableDetail.row(par).remove().draw(false)
      },
      error:function(data){
        swal({
        title: "Terjadi Kesalahan",
                type: 'error',
                timer: 900,
               showConfirmButton: true

    });
   }
  });  
 });
}

</script>
@endsection
