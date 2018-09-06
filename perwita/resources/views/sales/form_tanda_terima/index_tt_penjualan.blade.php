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

  })

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
