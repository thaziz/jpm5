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
  td .center:{
    text-align: center !important;
  }
  td .right:{
    text-align: right !important;
  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
      <h2> Pembayaran Kas </h2>
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
              <strong> Kas Keluar</strong>
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
                    <h5> Pembayaran Kas
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
               
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                    
                <div class="box-body">
                  <div class="col-sm-12" style="margin-bottom: 20px">
                    <table cellpadding="3" cellspacing="0" border="0" class="table filter table-bordered">
                        <tr>
                            <td align="center">Tanggal Awal</td>
                            <td align="center">
                              <input type="text" class="tanggal_awal form-control date" name="tanggal_awal">
                            </td>
                            <td align="center">Tanggal Akhir</td>
                            <td align="center">
                              <input type="text" class="tanggal_akhir form-control date" name="tanggal_akhir">
                            </td>
                        </tr>
                        <tr id="filter_col1" data-column="0">
                          @if (Auth::user()->punyaAkses('Pengembalian Bonsem','cabang')) 
                            <td align="right" colspan="2">Cabang</td>
                            <td align="center" >
                              <select class="form-control cabang chosen-select-width" onchange="filtering()" name="cabang">
                                <option value="0">Pilih - Cabang </option>
                                @foreach ($cabang as $a)
                                  <option value="{{$a->kode}}">{{$a->kode}} - {{$a->nama}}</option>
                                @endforeach
                              </select>
                            </td>
                          @else
                          <td colspan="3"></td>
                          @endif
                          <td align="center"></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="right">
                            Cari Berdasarkan Nota
                          </td>
                          <td>
                            <input type="text" class="nota form-control" name="nota">
                            <input type="hidden" class="flag form-control" name="flag">
                          </td>
                          <td align="center">
                            <button class="search btn btn-success" type="button" onclick="filtering_nota()"><i class="fa fa-search"> Cari Berdasarkan Nota</i></button>
                            <button class="search btn btn-danger" type="button" onclick="filtering()"><i class="fa fa-search"> Cari</i></button>
                            <button class=" btn btn-warning jurnal_all" type="button" ><i class="fa fa-eye"></i></button>
                          </td>
                        </tr>
                    </table>
                  </div>
                  <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                      <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Bonsem</a></li>
                      <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">History</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="col-sm-12 append_table table-responsive" style="overflow-y: scroll;"> 
                          <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang" style="width: 100%"> 
                            <thead align="center">
                             <tr>
                                <th> No. BKK </th>
                                <th> Tanggal </th>
                                <th> Nama Cabang </th>
                                <th> Keperluan </th> 
                                <th> Total </th>   
                                <th> Status </th>
                                <th> Aksi </th>
                            </tr>
                            </thead>
                            <tbody>  
                              
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div role="tabpanel" class="tab-pane" id="profile">
                        <div class="col-sm-12 append_table table-responsive" style="overflow-y: scroll;">
                          <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang-history" style="width: 100%">
                            <thead align="center">
                             <tr>
                                <th> No. BKK </th>
                                <th> Tanggal Posting</th>
                                <th> Nama Cabang </th>
                                <th> Keterangan </th> 
                                <th> Total Kembali</th>   
                                <th> Bank Tujuan </th>   
                                <th> Status </th>
                                <th> Aksi </th>
                            </tr>
                            </thead>
                            <tbody>  
                              
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

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
</div>

<div class="modal modal_jurnal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width: 1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body tabel_jurnal table-responsive" >
          
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal pengembalian_modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width: 500px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Pengembalian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body " >
          <table class="table pengembalian_modal_table">
            <tr>
              <td>Akun Tujuan</td>
              <td>
                <select class="form-control akun_bank chosen-select-width" name="akun_bank" >
                    @foreach ($akun as $val)
                        <option value="{{$val->mb_id}}">{{$val->mb_kode}} - {{$val->mb_nama}}</option>
                    @endforeach
                </select>
              </td>
            </tr>
            @if(Auth::user()->punyaAkses('Pengembalian Bonsem','cabang'))
            <tr class="">
                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                <td class="cabang_td">
                    <select  class="form-control bp_cabang chosen-select-width" name="bp_cabang" >
                    @foreach ($cabang as $row)
                        @if(Auth::user()->kode_cabang == $row->kode)
                            <option selected="" value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                        @else
                            <option value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                        @endif
                    @endforeach
                    </select>
                </td>
            </tr>
            @else
            <tr class="">
                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                <td class="cabang_td disabled">
                    <select  class="form-control bp_cabang chosen-select-width" name="bp_cabang" >
                    @foreach ($cabang as $row)
                        @if(Auth::user()->kode_cabang == $row->kode)
                            <option selected="" value="{{ $row->kode }}"> {{ $row->nama }} </option>
                        @else
                            <option value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                        @endif
                    @endforeach
                    </select>
                </td>
            </tr>
            @endif
            <tr>
              <td>Keterangan</td>
              <td>
                <input type="text" class="form-control keterangan" name="keterangan">
                <input type="hidden" class="form-control bp_nota" name="bp_id">
              </td>
            </tr>
            <tr>
              <td>Tanggal</td>
              <td>
                <input type="text" class="date form-control tanggal" name="tanggal" value="{{ carbon\carbon::now()->format('Y-m-d') }}">
              </td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success save" data-dismiss="modal" onclick="save()">Lakukan Pengembalian</button>
      </div>
    </div>
  </div>
</div>
<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

$(document).ready(function(){

    $('.tbl-penerimabarang').DataTable({
         processing: true,
          // responsive:true,
          serverSide: true,
          "order": [[ 1, "desc" ],[ 0, "desc" ]],
          ajax: {
              url:'{{ route("datatable_pengembalian") }}',
              data:{ tanggal_awal: function() { return $('.tanggal_awal').val()},
                     tanggal_akhir: function() { return $('.tanggal_akhir').val()}, 
                     cabang: function() { return $('.cabang').val()}, 
                     flag: function() { return $('.flag').val()}, 
                     nota: function() { return $('.nota').val()}},
              error:function(){
                location.reload();
              }
          },
          columnDefs: [
            {
               targets: 3,
               className:'right'
            },
            {
               targets: 4,
               className:'center'
            },
            {
               targets:5,
               className:'center'
            },
          ],
          "columns": [
          { "data": "bp_nota" },
          { "data": "bp_tgl" },
          { "data": "cabang" },
          { "data": "bp_keperluan" },
          { "data": "tagihan" },
          { "data": "status"},
          { "data": "aksi" },
          ]
    });

    $('.tbl-penerimabarang-history').DataTable({
         processing: true,
          // responsive:true,
          serverSide: true,
          "order": [[ 1, "desc" ],[ 0, "desc" ]],
          ajax: {
              url:'{{ route("datatable_pengembalian_history") }}',
              error:function(){
                location.reload();
              }
          },
          columnDefs: [
            {
               targets: 3,
               className:'right'
            },
            {
               targets: 4,
               className:'center'
            },
            {
               targets:5,
               className:'center'
            },
          ],
          "columns": [
          { "data": "bp_nota" },
          { "data": "bp_tanggal_pengembalian" },
          { "data": "cabang" },
          { "data": "bp_keterangan_pengembalian" },
          { "data": "bp_total_pengembalian",render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
          { "data": "bank" },
          { "data": "status"},
          { "data": "aksi" },
          ]
    });
    $('.center').css('text-align','center');
})



function filtering() {
  $('.flag').val('global');
  var table = $('.tbl-penerimabarang').DataTable();
  table.ajax.reload();
}

function filtering_nota() {
  $('.flag').val('nota');
  var table = $('.tbl-penerimabarang').DataTable();
  table.ajax.reload();
}

  $('.date').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
  });
    
  function hapus(id){
    swal({
    title: "Apakah anda yakin?",
    text: "Hapus Data Biaya Penerus!",
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
      url:baseUrl + '/buktikaskeluar/hapus',
      data:{id},
      type:'get',
      success:function(data){
        if (data.status == '1') {
          swal({
          title: "Error!",
                  type: 'warning',
                  text: data.pesan,
                  timer: 2000,
                  showConfirmButton: true
                  },function(){
                    var tableDetail = $('.tbl-penerimabarang').DataTable();
                    tableDetail.ajax.reload();
                    return false;
          });
        }else if (data.status == '2'){
          swal({
          title: "Berhasil!",
                  type: 'success',
                  text: "Data Berhasil Dihapus",
                  timer: 2000,
                  showConfirmButton: true
                  },function(){
                     var tableDetail = $('.tbl-penerimabarang').DataTable();
                    tableDetail.ajax.reload();
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

function printing(id) {
    $.ajax({
        url:baseUrl + '/buktikaskeluar/print',
        type:'get',
        data:{id},
        success:function(data){
          window.open().document.write(data);
        },
        error:function(data){
        }
    });
  }

function lihat_jurnal(id,id2){
    $.ajax({
      url:baseUrl + '/pengembalian_bonsem/jurnal',
      type:'get',
      data:{id,id2},
      success:function(data){
         $('.tabel_jurnal').html(data);
         $('.modal_jurnal').modal('show');
      },
      error:function(data){
          // location.reload();
      }
  }); 
}
$('.jurnal').click(function(){
  $.ajax({
      url:baseUrl + '/buktikaskeluar/jurnal',
      type:'get',
      data:{id},
      success:function(data){
         $('.tabel_jurnal').html(data);
         $('.modal_jurnal').modal('show');
      },
      error:function(data){
          // location.reload();
      }
  }); 
})

$('.jurnal_all').click(function(){
  var cabang = $('.cabang').val();
  $.ajax({
      url:baseUrl + '/buktikaskeluar/jurnal_all',
      type:'get',
      data:{cabang},
      success:function(data){
         $('.tabel_jurnal').html(data);
         $('.modal_jurnal').modal('show');
      },
      error:function(data){
          // location.reload();
      }
  }); 
})


function pengembalian(id) {
  $('.bp_nota').val(id);
  $('.keterangan').val('');
  $('.pengembalian_modal').modal('show');
}

function save() {
  swal({
    title: "Apakah anda yakin?",
    text: "Approve Data!",
    type: "warning",
    showCancelButton: true,
    showLoaderOnConfirm: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Approve!",
    cancelButtonText: "Batal",
    closeOnConfirm: true
  },

function(){

     $.ajax({
      url:baseUrl + '/pengembalian_bonsem/edit',
      data:$('.pengembalian_modal_table :input').serialize(),
      type:'get',
      success:function(data){
        if (data.status == '2') {
          swal({
          title: "Error!",
                  type: 'warning',
                  text: data.pesan,
                  timer: 200,
                  },function(){
                    // var tableDetail = $('.tbl-penerimabarang').DataTable();
                    // tableDetail.ajax.reload();
                    return false;
          });
        }else if (data.status == '1'){
          swal({
          title: "Berhasil!",
                  type: 'success',
                  text: "Data Berhasil DiApprove",
                  timer: 200,
                  },function(){
                    //  var tableDetail = $('.tbl-penerimabarang').DataTable();
                    // tableDetail.ajax.reload();
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

</script>
@endsection
