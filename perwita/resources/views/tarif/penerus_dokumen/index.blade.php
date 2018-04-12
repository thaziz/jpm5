
@extends('main')


@section('title', 'dashboard')


@section('content')
<style type="text/css">
    .cssright { text-align: right; }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> TARIF PENERUS DOKUMEN </h2>
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
                            <strong> Tarif Penerus Dokumen </strong>
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
                                <th hidden="" align="center"> Kota Asal</th>
                        <th hidden="" align="center">id Kota Asal</th>
                        <th align="center"> Kota Asal</th>
                        <th align="center"> Kota Tujuan</th>
                        <th align="center">kode</th>
                        <th align="center"> Jenis </th>
                        <th align="center"> Waktu </th>
                        <th align="center"> Tarif</th>
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
                        <h4 class="modal-title">Insert Edit Tarif Penerus Dokumen</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal kirim">
                          <table class="table table-striped table-bordered table-hover ">
                            <tbody>
                                
                                <tr>
                                    <td style="padding-top: 0.4cm">Kode</td>
                                    <td><input type="text" name="ed_kode" class="form-control" placeholder="OTOMATIS"></td>
                                    <input type="hidden" name="ed_kode_old">
                                    <input type="hidden" name="crud">
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Tipe Kiriman</td>
                                    <td>{{-- <input type="text" value="DOKUMEN" readonly="" > --}}
                                        <select  name="ed_tipe" class="form-control">
                                          <option value="">Pilih - Tipe</option>
                                          <option value="DOKUMEN">DOKUMEN</option>
                                          <option value="KILOGRAM">KILOGRAM</option>
                                          <option value="KOLI">KOLI</option>
                                          <option value="SEPEDA">SEPEDA</option>
                                        </select>
                                    </td>
                                </tr>
                               
                               <tr>
                                   <td style="padding-top: 0.4cm"> Provinsi </td>
                                   <td >
                                       <select  name="ed_provinsi" id="provinsi" class="form-control">
                                           <option selected="" disabled="">-- Pilih Provinsi --</option>
                                           @foreach ($provinsi as $a)
                                                <option value="{{ $a->id }}">{{ $a->nama }}</option>
                                           @endforeach
                                       </select>
                                   </td>
                               </tr>

                               <tr>
                                   <td style="padding-top: 0.4cm"> Kota </td>
                                   <td>
                                        <select readonly   name="ed_kota" id="kota"  class="form-control">
                                            <option disabled="" selected="">-</option>  
                                            @foreach ($kota as $b)
                                                <option value="{{ $b->id }}">{{ $b->nama }}</option>
                                           @endforeach      
                                        </select>
                                    </td>
                               </tr>

                               <tr>
                                   <td style="padding-top: 0.4cm"> kecamatan </td>
                                   <td>
                                        <select readonly name="ed_kecamatan" id="kecamatan"  class="form-control">
                                            <option disabled="" selected="">-</option>
                                            @foreach ($kecamatan as $c)
                                                <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                           @endforeach               
                                        </select>
                                    </td>
                               </tr>

                               <tr>
                                   <td style="padding-top: 0.4cm"> Tarif Reguler</td>
                                   <td>
                                         <select id="ed_reguler"  class="form-control chosen-select-width" name="ed_reguler">
                                            <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach               
                                        </select>
                                   </td>
                               </tr>

                               <tr>
                                   <td style="padding-top: 0.4cm"> Tarif Express</td>
                                   <td>
                                        <select id="ed_express"  class="form-control chosen-select-width" name="ed_express">
                                            <option disabled="" selected="">Pilih - Zona</option>
                                            @foreach ($zona as $d)
                                                <option value="{{ $d->id_zona }}" data-foreign="{{ $d->id_zona }}">{{ $d->nama_zona }} - {{ $d->harga_zona }}</option>
                                           @endforeach               
                                        </select>
                                    </td>
                               </tr>

                               {{--  <tr>
                                   <td style="padding-top: 0.4cm"> Tarif Reguler</td>
                                   <td><input type="text" name="ed_reguler" class="form-control"></td>
                               </tr>
                               <tr>
                                   <td style="padding-top: 0.4cm"> Tarif Express</td>
                                   <td><input type="text" name="ed_express" class="form-control"></td>
                               </tr> --}}
                              
                                <input type="hidden" name="kode_kota">
                               {{--  <input type="hidden" name="ed_zona_reguler">
                                <input type="hidden" name="ed_zona_express"> --}}

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



    $('#provinsi').change(function(){
        var prov = $(this).find(':selected').val();
        $.ajax({
            type: "GET",
            data : {kota:prov},
            url : baseUrl + "/sales/tarif_penerus_dokumen/get_kota",
            dataType:'json',
            success: function(data)
            {   
                console.log(data);
                 var kotakota = '<option value="" selected="" disabled="">-- Pilih Kota --</option>';

                 $.each(data, function(i,n){
                    kotakota = kotakota + '<option value="'+n.id+'" data-kota="'+n.kode_kota+'">'+n.nama+'</option>';
                 })
                $('#kota').addClass('form-control'); 
                $('#kota').attr('readonly',false); 
                $('#kota').html(kotakota); 
                $('#kota').change(function(){
                    var kode_kota = $(this).find(':selected').data('kota');
                    $('input[name="kode_kota"]').val(kode_kota);
                })
                $('#kecamatan').html('<option value="" selected="" disabled=""></option>'); 
            }
        })
       

    });

    $('#kota').change(function(){
        var kot = $(this).find(':selected').val();
         $.ajax({
            type: "GET",
            data : {kecamatan:kot},
            url : baseUrl + "/sales/tarif_penerus_dokumen/get_kec",
            dataType:'json',
            success: function(data)
            {   
                console.log(data);
                 var kecamatan = '<option value="" selected="" disabled="">-- Pilih Kecamatan --</option>';

                 $.each(data, function(i,n){
                    kecamatan = kecamatan + '<option value="'+n.id+'">'+n.nama+'</option>';
                 })
                $('#kecamatan').addClass('form-control'); 
                $('#kecamatan').html(kecamatan); 
                $('#kecamatan').attr('readonly',false); 

            }
        })
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
              "url" :  baseUrl + "/sales/tarif_penerus_dokumen/tabel",
              "type": "GET"
            },
            "columns": [
            { "data": "id_tarif_dokumen", },
            { "data": "provinsi_nama", },
            { "data": "kota_nama" },
            { "data": "kecamatan_nama" },  
            { "data": "type" },  
            { "data": "reguler", render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "express", render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
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
        $("input[name='ed_kode_old']").val('');
        $("input[name='ed_reguler']").val('');
        $("input[name='ed_express']").val('');
        $("input[name='ed_kode']").attr('readonly',true);
        $("input[name='ed_kode']").val('');

                $("select[name='ed_reguler']").val('').trigger('chosen:updated');

                $("select[name='ed_express']").val('').trigger('chosen:updated');

                $("select[name='ed_tipe']").val('').trigger('chosen:update');

        $("#provinsi").val('').trigger('chosen:updated');
        $("#kota").val('').trigger('chosen:updated');
        $("#kecamatan").val('').trigger('chosen:updated');
        $("#modal").modal("show");
        $("input[name='cb_jenis']").focus();
    });

    $(document).on( "click",".btnedit", function() {
        var id=$(this).attr("id");
        var value = {
            id: id
        };
        $.ajax(
        {
            url : baseUrl + "/sales/tarif_penerus_dokumen/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                console.log(data);
                $("input[name='crud']").val('E');
                $("input[name='ed_kode']").val(data[0].id_tarif_dokumen);
                $("input[name='ed_kode_old']").val(data[0].id_increment_dokumen);
                $("select[name='ed_reguler']").val(data[0].tarif_reguler).trigger('chosen:updated');
                $("select[name='ed_express']").val(data[0].tarif_express).trigger('chosen:updated');
                $("input[name='ed_kode']").attr('readonly',true);

                $("#provinsi").val(data[0].provinsi_id).trigger('chosen:updated');
                
                $("input[name='kode_kota']").val(data[0].kota_kode);

                $("select[name='ed_tipe']").val(data[0].type).trigger('chosen:update');


                $("#kota").val(data[0].kota_id);
                $("#kecamatan").val(data[0].kecamatan_id);

                $("#modal").modal('show');
                $("input[name='ed_kode']").focus();
                
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on("click","#btnsave",function(){
        $kota =$("#kota :selected").val();
        $kec = $("#kecamatan :selected").val();

        if($kota == ''){
          Command: toastr["warning"]("Nama Kota Harus Di pilih", "Peringatan!")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "100",
              "hideDuration": "500",
              "timeOut": "3000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }
        if($kec == ''){
          Command: toastr["warning"]("Nama Kecamatan Harus Di pilih", "Peringatan!")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "100",
              "hideDuration": "500",
              "timeOut": "3000",
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
            url : baseUrl + "/sales/tarif_penerus_dokumen/save_data",
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
            url : baseUrl + "/sales/tarif_penerus_dokumen/hapus_data",
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
