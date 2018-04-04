@extends('main')

@section('title', 'dashboard')

@section('content')

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> CN / DN PENJUALAN </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Sales</a>
                        </li>
                        <li>
                          <a> Penerimaan Kwitansi</a>
                        </li>
                        <li class="active">
                            <strong> Create CN / DN Penjualan </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
<style type="text/css" media="screen">
  .disabled {
        pointer-events: none;
        opacity: 0.7;
        }
  .borderless td, .borderless th {
    border: none !important;
}
  .table-hover tbody tr{
    cursor: pointer;
  }

</style>
<div class="wrapper wrapper-content animated fadeInRight" style="font-size: 12px ">
  <div class="row">
    <div class="col-lg-12" >
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5> CN/DN PENJUALAN
            {{Session::get('comp_year')}}

          </h5>
           <a  href="../nota_debet_kredit" class="pull-right" style="color: grey; float: right;"><i class="fa fa-arrow-left"> Kembali</i></a>
          
        </div>
        <div class="ibox-content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="col-sm-12">
                  <div class="col-sm-6">
                    <h3></h3>
                    <table class="table borderless tabel_header1">
                      <tr>
                        <td>Nomor CN/DN</td> 
                        <td><input type="text" readonly="" class="form-control nomor_cn_dn" name="nomor_cn_dn"></td>
                      </tr>
                      <tr>
                        <td>
                          Jenis CN/DN
                        </td>
                        <td>
                          <select class="form-control jenis_cd" onchange="hitung()" name="jenis_debet">
                          <option value="K">KREDIT</option>
                          <option value="D">DEBET</option>
                        </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Tanggal</td>
                        <td>
                           <div class="input-group date">
                              <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </span>
                              <input type="text" class="form-control tgl" name="tgl" value="{{carbon\carbon::now()->format('Y-m-d')}}">
                          </div>
                        </td>
                      </tr>
                      @if(Auth::user()->punyaAkses('CN DN Penjualan','cabang'))
                      <tr>
                        <td>
                          Cabang
                        </td>
                        <td class="">
                          <select class="form-control cabang chosen-select-width" name="cabang">
                          @foreach($cabang as $val)
                            @if(Auth::user()->kode_cabang == $val->kode)
                              <option selected="" value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                            @else
                              <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                            @endif
                          @endforeach
                        </select>
                        </td>
                      </tr>
                      @else
                      <tr>
                        <td>
                          Cabang
                        </td>
                        <td class="disabled">
                          <select class="form-control cabang chosen-select-width" name="cabang">
                          @foreach($cabang as $val)
                            @if(Auth::user()->kode_cabang == $val->kode)
                              <option selected="" value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                            @else
                              <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                            @endif
                          @endforeach
                        </select>
                        </td>
                      </tr>
                      @endif
                      <tr>
                          <td style="padding-top: 0.4cm" >Customer</td>
                          <td colspan="5" class="">                                    
                              <select class="chosen-select-width cus_disabled form-control"   name="customer" id="customer" style="width:100%" >
                                  <option value="0">Pilih - Customer</option>
                              @foreach ($customer as $row)
                                  <option value="{{$row->kode}}" data-accpiutang="{{$row->acc_piutang}}"> {{$row->kode}} - {{$row->nama}} - {{$row->cabang}} </option>
                              @endforeach
                              </select>
                              <input type="hidden" class="ed_customer" name="ed_customer" value="" >
                          </td>
                      </tr>
                      <tr>
                        <td>Keterangan</td> 
                        <td><input type="text" class="form-control keterangan" ></td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-sm-6">
                    
                    <table class="table borderless table-hover table_pajak ">
                        <tbody>
                            <tr>
                                <td>Jumlah DPP</td>
                                <td colspan="4">
                                    <input type="text" value="0" class="form-control ed_total_text" readonly="readonly" style="text-align:right">
                                    <input type="hidden" value="0" name="ed_total" class="form-control ed_total" readonly="readonly" style="text-align:right">
                                </td>
                            </tr>
                            <tr>
                                <td>Jumlah PPN</td>
                                <td colspan="4">
                                    <input type="text" class="form-control debet_text" readonly="readonly" style="text-align:right" value="0">
                                    <input type="hidden" name="debet" class="form-control debet" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" value="0">
                                </td>
                            </tr>
                            <tr>
                                <td>Jumlah PPH23</td>
                                <td colspan="4">
                                    <input type="text" class="form-control kredit_text" readonly="readonly" style="text-align:right" value="0">
                                    <input type="hidden" name="kredit" class="form-control kredit" readonly="readonly" style="text-align:right" value="0">
                                </td>
                            </tr>
                            <tr>
                                <td>Jumlah Nota</td>
                                <td colspan="4">
                                    <input type="text" class="form-control netto_total_text" readonly="readonly" style="text-align:right" >
                                    <input type="hidden" name="netto_total" class="form-control netto_total" readonly="readonly" tabindex="-1" style="text-align:right" >
                                </td>
                            </tr>
                        </tbody>
                    </table> 
                  </div>
                  <div class="col-sm-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-rk">Invoice</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-cn">Lain</a></li>
                        </ul>
                        <div class="tab-content ">
                            <div id="tab-rk" class="tab-pane active">
                                <div class="panel-body riwayat_kwitansi">
                                  <div class="col-sm-6">
                                    <table class="table riwayat borderless">
                                        <tr>
                                          <td>Nomor Invoice</td>
                                          <td><input type="text" name="nomor_invoice" class="nomor_invoice form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>Tanggal Invoice</td>
                                          <td><input type="text" readonly="" name="tgl_invoice" class="tgl_invoice form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>Jatuh tempo</td>
                                          <td><input type="text" readonly="" name="jatuh_tempo" class="jatuh_tempo form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>DPP</td>
                                          <td><input type="text" readonly="" style="text-align: right" name="dpp" class="dpp_awal form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>PPN</td>
                                          <td><input type="text" readonly="" style="text-align: right" name="ppn" class="ppn_awal form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>PPH 23</td>
                                          <td><input type="text" readonly="" name="pph" style="text-align: right" class="pph_awal form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>Netto</td>
                                          <td><input type="text" readonly="" name="netto_awal" style="text-align: right" class="netto_awal form-control"></td>
                                        </tr>
                                    </table>
                                  </div>
                                  <div class="col-sm-6">
                                    <table class="table riwayat  borderless">
                                        <tr>
                                          <td>Terbayar</td>
                                          <td><input type="text" name="terbayar" readonly="" style="text-align: right" class="terbayar form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>Nota Debet</td>
                                          <td><input type="text" name="nota_debet" class="nota_debet form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>Sisa Terbayar</td>
                                          <td><input type="text" name="sisa_terbayar" class="sisa_terbayar form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>DPP</td>
                                          <td><input type="text" name="dpp_akhir" class="dpp_akhir form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>PPN</td>
                                          <td><input type="text" name="ppn_akhir" class="ppn_akhir form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>PPH 23</td>
                                          <td><input type="text" name="pph_akhir" class="pph_akhir form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>Jumlah N/D</td>
                                          <td><input type="text" name="netto_akhir" class="netto_akhir form-control"></td>
                                        </tr>
                                    </table>
                                  </div>
                                </div>
                            </div>
                            <div id="tab-cn" class="tab-pane">
                                <div class="panel-body riwayat_cn_dn">
                                    <table id="table_cn_dn" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor CN/DN</th>
                                                <th>Tanggal</th>
                                                <th>Jml Kredit</th>
                                                <th>Jml Kredit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-sm-12">
                      <table class="table table_detail">
                        <thead>
                          <tr>
                            <th>Seq</th>
                            <th>Nomor Invoice</th>
                            <th>DPP</th>
                            <th>PPN</th>
                            <th>PPH23</th>
                            <th>Jumlah</th>
                          </tr> 
                        </thead>
                        
                      </table>
                    </div>
                  </div>
                </div>
                <div class="box-footer">
                  {{-- MODAL --}}
                  <div id="modal_cd" class="modal" >
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Edit Insert Biaya</h4>
                            </div>
                            <div class="modal-body cn_dn_modal">
                                
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="update_biaya">Save changes</button>
                                </div>
                            </div>
                        </div>
                      </div>
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
    $(document).ready(function(){
      var cabang = $('.cabang').val();  
      $.ajax({
        url  :baseUrl+'/sales/nota_debet_kredit/nomor_cn_dn',
        data : {cabang},
        success:function(data){
          $('.nomor_cn_dn').val(data.nota);
        }
      })
    })
    $('.table_detail').DataTable();

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
    $('.nomor_invoice').focus(function(){
      var cabang = $('.cabang').val();
      $.ajax({
        url  :baseUrl+'/sales/nota_debet_kredit/cari_invoice',
        data : {cabang},
        success:function(data){
          $('.cn_dn_modal').html(data);
        }
      })
      $('#modal_cd').modal('show');
    })
    $('.jumlah_biaya').maskMoney({precision:0,thousands:'.'});


     function hitung(val) {
      var jenis_cd      = $('.jenis_cd').val();
      var jumlah_biaya  = $('.jumlah_biaya').val();
      var ed_total      = $('.ed_total').val();
      ed_total          = parseFloat(ed_total);
      jumlah_biaya      = jumlah_biaya.replace(/[^0-9\-]+/g,"");
      jumlah_biaya      =parseFloat(jumlah_biaya);
      $('.jumlah_biaya1').val(jumlah_biaya);

      if (jenis_cd == 'K') {
        $('.kredit').val(jumlah_biaya);
        $('.kredit_text').val(accounting.formatMoney(jumlah_biaya,"",2,'.',','));
        $('.debet').val(0);
        $('.debet_text').val(accounting.formatMoney(0,"",2,'.',','));
      }else{
        $('.debet').val(jumlah_biaya);
        $('.debet_text').val(accounting.formatMoney(jumlah_biaya,"",2,'.',','));
        $('.kredit').val(0);
        $('.kredit_text').val(accounting.formatMoney(0,"",2,'.',','));
      }
      var jumlah_biaya1  = $('.jumlah_biaya1').val();
      if (ed_total != 0 && jumlah_biaya1 != '') {
        var total = ed_total - jumlah_biaya1;
        if (total < 0) {
          total = 0;
        }
        $('.netto_total_text').val(accounting.formatMoney(total,"",2,'.',','));
        $('.netto_total').val(total);
      }
      
    }

    function hitung_total_tagihan(){
        var cb_jenis_ppn = $('#cb_jenis_ppn').val();
        var diskon2      = $('.diskon2').val();
        var netto_total  = $('.netto_total').val();
        var netto_detail = $('.netto_detail').val();
        netto_total      = netto_total.replace(/[^0-9\-]+/g,"");
        netto_total      = parseInt(netto_total)/100;
        netto_detail     = netto_detail.replace(/[^0-9\-]+/g,"");
        netto_detail     = parseInt(netto_detail)/100;
        diskon2          = diskon2.replace(/[^0-9\-]+/g,"");
        diskon2          = parseInt(diskon2)/100;

        var ppn  = $('.ppn').val();
        ppn      = ppn.replace(/[^0-9\-]+/g,"");
        ppn      = parseInt(ppn)/100;

        var pph  = $('.pph').val();
        pph      = pph.replace(/[^0-9\-]+/g,"");
        pph      = parseInt(pph)/100;
        if (cb_jenis_ppn == 1 || cb_jenis_ppn == 2 || cb_jenis_ppn == 0) {
            var total_tagihan = netto_total+ppn-pph;
        }else if (cb_jenis_ppn == 3 || cb_jenis_ppn == 5) {
            var total_tagihan = netto_detail-diskon2-pph;
        }else if (cb_jenis_ppn == 4) {
            var total_tagihan = netto_total-pph;
        }

        $('.total_tagihan').val(accounting.formatMoney(total_tagihan,"",2,'.',','));

    }

    function hitung_pajak_ppn() {
       var cb_jenis_ppn = $('#cb_jenis_ppn').val();
       var netto_total  = $('.netto_total').val();
       // var netto_detail = $('.netto_detail').val();
       // var diskon2      = $('.diskon2').val();
       // netto_total      = netto_total.replace(/[^0-9\-]+/g,"");
       netto_total      = parseFloat(netto_total)/100;

       // netto_detail     = netto_detail.replace(/[^0-9\-]+/g,"");
       // netto_detail     = parseInt(netto_detail)/100;
        // if (diskon2 == '') {
        //     diskon2 = 0;
        // }
       // diskon2          = diskon2.replace(/[^0-9\-]+/g,"");
       // diskon2          = parseFloat(diskon2);
      
       hasil_netto      = parseFloat(netto_total);
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
            $('.netto_total_text').val(accounting.formatMoney(hasil_netto,"",2,'.',','))
            $('.netto_total_text').val(hasil_netto)

        }else if (cb_jenis_ppn == 3){

            var ppn = 0;
            ppn = 100/101 * hasil_netto ;
            ppn_netto = hasil_netto - ppn;
            $('.ppn').val(accounting.formatMoney(ppn_netto,"",2,'.',','))
            $('.netto_total_text').val(accounting.formatMoney(ppn,"",2,'.',','))
            $('.netto_total_text').val(ppn)

        }else if (cb_jenis_ppn == 5){

            var ppn = 0;
            ppn = 100/110 * hasil_netto ;
            ppn_netto = hasil_netto - ppn ;
            $('.ppn').val(accounting.formatMoney(ppn_netto,"",2,'.',','))
            $('.netto_total').val(accounting.formatMoney(ppn,"",2,'.',','))

        }else if (cb_jenis_ppn == 4){
            var ppn = 0;
            ppn = netto_total * 1 ;
            ppn_netto = ppn - netto_total;
            $('.ppn').val(accounting.formatMoney(ppn_netto,"",2,'.',','))
            $('.netto_total').val(accounting.formatMoney(hasil_netto,"",2,'.',','))

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
                // hitung_pajak_lain();
                hitung_total_tagihan();
                $('.simpan_btn').removeClass('disabled');


             }
       })
   }

    function pilih_invoice(par) {
      var nomor = $(par).find('.invoice_nomor').text();
      $.ajax({
        url  :baseUrl+'/sales/nota_debet_kredit/pilih_invoice',
        data : {nomor},
        dataType:'json',
        success:function(data){
          $('.nomor_invoice').val(data.data.i_nomor);
          $('.tgl_invoice').val(data.data.i_tanggal);
          $('.jatuh_tempo').val(data.data.i_jatuh_tempo);
          $('.dpp_awal').val(accounting.formatMoney(data.data.i_netto_detail,"",2,'.',','));
          $('.ppn_awal').val(accounting.formatMoney(data.data.i_ppnrp,"",2,'.',','));
          $('.pph_awal').val(accounting.formatMoney(data.data.i_pajak_lain,"",2,'.',','));
          $('.netto_awal').val(accounting.formatMoney(data.data.i_total_tagihan,"",2,'.',','));
          $('.terbayar').val(accounting.formatMoney(data.data.i_total_tagihan - data.data.i_sisa_pelunasan,"",2,'.',','));
          
          $('#modal_cd').modal('hide');
        }
      })
    }

    function histori(p){
    var par                 = $(p).parents('tr');
    var i_nomor             = $(par).find('.i_nomor').val();
    var i_sisa_pelunasan    = $(par).find('.i_sisa_pelunasan').val();
    var i_bayar             = $(par).find('.i_bayar ').val();
    var i_tagihan           = $(par).find('.i_tagihan ').val();

    $.ajax({
        url:baseUrl + '/sales/riwayat_invoice',
        data:{i_nomor},
        success:function(data){
            $('.riwayat_kwitansi').html(data);
            var temp = 0;
            table_riwayat.$('.kd_total_bayar').each(function(){
                temp += parseFloat($(this).val());
            });
            $('.ed_terbayar').val(accounting.formatMoney(temp,"",2,'.',','));
            $('.terbayar').val(temp);


            $.ajax({
                url:baseUrl + '/sales/riwayat_cn_dn',
                data:{i_nomor},
                success:function(data){
                    $('.riwayat_cn_dn').html(data);
                    var temp = 0;
                    var temp1 = 0;
                    table_cd.$('.cd_debet').each(function(){
                        temp += parseFloat($(this).val());
                    });

                    table_cd.$('.cd_kredit').each(function(){
                        temp1 += parseFloat($(this).val());
                    });
                    $('.ed_nota_debet').val(accounting.formatMoney(temp,"",2,'.',','));
                    $('.nota_debet').val(temp);

                    $('.ed_nota_kredit').val(accounting.formatMoney(temp1,"",2,'.',','));
                    $('.nota_kredit').val(temp1);


                    $('.ed_nomor_invoice').val(i_nomor);
                    $('.ed_jumlah_tagihan').val(accounting.formatMoney(i_tagihan,"",2,'.',','));
                    $('.jumlah_tagihan').val(i_tagihan);

                    var jumlah_tagihan = $('.jumlah_tagihan').val();
                    jumlah_tagihan     = parseFloat(jumlah_tagihan);
                    var terbayar       = $('.terbayar').val();
                    terbayar           = parseFloat(terbayar);
                    var nota_debet     = $('.nota_debet').val()
                    nota_debet         = parseFloat(nota_debet);

                    var nota_kredit    =$('.nota_kredit').val()
                    nota_kredit        = parseFloat(nota_kredit);


                    var jumlah         = jumlah_tagihan - terbayar + nota_debet - nota_kredit;
                    jumlah             = Math.round(jumlah).toFixed(2);
                    $('.ed_sisa_terbayar').val(accounting.formatMoney(jumlah,"",2,'.',','));
                    $('.sisa_terbayar').val(jumlah);

                    var i_bayar        = $(par).find('.i_bayar').val();
                    var i_debet    = $(par).find('.i_debet').val();
                    var i_kredit    = $(par).find('.i_kredit').val();
                    var biaya_admin = parseInt(i_debet)+parseInt(i_kredit);
                    console.log(i_bayar);
                    $('.angka').val(i_bayar);
                    $('.ed_jumlah_bayar').val(accounting.formatMoney(i_bayar,"",2,'.',','));
                    $('.jumlah_bayar').val(i_bayar);
                    $('.jumlah_biaya_admin ').val(biaya_admin);
                    var biaya_admin    = $(par).find('.akun_biaya').val();
                    $('.biaya_admin ').val(biaya_admin).trigger('chosen:updated');


                    hitung();
                    $('#modal_info').modal('show');
                }
            })
        }
    })
  
}


   function simpan(){
       
      swal({
        title: "Apakah anda yakin?",
        text: "Simpan Data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Simpan!",
        cancelButtonText: "Batal",
        closeOnConfirm: true
      },
      function(){
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

          $.ajax({
          url:baseUrl + '/sales/nota_debet_kredit/simpan_cn_dn',
          type:'get',
          data:$('.tabel_header1 :input').serialize()
               +'&'+$('.table_data :input').serialize(),
          success:function(response){
                swal({
                    title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){
                        location.reload();
                });
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

   

</script>
@endsection
