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
                    <h5 style="margin-left : 5px"> DELIVERY ORDER
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

                <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->

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
                        <div class="x_content">
                            <div class="row">
                                <div class="col-xs-6">
                                    
                                </div>
                                <div class="col-xs-6">.col-xs-6</div>
                            </div>
                            <form id="form_header" class="form-horizontal kirim">
                                <table class="table table-striped table-bordered dt-responsive nowrap table-hover">
                                    <tbody>
                                        <tr style="max-height: 15px !important; height: 15px !important; overflow:hidden;">
                                            <td style="width:110px; padding-top: 0.4cm">Nomor</td>
                                            <td>
                                                <input type="text" class="form-control" id="ed_nomor" name="ed_nomor" style="text-transform: uppercase" value="{{ $do->nomor or null }}">
                                                <input type="hidden" class="form-control" id="ed_nomor_old" name="ed_nomor_old" value="{{ $do->nomor or null }}">
                                                <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly >
                                                <input type="hidden" class="form-control" name="crud_h" @if ($do === null) value="N" @else value="E" @endif>
                                            </td>
                                            <td style="padding-top: 0.4cm">Tanggal</td>
                                            <td>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tanggal" value="{{ $do->tanggal or  date('Y-m-d') }}">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Kota Asal</td>
                                            <td>
                                                <select class="chosen-select-width"  name="cb_kota_asal" style="width:100%">
                                                    <option value=""></option>
                                                @foreach ($kota as $row)
                                                    <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                                @endforeach
                                                </select>
                                            </td>
                                            <td style="padding-top: 0.4cm">Kota Tujuan</td>
                                            <td>
                                                <select class="chosen-select-width"  name="cb_kota_tujuan" style="width:100%">
                                                    <option value=""></option>
                                                @foreach ($kota as $row)
                                                    <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                                @endforeach
                                                </select>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td style="width:110px; padding-top: 0.4cm">Pendapatan</td>
                                            <div class="form-group">
                                                <td>
                                                    <select class="form-control" name="pendapatan" id="pendapatan" class="form-control" onChange="tkir();" >
                                                        <option value="KERTAS" />KERTAS</option>
                                                        <option value="PAKET" />PAKET</option>
                                                    </select>
                                                </td>
                                            </div>
                                            <td style="width:110px; padding-top: 0.4cm">Type Kiriman</td>
                                            <td>
                                                <select class="form-control"  name="type_kiriman" id="type_kiriman" >
                                                    <option value="KARGO KERTAS">KARGO KERTAS</option>
                                                    <option value="KERTAS">KERTAS</option>
                                                </select>
                                            </td>
                                            <td style="width:110px; padding-top: 0.4cm">Jenis Kiriman</td>
                                            <td colspan="3">
                                                <select class="form-control" name="jenis_kiriman" id="jenis_kiriman" >
                                                    <option value="REGULER">REGULER</option>
                                                    <option value="EXPRESS">EXPRESS</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:110px; padding-top: 0.4cm">DO Outlet</td>
                                            <td colspan="">
                                                <select class="chosen-select-width"  name="cb_outlet" style="width:100%">
                                                    <option value="NON OUTLET">NON OUTLET</option>
                                                @foreach ($outlet as $row)
                                                    <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                @endforeach
                                                </select>
                                            </td>
                                            <td style="">Biaya Tambahan</td>
                                            <td>
                                                <input type="text" class="form-control" name="ed_biaya_tambahan" style="text-align:right" @if ($do === null) value="0" @else value="{{ number_format($do->biaya_tambahan, 0, ",", ".") }}" @endif>
                                            </td>
                                            <td style="padding-top: 0.4cm" id="div_kom">Biaya Komisi</td>
                                            <td colspan="" id="div_kom">
                                                <input type="text" class="form-control" name="ed_biaya_komisi" id="biaya_komisi" style="text-align:right" @if ($do === null) value="0" @else value="{{ number_format($do->biaya_komisi, 0, ",", ".") }}" @endif>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Customer</td>
                                            <td colspan="">
                                                <select class="chosen-select-width"  name="cb_customer" style="width:100%" >
                                                    <option> </option>
                                                @foreach ($customer as $row)
                                                    <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                @endforeach
                                                </select>
                                            </td>
                                            <td style="width:110px; padding-top: 0.4cm">Marketing</td>
                                            <td colspan="">
                                                <select class="chosen-select-width"  name="cb_marketing" style="width:100%">
                                                    <option> </option>
                                                @foreach ($marketing as $row)
                                                    <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                @endforeach
                                                </select>
                                            </td>
                                            <td colspan="2">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="ck_ppn"> PPN
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:110px;">Nama Pengirim</td>
                                            <td>
                                                <input type="text" class="form-control" name="ed_nama_pengirim" style="text-transform: uppercase" value="{{ $do->nama_pengirim or null }}">
                                            </td>
                                            <td style="width:110px;">Alamat Pengirim</td>
                                            <td>
                                                <input type="text" class="form-control" name="ed_alamat_pengirim"  style="text-transform: uppercase" value="{{ $do->alamat_pengirim or null }}">
                                            </td>
                                            <td style="width:110px;">Telpon Pengirim</td>
                                            <td>
                                                <input type="text" class="form-control" name="ed_telpon_pengirim"  style="text-transform: uppercase" value="{{ $do->telpon_pengirim or null }}">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="width:110px;">Nama Penerima</td>
                                            <td>
                                                <input type="text" class="form-control" name="ed_nama_penerima"  style="text-transform: uppercase" value="{{ $do->nama_penerima or null }}">
                                            </td>
                                            <td style="width:110px;">Alamat Penerima</td>
                                            <td>
                                                <input type="text" class="form-control" name="ed_alamat_penerima"  style="text-transform: uppercase" value="{{ $do->alamat_penerima or null }}">
                                            </td>
                                            <td style="width:110px;">Telpon Penerima</td>
                                            <td>
                                                <input type="text" class="form-control" name="ed_telpon_penerima"  style="text-transform: uppercase" value="{{ $do->telpon_penerima or null }}">
                                            </td>
                                        </tr>


                                        <tr>
                                            <td style="padding-top: 0.4cm">Total</td>
                                            <td >
                                                <input type="text" class="form-control" name="ed_total" style="text-align:right" readonly="readonly" tabindex="-1" @if ($do === null) value="0" @else value="{{ number_format($do->total, 0, ",", ".") }}" @endif>
                                            </td>
                                            <td style="padding-top: 0.4cm">Diskon</td>
                                            <td >
                                                <input type="text" class="form-control" name="ed_diskon_m" style="text-align:right" readonly="readonly" tabindex="-1" @if ($do === null) value="0" @else value="{{ number_format($do->diskon, 0, ",", ".") }}" @endif>
                                            </td>
                                            <td style="padding-top: 0.4cm">Total Net</td>
                                            <td >
                                                <input type="text" class="form-control" name="ed_total_net" style="text-align:right" readonly="readonly" tabindex="-1" @if ($do === null) value="0" @else value="{{ number_format($do->total_net, 0, ",", ".") }}" @endif>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>


                                <div class="row">
                                <div class="col-md-4">
                                  <button type="button" class="btn btn-primary " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Add Item</button>
                                </div>

                                <div class="pull-right">
                                  <button type="submit" class="btn btn-success " id="btnsimpan" name="btnsimpan"  style="position: absolute; right: 14px;"><i class="glyphicon glyphicon-ok"></i>Simpan</button>
                                </div>
                                </div>
                            </form>
                        </div>






                        <!--TIPE PENDAPATAN PAKET-->
                        <!-- modal dokumen-->
                        <div id="modal_dokumen" class="modal" >
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title">Insert Edit Delivery Order Cabang</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal kirim_detail">
                                        <table id="table_data" class="table table-striped table-bordered table-hover">
                                            <tbody>
                                                <tr>
                                                    <td style="width:120px; padding-top: 0.4cm">No Sales Order</td>
                                                    <td colspan="5">
                                                        <div class="input-group" style="width : 100%">
                                                            <input  type="text" class="form-control" name="ed_so" readonly="readonly" tabindex="-1"> <span class="input-group-btn"> <button type="button" id="btn_pilih_so" class="btn btn-primary">Search
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:120px; padding-top: 0.4cm">Item</td>
                                                    <td colspan="5">
                                                        <div class="input-group" style="width : 100%">
                                                            <input  type="text" class="form-control" name="ed_item" disabled="disabled"> <span class="input-group-btn"> <button type="button" id="btn_pilih_item" class="btn btn-primary">Search
                                                            <input type="hidden" class="form-control" name="ed_kode_item" >
                                                            <input type="hidden" class="form-control" name="ed_id">
                                                            <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly >
                                                            <input type="hidden" class="form-control" name="crud" value="N">
                                                            <input type="hidden" class="form-control" name="ed_nomor_d">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr id="kargo">
                                                    <td style="width:120px; padding-top: 0.4cm">Jenis Kendaraan</td>
                                                    <td>
                                                        <select class="select2_single form-control"  name="cb_angkutan" id="cb_angkutan" style="width: 100% !important;" disabled="disabled">
                                                            <option></option>
                                                        @foreach ($angkutan as $row)
                                                            <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                        @endforeach
                                                        </select>
                                                    </td>

                                                    <td style="padding-top: 0.4cm">No Surat Jalan</td>
                                                    <td><input type="text" class="form-control" name="ed_surat_jalan" style="text-transform: uppercase"></td>
                                                    <td style="padding-top: 0.4cm">Nopol</td>
                                                    <td>
                                                        <select class="chosen-select-width"  name="cb_nopol" style="width:100%">
                                                            <option></option>
                                                        @foreach ($kendaraan as $row)
                                                            <option value="{{ $row->nopol }}"> {{ $row->nopol }} </option>
                                                        @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="dimensi">
                                                    <td style="padding-top: 0.4cm">Panjang</td>
                                                    <td><input type="text" class="form-control" name="ed_panjang" style="text-align:right"></td>
                                                    <td style="padding-top: 0.4cm">Lebar</td>
                                                    <td><input type="text" class="form-control" name="ed_lebar" style="text-align:right"></td>
                                                    <td style="padding-top: 0.4cm">Tinggi</td>
                                                    <td><input type="text" class="form-control" name="ed_tinggi" style="text-align:right"></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Jumlah</td>
                                                    <td><input type="text" class="form-control" name="ed_jumlah" id="ed_jumlah" style="text-align:right"></td>
                                                    <td style="padding-top: 0.4cm">Satuan</td>
                                                    <td colspan="3"><input type="text" class="form-control" id="edsatuan" name="ed_satuan" readonly="readonly" tabindex="-1"></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Harga</td>
                                                    <td><input type="text" class="form-control" name="ed_harga" style="text-align:right"></td>
                                                    <td style="padding-top: 0.4cm; width: 105px">Biaya Penerus</td>
                                                    <td colspan="3"><input type="text" class="form-control" name="ed_biaya_penerus" style="text-align:right" ></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Discount</td>
                                                    <td><input type="text" class="form-control" name="ed_diskon" style="text-align:right"></td>
                                                    <td style="padding-top: 0.4cm">Total</td>
                                                    <td colspan="3"><input type="text" class="form-control" name="ed_total_harga" style="text-align:right" readonly="readonly" tabindex="-1" ></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Keterangan</td>
                                                    <td colspan="5"><textarea class="form-control" rows="3" name="ed_keterangan" id="ed_keterangan"  style="text-transform: uppercase"></textarea></td>
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
                        <!-- end modal dokumen-->



                        <!--- END TIPE PENDAPATAN PAKET-->

                        <!----modal pilih nomor sales order--->

                        <div id="modal_pilih_nomor_so" class="modal" >
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h2>Pilih Nomor SO dari Pelanggan 1</h2>
                              </div>
                              <div class="modal-body">
                                <form class="form-horizontal">
                                    <table id="table_data_so" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nomor SO</th>
                                                <th>Tanggal</th>
                                                <th>Item</th>
                                                <th>Qty</th>
                                                <th>Jml Harga</th>
                                                <th>Pilih</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </form>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!----modal pilih item--->
                        <div id="modal_pilih_item" class="modal" >
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4>Pilih Item</h4>
                              </div>
                              <div class="modal-body">
                                <form class="form-horizontal">
                                    <table id="tableitem" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th> Kode</th>
                                                <th> Nama </th>
                                                <th> Satuan </th>
                                                <th style="width:50px"> Aksi </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- modal -->




                    </div>
                </form>
                <div class="box-body">
                    <table id="table_data_detail" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> No SO</th>
                                <th> Kode Item</th>
                                <th> Nama Item </th>
                                <th> Keterangan </th>
                                <th> Qty </th>
                                <th> Satuan </th>
                                <th> Ttl Harga </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">





                    </div>
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
        $("select[name='cb_kota_asal']").val('{{ $do->id_kota_asal or ''  }}').trigger('chosen:updated');
        $("select[name='cb_kota_tujuan']").val('{{ $do->id_kota_tujuan or ''  }}').trigger('chosen:updated');
        $("select[name='pendapatan']").val('{{ $do->pendapatan or ''  }}');
        $("select[name='type_kiriman']").val('{{ $do->type_kiriman or ''  }}');
        $("select[name='jenis_kiriman']").val('{{ $do->jenis_pengiriman or ''  }}');
        $("select[name='cb_customer']").val('{{ $do->kode_customer or ''  }}').trigger('chosen:updated');
        $("select[name='cb_outlet']").val('{{ $do->kode_outlet or ''  }}').trigger('chosen:updated');
        $("select[name='cb_marketing']").val('{{ $do->kode_marketing or ''  }}').trigger('chosen:updated');
        $("input[name='ck_ppn']").attr('checked', {{ $do->ppn or null}});
        var jumlah = {{ $jml_detail->jumlah or '0'}};
        if (jumlah == 0 ) {
            $("#ed_nomor").focus();
        }else{
            $("input[name='ed_biaya_tambahan']").focus();
            $("input[name='ed_nomor']").attr('readonly','readonly');
            $("select[name='cb_kota_asal']").attr('disabled','disabled');
            $("select[name='cb_kota_tujuan']").attr('disabled','disabled');
            $("select[name='pendapatan']").attr('disabled','disabled');
            $("select[name='jenis_kiriman']").attr('disabled','disabled');
            $("select[name='type_kiriman']").attr('disabled','disabled');
        }       
        
        $('#table_data_detail').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "ajax": {
              "url" :  baseUrl + "/sales/deliveryorderform/tabel_data_detail",
              "type": "GET",
              "data" : { nomor : function () { return $('#ed_nomor').val()}},
            },
            "columns": [
            { "data": "nomor_so" },
            { "data": "kode_item" },
            { "data": "nama" },
            { "data": "keterangan" },
            { "data": "jumlah", render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "satuan" },
            { "data": "total", render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "button" },
            ]
        });

        $('#tableitem').DataTable({
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
              "url" :  baseUrl + "/sales/deliveryorderform/tabel_item",
              "type": "GET"
            },
            "columns": [
            { "data": "kode" },
            { "data": "nama" },
            { "data": "kode_satuan" },
            { "data": "button" },
            ]
        });
        $('#tableitem_filter input').keypress(function(event) {
            var keycode = event.keyCode || event.which;
            if(keycode == '13') {
                $(".btnpilih").focus();
            }
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

        $("input[name='ed_harga'],input[name='ed_jumlah'],input[name='ed_biaya_penerus'],input[name='ed_diskon']").maskMoney({thousands:'.', decimal:',', precision:-1});
        $("input[name='ed_biaya_tambahan'],input[name='ed_biaya_komisi']").maskMoney({thousands:'.', decimal:',', precision:-1});

    });



    //window.scrollTo(0, 120);
    function tkir(){
    if (document.getElementById('pendapatan').value != ''){if (document.getElementById('pendapatan').value == "KERTAS"){document.getElementById('type_kiriman').innerHTML = "<option value='KARGO KERTAS'>KARGO KERTAS</option><option value='KERTAS'>KERTAS</option>"}
    } else {document.getElementById('type_kiriman').innerHTML = "<option value=''>-- Pilih Type Kiriman --</option>"}
    if (document.getElementById('pendapatan').value != ''){if (document.getElementById('pendapatan').value == "koran"){document.getElementById('type_kiriman').innerHTML = ""}
    } else {document.getElementById('type_kiriman').innerHTML = "<option value=''>-- Pilih Type Kiriman --</option>"}
    if (document.getElementById('pendapatan').value != ''){if (document.getElementById('pendapatan').value == "PAKET"){document.getElementById('type_kiriman').innerHTML = "<option value='DOKUMEN'>DOKUMEN</option><option value='KARGO PAKET'>KARGO PAKET</option><option value='KILOGRAM'>KILOGRAM</option><option value='KOLI'>KOLI</option>"}
    } else {document.getElementById('type_kiriman').innerHTML = "<option value=''>-- Pilih Type Kiriman --</option>"}

    }

    $('#do_agen').change(function(){
        x=$(this).val();
            if(x!=''){
                $('#div_kom').show();
            } else {
                $('#div_kom').hide();
        }
    });

    $('#pendapatan').change(function(){
        x=$(this).val();
            if(x=='kertas'){
                $('#sj').show();
                $('#np').show();
            } else {
                $('#sj').hide();
                $('#np').hide();
        }
    });


    $(document).on("click","#btnadd",function(){
        if ( $("#type_kiriman").val() =='DOKUMEN') {
            $("#dimensi").hide();
            $("#kargo").hide();
            $("#modal_dokumen").modal("show");
            $("#btn_pilih_item").focus();
        }else if ( $("#type_kiriman").val() =='KARGO PAKET' || $("#type_kiriman").val() =='KARGO KERTAS') {
            $("#dimensi").hide();
            $("#kargo").show();
            $('#cb_angkutan').removeAttr('disabled');
            $("#modal_dokumen").modal("show");
            $("#btn_pilih_item").focus();
        }else if ( $("#type_kiriman").val() =='KILOGRAM') {
            $("#dimensi").show();
            $("#kargo").hide();
            $("#modal_dokumen").modal("show");
            $("#btn_pilih_item").focus();
        }else if ( $("#type_kiriman").val() =='KOLI') {
            $("#dimensi").hide();
            $("#kargo").hide();
            $("#modal_dokumen").modal("show");
            $("#btn_pilih_item").focus();
        }else if ( $("#type_kiriman").val() =='KERTAS') {
            $("#dimensi").hide();
            $("#kargo").show();
            $('#cb_angkutan').attr('disabled','disabled');
            $("#modal_dokumen").modal("show");
            $("#btn_pilih_item").focus();
        }
        var kota_asal = $("select[name='cb_kota_asal']").val();
        var kota_tujuan = $("select[name='cb_kota_tujuan']").val();
        var pendapatan = $("select[name='pendapatan']").val();
        var type_kiriman = $("select[name='type_kiriman']").val();
        var jenis_kiriman = $("select[name='jenis_kiriman']").val();
        if (kota_asal == '') {
            alert('Kota asal harus di isi');
            $("select[name='cb_kota_asal']").focus();
            return false;
        }else if (kota_tujuan == '') {
            alert('Kota tujuan harus di isi');
            $("select[name='cb_kota_tujuan']").focus();
            return false;
        }else if (pendapatan == '') {
            alert('Pendapatan harus di isi');
            $("select[name='pendapatan']").focus();
            return false;
        }else if (type_kiriman == '') {
            alert('Type kiriman harus di isi');
            $("select[name='type_kiriman']").focus();
            return false;
        }else if (jenis_kiriman == '') {
            alert('Jenis kiriman harus di isi');
            $("select[name='jenis_kiriman']").focus();
            return false;
        }
        
        $("input[name='crud']").val('N');
        $("input[name='ed_harga']").val(0);
        $("input[name='ed_jumlah']").val(0);
        $("input[name='ed_biaya_penerus']").val(0);
        $("input[name='ed_diskon']").val(0);
        $("input[name='ed_panjang']").val(0);
        $("input[name='ed_lebar']").val(0);
        $("input[name='ed_tinggi']").val(0);
        $("#ed_keterangan").val('');
        $("input[name='ed_so']").val('');
        $("input[name='ed_item']").val('');
        $("input[name='ed_satuan']").val('');
        $("input[name='ed_kode_item']").val('');
        $("select[name='cb_angkutan']").val('').trigger('chosen:updated');
        $("select[name='cb_nopol']").val('').trigger('chosen:updated');
        $.ajax(
        {
            url :  baseUrl + "/sales/deliveryorderform/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
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
    
    $(document).on("click","#btnsimpan",function(){
        var kota_asal = $("select[name='cb_kota_asal']").val();
        var kota_tujuan = $("select[name='cb_kota_tujuan']").val();
        var pendapatan = $("select[name='pendapatan']").val();
        var type_kiriman = $("select[name='type_kiriman']").val();
        var jenis_kiriman = $("select[name='jenis_kiriman']").val();
        if (kota_asal == '') {
            alert('Kota asal harus di isi');
            $("select[name='cb_kota_asal']").focus();
            return false;
        }else if (kota_tujuan == '') {
            alert('Kota tujuan harus di isi');
            $("select[name='cb_kota_tujuan']").focus();
            return false;
        }else if (pendapatan == '') {
            alert('Pendapatan harus di isi');
            $("select[name='pendapatan']").focus();
            return false;
        }else if (type_kiriman == '') {
            alert('Type kiriman harus di isi');
            $("select[name='type_kiriman']").focus();
            return false;
        }else if (jenis_kiriman == '') {
            alert('Jenis kiriman harus di isi');
            $("select[name='jenis_kiriman']").focus();
            return false;
        }
        
        $.ajax(
        {
            url :  baseUrl + "/sales/deliveryorderform/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result != 1){
                        alert("Gagal menyimpan data!");
                    }else{
                        window.location.href = baseUrl + '/sales/deliveryorder'
                    }
                }else if(data.crud == 'E'){
                    if(data.result != 1){
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }else{
                        window.location.href = baseUrl + '/sales/deliveryorder';
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

    $("#cb_angkutan").change(function(){
        var value = {
            pendapatan: $("select[name='pendapatan']").val(),
            asal: $("select[name='cb_kota_asal']").val(),
            tujuan: $("select[name='cb_kota_tujuan']").val(),
            tipe: $("select[name='type_kiriman']").val(),
            tujuan: $("select[name='cb_kota_tujuan']").val(),
            jenis: $("select[name='jenis_kiriman']").val(),
            angkutan: $("select[name='cb_angkutan']").val(),
        };
        $.ajax(
        {
            url : baseUrl + "/sales/deliveryorderform/cari_harga",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='ed_harga']").val(data.harga);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               // swal("Error!", textStatus, "error");
            }
        });
    });

    $("#ed_jumlah").focusout(function(){
        var value = {
            pendapatan: $("select[name='pendapatan']").val(),
            asal: $("select[name='cb_kota_asal']").val(),
            tujuan: $("select[name='cb_kota_tujuan']").val(),
            tipe: $("select[name='type_kiriman']").val(),
            jenis: $("select[name='jenis_kiriman']").val(),
            berat: $("input[name='ed_jumlah']").val(),
            angkutan: $("select[name='cb_angkutan']").val(),
        };
        if ($("select[name='type_kiriman']").val()== 'KARGO PAKET' || $("select[name='type_kiriman']").val()== 'KARGO KERTAS') {
            return false;
        }
        $.ajax(
        {
            url : baseUrl + "/sales/deliveryorderform/cari_harga",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='ed_harga']").val(data.harga);
                $("input[name='ed_biaya_penerus']").val(data.biaya_penerus);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
             //   swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on("click","#btn_pilih_so",function(){
        $("#modal_pilih_nomor_so").modal("show");
    });

    $(document).on("click","#btn_pilih_item",function(){
        $("#modal_pilih_item").modal("show");
        $('#tableitem_filter input').focus();
    });

    $(document).on( "click",".btnpilih", function() {
        var id=$(this).attr("id");
        var value = {
            id: id
        };
        $.ajax(
        {
            url : baseUrl + "/sales/deliveryorderform/get_item",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='ed_satuan']").val(data[0].kode_satuan);
                //$("input[name='ed_harga']").val(data[0].harga);
                $("input[name='ed_item']").val(data[0].nama);
                $("input[name='ed_kode_item']").val(data[0].kode);
                $("#modal_pilih_item").modal("hide");
                if ($("select[name='type_kiriman']").val()== 'KARGO PAKET' || $("select[name='type_kiriman']").val()== 'KARGO KERTAS') {
                    $("#cb_angkutan").focus();
                }else if ($("select[name='type_kiriman']").val()== 'KERTAS'){
                    $("input[name='ed_surat_jalan']").focus();
                }else{
                    $("#ed_jumlah").focus();
                }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    });

    $("input[name='ed_harga'],input[name='ed_jumlah'],input[name='ed_biaya_penerus'],input[name='ed_diskon']").keyup(function(){
        var harga = $("input[name='ed_harga']").val();
        var jumlah = $("input[name='ed_jumlah']").val();
        var biaya_penerus = $("input[name='ed_biaya_penerus']").val();
        var diskon  = $("input[name='ed_diskon']").val();
        var harga = harga.replace(/[A-Za-z$. ,-]/g, "");
        var jumlah = jumlah.replace(/[A-Za-z$. ,-]/g, "");
        var biaya_penerus = biaya_penerus.replace(/[A-Za-z$. ,-]/g, "");
        var diskon = diskon.replace(/[A-Za-z$. ,-]/g, "");
        var harga  = parseFloat(harga);
        var jumlah  = parseFloat(jumlah);
        var biaya_penerus  = parseFloat(biaya_penerus);
        var diskon  = parseFloat(diskon);
        var total= 0;
        if ($("select[name='type_kiriman']").val()== 'KERTAS') {
            total = (harga + biaya_penerus) * jumlah - diskon  ;
        }else{
            total = harga + biaya_penerus - diskon  ;
        }
        $("input[name='ed_total_harga']").val(total.format());
    });
    
    $("input[name='ed_biaya_tambahan'],input[name='ed_biaya_komisi']").keyup(function(){
        var biaya_tambahan = $("input[name='ed_biaya_tambahan']").val();
        var biaya_komisi = $("input[name='ed_biaya_komisi']").val();
        var diskon = $("input[name='ed_diskon_m']").val();
        var total = $("input[name='ed_total']").val();
        var biaya_tambahan = biaya_tambahan.replace(/[A-Za-z$. ,-]/g, "");
        var biaya_komisi = biaya_komisi.replace(/[A-Za-z$. ,-]/g, "");
        var diskon = diskon.replace(/[A-Za-z$. ,-]/g, "");
        var total = total.replace(/[A-Za-z$. ,-]/g, "");
        var total_net = parseFloat(biaya_tambahan) + parseFloat(biaya_komisi)+ parseFloat(total) - parseFloat(diskon)  ;
        var total = parseFloat(total_net) + parseFloat(diskon)  ;
        $("input[name='ed_total_net']").val(total_net.format());
        $("input[name='ed_total']").val(total.format());
    });



    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    $(document).on("click","#btnsave",function(){
        var nomor = $("input[name='ed_nomor']").val();
        var item = $("input[name='ed_kode_item']").val();
        if (item == '') {
            alert('Item harus di isi');
            $("#btn_pilih_item").focus();
            return false;
        }
        $("input[name='ed_nomor_d']").val(nomor);
        $.ajax(
        {
            url :  baseUrl + "/sales/deliveryorderform/save_data_detail",
            type: "POST",
            dataType:"JSON",
            data : $('.kirim_detail :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result == 1){
                        var table = $('#table_data_detail').DataTable();
                        var biaya_komisi = $("input[name='ed_biaya_komisi']").val();
                        var biaya_tambahan = $("input[name='ed_biaya_tambahan']").val();
                        var biaya_komisi = biaya_komisi.replace(/[A-Za-z$. ,-]/g, "");
                        var biaya_tambahan = biaya_tambahan.replace(/[A-Za-z$. ,-]/g, "");
                        table.ajax.reload( null, false );
                        $("#modal_dokumen").modal('hide');
                        $("#btn_add").focus();
                        $("input[name='ed_nomor']").attr('readonly','readonly');
                        $("select[name='cb_kota_asal']").attr('disabled','disabled');
                        $("select[name='cb_kota_tujuan']").attr('disabled','disabled');
                        $("select[name='pendapatan']").attr('disabled','disabled');
                        $("select[name='jenis_kiriman']").attr('disabled','disabled');
                        $("select[name='type_kiriman']").attr('disabled','disabled');
                        var total = parseFloat(data.total[0].total) + parseFloat(biaya_komisi) + parseFloat(biaya_tambahan);
                        var total_net = parseFloat(total) - parseFloat(data.total[0].diskon);
                        var diskon = parseFloat(data.total[0].diskon);
                        $("input[name='ed_total']").val(total.format());
                        $("input[name='ed_diskon_m']").val(diskon.format());
                        $("input[name='ed_total_net']").val(total_net.format());
                    }else{
                        alert("Gagal menyimpan data!");
                    }
                }else if(data.crud == 'E'){
                    if(data.result == 1){
                        var table = $('#table_data_detail').DataTable();
                        var biaya_komisi = $("input[name='ed_biaya_komisi']").val();
                        var biaya_tambahan = $("input[name='ed_biaya_tambahan']").val();
                        var biaya_komisi = biaya_komisi.replace(/[A-Za-z$. ,-]/g, "");
                        var biaya_tambahan = biaya_tambahan.replace(/[A-Za-z$. ,-]/g, "");
                        table.ajax.reload( null, false );
                        $("#modal_dokumen").modal('hide');
                        $("#btn_add").focus();
                        $("input[name='ed_nomor']").attr('readonly','readonly');
                        $("select[name='cb_kota_asal']").attr('disabled','disabled');
                        $("select[name='cb_kota_tujuan']").attr('disabled','disabled');
                        $("select[name='pendapatan']").attr('disabled','disabled');
                        $("select[name='jenis_kiriman']").attr('disabled','disabled');
                        $("select[name='type_kiriman']").attr('disabled','disabled');
                        var total = parseFloat(data.total[0].total) + parseFloat(biaya_komisi) + parseFloat(biaya_tambahan);
                        var total_net = parseFloat(total) - parseFloat(data.total[0].diskon);
                        var diskon = parseFloat(data.total[0].diskon);
                        $("input[name='ed_total']").val(total.format());
                        $("input[name='ed_diskon_m']").val(diskon.format());
                        $("input[name='ed_total_net']").val(total_net.format());
                    }else{
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

    $(document).on( "click",".btnedit", function() {
        if ( $("#type_kiriman").val() =='DOKUMEN') {
            $("#dimensi").hide();
            $("#kargo").hide();
            $("#modal_dokumen").modal("show");
            $("#btn_pilih_item").focus();
        }else if ( $("#type_kiriman").val() =='KARGO PAKET' || $("#type_kiriman").val() =='KARGO KERTAS') {
            $("#dimensi").hide();
            $("#kargo").show();
            $('#cb_angkutan').removeAttr('disabled');
            $("#modal_dokumen").modal("show");
            $("#btn_pilih_item").focus();
        }else if ( $("#type_kiriman").val() =='KILOGRAM') {
            $("#dimensi").show();
            $("#kargo").hide();
            $("#modal_dokumen").modal("show");
            $("#btn_pilih_item").focus();
        }else if ( $("#type_kiriman").val() =='KOLI') {
            $("#dimensi").hide();
            $("#kargo").hide();
            $("#modal_dokumen").modal("show");
            $("#btn_pilih_item").focus();
        }else if ( $("#type_kiriman").val() =='KERTAS') {
            $("#dimensi").hide();
            $("#kargo").show();
            $('#cb_angkutan').attr('disabled','disabled');
            $("#modal_dokumen").modal("show");
            $("#btn_pilih_item").focus();
        }
        var id=$(this).attr("id");
        var item = $(this).attr("name");
        var value = {
            id: id
        };
        $.ajax(
        {
            url :  baseUrl + "/sales/deliveryorderform/get_data_detail",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='crud']").val('E');
                $("input[name='ed_so']").val(data.nomor_so);
                $("input[name='ed_nomor']").val(data.nomor);
                $("input[name='ed_id']").val(data.id);
                $("input[name='ed_kode_item']").val(data.kode_item);
                $("input[name='ed_item']").val(item);
                $("input[name='ed_satuan']").val(data.satuan);
                $("select[name='cb_angkutan']").val(data.kode_angkutan).trigger('chosen:updated');
                $("input[name='ed_surat_jalan']").val(data.no_surat_jalan);
                $("select[name='cb_nopol']").val(data.nopol).trigger('chosen:updated');
                $("input[name='ed_panjang']").val(data.panjang);
                $("input[name='ed_lebar']").val(data.lebar);
                $("input[name='ed_tinggi']").val(data.tinggi);
                $("input[name='ed_jumlah']").val(data.jumlah);
                $("input[name='ed_harga']").val(data.harga);
                $("input[name='ed_biaya_penerus']").val(data.biaya_penerus);
                $("input[name='ed_diskon']").val(data.diskon);
                $("input[name='ed_total_harga']").val(data.total);
                $("#ed_keterangan").val(data.keterangan);

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on( "click",".btndelete", function() {
        var name = $(this).attr("name");
        var nomor = $("#ed_nomor").val();
        var id = $(this).attr("id");
        if(!confirm("Hapus Data " +name+ " ?")) return false;
        var value = {
            id: id,
            nomor : nomor,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "POST",
            url :  baseUrl + "/sales/deliveryorderform/hapus_data_detail",
            dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result == 1){
                    var table = $('#table_data_detail').DataTable();
                    var biaya_komisi = $("input[name='ed_biaya_komisi']").val();
                    var biaya_tambahan = $("input[name='ed_biaya_tambahan']").val();
                    var biaya_komisi = biaya_komisi.replace(/[A-Za-z$. ,-]/g, "");
                    var biaya_tambahan = biaya_tambahan.replace(/[A-Za-z$. ,-]/g, "");
                    table.ajax.reload( null, false );
                    if (data.jml_detail[0].jumlah == 0) {
                        $("input[name='ed_nomor']").removeAttr('readonly','readonly');
                        $("select[name='cb_kota_asal']").removeAttr('disabled','disabled');
                        $("select[name='cb_kota_tujuan']").removeAttr('disabled','disabled');
                        $("select[name='pendapatan']").removeAttr('disabled','disabled');
                        $("select[name='jenis_kiriman']").removeAttr('disabled','disabled');
                        $("select[name='type_kiriman']").removeAttr('disabled','disabled');
                        var total = parseFloat(biaya_komisi) + parseFloat(biaya_tambahan);
                        var total_net = parseFloat(biaya_komisi) + parseFloat(biaya_tambahan);
                        var diskon = 0;
                    }else{
                        var total = parseFloat(biaya_komisi) + parseFloat(biaya_tambahan) - parseFloat(data.total[0].total);
                        var total_net = parseFloat(total) - parseFloat(data.total[0].diskon);
                        var diskon = data.total[0].diskon;
                    }
                    
                    $("input[name='ed_total']").val(total.format());
                    $("input[name='ed_diskon_m']").val(diskon.format());
                    $("input[name='ed_total_net']").val(total_net.format());
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
