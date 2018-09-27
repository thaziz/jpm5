@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Surat Permintaan Pembelian </h2>
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
                            <strong> Surat Permintaan Pembelian </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

  <div class="wrapper wrapper-content animated fadeInRight">
   
   <!--  <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-danger alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style='text-align:center'> <b> {{$data['belumdiproses']}} SPP </b></h2> <h4 style='text-align:center'> Belum di proses Staff Pembelian </h4>
      </div>
    </div>

     <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-success alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      <h2 style='text-align:center'> <b> {{$data['statuskabag']}} SPP  </b></h2> <h4 style='text-align:center'> Belum di ketahui oleh Kepala Cabang </h4>
      </div>
    </div>

    <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-success alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      <h2 style='text-align:center'> <b> {{$data['disetujui']}} SPP  </b></h2> <h4 style='text-align:center'> DISETUJUI oleh Staff Keuangan </h4>
      </div>
    </div>

    <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-warning alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style='text-align:center'> <b> {{$data['masukgudang']}} SPP  </b></h2> <h4 style='text-align:center'> <br> MASUK GUDANG  </h4>
      </div>
    </div>
    <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-info alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
         <h2 style='text-align:center'> <b> {{$data['selesai']}} SPP  </b></h2> <h4 style='text-align:center'> <br> SELESAI </h4>
      </div>
    </div> -->

<div id="notif"></div>

    </div>




<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Surat Permintaan Pembelian
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>

                         @if(Auth::user()->punyaAkses('Surat Permintaan Pembelian','tambah'))
                      <div class="text-right">
                       <a class="btn btn-sm btn-success" aria-hidden="true" href="{{ url('suratpermintaanpembelian/createspp')}}"> <i class="fa fa-plus"> Tambah Data Surat Permintaan Pembelian </i> </a> 
                       @endif
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
                
                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                       <th style="width:10px"> No </th>
                        <th> No SPP</th>
                        <th> Tanggal di Butuhkan </th>
                        <th> Cabang </th>
                        <th> Keperluan </th>
                        <th> Bagian </th>
                        <th> Status </th>
                        <th style="width:90px"> Detail </th>
                        <th> Status Kabag </th>
                    </tr>
                 
                    </thead>
                    
<<<<<<< HEAD
                 
=======
                    <tbody>
                    @foreach($data['spp'] as $index=>$spp)
                    <tr>
                      <td> {{$index + 1}}  </td>
                      <td> <a href="{{url('suratpermintaanpembelian/detailspp/'. $spp->spp_id .'')}}"> {{$spp->spp_nospp}} </a> </td>
                      <td> {{ Carbon\Carbon::parse($spp->spp_tgldibutuhkan)->format('d-M-Y ') }} </td>
                      <td>{{ $spp->nama }}</td>
                      <td>{{ $spp->spp_keperluan}} </td>
                      <td> {{$spp->nama_department}} </td>
                      <td>

                      @if($spp->spp_status == 'DISETUJUI')
                         <span class="label label-info"> <!-- <a href="{{url('suratpermintaanpembelian/statuspp/'.$spp->spp_id.'')}}" stye="color:black"> --> DISETUJUI </a></span>
                      @elseif($spp->spp_status == 'DITERIMA')
                          <span class="label label-warning"><!--  <a href="{{url('suratpermintaanpembelian/statuspp/'.$spp->spp_id.'')}}" stye="color:black"> -->  DITERIMA </span>
                      @elseif($spp->spp_status == 'DITOLAK')
                            <span class="label label-danger"> <!-- <a href="{{url('suratpermintaanpembelian/statuspp/'.$spp->spp_id.'')}}" stye="color:black">  -->{{$spp->spp_status}} </span>
                      @else 
                            <span class="label label-default"> <!-- <a href="{{url('suratpermintaanpembelian/statuspp/'.$spp->spp_id.'')}}" stye="color:black">  -->{{$spp->spp_status}} </span>
                      @endif
                          </td>

                      <td> <div class="row">
                      <div class="col-md-3">

                   
                      @if($spp->spp_status == 'DITERBITKAN')
                         @if(Auth::user()->punyaAkses('Surat Permintaan Pembelian','hapus'))
                           <a href="#" class="btn btn-sm btn-danger" onclick="hapusData('{{$spp->spp_id}}')"> <i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
                            
                                &nbsp;
                         @endif

                         @if(Auth::user()->punyaAkses('Surat Permintaan Pembelian' , 'ubah'))
                           &nbsp; <a class="btn btn-sm btn-warning" href="{{url('suratpermintaanpembelian/editspp/'.$spp->spp_id.'')}}"> <i class="fa fa-pencil" aria-hidden="true"></i>  </a>
                        @endif

                      @endif

                        @if(Auth::user()->punyaAkses('Surat Permintaan Pembelian','print'))
        
                          <a class="btn btn-sm btn-success" href="{{url('suratpermintaanpembelian/cetakspp/'.$spp->spp_id.'')}}"> <i class="fa fa-print" aria-hidden="true"></i>  </a>  </div> 
                          @endif

                       
                      </td>
                      

                      <td>
                        @if($spp->spp_statuskabag == 'BELUM MENGETAHUI')
                        <span class="label label-info"> <i class="fa fa-close"> </i> {{$spp->spp_statuskabag}} </span>
                        @elseif($spp->spp_statuskabag == 'SETUJU')
                        <span class="label label-info"> <i class="fa fa-check"> </i> {{$spp->spp_statuskabag}}
                        @endif
                      </td>
                    </tr>
                   @endforeach


                    </tbody>
>>>>>>> 3ea18070a7112d9c7393c48e8e03dbc2a5ee0538
                   
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




dateAwal();
var tablex;
table();
     function table(){
   $('.tbl-item').dataTable().fnDestroy();
   tablex = $(".tbl-item").DataTable({        
         responsive: true,
        "language": dataTableLanguage,
    processing: true,
            serverSide: true,
            ajax: {
              "url": "{{ url("suratpermintaanpembelian/table") }}",
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
            {data: 'detailspp', name: 'detailspp'},                           
            {data: 'spp_tgldibutuhkan', name: 'spp_tgldibutuhkan'},   
            {data: 'nama', name: 'nama'},
            {data: 'spp_keperluan', name: 'spp_keperluan'},
            {data: 'nama_department', name: 'nama_department'},   


            {data: 'spp_status', name: 'spp_status'},            
            {data: 'spp_cabang', name: 'spp_cabang'},                        
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



    $('.date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    
    function kabag(){

    }

      
    function hapusData(id){
   
            swal({
            title: "apa anda yakin?",
                    text: "data yang dihapus tidak akan dapat dikembalikan",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya, Hapus!",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
            },
                    function(){                        
                    $('#' +id).submit();
                    swal("Terhapus!", "Data Anda telah terhapus.", "success");
                    });
            }




function dateAwal(){
      var d = new Date();
      d.setDate(d.getDate()-7);

      /*d.toLocaleString();*/
      $('#tanggal1').datepicker({
            format:"dd-mm-yyyy",        
            autoclose: true,
      }).datepicker( "setDate", d);
      $('#tanggal2').datepicker({
            format:"dd-mm-yyyy",        
            autoclose: true,
      }).datepicker( "setDate", new Date());
      $('.kosong').val('');
      $('.kosong').val('').trigger('chosen:updated');
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
      url:baseUrl + '/suratpermintaanpembelian/notif',
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
