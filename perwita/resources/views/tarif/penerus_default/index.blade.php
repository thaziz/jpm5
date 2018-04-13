
@extends('main')


@section('title', 'dashboard')


@section('content')
<style type="text/css">
    .cssright { text-align: right; }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> TARIF PENERUS DEFAULT </h2>
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
                            <strong> Tarif Penerus Default </strong>
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
                                <th style="width:100px"> Jenis</th>
                                <th> Tipe Kiriman</th>
                                <th> Keterangan </th>
                                <th> Harga </th>
                                <th> Kode Cabang </th>
                                <th style="width:50px"> Aksi </th>
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
                        <h4 class="modal-title">Insert Edit Tarif Penerus Default</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal kirim">
                          <table class="table table-striped table-bordered table-hover ">
                            <tbody>
                                <tr>
                                    <td style="padding-top: 0.4cm">Tipe Kiriman</td>
                                    <td>   
                                        <select class="form-control b"  name="cb_tipe_kiriman" id="cb_tipe_kiriman" style="width:100%">
                                            <option value="" selected="" disabled="">-- Pilih kiriman --</option>
                                            <option value="DOKUMEN">DOKUMEN</option>
                                            <option value="KILOGRAM">KILOGRAM</option>
                                            <option value="KOLI">KOLI</option>
                                            <option value="SEPEDA">SEPEDA</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr id="hilangjenis">
                                    <td style="padding-top: 0.4cm">Jenis</td>
                                    <td id="jenissep">   
                                        <select class="form-control a"  name="cb_jenis" id="cb_jenis" style="width:100%">
                                            <option value="" selected="" disabled="">-- Pilih jenis --</option>
                                            <option value="REGULER">REGULER</option>
                                            <option value="EXPRESS">EXPRESS</option>
                                        </select>
                                        
                                    </td>
                                </tr>
                                <input type="hidden" name="ed_id" class="form-control" style="text-transform: uppercase" >
                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                        <input type="hidden" class="form-control" name="crud" class="form-control" >
                                <tr>
                                    <td style="padding-top: 0.4cm" id="test">Keterangan</td>
                                    <td id="test2">   
                                        <select class="form-control c"  name="cb_keterangan" id="cb_keterangan" style="width:100%">
                                            <option value="" selected="" disabled="">-- Pilih keterangan --</option>
                                            <option value="TARIF 0 KG SAMPAI 10 KG">TARIF 0 KG SAMPAI 10 KG</option>
                                            <option value="TARIF 10 KG SAMPAI 20 KG">TARIF 10 KG SAMPAI 20 KG</option>
                                            <option value="TARIF 20 KG SAMPAI 30 KG">TARIF 20 KG SAMPAI 30 KG</option>
                                            <option value="TARIF DI ATAS 30 KG">TARIF DI ATAS 30 KG</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    <td>
                                        <select  class="form-control d" name="ed_cabang" style="text-align: right;">
                                        
                                            <option value="">-- Pilih Cabang Terlebih Dahulu --</option>
                                            @foreach ($cabang_default as $a)
                                                <option value="{{ $a->kode }}" >{{ $a->kode }} - {{ $a->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Harga</td>
                                    <td>
                                        <select  class="form-control d" name="ed_harga" id="ed_harga" style="text-align: right;">
                                        
                                            <option value="">-- Pilih Harga Zona Terlebih Dahulu --</option>
                                            @foreach ($zona as $el)
                                                <option value="{{ $el->harga_zona }}" data-id="{{ $el->id_zona }}">{{ $el->nama }} - {{ $el->harga_zona }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <input type="hidden" name="id_zona_foreign">

                            </tbody>
                          </table>


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

    $('#ed_harga').change(function(){
        var hargafind = $(this).find(':selected').data('id');
        // alert(hargafind);
        $('input[name="id_zona_foreign"]').val(hargafind);

    });
    $('#cb_tipe_kiriman').change(function(){
    var tipe = $('#cb_tipe_kiriman').find(':selected').val();
   
    if (tipe == 'SEPEDA') {
            $('#cb_keterangan').hide();
            $('#test2').html('<input tipe="text" name="cb_keterangan" class="form-control">');

            $('#jenissep').html(' <select class="form-control b"  name="cb_jenis" id="cb_jenis" style="width:100%">'+
                                            '<option value="" selected="" disabled="">-- Pilih kiriman --</option>'+
                                           '<option value="sepeda">SEPEDA</option>'+
                                           '<option value="bebek_matik">BEBEK/MATIK</option>'+
                                           '<option value="laki_sport">Laki/SPORT</option>'+
                                           '<option value="moge">MOGE</option>'+
                                        '</select>');
            $('#test').hide();
            $('#test2').hide();
        }

    if(tipe == 'KILOGRAM'){
            $('#test').show();
            $('#test2').show();
            $('#test2').html('<select class="form-control c"  name="cb_keterangan" id="cb_keterangan" style="width:100%">'+'<option value="" selected="" disabled="">-- Pilih keterangan --</option>'+'<option value="TARIF 0 KG SAMPAI 10 KG">TARIF 0 KG SAMPAI 10 KG</option>'+
                                                        '<option value="TARIF 10 KG SAMPAI 20 KG">TARIF 10 KG SAMPAI 20 KG</option>'+'</select>');
            // $('#hilangjenis').show();
            $('#jenissep').html(' <select class="form-control b"  name="cb_jenis" id="cb_jenis" style="width:100%">'+
                                            '<option value="" selected="" disabled="">-- Pilih kiriman --</option>'+
                                          ' <option value="REGULER">REGULER</option>'+
                                           ' <option value="EXPRESS">EXPRESS</option>'+
                                        '</select>');
    }
    if(tipe == 'DOKUMEN'){
            $('#test').hide();
            $('#test2').hide();
            $('#test2').html('<input tipe="text" name="cb_keterangan" class="form-control">');
          $('#jenissep').html(' <select class="form-control b"  name="cb_jenis" id="cb_jenis" style="width:100%">'+
                                            '<option value="" selected="" disabled="">-- Pilih kiriman --</option>'+
                                          ' <option value="REGULER">REGULER</option>'+
                                           ' <option value="EXPRESS">EXPRESS</option>'+
                                           ' <option value="OUTLET">OUTLET</option>'+
                                        '</select>');
    }
    if(tipe == 'KOLI'){
            $('#test').show();
            $('#test2').show();
            $('#test2').html(' <select class="form-control c"  name="cb_keterangan" id="cb_keterangan" style="width:100%">'+
                                            '<option value="" selected="" disabled="">-- Pilih keterangan --</option>'+
                                            '<option value="TARIF 0 KG SAMPAI 10 KG">TARIF 0 KG SAMPAI 10 KG</option>'+
                                            '<option value="TARIF 10 KG SAMPAI 20 KG">TARIF 10 KG SAMPAI 20 KG</option>'+
                                            '<option value="TARIF 20 KG SAMPAI 30 KG">TARIF 20 KG SAMPAI 30 KG</option>'+
                                            '<option value="TARIF DI ATAS 30 KG">TARIF DI ATAS 30 KG</option>'+
                                        '</select>');
           $('#jenissep').html(' <select class="form-control b"  name="cb_jenis" id="cb_jenis" style="width:100%">'+
                                            '<option value="" selected="" disabled="">-- Pilih kiriman --</option>'+
                                          ' <option value="REGULER">REGULER</option>'+
                                           ' <option value="EXPRESS">EXPRESS</option>'+
                                        '</select>');
    }
    })
    

    $('#cb_jenis').change(function(){
        var jenis = $('#cb_jenis').find(':selected').val();
        var tipe = $('#cb_tipe_kiriman').find(':selected').val();
        // alert(abc);
        alert(jenis); alert(tipe);
        if(tipe == 'DOKUMEN' && jenis == 'REGULER') {
           
        $('#test2').html('<input tipe="text" name="cb_keterangan" class="form-control">');
        }else if (jenis == 'EXPRESS' && tipe == 'DOKUMEN') {
            
            $('#test2').html('<input tipe="text" name="cb_keterangan" class="form-control">');
        }

        if (tipe == 'SEPEDA') {
            $('#cb_keterangan').hide();
            $('#test2').html('<input tipe="text" name="cb_keterangan" class="form-control">');

            $('#hilangjenis').hide();
            $('#test').show();
            $('#test2').show();
        }

        if (jenis == 'REGULER' && tipe == 'KILOGRAM') {
            $('#cb_keterangan').html('<option value="" selected="" disabled="">-- Pilih keterangan --</option>'+'<option value="TARIF 0 KG SAMPAI 10 KG">TARIF 0 KG SAMPAI 10 KG</option>'+
                                                        '<option value="TARIF 10 KG SAMPAI 20 KG">TARIF 10 KG SAMPAI 20 KG</option>');

            
            $('#test2').show();
        }else if (jenis == 'EXPRESS' && tipe == 'KILOGRAM') {
            $('#cb_keterangan').html('<option value="" selected="" disabled="">-- Pilih keterangan --</option>'+'<option value="TARIF 0 KG SAMPAI 10 KG">TARIF 0 KG SAMPAI 10 KG</option>'+
                                                        '<option value="TARIF 10 KG SAMPAI 20 KG">TARIF 10 KG SAMPAI 20 KG</option>');

            $('#test').show();
            $('#test2').html('<select class="form-control c"  name="cb_keterangan" id="cb_keterangan" style="width:100%">'+
                                            '<option value="" selected="" disabled="">-- Pilih keterangan --</option>'+
                                            '<option value="TARIF 0 KG SAMPAI 10 KG">TARIF 0 KG SAMPAI 10 KG</option>'+
                                            '<option value="TARIF 10 KG SAMPAI 20 KG">TARIF 10 KG SAMPAI 20 KG</option>'+
                                            '<option value="TARIF 20 KG SAMPAI 30 KG">TARIF 20 KG SAMPAI 30 KG</option>'+
                                            '<option value="TARIF DI ATAS 30 KG">TARIF DI ATAS 30 KG</option>'+
                                        '</select>');
        }

        if (jenis == 'REGULER' && tipe == 'KOLI') {
            $('#cb_keterangan').html('<option value="" selected="" disabled="">-- Pilih keterangan --</option>'+
                                                        '<option value="TARIF 0 KG SAMPAI 10 KG">TARIF 0 KG SAMPAI 10 KG</option>'+
                                                        '<option value="TARIF 10 KG SAMPAI 20 KG">TARIF 10 KG SAMPAI 20 KG</option>'+
                                                        '<option value="TARIF 20 KG SAMPAI 30 KG">TARIF 20 KG SAMPAI 30 KG</option>'+
                                                        '<option value="TARIF DI ATAS 30 KG">TARIF DI ATAS 30 KG</option>');

            $('#test').show();
            $('#test2').show();
        }
        else if (jenis == 'EXPRESS' && tipe == 'KOLI') {
            $('#cb_keterangan').html('<option value="" selected="" disabled="">-- Pilih keterangan --</option>'+
                                                        '<option value="TARIF 0 KG SAMPAI 10 KG">TARIF 0 KG SAMPAI 10 KG</option>'+
                                                        '<option value="TARIF 10 KG SAMPAI 20 KG">TARIF 10 KG SAMPAI 20 KG</option>'+
                                                        '<option value="TARIF 20 KG SAMPAI 30 KG">TARIF 20 KG SAMPAI 30 KG</option>'+
                                                        '<option value="TARIF DI ATAS 30 KG">TARIF DI ATAS 30 KG</option>');

            $('#test').show();
            $('#test2').show();
        }

        
        
    })

    $(document).ready( function () {
        $('#table_data').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
            "ajax": {
              "url" :  baseUrl + "/sales/tarif_penerus_default/tabel",
              "type": "GET"
            },
            "columns": [
            { "data": "jenis", },
            { "data": "tipe_kiriman", },
            { "data": "keterangan" },
            { "data": "harga", render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "cabang" },
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
         $('#test').show();
            $('#test2').show();
        $("input[name='crud']").val('N');
        $("input[name='ed_id']").val('');
        $("select[name='cb_jenis']").val('');
        $("select[name='cb_tipe_kiriman']").val('');
        $("select[name='ed_harga']").val('');
        $("select[name='ed_cabang']").val('');
        $("select[name='cb_keterangan']").val('');
        $("#modal").modal("show");
        $("input[name='cb_tipe_kiriman']").focus();
    });

    $(document).on( "click",".btnedit", function() {
        var id=$(this).attr("id");
        var value = {
            id: id
        };
        $.ajax(
        {
            url : baseUrl + "/sales/tarif_penerus_default/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                console.log(data)
                $("input[name='crud']").val('E');
                $("input[name='ed_id']").val(data.id);
                $("select[name='ed_harga']").val(data.harga);
                $("select[name='cb_jenis']").val(data.jenis);
                $("select[name='id_zona_foreign']").val(data.id_zona_foreign);
                $("select[name='ed_cabang']").val(data.cabang_default);
                $("select[name='cb_tipe_kiriman']").val(data.tipe_kiriman);
                $("#modal").modal('show');
                $("input[name='ed_kode']").focus();
                if(data.tipe_kiriman == "KILOGRAM" || data.tipe_kiriman == 'KOLI' ){
                    $("select[name='cb_keterangan']").val(data.keterangan);
                    // alert('a');
                    $('#test2').show();
                    $('#test').show();
                }else if(data.tipe_kiriman == "DOKUMEN" || data.tipe_kiriman == 'SEPEDA' ){
                    $('#test2').hide();
                    $('#test').hide();
                    // alert('b');
                }
                
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
            url : baseUrl + "/sales/tarif_penerus_default/save_data",
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
                        alert('data berhasil di simpan');
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
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }
                }else{
                    swal("Error","invalid order","error");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Data sudah ada di Database!", 'Cek Data Sekali lagi!', "warning");
            }
        });
    });

    $(document).on( "click",".btndelete", function() {
        var name = $(this).attr("name");
        var id = $(this).attr("id");
        if(!confirm("Hapus Data " +name+ " ?")) return false;
        var value = {
            id: id,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "get",
            url : baseUrl + "/sales/tarif_penerus_default/hapus_data",
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
