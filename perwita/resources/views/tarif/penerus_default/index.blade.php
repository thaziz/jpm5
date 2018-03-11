
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
                    <h5> TARIF PENERUS DEFAULT
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
                                <th style="width:100px"> Jenis</th>
                                <th> Tipe Kiriman</th>
                                <th> Keterangan </th>
                                <th> Harga </th>
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
                        <h4 class="modal-title">Insert Edit Tarif Cabang Koli</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal kirim">
                          <table class="table table-striped table-bordered table-hover ">
                            <tbody>
                                
                                <tr>
                                    <td style="padding-top: 0.4cm">Jenis</td>
                                    <td>   
                                        <select class="form-control"  name="cb_jenis" style="width:100%">
                                            <option value="REGULER">REGULER</option>
                                            <option value="EXPRESS">EXPRESS</option>
                                        </select>
                                        <input type="hidden" name="ed_id" class="form-control" style="text-transform: uppercase" >
                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                        <input type="hidden" class="form-control" name="crud" class="form-control" >
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Tipe Kiriman</td>
                                    <td>   
                                        <select class="form-control"  name="cb_tipe_kiriman" style="width:100%">
                                            <option value="DOKUMEN">DOKUMEN</option>
                                            <option value="KARGO PAKET">KARGO PAKET</option>
                                            <option value="KILOGRAM">KILOGRAM</option>
                                            <option value="KOLI">KOLI</option>
                                            <option value="KERTAS">KERTAS</option>
                                            <option value="KARGO KERTAS">KARGO KERTAS</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Keterangan</td>
                                    <td>   
                                        <select class="form-control"  name="cb_keterangan" style="width:100%">
                                            <option></option>
                                            <option value="TARIF 0 KG SAMPAI 10 KG">TARIF 0 KG SAMPAI 10 KG</option>
                                            <option value="TARIF 10 KG SAMPAI 20 KG">TARIF 10 KG SAMPAI 20 KG</option>
                                            <option value="TARIF 20 KG SAMPAI 30 KG">TARIF 20 KG SAMPAI 30 KG</option>
                                            <option value="TARIF DI ATAS 30 KG">TARIF DI ATAS 30 KG</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Harga</td>
                                    <td><input type="text" class="form-control" name="ed_harga" style="text-align: right;"></td>
                                </tr>

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
            { "data": "button" },
            ]
        });
        var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"100%",search_contains:true}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
        $("input[name='ed_harga'],input[name='ed_waktu']").maskMoney({thousands:'.', decimal:',', precision:-1});
    });

    $(document).on("click","#btn_add",function(){
        $("input[name='crud']").val('N');
        $("input[name='ed_id']").val('');
        $("input[name='ed_harga']").val(0);
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
            url : baseUrl + "/sales/tarif_penerus_default/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='crud']").val('E');
                $("input[name='ed_id']").val(data.id);
                $("input[name='ed_harga']").val(data.harga);
                $("select[name='cb_jenis']").val(data.jenis);
                $("select[name='cb_tipe_kiriman']").val(data.tipe_kiriman);
                $("select[name='cb_keterangan']").val(data.keterangan);
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
        /*
        var kode_old = $("#ed_kode_old").val();
        var kode = $("#ed_kode").val();
        var kota = $("#ed_kota").val();
        var provinsi = $("#cb_kota_asal").val();
        var crud   = $("#crud").val();
        if(id == '' || id == null ){
            alert('Id harus di isi');
            $("#ed_kode").focus();
            return false;
        }
        if(provinsi == '' || provinsi == null ){
            alert('provinsi harus di isi');
            $("#cb_kota_asal").focus();
            return false;
        }
        /*
        value = {
            id_old: id_old,
            id: id,
            provinsi: provinsi,
            kota: kota.toUpperCase(),
            crud: crud,
            _token: "{{ csrf_token() }}",
        };
        */
        $.ajax(
        {
            url : baseUrl + "/sales/tarif_penerus_default/save_data",
            type: "POST",
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
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }
                }else{
                    swal("Error","invalid order","error");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Error!", textStatus, "error");
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
            type: "POST",
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
