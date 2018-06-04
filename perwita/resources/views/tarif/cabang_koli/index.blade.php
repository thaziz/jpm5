
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
    }.btn-purple{
      background-color: purple;
    }
    .btn-black{
      background-color: black;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> TARIF CABANG KOLI </h2>
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
                          <a> Master Tarif</a>
                        </li>
                        <li class="active">
                            <strong> Tarif Cabang Kilo </strong>
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
                      @if(Auth::user()->punyaAkses('Tarif Cabang Koli','tambah'))
                       <button  type="button" class="btn btn-success " id="btn_add" name="btnok"><i class="glyphicon glyphicon-plus"></i>Tambah Data</button>
                       @endif
                      @if(Auth::user()->punyaAkses('Tarif Cabang Koli','print'))
                       <a href="{{ url('/laporan_master_penjualan/tarif_cabang_koli') }}" class="btn btn-warning"><i class="glyphicon glyphicon-print"></i>Laporan</a>
                       @endif
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                        <div class="box-body">
                            <div class="row">
                                <table class="table table-striped table-bordered dt-responsive nowrap table-hover">
                            </table>
                         <div class="col-xs- float-left">
                          <table>
                            <tr>
                              <td valign="top" style="padding-left: 20px;"><p style="background-color: red;width: 15px;height: 15px">&nbsp;</p></td>
                              <td><p>&nbsp;&nbsp;&nbsp;</p></td>
                              <td valign="top"><p> Menghapus Seluruh Data <b>kota</b> Menuju <b>Provinsi</b> <f style="color: red;";>*Kecuali</f> jika sudah di custom/edit</p></td>
                                                       
                              <td valign="top" style="padding-left: 50px;"><p style="background-color: purple;width: 15px;height: 15px">&nbsp;</p></td>
                              <td><p>&nbsp;&nbsp;&nbsp;</p></td>
                              <td  valign="top"><p>Menghapus Data <b>kota</b> Menuju <b>Kota</b> <f style="color: red;";>*Kecuali</f> jika sudah di custom/edit</p></td>

                              <td valign="top" style="padding-left: 50px;"><p style="background-color: #595959;width: 15px;height: 15px">&nbsp;</p></td>
                              <td><p>&nbsp;&nbsp;&nbsp; </p></td>
                              <td  valign="top"><p>Menghapus data Tidak diperbolehkan</p></td>
                            </tr>
                          </table>
                        </div>
                        </div>
                    </form>
                <div class="box-body">
                    <table id="table_data" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width:70px"> Kode</th>
                                <th> Asal </th>
                                <th> Tujuan </th>
                                <th> Provinsi Tujuan </th>
                                <th> Tarif </th>
                                <th> Jenis </th>
                                <th> Cabang </th>
                                <th> Waktu </th>
                                <th> Keterangan </th>
                                <th style="width:100px"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <!-- modal -->
                <div id="modal" class="modal" >
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insert Edit Tarif Cabang Koli</h4>
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
                                <tr id="hilang1">
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
                                 <tr id="hilang">
                                    <td style="padding-top: 0.4cm">Provinsi Tujuan</td>
                                    <td>   
                                        <select class="chosen-select-width c"  name="cb_provinsi_tujuan" id="cb_provinsi_tujuan" style="width:100%" i>
                                            <option value="" selected="" disabled="">-- Pilih Provinsi tujuan --</option>
                                        @foreach ($prov as $prov)
                                            <option value="{{ $prov->id }}"> {{ $prov->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                 @if(Auth::user()->punyaAkses('Tarif Cabang Koli','cabang'))
                                 <tr>
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    <td>
                                        <select  class="form-control d" name="ed_cabang" id="ed_harga" style="text-align: right;">
                                        
                                            <option value="">-- Pilih Cabang Terlebih Dahulu --</option>
                                            @foreach ($cabang_default as $a)
                                                <option @if(Auth::user()->kode_cabang == $a->kode) selected="" @endif value="{{ $a->kode }}" >{{ $a->kode }} - {{ $a->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @else
                                 <tr>
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    <td class="disabled">
                                        <select  class="form-control d" name="ed_cabang" id="ed_harga" style="text-align: right;">
                                        
                                            <option value="">-- Pilih Cabang Terlebih Dahulu --</option>
                                            @foreach ($cabang_default as $a)
                                                <option @if(Auth::user()->kode_cabang == $a->kode) selected="" @endif value="{{ $a->kode }}" >{{ $a->kode }} - {{ $a->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="padding-top: 0.4cm">Acc Penjualan</td>
                                    <td>
                                        <select  class="chosen-select-width form-control d" name="ed_acc_penjualan"  style="text-align: right;">
                                        
                                            <option value="">-- Pilih Acc Penjualan Terlebih Dahulu --</option>
                                            @foreach ($accpenjualan as $b)
                                                <option value="{{ $b->id_akun }}" >{{ $b->id_akun }} - {{ $b->nama_akun }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Csf Penjualan</td>
                                    <td>
                                        <select  class="chosen-select-width form-control d" name="ed_csf_penjualan" style="text-align: right;">
                                        
                                            <option value="">-- Pilih Csf Penjualan Terlebih Dahulu --</option>
                                            @foreach ($csfpenjualan as $a)
                                                <option value="{{ $a->id_akun }}" >{{ $a->id_akun }} - {{ $a->nama_akun }}</option>
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
                                      <td class="pad">Tarif Koli < 10 Kg</td>
                                      <td class="pad"><input type="text" name="tarifkertas_reguler"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif  < 20 Kg</td>
                                      <td class="pad"><input type="text" name="tarif0kg_reguler"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif < 30 Kg</td>
                                      <td class="pad"><input type="text" name="tarif10kg_reguler"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif >30 kg</td>
                                      <td class="pad"><input type="text" name="tarif20kg_reguler"></td>
                                  </tr>

                              </tbody>
                          </table> 
                          <table class="table-striped table-bordered" style="margin-left: 45%;margin-top: -259px;position: fixed;" width="48%"> 
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
                                      <td class="pad">Tarif Koli < 10 Kg</td>
                                      <td class="pad"><input type="text" name="tarifkertas_express"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif  < 20 Kg</td>
                                      <td class="pad"><input type="text" name="tarif0kg_express"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif < 30 Kg</td>
                                      <td class="pad"><input type="text" name="tarif10kg_express"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif >30 kg</td>
                                      <td class="pad"><input type="text" name="tarif20kg_express"></td>
                                  </tr>
                              </tbody>
                          </table>
                          
                          <input type="hidden" name="kodekota" id="kodekota">
                          {{-- KODE utama  --}}
                          <input type="hidden" name="id0">
                          <input type="hidden" name="id1">
                          <input type="hidden" name="id2">
                          <input type="hidden" name="id3">
                          <input type="hidden" name="id4">
                          <input type="hidden" name="id5">
                          <input type="hidden" name="id6">
                          <input type="hidden" name="id7">
                          {{-- KODE DETAIL --}}
                          <input type="hidden" name="kode0">
                          <input type="hidden" name="kode1">
                          <input type="hidden" name="kode2">
                          <input type="hidden" name="kode3">
                          <input type="hidden" name="kode4">
                          <input type="hidden" name="kode5">
                          <input type="hidden" name="kode6">
                          <input type="hidden" name="kode7">
                          {{-- KODE SAMA KILO --}}
                          <input type="hidden" name="kode_sama_koli">

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
    $('#cb_kota_asal').change(function(){
        var idkota = $('#cb_kota_asal :selected').data('kota');
        // alert(idkota);
        var kotaid = $('#kodekota').val(idkota);
    })

    $('#cb_kota_tujuan').change(function(){
        $('#hilang').hide();
        // alert('njing');

    })
    $('#cb_provinsi_tujuan').change(function(){
        $('#hilang1').hide();
    })


        $('input[name="ed_kode"]').attr('readonly',true);
    $(document).ready( function () {
        $('#table_data').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
            "ajax": {
              "url" :  baseUrl + "/sales/tarif_cabang_koli/tabel",
              "type": "GET"
            },
            "columns": [
            { "data": "kode" },
            { "data": "asal" },
            { "data": "tujuan" },
            { "data": "provinsi" },
            { "data": "harga", render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "jenis", },
            { "data": "cabang", },
            { "data": "waktu", render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "keterangan" },
            { "data": "button" },
            ]
        });
        var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"100%"}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
        $("input[name='ed_harga'],input[name='ed_waktu']").maskMoney({thousands:'.', decimal:',', precision:-1});
    });

    $(document).on("click","#btn_add",function(){
        $("input[name='crud']").val('N');
      

        $("input[name='id0']").val('');
        $("input[name='id1']").val('');
        $("input[name='id2']").val('');
        $("input[name='id3']").val('');
        $("input[name='id4']").val('');
        $("input[name='id5']").val('');
        $("input[name='id6']").val('');
        $("input[name='id7']").val('');
        //kode
        $("input[name='kode0']").val('');
        $("input[name='kode1']").val('');
        $("input[name='kode2']").val('');
        $("input[name='kode3']").val('');
        $("input[name='kode4']").val('');
        $("input[name='kode5']").val('');
        $("input[name='kode6']").val('');
        $("input[name='kode7']").val('');
        //kode detail
        //kode sama
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
        //expre
        $('#hilang').show();

        $('#hilang1').show();
        //
        $("input[name='kode_sama_koli']").val('');
        $("select[name='cb_kota_asal']").val('').trigger('chosen:updated');
        $("select[name='cb_kota_tujuan']").val('').trigger('chosen:updated');
        $("select[name='ed_csf_penjualan']").val('').trigger('chosen:updated');
        $("select[name='ed_acc_penjualan']").val('').trigger('chosen:updated');
        $("select[name='cb_provinsi_tujuan']").val('').trigger('chosen:updated');
        $("#modal").modal("show");
    });

    $(document).on( "click",".btnedit", function() {
        var id=$(this).attr("id");
        var tujuan=$(this).data('tujuan');
        var value = {
            asal: id,tujuan:tujuan
        };
        $.ajax(
        {
            url : baseUrl + "/sales/tarif_cabang_koli/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                console.log(data);
                $("input[name='crud']").val('E');
                
                  //flag
                $("input[name='id0']").val(data[0].kode);
                $("input[name='id1']").val(data[1].kode);
                $("input[name='id2']").val(data[2].kode);
                $("input[name='id3']").val(data[3].kode);
                $("input[name='id4']").val(data[4].kode);
                $("input[name='id5']").val(data[5].kode);
                $("input[name='id6']").val(data[6].kode);
                $("input[name='id7']").val(data[7].kode);
                //kode
                $("input[name='kode0']").val(data[0].kode_detail_koli);
                $("input[name='kode1']").val(data[1].kode_detail_koli);
                $("input[name='kode2']").val(data[2].kode_detail_koli);
                $("input[name='kode3']").val(data[3].kode_detail_koli);
                $("input[name='kode4']").val(data[4].kode_detail_koli);
                $("input[name='kode5']").val(data[5].kode_detail_koli);
                $("input[name='kode6']").val(data[6].kode_detail_koli);
                $("input[name='kode7']").val(data[7].kode_detail_koli);
                //kode detail
                //kode sama
                $('input[name="waktu_regular"]').val(data[0].waktu);
                $('input[name="tarifkertas_reguler"]').val(data[0].harga);
                $('input[name="tarif0kg_reguler"]').val(data[1].harga);
                $('input[name="tarif10kg_reguler"]').val(data[2].harga);
                $('input[name="tarif20kg_reguler"]').val(data[3].harga);
                //reg
                $('input[name="waktu_express"]').val(data[4].waktu);
                $('input[name="tarifkertas_express"]').val(data[4].harga);
                $('input[name="tarif0kg_express"]').val(data[5].harga);
                $('input[name="tarif10kg_express"]').val(data[6].harga);
                $('input[name="tarif20kg_express"]').val(data[7].harga);
                //expre
                $('#hilang').hide();
                $('#hilang1').show();
                $("input[name='kodekota']").val(data[0].kode_kota);
                //
                $("input[name='kode_sama_koli']").val(data[0].kode_sama_koli);
                $("select[name='cb_kota_asal']").val(data[0].id_kota_asal).trigger('chosen:updated');
                $("select[name='cb_kota_tujuan']").val(data[0].id_kota_tujuan).trigger('chosen:updated');
                $("select[name='ed_csf_penjualan']").val(data[0].csf_penjualan).trigger('chosen:updated');
                $("select[name='ed_acc_penjualan']").val(data[0].acc_penjualan).trigger('chosen:updated');
                $("select[name='ed_cabang']").val(data[0].kode_cabang).trigger('chosen:updated');
                
                $("#modal").modal('show');

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on("click","#btnsave",function(){
      
        $.ajax(
        {
            url : baseUrl + "/sales/tarif_cabang_koli/save_data",
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
                        //$.notify('Successfull update data');
                        var table = $('#table_data').DataTable();
                        table.ajax.reload( null, false );
                        //$("#edkode").focus();
                        $("#modal").modal('hide');
                        $("#btn_add").focus();
                    }else{
                        swal("Error","Can't update customer data, error : "+data.error,"error");
                    }
                }else{
                    swal("Error","invalid order","error");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Kode Tidak boleh sama !", 'periksa sekali lagi', "warning");
            }
        });
    });

    $(document).on( "click",".btndelete", function() {
        var name = $(this).attr("name");
        var id = $(this).attr("id");
        var tujuan = $(this).data("tujuan");
        var asal = $(this).data("asal");
        var prov = $(this).data("prov");
        if(!confirm("Hapus Data " + asal +' menuju ke '+ prov + " ?")) return false;
        var value = {
            id: id,
            name: name,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "get",
            url : baseUrl + "/sales/tarif_cabang_koli/hapus_data",
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


    });
    $(document).on( "click",".btndelete_perkota", function() {
        var name = $(this).attr("name");
        var id = $(this).attr("id");
        var tujuan = $(this).data("tujuan");
        var asal = $(this).data("asal");
        if(!confirm("Hapus Data " + asal +' menuju ke '+ tujuan + " ?")) return false;
        var value = {
            id: id,name:name,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "get",
            url : baseUrl + "/sales/tarif_cabang_koli/hapus_data_perkota",
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


    });

</script>
@endsection
