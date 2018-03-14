@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
.id {display:none; }
.cssright { text-align: right; }

.disabled {
    pointer-events: none;
    opacity: 0.4;
}
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
                                <td colspan="3">
                                    <input type="text" name="nota_invoice" id="nota_invoice" readonly="readonly" class="form-control" style="text-transform: uppercase" value="" >
                                    <input type="hidden" name="_token" id="token" value="{{csrf_token()}}" readonly="readonly">
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td colspan="4">
                                        <select class="form-control chosen-select-width cabang " disabled="" name="cb_cabang">
                                        @foreach ($cabang as $row)
                                            @if(Auth::user()->kode_cabang == $row->kode)
                                            <option selected="" value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                            @else
                                            <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                            @endif
                                        @endforeach
                                        </select>
                                   
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Customer</td>
                                <td colspan="4">
                                    <select class="chosen-select-width"  name="cb_customer" id="cb_customer" style="width:100%" >
                                        <option> </option>
                                    @foreach ($customer as $row)
                                        <option value="" >  </option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" name="ed_customer" value="" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td >
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tgl" name="tgl" value="{{$tgl}}">
                                    </div>
                                </td>
                                <td style="padding-top: 0.4cm">Jatuh Tempo</td>
                                <td>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_jatuh_tempo" value="">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Customer</td>
                                <td colspan="4">
                                    <select class="chosen-select-width"  name="cb_customer" id="cb_customer" style="width:100%" >
                                        <option> </option>
                                    @foreach ($customer as $row)
                                        <option value="" >  </option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" name="ed_customer" value="" >
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
                                    <input type="hidden" name="ed_pendapatan" value="" >
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
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tanggal_mulai_do" value="">
                                    </div>
                                </td>
                                <td style="padding-top: 0.4cm">Tgl DO Sampai</td>
                                <td>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tanggal_sampai_do" value="">
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
                                    <input type="text" name="ed_total" class="form-control" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right">
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm; text-align:right">Diskon</td>
                                <td colspan="4">
                                    <input type="text" name="ed_diskon" id="ed_diskon"  class="form-control angka" style="text-transform: uppercase;text-align:right" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm; text-align:right">Netto</td>
                                <td colspan="4">
                                    <input type="text" name="ed_netto" id="ed_netto" class="form-control" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" >
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
                                    <input type="text" name="ed_ppn" class="form-control" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm; text-align:right">Pajak</td>
                                <td>
                                    <select class="form-control" name="cb_pajak" id="cb_pajak" >
                                        <option value=""  > </option>
                                    </select>
                                </td>
                                <td style="padding-top: 0.4cm; text-align:right">PPH</td>
                                <td>
                                    <input type="text" name="ed_pph" class="form-control" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm; text-align:right">Total Tagihan</td>
                                <td colspan="4">
                                    <input type="text" name="ed_total_tagihan" class="form-control" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right">
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
    // chosen select
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

    //date picker
    $('.tgl').datepicker({
        format:'dd/mm/yyyy'
    });
    //ajax cari nota
    $(document).ready(function(){
        var cabang = $('.cabang').val();
        $.ajax({
            url:baseUrl+'/sales/nota_invoice',
            data:{cabang},
            succces:function(response){
                $('#nota_invoice').val(response.nota);
            }
        });
    });
    
</script>
@endsection
