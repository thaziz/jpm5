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
                    <h5> INVOICE DETAIL
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
                    {{ csrf_token() }}
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Nomor</td>
                                <td colspan="3">
                                    <input type="text" name="nota_invoice" id="nota_invoice" readonly="readonly" class="form-control" style="text-transform: uppercase" value="" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td >
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tanggal" value="{{ $data->tanggal or  date('Y-m-d') }}">
                                    </div>
                                </td>
                                <td style="padding-top: 0.4cm">Jatuh Tempo</td>
                                <td>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_jatuh_tempo" value="{{ $data->jatuh_tempo or  date('Y-m-d') }}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Customer</td>
                                <td colspan="4">
                                    <select class="chosen-select-width"  name="cb_customer" id="cb_customer" style="width:100%" >
                                        <option> </option>
                                    @foreach ($customer as $row)
                                        <option value="{{ $row->kode }}" data-jt="{{$row->syarat_kredit}}"> {{$row->kode}}&nbsp-&nbsp{{ $row->nama }} </option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" name="ed_customer" value="{{ $data->kode_customer or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Pendapatan</td>
                                <td colspan="3">
                                    <select class="form-control"  name="cb_pendapatan" id="cb_pendapatan" >
                                        <option></option>
                                        <option value="PAKET">PAKET</option>
                                        <option value="KARGO">KARGO</option>
                                        <option value="KORAN">KORAN</option>
                                    </select>
                                    <input type="hidden" name="ed_pendapatan" value="{{ $data->pendapatan or null }}" >
                                </td>
                                <td style="width:110px; padding-top: 0.4cm;display:none" >Type Kiriman</td>
                                <td style="display:none;>
                                    <select class="form-control"  name="type_kiriman" id="type_kiriman"  >
                                        <option></option>
                                        <option value="KARGO KERTAS">KARGO KERTAS</option>
                                        <option value="KERTAS">KERTAS</option>
                                        <option value="DOKUMEN">DOKUMEN</option>
                                        <option value="KARGO PAKET">KARGO PAKET</option>
                                        <option value="KILOGRAM">KILOGRAM</option>
                                        <option value="KOLI">KOLI</option>
                                    </select>
                                    <input type="hidden" name="ed_type_kiriman" value="{{ $data->type_kiriman or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td colspan="4">
                                    <input type="text" name="ed_keterangan" class="form-control" style="text-transform: uppercase" value="{{ $data->keterangan or null }}" >
                                </td>
                            </tr>
                            <tr>
								<!--
                                <td style="width:120px; padding-top: 0.4cm">No Faktur Pajak</td>
                                <td>
                                    <input type="text" name="ed_no_faktur_pajak" class="form-control" style="text-transform: uppercase" value="{{ $data->no_faktur_pajak or null }}" >
                                </td>
								-->
								
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td colspan="4">
                                    <select class="form-control" name="cb_cabang" >
                                    @foreach ($cabang as $row)
                                        <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" name="ed_cabang" value="{{ $data->kode_cabang or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tgl DO Mulai</td>
                                <td >
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tanggal_mulai_do" value="{{ $data->tgl_mulai_do or  date('Y-m-d') }}">
                                    </div>
                                </td>
                                <td style="padding-top: 0.4cm">Tgl DO Sampai</td>
                                <td>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tanggal_sampai_do" value="{{ $data->tgl_sampai_do or  date('Y-m-d') }}">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info " id="btnadd" name="btnadd" ><i class="glyphicon glyphicon-plus"></i>Pilih Nomor Order</button>
                            <button type="button" class="btn btn-success " id="btnsimpan" name="btnsimpan" ><i class="glyphicon glyphicon-save"></i>Simpan</button>
                        </div>
                    </div>
                </form>
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="display:none;">id</th>
                            <th>Nomor DO</th>
                            <th>Tgl DO</th>
                            <th>Keterangan</th>
                            <th>Kuantum</th>
                            <th>Harga Satuan</th>
                            <th>Harga Bruto</th>
                            <th>Diskon</th>
                            <th>Harga Netto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
                <!-- /.box-body -->
                <form class="form-horizontal" id="form_bottom" >
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td style="width:64%; padding-top: 0.4cm; text-align:right">Total</td>
                                <td colspan="4">
                                    <input type="text" name="ed_total" class="form-control" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" @if ($data === null) value="0" @else value="{{ number_format($data->total, 0, ",", ".") }}" @endif>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm; text-align:right">Diskon</td>
                                <td colspan="4">
                                    <input type="text" name="ed_diskon" id="ed_diskon"  class="form-control angka" style="text-transform: uppercase;text-align:right" @if ($data === null) value="0" @else value="{{ number_format($data->diskon, 0, ",", ".") }}" @endif>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm; text-align:right">Netto</td>
                                <td colspan="4">
                                    <input type="text" name="ed_netto" id="ed_netto" class="form-control" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" @if ($data === null) value="0" @else value="{{ number_format($data->netto, 0, ",", ".") }}" @endif>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm; text-align:right">Jenis PPN</td>
                                <td>
                                    <select class="form-control" name="cb_jenis_ppn" id="cb_jenis_ppn" >
                                        <option value="4" ppnrte="0" ppntpe="npkp" >NON PPN</option>
                                        <option value="1" ppnrte="10" ppntpe="pkp" >EXCLUDE 10 %</option>
                                        <option value="2" ppnrte="1" ppntpe="pkp" >EXCLUDE 1 %</option>
                                        <option value="3" ppnrte="1" ppntpe="npkp" >INCLUDE 1 %</option>
                                        <option value="5" ppnrte="10" ppntpe="npkp" >INCLUDE 10 %</option>
                                    </select>
                                </td>
                                <td style="padding-top: 0.4cm; text-align:right">PPN</td>
                                <td>
                                    <input type="text" name="ed_ppn" class="form-control" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" @if ($data === null) value="0" @else value="{{ number_format($data->ppn, 0, ",", ".") }}" @endif>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm; text-align:right">Pajak</td>
                                <td>
                                    <select class="form-control" name="cb_pajak" id="cb_pajak" >
                                    @foreach ($pajak as $row)
                                        <option value="{{ $row->kode }}" data-nilai="{{ $row->nilai}}" > {{ $row->nama }} </option>
                                    @endforeach
                                    </select>
                                </td>
                                <td style="padding-top: 0.4cm; text-align:right">PPH</td>
                                <td>
                                    <input type="text" name="ed_pph" class="form-control" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" @if ($data === null) value="0" @else value="{{ number_format($data->pph, 0, ",", ".") }}" @endif>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm; text-align:right">Total Tagihan</td>
                                <td colspan="4">
                                    <input type="text" name="ed_total_tagihan" class="form-control" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" @if ($data === null) value="0" @else value="{{ number_format($data->total_tagihan, 0, ",", ".") }}" @endif>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <!-- modal -->
                <div id="modal" class="modal" >
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Pilih Nomor DO</h4>
                      </div>
                      <div class="modal-body">
                            <form class="form-horizontal  kirim">
                                <table id="table_data_do" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nomor Order</th>
                                            <th>Tgl Order</th>
                                            <th>Jumlah</th>
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

<div id="data-jurnal">
</div>

<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
    Number.prototype.format = function(n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&.');
    };
    function hitung(){
        var total = $("input[name='ed_total']").val();
        var diskon = $("input[name='ed_diskon']").val();
        var jenis_ppn = $("select[name='cb_jenis_ppn']").val();
        var nilai_pajak = $('#cb_pajak').find(':selected').data('nilai');
        var total = total.replace(/[A-Za-z$. ,-]/g, "");
        var diskon = diskon.replace(/[A-Za-z$. ,-]/g, "");
        var netto  = parseFloat(total) - parseFloat(diskon) ;
        var ppn = 0;
        if (jenis_ppn == 1) {
            ppn =Math.round(parseFloat(netto) * parseFloat(0.1));
        }else if (jenis_ppn == 2) {
            ppn =Math.round(parseFloat(netto) * parseFloat(0.01));
        }else if (jenis_ppn == 4) {
            ppn =0;
        }else if (jenis_ppn == 3) {
            ppn =Math.round(parseFloat(netto) / parseFloat(100.1));
            netto = netto - ppn;
        }else if (jenis_ppn == 5) {
            ppn =Math.round(parseFloat(netto) / parseFloat(10.1));
            netto = netto - ppn;
        }
        var pph = Math.round(parseFloat(netto) * parseFloat(nilai_pajak/100));
        var total_tagihan = netto + ppn - pph
        $("input[name='ed_total_tagihan']").val(total_tagihan.format());
        $("input[name='ed_netto']").val(netto.format());
        $("input[name='ed_ppn']").val(ppn.format());
        $("input[name='ed_pph']").val(pph.format());
    }

    $("select[name='cb_customer']").change(function(){
        var data = $(this).val();
        $("input[name='ed_customer']").val(data);
    });

    $("select[name='cb_cabang']").change(function(){
        var data = $(this).val();
        $("input[name='ed_cabang']").val(data);
    });

    $('#ed_diskon').keyup(function(){
        hitung();
    });

    $('#cb_jenis_ppn').change(function(){
        hitung();
    });

    $('#cb_pajak').change(function(){
        hitung();
    });

    $('#cb_pendapatan').change(function(){
        var kargo = '<option value="1" >EXCLUDE 10%</option>  <option value="5" >INCLUDE 10%</option> <option value="4" >NON PPN</option>' ;
        var paket = '<option value="3" >INCLUDE 1%</option> <option value="2" >EXCLUDE 1%</option> <option value="4" >NON PPN</option>';
        var data = $("select[name='cb_pendapatan']").val();
        if ( $(this).val() == "KARGO" || $(this).val() == "KORAN" ){
            $("select#cb_jenis_ppn").html(kargo);
        }else{
           $("select#cb_jenis_ppn").html(paket);
        }
        hitung();
        $("input[name='ed_pendapatan']").val(data);
        
    });
    $('#type_kiriman').change(function(){
        var data = $("select[name='type_kiriman']").val();
        $("input[name='ed_type_kiriman']").val(data);
    });

    $(document).ready( function () {
        var kargo = '<option value="1" >EXCLUDE 10%</option>  <option value="5" >INCLUDE 10%</option> <option value="4" >NON PPN</option>' ;
        var paket = '<option value="2" >EXCLUDE 1%</option> <option value="3" >INCLUDE 1%</option> <option value="4" >NON PPN</option>';
		
        if ( $(this).val() == "KARGO PAKET" || $(this).val() == "KARGO KERTAS"){
            $("select#cb_jenis_ppn").html(kargo);
        }else{
           $("select#cb_jenis_ppn").html(paket);
        }
        $("input[name='ed_tanggal']").focus();
        $("select[name='type_kiriman']").val('{{ $data->type_kiriman or ''  }}');
        $("select[name='cb_jenis_ppn']").val('{{ $data->jenis_ppn or ''  }}');
        $("select[name='cb_pajak']").val('{{ $data->pajak or 'T'  }}');
        $("select[name='cb_cabang']").val('{{ $data->kode_cabang or ''  }}');
        $("select[name='cb_pendapatan']").val('{{ $data->pendapatan or ''  }}');
        $("select[name='cb_customer']").val('{{ $data->kode_customer or ''  }}').trigger('chosen:updated');
		$('#cb_pendapatan').change();
        $jml_detail = {{ $jml_detail->jumlah  or 0}};
        if ($jml_detail > 0){
            $("input[name='ed_nomor']").attr('readonly','readonly');
            $("input[name='ed_nomor']").attr('readonly','readonly');
            $("select[name='type_kiriman']").attr('disabled','disabled');
            $("select[name='cb_cabang']").attr('disabled','disabled');
            $("select[name='cb_pendapatan']").attr('disabled','disabled');
            $("select[name='cb_customer']").prop('disabled', true).trigger("chosen:updated");
            $("input[name='ed_tanggal']").focus();
        }else{
            //$("input[name='ed_nomor']").focus();
        }
        $("input[name='ed_tanggal']").focus();
        var value ={
                    kode_customer: function () { return $("input[name='ed_customer']").val()},
                    type_kiriman: function () {return $("input[name='ed_type_kiriman']").val()},
                    pendapatan: function () {return $("input[name='ed_pendapatan']").val()},
                    kode_cabang: function () { return $("input[name='ed_cabang']").val()},
                    tgl_mulai_do: function () {return  $("input[name='ed_tanggal_mulai_do']").val()},
                    tgl_sampai_do: function () { return $("input[name='ed_tanggal_sampai_do']").val()}
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
                "url": baseUrl + "/sales/invoice_form/tampil_do",
                "type": "GET",
                "data" : value,
            },
            "columns": [
            { "data": "nomor" },
            { "data": "tanggal" },
            { "data": "total" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "button" },
            ]
        });

        var value ={
                    nomor: function () {return $("input[name='ed_nomor']").val()},
                    pendapatan: function () {return $("input[name='ed_pendapatan']").val()},
		};
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
                "url": baseUrl + "/sales/invoice_form/tabel_data_detail",
                "type": "GET",
                "data" : value,//{ nomor : function () { return $('#ed_nomor').val()}},
            },
            "columns": [
            { "data": "id" , render: $.fn.dataTable.render.number( '.'),"sClass": "id" },
            { "data": "nomor" },
            { "data": "tgl_do" },
            { "data": "keterangan" },
            { "data": "kuantum" ,"sClass": "cssright" },
            { "data": "harga_satuan" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "harga_bruto" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "diskon" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "harga_netto" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
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
            url :  baseUrl + "/sales/invoice/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('#form_header,#form_bottom').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result == 3){
                    alert('Nomor invoice sudah di pakai pada penerimaan penjualan atau kwitansi. Tidak bisa memilih nomor do');
                    return false();
                }
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
                var table = $('#table_data_do').DataTable();
                table.ajax.reload( null, false );
                $("#modal").modal("show");
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Error!", textStatus, "error");
            }
        });
        
    });

    $(document).on("click","#btnsimpan",function(){
        $.ajax(
        {
            url :  baseUrl + "/sales/invoice/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('#form_header,#form_bottom').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result == 3){
                    alert('Nomor invoice sudah di pakai pada penerimaan penjualan atau kwitansi. Data tidak bisa di simpan');
                    return false();
                }
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
        var nomor_do = [];

        var acc_piutang = $('#cb_customer').find(':selected').data('acc');                
        var jenis_ppn = $("select[name='cb_jenis_ppn']").val();
        var diskon = $("input[name='ed_diskon']").val();
        var pajak = $("select[name='cb_pajak']").val();
        var type_kiriman = $("input[name='ed_type_kiriman']").val()
        var pendapatan = $("input[name='ed_pendapatan']").val()
        var tgl = $("input[name='ed_tanggal']").val()        
        var table = $('#table_data_do').DataTable();
        var cabang = $("select[name='cb_cabang']").val();    
        table.$(':checkbox:checked').each(function(i){
            nomor_do[i] = $(this).attr("id");    
        });
        var nomor = $("input[name='ed_nomor']").val();

        var value = {
            nomor : nomor,
            nomor_do: nomor_do,
            jenis_ppn: jenis_ppn,
            diskon: diskon,
            pajak: pajak,
            type_kiriman: type_kiriman,
            pendapatan: pendapatan,
            tgl: tgl,
            cabang: cabang,
            acc_piutang:acc_piutang,
            _token: "{{ csrf_token() }}"
        };
        $.ajax(
        {
            url : baseUrl + "/sales/invoice/save_data_detail",
            type: "POST",
            dataType:"JSON",
            data : value ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.status == 'gagal'){
                   alert(data.info);
                }
                else if(data.result == 1){
                    var table = $('#table_data').DataTable();
                    table.ajax.reload( null, false );
                    $("#modal").modal('hide');
                    $("input[name='ed_total']").val(data.total);
                    $("input[name='ed_diskon']").val(data.diskon);
                    $("input[name='ed_ppn']").val(data.ppn);
                    $("input[name='ed_netto']").val(data.netto);
                    $("input[name='ed_pph']").val(data.pph);
                    $("input[name='ed_total_tagihan']").val(data.total_tagihan);
                    $("input[name='ed_nomor']").attr('readonly','readonly');
                    $("select[name='type_kiriman']").attr('disabled','disabled');
                    $("select[name='cb_cabang']").attr('disabled','disabled');
                    $("select[name='cb_pendapatan']").attr('disabled','disabled');
                    $("select[name='cb_customer']").prop('disabled', true).trigger("chosen:updated");
                    $("#btn_add").focus();
                    $("#btn-jurnal").css("display","");
                }else{
                    alert("Gagal menyimpan data!");
                }
            },
            
        });
        hitung();
    });

    $(document).on( "click",".btndelete", function() {
        var nomor = $("input[name='ed_nomor']").val();
        var id = $(this).attr("id");
        var jenis_ppn = $("select[name='cb_jenis_ppn']").val();
        var diskon = $("input[name='ed_diskon']").val();
        var pajak = $("select[name='cb_pajak']").val();
        if(!confirm("Hapus Data " +name+ " ?")) return false;
        var value = {
            id: id,
            nomor: nomor,
            jenis_ppn: jenis_ppn,
            diskon: diskon,
            pajak: pajak,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "POST",
            url : baseUrl + "/sales/invoice/hapus_data_detail",
            dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result == 3){
                    alert('Nomor invoice sudah di pakai pada penerimaan penjualan atau kwitansi. Data tidak bisa di hapus');
                    return false();
                }
                if(data.result ==1){
                    var table = $('#table_data').DataTable();
                    if (data.jml_detail == 0) {
                        $("input[name='ed_nomor']").removeAttr('readonly','readonly');
                        $("select[name='type_kiriman']").removeAttr('disabled');
                        $("select[name='cb_cabang']").removeAttr('disabled');
                        $("select[name='cb_pendapatan']").removeAttr('disabled');
                        $("select[name='cb_customer']").prop('disabled', false).trigger("chosen:updated");
                    }
                    $("input[name='ed_total']").val(data.total);
                    $("input[name='ed_diskon']").val(data.diskon);
                    $("input[name='ed_ppn']").val(data.ppn);
                    $("input[name='ed_netto']").val(data.netto);
                    $("input[name='ed_pph']").val(data.pph);
                    $("input[name='ed_total_tagihan']").val(data.total_tagihan);
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
        hitung();
    });

    function lihatjurnal(){
    var nomor=$("input[name='ed_nomor']").val();
      $.ajax(
        {
            url :  baseUrl + "/data/jurnal/"+nomor,
            type: "GET",                      
            success: function(data)
            {                
            $('#data-jurnal').html(data);
            $('#jurnal').modal('show');
            }
            });

        
}

</script>
@endsection
