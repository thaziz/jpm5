
DO KERTAS SEDANG MAINTENANCE MOHON MAAF ATAS GANGGUANNYA
{{-- @extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .right { text-align: right; }
    .center { text-align: center; }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> DELIVERY ORDER KORAN </h2>
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
                            <strong> DO KORAN </strong>
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

                    <table id="tabel_data" class="table table-bordered table-striped" cellspacing="10">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tanggal </th>
                                <th>Cabang </th>
                                <th>Customer</th>
                                <th>Diskon </th>
                                <th>Total </th>
                                <th style="width:110px"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>

                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">





                    </div>
                  </div>/.box-footer
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
                url:'{{ route("datatable_do_kertas") }}',
            },
            columnDefs: [
              {
                 targets: 5,
                 className: 'right'
              },
              {
                 targets: 4,
                 className: 'right'
              },
              {
                 targets:6,
                 className: 'center'
              },
            ],
            "columns": [
            { "data": "nomor" },
            { "data": "tanggal" },
            { "data": "cabang"},
            { "data": "customer" },
            { "data": "diskon" },
            { "data": "total_net"},
            { "data": "aksi" },
            
            ]
      });
      $.fn.dataTable.ext.errMode = 'throw';
    });

    $(document).on("click","#btn_add_order",function(){
        window.location.href = baseUrl + '/sales/deliveryorderkertas_form'
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });


    function print(a) {
        window.open('{{ url('sales/cetak_nota_kertas') }}'+'/'+a)
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
          url:baseUrl + '/sales/hapus_do_kertas',
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

function edit(ted) {
  location.href = '{{ url('sales/edit_do_kertas') }}/'+ted;
}
</script>
@endsection
 --}}