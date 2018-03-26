
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
                    <h2> TARIF CABANG DOKUMEN </h2>
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
                            <strong> Tarif Cabang Dokumen </strong>
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
                       <button  type="button" class="btn btn-success " id="btn_add" name="btnok"><i class="glyphicon glyphicon-plus"></i>Tambah Data</button>
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
                                <th style="width:15%"> Kode</th>
                                <th> Asal </th>
                                <th> Tujuan </th>
                                <th> Provinsi Tujuan </th>
                                <th> Tarif </th>
                                <th> Jenis </th>
                                <th> Waktu (Hari) </th>
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
                        <h4 class="modal-title">Insert Edit Tarif Cabang Dokumen</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal kirim" style="width: 853px">
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
                                <tr id="hilang2">
                                    <td style="padding-top: 0.4cm">Kota Tujuan</td>
                                    <td>   
                                        <select class="chosen-select-width c"  name="cb_kota_tujuan" id="cb_kota_tujuan" style="width:100%" i>
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
                                 <tr>
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    <td>
                                        <select  class="form-control d" name="ed_cabang" id="ed_harga" style="text-align: right;">
                                        
                                            <option value="">-- Pilih Cabang Terlebih Dahulu --</option>
                                            @foreach ($cabang_default as $a)
                                                <option value="{{ $a->kode }}" >{{ $a->kode }} - {{ $a->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Acc Penjualan</td>
                                    <td>
                                        <select  class="form-control d" name="ed_acc_penjualan"  style="text-align: right;">
                                        
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
                                        <select  class="form-control d" name="ed_csf_penjualan" style="text-align: right;">
                                        
                                            <option value="">-- Pilih Csf Penjualan Terlebih Dahulu --</option>
                                            @foreach ($csfpenjualan as $a)
                                                <option value="{{ $a->id_akun }}" >{{ $a->id_akun }} - {{ $a->nama_akun }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                          </table>
                          
                          <table class="table-striped table-bordered" > 
                              <thead>
                                  <tr >
                                      <th style="padding: 7px; text-align: center;"  colspan="2">REGULAR</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td class="pad">Harga</td>
                                      <td class="pad"><input type="text" name="harga_regular"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Waktu/Estimasi</td>
                                      <td class="pad"><input type="text" name="waktu_regular"></td>
                                  </tr>
                              </tbody>
                          </table> 
                          <table class="table-striped table-bordered" style="margin-left: 300px; margin-top: -124px; position: fixed; " > 
                              <thead>
                                  <tr>
                                      <th style="padding: 7px; text-align: center;"  colspan="2">EXPRESS</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td class="pad">Harga</td>
                                      <td class="pad"><input type="text" name="harga_express"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Waktu/Estimasi</td>
                                      <td class="pad"><input type="text" name="waktu_express"></td>
                                  </tr>
                              </tbody>
                          </table>
                          <table class="table-striped table-bordered" style="margin-left: 600px; margin-top: -124px; position: fixed; " > 
                              <thead>
                                  <tr>
                                      <th style="padding: 7px; text-align: center;"  colspan="2">OUTLET</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td class="pad">Harga</td>
                                      <td class="pad"><input type="text" name="harga_outlet"></td>
                                  </tr>
                              </tbody>
                          </table>
                          <input type="hidden" name="id_reguler" id="id_reguler">
                          <input type="hidden" name="jenis_reguler">
                          <input type="hidden" name="id_express" id="id_express">
                          <input type="hidden" name="jenis_express">
                          <input type="hidden" name="id_outlet" id="id_outlet">
                          <input type="hidden" name="jenis_outlet">
                          <input type="hidden" name="kodekota" id="kodekota">

                          {{--  --}}
                          <input type="hidden" name="id_reguler_edit">
                          <input type="hidden" name="id_express_edit">
                          <input type="hidden" name="id_outlet_edit">
                          
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
        var kotaid = $('#kodekota').val(idkota);

    })
   $('#cb_kota_tujuan').change(function(){
        $('#hilang').hide();

    })
    $('#cb_provinsi_tujuan').change(function(){
        $('#hilang2').hide();
    })


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
              "url" :  baseUrl + "/sales/tarif_cabang_dokumen/tabel",
              "type": "GET"
            },
            "columns": [
            { "data": "kode" },
            { "data": "asal" },
            { "data": "tujuan" },
            { "data": "provinsi" },
            { "data": "harga", render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "jenis", },
            { "data": "waktu","sClass": "cssright" },
            //{ "data": "tipe" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "button",render: $.fn.dataTable.render.number( '.'),"sClass": "cssmid"  },
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
        $("input[name='id_reguler']").val('');
        $("input[name='id_express']").val('');
        $("input[name='id_outlet']").val('');
        //
        $("input[name='harga_regular']").val('');
        $("input[name='harga_express']").val('');
        $("input[name='harga_outlet']").val('');
        //
        $("input[name='waktu_regular']").val('');
        $("input[name='waktu_express']").val('');
        //  
        $("input[name='jenis_reguler']").val('');
        $("input[name='jenis_express']").val('');
        $("input[name='jenis_outlet']").val('');
        $('#hilang').show();

        $('#hilang2').show();
       
               
        $("select[name='cb_kota_asal']").val('').trigger('chosen:updated');
        $("select[name='cb_kota_tujuan']").val('').trigger('chosen:updated');
        $("select[name='cb_provinsi_tujuan']").val('').trigger('chosen:updated');
        $("#modal").modal("show");
    });

    $(document).on( "click",".btnedit", function() {
        var id=$(this).attr("id");
        var tuju = $(this).data('tujuan');
        var value = {
            asal: id,tujuan :tuju
        };
        $.ajax(
        {
            url : baseUrl + "/sales/tarif_cabang_dokumen/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                console.log(data);

                $("input[name='crud']").val('E');
                //
                $("input[name='id_reguler']").val(data[0].kode);
                $("input[name='id_express']").val(data[1].kode);
                //
                $("input[name='harga_regular']").val(data[0].harga);
                $("input[name='harga_express']").val(data[1].harga);
                //
                $("input[name='waktu_regular']").val(data[0].waktu);
                $("input[name='waktu_express']").val(data[1].waktu);
                //  
                $("input[name='jenis_reguler']").val(data[0].jenis);
                $("input[name='jenis_express']").val(data[1].jenis);
                //
               
                var gege = data[2];
                // alert(gege);
                if (gege !== undefined) {
                  $("input[name='id_outlet']").val(data[2].kode);
                  $("input[name='harga_outlet']").val(data[2].harga);
                  $("input[name='jenis_outlet']").val(data[2].jenis);
                  $("input[name='id_outlet_edit']").val(data[2].kode_detail);
                }else if (gege === undefined){
                  $("input[name='id_outlet']").val('');
                  $("input[name='harga_outlet']").val('');
                  $("input[name='jenis_outlet']").val('');
                  $("input[name='id_outlet_edit']").val('');
                }
                
                  
                $("input[name='id_reguler_edit']").val(data[0].kode_detail);
                $("input[name='id_express_edit']").val(data[1].kode_detail);


                $("input[name='ed_kode_old']").val(data[0].kode_sama);
                $("select[name='cb_kota_asal']").val(data[0].id_kota_asal).trigger('chosen:updated');
                $("select[name='cb_kota_tujuan']").val(data[0].id_kota_tujuan).trigger('chosen:updated');
                $("select[name='ed_cabang']").val(data[0].kode_cabang).trigger('chosen:updated');
                $("select[name='cb_provinsi_tujuan']").val(data[0].id_provinsi_cabdokumen).trigger('chosen:updated');
                $("select[name='ed_acc_penjualan']").val(data[0].acc_penjualan).trigger('chosen:updated');
                $("select[name='ed_csf_penjualan']").val(data[0].csf_penjualan).trigger('chosen:updated');
                $("#modal").modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on("click","#btnsave",function(){
        var data = $('.kirim :input').serialize();
        
        console.log(data);
        $.ajax(
        {
            url : baseUrl + "/sales/tarif_cabang_dokumen/save_data",
            type: "get",
            dataType:"JSON",
            data : $('.kirim :input').serialize(),
            success: function(data, textStatus, jqXHR,hasil_cek)
            {
              console.log(data);
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
                  console.log(data.hasil_cek);
                    swal(data.hasil_cek,'Cek sekali lagi',"warning");
                }
            },
            error: function(data,jqXHR, textStatus, errorThrown,hasil_cek)
            {

               // console.log(hasil_cek);
               swal("Terdapat Kesalahan!", data.hasil_cek, "warning");
            }
        });
    });

    $(document).on( "click",".btndelete", function() {
        var name = $(this).attr("name");
        var prov = $(this).data("prov");
        var asal = $(this).data("asal");
        var id = $(this).attr("id");
        if(!confirm("Hapus Data seluruh" + asal +' menuju ke '+ prov + " ?")) return false;
        var value = {
            id: id,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "get",
            url : baseUrl + "/sales/tarif_cabang_dokumen/hapus_data",
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
            url : baseUrl + "/sales/tarif_cabang_dokumen/hapus_data_perkota",
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
