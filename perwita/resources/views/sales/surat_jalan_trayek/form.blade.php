@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
      .id {display:none; }
    </style>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> SURAT JALAN TRAYEK
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>

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
                <form id="form_header" class="form-horizontal">
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Nomor</td>
                                <td>
                                    <input type="text" name="ed_nomor" id="ed_nomor" class="form-control" readonly="readonly" style="text-transform: uppercase" value="{{ $data->nomor or null }}" >
                                    <input type="hidden" name="ed_nomor_old" class="form-control" style="text-transform: uppercase" value="{{ $data->nomor or null }}" >
                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                    <input type="hidden" class="form-control" name="crud_h" class="form-control" @if ($data === null) value="N" @else value="E" @endif>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td colspan="5">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tanggal" value="{{ $data->tanggal or  date('Y-m-d') }}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td>
                                    <select class="form-control" name="cb_cabang" >
                                    @foreach ($cabang as $row)
                                        <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" name="ed_cabang" value="{{ $data->kode_cabang or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Rute</td>
                                <td>
                                    <select class="chosen-select-width" name="cb_rute" id="cb_rute" >
                                        <option></option>
                                    @foreach ($rute as $row)
                                        <option value="{{ $row->kode }}">{{ $row->nama }}</option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" name="ed_nama_rute" class="form-control" style="text-transform: uppercase" value="{{ $data->nama_rute or null }}" >
                                    <input type="hidden" name="ed_kode_rute" class="form-control" style="text-transform: uppercase" value="{{ $data->kode_rute or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Nopol</td>
                                <td>
                                    <select class="chosen-select-width" id="cb_nopol" name="cb_nopol" style="width:100%">
                                        <option></option>
                                    @foreach ($kendaraan as $row)
                                        <option value="{{ $row->id }}">{{ $row->nopol }}</option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" name="ed_nopol" class="form-control" style="text-transform: uppercase" value="{{ $data->nopol or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Sopir</td>
                                <td>
                                    <input type="text" name="ed_sopir" class="form-control" style="text-transform: uppercase" value="{{ $data->sopir or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td>
                                    <input type="text" name="ed_keterangan" class="form-control" style="text-transform: uppercase" value="{{ $data->keterangan or null }}" >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info " id="btnadd" name="btnadd" ><i class="glyphicon glyphicon-plus"></i>Tambah</button>
                            <button type="button" class="btn btn-success " id="btnsimpan" name="btnsimpan" ><i class="glyphicon glyphicon-save"></i>Simpan</button>
                        </div>
                    </div>
                </form>
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="display:none;">id</th>
                            <th>Nomor Order</th>
                            <th>Tgl Order</th>
                            <th>Tujuan</th>
                            <th>Alamat</th>
                            <th>Tipe</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <!-- modal -->
                <div id="modal" class="modal" >
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insert Nomor DO</h4>
                  </div>
                      <div class="modal-body">
                            <form class="form-horizontal  kirim">
                                <table id="table_data_do" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nomor Order</th>
                                            <th>Tgl Order</th>
                                            <th>Tujuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
        $("input[name='ed_tanggal']").focus();
        $("select[name='cb_cabang']").val('{{ $data->kode_cabang or ''  }}');
        $("select[name='cb_rute']").val('{{ $data->kode_rute or ''  }}').trigger('chosen:updated');
        $("select[name='cb_nopol']").val('{{ $data->id_kendaraan or ''  }}').trigger('chosen:updated');
        $jml_detail = {{ $jml_detail->jumlah  or 0}};
        if ($jml_detail > 0){
            $("input[name='ed_nomor']").attr('readonly','readonly');
            $("select[name='cb_rute']").prop('disabled', true);
        }else{
            //$("input[name='ed_nomor']").focus();
        }
        $('#table_data').DataTable({
            "lengthChange": true,
            "ordering": true,
            "searching": false,
            "paging": false,
            "ordering": true,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
            "ajax": {
                "url": baseUrl + "/sales/surat_jalan_trayek_form/tabel_data_detail",
                "type": "GET",
                "data" : { nomor : function () { return $('#ed_nomor').val()}},
            },
            "columns": [
            { "data": "id" , render: $.fn.dataTable.render.number( '.'),"sClass": "id" },
            { "data": "nomor_do" },
            { "data": "tanggal" },
            { "data": "tujuan" },
            { "data": "alamat_penerima" },
            { "data": "type_kiriman" },
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
    });
    
    function tampil_data_do(){
        var rute = $("#cb_rute").val();
        var kode_cabang = $("input[name='ed_cabang']").val();
        var value = {
            rute: rute,
            kode_cabang:kode_cabang,
        };
        $('#table_data_do').DataTable({
            "lengthChange": true,
            "ordering": true,
            "searching": true,
            "paging": true,
            "ordering": true,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
            "ajax": {
                "url": baseUrl + "/sales/surat_jalan_trayek_form/tampil_do",
                "type": "GET",
                "data" : value,
            },
            "columns": [
            { "data": "nomor" },
            { "data": "tanggal" },
            { "data": "tujuan" },
            { "data": "button" },
            ]
        });
    }

    $(document).on("click","#btnadd",function(){
        $("input[name='crud']").val('N');
        $.ajax(
        {
            url :  baseUrl + "/sales/surat_jalan_trayek/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('#form_header').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result != 1){
                        alert("Gagal menyimpan data!");
                    }else{
                        $("input[name='ed_nomor']").val(data.nomor);
                        $("input[name='ed_nomor_old']").val(data.nomor);
                        
                    }
                }else if(data.crud == 'E'){
                    if(data.result != 1){
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }else{
                        $("input[name='ed_nomor']").val(data.nomor);
                        $("input[name='ed_nomor_old']").val(data.nomor);
                        
                    }
                }else{
                     swal("Error","invalid order","error");
                }
                tampil_data_do();
                var table = $('#table_data_do').DataTable();
                table.ajax.reload( null, false );
                $("#modal").modal("show");
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
              // swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on("click","#btnsimpan",function(){
        $("select[name='cb_rute']").prop('disabled', false).trigger("chosen:updated");
        $("input[name='crud']").val('N');
        $.ajax(
        {
            url :  baseUrl + "/sales/surat_jalan_trayek/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('#form_header').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result != 1){
                        alert("Gagal menyimpan data!");
                    }else{
                        window.location.href = baseUrl + '/sales/surat_jalan_trayek'
                    }
                }else if(data.crud == 'E'){
                    if(data.result != 1){
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }else{
                        window.location.href = baseUrl + '/sales/surat_jalan_trayek';
                    }
                }else{
                    swal("Error","invalid order","error");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
              // swal("Error!", textStatus, "error");
            }
        });
        
        
    });

    $("select[name='cb_cabang']").change(function(){
        var data = $(this).val();
        $("input[name='ed_cabang']").val(data);
    });

    $('#cb_nopol').change(function(){
        $nopol = $("select[name='cb_nopol'] option:selected").text();
        $("input[name='ed_nopol']").val($nopol);
    });

    $('#cb_rute').change(function(){
        $kode_rute = $("select[name='cb_rute'] option:selected").val();
        $nama_rute = $("select[name='cb_rute'] option:selected").text();
        $("input[name='ed_kode_rute']").val($kode_rute);
        $("input[name='ed_nama_rute']").val($nama_rute);
    });


    $(document).on("click","#btnsave",function(){
        var nomor_do = [];
        $(':checkbox:checked').each(function(i){
          nomor_do[i] = $(this).attr("id");
        });
        var nomor = $("input[name='ed_nomor']").val();
        var value = {
            nomor : nomor,
            nomor_do: nomor_do,
            _token: "{{ csrf_token() }}"
        };
        $.ajax(
        {
            url : baseUrl + "/sales/surat_jalan_trayek/save_data_detail",
            type: "POST",
            dataType:"JSON",
            data : value ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result == 1){
                    var table = $('#table_data').DataTable();
                    table.ajax.reload( null, false );
                    $("#modal").modal('hide');
                    //$("input[name='ed_nomor']").attr('readonly','readonly');
                    $("select[name='cb_rute']").prop('disabled', true).trigger("chosen:updated");
                    $("select[name='cb_cabang']").attr('disabled','disabled');
                    $("#btn_add").focus();
                }else{
                    alert("Gagal menyimpan data!");
                }
            },
            
        });
    });

    $(document).on( "click",".btndelete", function() {
        var name = $(this).attr("name");
        var id = $(this).attr("id");
        var nomor = $("input[name='ed_nomor']").val();
        if(!confirm("Hapus Data " +name+ " ?")) return false;
        var value = {
            id: id,
            nomor: nomor,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "POST",
            url : baseUrl + "/sales/surat_jalan_trayek/hapus_data_detail",
            dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result ==1){
                    var table = $('#table_data').DataTable();
                    if (data.jml_detail == 0) {
                        //$("input[name='ed_nomor']").removeAttr('readonly');
                        $("select[name='cb_cabang']").removeAttr('disabled');
                        $("select[name='cb_rute']").prop('disabled', false).trigger("chosen:updated");
                    }
                    table.ajax.reload( null, false );
                }else{
                    //swal("Error","Data tidak bisa hapus : "+data.error,"error");
                    alert('gagal menghapus data');
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
