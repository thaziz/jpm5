@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
      .id {display:none; }
    .cssright { text-align: right; }
    </style>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> PENERIMAAN
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
                                    <input type="text" name="ed_nomor" id="ed_nomor" class="form-control" style="text-transform: uppercase" value="{{ $data->nomor or null }}" >
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
                                <td style="width:110px; padding-top: 0.4cm">Akun Debet</td>
                                <td>
                                    <select class="form-control" name="cb_akun" >
                                    @foreach ($akun_kas_bank as $row)
                                        <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                    @endforeach
                                    </select>
                                </td>
                            </tr>
                            
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td>
                                    <input type="text" name="ed_keterangan" class="form-control" style="text-transform: uppercase" value="{{ $data->keterangan or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Total</td>
                                <td>
                                    <input type="text" name="ed_total" readonly="readonly" class="form-control" style="text-transform: uppercase; text-align: right" value="{{ $data->total or 0 }}" >
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
                            <th>Kode</th>
                            <th>Akun Kredit</th>
                            <th>Memo</th>
                            <th style="width:10%">Jumlah</th>
                            <th style="width:8%">Aksi</th>
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
                            <h4 class="modal-title">Insert Edit Item Penerimaan</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal detail">
                                <table id="table_data" class="table table-striped table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                          <td style="width:120px; padding-top: 0.4cm">Akun Kredit</td>
                                          <td>
                                                <select class="chosen-select-width" name="cb_akun_kredit" id="cb_akun_kredit" >
                                                    <option></option>
                                                @foreach ($akun as $row)
                                                    <option value="{{ $row->kode }}">{{ $row->nama }}</option>
                                                @endforeach
                                                </select>
                                                <input type="hidden" name="txtid">
                                                <input type="hidden" name="ed_nomor_d">
                                                <input type="hidden" name="ed_kode_akun_debet">
                                                <input type="hidden" name="crud" value="N">
                                                <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                          </td>                      
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Memo</td>
                                            <td><textarea class="form-control" rows="3" name="ed_memo" ></textarea></td>                      
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Jumlah</td>
                                            <td><input type="text" class="form-control" name="ed_jumlah" style="text-align:right"></td>                      
                                            <input type="hidden" name="edoldjumlah">
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
        $("select[name='cb_cabang']").val('{{ $data->nomor_cabang or ''  }}');
        $jml_detail = {{ $jml_detail->jumlah  or 0}};
        if ($jml_detail > 0){
            $("input[name='ed_nomor']").attr('readonly','readonly');
            $("input[name='ed_nama']").focus();
        }else{
            $("input[name='ed_nomor']").focus();
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
                "url": baseUrl + "/keuangan/penerimaanform/tabel_data_detail",
                "type": "GET",
                "data" : { nomor : function () { return $('#ed_nomor').val()}},
            },
            "columns": [
             { "data": "id" , render: $.fn.dataTable.render.number( '.'),"sClass": "id" },
            { "data": "kode_akun_kredit" },
            { "data": "akun_kredit" },
            { "data": "memo" },
            { "data": "jumlah" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
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
    });

    $(document).on("click","#btnadd",function(){
        var nomor = $("input[name='ed_nomor']").val();
        var kode_akun = $("select[name='cb_akun']").val();
        $("input[name='crud']").val('N');
        $("input[name='ed_id']").val('');
        $("input[name='ed_id']").val('');
        $("input[name='ed_nomor_d']").val(nomor);
        $("input[name='ed_kode_akun_debet']").val(kode_akun);
        $("input[name='ed_memo']").val('');
        $("input[name='ed_jumlah']").val('0');
        $("#modal").modal("show");
        $("#cb_kota").trigger('chosen:activate');
        $.ajax(
        {
            url :  baseUrl + "/keuangan/penerimaanform/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('#form_header').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result != 1){
                        alert("Gagal menyimpan data!");
                    }else{
                        var nomor = $("input[name='ed_nomor']").val();
                        $("input[name='ed_nomor_old']").val(nomor);
                    }
                }else if(data.crud == 'E'){
                    if(data.result != 1){
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }else{
                        var nomor = $("input[name='ed_nomor']").val();
                        $("input[name='ed_nomor_old']").val(nomor);
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

    

    $(document).on( "click",".btnedit", function() {
        var id=$(this).attr("id");
        var value = {
            id: id
        };
        $.ajax(
        {
            url : baseUrl + "/master_sales/rute/get_data_detail",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='crud']").val('E');
                $("input[name='ed_id']").val(data.id);
                $("input[name='ed_nomor_']").val(data.nomor_rute);
                $("select[name='cb_kota']").val(data.id_kota).trigger('chosen:updated');
                $("input[name='ed_kota']").val(data.kota);
                $("#modal").modal('show');
                $("input[name='ed_nomor']").focus();
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
            url : baseUrl + "/keuangan/penerimaanform/save_data_detail",
            type: "POST",
            dataType:"JSON",
            data : $('.detail :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result == 1){
                        var table = $('#table_data').DataTable();
                        table.ajax.reload( null, false );
                        $("#modal").modal('hide');
                        $("input[name='ed_nomor']").attr('readonly','readonly');
                        $("select[name='cb_akun']").attr('disabled','disabled');
                        $("input[name='ed_total']").val(data.total[0].total);
                        $("#btn_add").focus();
                    }else{
                        alert("Gagal menyimpan data!");
                    }
                }else if(data.crud == 'E'){
                    if(data.result == 1){
                        //$.notify('Successfull update data');
                        var table = $('#table_data').DataTable();
                        table.ajax.reload( null, false );
                        $("input[name='ed_nomor']").attr('readonly','readonly');
                        $("input[name='ed_total']").val(data.total[0].total);
                        $("select[name='cb_akun']").attr('disabled','disabled');
                        $("#modal").modal('hide');
                        $("#btn_add").focus();
                    }else{
                        //swal("Error","Can't update data, error : "+data.error,"error");
                        alert("Gagal menyimpan data!");
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
        var nomor = $("input[name='ed_nomor']").val();
        if(!confirm("Hapus Data " +name+ " ?")) return false;
        var value = {
            id: id,
            nomor: nomor,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "POST",
            url : baseUrl + "/keuangan/penerimaanform/hapus_data_detail",
            dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result ==1){
                    var table = $('#table_data').DataTable();
                    if (data.jml_detail[0].jumlah == 0) {
                        $("input[name='ed_nomor']").removeAttr('readonly');
                        $("select[name='cb_akun']").removeAttr('disabled');
                    }
                    $("input[name='ed_total']").val(data.total[0].total);
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
