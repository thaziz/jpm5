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
                    <h5> POSTING PEMBAYARAN DETAIL
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
                                    <input type="text" name="ed_nomor" id="ed_nomor" class="form-control" style="text-transform: uppercase" value="{{ $data->nomor or null }}" readonly="readonly" >
                                    <input type="hidden" name="ed_nomor_old" class="form-control" style="text-transform: uppercase" value="{{ $data->nomor or null }}" >
                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                    <input type="hidden" class="form-control" name="crud_h" class="form-control" @if ($data === null) value="N" @else value="E" @endif>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td >
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tanggal" value="{{ $data->tanggal or  date('Y-m-d') }}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px;">Jenis Pembayaran</td>
                                <td>
                                    <select class="form-control" name="cb_jenis_pembayaran" >
                                        <option value="T"> TUNAI/CASH </option>
                                        <option value="C"> TRANSFER </option>
                                        <option value="F"> CHEQUE/BG </option>
                                        <option value="U"> UANG MUKA/DP </option>
                                    </select>
                                    <input type="hidden" name="ed_jenis_pembayaran" value="{{ $data->jenis_pembayaran or null }}" >
                                </td>
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
                                <td style="width:120px; padding-top: 0.4cm">Kas / Bank</td>
                                <td colspan="4">
                                    <select class="form-control" name="cb_kas_bank" >
                                        <option value="T"> TUNAI/CASH </option>
                                        <option value="C"> TRANSFER </option>
                                        <option value="F"> CHEQUE/BG </option>
                                        <option value="U"> UANG MUKA/DP </option>
                                    </select>
                                    <input type="hidden" name="ed_kas_bank" value="{{ $data->jenis_pembayaran or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td colspan="4" >
                                    <input type="text" name="ed_keterangan" class="form-control" style="text-transform: uppercase" value="{{ $data->keterangan or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Jumlah</td>
                                <td colspan="4">
                                    <input type="text" name="ed_jumlah" class="form-control angka" readonly="readonly" tabindex="-1" style="text-transform: uppercase; text-align: right" @if ($data === null) value="0" @else value="{{ number_format($data->jumlah, 0, ",", ".") }}" @endif>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info " id="btnadd" name="btnadd" ><i class="glyphicon glyphicon-plus"></i>Pilih Nomor Penerimaan</button>
                            <button type="button" class="btn btn-success " id="btnsimpan" name="btnsimpan" ><i class="glyphicon glyphicon-save"></i>Simpan</button>
                        </div>
                    </div>
                </form>
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="display:none;">id</th>
                            <th>Nomor Penerimaan</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
                <!-- /.box-body -->
                
                <!-- modal -->
                <div id="modal" class="modal" >
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Pilih Nomor Penerimaan</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal  kirim">
                                    <table id="table_data_d" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor Penerimaan</th>
                                                <th>Tanggal</th>
                                                <th style="width:20%">Jumlah</th>
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
    Number.prototype.format = function(n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&.');
    };
    
    $(document).ready( function () {
        $("input[name='ed_tanggal']").focus();
        $("select[name='cb_jenis_pembayaran']").val('{{ $data->jenis_pembayaran or ''  }}');
        $("select[name='cb_cabang']").val('{{ $data->kode_cabang or ''  }}');
        $jml_detail = {{ $jml_detail->jumlah  or 0}};
        if ($jml_detail > 0){
            $("input[name='ed_nomor']").attr('readonly','readonly');
            $("select[name='cb_jenis_pembayaran']").attr('disabled','disabled');
            $("select[name='cb_cabang']").attr('disabled','disabled');
            $("input[name='ed_tanggal']").focus();
        }else{
            //$("input[name='ed_nomor']").focus();
        }
        var value ={
                    jenis_pembayaran: function () { return $("input[name='ed_jenis_pembayaran']").val()},
                    kode_cabang: function () { return $("input[name='ed_cabang']").val()},
        };

        $('#table_data_d').DataTable({
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
            "url": baseUrl + "/sales/posting_pembayaran_form/tampil_penerimaan_penjualan",
                "type": "GET",
                "data" : value,
            },
            "columns": [
            { "data": "nomor"},
            { "data": "tanggal" },
            { "data": "jumlah" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "button" },
            ]
        });

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
                "url": baseUrl + "/sales/posting_pembayaran_form/tabel_data_detail",
                "type": "GET",
                "data" : { nomor : function () { return $('#ed_nomor').val()}},
            },
            "columns": [
            { "data": "id" , render: $.fn.dataTable.render.number( '.'),"sClass": "id" },
            { "data": "nomor_penerimaan_penjualan" },
            { "data": "jumlah" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
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
        $(".angka").maskMoney({thousands:'.', decimal:',', precision:-1});
    });

    $("select[name='cb_jenis_pembayaran']").change(function(){
        var data = $("select[name='cb_jenis_pembayaran']").val();
        $("input[name='ed_jenis_pembayaran']").val(data);
    });

    $("select[name='cb_cabang']").change(function(){
        var data = $("select[name='cb_cabang']").val();
        $("input[name='ed_cabang']").val(data);
    });

    $(document).on("click","#btnadd",function(){
        $.ajax(
        {
            url :  baseUrl + "/sales/posting_pembayaran/save_data",
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
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Error!", textStatus, "error");
            }
        });
        var table = $('#table_data_d').DataTable();
        table.ajax.reload( null, false );
        $("#modal").modal("show");
    });

    $(document).on("click","#btnsimpan",function(){
        $.ajax(
        {
            url :  baseUrl + "/sales/posting_pembayaran/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('#form_header').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result != 1){
                        alert("Gagal menyimpan data!");
                    }else{
                        window.location.href = baseUrl + '/sales/posting_pembayaran'
                    }
                }else if(data.crud == 'E'){
                    if(data.result != 1){
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }else{
                        window.location.href = baseUrl + '/sales/posting_pembayaran'
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
    

    $(document).on("click","#btnsave",function(){
        var nomor_penerimaan_penjualan = [];
        var jumlah = [];
        var nomor = $("input[name='ed_nomor']").val();
        $(':checkbox:checked').each(function(i){
          nomor_penerimaan_penjualan[i] = $(this).attr("id");
          jumlah[i] = $("#ed_jumlah_" + nomor_penerimaan_penjualan[i]).val();
        });
        var nomor = $("input[name='ed_nomor']").val();
        var value = {
            nomor : nomor,
            nomor_penerimaan_penjualan: nomor_penerimaan_penjualan,
            jumlah: jumlah,
            _token: "{{ csrf_token() }}"
        };
        $.ajax(
        {
            url : baseUrl + "/sales/posting_pembayaran/save_data_detail",
            type: "POST",
            dataType:"JSON",
            data : value ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result == 1){
                    var table = $('#table_data').DataTable();
                    table.ajax.reload( null, false );
                    $("#modal").modal('hide');
                    $("input[name='ed_jumlah']").val(data.jumlah);
                    //$("input[name='ed_nomor']").attr('readonly','readonly');
                    $("select[name='cb_cabang']").attr('disabled','disabled');
                    $("select[name='cb_jenis_pembayaran']").attr('disabled','disabled');
                    
                    $("#btn_add").focus();
                }else{
                    alert("Gagal menyimpan data!");
                }
            },
            
        });
    });

    $(document).on( "click",".btndelete", function() {
        var nomor = $("input[name='ed_nomor']").val();
        var id = $(this).attr("id");
        var nomor_penerimaan_penjualan = $(this).attr("name");
        var jenis_ppn = $("select[name='cb_jenis_ppn']").val();
        var pajak = $("select[name='cb_pajak']").val();
        if(!confirm("Hapus Data " +name+ " ?")) return false;
        var value = {
            id: id,
            nomor: nomor,
            nomor_penerimaan_penjualan: nomor_penerimaan_penjualan,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "POST",
            url : baseUrl + "/sales/posting_pembayaran/hapus_data_detail",
            dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result ==1){
                    var table = $('#table_data').DataTable();
                    if (data.jml_detail == 0) {
                        //$("input[name='ed_nomor']").removeAttr('readonly','readonly');
                        $("select[name='cb_cabang']").removeAttr('disabled');
                        $("select[name='cb_jenis_pembayaran']").removeAttr('disabled');
                        
                    }
                   $("input[name='ed_jumlah']").val(data.jumlah);
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

    $(document).on( "click",".btninfo", function() {
        var id = $(this).attr("id");
        var value = {
              nomor_penerimaan: id,
            };
        $.ajax(
        {
            url : baseUrl + "/sales/posting_pembayaran_form/tampil_riwayat_invoice",
            type: "GET",
            data : value,
            success: function(data)
            {
                $("#table_data_riwayat_invoice").html(data);
            }       
        });
        $("#modal_info").modal("show");
    });



</script>
@endsection
