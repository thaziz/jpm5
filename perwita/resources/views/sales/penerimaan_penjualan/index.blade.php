@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright { text-align: right; }
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
                                <th>Customer</th>
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
$(document).ready(function() {
    $('.tabel_data').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('datatable_kwitansi') }}',
        columns: [
            {data: 'k_nomor', name: 'k_nomor'},
            {data: 'k_tanggal', name: 'k_tanggal'},
            {data: 'k_kode_customer', name: 'k_kode_customer'},
            {data: 'k_netto', name: 'k_netto'},
            {data: 'k_keterangan', name: 'k_keterangan'},
            {data: 'tes', name: 'tes'}
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


    $(document).on( "click",".btnhapus", function(){
        if(!confirm("Hapus Data ?")) return false;
    });

    function ngeprint(id){
        console.log(id);
        window.open(baseUrl+'/sales/kwitansi/cetak_nota/'+id);
    }

</script>
@endsection
