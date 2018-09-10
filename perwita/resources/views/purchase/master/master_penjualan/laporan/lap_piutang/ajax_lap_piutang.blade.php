<!DOCTYPE html>
<html>
<head>
@include('partials._head')
<style type="text/css">
  .height{
    background: white;
    height: 100%;
  }
  .pt-2{
    padding-top: 20px;
  }
  .pl-2{
    padding-top: 20px;
  }
  .pr-2{
    padding-right: 20px !important;
  }
  .width-10{
    width: 10%;
  }
  .width-20{
    width: 20%;
  }
  .border-black{
    border:1px solid #9999;
  }
  .box-git{
    width: 100%;
    height: 133px;
  }
  .nopadding-right {
     padding-right: 0 !important;
     margin-right: 0 !important;
  }

  .nopadding-left {
     padding-left: 0 !important;
     margin-left: 0 !important;
  }
  .mt-1{
    margin-top: 10px !important;
  }
  .mt-2{
    margin-top: 20px !important;
  }
  .mb-1{
    margin-bottom: 10px !important;
  }
  .mb-2{
    margin-bottom: 20px !important;
  }
  .mr-1{
    margin-right: 10px !important;
  }
  .mr-2{
    margin-right: 20px !important;
  }
  .ml-1{
    margin-left: 10px !important;
  }
  .ml-2{
    margin-left: 20px !important;
  }
  .grey{
    color: grey;
  }
  .width-100{
    width: 100%;
  }
  .none{
    text-decoration: none;
    list-style-type: none;
  }
  .d-inline-block{
    display: inline-block;
    vertical-align: middle;
  }
  .d-inline{
    display: inline;
    vertical-align: middle;
  }
  .d-inline li{
    display: inline;
  }
  .m-auto{
    margin: auto;
  }
  .nav-tabs li a{
    padding-left: 0 !important;
    padding-right: 0 !important;
    text-align: center !important;
  }
  .font-small{
    font-size: 12px;
  }
  .middle{
    height: 47px;
  }
  .black{
    color: black;
  }
  .head{
    background: grey !important;
    color:white;
    width: 100%;
    height: 100%;
    vertical-align: middle;
  }
  .mt-5{
    margin-top: 50px
  }
  .head_awal{
    background-color: black !important;
    color: white;`
  }
  .head_awal1{
    background-color: black !important;
    color: white;`
  }
  .head_awal2{
    background-color: black !important;
    color: white;`
  }
  .hide{
    display: none;
  }


  @media print
  {    
      header, header *
      {
          display: none !important;
      }
  }

</style>
<link href="{{ asset('assets/vendors/bootstrap-4/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/chosen/chosen.css') }}" rel="stylesheet">
</head>
<body style="background: grey">
  <header id="navigation" style="padding: 0px 0px;height: 60px;vertical-align: middle;background: rgba(0, 0, 0, 0.4); box-shadow: 0px 2px 5px #444;position: fixed; z-index:2;width: 100%">
    <div class="container" >
      <div class="row">
        <div class="col-sm-6 nopadding-left" style="padding-top: 20px">
          <label style="color: white">PT JAWA PRATAMA MANDIRI</label>
        </div>
        <div class=" col-sm-6 nopadding-left" style="padding-top: 20px;" >
          <div class="col-sm-6" align="right">
            <button class="btn btn-info filter" type="button">
              <i class="fa fa-search"> Filter</i>
            </button>
          </div>
          <div class="col-sm-2" align="right">
            <div class="dropdown">
              <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Collapse
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" onclick="collapse_all()">Collapse All</a>
                <a class="dropdown-item" onclick="collapse_customer()">Collapse Customer</a>
                <a class="dropdown-item" onclick="collapse_akun()">Collapse Akun</a>
                <a class="dropdown-item" onclick="collapse_cabang()">Collapse Cabang</a>
              </div>
            </div>  
          </div>
          <div class="col-sm-2" align="right">
            <div class="dropdown">
              <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Append
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" onclick="append_all()">append All</a>
                <a class="dropdown-item" onclick="append_customer()">append Customer</a>
                <a class="dropdown-item" onclick="append_akun()">append Akun</a>
                <a class="dropdown-item" onclick="append_cabang()">append Cabang</a>
              </div>
            </div>
          </div>
          <div class="col-sm-2" align="right">
            <button class="btn btn-default" onclick="print()" type="button">
              <i class="fa fa-print"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </header>
  <div class="body" id="printArea">
    <div class="container">
      <div class="row" style="margin-top: 80px">
        <div class="col-sm-12 height mt-2" >
          <div class="col-sm-12" style="margin-top: 20px" >
            <h2 class="black"><b>KARTU PIUTANG</b></h2>
            <p class="black">PT JAWA PRATAMA MANDIRI</p>
            <p class="black" style="text-transform: uppercase;">REKAP {{ $jenis }}</p>
            <hr class="black" style="border-bottom: 2px solid black">
          </div>
          <div class="col-sm-12">
            <div class="col-sm-6 nopadding-left">
              <label>Tanggal : {{ carbon\carbon::parse($minr)->format('d-m-Y') }} s/d {{ carbon\carbon::parse($maxr)->format('d-m-Y') }}</label>
            </div>
            <div class="col-sm-6 nopadding-left">
              <label>Customer : {{ $customerr->nama or $customerr}}</label>
            </div>
            <div class="col-sm-6 nopadding-left">
              <label>Akun Piutang : {{ $akunr->nama_akun or $akunr}}</label>
            </div>
            <div class="col-sm-6 nopadding-left">
              <label>Cabang : {{ $cabangr->nama or $cabangr}}</label>
            </div>
          </div>
          @if ($jenis == 'hirarki')
          <div class="col-sm-12 mt-5">
            <table class="table table-bordered ">
              <tr class="head_awal">
                <td>NO</td>
                <td>NAMA CABANG</td>
                <td>DEBET</td>
                <td>KREDIT</td>
                <td>SALDO</td>
              </tr>
              @php
                $saldo_cabang = 0;
                $debet_cabang  = 0;
                $kredit_cabang = 0;
              @endphp
              @foreach ($cabang as $i=>$val)
              @php
                $saldo_cabang = $saldo_cabang + $val->debet - $val->kredit;
                $debet_cabang += $val->debet;
                $kredit_cabang += $val->kredit;
              @endphp
              <tr class="trigger_cabang trigger_cabang_{{ $i }}" onclick="hilang_cabang(this)">
                <td  align="center" width="50">
                  <input type="hidden" class="value_cabang" value="{{ $i }}">
                  {{ $i+1 }}
                </td>
                <td >{{ $val->nama }}</td>
                <td align="right">{{ number_format( $val->debet,2,',','.') }}</td>
                <td align="right">{{ number_format( $val->kredit,2,',','.') }}</td>
                <td align="right">{{ number_format( $saldo_cabang,2,',','.') }} </td>
              </tr>
              <tr class="cabang cabang_{{ $i }}">
                <td colspan="5">
                  <table class="table table-bordered">
                    <tr class="head_awal2">
                      <td>NO</td>
                      <td>AKUN</td>
                      <td>DEBET</td>
                      <td>KREDIT</td>
                      <td>SALDO</td>
                    </tr>
                    @php
                      $saldo_akun  = 0;
                      $debet_akun  = 0;
                      $kredit_akun = 0;
                    @endphp
                    @foreach ($akun[$i] as $i1=>$ak)
                    @php
                      $saldo_akun = $saldo_akun + $ak->debet - $ak->kredit;
                      $debet_akun += $ak->debet;
                      $kredit_akun += $ak->kredit;
                    @endphp
                    <tr class="trigger_akun trigger_akun_{{ $i1 }}" onclick="hilang_akun(this)">
                      <td align="center" width="50">
                        {{ $i1+1 }}
                        <input type="hidden" class="value_akun" value="{{ $i1 }}">
                      </td>
                      <td>{{ $ak->nama }}</td>
                      <td align="right">{{ number_format( $ak->debet,2,',','.') }}</td>
                      <td align="right">{{ number_format( $ak->kredit,2,',','.') }}</td>
                      <td align="right">{{ number_format( $saldo_akun,2,',','.') }} </td>
                    </tr>
                    <tr class="akun akun_{{ $i1 }}">
                      <td colspan="5">
                        <table class="table table-bordered">
                          <tr class="head_awal1">
                            <td>NO</td>
                            <td>CUSTOMER</td>
                            <td>DEBET</td>
                            <td>KREDIT</td>
                            <td>SALDO</td>
                          </tr>
                          @php
                            $saldo_customer  = 0;
                            $debet_customer  = 0;
                            $kredit_customer = 0;
                          @endphp
                          @foreach ($customer[$i][$i1] as $i2=>$cus)
                          @php
                            $saldo_customer = $saldo_customer + $cus->debet - $cus->kredit;
                            $debet_customer += $cus->debet;
                            $kredit_customer += $cus->kredit;
                          @endphp
                          <tr class="trigger_customer trigger_customer_{{ $i2 }}" onclick="hilang_customer(this)">
                            <td align="center" width="50">
                              {{ $i2+1 }}
                              <input type="hidden" class="value_customer" value="{{ $i2 }}">
                            </td>
                            <td >{{ $cus->nama }}</td>
                            <td align="right">{{ number_format( $cus->debet,2,',','.') }}</td>
                            <td align="right">{{ number_format( $cus->kredit,2,',','.') }}</td>
                            <td align="right">{{ number_format( $saldo_customer,2,',','.') }} </td>
                          </tr>
                          <tr class="customer customer_{{ $i2 }}">
                            <td colspan="5">
                              <table class="table table-bordered">
                                <tr class="head_awal1">
                                  <td>NO</td>
                                  <td>INVOICE</td>
                                  <td>KETERANGAN</td>
                                  <td>DEBET</td>
                                  <td>KREDIT</td>
                                  <td>SALDO</td>
                                </tr>
                                @php
                                  $saldo_invoice  = 0;
                                  $debet_invoice  = 0;
                                  $kredit_invoice = 0;
                                @endphp
                                @foreach ($invoice[$i][$i1][$i2] as $i3=>$inv)
                                @php
                                  $saldo_invoice = $saldo_invoice + $inv->debet - $inv->kredit;
                                  $debet_invoice += $inv->debet;
                                  $kredit_invoice += $inv->kredit;
                                @endphp
                                <tr>
                                  <td align="center" width="50">{{ $i3+1 }}</td>
                                  <td >{{ $inv->i_nomor }}</td>
                                  <td> {{ $inv->i_keterangan }}</td>
                                  <td align="right">{{ number_format( $inv->debet,2,',','.') }}</td>
                                  <td align="right">{{ number_format( $inv->kredit,2,',','.') }}</td>
                                  <td align="right">{{ number_format( $saldo_invoice,2,',','.') }} </td>
                                </tr>
                                @endforeach
                                <tfoot>
                                  <td align="right" colspan="3">TOTAL</td>
                                  <td align="right">{{ number_format( $debet_invoice,2,',','.') }}</td>
                                  <td align="right">{{ number_format( $kredit_invoice,2,',','.') }}</td>
                                  <td align="right">{{ number_format( $saldo_invoice,2,',','.') }}</td>
                                </tfoot>
                              </table>
                            </td>
                          </tr>
                          @endforeach
                          <tfoot>
                            <td align="right" colspan="2">TOTAL</td>
                            <td align="right">{{ number_format( $debet_customer,2,',','.') }}</td>
                            <td align="right">{{ number_format( $kredit_customer,2,',','.') }}</td>
                            <td align="right">{{ number_format( $saldo_customer,2,',','.') }}</td>
                          </tfoot>
                        </table>
                      </td>
                    </tr>
                    @endforeach
                    <tfoot>
                      <td align="right" colspan="2">TOTAL</td>
                      <td align="right">{{ number_format( $debet_akun,2,',','.') }}</td>
                      <td align="right">{{ number_format( $kredit_akun,2,',','.') }}</td>
                      <td align="right">{{ number_format( $saldo_akun,2,',','.') }}</td>
                    </tfoot>
                  </table>
                </td>
              </tr>
              @endforeach
              <tfoot>
                <td align="right" colspan="2">TOTAL</td>
                <td align="right">{{ number_format( $debet_cabang,2,',','.') }}</td>
                <td align="right">{{ number_format( $kredit_cabang,2,',','.') }}</td>
                <td align="right">{{ number_format( $saldo_cabang,2,',','.') }}</td>
              </tfoot>
            </table>
          </div>
          @elseif ($jenis == 'customer')
          <div class="col-sm-12 mt-5">
            <table class="table table-bordered">
              <tr class="head_awal1">
                <td>NO</td>
                <td>CUSTOMER</td>
                <td>DEBET</td>
                <td>KREDIT</td>
                <td>SALDO</td>
              </tr>
              @php
                $saldo_customer  = 0;
                $debet_customer  = 0;
                $kredit_customer = 0;
              @endphp
              @foreach ($customer as $i2=>$cus)
              @php
                $saldo_customer = $saldo_customer + $cus->debet - $cus->kredit;
                $debet_customer += $cus->debet;
                $kredit_customer += $cus->kredit;
              @endphp
              <tr class="trigger_customer trigger_customer_{{ $i2 }}" onclick="hilang_customer(this)">
                <td align="center" width="50">
                  {{ $i2+1 }}
                  <input type="hidden" class="value_customer" value="{{ $i2 }}">
                </td>
                <td >{{ $cus->nama }}</td>
                <td align="right">{{ number_format( $cus->debet,2,',','.') }}</td>
                <td align="right">{{ number_format( $cus->kredit,2,',','.') }}</td>
                <td align="right">{{ number_format( $saldo_customer,2,',','.') }} </td>
              </tr>
              @endforeach
              <tfoot>
                <td align="right" colspan="2">TOTAL</td>
                <td align="right">{{ number_format( $debet_customer,2,',','.') }}</td>
                <td align="right">{{ number_format( $kredit_customer,2,',','.') }}</td>
                <td align="right">{{ number_format( $saldo_customer,2,',','.') }}</td>
              </tfoot>
            </table>
          </div>
          @elseif ($jenis == 'invoice')
          <div class="col-sm-12 mt-5">
            <table class="table table-bordered">
              <tr class="head_awal1">
                <td>NO</td>
                <td>INVOICE</td>
                <td>KETERANGAN</td>
                <td>DEBET</td>
                <td>KREDIT</td>
                <td>SALDO</td>
              </tr>
              @php
                $saldo_invoice  = 0;
                $debet_invoice  = 0;
                $kredit_invoice = 0;
              @endphp
              @foreach ($invoice as $i3 =>$inv)
              @php
                $saldo_invoice = $saldo_invoice + $inv->debet - $inv->kredit;
                $debet_invoice += $inv->debet;
                $kredit_invoice += $inv->kredit;
              @endphp
              <tr>
                <td align="center" width="50">{{ $i3+1 }}</td>
                <td >{{ $inv->i_nomor }}</td>
                <td> {{ $inv->i_keterangan }}</td>
                <td align="right">{{ number_format( $inv->debet,2,',','.') }}</td>
                <td align="right">{{ number_format( $inv->kredit,2,',','.') }}</td>
                <td align="right">{{ number_format( $saldo_invoice,2,',','.') }} </td>
              </tr>
              @endforeach
              <tfoot>
                <td align="right" colspan="3">TOTAL</td>
                <td align="right">{{ number_format( $debet_invoice,2,',','.') }}</td>
                <td align="right">{{ number_format( $kredit_invoice,2,',','.') }}</td>
                <td align="right">{{ number_format( $saldo_invoice,2,',','.') }}</td>
              </tfoot>
            </table>
          </div>
          @elseif ($jenis == 'akun')
          <div class="col-sm-12 mt-5">
            <table class="table table-bordered">
              <tr class="head_awal2">
                <td>NO</td>
                <td>AKUN</td>
                <td>DEBET</td>
                <td>KREDIT</td>
                <td>SALDO</td>
              </tr>
              @php
                $saldo_akun  = 0;
                $debet_akun  = 0;
                $kredit_akun = 0;
              @endphp
              @foreach ($akun as $i1=>$ak)
              @php
                $saldo_akun = $saldo_akun + $ak->debet - $ak->kredit;
                $debet_akun += $ak->debet;
                $kredit_akun += $ak->kredit;
              @endphp
              <tr class="trigger_akun trigger_akun_{{ $i1 }}" onclick="hilang_akun(this)">
                <td align="center" width="50">
                  {{ $i1+1 }}
                  <input type="hidden" class="value_akun" value="{{ $i1 }}">
                </td>
                <td>{{ $ak->nama }}</td>
                <td align="right">{{ number_format( $ak->debet,2,',','.') }}</td>
                <td align="right">{{ number_format( $ak->kredit,2,',','.') }}</td>
                <td align="right">{{ number_format( $saldo_akun,2,',','.') }} </td>
              </tr>
              @endforeach
              <tfoot>
                <td align="right" colspan="2">TOTAL</td>
                <td align="right">{{ number_format( $debet_akun,2,',','.') }}</td>
                <td align="right">{{ number_format( $kredit_akun,2,',','.') }}</td>
                <td align="right">{{ number_format( $saldo_akun,2,',','.') }}</td>
              </tfoot>
            </table>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">FILTER</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table">
            <tr>
              <td>MIN DATE</td>
              <td><input type="text" value="{{ $minr }}" class="date min form-control" name="min"></td>
            </tr>
            <tr>
              <td>MAX DATE</td>
              <td><input type="text" value="{{ $maxr }}" class="date max form-control" name="max"></td>
            </tr>
            <tr>
              <td>Customer</td>
              <td>
                <select class="chosen-select-width form-control" name="customer" id="customer">
                  <option value="0">- Semua Customer -</option>
                  @foreach ($customer1 as $e)
                    <option @if (isset($customerr->kode))
                              @if ($customerr->kode == $e->kode)
                                selected="" 
                              @endif
                            @endif
                    value="{{ $e->kode }}">{{ $e->kode }} - {{ $e->nama }}</option>
                  @endforeach
                </select>
              </td>
            </tr>
            <tr>
              <td>Acc Piutang</td>
              <td>
                <select class="chosen-select-width form-control" name="akun" id="akun">
                  <option value="0">- Semua Piutang -</option>
                  @foreach ($piutang1 as $piu)
                    <option @if (isset($akunr->id_akun))
                              @if ($akunr->id_akun == $piu->id_akun)
                                selected="" 
                              @endif
                    @endif  value="{{ $piu->id_akun }}">{{ $piu->id_akun }} - {{ $piu->nama_akun }}</option>
                  @endforeach
                </select>
              </td>
            </tr>
            <tr>
              <td>Cabang</td>
              @if (Auth::user()->punyaAkses('Laporan Penjualan','cabang'))
               <td>
                <select class="chosen-select-width form-control" name="cabang" id="cabang">
                  <option value="0">- Semua Cabang -</option>
                  @foreach ($cabang1 as $cab)
                    <option @if (isset($cabangr->kode))
                      @if ($cabangr->kode == $cab->kode)
                        selected="" 
                      @endif
                    @endif value="{{ $cab->kode }}">{{ $cab->kode }} - {{ $cab->nama }}</option>
                  @endforeach
                </select>
               </td>
               @else
               <td class="disabled">
                  <select class="chosen-select-width form-control" name="cabang" id="cabang">
                    <option value="0">- Semua Cabang -</option>
                    @foreach ($cabang1 as $cab)
                      <option @if (Auth::user()->kode_cabang == $cab->kode)
                        selected="" 
                      @endif value="{{ $cab->kode }}">{{ $cab->kode }} - {{ $cab->nama }}</option>
                    @endforeach
                  </select>
                </td>
               @endif
            </tr>
            <tr>
              <td>LAPORAN</td>
              <td>
                <select class="chosen-select-width" name="laporan" id="laporan">
                  <option @if ($jenis == 'hirarki')
                    selected="" 
                  @endif value="hirarki">- Hirarki -</option>
                  <option @if ($jenis == 'customer')
                    selected="" 
                  @endif value="customer">- customer -</option>
                  <option @if ($jenis == 'akun')
                    selected="" 
                  @endif value="akun">- akun -</option>
                  <option @if ($jenis == 'invoice')
                    selected="" 
                  @endif value="invoice">- invoice -</option>
                </select>
              </td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="cari()">Cari</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</body>
{{-- @include('partials._scripts') --}}
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>
<script src="{{ asset('assets/vendors/bootstrap-4/js/Popper.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/bootstrap-4/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/vendors/accounting/accounting.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/js/chosen/chosen.jquery.js') }}"></script>
<script type="text/javascript">
  var config1 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width'     : {width:"100%"}
             }

  for (var selector in config1) {
   $(selector).chosen(config1[selector]);
  }  

  $('.date').datepicker({
    format:'yyyy-mm-dd'
  }).on('changeDate', function(e){
    $(this).datepicker('hide');
  });
 
  function hilang_cabang(par) {
   var triger = $(par).find('.value_cabang').val();

   var cabang = $('.cabang_'+triger);

   if (cabang.hasClass('hide')) {
    cabang.removeClass('hide');
   }else{
    cabang.addClass('hide');
   }
  }

  function hilang_akun(par) {
   var triger = $(par).find('.value_akun').val();

   var cabang = $('.akun_'+triger);

   if (cabang.hasClass('hide')) {
    cabang.removeClass('hide');
   }else{
    cabang.addClass('hide');
   }
  }

  function hilang_customer(par) {
   var triger = $(par).find('.value_customer').val();

   var cabang = $('.customer_'+triger);

   if (cabang.hasClass('hide')) {
    cabang.removeClass('hide');
   }else{
    cabang.addClass('hide');
   }
  }
  $(document).ready(function(){
    $('.cabang').addClass('hide');
    $('.customer').addClass('hide');
    $('.akun').addClass('hide');
  })

  function collapse_all() {
    collapse_akun();
    collapse_customer();
    collapse_cabang();
  }

  function collapse_akun(argument) {
    
    $('.akun').addClass('hide');
  }

  function collapse_customer(argument) {
    $('.customer').addClass('hide');
  }

  function collapse_cabang(argument) {
    $('.cabang').addClass('hide');
  }

  function append_all() {
    append_akun();
    append_customer();
    append_cabang();
  }

  function append_akun(argument) {
    $('.cabang').removeClass('hide');
    $('.akun').removeClass('hide');
  }

  function append_customer(argument) {
    $('.customer').removeClass('hide');
    $('.cabang').removeClass('hide');
    $('.akun').removeClass('hide');
  }

  function append_cabang(argument) {
    $('.cabang').removeClass('hide');
  }

  function jenis(jenis) {
    var min       = '{{ $minr }}';
    var max       = '{{ $maxr }}';
    var customer  = '{{ $customerr->kode or $customerr }}';
    var akun      = '{{ $akunr->id_akun or $akunr  }}';
    var cabang    = '{{ $cabangr->kode or $cabangr }}';

    location.href = '{{ url('cari_kartupiutang/cari_kartupiutang') }}?min='+min+'&max='+max+'&customer='+customer+'&akun='+akun+'&cabang='+cabang+'&jenis='+jenis;
  }

  function cari() {
    var min       = $('.min').val();
    var max       = $('.max').val();
    var customer  = $('#customer').val();
    var akun      = $('#akun').val();
    var cabang    = $('#cabang').val();
    var jenis     = $('#laporan').val();

    location.href = '{{ url('cari_kartupiutang/cari_kartupiutang') }}?min='+min+'&max='+max+'&customer='+customer+'&akun='+akun+'&cabang='+cabang+'&jenis='+jenis;
  }

  $('.filter').click(function(){
    $('.modal').modal('show');
  })
</script>
</html>
