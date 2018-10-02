@extends('main')

@section('title', 'dashboard')

@section('content')

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Form Permintaan Cek / BG (FPG) </h2>
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
                            <strong> Form Permintaan Cek / BG (FPG) </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

<div class="wrapper wrapper-content animated fadeInRight">
<div id="notif"></div>
     <!-- <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-danger alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style='text-align:center'> <b> {{$data['belumdiproses']}} Data </b></h2> <h4 style='text-align:center'> Belum di Posting Bank Keluar </h4>
      </div>
    </div>

     <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-success alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      <h2 style='text-align:center'> <b> {{$data['sudahdiproses']}} Data  </b></h2> <h4 style='text-align:center'> Sudah di Posting Bank Keluar </h4>
      </div>
    </div>
 -->


    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Form Permintaan Cek / BG (FPG)
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                         @if(Auth::user()->punyaAkses('Form Permintaan Giro','tambah'))
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('formfpg/createformfpg')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
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



      <div class="col-md-12 col-sm-12 col-xs-12">
             


              <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="tebal">Jenis Bayar</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">

                    <select class="form-control chosen-select-width kosong" name="idjenisbayar" id="idjenisbayar">
                      <option value="">Pilih Jenis Bayar</option>
                      @foreach($data['jenisBayar'] as $jenisByr)
                      <option value="{{$jenisByr->idjenisbayar}}">{{$jenisByr->jenisbayar}}</option>
                      @endForeach
                    </select>
                </div>
              </div>



              <div class="col-md-1 col-sm-3 col-xs-12">
                <label class="tebal">Supplier</label>
              </div>

              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">

                     <select class="form-control chosen-select-width kosong" name="nosupplier" id="nosupplier">
                     <option value="">Pilih Supplier</option>
                      @foreach($data['supplier'] as $supplier)
                      <option value="{{$supplier->idsup}}">{{$supplier->no_supplier}} - {{$supplier->nama_supplier}}</option>
                      @endForeach
                    </select>
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

                 {{--  <table class="table table-bordered" style="width:60%">
                    <tr>
                        <td style="width:40%"> No FPG </td> <td style="width:5%"> : </td> <td> </td>
                    </tr>
                    <tr>
                        <td> Jenis Bayar </td> <td> : </td> <td> </td>
                    </tr>
                    <tr>
                        <td> Tanggal </td> <td> : </td> <td> </td>
                    </tr>
                    <tr>
                      <td colspan="3"> <button class="btn btn-success btn-md"> <i class="fa fa-search"> </i> Cari </button> </td>
                    </tr>
                  </table> --}}


                  <table style="width: 100%" id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead>
                     <tr>
                        <th  style="width:5%">No </th>
                        <th style="width:10%"> No FPG </th>
                        <th style="width:10%"> Tanggal </th>
                        <th style="width:10%"> Jenis Bayar </th>
                        <th style="width:20%"> Keterangan </th>
                        <th style="width:10%"> Total Bayar </th>
                        <th style="width:10%"> Uang Muka  </th>
                        <th style="width:10%"> Cek / BG  </th>                      
                        <th style="width:10%"> Detail </th>                     
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
/*
     tableDetail = $('.tbl-penerimabarang').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });*/

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
              "url": "{{ url("formfpg/formfpg/table") }}",
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
            {data: 'fpg_nofpg', name: 'fpg_nofpg'},                           
            {data: 'fpg_tgl', name: 'fpg_tgl'},            
            {data: 'jenisbayar', name: 'jenisbayar'},
            {data: 'fpg_keterangan', name: 'fpg_keterangan'},
            {data: 'fpg_totalbayar', name: 'fpg_totalbayar'},            
            {data: 'uangmuka', name: 'uangmuka'},            
            {data: 'fpg_cekbg', name: 'fpg_cekbg'},                        
            {data: 'action', name: 'action'},                        
          /*  {data: 's_gross', name: 's_gross'}, 
            {data: 's_disc_percent', name: 's_disc_percent'}, 
            {data: 's_ongkir', name: 's_ongkir'},
            {data: 's_net', name: 's_net'},            
            {data: 's_status', name: 's_status'}, 
            {data: 'action', name: 'action'},
            */
           
            ],
            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
            "bFilter": false,
           /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html(index + 1);
            }*/



    });
   notif();
}






    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
  
    
     function hapusdata(id){
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
      url:baseUrl + '/formfpg/hapusfpg/' + id,
      type:'get',
      dataType : 'json',
      success:function(data){

        if(data.status == "sukses") {
          swal({
            title: "Berhasil!",
                    type: 'success',
                    text: "Data Berhasil Dihapus",
                    timer: 2000,
                    showConfirmButton: true
                    },function(){
                       location.reload();
            });
        }
        else if(data.status == "gagal") {
       
          swal({
            title: "ERROR!",
                    type: 'error',
                    text: data.info,
                    timer: 2000,
                    showConfirmButton: true
                    })
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
      /*.datepicker( "setDate", new Date());      */
      $('.kosong').val('').trigger('chosen:updated');
      $('.kosong').val('');      
}

 function cari(){
  table();  
 }

 function resetData(){  
  $('#tanggal1').val('');
  $('#tanggal2').val('');  
  /*$('#nofpg').val('');*/
  $('.kosong').val('');      
  $('.kosong').val('').trigger('chosen:updated');
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
</script>
@endsection
