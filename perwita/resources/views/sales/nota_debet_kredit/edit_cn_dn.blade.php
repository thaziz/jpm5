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

  .right{
      text-align: right;
  }
  .table-hover tbody tr{
    cursor: pointer;
  }

  .center{
      text-align: center;
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
           <a  href="{{url('sales/nota_debet_kredit')}}" class="pull-right" style="color: grey; float: right;"><i class="fa fa-arrow-left"> Kembali</i></a>
          
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
                        <td width="93px">Nomor CN/DN</td> 
                        <td><input type="text" readonly="" value="{{$data->cd_nomor}}" class="form-control nomor_cn_dn" name="nomor_cn_dn"></td>
                      </tr>
                      <tr>
                        <td>
                          Jenis CN/DN
                        </td>
                        <td class="jenis_td">
                          <select class="form-control jenis_cd" onchange="hitung()" name="jenis_debet">
                          @if($data->cd_jenis == 'K')
                          <option selected="" value="K">KREDIT</option>
                          <option value="D">DEBET</option>
                          @else
                          <option value="K">KREDIT</option>
                          <option selected="" value="D">DEBET</option>
                          @endif
                        </select>
                        </td>
                      </tr>
                      <tr>
                          <td>Akun Biaya</td>
                          <td style="max-width: 200px"  class="akun_biaya_td">
                              <select  class="form-control akun_biaya" name="akun_biaya" id="akun_biaya">
                                  @foreach($akun_biaya as $val)
                                  @if($data->cd_jenis_biaya == $val->kode)
                                  <option selected="" value="{{$val->kode}}" data-biaya ="{{$val->acc_biaya}}" data-jenis ="{{$val->jenis}}">{{$val->kode}} - {{$val->nama}}</option>
                                  @else
                                  <option value="{{$val->kode}}" data-biaya ="{{$val->acc_biaya}}" data-jenis ="{{$val->jenis}}">{{$val->kode}} - {{$val->nama}}</option>
                                  @endif
                                  @endforeach
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
                              <input type="text" class="form-control tgl" name="tgl" value="{{$data->cd_tanggal}}">
                          </div>
                        </td>
                      </tr>
                      @if(Auth::user()->punyaAkses('CN DN Penjualan','cabang'))
                      <tr>
                        <td>
                          Cabang
                        </td>
                        <td class=" cabang_td disabled">
                          <select class="form-control cabang chosen-select-width" name="cabang">
                          @foreach($cabang as $val)
                            @if($data->cd_kode_cabang == $val->kode)
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
                        <td class="cabang_td disabled">
                          <select class="form-control cabang chosen-select-width" name="cabang">
                          @foreach($cabang as $val)
                            @if($data->cd_kode_cabang == $val->kode)
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
                          <td colspan="5" class="customer_td disabled">                                    
                              <select class="chosen-select-width cus_disabled form-control"   name="customer" id="customer" style="width:100%" >
                                  <option value="0">Pilih - Customer</option>
                              @foreach ($customer as $row)
                              @if ($data->cd_customer == $row->kode)
                                  <option selected="" value="{{$row->kode}}" data-accpiutang="{{$row->acc_piutang}}"> {{$row->kode}} - {{$row->nama}} - {{$row->cabang}} </option>
                              @endif
                                  <option value="{{$row->kode}}" data-accpiutang="{{$row->acc_piutang}}"> {{$row->kode}} - {{$row->nama}} - {{$row->cabang}} </option>
                              @endforeach
                              </select>
                              <input type="hidden" class="ed_customer" name="ed_customer" value="" >
                          </td>
                      </tr>
                      <tr>
                        <td>Keterangan</td> 
                        <td><input type="text" name="keterangan" value="{{$data->cd_keterangan}}" class="form-control keterangan" ></td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-sm-6">
                    
                    <table class="table borderless table-hover table_pajak ">
                        <tbody>
                            <tr>
                                <td>Jumlah DPP</td>
                                <td colspan="4">
                                    <input type="text" value="0" name="jumlah_dpp" class="form-control jumlah_dpp" readonly="readonly" style="text-align:right">
                                </td>
                            </tr>
                            <tr>
                                <td>Jumlah PPN</td>
                                <td colspan="4">
                                    <input type="text" name="jumlah_ppn" class="form-control jumlah_ppn" readonly="readonly" style="text-align:right" value="0">
                                </td>
                            </tr>
                            <tr>
                                <td>Jumlah PPH23</td>
                                <td colspan="4">
                                    <input type="text" name="jumlah_pph" class="form-control jumlah_pph" readonly="readonly" style="text-align:right" value="0">
                                </td>
                            </tr>
                            <tr>
                                <td>Jumlah Nota</td>
                                <td colspan="4">
                                    <input type="text" class="jumlah_nota form-control" name="jumlah_nota" readonly="readonly" style="text-align:right" value="0">
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
                                          <td colspan="3"><input type="text" name="nomor_invoice" class="nomor_invoice form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>Tanggal Invoice</td>
                                          <td colspan="3"><input type="text" readonly="" name="tgl_invoice" class="tgl_invoice form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>Jatuh tempo</td>
                                          <td colspan="3"><input type="text" readonly="" name="jatuh_tempo" class="jatuh_tempo form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>DPP</td>
                                          <td colspan="3"><input type="text" readonly="" style="text-align: right" name="dpp" class="dpp_awal form-control"></td>
                                        </tr>
                                        <tr>
                                            <td>PPN</td>
                                            <td colspan="3">
                                                <input type="text" name="ppn" style="text-align: right" class="form-control ppn_awal" readonly="readonly" >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PPH</td>
                                            <td colspan="3">
                                                <input type="text" name="pph" style="text-align: right" class="pph_awal form-control" readonly="readonly">
                                            </td>
                                        </tr>
                                        <tr>
                                          <td>Netto</td>
                                          <td colspan="3"><input type="text" readonly="" name="netto_awal" style="text-align: right" class="netto_awal form-control"></td>
                                        </tr>
                                    </table>
                                  </div>
                                  <div class="col-sm-6">
                                    <table class="table riwayat  borderless">
                                        <tr>
                                          <td>Terbayar</td>
                                          <td colspan="3"><input type="text" name="terbayar" readonly="" style="text-align: right" class="terbayar form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>Nota Debet</td>
                                          <td colspan="3"><input type="text" style="text-align: right" name="nota_debet" readonly="" class="nota_debet form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>Nota Kredit</td>
                                          <td colspan="3"><input type="text" style="text-align: right" name="nota_kredit" readonly="" class="nota_kredit form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>Sisa Terbayar</td>
                                          <td colspan="3"><input type="text" style="text-align: right" name="sisa_terbayar" readonly="" class="sisa_terbayar form-control"></td>
                                        </tr>
                                        <tr>
                                          <td>DPP</td>
                                          <td colspan="3"><input type="text" style="text-align: right" name="dpp_akhir" onkeyup="hitung_jumlah()" value="0,00"  class="dpp_akhir form-control"></td>
                                        </tr>
                                        <tr class="ppn_td ">
                                            <td >Jenis PPN</td>
                                            <td >
                                                <select class="form-control jenis_ppn_akhir" onchange="hitung_pajak_ppn()"  >
                                                    <option value="4" ppnrte="0" ppntpe="npkp" >NON PPN</option>
                                                    <option value="1" ppnrte="10" ppntpe="pkp" >EXCLUDE 10 %</option>
                                                    <option value="2" ppnrte="1" ppntpe="pkp" >EXCLUDE 1 %</option>
                                                    <option value="3" ppnrte="1" ppntpe="npkp" >INCLUDE 1 %</option>
                                                    <option value="5" ppnrte="10" ppntpe="npkp" >INCLUDE 10 %</option>
                                                </select>
                                            </td>
                                            <td style="padding-top: 0.4cm; text-align:right">PPN</td>
                                            <td>
                                                <input onkeyup="hitung_jumlah()" style="text-align: right" type="text" name="ppn" class="form-control ppn_akhir" value="0,00"  tabindex="-1" >
                                            </td>
                                        </tr>
                                        <tr class="pph_td ">
                                            <td>Pajak lain-lain</td>
                                            <td >
                                                <select onchange="hitung_pajak_lain()"  class="pajak_lain_akhir form-control" name="kode_pajak_lain" id="pajak_lain_akhir" >
                                                    <option value="0"  >Pilih Pajak Lain-lain</option>
                                                    @foreach($pajak as $val)
                                                        <option value="{{$val->kode}}" data-pph="{{$val->nilai}}">{{$val->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td >PPH</td>
                                            <td>
                                                <input onkeyup="hitung_jumlah()" style="text-align: right" type="text" name="pph" class="pph_akhir form-control"  value="0,00" tabindex="-1" >
                                            </td>
                                        </tr>
                                        <tr>
                                          <td>Jumlah N/D</td>
                                          <td colspan="3">
                                            <input type="text" readonly="" style="text-align: right" name="netto_akhir" class="netto_akhir form-control">
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="4" >
                                            <div class="pull-right">
                                              <button onclick="append()" class="btn btn-default pull-right">
                                                <i class="fa fa-plus"> Append</i>
                                              </button>
                                            </div>
                                          </td>
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
                      <div class="pull-right">
                        <button type="button" class="btn btn-success simpan" onclick="simpan()" >
                        <i class="glyphicon glyphicon-save"></i> Simpan
                      </button>
                      </div>
                      <table class="table table_detail table-bordered">
                        <thead>
                          <tr>
                            <th>Nomor Invoice</th>
                            <th>DPP</th>
                            <th>PPN</th>
                            <th>PPH23</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
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
                                <h4 class="modal-title">Invoice</h4>
                            </div>
                            <div class="modal-body cn_dn_modal">
                                
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="update_biaya">Save changes</button>
                                </div>
                            </div>
                        </div>
                      </div>
                  </div>

                  {{-- MODAL --}}
                  <div id="riwayat" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Riwayat</h4>
                          </div>
                          <div class="modal-body riwayat_div">
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
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



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
  var array_simpan = [];
      
    var table_detail = $('.table_detail').DataTable({
      columnDefs: [

          {
             targets: 1,
             className: 'right'
          },
          {
             targets: 2 ,
             className: 'right'
          },
          {
             targets: 3,
             className: 'right'
          },
          {
             targets: 4,
             className: 'right'
          },
          {
             targets: 5,
             className: 'center'
          }
       ]
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    $('.cabang').change(function(){
      var cabang = $('.cabang').val();  
      $.ajax({
        url  :baseUrl+'/sales/nota_debet_kredit/nomor_cn_dn',
        data : {cabang},
        success:function(data){
          $('.nomor_cn_dn').val(data.nota);
        }
      })
    })
    

    $('.dpp_akhir').maskMoney({precision:2,thousands:'.',allowZero:true,decimal:','});
    $('.ppn_akhir ').maskMoney({precision:2,thousands:'.',allowZero:true,decimal:','});
    $('.pph_akhir').maskMoney({precision:2,thousands:'.',allowZero:true,decimal:','});

     function hitung_total_tagihan(){
        var temp1 = 0;
        $('.d_dpp').each(function(){
          var ini  = $(this).val();
          ini      = ini.replace(/[^0-9\-]+/g,"");
          ini      = parseFloat(ini)/100;
          temp1 += ini;
        })
        $('.jumlah_dpp').val(accounting.formatMoney(temp1,"",2,'.',','));
        var temp2 = 0;
        $('.d_ppn').each(function(){
          var ini  = $(this).val();
          ini      = ini.replace(/[^0-9\-]+/g,"");
          ini      = parseFloat(ini)/100;
          temp2 += ini;
        })
        $('.jumlah_ppn').val(accounting.formatMoney(temp2,"",2,'.',','));
        var temp3 = 0;
        $('.d_pph').each(function(){
          var ini  = $(this).val();
          ini      = ini.replace(/[^0-9\-]+/g,"");
          ini      = parseFloat(ini)/100;
          temp3 += ini;
        })
        $('.jumlah_pph').val(accounting.formatMoney(temp3,"",2,'.',','));
        var temp = temp1+temp2+temp3;
        
        $('.jumlah_nota').val(accounting.formatMoney(temp,"",2,'.',','));

     } 

     function hitung() {
      var jenis_cd      = $('.jenis_cd').val();
      // if (jenis_cd == 'K') {
      //   $('.ppn_td').addClass('disabled');
      //   $('.pph_td').removeClass('disabled');
      // }else{
      //   $('.pph_td').addClass('disabled');
      //   $('.ppn_td').removeClass('disabled');
      // }
      var terbayar      = $('.terbayar').val();
      var nota_debet    = $('.nota_debet').val();
      var nota_kredit   = $('.nota_kredit').val();
      var netto_awal    = $('.netto_awal').val();

      terbayar          = terbayar.replace(/[^0-9\-]+/g,"");
      nota_debet        = nota_debet.replace(/[^0-9\-]+/g,"");
      nota_kredit       = nota_kredit.replace(/[^0-9\-]+/g,"");
      netto_awal        = netto_awal.replace(/[^0-9\-]+/g,"");

      terbayar          = parseFloat(terbayar)/100;
      nota_debet        = parseFloat(nota_debet)/100;
      nota_kredit       = parseFloat(nota_kredit)/100;
      netto_awal        = parseFloat(netto_awal)/100;

      var hasil         = netto_awal - terbayar + nota_debet - nota_kredit;
      $('.sisa_terbayar').val(accounting.formatMoney(hasil,"",2,'.',','));

      
    }

    function hitung_jumlah() {
      var sisa_terbayar = $('.sisa_terbayar').val();
      var dpp_akhir     = $('.dpp_akhir').val();
      var ppn_akhir     = $('.ppn_akhir').val();
      var pph_akhir     = $('.pph_akhir').val();
      var jenis_cd      = $('.jenis_cd').val();

      sisa_terbayar     = sisa_terbayar.replace(/[^0-9\-]+/g,"");
      dpp_akhir         = dpp_akhir.replace(/[^0-9\-]+/g,"");
      ppn_akhir         = ppn_akhir.replace(/[^0-9\-]+/g,"");
      pph_akhir         = pph_akhir.replace(/[^0-9\-]+/g,"");

      sisa_terbayar     = parseFloat(sisa_terbayar)/100;
      dpp_akhir         = parseFloat(dpp_akhir)/100;
      ppn_akhir         = parseFloat(ppn_akhir)/100;
      pph_akhir         = parseFloat(pph_akhir)/100;

      if (jenis_cd == 'K') {
        var hasil = dpp_akhir + ppn_akhir - pph_akhir;
      }else{
        var hasil = dpp_akhir + ppn_akhir - pph_akhir;
      }

      $('.netto_akhir').val(accounting.formatMoney(hasil,"",2,'.',','));
    }

   

    function hitung_pajak_ppn() {
       var cb_jenis_ppn = $('.jenis_ppn_akhir').val();
       var netto_total  = $('.dpp_akhir').val();
       netto_total      = netto_total.replace(/[^0-9\-]+/g,"");
       netto_total      = parseFloat(netto_total)/100;

       hasil_netto      = parseFloat(netto_total);
       if (hasil_netto < 0) {
        hasil_netto = 0;
        }
      console.log(netto_total);
      console.log(cb_jenis_ppn);

        if (cb_jenis_ppn == 1) {

            var ppn = 0;
            ppn = hasil_netto * 1.1 ;
            ppn_netto = ppn - hasil_netto;
            $('.ppn_akhir').val(accounting.formatMoney(ppn_netto,"",2,'.',','))
            

        }else if (cb_jenis_ppn == 2){

            var ppn = 0;
            ppn = hasil_netto * 1.01 ;
            ppn_netto = ppn - hasil_netto;
            $('.ppn_akhir').val(accounting.formatMoney(ppn_netto,"",2,'.',','))
            

        }else if (cb_jenis_ppn == 3){

            var ppn = 0;
            ppn = 100/101 * hasil_netto ;
            ppn_netto = hasil_netto - ppn;
            $('.ppn_akhir').val(accounting.formatMoney(ppn_netto,"",2,'.',','))
           

        }else if (cb_jenis_ppn == 5){

            var ppn = 0;
            ppn = 100/110 * hasil_netto ;
            ppn_netto = hasil_netto - ppn ;
            $('.ppn_akhir').val(accounting.formatMoney(ppn_netto,"",2,'.',','))
           

        }else if (cb_jenis_ppn == 4){
            var ppn = 0;
            ppn = netto_total * 1 ;
            ppn_netto = ppn - netto_total;
            $('.ppn_akhir').val(accounting.formatMoney(ppn_netto,"",2,'.',','))

        }

       hitung_jumlah();

       
    }

    function hitung_pajak_lain(){

       var netto_total  = $('.dpp_akhir').val();
       var pajak_lain   = $('.pajak_lain_akhir').val();
       netto_total      = netto_total.replace(/[^0-9\-]+/g,"");
       netto_total      = parseInt(netto_total)/100;
       var pajak_persen = 0;
       var pajak_total  = 0;
       if (pajak_lain == 0) {

        $('.pph_akhir').val(accounting.formatMoney(pajak_total,"",2,'.',','));

        return 1;
       }


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
                $('.pph_akhir').val(accounting.formatMoney(pajak_total,"",2,'.',','));
                hitung_jumlah();


             }
       })

       hitung_jumlah();
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
          $('.nota_debet').val(accounting.formatMoney(data.D,"",2,'.',','));
          $('.nota_kredit').val(accounting.formatMoney(data.K,"",2,'.',','));
          hitung();
          $('#modal_cd').modal('hide');
        }
      })
    }

    function pilih_invoice1() {
      var nomor = $('.nomor_invoice').val();
      var nomor_cn_dn = $('.nomor_cn_dn').val();
      $.ajax({
        url  :baseUrl+'/sales/nota_debet_kredit/pilih_invoice',
        data : {nomor,nomor_cn_dn},
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
          $('.nota_debet').val(accounting.formatMoney(data.D,"",2,'.',','));
          $('.nota_kredit').val(accounting.formatMoney(data.K,"",2,'.',','));
          hitung();
          $('#modal_cd').modal('hide');
        }
      })
    }


    $('.nomor_invoice').focus(function(){
      var cabang = $('.cabang').val();
      var customer = $('#customer').val();
      $.ajax({
        url  :baseUrl+'/sales/nota_debet_kredit/cari_invoice',
        data : {cabang,array_simpan,customer},
        success:function(data){
          $('.cn_dn_modal').html(data);
          $('#modal_cd').modal('show');
        }
      })
    })

    @foreach ($data_dt as $val)
     var nomor_invoice        = "{{$val->cdd_nomor_invoice}}";
     var dpp                  = "{{$val->cdd_dpp_akhir}}";
     var ppn_akhir            = "{{$val->cdd_ppn_akhir}}";
     var pph_akhir            = "{{$val->cdd_pph_akhir}}";
     var jenis_ppn_akhir      = "{{$val->cdd_jenis_ppn}}";
     var pajak_lain_akhir     = "{{$val->cdd_jenis_pajak}}";
     var netto_akhir          = "{{$val->cdd_netto_akhir}}";

          table_detail.row.add([
          '<a onclick="histori(this)" class="d_nomor_text">'+nomor_invoice+'</a>'+
          '<input type="hidden" class="d_nomor d_nomor_'+nomor_invoice+'" value="'+nomor_invoice+'" name="d_nomor[]">',

          '<p class="d_dpp_text">'+accounting.formatMoney(dpp,"",2,'.',',')+'</p>'+'<input type="hidden" class="d_dpp" value="'+accounting.formatMoney(dpp,"",2,'.',',')+'" name="d_dpp[]">',

          '<p class="d_ppn_text">'+accounting.formatMoney(ppn_akhir,"",2,'.',',')+'</p>'+
          '<input type="hidden" value="'+accounting.formatMoney(ppn_akhir,"",2,'.',',')+'" class="d_ppn" name="d_ppn[]">'+
          '<input type="hidden" class="d_jenis_ppn" value="'+jenis_ppn_akhir+'" name="d_jenis_ppn[]">'+
          '<input type="hidden" class="d_pajak_lain" value="'+pajak_lain_akhir+'" name="d_pajak_lain[]">',

          '<p class="d_pph_text">'+accounting.formatMoney(pph_akhir,"",2,'.',',')+'</p>'+'<input type="hidden" class="d_pph" value="'+accounting.formatMoney(pph_akhir,"",2,'.',',')+'" name="d_pph[]">',

          '<p class="d_netto_text">'+accounting.formatMoney(netto_akhir,"",2,'.',',')+'</p>'+
          '<input type="hidden" class="d_netto" value="'+accounting.formatMoney(netto_akhir,"",2,'.',',')+'" name="d_netto[]">',

          '<div class="btn-group ">'+
          '<a  onclick="edit(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
          '<a  onclick="hapus(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
          '</div>'
        ]).draw();
        array_simpan.push(nomor_invoice);
        $('.jenis_td').addClass('disabled');
        $('.akun_biaya_td').addClass('disabled');
        $('.cabang_td').addClass('disabled');
        $('.customer_td').addClass('disabled');
        hitung_total_tagihan();
   @endforeach


    var count = 1;
   function append() {
     var nomor_invoice    = $('.nomor_invoice').val(); 
     var dpp              = $('.dpp_akhir').val(); 
     var ppn_akhir        = $('.ppn_akhir').val(); 
     var pph_akhir        = $('.pph_akhir').val(); 
     var netto_akhir      = $('.netto_akhir').val(); 
     var jenis_ppn_akhir  = $('.jenis_ppn_akhir').val();
     var pajak_lain_akhir = $('.pajak_lain_akhir').val();
     if (netto_akhir == '' || netto_akhir == '0,00') {
      toastr.warning('Netto Akhir Tidak Boleh Kosong Atau 0');
      return 1;
     }
     var index = array_simpan.indexOf(nomor_invoice);
     if (index == -1) {
       table_detail.row.add([

          '<a onclick="histori(this)" class="d_nomor_text">'+nomor_invoice+'</a>'+
          '<input type="hidden" class="d_nomor d_nomor_'+nomor_invoice+'" value="'+nomor_invoice+'" name="d_nomor[]">',

          '<p class="d_dpp_text">'+dpp+'</p>'+'<input type="hidden" class="d_dpp" value="'+dpp+'" name="d_dpp[]">',

          '<p class="d_ppn_text">'+ppn_akhir+'</p>'+
          '<input value="'+ppn_akhir+'"  type="hidden" class="d_ppn" name="d_ppn[]">'+
          '<input type="hidden" class="d_jenis_ppn" value="'+jenis_ppn_akhir+'" name="d_jenis_ppn[]">'+
          '<input type="hidden" class="d_pajak_lain" value="'+pajak_lain_akhir+'" name="d_pajak_lain[]">',

          '<p class="d_pph_text">'+pph_akhir+'</p>'+'<input type="hidden" class="d_pph" value="'+pph_akhir+'" name="d_pph[]">',

          '<p class="d_netto_text">'+netto_akhir+'</p>'+
          '<input type="hidden" class="d_netto" value="'+netto_akhir+'" name="d_netto[]">',

          '<div class="btn-group ">'+
          '<a  onclick="edit(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
          '<a  onclick="hapus(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
          '</div>',
        ]).draw();
        array_simpan.push(nomor_invoice);
        $('.jenis_td').addClass('disabled');
        $('.akun_biaya_td').addClass('disabled');
        $('.cabang_td').addClass('disabled');
        $('.customer_td').addClass('disabled');

      }else{
         var a            = $('.d_nomor_'+nomor_invoice);
         var par          = $(a).parents('tr');
         $(par).find('.d_dpp').val(dpp);
         $(par).find('.d_ppn').val(ppn_akhir);
         $(par).find('.d_jenis_ppn').val(jenis_ppn_akhir);
         $(par).find('.d_pajak_lain').val(pajak_lain_akhir);
         $(par).find('.d_pph').val(pph_akhir);
         $(par).find('.d_netto').val(netto_akhir);
        console.log($(par).find('.d_ppn').val());
         $(par).find('.d_dpp_text').text(dpp);
         $(par).find('.d_ppn_text').text(ppn_akhir);
         $(par).find('.d_pph_text').text(pph_akhir);
         $(par).find('.d_netto_text').text(netto_akhir);

      }

      $('.riwayat input').val('');
      $('.riwayat ').find('.ppn_akhir').val('0,00');
      $('.riwayat ').find('.pph_akhir').val('0,00');
      hitung_total_tagihan();
   }

   function histori(p){
      console.log('sd');
      var nomor = $(p).text();
      var    id = $('.nomor_cn_dn').val();
      console.log(nomor);
      $.ajax({
        url  :baseUrl+'/sales/nota_debet_kredit/riwayat',
        data : {nomor,id},
        success:function(data){
          $('#riwayat').modal('show');
          $('.riwayat_div').html(data);
        }
      })
    }

   function edit(a) {
     var par          = $(a).parents('tr');
     var d_nomor      = $(par).find('.d_nomor').val();
     var d_dpp        = $(par).find('.d_dpp').val();
     var d_ppn        = $(par).find('.d_ppn').val();
     var d_jenis_ppn  = $(par).find('.d_jenis_ppn').val();
     var d_pajak_lain = $(par).find('.d_pajak_lain').val();
     var d_pph        = $(par).find('.d_pph').val();
     var d_netto      = $(par).find('.d_netto').val();

     $('.dpp_akhir').val(d_dpp); 
     $('.ppn_akhir').val(d_ppn); 
     $('.pph_akhir').val(d_pph); 
     $('.netto_akhir').val(d_netto); 
     $('.jenis_ppn_akhir').val(d_jenis_ppn);
     $('.pajak_lain_akhir').val(d_pajak_lain);

     $('.nomor_invoice').val(d_nomor);
     pilih_invoice1();

     toastr.info('Edit Data Berhasil Diinisialisasi');
   }

   function hapus(a) {
     var par   = $(a).parents('tr');
     var arr   = $(par).find('.d_nomor').val();
     var index = array_simpan.indexOf(arr);
     array_simpan.splice(index,1);
     table_detail.row(par).remove().draw(false);
     hitung_total_tagihan();
     var val  = 0;
     $('d_nomor').each(function(){
      val += 1;
     });
     if (val == 0) {
        $('.jenis_td').removeClass('disabled');
        $('.akun_biaya_td').removeClass('disabled');
     }

   }


   function simpan(){
       
      swal({
        title: "Apakah anda yakin?",
        text: "Update Data!",
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
          url:baseUrl + '/sales/nota_debet_kredit/update_cn_dn',
          type:'get',
          data:$('.tabel_header1 :input').serialize()
               +'&'+table_detail.$('input').serialize()
               +'&'+$('.table_pajak :input').serialize(),
          success:function(response){
                swal({
                    title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){
                        window.location.href= baseUrl+'/sales/nota_debet_kredit';
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
