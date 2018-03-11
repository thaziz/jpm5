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
                    <h2> Ikhtisar Kas </h2>
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
                            <strong> Ikhtisar Kas</strong>
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
                    <h5> Ikhtisar Kas
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('ikhtisar_kas/create')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
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
                        <th> No. Ikhtisar </th>
                        <th> Tanggal </th>
                        <th> Nama Cabang </th>
                        <th> Keterangan </th> 
                        <th> Total </th> 
                        <th> Print </th>     
                        <th> Status </th>     
                        <th> Allow Edit </th>
                        <th> Aksi </th>
                    </tr>
                    </thead>
                    <tbody>  
                      @foreach($data as $val)
                      <tr>
                        <td>{{$val->ik_nota}}</td>
                        <td><?php echo date('d/m/Y',strtotime($val->ik_tgl_akhir));?></td>
                        <td>{{$val->nama}}</td>
                        <td>{{$val->ik_keterangan}}</td>
                        <td>{{$val->ik_total}}</td>
                        <td align="center">
                          <a title="Edit" class="" href={{url('buktikaskeluar/edit/'.$val->ik_id.'')}}>
                              <i class="fa fa-print" aria-hidden="true">&nbsp; Print</i>
                          </a> 
                        </td>
                        <td>{{$val->ik_status}}</td>
                        <td align="center"><input type="checkbox" name="check" class="check form-control"></td>
                        <td align="center"> 
                              <a title="Edit" class="btn btn-success" href={{url('buktikaskeluar/edit/'.$val->ik_id.'')}}>
                              <i class="fa fa-arrow-right" aria-hidden="true"></i>
                              </a> 
                              <a title="Hapus" class="btn btn-success" onclick="hapus({{$val->ik_id}})">
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



</script>
@endsection
