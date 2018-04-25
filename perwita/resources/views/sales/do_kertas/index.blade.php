@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright { text-align: right; }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> DELIVERY ORDER KORAN </h2>
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
                            <strong> DO KORAN </strong>
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

                    <table id="tabel_data" class="table table-bordered table-striped" cellspacing="10">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tanggal </th>
                                <th>Cabang </th>
                                <th>Customer</th>
                                <th>Diskon </th>
                                <th>Total </th>
                                <th style="width:110px"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr>
                                <td><a href="{{ url('sales/detail_do_kertas')}}/{{$row->nomor}}">{{ $row->nomor }}</a></td>
                                <td>{{ $row->tanggal }}</td>
                                <td>{{ $row->nama_cabang }}</td>
                                <td>{{ $row->nama }}</td>
                                <td style="text-align:right"> {{ number_format($row->diskon, 0, ",", ".") }} </td>
                                <td style="text-align:right"> {{ number_format($row->total_net, 0, ",", ".") }} </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        @if($row->status_do == 'Released' or Auth::user()->punyaAkses('Delivery Order Koran','ubah'))
                                            @if(cek_periode(carbon\carbon::parse($row->tanggal)->format('m'),carbon\carbon::parse($row->tanggal)->format('Y') ) != 0)
                                            <a type="button" href="{{ url('sales/edit_do_kertas')}}/{{$row->nomor}}" data-toggle="tooltip" title="Edit" class="btn btn-success btn-xs btnedit"><i class="fa fa-pencil"></i></a>
                                            @endif
                                        @endif


                                        @if(Auth::user()->punyaAkses('Delivery Order Koran','print'))
                                            <button type="button" onclick="print('{{$row->nomor}}')" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-warning btn-xs btnedit"><i class="fa fa-print"></i></button>
                                        @endif

                                        @if($row->status_do == 'Released' or Auth::user()->punyaAkses('Delivery Order Koran','hapus'))
                                            @if(cek_periode(carbon\carbon::parse($row->tanggal)->format('m'),carbon\carbon::parse($row->tanggal)->format('Y') ) != 0)
                                            <button type="button" onclick="hapus('{{$row->nomor}}')" class="btn btn-xs btn-danger btnhapus"><i class="fa fa-trash"></i></button>
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
        window.location.href = baseUrl + '/sales/deliveryorderkertas_form'
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });


    function print(a) {
        window.open('{{ url('sales/cetak_nota_kertas') }}'+'/'+a)
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
          url:baseUrl + '/sales/hapus_do_kertas',
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
