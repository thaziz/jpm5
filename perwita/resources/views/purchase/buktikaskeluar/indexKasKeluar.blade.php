@extends('main')

@section('title', 'dashboard')

@section('content')


<style type="text/css">
  .asw{
    color: grey;
  }
  .asw:hover{
    color: red;
  }
  .center:{
    text-align: center !important;
  }
  .right:{
    text-align: right !important;
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
                  <div class="col-sm-6" style="margin-bottom: 20px">
                    <table cellpadding="3" cellspacing="0" border="0" class="table">
                      <tr id="filter_col1" data-column="0">
                          <td>Cabang</td>
                          <td align="center"><input type="text" class="column_filter form-control" id="col0_filter"></td>
                      </tr>
                      <tr id="filter_col2" data-column="1">
                          <td>Jenis Pembayaran</td>
                          <td align="center"><input type="text" class="column_filter form-control" id="col1_filter"></td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-sm-12">
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
                          {{-- <th> Allow Edit </th> --}}
                          <th> Aksi </th>
                      </tr>
                      </thead>
                      <tbody>  
                        
                      </tbody>
                    </table>
                  </div>
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
         processing: true,
          // responsive:true,
          serverSide: true,
          ajax: {
              url:'{{ route("datatable_bkk") }}',
          },
          columnDefs: [
            {
               targets: 5,
               className:'right'
            },
            {
               targets: 6,
               className:'center'
            },
            {
               targets:7,
               className:'center'
            },
          ],
          "columns": [
          { "data": "bkk_nota" },
          { "data": "bkk_tgl" },
          { "data": "cabang" },
          { "data": "jenisbayar"},
          { "data": "bkk_keterangan" },
          { "data": "tagihan" },
          { "data": "print"},
          { "data": "aksi" },
          
          ]
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
      url:baseUrl + '/buktikaskeluar/hapus',
      data:{id},
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

function printing(id) {
    $.ajax({
        url:baseUrl + '/buktikaskeluar/print',
        type:'get',
        data:{id},
        success:function(data){
          window.open().document.write(data);
        },
        error:function(data){
        }
    });
  }

</script>
@endsection
