@extends('main')

@section('title', 'dashboard')

@section('content')


<style type="text/css">
  .center{
    text-align: center;
  }

  .right{
    text-align: right;
  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Faktur Pembelian </h2>
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
                            <strong>  Faktur Pembelian </strong>
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
                    <h5> Faktur Pembelian
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     @if(Auth::user()->PunyaAkses('Faktur Pembelian','tambah'))
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('fakturpembelian/createfatkurpembelian')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
                    </div>
                    @endif
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
               
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                    
                <div class="box-body">
                  <table cellpadding="3" cellspacing="0" border="0" class="table filter table-bordered">
                        <tr>
                            <td align="center">Tanggal Awal</td>
                            <td align="center">
                              <input type="text" class="min form-control date" name="min">
                            </td>
                            <td align="center">Tanggal Akhir</td>
                            <td align="center">
                              <input type="text" class="max form-control date" name="max">
                            </td>
                        </tr>
                        <tr>
                            <td align="center">Jenis Faktur</td>
                            <td align="left">
                              <select class="jenis_faktur form-control chosen-select-width" >
                                <option value="">Pilih - Jenis</option>
                                @foreach ($jenis as $val)
                                  <option value="{{ $val->idjenisbayar }}">{{ $val->jenisbayar }}</option>
                                @endforeach
                              </select>
                            </td>
                            <td align="center">Pihak Ketiga</td>
                            <td align="left">
                              <select class="pihak_ketiga form-control chosen-select-width" >
                                <option value="">Pilih - Pihak</option>
                                @foreach ($all as $val)
                                  <option value="{{ $val->kode }}">{{ $val->kode }} - {{ $val->nama }}</option>
                                @endforeach
                              </select>
                            </td>
                        </tr>
                        @if (Auth::user()->PunyaAkses('Faktur Pembelian','cabang'))
                          <tr>
                            <td align="center">Cabang</td>
                            <td align="left">
                              <select class="cabang form-control chosen-select-width" >
                                <option value="">Pilih - Cabang</option>
                                @foreach ($cabang as $val)
                                  <option value="{{ $val->kode }}">{{ $val->nama }}</option>
                                @endforeach
                              </select>
                            </td>
                            <td align="center">Cari Berdasarkan Nota</td>
                            <td align="center">
                              <input type="text" class="nota form-control" name="nota">
                            </td>
                          </tr>
                        @else
                        <tr>
                            <td align="center">Cabang</td>
                            <td align="left">
                              <select class="cabang form-control chosen-select-width" >
                                <option value="">Pilih - Cabang</option>
                                @foreach ($cabang as $val)
                                  <option @if (Auth::user()->kode_cabang == $val->kode)
                                    selected="" 
                                  @endif value="{{ $val->kode }}">{{ $val->nama }}</option>
                                @endforeach
                              </select>
                            </td>
                            <td align="center">Cari Berdasarkan Nota</td>
                            <td align="center">
                              <input type="text" class="nota form-control" name="nota">
                            </td>
                        </tr>
                        @endif
                        <tr>
                          <td align="right" colspan="4">
                            <button class="search btn btn-danger" type="button" onclick="filtering()"><i class="fa fa-search"> Cari</i></button>
                            <button class=" btn btn-warning jurnal_all" type="button" ><i class="fa fa-eye"></i></button>
                          </td>
                        </tr>
                    </table>
                  <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead align="center">
                     <tr>
                        <th style="width:10px">No</th>
                        <th> No Faktur </th>
                        <th> Tanggal </th>
                        <th> Jenis Faktur </th>
                        <th> Pihak Ketiga </th>
                        <th> No Invoice </th>
                        <th> Total </th>
                        <th> Status </th>
                        <th> Detail </th>
                        <th> Pelunasan </th>
                        <!-- <th> Allow Edit</th> -->
                        <th> Aksi </th>   
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
            </div>
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

     $(document).ready( function () {

         $('.tbl-penerimabarang').DataTable({
          searching:false,
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route("datatable_faktur_pembelian") }}',
                data:{min: function() { return $('.min').val()},
                      max: function() { return $('.max').val()},
                      cabang: function() { return $('.cabang').val()},
                      jenis: function() { return $('.jenis_faktur').val()},
                      customer: function() { return $('.pihak_ketiga').val() },
                      nomor : function() { return $('.nota ').val() }}
            },
            columnDefs: [
              {
                 targets: 0,
                 className: 'center'
              },
              {
                 targets:6,
                 className: 'right'
              },
              {
                 targets:7,
                 className: 'center'
              },
              {
                 targets:8,
                 className: 'center'
              },
              {
                 targets:9,
                 className: 'center'
              },
              {
                 targets:10,
                 className: 'center'
              },
            
            ],
            "columns": [
            {data: 'DT_Row_Index', name: 'DT_Row_Index'},
            { "data": "fp_nofaktur" },
            { "data": "fp_tgl" },
            { "data": "jenis_faktur"},
            { "data": "pihak_ketiga"},
            { "data": "fp_noinvoice" },
            { "data": "fp_netto", render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
            { "data": "status" },
            { "data": "detail" },
            { "data": "lunas" },
            { "data": "aksi" },
            
            ]
      });
      $.fn.dataTable.ext.errMode = 'throw';
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
  function filtering() {
    table = $('.tbl-penerimabarang').DataTable();
    table.ajax.reload();
  }
    

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
      url:baseUrl + '/fakturpembelian/hapusbiayapenerus/'+id,
      type:'get',
      success:function(data){
        console.log(data.status);
        if(data.status == '1'){
          swal({
          title: "Berhasil!",
                  type: 'success',
                  text: "Data Berhasil Dihapus",
                  timer: 2000,
                  showConfirmButton: true
                  },function(){
                     location.reload();
          });
        }else if(data.status == 3){
         swal({
            title: "Gagal Hapus!",
            type: 'error',
            text: data.pesan,
            timer: 2000,
            },function(){

          });
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
    
  
   function hapusData(id){
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
      url:baseUrl + '/fakturpembelian/hapusfakturpembelian/'+id,
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
