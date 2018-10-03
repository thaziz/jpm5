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
  .tengah:{
    text-align: center !important;
  }
  .kanan:{
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
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('sales/form_tanda_terima_penjualan/create')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
                    </div>
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
              
              <div class="box">
                <div class="box-body">
                  <div class="col-sm-12">
                    <table id="addColumn" class="table table-bordered table-striped table_tt ">
                      <thead style="color: white">
                        <tr>
                          <th>No</th>
                          <th>Nomor</th>
                          <th>Cabang</th>
                          <th>Tanggal</th>
                          <th>Tanggal Terima</th>
                          <th>Jatuh Tempo</th>
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


var tablex;
setTimeout(function () {            
   table();
   
      }, 1500);

     function table(){
   $('#addColumn').dataTable().fnDestroy();
   tablex = $("#addColumn").DataTable({        
         responsive: true,
        "language": dataTableLanguage,
    processing: true,
            serverSide: true,
            ajax: {
              "url":'{{ route("tt_penjualan") }}',
              "type": "get",
              data: {
                    "_token": "{{ csrf_token() }}",                    
                    "tanggal1" :$('#tanggal1').val(),
                    "tanggal2" :$('#tanggal2').val(),
                    "nomor" :$('#nomor').val(),
                    },
              },
             columnDefs: [
              {
                 targets: 0,
                 className: 'tengah'
              },
              {
                 targets: 3,
                 className: 'kanan'
              },
              {
                 targets: 5,
                 className: 'tengah'
              },
              {
                 targets:6,
                 className: 'tengah'
              },
            ],
            "columns": [
            { "data": "DT_Row_Index",},
            { "data": "ft_nota" },
            { "data": "cabang" },
            { "data": "tanggal_buat"},
            { "data": "ft_tanggal_terima"},
            { "data": "ft_jatuh_tempo"},
            { "data": "ft_total",render: $.fn.dataTable.render.number( '.', '.', 0, '' )},
            { "data": "nama" },
            { "data": "print" },
            { "data": "aksi" },
            ],
            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
            "bFilter": false,
            "responsive": false,
           /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html(index + 1);
            }*/



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

/*
  $(document).ready(function(){
    $('.table_tt').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            // sorting: false,
            ajax: {
                url:'{{ route("tt_penjualan") }}',
            },
            columnDefs: [
              {
                 targets: 0,
                 className: 'tengah'
              },
              {
                 targets: 3,
                 className: 'kanan'
              },
              {
                 targets: 5,
                 className: 'tengah'
              },
              {
                 targets:6,
                 className: 'tengah'
              },
            ],
            "columns": [
            { "data": "DT_Row_Index",},
            { "data": "ft_nota" },
            { "data": "cabang" },
            { "data": "tanggal_buat"},
            { "data": "ft_tanggal_terima"},
            { "data": "ft_jatuh_tempo"},
            { "data": "ft_total",render: $.fn.dataTable.render.number( '.', '.', 0, '' )},
            { "data": "nama" },
            { "data": "print" },
            { "data": "aksi" },
            ]
        }); 
        $('td .kanan').css('text-align','right');
        $('td .tengah').css('text-align','center');

  })*/

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
          url:'{{ route('hapus_tt_penjualan') }}',
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
                         var table = $('.table_tt').DataTable();
                         table.ajax.reload();
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

function printing(id)
{
  window.open('{{ url('sales/form_tanda_terima_penjualan/printing') }}'+'/'+id);
}
</script>
@endsection
