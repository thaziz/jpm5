@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Pelunasan Hutang / Pembayaran Bank </h2>
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
                            <strong> Pelunasan Hutang / Pembayaran Bank </strong>
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
                    <h5> Pelunasan Hutang / Pembayaran Bank
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                         @if(Auth::user()->punyaAkses('Pelunasan Hutang','tambah'))
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('pelunasanhutangbank/createpelunasanbank')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
                    </div>
                    @endif
                </div>
                <div class="ibox-content">


<div class="row" >
   <form method="post" id="dataSeach">
      <div class="col-md-12 col-sm-12 col-xs-12">
              
               <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="tebal">No FPG</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <input class="form-control kosong" type="text" name="nofpg" id="nofpg" placeholder="No FPG">
                </div>
              </div>


            
              <div class="col-md-1 col-sm-3 col-xs-12">
                <label class="tebal">Tanggal</label>
              </div>

              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <div class="input-daterange input-group">
                    <input id="tanggal1" class="kosong form-control input-sm datepicker2" name="tanggal1" type="text">
                    <span class="input-group-addon">-</span>
                    <input id="tanggal2" "="" class="kosong input-sm form-control datepicker2" name="tanggal2" type="text">
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



      <div class="col-md-12 col-sm-12 col-xs-12">
            
              <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="tebal">Bank</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <input class="kosong form-control" type="" name="bank" id="bank">
                </div>
              </div>



              <div class="col-md-1 col-sm-3 col-xs-12">
                <label class="tebal">Biaya</label>
              </div>

              <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="form-group">
                     <input class="kosong form-control" type="" name="biaya" id="biaya">
                </div>
              </div>

              <div class="col-md-1 col-sm-3 col-xs-12">
                <label class="tebal">Total</label>
              </div>

              <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="form-group">
                     <input class="kosong form-control" type="" name="total" id="total">
                </div>
              </div>

    </div>
    </form>
</div>




                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
               
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                </div>        
                    
                <div class="box-body">
                  <table width="100%" id="addColumn" class="table table-bordered table-stripped tbl-penerimabarang">
                    <thead>
                     <tr>
                        <th style="width:10px">  NO  </th>
                        <th>  No Bank </th>
                        <th> Nota FPG </th>
                        <th>  Bank  </th>
                        <th> Tanggal </th>
                        <th> Keterangan </th>
                        <th> Cek / BG </th>
                        <th> Biaya </th>
                        <th> Total </th>
                        <th> Detail </th>
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
   tablex = $("#addColumn").DataTable({        
         responsive: true,
        "language": dataTableLanguage,
    processing: true,
            serverSide: true,
            ajax: {
              "url": "{{ url("pelunasanhutangbank/pelunasanhutangbank/table") }}",
              "type": "get",
              data: {                
                    "_token": "{{ csrf_token() }}",                    
                    "tanggal1" :$('#tanggal1').val(),
                    "tanggal2" :$('#tanggal2').val(),
                    "biaya" :$('#biaya').val(),
                    "total" :$('#total').val(),
                    "bank" :$('#bank').val(),
                    "nofpg" :$('#nofpg').val(),
                    },
              },
            columns: [            
            {data: 'no', name: 'no'},             
            {data: 'bbk_nota', name: 'bbk_nota'},                           
            {data: 'fpg_nofpg', name: 'fpg_nofpg'},     
            {data: 'mb_nama', name: 'mb_nama'},            
            {data: 'bbk_tgl', name: 'bbk_tgl'},
            {data: 'bbk_keterangan', name: 'bbk_keterangan'},
            {data: 'bbk_cekbg', name: 'bbk_cekbg'},            
            {data: 'bbk_biaya', name: 'bbk_biaya'},            
            {data: 'bbk_total', name: 'bbk_total'},                        
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
  $('.kosong').val('');
  $('.kosong').val('').trigger('chosen:updated');
  $('#tanggal1').val('');
  $('#tanggal2').val('');  
  table();
  dateAwal();
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

$('#biaya').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
$('#total').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
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
      url:baseUrl + '/pelunasanhutangbank/hapuspelunasanhutang/'+id,
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
