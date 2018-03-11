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
                    <h5> PENERIMAAN PENJUALAN DETAIL
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
                                <td >
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tanggal" value="{{ $data->tanggal or  date('Y-m-d') }}">
                                    </div>
                                </td>
                                <td style="width:110px;">Jenis Pembayaran</td>
                                <td>
                                    <select class="form-control" name="cb_jenis_pembayaran" >
                                        <option value="T"> TUNAI/CASH </option>
                                        <option value="C"> TRANSFER </option>
                                        <option value="F"> CHEQUE/BG </option>
                                        <option value="U"> UANG MUKA/DP </option>
                                    </select>
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
                                </td>
                                <td style="padding-top: 0.4cm">Customer</td>
                                <td colspan="4" >
                                    <select class="chosen-select-width"  name="cb_customer" id="cb_customer" style="width:100%" >
                                        <option> </option>
                                    @foreach ($customer as $row)
                                        <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                    @endforeach
                                    </select>
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
                                <td >
                                    <input type="text" name="ed_jumlah" class="form-control angka" style="text-transform: uppercase; text-align: right" @if ($data === null) value="0" @else value="{{ number_format($data->jumlah, 0, ",", ".") }}" @endif>
                                </td>
                                <td style="width:120px; padding-top: 0.4cm">Terpakai</td>
                                <td>
                                    <input type="text" name="ed_terpakai" class="form-control angka" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1" value="{{ $data->terpakai or null }}" >
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info " id="btnadd" name="btnadd" ><i class="glyphicon glyphicon-plus"></i>Pilih Nomor Invoice</button>
                            <button type="button" class="btn btn-success " id="btnsimpan" name="btnsimpan" ><i class="glyphicon glyphicon-save"></i>Simpan</button>
                        </div>
                    </div>
                </form>
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="display:none;">id</th>
                            <th>Nomor Invoice</th>
                            <th>Jumlah Bayar</th>
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
                        <h4 class="modal-title">Pilih Nomor Invoice</h4>
                      </div>
                      <div class="modal-body">
                            <form class="form-horizontal  kirim">
                                <table id="table_data_invoice" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nomor Invoice</th>
                                            <th>Tanggal</th>
                                            <th>Sisa Tagihan</th>
                                            <th style="width:20%">Jml Bayar</th>
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
        $("select[name='type_kiriman']").val('{{ $data->type_kiriman or ''  }}');
        $("select[name='cb_jenis_ppn']").val('{{ $data->jenis_ppn or ''  }}');
        $("select[name='cb_pajak']").val('{{ $data->pajak or ''  }}');
        $("select[name='cb_cabang']").val('{{ $data->kode_cabang or ''  }}');
        $("select[name='cb_customer']").val('{{ $data->kode_customer or ''  }}').trigger('chosen:updated');
        $jml_detail = {{ $jml_detail->jumlah  or 0}};
        if ($jml_detail > 0){
            $("input[name='ed_nomor']").attr('readonly','readonly');
            $("input[name='ed_nama']").focus();
        }else{
            $("input[name='ed_nomor']").focus();
        }
        var value ={
                    kode_customer: function () { return $("select[name='cb_customer']").val()},
                    kode_cabang: function () { return $("select[name='cb_cabang']").val()},
        };
        $('#table_data_invoice').DataTable({
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
            "url": baseUrl + "/sales/penerimaan_penjualan_form/tampil_invoice",
                "type": "GET",
                "data" : value,
            },
            "columns": [
            { "data": "nomor"},
            { "data": "tanggal" },
            { "data": "sisa_tagihan" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "jml_bayar" },
            { "data": "button" },
            ],
            "fnDrawCallback": function( oSettings ) {
                $(".angka").maskMoney({thousands:'.', decimal:',', precision:-1});
            }
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
                "url": baseUrl + "/sales/penerimaan_penjualan_form/tabel_data_detail",
                "type": "GET",
                "data" : { nomor : function () { return $('#ed_nomor').val()}},
            },
            "columns": [
            { "data": "id" , render: $.fn.dataTable.render.number( '.'),"sClass": "id" },
            { "data": "nomor_invoice" },
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

    $(document).on("click","#btnadd",function(){
        $.ajax(
        {
            url :  baseUrl + "/sales/penerimaan_penjualan/save_data",
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
        var table = $('#table_data_invoice').DataTable();
        table.ajax.reload( null, false );
        $("#modal").modal("show");
    });

    $(document).on("click","#btnsimpan",function(){
        $("input[name='ed_nomor']").removeAttr('readonly','readonly');
        $("select[name='cb_cabang']").removeAttr('disabled');
        $("select[name='cb_customer']").prop('disabled', false).trigger("chosen:updated");    
        $.ajax(
        {
            url :  baseUrl + "/sales/penerimaan_penjualan/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('#form_header').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result != 1){
                        alert("Gagal menyimpan data!");
                    }else{
                        window.location.href = baseUrl + '/sales/invoice'
                    }
                }else if(data.crud == 'E'){
                    if(data.result != 1){
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }else{
                        window.location.href = baseUrl + '/sales/invoice'
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
        var nomor_invoice = [];
        var jumlah = [];
        var nomor = $("input[name='ed_nomor']").val();
        $('input[name^=ed_jumlah_bayar').each(function(i){
            jumlah[i] = $(this).val();
        });
        $('input[name^=ed_nomor_invoice').each(function(i){
            nomor_invoice[i] = $(this).val();
        });
        var nomor = $("input[name='ed_nomor']").val();
        var value = {
            nomor : nomor,
            nomor_invoice: nomor_invoice,
            jumlah: jumlah,
            _token: "{{ csrf_token() }}"
        };
        $.ajax(
        {
            url : baseUrl + "/sales/penerimaan_penjualan/save_data_detail",
            type: "POST",
            dataType:"JSON",
            data : value ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result == 1){
                    var table = $('#table_data').DataTable();
                    table.ajax.reload( null, false );
                    $("#modal").modal('hide');
                    $("input[name='ed_terpakai']").val(data.terpakai);
                    //$("input[name='ed_nomor']").attr('readonly','readonly');
                    //$("select[name='cb_cabang']").attr('disabled','disabled');
                    //$("select[name='cb_customer']").prop('disabled', true).trigger("chosen:updated");
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
        var jenis_ppn = $("select[name='cb_jenis_ppn']").val();
        var pajak = $("select[name='cb_pajak']").val();
        if(!confirm("Hapus Data " +name+ " ?")) return false;
        var value = {
            id: id,
            nomor: nomor,
            jenis_ppn: jenis_ppn,
            pajak: pajak,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "POST",
            url : baseUrl + "/sales/penerimaan_penjualan/hapus_data_detail",
            dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result ==1){
                    var table = $('#table_data').DataTable();
                    if (data.jml_detail == 0) {
                        $("input[name='ed_nomor']").removeAttr('readonly','readonly');
                        $("select[name='cb_cabang']").removeAttr('disabled');
                        $("select[name='cb_customer']").prop('disabled', false).trigger("chosen:updated");
                    }
                   $("input[name='ed_terpakai']").val(data.terpakai);
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

    $(document).on("click",".btnpilih",function(){
        var id=$(this).attr("id"); //nama idnya ini adalah nomor nota di tabel
        var jumlah=parseFloat($("#ed_bayar"+id).val());
        if ($(this).prop('checked')){
            $("#ed_"+id).val(jumlah.format());
        } else {
            $("#ed_"+id).val('0');
        }
    });


</script>
@endsection
