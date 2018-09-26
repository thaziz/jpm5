  @extends('main')

@section('title', 'dashboard')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Konfirmasi Order </h2>
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
                            <strong> Konfirmasi Order </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>


<div class="wrapper wrapper-content animated fadeInRight">

    <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-danger alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style='text-align:center'> <b> {{$data['pembelian'][0]->count}} SPP </b></h2> <h4 style='text-align:center'> Belum di proses Staff Pembelian </h4>
      </div>
    </div>

     <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-success alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      <h2 style='text-align:center'> <b> {{$data['keuangan'][0]->count}} SPP  </b></h2> <h4 style='text-align:center'> Belum di proses Keuangan </h4>
      </div>
    </div>


    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Daftar Surat Permintaan Pembelian
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        
                    </div>
                </div>
      <div class="ibox-content">
              <div class="row">





<div class="row" >
   <form method="post" id="dataSeach">
      <div class="col-md-12 col-sm-12 col-xs-12">
              
              <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="tebal">No SPP</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <input class="form-control kosong" type="text" name="nofpg" id="nofpg" placeholder="No SPP">
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


















            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                    
                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped konfirmasi">
                    <thead>
                     <tr>
                        <th style="width:10px">No</th>
                        <th> No SPP </th>
                        <th> Cabang Pemohon </th>
                        <th> Tanggal di butuhkan </th>
                        <th> Status Pembelian </th>
                        <th> Status Keuangan </th>
                        <th> </th>
                       
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

   

    $('.date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });


    dateAwal();
var tablex;
table();
     function table(){
   $('.konfirmasi').dataTable().fnDestroy();
   tablex = $(".konfirmasi").DataTable({        
         responsive: true,
        "language": dataTableLanguage,
    processing: true,
            serverSide: true,
            ajax: {
              "url": "{{ url("konfirmasi_order/konfirmasi_order/table") }}",
              "type": "get",
              data: {
                    "_token": "{{ csrf_token() }}",                    
                    "tanggal1" :$('#tanggal1').val(),
                    "tanggal2" :$('#tanggal2').val(),
                    "nosupplier" :$('#nosupplier').val(),
                    "idjenisbayar" :$('#idjenisbayar').val(),
                    "nofpg" :$('#nofpg').val(),
                    },
              },



            columns: [
            {data: 'no', name: 'no'},             
            {data: 'spp_nospp', name: 'spp_nospp'},                                       
            {data: 'spp_cabang', name: 'spp_cabang'},
            {data: 'spp_tgldibutuhkan', name: 'spp_tgldibutuhkan'},            
            {data: 'staff_pemb', name: 'staff_pemb'},
            {data: 'man_keu', name: 'man_keu'},                            
            {data: 'action', name: 'action'},                        
           
            ],
            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
           /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html(index + 1);
            }*/



    });
   notif();
}

tablex.on('draw.dt', function () {
    var info = tablex.page.info();
    tablex.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1 + info.start;
    });
});


function dateAwal(){
      var d = new Date();
      d.setDate(d.getDate()-7);
      $('#tanggal1').datepicker({
            format:"dd-mm-yyyy",        
            autoclose: true,
      }).datepicker( "setDate", d);
      $('#tanggal2').datepicker({
            format:"dd-mm-yyyy",        
            autoclose: true,
      }).datepicker( "setDate", new Date());
      $('.kosong').val('');
}

 function cari(){
  table();  
 }

 function resetData(){  
  dateAwal();
  table();
}  

    
function notif(){
   $.ajax({
      url:baseUrl + '/formfpg/formfpg/notif',
      type:'get',   
       data: {
                    "_token": "{{ csrf_token() }}",                    
                    "tanggal1" :$('#tanggal1').val(),
                    "tanggal2" :$('#tanggal2').val(),
                    "nosupplier" :$('#nosupplier').val(),
                    "idjenisbayar" :$('#idjenisbayar').val(),
                    "nofpg" :$('#nofpg').val(),
                    },   
      success:function(data){
        $('#notif').html(data);
    }
  });
}

</script>
@endsection
