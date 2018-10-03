@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> UANG MUKA PEMBELIAN </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Operasional</a>
                        </li>
                        <li>
                          <a>Pembelian</a>
                        </li>
                        <li>
                          <a>Transaksi Hutang</a>
                        </li>
                        <li class="active">
                            <strong>Uang Muka Pembelian</strong>
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
                    <h5> 
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                            @if(Auth::user()->punyaAkses('Uang Muka','tambah'))
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('uangmuka/create')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
                    </div>
                    @endif
                </div>
                <div class="ibox-content">



<div class="row" >
   <form method="post" id="dataSeach">
      <div class="col-md-12 col-sm-12 col-xs-12">

              <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="tebal">Nomor</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <input class="form-control kosong" type="text" name="nomor" id="nomor" placeholder="Nomor">
                </div>
              </div>



              <div class="col-md-1 col-sm-3 col-xs-12">
                <label class="tebal">Tanggal</label>
              </div>

              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <div class="input-daterange input-group">
                    <input id="tanggal1" class="form-control input-sm datepicker2" name="tanggal1" type="text">
                    <span class="input-group-addon">-</span>
                    <input id="tanggal2" "="" class="input-sm form-control datepicker2" name="tanggal2" type="text">
                  </div>
                </div>
              </div>


              <div class="col-md-2 col-sm-6 col-xs-12" align="center">
                <button class="btn btn-primary btn-sm btn-flat" title="Cari rentang tanggal" type="button" onclick="cari()">
                  <strong>
                    <i class="fa fa-search" aria-hidden="true"></i>
                  </strong>
                </button>
                <button class="btn btn-info btn-sm btn-flat" type="button" title="Reset" onclick="resetData()">
                  <strong>
                    <i class="fa fa-undo" aria-hidden="true"></i>
                  </strong>
                </button>
              </div>
      </div>



 


    </form>
</div>




                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                </div>        
                <div class="box-body">
                  <table width="100%" id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead>
                     <tr>
                        <th style="width:5px">No.</th>
                        <th> No Bukti </th>
                        <th> Tanggal </th>
                        <th> Supplier </th>                    
                        <th> Jumlah </th>
                        <th> Aksi  </th>
                    </tr>
                    </thead>
                   
                   
                    
                   
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                 
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
   
var tablex;
setTimeout(function () {            
   table();
   tablex.on('draw.dt', function () {
    var info = tablex.page.info();
    tablex.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1 + info.start;
    });
});

      }, 1500);




     function table(){
   $('#addColumn').dataTable().fnDestroy();
   tablex = $('#addColumn').DataTable({        
         responsive: true,
        "language": dataTableLanguage,
    processing: true,
            serverSide: true,
            ajax: {
              "url": "{{ url("uangmuka/table") }}",
              "type": "get",
              data: {
                    "_token": "{{ csrf_token() }}",
                    "tanggal1" :$('#tanggal1').val(),
                    "tanggal2" :$('#tanggal2').val(),                 
                    "nomor" :$('#nomor').val(),
                    },
              },
            columns: [
            { "data": "no" },
            { "data": "um_nomorbukti" },
            { "data": "um_tgl" },
            { "data": "um_supplier"},
            { "data": "um_jumlah" },            
            { "data": "action" },
            ],  
              columnDefs: [
              {
                 targets: 0,
                 className: 'center'
              },
            ],
            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
            "bFilter": false,
            "responsive": false,
    


                   



    });   
}



dateAwal();
function dateAwal(){
      var d = new Date();
      d.setDate(d.getDate()-7);

      /*d.toLocaleString();*/
      $('#tanggal1').datepicker({
            format:"dd-mm-yyyy",
            autoclose: true,
      })
      /*.datepicker( "setDate", d);*/
      $('#tanggal2').datepicker({
            format:"dd-mm-yyyy",
            autoclose: true,
      })
      /*.datepicker( "setDate", new Date());*/
      $('.kosong').val('');
      $('.kosong').val('').trigger('chosen:updated');
}

 function cari(){
  table();
 }

 function resetData(){
  $('#tanggal1').val('');
  $('#tanggal2').val('');
  $('.kosong').val('');
  table();
  dateAwal();
}

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
    

</script>
@endsection
