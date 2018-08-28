@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright { text-align: right; }
    .center { text-align: center; }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> SURAT JALAN TRAYEK </h2>
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
                            <a>Transaksi Paket</a>
                        </li>
                        <li class="active">
                            <strong> SURAT JALAN TRAYEK </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
@if (Session::has('message'))
    <div class="wrapper wrapper-content animated fadeInRight">
      <div class="col-md-12">
        <div class="alert alert-info alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
          <h2 style="text-align:center"> <b></b></h2> <h4 style="text-align:left">DATA BERHASIL DIHAPUS</h4>
        </div>
      </div>
    </div>
@endif
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 style="margin : 8px 5px 0 0"> SURAT JALAN TRAYEK
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
                                <th>Kode Rute</th>
                                <th>Nama Rute</th>
                                <th>Cabang </th>
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
    $('#tabel_data').DataTable({
        processing: true,
        // responsive:true,
        serverSide: true,
        ajax: {
            url:'{{ route("datatable_sjt") }}',
        },
        columnDefs: [
          {
             targets: 5,
             className: 'center'
          }
        ],
        "columns": [
        { "data": "nomor" },
        { "data": "tanggal" },
        { "data": "kode_rute" },
        { "data": "nama_rute"},
        { "data": "cabang" },
        { "data": "aksi" },
        
        ]
    });


    $(document).on("click","#btn_add_order",function(){
        window.location.href = baseUrl + '/sales/surat_jalan_trayek_form'
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });


    $(document).on( "click",".btnhapus", function(){
        if(!confirm("Hapus Data ?")) return false;
    });


</script>
@endsection
