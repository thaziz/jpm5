@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright { text-align: right; }
    .center{
        text-align: center;
    }
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
                    <table class="table datatable" border="0">
                         <tr>
                        <td> Dimulai : </td> <td> <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input name="min" id="min" type="text" class="cari_semua date form-control date_to date_range_filter
                                              date" >

                              </div> </td>  <td> Diakhiri : </td> <td> <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input type="text" class="cari_semua date form-control date_to date_range_filter
                                              date" name="max" id="max"  >
                              </div> </td>
                      </tr>
                    
                      <tr>

                        
                           <th style="width: 100px; padding-top: 16px">Cabang</th>
                          <td colspan="1">
                            <select class="cari_semua chosen-select-width" id="cabang"  name="cabang">
                              <option></option>
                              @foreach ($cabang as $element)
                                <option value="{{ $element->kode }}">{{ $element->kode }} - {{ $element->nama }}</option>
                              @endforeach
                            </select>
                          </td>

                          <th style="width: 100px; padding-top: 16px"> Kota Asal  </th>
                          <td >
                          <select style="width: 200px; margin-top: 20px;" name="asal" class="cari_semua chosen-select-width select-picker1 form-control" data-show-subtext="true" data-live-search="true"  id="kota_asal">
                            <option value=""  selected=""> --Asal --</option>
                            @foreach ($kota1 as $asal)
                                <option value="{{ $asal->id }}">{{ $asal->nama }}</option>
                            @endforeach
                          </select>
                          </td>

                        </tr>       
                        <tr>
                           <th style="width: 100px; padding-top: 16px"> Jenis </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" name="jenis" id="jenis" class="select-picker4 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" >
                            <option value=""  selected=""> --Pilih --</option>
                            @foreach($jenis_tarif as $val)
                                <option value="{{$val->jt_id}}">{{$val->jt_nama_tarif}}</option>
                            @endforeach
                           </select>
                          </td>


                          <th style="width: 100px; padding-top: 16px"> Kota Tujuan </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" name="tujuan" class="cari_semua select-picker2 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" id="kota_tujuan" >
                            <option value=""  selected=""> --Tujuan --</option>
                            @foreach ($kota as $tujuan)
                                <option value="{{ $tujuan->id }}">{{ $tujuan->nama }}</option>
                            @endforeach
                           </select>
                          </td>

                           
                        </tr>
                        <tr >
                        <th style="width: 100px; padding-top: 16px"> Customer </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" name="customer" class="cari_semua customer chosen-select-width form-control" data-show-subtext="true" data-live-search="true" id="customer">
                            <option value=""  selected=""> --Customer --</option>
                            @foreach ($customer as $e)
                                <option value="{{ $e->kode }}">{{ $e->kode }} - {{ $e->nama }}</option>
                            @endforeach
                           </select>
                          </td>
                        <th style="width: 100px; padding-top: 16px"> Status </th>
                          <td colspan="3"> 
                           <select style="width: 200px; margin-top: 20px;" name="status" class="cari_semua select-picker5 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" id="status"  >
                            <option value=""  selected=""> --Status --</option>
                            <option value="MANIFESTED">MANIFESTED</option>
                            <option value="TRANSIT">TRANSIT</option>
                            <option value="RECEIVED">RECEIVED</option>
                            <option value="DELIVERED">DELIVERED</option>
                            <option value="DELIVERED OK">DELIVERED OK</option>
                           </select>
                          </td>

                          
                        </tr>
                        <tr>
                          <th style="width: 100px; padding-top: 16px"> Nomor </th>
                          <td > 
                           <input type="text" name="do_nomor" id="do_nomor" class="form-control">
                          </td>
                          
                          
                        </tr>

                      <br>
                      </table>
                      <div class="row" style="margin-top: 20px;margin-bottom: 10px;"> &nbsp; &nbsp; <a class="btn btn-primary" onclick="cari()"> <i class="fa fa-search" aria-hidden="true"></i> Cari </a> </div>
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
          searching:false,
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route("datatable_do_kargo") }}',
                data:{min: function() { return $('#min').val()},
                     max: function() { return $('#max').val()},
                     cabang: function() { return $('#cabang').val()},
                     jenis: function() { return $('#jenis').val()},
                     customer: function() { return $('#customer').val() },
                     kota_asal: function() { return $('#kota_asal').val() },
                     kota_tujuan: function() { return $('#kota_tujuan').val() },
                     status : function() { return $('#status ').val() },
                     do_nomor : function() { return $('#do_nomor ').val() }}
            },
            columnDefs: [
              {
                 targets: 8,
                 className: 'right'
              },
              {
                 targets:9,
                 className: 'center'
              },
            ],
            "columns": [
            { "data": "nomor" },
            { "data": "tanggal" },
            { "data": "nama"},
            { "data": "nama_pengirim" },
            { "data": "nama_penerima" },
            { "data": "asal"},
            { "data": "tujuan" },
            { "data": "status" },
            { "data": "total_net" },
            { "data": "aksi" },
            
            ]
      });
      $.fn.dataTable.ext.errMode = 'throw';
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
        var id = id.replace(/\//g, "-");
        window.open("{{url('sales/deliveryorderkargoform/nota')}}"+'/'+id);
    }

    function edit(id) {
        var id = id.replace(/\//g, "-");
        window.open("{{ url('sales/edit_do_kargo')}}"+'/'+id);
    }

    function detail(id) {
        var id = id.replace(/\//g, "-");
        window.open("{{ url('sales/detail_do_kargo')}}"+'/'+id);
        
    }

    function cari(argument) {
      var table = $('#tabel_data').DataTable();
      table.ajax.reload();
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
