@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright { text-align: right; }
    .center{
        text-align: center;
    }
    .right: {
        text-align: right;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> POSTING PEMBAYARAN </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Operasional</a>
                        </li>
                        <li>
                            <a>Penjualan</a>
                        </li>
                        <li>
                            <a>Penerimaan Kwitansi</a>
                        </li>
                        <li class="active">
                            <strong> POSTING PEMBAYARAN </strong>
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
                    <h5 style="margin : 8px 5px 0 0">
                          <!-- {{Session::get('comp_year')}} -->
                    </h5>

                    <div class="text-right" style="">
                       <a href="../sales/posting_pembayaran_form" class="btn btn-primary">Tambah Data</a>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                <div class="box-body">

                    <table id="tabel_data" class="table table-bordered table-striped" cellspacing="10">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tanggal </th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Keterangan </th>
                                <th style="width:8%"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>

                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">





                    </div>
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
        $('#tabel_data').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route("datatable_posting") }}',
            },
            columnDefs: [
              {
                 targets: 3,
                 className: 'cssright'
              },
              {
                 targets: 2,
                 className: 'center'
              },
              {
                 targets:5,
                 className: 'center'
              },
            ],
            "columns": [
            { "data": "nomor" },
            { "data": "tanggal" },
            { "data": "pembayaran" },
            { "data": "jumlah_text"},
            { "data": "keterangan" },
            { "data": "aksi" },
            ]
        });
    });




    function edit(id){
        window.location.href = baseUrl + '/sales/posting_pembayaran_edit?id='+id;

    }

    function ngeprint(id){
        window.location.href = baseUrl + '/sales/posting_pembayaran_print/'+id;

    }


    function hapus(id){
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
          url:baseUrl + '/sales/posting_pembayaran_hapus',
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

</script>
@endsection
