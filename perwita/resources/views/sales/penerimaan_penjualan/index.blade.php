@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright { text-align: right; }
    .right{
        text-align: right;
        }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> KWITANSI </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Operasional</a>
                        </li>
                        <li>
                            <a>Penjualan</a>
                        </li>
                        <li>
                            <a>Transaksi Penjualan</a>
                        </li>
                        <li class="active">
                            <strong> KWITANSI </strong>
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
                    <h5 style="margin : 8px 5px 0 0">
                          <!-- {{Session::get('comp_year')}} -->
                    </h5>

                    <div class="text-right" style="">
                       <button  type="button" style="margin-right :12px; width:110px" class="btn btn-success " id="btn_add_order" name="btnok"></i>Tambah Data</button>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                <div class="box-body">

                    <table id="tabel_data" class="table table-bordered table-striped tabel_data" cellspacing="10">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tanggal </th>
                                <th>Customer</th>
                                <th>Jumlah</th>
                                <th>Memorial</th>
                                <th>Keterangan </th>
                                <th style="width:8%"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $val)
                          <tr>
                            <td>
                              <a onclick="detail('{{$val->k_nomor}}')">{{$val->k_nomor}}</a>
                            </td>
                            <td>
                              {{$val->k_tanggal}}
                            </td>
                            <td>
                              {{$val->nama}}
                            </td>
                            <td>
                              {{number_format($val->k_netto, 2, ",", ".")}}
                            </td>
                            <td align="right">
                              {{number_format($val->k_jumlah_memorial, 2, ",", ".")}}
                            </td>
                            <td>
                              {{$val->k_keterangan}}
                            </td>
                            <td>
                              <div class="btn-group">
                              @if(Auth::user()->punyaAkses('Kwitansi','ubah'))
                              @if(cek_periode(carbon\carbon::parse($val->k_tanggal)->format('m'),carbon\carbon::parse($val->k_tanggal)->format('Y') ) != 0)
                                <button type="button" onclick="edit('{{$val->k_nomor}}')" class="btn btn-xs btn-primary">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                @endif
                              @endif
                              @if(Auth::user()->punyaAkses('Kwitansi','print'))
                                <button type="button" onclick="ngeprint('{{$val->k_nomor}}')" class="btn btn-xs btn-warning">
                                  <i class="fa fa-print"></i>
                                </button>
                              @endif
                              @if(Auth::user()->punyaAkses('Kwitansi','hapus'))
                              @if(cek_periode(carbon\carbon::parse($val->k_tanggal)->format('m'),carbon\carbon::parse($val->k_tanggal)->format('Y') ) != 0)
                                <button type="button" onclick="hapus('{{$val->k_nomor}}')" class="btn btn-xs btn-danger">
                                  <i class="fa fa-trash"></i>
                                </button>
                                @endif
                              @endif
                              </div>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>

                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">





                    </div>
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
$(document).ready(function() {
    $('.tabel_data').DataTable({
      ordering:false,
        columnDefs: [  
          
                      {
                         targets: 3,
                         className: 'right'
                      },


                    ],

    });
});

    $(document).on("click","#btn_add_order",function(){
        window.location.href = baseUrl + '/sales/penerimaan_penjualan_form'
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });


    $(document).on( "click",".btnhapus", function(){
        if(!confirm("Hapus Data ?")) return false;
    });

    function ngeprint(id){
        window.open(baseUrl+'/sales/kwitansi/cetak_nota/'+id);
    }

    function edit(id){
        window.location.href = baseUrl +'/sales/edit_kwitansi/'+id
    }

    function hapus(id) {
      var nota = id;
      var flag_nota = 'H';
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
          url:baseUrl + '/sales/hapus_kwitansi',
          data:{nota,flag_nota},
          type:'get',
          dataType:'json',
          success:function(data){
            if (data.status == 1) {
              swal({
              title: "Berhasil!",
                      type: 'success',
                      text: "Data Berhasil Dihapus",
                      timer: 2000,
                      showConfirmButton: true
                      },function(){
                         location.reload();
              });
            }else{
              swal({
                  title: "Anda Tidak Punya Akses Untuk Menghapus",
                          type: 'error',
                          timer: 2000,
                          showConfirmButton: false
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
    function detail(id) {
      window.location.href = baseUrl +'/sales/detail_kwitansi/'+id
    }
</script>
@endsection
