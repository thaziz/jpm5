
@extends('main')


@section('title', 'dashboard')


@section('content')
<style type="text/css">
    .cssright { text-align: right; }
     .modal-dialog {
    width: 900px;
    margin: 30px auto;
}
    .pad{
        padding: 10px;
    }
     .btn-purple{
      background-color: purple;
    }
    .btn-black{
      background-color: black;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> TARIF VENDOR </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Master</a>
                        </li>
                        <li>
                          <a> Master Penjualan</a>
                        </li>
                        <li>
                          <a> Master Vendor</a>
                        </li>
                        <li class="active">
                            <strong> Tarif Vendor </strong>
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
                    <h5> 
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <div class="text-right">
                      @if(Auth::user()->punyaAkses('Tarif Cabang Kilogram','tambah'))
                       <button  type="button" class="btn btn-success " id="btn_add" name="btnok"><i class="glyphicon glyphicon-plus"></i>Tambah Data</button>
                       @endif
                      @if(Auth::user()->punyaAkses('Tarif Cabang Kilogram','print'))
                       <a href="{{ url('/laporan_master_penjualan/tarif_cabang_kilogram') }}" class="btn btn-warning"><i class="glyphicon glyphicon-print"></i>Laporan</a>
                       @endif
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    
                <div class="box-body">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width:70px"> Kode</th>
                                <th> Asal </th>
                                <th> Tujuan </th>
                                <th> Tarif </th>
                                <th> Cabang </th>
                                <th> jenis </th>
                                <th> Waktu </th>
                                <th style="width:80px"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <!-- modal -->
                <div id="modal" class="modal" >
                  <div class="modal-dialog modal-lg ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insert Edit Tarif Cabang Kilogram</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal kirim">
                          <table class="table table-striped table-bordered table-hover ">
                            <tbody>
                                <tr>
                                    {{-- <td style="width:120px; padding-top: 0.4cm">Kode</td> --}}
                                    <td colspan="3">
                                        {{-- <input type="text" name="ed_kode" class="form-control a" style="text-transform: uppercase" > --}}
                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                        <input type="hidden" name="ed_kode_old" class="form-control" >
                                        <input type="hidden" class="form-control" name="crud" class="form-control" >
                                    </td>
                                </tr>
                                 @if(Auth::user()->punyaAkses('Tarif Cabang Kilogram','cabang'))
                                 <tr>
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    <td>   
                                        <select class="chosen-select-width b"  name="cb_cabang" id="cb_cabang"  style="width:100%">
                                            <option value="" selected="" disabled="">-- Pilih Cabang --</option>
                                            @foreach ($cabang as $row)
                                                 <option @if(Auth::user()->kode_cabang == $row->kode) selected="" @endif value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @else
                                 <tr>
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    <td class="disabled">   
                                        <select class="chosen-select-width b"  name="cb_cabang" id="cb_cabang" style="width:100%">
                                            <option value="" selected="" disabled="">-- Pilih Cabang --</option>
                                        @foreach ($cabang as $row)
                                            <option @if(Auth::user()->kode_cabang == $row->kode) selected="" @endif value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="padding-top: 0.4cm">Kota Asal</td>
                                    <td>   
                                        <select class="chosen-select-width b"  name="cb_kota_asal" style="width:100%" id="cb_kota_asal">
                                            <option value="" selected="" disabled="">-- Pilih Kota asal --</option>
                                        @foreach ($kota as $row)
                                            <option value="{{ $row->id }}" data-kota="{{ $row->kode_kota }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>

                                <tr id="hilang2">
                                    <td style="padding-top: 0.4cm">Kota Tujuan</td>
                                    <td>   
                                        <select class="chosen-select-width c"  name="cb_kota_tujuan" id="cb_kota_tujuan" style="width:100%">
                                             <option value="" selected="" disabled="">-- Pilih Kota tujuan --</option>
                                        @foreach ($kota as $row)
                                            <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Vendor</td>
                                    <td>
                                        <select class="chosen-select-width"  name="cb_vendor" style="width:100%">
                                             <option value="" selected="" disabled="">-- Pilih Vendor --</option>
                                        @foreach ($vendor as $ven)
                                            <option value="{{ $ven->kode}}" data-nama_akun="{{$ven->nama}}"> {{ $ven->kode }} - {{$ven->nama}}</option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                {{-- <tr id="hilang">
                                    <td style="padding-top: 0.4cm">Provinsi Tujuan</td>
                                    <td>   
                                        <select class="chosen-select-width c"  name="cb_provinsi_tujuan" id="cb_provinsi_tujuan" style="width:100%" i>
                                            <option value="" selected="" disabled="">-- Pilih Provinsi tujuan --</option>
                                        @foreach ($prov as $prov)
                                            <option value="{{ $prov->id }}"> {{ $prov->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td style="padding-top: 0.4cm">Acc Penjualan</td>
                                    <td>
                                        <select class="chosen-select-width"  name="cb_acc_penjualan" style="width:100%">
                                             <option value="" selected="" disabled="">-- Pilih Akun Penjualan --</option>
                                        @foreach ($akun as $row)
                                            <option value="{{ $row->id_akun}}" data-nama_akun="{{$row->nama_akun}}"> {{ $row->id_akun }} - {{$row->nama_akun}}</option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">CSF Penjualan</td>
                                    <td>
                                        <select class="chosen-select-width"  name="cb_csf_penjualan" style="width:100%">
                                             <option value="" selected="" disabled="">-- Pilih Csf Penjualan --</option>
                                        @foreach ($akun as $row)
                                            <option value="{{ $row->id_akun}}" data-nama_akun="{{$row->nama_akun}}"> {{ $row->id_akun }} - {{$row->nama_akun}}</option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>

                            </tbody>
                          </table>
                           <table class="table-striped table-bordered" width="48%"> 
                              <thead>
                                  <tr >
                                      <th style="padding: 7px; text-align: center;"  colspan="2">REGULAR</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <input type="hidden" name="id_reguler" id="id_reguler">
                                  <tr>
                                      <td class="pad">Waktu/Estimasi</td>
                                      <td class="pad"><input type="text" name="waktu_regular"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif</td>
                                      <td class="pad"><input type="text" name="tarifkertas_reguler"></td>
                                  </tr>

                              </tbody>
                          </table> 
                          <table class="table-striped table-bordered" style="margin-left: 45%;margin-top: -124px;position: fixed;" width="48%"> 
                              <thead>
                                  <tr>
                                      <th style="padding: 7px; text-align: center;"  colspan="2">EXPRESS</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <input type="hidden" name="id_express" id="id_express">

                                  <tr>
                                      <td class="pad">Waktu/Estimasi</td>
                                      <td class="pad"><input type="text" name="waktu_express"></td>
                                  </tr>
                                   <tr>
                                      <td class="pad">Tarif</td>
                                      <td class="pad"><input type="text" name="tarifkertas_express"></td>
                                  </tr>
                                  
                              </tbody>
                          </table>
                    

                          {{-- KODE SAMA KILO --}}
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btnsave">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>
                  <!-- modal -->
                <div class="box-footer">
                  <div class="pull-right">


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
    
  $('#datatable').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route('tarif_vendor_datatable') }}',
            },
             columnDefs: [

                  {
                     targets: 0 ,
                     className: 'd_id left'
                  },
                  {
                     targets: 3 ,
                     className: 'right'
                  },
                  

                ],
            "columns": [
            { "data": "id_tarif_vendor" },
            { "data": "asal" },
            { "data": "tujuan" },
            { "data": "tarif_vendor" ,render: $.fn.dataTable.render.number( '.', '.', 0, '' ) },
            { "data": "nama_cab" },
            { "data": "jenis" },
            { "data": "waktu_vendor" ,render: $.fn.dataTable.render.number( '.', '.', 0, '' ) },
            { 'data': 'button' },
            ]
      });





  $('#cb_kota_asal').change(function(){
        var idkota = $('#cb_kota_asal :selected').data('kota');
        var kotaid = $('#kodekota').val(idkota);
    })
  $('#cb_kota_tujuan').change(function(){
        $('#hilang').hide();
        // alert('aa');

    })
    $('#cb_provinsi_tujuan').change(function(){
        $('#hilang2').hide();
    })
 
    $('#cb_cabang').change(function(){
      $.ajax({
            type: "get",
            url : ('{{ route('cabang_vendor') }}'),
            //dataType:"JSON",
            data: $(this).val(),
            success: function(data, textStatus, jqXHR)
            {
                

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    })


    $("select[name='cb_acc_penjualan']").change(function(){
        var nama_akun = $(this).find(':selected').data('nama_akun');
        $("input[name='ed_acc_penjualan2']").val(nama_akun);
    });

    $("select[name='cb_csf_penjualan']").change(function(){
        var nama_akun = $(this).find(':selected').data('nama_akun');
        $("input[name='ed_csf_penjualan2']").val(nama_akun);
    });
    
    $(document).on("click","#btn_add",function(){
        $("input[name='crud']").val('N');
        // $("input[name='ed_kode']").val('');
        $("input[name='ed_kode_old']").val('');
        
        $('input[name="waktu_regular"]').val('');
        $('input[name="tarifkertas_reguler"]').val('');
        $('input[name="tarif0kg_reguler"]').val('');
        $('input[name="tarif10kg_reguler"]').val('');
        $('input[name="tarif20kg_reguler"]').val('');
        //reg
        $('input[name="waktu_express"]').val('');
        $('input[name="tarifkertas_express"]').val('');
        $('input[name="tarif0kg_express"]').val('');
        $('input[name="tarif10kg_express"]').val('');
        $('input[name="tarif20kg_express"]').val('');
        $('input[name="tarifkgsel_reguler"]').val('');
        $('input[name="tarifkgsel_express"]').val('');
        $('#hilang').show();
        $("input[name='kodekota']").val('');

        $('#hilang2').show();
        $("select[name='cb_provinsi_tujuan']").val('').trigger('chosen:updated');
        $("select[name='cb_kota_asal']").val('').trigger('chosen:updated');
        $("select[name='cb_kota_tujuan']").val('').trigger('chosen:updated');
        $("select[name='cb_acc_penjualan']").val('').trigger('chosen:updated');
        $("select[name='cb_csf_penjualan']").val('').trigger('chosen:updated');
        $("select[name='cb_acc_penjualan']").change();
        $("select[name='cb_csf_penjualan']").change();
        $("#modal").modal("show");
        $("input[name='ed_kode']").focus();
    });

    $(document).on( "click",".btnedit", function() {
        var id=$(this).attr("id");
        var tujuan = $(this).data('tujuan'); 
        var value = {
          asal : id , tujuan :tujuan 
        };
        $.ajax(
        {
            url : baseUrl + "/sales/tarif_cabang_kilogram/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
              console.log(data);
                $("input[name='crud']").val('E');
                //flag
                $("input[name='id0']").val(data[0][0].kode);
                $("input[name='id1']").val(data[0][1].kode);
                $("input[name='id2']").val(data[0][2].kode);
                $("input[name='id3']").val(data[0][3].kode);
                $("input[name='id4']").val(data[0][4].kode);
                $("input[name='id5']").val(data[0][5].kode);
                $("input[name='id6']").val(data[0][6].kode);
                $("input[name='id7']").val(data[0][7].kode);
                $("input[name='id8']").val(data[0][8].kode);
                $("input[name='id9']").val(data[0][9].kode);
                //kode
                $("input[name='kode0']").val(data[0][0].kode_detail_kilo);
                $("input[name='kode1']").val(data[0][1].kode_detail_kilo);
                $("input[name='kode2']").val(data[0][2].kode_detail_kilo);
                $("input[name='kode3']").val(data[0][3].kode_detail_kilo);
                $("input[name='kode4']").val(data[0][4].kode_detail_kilo);
                $("input[name='kode5']").val(data[0][5].kode_detail_kilo);
                $("input[name='kode6']").val(data[0][6].kode_detail_kilo);
                $("input[name='kode7']").val(data[0][7].kode_detail_kilo);
                $("input[name='kode8']").val(data[0][8].kode_detail_kilo);
                $("input[name='kode9']").val(data[0][9].kode_detail_kilo);
                //kode detail
                $("input[name='kode_sama_kilo']").val(data[0][1].kode_sama_kilo);
                //kode sama
                $('input[name="waktu_regular"]').val(data[0][0].waktu);
                $('input[name="tarifkertas_reguler"]').val(data[0][0].harga);
                $('input[name="tarif0kg_reguler"]').val(data[0][1].harga);
                $('input[name="tarif10kg_reguler"]').val(data[0][2].harga);
                $('input[name="tarif20kg_reguler"]').val(data[0][3].harga);
                $('input[name="tarifkgsel_reguler"]').val(data[0][4].harga);
                //reg
                $('input[name="waktu_express"]').val(data[0][5].waktu);
                $('input[name="tarifkertas_express"]').val(data[0][5].harga);
                $('input[name="tarif0kg_express"]').val(data[0][6].harga);
                $('input[name="tarif10kg_express"]').val(data[0][7].harga);
                $('input[name="tarif20kg_express"]').val(data[0][8].harga);
                $('input[name="tarifkgsel_express"]').val(data[0][9].harga);
                //expre
                $('#hilang').hide();
                $('#hilang2').show();
                $("input[name='kodekota']").val(data[0][0].kode_kota);
                

                $("input[name='ed_kode_old']").val(data.kode);
                $("select[name='cb_kota_asal']").val(data[0][0].id_kota_asal).trigger('chosen:updated');
                $("select[name='cb_kota_tujuan']").val(data[0][0].id_kota_tujuan).trigger('chosen:updated');
                $("select[name='cb_cabang']").val(data[0][0].kode_cabang).trigger('chosen:updated');
                $("select[name='cb_acc_penjualan']").val(data[0][0].acc_penjualan).trigger('chosen:updated');
                $("select[name='cb_csf_penjualan']").val(data[0][0].csf_penjualan).trigger('chosen:updated');
                $("select[name='cb_provinsi_tujuan']").val(data[0][0].id_provinsi_cabkilogram).trigger('chosen:updated');
                $("#modal").modal('show');
                $("input[name='ed_kode']").focus();
                
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    });
  
  $()
    $(document).on("click","#btnsave",function(){
        $.ajax(
        {
            url : baseUrl + "/sales/tarif_vendor/save_data",
            type: "get",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result == 1){
                        var table = $('#table_data').DataTable();
                        table.ajax.reload( null, false );
                        $("#modal").modal('hide');
                        $("#btn_add").focus();
                    }else{
                        alert("Gagal menyimpan data!");
                    }
                }else if(data.crud == 'E'){
                    if(data.result == 1){
                        var table = $('#table_data').DataTable();
                        table.ajax.reload( null, false );
                        $("#modal").modal('hide');
                        $("#btn_add").focus();
                    }else{
                        swal("Error","Can't update customer data, error : "+data.error,"error");
                    }
                }else{
                    // console.log(data.hasil_cek);
                    swal(data.hasil_cek,'Cek sekali lagi',"warning");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Error!", textStatus, "error");
            }
        });
    });

    function hapus(parm) {
      var par   = $(parm).parents('tr');
      var id    = $(par).find('.d_id').text();

      if(!confirm("Hapus Data"+" ?")) return false;
        var value = {
            id: id,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "get",
            url : baseUrl + "/sales/tarif_vendor/hapus_data",
            //dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                var data = jQuery.parseJSON(data);
                if(data.result ==1){
                    var table = $('#table_data').DataTable();
                    table.ajax.reload( null, false );
                }else{
                    swal("Error","Data tidak bisa hapus : "+data.error,"error");
                }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });


    }
  
  
    

</script>
@endsection
