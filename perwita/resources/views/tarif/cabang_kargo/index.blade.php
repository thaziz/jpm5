
@extends('main')


@section('title', 'dashboard')


@section('content')
<style type="text/css">
    .cssright { text-align: right; }
</style>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> TARIF CABANG KARGO
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
                                <th> Jenis </th>
                                <th> Angkutan </th>
                                <th> Tarif </th>
                                <th> Waktu (Hari) </th>
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
                        <h4 class="modal-title">Insert Edit Tarif Cabang Kargo</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal kirim">
                          <table class="table table-striped table-bordered table-hover ">
                            <tbody>
                                <tr>
                                    <td style="width:120px; padding-top: 0.4cm">Kode</td>
                                    <td>
                                        <input type="text" name="ed_kode" class="form-control a" style="text-transform: uppercase" >
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
                                <tr>
                                    <td style="padding-top: 0.4cm">Kota Tujuan</td>
                                    <td>   
                                        <select class="chosen-select-width c"  name="cb_kota_tujuan" style="width:100%">
                                           <option value="" selected="" disabled="">-- Pilih Kota tujuan --</option>
                                        @foreach ($kota as $row)
                                            <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Angkutan</td>
                                    <td>   
                                        <select class="form-control d"  name="cb_angkutan" style="width:100%">
                                            <option value="" selected="" disabled="">-- Pilih Kota angkatan --</option>
                                        @foreach ($angkutan as $row)
                                            <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Jenis</td>
                                    <td>   
                                        <select class="form-control e"  name="cb_jenis" style="width:100%">
                                            <option value="" selected="" disabled="">-- Pilih Kota jenis --</option>
                                            @foreach ($jenis_tarif as $row)
                                            <option value="{{ $row->jt_id }}"> {{$row->jt_nama_tarif}} </option>
                                             @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Harga</td>
                                    <td><input type="text" class="form-control f" name="ed_harga" style="text-align: right;"></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Waktu/Estimasi</td>
                                    <td><input type="text" class="form-control g" name="ed_waktu" style="text-align: right;"></td>
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
            { "data": "jenis" },
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
        $("input[name='ed_harga'],input[name='ed_waktu']").maskMoney({thousands:'.', decimal:',', precision:-1});
    });

    $(document).on("click","#btn_add",function(){
        $("input[name='crud']").val('N');
        $("input[name='ed_kode']").val('');
        $("input[name='ed_kode_old']").val('');
        $("input[name='ed_harga']").val(0);
        $("input[name='ed_waktu']").val(0);
        $("select[name='cb_kota_asal']").val('').trigger('chosen:updated');
        $("select[name='cb_kota_tujuan']").val('').trigger('chosen:updated');
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
                $("input[name='crud']").val('E');
                $("input[name='ed_kode']").val(data.kode);
                $("input[name='ed_kode_old']").val(data.kode_detail_kargo);
                $("input[name='ed_harga']").val(data.harga);
                $("input[name='ed_waktu']").val(data.waktu);
                $("select[name='cb_jenis']").val(data.jenis);
                $("select[name='cb_angkutan']").val(data.kode_angkutan);
                $("select[name='cb_kota_asal']").val(data.id_kota_asal).trigger('chosen:updated');
                $("select[name='cb_kota_tujuan']").val(data.id_kota_tujuan).trigger('chosen:updated');
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
        // /*
        // var kode_old = $("#ed_kode_old").val();
        // var kode = $("#ed_kode").val();
        // var kota = $("#ed_kota").val();
        // var provinsi = $("#cb_kota_asal").val();
        // var crud   = $("#crud").val();
        // if(id == '' || id == null ){
        //     alert('Id harus di isi');
        //     $("#ed_kode").focus();
        //     return false;
        // }
        // if(provinsi == '' || provinsi == null ){
        //     alert('provinsi harus di isi');
        //     $("#cb_kota_asal").focus();
        //     return false;
        // }
        // /*
        // value = {
        //     id_old: id_old,
        //     id: id,
        //     provinsi: provinsi,
        //     kota: kota.toUpperCase(),
        //     crud: crud,
        //     _token: "{{ csrf_token() }}",
        // };
        // */
        // var a = $(".a").val();
        // var b = $(".b").val();
        // var c = $(".c").val();
        // var d = $(".d").val();
        // var e = $(".e").val();
        // var f = $(".f").val();
        // var g = $(".g").val();
        // if(a == '' || a == null ){
        //     alert('Kode harus di isi');
        //      $('html,body').animate({scrollTop: $('.a').offset().top}, 200, function() {
        //       $(".a").focus();
        //  });
        //     return false;
        // }
        // if(b == '' || b == null ){
        //     alert('Kota asal harus di isi');
        //      $('html,body').animate({scrollTop: $('.b').offset().top}, 200, function() {
        //      $('.b').focus();
        //  });
        //     return false;
        // }
        // if(c == '' || c == null ){
        //     alert('Kota tujuan harus di isi');
        //      $('html,body').animate({scrollTop: $('.c').offset().top}, 200, function() {
        //      $('.c').focus();
        //  });
        //     return false;
        // }
        // if(d == '' || d == null ){
        //     alert('Angkutan harus di isi');
        //      $('html,body').animate({scrollTop: $('.d').offset().top}, 200, function() {
        //      $('.d').focus();
        //  });
        //     return false;
        // }
        // if(e == '' || e == null ){
        //     alert('Harga harus di isi');
        //     $('html,body').animate({scrollTop: $('.e').offset().top}, 200, function() {
        //      $('.e').focus();
        //  });
        //     return false;
        // }
        // if(f == '' || f == null ){
        //     alert('Waktu/Estimasi harus di isi');
        //    $('html,body').animate({scrollTop: $('.f').offset().top}, 200, function() {
        //      $('.f').focus();
        //  });
        //     return false;
        // }
        //  if(g == '' || g == null ){
        //     alert('Waktu/Estimasi harus di isi');
        //    $('html,body').animate({scrollTop: $('.g').offset().top}, 200, function() {
        //      $('.g').focus();
        //  });
        //     return false;
        // }
        $.ajax(
        {
            url : baseUrl + "/sales/tarif_cabang_kargo/save_data",
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
        if(!confirm("Hapus Data " +name+ " ?")) return false;
        var value = {
            id: id,
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
    

</script>
@endsection
