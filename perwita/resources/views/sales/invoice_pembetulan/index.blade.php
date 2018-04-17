@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright { text-align: right; }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> INVOICE PEMBETULAN</h2>
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
                            <strong> INVOICE PEMBETULAN</strong>
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

                    <table style="font-size: 12px" id="tabel_data" class="table table-bordered table-striped" cellspacing="10">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tanggal </th>
                                <th>Customer</th>
                                <th>JT</th>
                                <th>Tagihan </th>
                                <th>Keterangan </th>
                                <th style="width:10%"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr>
                                <td>{{ $row->ip_nomor }}</td>
                                <td>{{ $row->ip_tanggal }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->ip_jatuh_tempo }}</td>
                                <td style="text-align:right"> {{ number_format($row->ip_total_tagihan, 2, ",", ".") }} </td>
                                <td>{{ $row->ip_keterangan }}</td>
                                <td class="text-center">
                                    <div class="btn-group ">
                                        @if(Auth::user()->punyaAkses('Invoice Penjualan','ubah'))
                                        @if(cek_periode(carbon\carbon::parse($val->ip_tanggal)->format('m'),carbon\carbon::parse($row->ip_tanggal)->format('Y') ) != 0)
                                        <a  onclick="edit('{{$row->ip_nomor}}')" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                                        @endif
                                        @endif
                                        @if(Auth::user()->punyaAkses('Invoice Penjualan','print'))
                                        <a  onclick="ngeprint('{{$row->ip_nomor}}')" class="btn btn-xs btn-warning"><i class="fa fa-print"></i></a>
                                        @endif
                                        @if(cek_periode(carbon\carbon::parse($val->ip_tanggal)->format('m'),carbon\carbon::parse($row->ip_tanggal)->format('Y') ) != 0)
                                        <a  onclick="hapus('{{$row->ip_nomor}}')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
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
    $(document).ready( function () {
        $('#tabel_data').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
      });
    });


    $(document).on("click","#btn_add_order",function(){
        window.location.href = baseUrl + '/sales/invoice_pembetulan_create'
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    function edit(id){
        window.location.href = baseUrl + '/sales/invoice_pembetulan_edit/'+id;
    }
    function lihat(id){
        window.open(baseUrl + '/sales/lihat_invoice/'+id);
    }


    function ngeprint(id){
        window.open(baseUrl+'/sales/cetak_nota/'+id);
        location.reload();
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
          url:baseUrl + '/sales/hapus_invoice_pembetulan',
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


</script>
@endsection
