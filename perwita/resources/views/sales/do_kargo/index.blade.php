@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright { text-align: right; }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> DELIVERY ORDER KARGO </h2>
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
                            <strong> DO KARGO </strong>
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
                    <h5 style="margin : 8px 5px 0 0"> DELIVERY ORDER KARGO
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
                                <th> No DO</th>
                                <th> Tanggal </th>
                                <th> Cabang </th>
                                <th> Pengirim </th>
                                <th> Penerima </th>
                                <th> Kota Asal </th>
                                <th> Kota Tujuan </th>
                                <th> Status </th>
                                <th> Tarif </th>
                                <th style="width:110px"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr>
                                <td><a href="{{ url('sales/detail_do_kargo')}}/{{$row->nomor}}">{{ $row->nomor }}</a></td>
                                <td>{{ $row->tanggal }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->nama_pengirim }}</td>
                                <td>{{ $row->nama_penerima }}</td>
                                @foreach($kota as $val)
                                    @if($val->id == $row->id_kota_tujuan)
                                    <td>{{ $val->nama }}</td>
                                    @endif
                                @endforeach
                                @foreach($kota as $val)
                                    @if($val->id == $row->id_kota_asal)
                                    <td>{{ $val->nama }}</td>
                                    @endif
                                @endforeach
                                <td>{{ $row->status }}</td>
                                <td>{{ $row->total_net }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        @if($row->status_do == 'Released' or Auth::user()->punyaAkses('Delivery Order','ubah'))
                                            @if(cek_periode(carbon\carbon::parse($row->tanggal)->format('m'),carbon\carbon::parse($row->tanggal)->format('Y') ) != 0)
                                            <a type="button" href="{{ url('sales/edit_do_kargo')}}/{{$row->nomor}}" data-toggle="tooltip" title="Edit" class="btn btn-success btn-xs btnedit"><i class="fa fa-pencil"></i></a>
                                            @endif
                                        @endif


                                        @if(Auth::user()->punyaAkses('Delivery Order','print'))
                                            <button type="button" onclick="print('{{$row->nomor}}')" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-warning btn-xs btnedit"><i class="fa fa-print"></i></button>
                                        @endif

                                        @if($row->status_do == 'Released' or Auth::user()->punyaAkses('Delivery Order','hapus'))
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

      });
    });


    $(document).on("click","#btn_add_order",function(){
        window.location.href = baseUrl + '/sales/deliveryorderkargoform'
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    function tambahdata() {
        window.location.href = baseUrl + '/data-master/master-akun/create'
    }


    function print(id) {
        window.open("{{url('sales/deliveryorderkargoform/nota')}}"+'/'+id);
    }

    function hapus(id){
    var nomor_do = id;
        
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
          url:baseUrl + '/sales/hapus_do_kargo',
          data:{nomor_do},
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
