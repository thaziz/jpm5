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
  .center:{
    text-align: center !important;
  }
  .right:{
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
                      @if (Auth::user()->punyaAkses('Bukti Kas Keluar','cabang')) 
                      <div class="text-right">
                        <a class="btn btn-success" aria-hidden="true" href="{{ url('buktikaskeluar/create')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
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
                  <div class="col-sm-6" style="margin-bottom: 20px">
                    <table cellpadding="3" cellspacing="0" border="0" class="table">
                      @if (Auth::user()->punyaAkses('Bukti Kas Keluar','cabang')) 
                      <tr id="filter_col1" data-column="0">
                          <td>Cabang</td>
                          <td align="center">
                            <select onchange="filtering()" class="form-control cabang chosen-select-width">
                              <option value="0">Pilih - Cabang </option>
                              @foreach ($cabang as $a)
                                <option value="{{$a->kode}}">{{$a->nama}}</option>
                              @endforeach
                            </select>
                          </td>
                      </tr>
                      @endif
                      <tr id="filter_col2" data-column="1">
                          <td>Jenis Pembayaran</td>
                          <td align="center">
                            <select onchange="filtering()" class="form-control jenis_bayar chosen-select-width">
                              <option value="0">Pilih - Jenis </option>
                              @foreach ($jenis_bayar as $a)
                                <option value="{{$a->idjenisbayar}}">{{$a->jenisbayar}}</option>
                              @endforeach
                            </select>
                          </td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-sm-12 append_table">
                    
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



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

$(document).ready(function(){
  var cabang = $('.cabang').val();
  var jenis_bayar = $('.jenis_bayar').val();
  $.ajax({
      url:baseUrl + '/buktikaskeluar/append_table',
      data:{cabang,jenis_bayar},
      type:'get',
      success:function(data){
        $('.append_table').html(data);
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
})

function filtering() {
  var cabang = $('.cabang').val();
  var jenis_bayar = $('.jenis_bayar').val();
  $.ajax({
      url:baseUrl + '/buktikaskeluar/append_table',
      data:{cabang,jenis_bayar},
      type:'get',
      success:function(data){
        $('.append_table').html(data);
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

</script>
@endsection
