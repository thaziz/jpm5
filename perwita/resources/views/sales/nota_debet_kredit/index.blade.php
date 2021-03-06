@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css" media="screen">
        .center{
        text-align: center;
        }
       .right{
        text-align: right;
        }
</style>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> NOTA DEBET KREDIT  
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <div class="text-right">
                       <a class="btn btn-primary" href="nota_debet_kredit/create">Tambah data</a>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                        <div class="box-body">
                    
                            <div class="row">
                                <table class="table table-striped table-bordered dt-responsive nowrap table-hover">
                                    
                            </table>
                        <div class="col-xs-6">



                        </div>



                    </div>
                </form>
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>Customer</th>
							              <th>Keterangan</th>
                            <th>Jenis</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                            <th> Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">


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
    $(document).ready( function () {
       $('#table_data').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('datatable_cn_dn') }}',
        
        columns: [
            {data: 'cd_nomor', name: 'cd_nomor'},
            {data: 'cd_tanggal', name: 'cd_tanggal'},
            {data: 'nama', name: 'nama'},
            {data: 'cd_keterangan', name: 'cd_keterangan'},
            {data: 'cd_jenis', name: 'cd_jenis'},
            {data: 'debet', name: 'debet'},
            {data: 'kredit', name: 'kredit'},
            {data: 'tombol', name: 'tombol'}
        ],
        columnDefs: [
              {
                 targets: 4,
                 className: 'center'
              },
              {
                 targets: 5,
                 className: 'right'
              },
              {
                 targets: 6,
                 className: 'right'
              },
              {
                 targets: 7,
                 className: 'center'
              },
              
            ],
    });
    });

    function edit(a){
      window.location.href = "nota_debet_kredit/edit/"+a;
    }

        function hapus(id){
          var nomor_cn_dn = id;
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
          url:baseUrl + '/sales/nota_debet_kredit/hapus_cn_dn',
          data:{nomor_cn_dn},
          type:'get',
          dataType:'json',
          success:function(data){
            if (data.status == 1) {
              swal({
              title: "Berhasil!",
                      type: 'success',
                      text: "Data Berhasil Dihapus",
                      timer: 2000,
                      showConfirmButton: true
                      },function(){
                         location.reload();
              });
            }else{
              swal({
            title: "Data ini hanya bisa dihapus melalui invoice pembetulan",
                    type: 'warning',
                    timer: 2000,
                    showConfirmButton: false
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
