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
                                <td style="width:px; padding-top: 0.4cm">Nomor</td>
                                <td colspan="20">
                                    <input type="text" name="ed_nomor" id="ed_nomor" class="form-control" readonly="readonly" style="text-transform: uppercase" value="{{ $data->nomor or null }}" >
                                    <input type="hidden" name="ed_nomor_old" class="form-control" style="text-transform: uppercase" value="{{ $data->nomor or null }}" >
                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                    <input type="hidden" class="form-control" name="crud_h" class="form-control" @if ($data === null) value="N" @else value="E" @endif>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td >
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control col-xs-12" name="ed_tanggal" value="{{ $data->tanggal or  date('Y-m-d') }}">
                                    </div>
                                </td>
                                <td style="width:110px;">Jenis Pembayaran</td>
                                <td >
                                    <select class="form-control" name="cb_jenis_pembayaran" >
                                        <option value="T"> TUNAI/CASH </option>
                                        <option value="C"> TRANSFER </option>
                                        <option value="F"> CHEQUE/BG </option>
                                        <option value="U"> UANG MUKA/DP </option>
                                    </select>
                                    <input type="hidden" name="ed_jenis_pembayaran" value="{{ $data->jenis_pembayaran or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Akun</td>
                                <td colspan="3">
                                    <select class="form-control" name="cb_akun_h" >
                                        <option value="1000001"> KAS KECIL </option>
                                        <option value="2000001"> BANK BNI </option>
                                        <option value="2000002"> BANK BCA </option>
                                        <option value="2000003"> BANK MANDIRI </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Customer</td>
                                <td >
                                    <select class="chosen-select-width"  name="cb_customer" id="cb_customer" style="width:100%" >
                                        <option></option>
                                    @foreach ($customer as $row)
                                        <option value="{{ $row->kode }}">{{ $row->kode }}  &nbsp - &nbsp {{ $row->nama }} </option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" name="ed_customer" value="{{ $data->kode_customer or null }}" >
                                </td>
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td >
                                    <select class="chosen-select-width" name="cb_cabang" >
                                        <option></option>
                                    @foreach ($cabang as $row)
                                        <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" name="ed_cabang" value="{{ $data->kode_cabang or null }}" >
                                </td>
                            </tr>
                            <tr>    
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td colspan="3">
                                    <input type="text" name="ed_keterangan" class="form-control" style="text-transform: uppercase" value="{{ $data->keterangan or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Ttl Jml Bayar</td>
                                <td colspan="3">
                                    <input type="text" name="ed_jumlah" class="form-control" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1" @if ($data === null) value="0" @else value="{{ number_format($data->jumlah, 0, ",", ".") }}" @endif>
                                </td>
                              
                            </tr>
                            <tr>
                                  <td style="width:120px; padding-top: 0.4cm">Ttl Debet</td>
                                <td colspan="3">
                                    <input type="text" name="ed_debet" class="form-control" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1" @if ($data === null) value="0" @else value="{{ number_format($data->debet, 0, ",", ".") }}" @endif>
                                </td>
                            </tr>
                            <tr>
                                 <td style="width:120px; padding-top: 0.4cm">Ttl Kredit</td>
                                <td colspan="3">
                                    <input type="text" name="ed_kredit" class="form-control" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1" @if ($data === null) value="0" @else value="{{ number_format($data->kredit, 0, ",", ".") }}" @endif>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Netto</td>
                                <td colspan="3">
                                    <input type="text" name="ed_netto" class="form-control" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1" @if ($data === null) value="0" @else value="{{ number_format($data->netto, 0, ",", ".") }}" @endif>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-7">
                            
                        </div>
                        <div class="col-sm-5">
                            <button type="button" class="btn btn-info " id="btnadd" name="btnadd" ><i class="glyphicon glyphicon-plus"></i>Pilih Nomor Invoice</button>
                            <button type="button" class="btn btn-info " id="btnadd_biaya" name="btnadd_biaya" ><i class="glyphicon glyphicon-plus"></i>Add Biaya</button>
                            <button type="button" class="btn btn-success " id="btnsimpan" name="btnsimpan" ><i class="glyphicon glyphicon-save"></i>Simpan</button>
                        </div>
                    </div>
                </form>
                <div class="box-body">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1"> Detail Kwitansi</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2">Detail Biaya</a></li>
                        </ul>
                        <div class="tab-content ">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <table id="table_data" class="table table-bordered table-striped gg">
                                        <thead>
                                            <tr>
                                                <th style="display:none;">id</th>
                                                <th>Nomor Invoice</th>
                                                <th>Jumlah Bayar</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <table id="table_data_biaya" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="display:none;">id</th>
                                                <th>Nomor Invoice</th>
                                                <th>Nama Biaya</th>
                                                <th>Jenis</th>
                                                <th>Jumlah</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                <th style="width:20%">Jml Tagihan</th>
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

                <!-- modal info -->
                <div id="modal_info" class="modal" >
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Riwayat Pembayaran Invoice</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <table class="table table-bordered table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding-top: 0.4cm">No Invoice</td>
                                                        <td>
                                                            <input type="text" class="form-control" name="ed_nomor_invoice"  readonly="readonly">
                                                            <input type="hidden" name="ed_id" readonly="readonly" >
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jumlah Tagihan</td>
                                                        <td>
                                                            <input type="text" class="form-control" name="ed_jumlah_tagihan"  style="text-align:right" readonly="readonly" tabindex="-1">
                                                        </td>
                                                    </tr>
                                                    <tr>    
                                                        <td style="padding-top: 0.4cm">Terbayar</td>
                                                        <td>
                                                            <input type="text" readonly="readonly" class="form-control" name="ed_terbayar" style="text-align:right" tabindex="-1">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 0.4cm">Nota Debet</td>
                                                        <td>
                                                            <input type="text" readonly="readonly" class="form-control" name="ed_nota_debet"  style="text-align:right" value="0" tabindex="-1">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 0.4cm">Nota Kredit</td>
                                                        <td>
                                                            <input type="text" readonly="readonly" class="form-control" name="ed_nota_kredit" style="text-align:right" value="0" tabindex="-1">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sisa Terbayar</td>
                                                        <td>
                                                            <input type="text" class="form-control" name="ed_sisa_terbayar" id="ed_sisa_terbayar" readonly="readonly" style="text-align:right" tabindex="-1">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 0.4cm">Biaya Debet</td>
                                                        <td>
                                                            <input type="text" readonly="readonly" class="form-control" name="ed_biaya_debet"  style="text-align:right" tabindex="-1">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 0.4cm">Biaya Kredit</td>
                                                        <td>
                                                            <input type="text" readonly="readonly" class="form-control" name="ed_biaya_kredit"  style="text-align:right" tabindex="-1">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Net Jml Bayar</td>
                                                        <td>
                                                            <input type="text" readonly="readonly" class="form-control" name="ed_netto_jml_bayar" style="text-align:right" tabindex="-1">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 0.4cm">Sisa Tagihan</td>
                                                        <td colspan="4">
                                                            <input type="text" class="form-control" readonly="readonly" id="ed_sisa_tagihan" name="ed_sisa_tagihan" tabindex="-1" style="text-align:right" >
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-7">
                                            <table id="table_data_riwayat_invoice" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nomor Penerimaan</th>
                                                        <th>Tanggal</th>
                                                        <th style="width:20%">Jml Bayar</th>
                                                        <th style="width:20%">Sisa</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <table class="table table-bordered table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td>Jml Bayar</td>
                                                        <td>
                                                            <input type="text" class="form-control angka" name="ed_jml_bayar" style="text-align:right">
                                                            <input type="hidden" name="ed_jml_bayar_old" >
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 0.4cm">Keterangan</td>
                                                        <td colspan="6">
                                                            <textarea rows="2" cols="50" name="ed_keterangan_d" class="form-control" style="text-transform: uppercase" > </textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="btnsave2">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  <!-- modal -->

                <!-- modal biaya -->
                <div id="modal_biaya" class="modal" >
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Edit Insert Biaya</h4>
                            </div>
                            <div class="modal-body">
                                <form id="form_biaya" class="form-horizontal">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td style="padding-top: 0.4cm">No Invoice</td>
                                                <td>
                                                    <select class="form-control modalinvoice" name="cb_invoice" id="cb_invoice" >
                                                    </select>
                                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                                    <input type="hidden" class="form-control" name="ed_id_biaya" >
                                                    <input type="hidden" class="form-control" name="crud_biaya" value="N">
                                                    <input type="hidden" class="form-control" name="ed_nomor_penerimaan_penjualan" >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Biaya</td>
                                                <td>
                                                    <select class="form-control biayamodal" name="cb_akun_biaya" >
                                                    <option></option>
                                                    @foreach ($akun_biaya as $row)
                                                        <option value="{{ $row->kode }}" data-jenis="{{ $row->jenis }}" data-kodeacc="{{ $row->acc_biaya }}" data-kodecsf="{{ $row->csf_biaya }}" >{{ $row->nama }}</option>
                                                    @endforeach
                                                    </select>
                                                </td>
                                                <td style="padding-top: 0.4cm">Jenis</td>
                                                <td>
                                                    <input type="text" name="ed_jenis_biaya" class="form-control" style="text-transform: uppercase" readonly="readonly" tabindex="-1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Kode ACC</td>
                                                <td>
                                                    <input type="text" name="ed_kode_acc" class="form-control" style="text-transform: uppercase" readonly="readonly" tabindex="-1">
                                                </td>
                                                <td colspan="2">
                                                    <input type="text" name="ed_acc" class="form-control" style="text-transform: uppercase" readonly="readonly" tabindex="-1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Kode CSF</td>
                                                <td>
                                                    <input type="text" name="ed_kode_csf" class="form-control" style="text-transform: uppercase" readonly="readonly" tabindex="-1">
                                                </td>
                                                <td colspan="2">
                                                    <input type="text" name="ed_csf" class="form-control" style="text-transform: uppercase" readonly="readonly" tabindex="-1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Jumlah</td>
                                                <td>
                                                    <input type="text" class="form-control angka jumlahmodal" name="ed_jml_biaya" style="text-align:right" >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Keterangan</td>
                                                <td colspan="6">
                                                    <input type="text" name="ed_keterangan_biaya" class="form-control keteranganmodal" style="text-transform: uppercase" >
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="btnsave3">Save changes</button>
                                </div>
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

    function hitung(){
        var jumlah_tagihan = $("input[name='ed_jumlah_tagihan']").val();
        var terbayar = $("input[name='ed_terbayar']").val();
        var nota_debet = $("input[name='ed_nota_debet']").val();
        var nota_kredit = $("input[name='ed_nota_kredit']").val();
        var biaya_debet = $("input[name='ed_biaya_debet']").val();
        var biaya_kredit = $("input[name='ed_biaya_kredit']").val();
        var sisa_terbayar = $("input[name='ed_sisa_terbayar']").val();
        var jumlah_bayar = $("input[name='ed_jml_bayar']").val();        
        var jumlah_tagihan = jumlah_tagihan.replace(/[A-Za-z$. ,-]/g, "");
        var terbayar = terbayar.replace(/[A-Za-z$. ,-]/g, "");
        var nota_debet = nota_debet.replace(/[A-Za-z$. ,-]/g, "");
        var nota_kredit = nota_kredit.replace(/[A-Za-z$. ,-]/g, "");
        var biaya_debet = biaya_debet.replace(/[A-Za-z$. ,-]/g, "");
        var biaya_kredit = biaya_kredit.replace(/[A-Za-z$. ,-]/g, "");
        var sisa_terbayar = sisa_terbayar.replace(/[A-Za-z$. ,-]/g, "");
        var jumlah_bayar = jumlah_bayar.replace(/[A-Za-z$. ,-]/g, "");
        var sisa_terbayar = parseFloat(jumlah_tagihan) - parseFloat(terbayar) - parseFloat(nota_debet) + parseFloat(nota_kredit);
        var net_jml_bayar = parseFloat(jumlah_bayar) - parseFloat(biaya_debet) + parseFloat(biaya_kredit);
        var total = parseFloat(sisa_terbayar) - parseFloat(net_jml_bayar) - parseFloat(biaya_debet) + parseFloat(biaya_kredit);
        $("input[name='ed_sisa_tagihan']").val(total.format());
        $("input[name='ed_sisa_terbayar']").val(sisa_terbayar.format());    
        $("input[name='ed_netto_jml_bayar']").val(net_jml_bayar.format());
    }
    
    $(document).ready( function () {
        $("input[name='ed_tanggal']").focus();
        $("select[name='type_kiriman']").val('{{ $data->type_kiriman or ''  }}');
        $("select[name='cb_cabang']").val('{{ $data->kode_cabang or ''  }}').trigger('chosen:updated');
        $("select[name='cb_customer']").val('{{ $data->kode_customer or ''  }}').trigger('chosen:updated');
        $jml_detail = {{ $jml_detail->jumlah  or 0}};
        if ($jml_detail > 0){
            $("input[name='ed_nomor']").attr('readonly','readonly');
            $("input[name='ed_nomor']").attr('readonly','readonly');
            $("select[name='cb_cabang']").prop('disabled', true).trigger("chosen:updated");
            $("select[name='cb_customer']").prop('disabled', true).trigger("chosen:updated");
            $("select[name='cb_jenis_pembayaran']").attr('disabled','disabled');
            $("input[name='ed_tanggal']").focus();
        }else{
            //$("input[name='ed_nomor']").focus();
        }
        var value ={
                    kode_customer: function () { return $("input[name='ed_customer']").val()},
                    kode_cabang: function () { return $("input[name='ed_cabang']").val()},
        };
        $('#table_data_invoice').DataTable({
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
            "url": baseUrl + "/sales/penerimaan_penjualan_form/tampil_invoice",
                "type": "GET",
                "data" : value,
            },
            "columns": [
            //{ "data": "btn_info" },    
            { "data": "nomor"},
            { "data": "tanggal" },
            { "data": "total_tagihan" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            //{ "data": "jml_bayar" },
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
            { "data": "keterangan" },
            { "data": "button" },
            ]
        });


        $('#table_data_biaya').DataTable({
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
                "url": baseUrl + "/sales/penerimaan_penjualan_form/tabel_data_detail_biaya",
                "type": "GET",
                "data" : { nomor : function () { return $('#ed_nomor').val()}},
            },
            "columns": [
            { "data": "id" , render: $.fn.dataTable.render.number( '.'),"sClass": "id" },
            { "data": "nomor_invoice" },
            { "data": "nama_biaya" },
            { "data": "jenis" },
            { "data": "jumlah" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "keterangan" },
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
     $("input[name='ed_jml_bayar']").keyup(function(){
        hitung();
    });
    $("select[name='cb_customer']").change(function(){
        var data = $(this).val();
        $("input[name='ed_customer']").val(data);
    });

    $("select[name='cb_cabang']").change(function(){
        var data = $(this).val();
        $("input[name='ed_cabang']").val(data);
    });

    $("select[name='cb_jenis_pembayaran']").change(function(){
        var data = $(this).val();
        $("input[name='ed_jenis_pembayaran']").val(data);
    });

    $("select[name='cb_akun_biaya']").change(function(){
        var jenis = $(this).find(':selected').data('jenis');
        var nama = $(this).find(':selected').text();
        var kode_acc = $(this).find(':selected').data('kodeacc');
        var kode_csf = $(this).find(':selected').data('kodecsf');
        $("input[name='ed_jenis_biaya']").val(jenis);
        $("input[name='ed_kode_acc']").val(kode_acc);
        $("input[name='ed_kode_csf']").val(kode_csf);
        $("input[name='ed_acc']").val(nama);
        $("input[name='ed_csf']").val(nama);
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
                var table = $('#table_data_invoice').DataTable();
                table.ajax.reload( null, false );
                $("#modal").modal("show");
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Data Ada Yang Belum Terisi!", "Silahkan diperiksa sekali lagi", "warning");
            }
        });
    });
      /* $(document).on("click","#btnadd_biaya",function(){
            
            if (){

            }else{

            }
       });*/

    $(document).on("click","#btnadd_biaya",function(){
        var gegege = $('#table_data').DataTable();

        if ( ! gegege.data().count() ) {
            alert( 'Data masih kosong' );
            return false;   
        }
       
        var nomor = $("#ed_nomor").val();
        console.log(nomor);
        $("input[name='ed_nomor_penerimaan_penjualan']").val(nomor);
        var value = {
              nomor: nomor,
            };
        $.ajax(
        {
            url : baseUrl + "/sales/penerimaan_penjualan_form/tampil_invoice_biaya",
            type: "GET",
            dataType:"JSON",
            data : value,
            success: function(data, textStatus, jqXHR)
            {
                $("#cb_invoice").html(data.html);
                $("#modal_biaya").modal("show");
                $("#cb_invoice").focus();
            }      
        });
        
    });

    $(document).on("click","#btnsimpan",function(){
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
                        window.location.href = baseUrl + '/sales/penerimaan_penjualan'
                    }
                }else if(data.crud == 'E'){
                    if(data.result != 1){
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }else{
                        window.location.href = baseUrl + '/sales/penerimaan_penjualan'
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
        $('input[type="checkbox"]:checked').each(function(i){
            nomor_invoice[i] = $(this).attr("id");
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
                    $("input[name='ed_jumlah']").val(data.ttl_jumlah);
                    $("input[name='ed_nomor']").attr('readonly','readonly');
                    //$("select[name='cb_cabang']").attr('disabled','disabled');
                    $("select[name='cb_jenis_pembayaran']").attr('disabled','disabled');
                    $("select[name='cb_customer']").prop('disabled', true).trigger("chosen:updated");
                    $("select[name='cb_cabang']").prop('disabled', true).trigger("chosen:updated");
                    $("#btn_add").focus();
                }else{
                    alert("Gagal menyimpan data!");
                }
            },
            
        });
    });

    $(document).on("click","#btnsave2",function(){
        var nomor_invoice = $("input[name='ed_nomor_invoice']").val();
        var jumlah = $("input[name='ed_jml_bayar']").val();;
        var jumlah_old = $("input[name='ed_jml_bayar_old']").val();;
        var nomor = $("input[name='ed_nomor']").val();
        var jenis_pembayaran = $("input[name='ed_jenis_pembayaran']").val();
        var keterangan = $("textarea[name='ed_keterangan_d']").val();
        var id = $("input[name='ed_id']").val();
        var value = {
            id : id,
            nomor : nomor,
            nomor_invoice: nomor_invoice,
            jumlah: jumlah,
            jumlah_old: jumlah_old,
            jenis_pembayaran: jenis_pembayaran,
            keterangan: keterangan,
            _token: "{{ csrf_token() }}"
        };
        $.ajax(
        {
            url : baseUrl + "/sales/penerimaan_penjualan/save_data_detail2",
            type: "POST",
            dataType:"JSON",
            data : value ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result == 1){
                    var table = $('#table_data').DataTable();
                    table.ajax.reload( null, false );
                    $("#modal_info").modal('hide');
                    $("input[name='ed_jumlah']").val(data.ttl_jumlah);
                    $("input[name='ed_debet']").val(data.ttl_debet);
                    $("input[name='ed_kredit']").val(data.ttl_kredit);
                    $("input[name='ed_netto']").val(data.ttl_netto);
                    //$("#btn_add").focus();
                }else{
                    alert("Gagal menyimpan data!");
                }
            },
            
        });
    });

    $(document).on("click","#btnsave3",function(){
        var a = $(".biayamodal").val();
        var b = $(".jumlahmodal").val();
        var c = $(".keteranganmodal").val();
        if (a == ''){
            alert('Biaya Harus di isi');
            $(".biayamodal").focus();
            return false;
        }
        else if (b == ''){
            alert('Jumlah Harus di isi');
            $(".jumlahmodal").focus();
            return false;
        }
         else if (c == '') {
            alert('Keterangan Harus Di isi');
            $(".keteranganmodal").focus();
            return false;
        }
         
        $.ajax(
        {
            url : baseUrl + "/sales/penerimaan_penjualan/save_data_detail_biaya",
            type: "POST",
            dataType:"JSON",
            data : $('#form_biaya').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result == 1){
                    var table = $('#table_data_biaya').DataTable();
                    table.ajax.reload( null, false );
                    $("#modal_biaya").modal('hide');
                    $("input[name='ed_jumlah']").val(data.ttl_jumlah);
                    $("input[name='ed_debet']").val(data.ttl_debet);
                    $("input[name='ed_kredit']").val(data.ttl_kredit);
                    $("input[name='ed_netto']").val(data.ttl_netto);
                }else{
                    alert("Gagal menyimpan data!");
                }
            },
            
        });
    });

    $(document).on( "click",".btndelete", function() {
        var nomor = $("input[name='ed_nomor']").val();
        var id = $(this).attr("id");
        var jenis_pembayaran = $("input[name='ed_jenis_pembayaran']").val();
        if(!confirm("Hapus Data " +name+ " ?")) return false;
        var value = {
            id: id,
            nomor: nomor,
            jenis_pembayaran: jenis_pembayaran,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "POST",
            url : baseUrl + "/sales/penerimaan_penjualan/hapus_data_detail",
            dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result ==3){
                    alert('Data sudah di pakai pada posting pembayaran, data tidak bisa di hapus');
                    return false();
                }
                if(data.result ==4){
                    alert('Nomor Invoice sudah di pakai pada biaya, data tidak bisa di hapus');
                    return false();
                }
                if(data.result ==1){
                    var table = $('#table_data').DataTable();
                    if (data.jml_detail == 0) {
                        $("select[name='cb_cabang']").removeAttr('disabled');
                        $("select[name='cb_jenis_pembayaran']").removeAttr('disabled');
                        $("select[name='cb_customer']").prop('disabled', false).trigger("chosen:updated");
                        $("select[name='cb_cabang']").prop('disabled', false).trigger("chosen:updated");
                    }
                    $("input[name='ed_jumlah']").val(data.ttl_jumlah);
                    $("input[name='ed_debet']").val(data.ttl_debet);
                    $("input[name='ed_kredit']").val(data.ttl_kredit);
                    $("input[name='ed_netto']").val(data.ttl_netto);
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
        var name = $(this).attr("name");
        var value = {
              nomor_invoice: name,
            };
        $.ajax(
        {
            url : baseUrl + "/sales/penerimaan_penjualan_form/tampil_riwayat_invoice",
            type: "GET",
            data : value,
            success: function(data)
            {
                $("#table_data_riwayat_invoice").html(data);
            }       
        });
        $("#modal_info").modal("show");
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

    $(document).on( "click",".btnedit", function() {
        var id = $(this).attr("id");
        var name = $(this).attr("name");
        var jumlah=((10000).format());
        var value = {
              nomor_invoice: name,
              id: id,
            };
        $.ajax(
        {
            url : baseUrl + "/sales/penerimaan_penjualan_form/tampil_riwayat_invoice",
            type: "GET",
            dataType:"JSON",
            data : value,
            success: function(data, textStatus, jqXHR)
            {
                $("#table_data_riwayat_invoice").html(data.html);
                $("input[name='ed_nomor_invoice']").val(data.invoice.nomor);
                $("input[name='ed_id']").val(id);
                $("input[name='ed_jumlah_tagihan']").val((parseFloat(data.invoice.total_tagihan)).format());
                $("input[name='ed_terbayar']").val((data.invoice.jml_bayar_memorial - data.penerimaan_penjualan_d.jumlah).format());
                $("input[name='ed_nota_debet']").val(parseFloat(data.ttl_nota_debet).format());
                $("input[name='ed_nota_kredit']").val(parseFloat(data.ttl_nota_kredit).format());
                $("input[name='ed_jml_bayar']").val(data.penerimaan_penjualan_d.jumlah).trigger('mask.maskMoney');
                $("input[name='ed_jml_bayar_old']").val(data.penerimaan_penjualan_d.jumlah);
                $("input[name='ed_biaya_debet']").val(parseFloat(data.total_biaya_debet).format());
                $("input[name='ed_biaya_kredit']").val(parseFloat(data.total_biaya_kredit).format());
                $("textarea[name='ed_keterangan_d']").val(data.penerimaan_penjualan_d.keterangan);
                $("#modal_info").modal("show");
                $("input[name='ed_jml_bayar']").focus();
                hitung();
            }      
        });
        
    });

    $(document).on( "click",".btnedit_biaya", function() {
        var nomor = $("#ed_nomor").val();
        $("input[name='ed_nomor_penerimaan_penjualan']").val(nomor);
        var id = $(this).attr("id");
        var name = $(this).attr("name");
        var value = {
              nomor_invoice: name,
              id: id,
            };
        $.ajax(
        {
            url : baseUrl + "/sales/penerimaan_penjualan/get_data_detail_biaya",
            type: "GET",
            dataType:"JSON",
            data : value,
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='cb_invoice']").val(data.nomor_invoice);
                $("input[name='ed_id_biaya']").val(id);
                $("input[name='cb_akun_biaya']").val(data.kode_biaya);
                $("input[name='ed_jenis_biaya']").val(data.jenis);
                $("input[name='ed_kode_acc']").val(data.kode_akun_acc);
                $("input[name='ed_kode_csf']").val(data.kode_akun_csf);
                $("input[name='ed_jml_biaya']").val(data.jumlah).trigger('mask.maskMoney');
                $("input[name='ed_keterangan_biaya']").val(data.keterangan);
                $("#modal_biaya").modal("show");
                $("input[name='cb_invoice']").focus();

            }      
        });
        
    });

    

    $(document).on( "click",".btndelete_biaya", function() {
        var nomor = $("input[name='ed_nomor']").val();
        var id = $(this).attr("id");
        if(!confirm("Hapus Data " +name+ " ?")) return false;
        var value = {
            id: id,
            nomor: nomor,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "POST",
            url : baseUrl + "/sales/penerimaan_penjualan/hapus_data_detail_biaya",
            dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result ==1){
                    var table = $('#table_data_biaya').DataTable();
                    if (data.jml_detail == 0) {
                        $("select[name='cb_cabang']").removeAttr('disabled');
                        $("select[name='cb_jenis_pembayaran']").removeAttr('disabled');
                        $("select[name='cb_customer']").prop('disabled', false).trigger("chosen:updated");
                    }
                    $("input[name='ed_jumlah']").val(data.ttl_jumlah);
                    $("input[name='ed_debet']").val(data.ttl_debet);
                    $("input[name='ed_kredit']").val(data.ttl_kredit);
                    $("input[name='ed_netto']").val(data.ttl_netto);
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
