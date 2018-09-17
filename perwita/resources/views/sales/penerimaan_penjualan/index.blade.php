@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright { text-align: right; }
    .right{
        text-align: right;
        }
     .center{
      text-align: center;
      }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> KWITANSI </h2>
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
                            <a>Transaksi Penjualan</a>
                        </li>
                        <li class="active">
                            <strong> KWITANSI </strong>
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
                       <button  type="button" style="margin-right :12px; width:110px" class="btn btn-success " id="btn_add_order" name="btnok"></i>Tambah Data</button>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                <div class="box-body">

                    <table id="tabel_data" class="table table-bordered table-striped tabel_data" cellspacing="10">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tanggal </th>
                                <th>Cabang </th>
                                <th>Akun Bank/Kas </th>
                                <th>Customer</th>
                                <th>Jumlah</th>
                                <th>Keterangan </th>
                                <th>Jenis Pembayaran </th>
                                <th>Posting</th>
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
$(document).ready(function() {
    $('.tabel_data').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route("datatable_kwitansi") }}',
            },
            columnDefs: [
              {
                 targets: 5,
                 className: 'cssright'
              },
              {
                 targets: 7,
                 className: 'center'
              },
              {
                 targets: 9,
                 className: 'center'
              },
              {
                 targets:8,
                 className: 'center'
              }
            ],
            "columns": [
            { "data": "k_nomor" },
            { "data": "k_tanggal" },
            { "data": "cabang" },
            { "data": "bank" },
            { "data": "customer" },
            { "data": "jumlah_text"},
            { "data": "k_keterangan" },
            { "data": "pembayaran" },
            { "data": "posting" },
            { "data": "aksi" },
            ]
        });
});

    $(document).on("click","#btn_add_order",function(){
        window.location.href = baseUrl + '/sales/penerimaan_penjualan_form'
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    function ngeprint(id){
        window.open(baseUrl+'/sales/kwitansi/cetak_nota/'+id);
    }

    function edit(id){
        window.location.href = baseUrl +'/sales/edit_kwitansi?id='+id
    }

    function hapus(id) {
      var nota = id;
      var flag_nota = 'H';
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
          url:baseUrl + '/sales/hapus_kwitansi',
          data:{nota,flag_nota},
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
                  title: "Anda Tidak Punya Akses Untuk Menghapus",
                          type: 'error',
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
    function detail(id) {
      window.location.href = baseUrl +'/sales/detail_kwitansi/'+id
    }
</script>
@endsection
