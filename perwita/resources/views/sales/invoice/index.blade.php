

@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright { text-align: right; }
    .center { text-align: center; }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> INVOICE </h2>
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
                            <strong> INVOICE </strong>
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

                    <table style="font-size: 12px" id="tabel_data" class="table table-bordered table-striped" cellspacing="10">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tanggal </th>
                                <th>Customer</th>
                                <th>JT</th>
                                <th>Tagihan </th>
                                <th>Sisa Tagihan </th>
                                <th>Keterangan </th>
                                <th>No Faktur Pajak </th>
                                <th>Status Print</th>
                                <th style="width:10%"> Aksi </th>
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
                url:'{{ route("datatable_invoice1") }}',
            },
            columnDefs: [
              {
                 targets: 4,
                 className: 'cssright'
              },
              {
                 targets: 5,
                 className: 'cssright'
              },
              {
                 targets:8,
                 className: 'center'
              },
              {
                 targets:9,
                 className: 'center'
              },
            ],
            "columns": [
            { "data": "i_nomor" },
            { "data": "i_tanggal" },
            { "data": "customer"},
            { "data": "i_jatuh_tempo" },
            { "data": "tagihan" },
            { "data": "sisa"},
            { "data": "i_keterangan" },
            { "data": "i_faktur_pajak" },
            { "data": "status" },
            { "data": "aksi" },
            
            ]
      });
      $.fn.dataTable.ext.errMode = 'throw';
    });


    $(document).on("click","#btn_add_order",function(){
        window.location.href = baseUrl + '/sales/invoice_form'
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    function edit(id){
        var id = id.replace(/\//g, "-");
        window.location.href = baseUrl + '/sales/edit_invoice/'+id;
    }
    function lihat(id){
        var id = id.replace(/\//g, "-");
        window.open(baseUrl + '/sales/lihat_invoice/'+id);
    }


    function ngeprint(id){
        var id = id.replace(/\//g, "-");
        window.open(baseUrl+'/sales/cetak_nota/'+id);
        location.reload();
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
          url:baseUrl + '/sales/hapus_invoice',
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
