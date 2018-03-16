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
                                    <input type="text" name="ed_nomor" id="ed_nomor" class="form-control" readonly="readonly" style="text-transform: uppercase" value="" >
                                    <input type="hidden" name="ed_nomor_old" class="form-control" style="text-transform: uppercase" value="" >
                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                    <input type="hidden" class="form-control" name="crud_h" class="form-control" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td >
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="ed_tanggal form-control col-xs-12" name="ed_tanggal" value="{{$tgl}}">
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
                                    <input type="hidden" name="ed_jenis_pembayaran" value="" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Akun</td>
                                <td colspan="3">
                                    <select class="form-control chosen-select-width" name="cb_akun_h" >
                                        <option value="1000001">Pilih - Akun</option>
                                        @foreach($akun as $val)
                                        <option value="{{$val->id_akun}}">{{$val->id_akun}} - {{$val->nama_akun}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Customer</td>
                                <td >
                                    <select class="chosen-select-width"  name="cb_customer" id="cb_customer" style="width:100%" >
                                        <option></option>
                                    @foreach ($customer as $row)
                                        <option value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" name="ed_customer" value="{{ $data->kode_customer or null }}" >
                                </td>
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td >
                                    <select class="chosen-select-width cb_cabang" name="cb_cabang" onchange="nota_kwitansi()" >
                                        <option></option>
                                    @foreach ($cabang as $row)
                                        <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" name="ed_cabang" value="" >
                                </td>
                            </tr>
                            <tr>    
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td colspan="3">
                                    <input type="text" name="ed_keterangan" class="form-control" style="text-transform: uppercase" value="" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Ttl Jml Bayar</td>
                                <td colspan="3">
                                    <input type="text" name="ed_jumlah" class="form-control" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1">
                                </td>
                              
                            </tr>
                            <tr>
                                  <td style="width:120px; padding-top: 0.4cm">Ttl Debet</td>
                                <td colspan="3">
                                    <input type="text" name="ed_debet" class="form-control" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1" >
                                </td>
                            </tr>
                            <tr>
                                 <td style="width:120px; padding-top: 0.4cm">Ttl Kredit</td>
                                <td colspan="3">
                                    <input type="text" name="ed_kredit" class="form-control" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Netto</td>
                                <td colspan="3">
                                    <input type="text" name="ed_netto" class="form-control" style="text-transform: uppercase ; text-align: right" readonly="readonly" tabindex="-1" >
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

// datepicker
$('.ed_tanggal').datepicker({
    format:'dd/mm/yyyy',
    endDate:'today'
})
//mengganti nota kwitansi
function nota_kwitansi() {
    var cb_cabang = $('.cb_cabang').val();

    $.ajax({
        url:baseUrl + '/sales/nota_kwitansi',
        data:{cb_cabang},
        dataType:'json',
        success:function(response){
            $('#ed_nomor').val(response.nota);
        }
    })
}


</script>

@endsection
