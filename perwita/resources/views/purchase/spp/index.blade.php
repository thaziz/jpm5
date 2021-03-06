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



      <div class="col-md-12 col-sm-12 col-xs-12">

              <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="tebal">Cabang</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                   <select class="cabang form-control chosen-select-width kosong" name="cabang" id="cabang">
                    @if(Auth::user()->punyaAkses('Surat Permintaan Pembelian','all')){
                     <option value="">---Pilih Cabang----</option>
                    @endif
                     @foreach($data as $cabang)
                     <option value="{{$cabang->kode}}">{{$cabang->nama}}</option>
                     @endforeach
                   </select>
                </div>
              </div>
      </div>


    </form>
</div>






            <div class="col-xs-12">

              <div class="box" id="seragam_box">


                <div class="box-body">

                  <table width="100%" id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                       <th style="width:5%"> No </th>
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
              "url": "{{ url("suratpermintaanpembelian/table") }}",
              "type": "get",
              data: {
                    "_token": "{{ csrf_token() }}",
                    "tanggal1" :$('#tanggal1').val(),
                    "tanggal2" :$('#tanggal2').val(),
                    "nosupplier" :$('#nosupplier').val(),
                    "idjenisbayar" :$('#idjenisbayar').val(),
                    "nofpg" :$('#nofpg').val(),
                    "cabang" :$('#cabang').val(),
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

            ],  
            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
             "bFilter": false,
    



    });
   notif();
}


 $('#addColumn_filter input[type=search]').keyup( function () {  
        var table = $('#addColumn').DataTable(); 
        table.search(
            jQuery.fn.DataTable.ext.type.search.html(this.value)
        ).draw();
    } );

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
