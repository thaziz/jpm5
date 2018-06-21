@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
.id {display:none; }
.cssright { text-align: right; }

.disabled {
    pointer-events: none;
    opacity: 1;
}
.center{
    text-align: center;
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
                     <a href="../sales/invoice" class="pull-right" style="color: grey; float: right;"><i class="fa fa-arrow-left"> Kembali</i></a>
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
                    <table class="table table_header table-striped table-bordered table-hover">

                        <tbody>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Nomor</td>
                                <td colspan="3">
                                    <input type="text" name="nota_invoice" id="nota_invoice" class="form-control" style="text-transform: uppercase" value="" >
                                    <input type="hidden" id="old_invoice" class="form-control" style="text-transform: uppercase" value="" >
                                    <input type="hidden" name="_token" id="token" value="{{csrf_token()}}" readonly="readonly">
                                </td>
                            </tr>
                            @if(Auth::user()->punyaAkses('Invoice','cabang'))
                            <tr class="">
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td colspan="4">
                                        <select onchange="ganti_nota()" class="form-control chosen-select-width cabang "  name="cb_cabang">
                                        @foreach ($cabang as $row)
                                            @if(Auth::user()->kode_cabang == $row->kode)
                                            <option selected="" value="{{ $row->kode }}">{{ $row->kode }} -  {{ $row->nama }} </option>
                                            @else
                                            <option value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                            @endif
                                        @endforeach
                                        </select>
                                </td>
                            </tr>
                            @else
                            <tr class="disabled">
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td colspan="4">
                                        <select class="form-control chosen-select-width cabang "  name="cb_cabang">
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
                            @endif
                            <tr>

                                {{-- {{dd($customer)}} --}}
                                <td style="padding-top: 0.4cm" >Customer</td>
                                <td colspan="4" class="">                                    
                                    <select onchange="ganti_jt()" class="chosen-select-width cus_disabled form-control"   name="customer" id="customer" style="width:100%" >
                                        <option value="0">Pilih - Customer</option>
                                    @foreach ($customer as $i=> $val)
                                            <option value="{{$val->kode}}"  > {{$val->kode}} - {{$val->nama}}</option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" class="ed_customer" name="ed_customer" value="" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td >
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input onchange="ganti_jt()" type="text" class="form-control tgl" name="tgl" value="{{$tgl}}">
                                    </div>
                                </td>
                                <td style="padding-top: 0.4cm">Jatuh Tempo</td>
                                <td class="disabled">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" readonly="" class="ed_jatuh_tempo form-control" name="ed_jatuh_tempo" value="">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Pendapatan</td>
                                <td colspan="3">
                                    <select class="form-control"  name="cb_pendapatan" id="cb_pendapatan" >
                                        <option value="0">Pilih - Pendapatan</option>
                                        <option value="PAKET">PAKET</option>
                                        <option value="KARGO">KARGO</option>
                                        <option value="KORAN">KORAN</option>
                                    </select>
                                    <input type="hidden" class="ed_pendapatan" name="ed_pendapatan" value="" >
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
                            <tr class="grup_item_tr" hidden="">
                                <td style="padding-top: 0.4cm" >Grup Item</td>
                                <td colspan="4" class="">                                    
                                    <select class="chosen-select-width form-control grup_item"   name="grup_item" id="grup_item" style="width:100%" >
                                        <option value="0">Pilih - Grup</option>
                                    @foreach ($gp as $i=> $val)
                                        <option value="{{$gp[$i]->kode}}" data-accpiutang="{{$gp[$i]->acc_piutang}}" data-csfpiutang="{{$gp[$i]->csf_piutang}}"> {{$gp[$i]->kode}} - {{$gp[$i]->nama}}</option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" class="ed_customer" name="ed_customer" value="" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td colspan="4">
                                    <input type="text" name="ed_keterangan" placeholder="harap diisi" class="form-control ed_keterangan" style="text-transform: uppercase" value="" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tgl DO Mulai</td>
                                <td >
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="do_awal form-control" name="do_awal" value="{{$tgl1}}">
                                    </div>
                                </td>
                                <td style="padding-top: 0.4cm">Tgl DO Sampai</td>
                                <td>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="do_akhir form-control" name="do_akhir" value="{{$tgl}}">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info " id="btn_modal_do"   ><i class="glyphicon glyphicon-plus"></i>Pilih Nomor DO</button>
                            <button type="button" class="btn btn-success simpan" onclick="simpan()" ><i class="glyphicon glyphicon-save"></i>Simpan</button>
                            <button type="button" class="btn btn-warning disabled print" onclick="ngeprint()" ><i class="glyphicon glyphicon-print"></i> Print</button>
                            <button type="button" class="btn btn-danger kanan pull-right reload" id="reload" name="btnsimpan" ><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                        </div>
                    </div>
                </form>
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped table_data">
                    <thead>
                        <tr>
                            <th align="center">No</th>
                            <th>Nomor DO</th>
                            <th>Tgl DO</th>
                            <th>Keterangan</th>
                            <th width="20">Jumlah</th>
                            <th>Harga Bruto</th>
                            <th>Biaya Tambahan</th>
                            <th>Diskon</th>
                            <th>Harga Netto</th>
                            <th align="center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
                <!-- /.box-body -->
                <form class="form-horizontal" id="form_bottom" >
                    <table class="table table-hover table_pajak">
                        <tbody>
                            <tr>
                                <td style="width:64%; padding-top: 0.4cm; text-align:right">Harga Bruto (+ biaya tambahan)</td>
                                <td colspan="4">
                                    <input type="text" name="ed_total" class="form-control ed_total" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right">
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm; text-align:right">Diskon DO</td>
                                <td colspan="4">
                                    <input type="text" readonly="" name="diskon1"  class="form-control diskon1" style="text-transform: uppercase;text-align:right" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm; text-align:right">Netto Detail</td>
                                <td colspan="4">
                                    <input type="text" name="netto_detail" readonly=""  class="form-control netto_detail" style="text-transform: uppercase;text-align:right" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm; text-align:right">Diskon Invoice</td>
                                <td colspan="4">
                                    <input type="number" name="diskon2" onkeyup="hitung()" value="0"  class="form-control diskon2" style="text-transform: uppercase;text-align:right" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm; text-align:right">Netto DPP</td>
                                <td colspan="4">
                                    <input type="text" name="netto_total" id="netto_total" class="form-control netto_total" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm; text-align:right">Jenis PPN</td>
                                <td>
                                    <select class="form-control" name="cb_jenis_ppn" onchange="hitung_pajak_ppn()" id="cb_jenis_ppn" >
                                        <option value="4" ppnrte="0" ppntpe="npkp" >NON PPN</option>
                                        <option value="1" ppnrte="10" ppntpe="pkp" >EXCLUDE 10 %</option>
                                        <option value="2" ppnrte="1" ppntpe="pkp" >EXCLUDE 1 %</option>
                                        <option value="3" ppnrte="1" ppntpe="npkp" >INCLUDE 1 %</option>
                                        <option value="5" ppnrte="10" ppntpe="npkp" >INCLUDE 10 %</option>
                                    </select>
                                </td>
                                <td style="padding-top: 0.4cm; text-align:right">PPN</td>
                                <td>
                                    <input type="text" name="ppn" class="form-control ppn" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm; text-align:right">Pajak lain-lain</td>
                                <td>
                                    <select onchange="hitung_pajak_lain()" class="pajak_lain form-control" name="kode_pajak_lain" id="pajak_lain" >
                                        <option value="0"  >Pilih Pajak Lain-lain</option>
                                        @foreach($pajak as $val)
                                            <option value="{{$val->kode}}" data-pph="{{$val->nilai}}">{{$val->nama}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding-top: 0.4cm; text-align:right">PPH</td>
                                <td>
                                    <input type="text" name="pph" class="pph form-control" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" >
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm; text-align:right">Total Tagihan</td>
                                <td colspan="4">
                                    <input type="text" name="total_tagihan" class="form-control total_tagihan" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <!-- modal -->
                <div id="modal_do" class="modal" >
                  <div class="modal-dialog" style="min-width: 1000px;max-width: 1000px">
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
                            <button type="submit" class="btn btn-primary" id="btnsave">Append</button>
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
    // global variabel
    var array_simpan = [];

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
    //data tabel detail
    var table_detail = $('#table_data').DataTable({
     searching:false,
     columnDefs: [
          {
             targets: 0 ,
             className: 'center'
          },
          {
             targets: 9,
             className: 'center'
          },
          {
             targets: 5,
             className: 'center'
          },
          {
             targets: 6,
             className: 'center'
          },
          {
             targets: 7,
             className: 'center'
          },
          {
             targets: 8,
             className: 'center'
          }
       ]

    });

    //date picker
    $('.tgl').datepicker({
        format:'dd/mm/yyyy',
        endDate:'today'
    });
    $('.ed_jatuh_tempo').datepicker({
        format:'dd/mm/yyyy',
    });
    $('.date').datepicker({
        format:'dd/mm/yyyy',
    });
       function ganti_jt() {
        var cus = $('#customer').val();
        var tgl = $('.tgl').val();
        $.ajax({
            url:baseUrl+'/sales/jatuh_tempo_customer',
            data:{cus,tgl},
            dataType : 'json',
            success:function(response){
                $('.ed_jatuh_tempo').val(response.tgl);
            }
        });
   }
    //ajax cari nota
    $(document).ready(function(){
        var cabang = $('.cabang').val();
        $.ajax({
            url:baseUrl+'/sales/nota_invoice',
            data:{cabang},
            dataType : 'json',
            success:function(response){
                $('#nota_invoice').val(response.nota);
                $('#old_invoice').val(response.nota);
            }
        });

        $.ajax({
        url:baseUrl +'/sales/drop_cus',
        data:{cabang},
        success:function(data){
            $('.customer_td').html(data);
            $('#customer').trigger('chosen:updated');
            // toastr.info('Data Telah Dirubah Harap Periksa Kembali');
        },
        error:function(){
            location.reload();
        }
        });
        ganti_jt();
    });
    // ganti nota untuk admin
    function ganti_nota(argument) {
      var cabang = $('.cabang').val();
        $.ajax({
            url:baseUrl+'/sales/nota_invoice',
            data:{cabang},
            dataType : 'json',
            success:function(response){
                if ($('#nota_invoice').val() == $('#old_invoice').val() ) {
                    $('#nota_invoice').val(response.nota);
                }
            }
        });

        $.ajax({
        url:baseUrl +'/sales/drop_cus',
        data:{cabang},
        success:function(data){
            $('.customer_td').html(data);
            $('#customer').trigger('chosen:updated');
            // toastr.info('Data Telah Dirubah Harap Periksa Kembali');

        },
        error:function(){
            location.reload();
        }
        });
    }
    //ajax jatuh  tempo
   function ganti(){
        var customer = $('#customer').val();
        var tgl = $('.tgl').val();
        $.ajax({
            url:baseUrl+'/sales/jatuh_tempo_customer',
            data:{customer,tgl},
            dataType : 'json',
            success:function(response){
                $('.ed_jatuh_tempo').val(response.tgl);

            }
        });
    }


        

   $('#cb_pendapatan').change(function(){
    if ($(this).val() == 'KORAN') {
        $('.grup_item_tr').prop('hidden',false);
    }else{
        $('.grup_item_tr').prop('hidden',true);
        $('.grup_item').val('0');
    }
        $('.ed_pendapatan').val($(this).val());

   })
   //modal do
   $('#btn_modal_do').click(function(){
        var array_validasi = [];
        var customer      = $('#customer').val();
        var cb_pendapatan = $('#cb_pendapatan').val();
        var ed_keterangan = $('#ed_keterangan').val();
        var do_awal       = $('.do_awal').val();
        var do_akhir      = $('.do_akhir').val();
        var cabang        = $('.cabang').val();
        var grup_item     = $('.grup_item').val();

        if (customer == 0) {
            array_validasi.push(0)
        }
        if (cb_pendapatan == 0) {
            array_validasi.push(0)
        }
        if (ed_keterangan == '') {
            array_validasi.push(0)
        }
        var index = array_validasi.indexOf(0);

        if (index == -1) {
            $.ajax({
              url:baseUrl + '/sales/cari_do_invoice',
              data:{customer,cb_pendapatan,do_awal,do_akhir,array_simpan,cabang,grup_item},
              success:function(data){
                $('#modal_do').modal('show');
                $('.kirim').html(data);
              }
            });
        }else{
            toastr.warning('Harap Lengkapi Data Diatas');
        }

   })

   // Menghitung pajak


function hitung_total_tagihan(){
        var cb_jenis_ppn = $('#cb_jenis_ppn').val();
        var diskon2      = $('.diskon2').val();
        var netto_total  = $('.netto_total').val();
        var netto_detail = $('.netto_detail').val();
        netto_total      = netto_total.replace(/[^0-9\-]+/g,"");
        netto_total      = parseFloat(netto_total)/100;
        netto_detail     = netto_detail.replace(/[^0-9\-]+/g,"");
        netto_detail     = parseFloat(netto_detail)/100;
        diskon2          = diskon2.replace(/[^0-9.\-]+/g,"");
        diskon2          = parseFloat(diskon2);

        var ppn  = $('.ppn').val();
        ppn      = ppn.replace(/[^0-9\-]+/g,"");
        ppn      = parseFloat(ppn)/100;

        var pph  = $('.pph').val();
        pph      = pph.replace(/[^0-9\-]+/g,"");

        pph      = parseFloat(pph)/100;
        if (cb_jenis_ppn == 1 || cb_jenis_ppn == 2 || cb_jenis_ppn == 0) {
            var total_tagihan = netto_total+ppn-pph;
        }else if (cb_jenis_ppn == 3 || cb_jenis_ppn == 5) {
            var total_tagihan = netto_detail-diskon2-pph;
        }else if (cb_jenis_ppn == 4) {
            var total_tagihan = netto_total-pph;
        }

        $('.total_tagihan').val(accounting.formatMoney(total_tagihan,"",2,'.',','))

   
    }


   function hitung_pajak_ppn() {
       var cb_jenis_ppn = $('#cb_jenis_ppn').val();
       var netto_total  = $('.netto_total').val();
       var netto_detail = $('.netto_detail').val();
       var diskon2      = $('.diskon2').val();
       netto_total      = netto_total.replace(/[^0-9\-]+/g,"");
       netto_total      = parseInt(netto_total)/100;

       netto_detail     = netto_detail.replace(/[^0-9\-]+/g,"");
       netto_detail     = parseInt(netto_detail)/100;

       if (diskon2 == '') {
            diskon2 = 0;
        }
       // diskon2          = diskon2.replace(/[^0-9\-]+/g,"");
       diskon2          = parseFloat(diskon2);
       diskon2          = parseFloat(diskon2);
       hasil_netto      = parseFloat(netto_detail) - parseFloat(diskon2);
       if (hasil_netto < 0) {
        hasil_netto = 0;
       }
        if (cb_jenis_ppn == 1) {

            var ppn = 0;
            ppn = hasil_netto * 1.1 ;
            ppn_netto = ppn - hasil_netto;
            $('.ppn').val(accounting.formatMoney(ppn_netto,"",2,'.',','))
            $('.netto_total').val(accounting.formatMoney(hasil_netto,"",2,'.',','))

        }else if (cb_jenis_ppn == 2){

            var ppn = 0;
            ppn = hasil_netto * 1.01 ;
            ppn_netto = ppn - hasil_netto;
            $('.ppn').val(accounting.formatMoney(ppn_netto,"",2,'.',','))
            $('.netto_total').val(accounting.formatMoney(hasil_netto,"",2,'.',','))

        }else if (cb_jenis_ppn == 3){

            var ppn = 0;
            ppn = 100/101 * hasil_netto ;
            ppn_netto = hasil_netto - ppn;
            $('.ppn').val(accounting.formatMoney(ppn_netto,"",2,'.',','));
            $('.netto_total').val(accounting.formatMoney(ppn,"",2,'.',','));

        }else if (cb_jenis_ppn == 5){

            var ppn = 0;
            ppn = 100/110 * hasil_netto ;
            ppn_netto = hasil_netto - ppn ;
            $('.ppn').val(accounting.formatMoney(ppn_netto,"",2,'.',','));
            $('.netto_total').val(accounting.formatMoney(ppn,"",2,'.',','));

        }else if (cb_jenis_ppn == 4){
            var ppn = 0;
            ppn = netto_total * 1 ;
            ppn_netto = ppn - netto_total;
            $('.ppn').val(accounting.formatMoney(ppn_netto,"",2,'.',','));
            $('.netto_total').val(accounting.formatMoney(hasil_netto,"",2,'.',','));

        }

       hitung_pajak_lain();
       hitung_total_tagihan();

   }

   function hitung_pajak_lain(){

       var netto_total  = $('.netto_total').val();
       var pajak_lain   = $('.pajak_lain').val();
       netto_total      = netto_total.replace(/[^0-9\-]+/g,"");
       netto_total      = parseInt(netto_total)/100;
       var pajak_persen = 0;
       var pajak_total  = 0;
       if (pajak_lain == 0) {

        $('.pph').val(accounting.formatMoney(pajak_total,"",2,'.',','));
        hitung_total_tagihan();
        return 1;
       }
       $('.simpan_btn').addClass('disabled');
       $.ajax({
             url:baseUrl +'/sales/pajak_lain',
             dataType:'json',
             data:{pajak_lain},
             success:function(response){
                pajak_persen = response.persen.nilai;
                var persen_fix = parseInt(pajak_persen)+100;
                persen_fix     = persen_fix/100;
                pajak_total  = persen_fix * netto_total;
                pajak_total  = pajak_total - netto_total;
                $('.pph').val(accounting.formatMoney(pajak_total,"",2,'.',','));
                // hitung_pajak_ppn();
                hitung_total_tagihan();
                $('.simpan_btn').removeClass('disabled');


             }
       })
   }



   // fungsi menghitung total dan diskon DO

    $(".diskon2").focus(function() {
     $(this).select();
    });
   function hitung(){
        var temp_total   = 0 ;
        var temp_bp      = 0 ;
        var temp_diskon  = 0 ;
        var temp_diskon  = 0 ;
        var temp_diskon2 = $('.diskon2').val();

        if (temp_diskon2 == '') {
            temp_diskon2 = 0;
        }
        temp_diskon2     = parseFloat(temp_diskon2)



        var netto = 0 ;
        table_detail.$('.dd_total').each(function(){
            temp_total += parseFloat($(this).val());
        });

        table_detail.$('.dd_biaya_tambahan').each(function(){
            temp_bp += parseFloat($(this).val());
        });

        table_detail.$('.dd_diskon').each(function(){
            temp_diskon += parseFloat($(this).val());
        });

    
        netto = temp_total-(temp_diskon2+temp_diskon);
        netto_diskon1 = temp_total + temp_bp - temp_diskon;
        if (netto_diskon1 < 0) {
            netto_diskon1 =0;
        }
        $('.ed_total').val(accounting.formatMoney(temp_total+temp_bp,"",2,'.',','));
        $('.diskon1').val(accounting.formatMoney(temp_diskon,"",2,'.',','));
        $('.netto_total').val(accounting.formatMoney(netto_diskon1,"",2,'.',','));
        $('.netto_detail').val(accounting.formatMoney(netto_diskon1,"",2,'.',','));
        // $('.diskon2').val(accounting.formatMoney(temp_diskon2,"",2,'.',','));

        hitung_pajak_ppn();
        hitung_pajak_lain();
   }

   
   // untuk mengirim yang di check ke controller dengan ajax
   var index_detail = 0;
   $('#btnsave').click(function(){

        var token = '{{ csrf_field() }}';
        var nomor_dt = [];
        var nomor_do = [];
        var cb_pendapatan = $('#cb_pendapatan').val();
        
        table_data_do.$('.tanda').each(function(){
            var check = $(this).is(':checked');
            if (check == true) {
               var par   = $(this).parents('tr');
               var no_dt = $(par).find('.nomor_dt').val();
               var no_do = $(par).find('.nomor_do').val();

               if (cb_pendapatan == 'KORAN') {
                  array_simpan.push(no_dt);
               }else{
                  array_simpan.push(no_do);
               }
               nomor_dt.push(no_dt);
               nomor_do.push(no_do);
            }
        });

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:baseUrl +'/sales/append_do',
            data:{token,nomor_dt,nomor_do,cb_pendapatan},
            type:'post',
            dataType:'json',
            success:function(response){
                if (response.jenis == 'KORAN') {
                    // //////////////////////////////////
                    for(var i = 0 ; i < response.data.length;i++){
                        index_detail+=1;
                        table_detail.row.add([
                            index_detail+'<p class="indexing"></p>',
                            response.data[i].dd_nomor+'<input type="hidden" value="'+response.data[i].dd_nomor+'" name="do_detail[]">',

                            response.data[i].tanggal+'<input type="hidden" class="dd_id" value="'+response.data[i].dd_id+'" name="do_id[]">',

                            response.data[i].dd_keterangan+'<input type="hidden" class="acc_penjualan" value="'+response.data[i].dd_acc_penjualan+'" name="akun[]">',

                            response.data[i].dd_jumlah+'<input type="hidden" value="'+response.data[i].dd_jumlah+'" name="dd_jumlah[]">',

                            accounting.formatMoney(response.data[i].dd_harga * response.data[i].dd_jumlah, "", 2, ".",',')+'<input class="dd_total" type="hidden" value="'+response.data[i].dd_harga * response.data[i].dd_jumlah+'" name="dd_total[]">',

                            accounting.formatMoney(0, "", 2, ".",',')+'<input class="dd_biaya_tambahan" type="hidden" value="0" name="dd_biaya_tambahan[]">',

                            accounting.formatMoney(response.data[i].dd_diskon, "", 2, ".",',')+'<input class="dd_diskon" type="hidden" value="'+response.data[i].dd_diskon+'" name="dd_diskon[]">',

                            accounting.formatMoney(response.data[i].dd_total, "", 2, ".",',')+'<input type="hidden" class="harga_netto" value="'+response.data[i].dd_total+'" name="harga_netto[]">',

                            '<button type="button" onclick="hapus_detail(this)" class="btn btn-danger hapus btn-sm" title="hapus"><i class="fa fa-trash"><i></button>',

                        ]).draw(false);
                    }
                    hitung();
                    
                    $('.cus_disabled').attr('disabled',true).trigger("chosen:updated");
                    $('#cb_pendapatan').attr('disabled',true);
                    ///////////////////////////////////////////
                }else if (response.jenis == 'PAKET' ) {
                    for(var i = 0 ; i < response.data.length;i++){
                        ///////////////////////////////////////
                        index_detail+=1;
                        table_detail.row.add([
                            index_detail+'<p class="indexing"></p>',

                            response.data[i].nomor+'<input class="nomor_detail" type="hidden" value="'+response.data[i].nomor+'" name="do_detail[]">',

                            response.data[i].tanggal,

                            response.data[i].deskripsi+'<input type="hidden" class="acc_penjualan" value="'+response.data[i].acc_penjualan+'" name="akun[]">',

                            response.data[i].jumlah+'<input type="hidden" value="'+response.data[i].jumlah+'" name="dd_jumlah[]">',


                            accounting.formatMoney(parseFloat(response.data[i].total), "", 2, ".",',')+'<input class="dd_total" type="hidden" value="'+parseFloat(response.data[i].total)+'" name="dd_total[]">',

                            accounting.formatMoney(response.data[i].biaya_tambahan, "", 2, ".",',')+'<input class="dd_biaya_tambahan" type="hidden" value="'+parseFloat(response.data[i].biaya_tambahan)+'" name="dd_biaya_tambahan[]">',


                            accounting.formatMoney(response.data[i].diskon, "", 2, ".",',')+'<input class="dd_diskon" type="hidden" value="'+response.data[i].diskon+'" name="dd_diskon[]">',

                            accounting.formatMoney(response.data[i].harga_netto, "", 2, ".",',')+'<input type="hidden" class="harga_netto" value="'+response.data[i].harga_netto+'" name="harga_netto[]">',

                            '<button type="button" onclick="hapus_detail(this)" class="btn btn-danger hapus btn-sm" title="hapus"><i class="fa fa-trash"><i></button>',

                        ]).draw(false);
                    }

                    hitung();
                    
                    $('.customer_td').addClass('disabled');
                    $('.grup_item_tr').addClass('disabled');
                    $('#cb_pendapatan').attr('disabled',true);
                    /////////////////////////////////////
                }else if (response.jenis == 'KARGO') {
                    for(var i = 0 ; i < response.data.length;i++){
                        ///////////////////////////////////////
                        index_detail+=1;
                        table_detail.row.add([
                            index_detail+'<p class="indexing"></p>',

                            response.data[i].nomor+'<input class="nomor_detail" type="hidden" value="'+response.data[i].nomor+'" name="do_detail[]">',

                            response.data[i].tanggal,

                            response.data[i].deskripsi+'<input type="hidden" class="acc_penjualan" value="'+response.data[i].acc_penjualan+'" name="akun[]">',

                            response.data[i].jumlah+'<input type="hidden" value="'+response.data[i].jumlah+'" name="dd_jumlah[]">',


                            accounting.formatMoney(response.data[i].total, "", 2, ".",',')+'<input class="dd_total" type="hidden" value="'+response.data[i].total+'" name="dd_total[]">',

                            accounting.formatMoney(response.data[i].biaya_tambahan, "", 2, ".",',')+'<input class="dd_biaya_tambahan" type="hidden" value="'+parseFloat(response.data[i].biaya_tambahan)+'" name="dd_biaya_tambahan[]">',

                            accounting.formatMoney(response.data[i].diskon, "", 2, ".",',')+'<input class="dd_diskon" type="hidden" value="'+response.data[i].diskon+'" name="dd_diskon[]">',

                            accounting.formatMoney(response.data[i].harga_netto, "", 2, ".",',')+'<input type="hidden" class="harga_netto" value="'+response.data[i].harga_netto+'" name="harga_netto[]">',

                            '<button type="button" onclick="hapus_detail(this)" class="btn btn-danger hapus btn-sm" title="hapus"><i class="fa fa-trash"><i></button>',

                        ]).draw(false);
                    }

                    hitung();
                    
                    $('.customer_td').addClass('disabled');
                    $('.grup_item_tr').addClass('disabled');
                    $('#cb_pendapatan').attr('disabled',true);
                    /////////////////////////////////////
                }

                $('#modal_do').modal('hide');                   
            },
            error:function(){
                $('#modal_do').modal('hide');                   
            }

        })
        toastr.info('Tekan simpan untuk menyimpan semua data');
   });
   // hapus detail
   function hapus_detail(o) {
        var jenis = $('#cb_pendapatan').val();
        var par = $(o).parents('tr');
        var length = table_detail.page.info().recordsTotal;

        if (jenis == 'KORAN') {
            var arr = $(par).find('.dd_id')
            var index = array_simpan.indexOf(arr);
            array_simpan.splice(index,1);
            table_detail.row(par).remove().draw(false);

        }else if (jenis == 'PAKET' || jenis == 'KARGO'){
            var arr = $(par).find('.nomor_detail')
            var index = array_simpan.indexOf(arr);
            array_simpan.splice(index,1);
            table_detail.row(par).remove().draw(false);
        }

        var temp = 0;
        $('.indexing').each(function(){
            temp+=1;
        })

        if (temp == 0) {
            $('.customer_td').removeClass('disabled');
            $('.grup_item_tr').removeClass('disabled');
            $('#cb_pendapatan').attr('disabled',false);
        }

        hitung();
            
   }
   // untuk check all detail
    function check_parent(){
      var parent_check = $('.parent_check:checkbox:checked');

      if (parent_check.length >0) {
        table_data_do.$('.tanda:checkbox').prop('checked',true);
      }else if(parent_check.length==0) {
        table_data_do.$('.tanda:checkbox').removeAttr('checked');
      }

    }

    // SIMPAN DATA
    function simpan(){

      swal({
        title: "Apakah anda yakin?",
        text: "Simpan Data Invoice!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Simpan!",
        cancelButtonText: "Batal",
        closeOnConfirm: true
      },
      function(){
            var acc_piutang=$(".grup_item").find(':selected').data('accpiutang'); 
            var pajak_lain=$("#pajak_lain").find(':selected').data('pph'); 
            var ed_customer=$("#customer").val(); 
               // alert(accPiutang);
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

          $.ajax({
          url:baseUrl + '/sales/simpan_invoice',
          type:'post',
          dataType:'json',
          data:$('.table_header :input').serialize()
               +'&'+table_detail.$('input').serialize()
               +'&'+$('.table_pajak :input').serialize()
               +'&acc_piutang='+acc_piutang
               +'&pajak_lain='+pajak_lain
               +'&ed_customer='+ed_customer,

          success:function(response){
             if (response.status =='gagal') {
                
                    toastr.warning(response.info)
                
             }


            if (response.status == 2) {
                swal({
                    title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){
                    toastr.warning('No DO telah diganti menjadi ' + response.nota)
                });
             }

             if (response.status == 1) {
                swal({
                    title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 1000,
                   showConfirmButton: true
                    },function(){
                        // window.location='../sales/invoice';
                        $('.simpan').addClass('disabled');
                        $('.print').removeClass('disabled');

                });
             }
          },
          error:function(data){
            swal({
            title: "Terjadi Kesalahan",
                    type: 'error',
                    timer: 900,
                   showConfirmButton: true

        });
       }
      });  
     });
    }

   function ngeprint(){
       var id = $('#nota_invoice').val();
        id = id.replace(/\//g, "-");
        window.open('{{url('sales/cetak_nota')}}'+'/'+id);
    }
    $('.reload').click(function(){
    location.reload();
})

$('#cb_pendapatan').change(function(){
    if ($(this).val() == 'KARGO') {
        $('#cb_jenis_ppn').val(1);
    }
    if ($(this).val() == 'PAKET') {
        $('#cb_jenis_ppn').val(3);
    }
    if ($(this).val() == 'KORAN') {
        $('#cb_jenis_ppn').val(1);
    }
})



window.onbeforeunload = function(event)
{       
       confirm();

};

</script>
@endsection
