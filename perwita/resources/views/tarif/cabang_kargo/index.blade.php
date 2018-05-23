
@extends('main')


@section('title', 'dashboard')


@section('content')
<style type="text/css">
    .cssright { text-align: right; }
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
                    <h2> TARIF CABANG KARGO </h2>
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
                            <strong> Tarif Cabang Kargo </strong>
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
                      @if(Auth::user()->punyaAkses('Tarif Cabang Kargo','tambah'))
                       <button  type="button" class="btn btn-success " id="btn_add" name="btnok"><i class="glyphicon glyphicon-plus"></i>Tambah Data</button>
                       @endif
                      @if(Auth::user()->punyaAkses('Tarif Cabang Kargo','print'))
                       <a href="{{ url('/laporan_master_penjualan/tarif_cabang_kargo') }}" class="btn btn-warning"><i class="glyphicon glyphicon-print"></i>Laporan</a>
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
                       <!--  <div class="form-group">

                            <div class="form-group">
                            <label for="bulan_id" class="col-sm-1 control-label">Bulan</label>
                            <div class="col-sm-2">
                             <select id="bulan_id" name="bulan_id" class="form-control">
                                                      <option value="">Pilih Bulan</option>

                              </select>
                            </div>
                          </div>
                          </div>
                           <div class="form-group">

                            <div class="form-group">
                            <label for="tahun" class="col-sm-1 control-label">Tahun</label>
                            <div class="col-sm-2">
                             <select id="tahun" name="tahun" class="form-control">
                                                      <option value="">Pilih Tahun</option>

                              </select>
                            </div>
                          </div>
                          </div> -->
                            <div class="row">
                                <table class="table table-striped table-bordered dt-responsive nowrap table-hover">

                            </table>
                        <div class="col-xs-6">



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
                                <th> Jenis </th>
                                <th> Cabang </th>
                                <th> Angkutan </th>
                                <th> Tarif </th>
                                <th> Waktu (Hari) </th>
                                <th style="width:80px"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <!-- modal -->
                <div id="modal" class="modal" >
                  <div class="modal-dialog " style="min-width: 1000px">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insert Edit Tarif Cabang Kargo</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal kirim">
                          <table class="table table-striped table-bordered table-hover ">
                            <tbody>
                                <tr>
                                    <td style="width:120px; padding-top: 0.4cm" hidden="" colspan="5">Kode</td>
                                    <td colspan="5">
                                        <input type="hidden"  name="ed_kode" class="form-control a" style="text-transform: uppercase" >
                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                        <input type="hidden" name="ed_kode_old" class="form-control" >
                                        <input type="hidden" name="ed_kode_lama" class="form-control" >
                                        <input type="hidden" class="form-control" name="crud" class="form-control" >
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Kota Asal</td>
                                    <td>   
                                        <select class="chosen-select-width b"  name="cb_kota_asal" style="width:100%" id="cb_kota_asal">
                                            <option value="" selected="" disabled="">Pilih - Kota asal</option>
                                        @foreach ($kota as $row)
                                            <option value="{{ $row->id }}" data-kota="{{ $row->kode_kota }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>

                                     <td style="padding-top: 0.4cm">Angkutan</td>
                                    <td>   
                                        <select class="form-control d "  name="cb_angkutan" style="width:100%">
                                            <option value="" selected="" disabled="">Pilih - Kota angkatan</option>
                                        @foreach ($angkutan as $row)
                                            <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                    </tr>
                                    <td class="hilang" style="padding-top: 0.4cm">Kota Tujuan</td>
                                    <td class="hilang" id="kota_col">   
                                        <select class="chosen-select-width c "  name="cb_kota_tujuan" id="cb_kota_tujuan" style="width:100%">
                                           <option value="" selected="" readonly="">Pilih - Kota tujuan</option>
                                        @foreach ($kota as $row)
                                            <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                
                                    <td class="hilang1" style="padding-top: 0.4cm">Provinsi Tujuan</td>
                                    <td class="hilang1" id="prov_col">   
                                        <select class="chosen-select-width c " name="cb_provinsi_tujuan" id="cb_provinsi_tujuan" style="width:100%" i>
                                            <option value="" selected="" readonly="">Pilih - Provinsi tujuan</option>
                                        @foreach ($prov as $prov)
                                            <option value="{{ $prov->id }}"> {{ $prov->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                 @if(Auth::user()->punyaAkses('Tarif Cabang Kargo','cabang'))
                                 <tr>
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    <td>
                                        <select  class="form-control d" name="ed_cabang"  style="text-align: right;">
                                        
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
                                        <select  class="form-control d" name="ed_cabang"  style="text-align: right;">
                                        
                                            <option value="">-- Pilih Cabang Terlebih Dahulu --</option>
                                            @foreach ($cabang_default as $a)
                                                <option @if(Auth::user()->kode_cabang == $a->kode) selected="" @endif value="{{ $a->kode }}" >{{ $a->kode }} - {{ $a->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="padding-top: 0.4cm">tarif</td>
                                    <td>   
                                        <select class="form-control e"  name="cb_jenis" style="width:100%">
                                            <option value="" selected="" disabled="">Pilih - jenis tarif</option>
                                            @foreach ($jenis_tarif as $row)
                                            <option value="{{ $row->jt_id }}"> {{$row->jt_nama_tarif}} </option>
                                             @endforeach
                                        </select>
                                    </td>

                                    <td style="padding-top: 0.4cm">satuan</td>
                                    <td>   
                                        <select class="form-control e"  name="satuan" style="width:100%">
                                            <option value="" selected="" disabled="">Pilih - Satuan jenis</option>
                                            @foreach ($satuan as $row)
                                            <option value="{{ $row->kode }}"> {{$row->nama}} </option>
                                             @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Harga</td>
                                    <td><input type="text" class="form-control f" name="ed_harga" style="text-align: right;"></td>
                                    

                                    <td style="padding-top: 0.4cm">Waktu/Estimasi</td>
                                    <td><input type="text" class="form-control g" name="ed_waktu" style="text-align: right;"></td>
                                </tr>
                                </tr>
                                
                                <tr>
                                    <td style="padding-top: 0.4cm">Acc Penjualan</td>
                                    <td>
                                        <select  class="chosen-select-width form-control d" name="ed_acc_penjualan"  style="text-align: right;">
                                        
                                            <option value="">Pilih - Acc Penjualan</option>
                                            @foreach ($accpenjualan as $b)
                                                <option value="{{ $b->id_akun }}" >{{ $b->id_akun }} - {{ $b->nama_akun }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="padding-top: 0.4cm">Csf Penjualan</td>
                                    <td>
                                        <select  class="chosen-select-width form-control d" name="ed_csf_penjualan" style="text-align: right;">
                                        
                                            <option value="">Pilih - Csf Penjualan</option>
                                            @foreach ($csfpenjualan as $a)
                                                <option value="{{ $a->id_akun }}" >{{ $a->id_akun }} - {{ $a->nama_akun }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                

                            </tbody>
                          </table>
                          <input type="hidden" name="kodekota" id="kodekota">

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
        $('.hilang1').hide();
        $('#kota_col').attr('colspan','3');

    })
    $('#cb_provinsi_tujuan').change(function(){
        $('.hilang').hide();
        $('#prov_col').attr('colspan','3');
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
              "url" :  baseUrl + "/sales/tarif_cabang_kargo/tabel",
              "type": "GET"
            },
            "columns": [
            { "data": "kode" },
            { "data": "asal" },
            { "data": "tujuan" },
            { "data": "provinsi" },
            { "data": "tarifnama" },
            { "data": "cabang" },
            { "data": "angkutan" },
            { "data": "harga", render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "waktu", render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
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
        $("input[name='ed_harga'],input[name='ed_waktu']").maskMoney({thousands:'', decimal:'', precision:-1});
    });

    $(document).on("click","#btn_add",function(){
        $("input[name='crud']").val('N');
        $("input[name='ed_kode']").val('');
        $("input[name='ed_kode_old']").val('');

        $("input[name='ed_harga']").val(0);
        $("input[name='ed_waktu']").val(0);
        $("select[name='cb_kota_asal']").val('').trigger('chosen:updated');
        $("select[name='cb_kota_tujuan']").val('').trigger('chosen:updated');

        $("select[name='cb_jenis']").val('');
        $("select[name='cb_angkutan']").val('');
        $("select[name='satuan']").val('');
        $("select[name='cb_kota_tujuan']").val('').trigger('chosen:updated');
        $("select[name='ed_acc_penjualan']").val('').trigger('chosen:updated');
        $("select[name='ed_csf_penjualan']").val('').trigger('chosen:updated');
        $("select[name='cb_provinsi_tujuan']").val('').trigger('chosen:updated');

        $('.hilang1').show();
        $('.hilang').show();
        $('#kota_col').attr('colspan','1');
        $('#prov_col').attr('colspan','1');
        

        $("#modal").modal("show");
        $("input[name='ed_kode']").focus();
    });

    $(document).on( "click",".btnedit", function() {
        var id=$(this).attr("id");
        var value = {
            id: id
        };
        $.ajax(
        {
            url : baseUrl + "/sales/tarif_cabang_kargo/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                console.log(data);
                $("input[name='crud']").val('E');
                $("input[name='ed_kode']").val(data[0].kode);
                $("input[name='ed_kode_old']").val(data[0].kode_detail_kargo);
                $("input[name='ed_kode_lama']").val(data[0].kode);

                $("input[name='ed_harga']").val(data[0].harga);
                $("input[name='ed_waktu']").val(data[0].waktu);
                $("select[name='cb_jenis']").val(data[0].jenis);
                $("select[name='cb_angkutan']").val(data[0].kode_angkutan);
                $("select[name='cb_kota_asal']").val(data[0].id_kota_asal).trigger('chosen:updated');
                $("select[name='cb_kota_tujuan']").val(data[0].id_kota_tujuan).trigger('chosen:updated');
                $("select[name='cb_provinsi_tujuan']").val(data[0].prov).trigger('chosen:updated');
                $("select[name='ed_cabang']").val(data[0].kode_cabang);
                $("select[name='satuan']").val(data[0].kode_satuan);
                $("select[name='cb_kota_tujuan']").val(data[0].id_kota_tujuan).trigger('chosen:updated');

                $("select[name='ed_acc_penjualan']").val(data[0].acc_penjualan).trigger('chosen:updated');
                $("select[name='ed_csf_penjualan']").val(data[0].csf_penjualan).trigger('chosen:updated');
                $("#modal").modal('show');
                $("input[name='kodekota']").val(data[0].kode_kota);

                $('.hilang').show();
                $('.hilang1').hide();
                $('#kota_col').attr('colspan','3');

                $("input[name='ed_kode']").focus();
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on("click","#btnsave",function(){
       var a = $('select[name="cb_kota_asal"]').val();
       var b = $('select[name="satuan"]').val();
       if(a == null){
            Command: toastr["warning"]("Kota Asal Tidak Boleh Kosong", "Peringatan!")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }
        if(b == null || ''){
            Command: toastr["warning"]("Satuan Tidak Boleh Kosong", "Peringatan!")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }
        if($('input[name="ed_waktu"]').val() == '0'){
            Command: toastr["warning"]("Harga Tidak Boleh Kosong", "Peringatan!")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }
        if($('input[name="ed_harga"]').val() == '0'){
            Command: toastr["warning"]("Waktu Tidak Boleh Kosong", "Peringatan!")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }

        $.ajax(
        {
            url : baseUrl + "/sales/tarif_cabang_kargo/save_data",
            type: "get",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            
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
                  console.log(data.result);
                    swal(data.result,'Cek sekali lagi',"warning");
                }
            
                
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Terjadi Kealahan !", 'Kemunkinan Data Terdapat Kesamaan', "warning");
            }
        });
    });

    $(document).on( "click",".btndelete", function() {
        var name = $(this).attr("name");
        var id = $(this).attr("id");
        if(!confirm('Apakah Anda Yaking'+"Hapus Data "+" ?")) return false;
        var value = {
            id: id,name:name,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "get",
            url : baseUrl + "/sales/tarif_cabang_kargo/hapus_data",
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
            url : baseUrl + "/sales/tarif_cabang_kargo/hapus_data_perkota",
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
