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
  .sorting_asc{
    background: pink !important;
  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
      <h2> Form Tanda Terima </h2>
      <ol class="breadcrumb">
          <li>
              <a>Home</a>
          </li>
          <li>
              <a>Purchase</a>
          </li>
          <li>
            <a>Transaksi Hutang</a>
          </li>
          <li class="active">
              <strong>Form Tanda Terima Pembelian</strong>
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
                    <h5> Form Tanda Terima
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('form_tanda_terima_pembelian/create')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
                <div class="box-body">
                  <div class="col-sm-12">
                    <table class="table table-bordered table-striped table_tt ">
                      <thead style="color: white">
                        <tr>
                          <th>No</th>
                          <th>Nomor</th>
                          <th>Tanggal</th>
                          <th>Total Terima</th>
                          <th>Kode Pihak Ketiga</th>
                          <th>Print</th>
                          <th>Aksi</th>
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



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

  $(document).ready(function(){
    $('.table_tt').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            // sorting: false,
            ajax: {
                url:'{{ route("datatable_form_tt") }}',
            },
            columnDefs: [
              {
                 targets: 0,
                 className: 'center'
              },
              {
                 targets: 3,
                 className: 'right'
              },
              {
                 targets: 5,
                 className: 'center'
              },
              {
                 targets:6,
                 className: 'center'
              },
            ],
            "columns": [
            { "data": "DT_Row_Index" },
            { "data": "tt_noform" },
            { "data": "tt_tgl" },
            { "data": "tt_totalterima"},
            { "data": "tt_supplier" },
            { "data": "print" },
            { "data": "aksi" },
            ]
        });

  })

</script>
@endsection
