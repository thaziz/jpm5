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

  .loader {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
    margin:auto;
    margin-top:200px;
    margin-bottom:200px;
  }
  .auto{
    margin:auto;
    margin-top:200px;
    margin-bottom:200px;
    width: 100%;
    height: 120px;
  }

  @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
  }

  @media print
  {    
      header, header *
      {
          display: none !important;
      }
  }
  tr{
    cursor: pointer;
  }
</style>
<link href="{{ asset('assets/vendors/bootstrap-4/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/chosen/chosen.css') }}" rel="stylesheet">
</head>
<body style="background: grey">
  <header id="navigation" style="padding: 0px 0px;height: 60px;vertical-align: middle;background: rgba(0, 0, 0, 0.4); box-shadow: 0px 2px 5px #444;position: fixed; z-index:2;width: 100%">
    <div class="container" >
      <div class="row">
        <a href="{{ url('/') }}" class="col-sm-6 nopadding-left" style="padding-top: 20px">
          <label style="color: white;cursor: pointer;">PT JAWA PRATAMA MANDIRI</label>
        </a>
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
  <div class="" id="printArea" style="padding-top: 60px">
    {{-- <div class="container"> --}}
      {{-- <div class="row" style="margin-top: 80px"> --}}
        <div class="col-sm-12 height mt-2" >
          <div class="col-sm-12" style="margin-top: 20px" >
            <h2 class="black"><b>ANALISA PIUTANG</b></h2>
            <p class="black">PT JAWA PRATAMA MANDIRI</p>
            <p class="black rekap" style="text-transform: uppercase;">REKAP {{ $jenis }}</p>
            <hr class="black" style="border-bottom: 2px solid black">
          </div>
          <div class="col-sm-12">
            <div class="col-sm-6 nopadding-left">
              <label class="tanggal_append">Tanggal : {{ carbon\carbon::parse($minr)->format('d-m-Y') }} s/d {{ carbon\carbon::parse($maxr)->format('d-m-Y') }}</label>
            </div>
            <div class="col-sm-6 nopadding-left">
              <label class="customer_append">Customer : {{ $customerr->nama or $customerr}}</label>
            </div>
            <div class="col-sm-6 nopadding-left">
              <label class="akun_append">Akun Piutang : {{ $akunr->nama_akun or $akunr}}</label>
            </div>
            <div class="col-sm-6 nopadding-left">
              <label class="cabang_append">Cabang : {{ $cabangr->nama or $cabangr}}</label>
            </div>
          </div>
          <div class="drop col-sm-12">
              
          </div><!-- /.box-body -->
        </div>
      {{-- </div> --}}
    {{-- </div> --}}
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
                  <option value="all">Semua Customer</option>
                  @foreach ($customer as $e)
                    <option value="{{ $e->kode }}">{{ $e->kode }} - {{ $e->nama }}</option>
                  @endforeach
                </select>
              </td>
            </tr>
            <tr>
              <td>Acc Piutang</td>
              <td>
                <select class="chosen-select-width form-control" name="akun" id="akun">
                  <option value="all">Semua Piutang</option>
                  @foreach ($piutang as $piu)
                    <option value="{{ $piu->id_akun }}">{{ $piu->id_akun }} - {{ $piu->nama_akun }}</option>
                  @endforeach
                </select>
              </td>
            </tr>
            <tr>
              <td>Cabang</td>
              @if (Auth::user()->punyaAkses('Laporan Penjualan','cabang'))
               <td>
                <select class="chosen-select-width form-control" name="cabang" id="cabang">
                  <option value="all">Semua Cabang</option>
                  @foreach ($cabang as $cab)
                    <option value="{{ $cab->kode }}">{{ $cab->nama }}</option>
                  @endforeach
                </select>
               </td>
               @else
               <td class="disabled">
                  <select class="chosen-select-width form-control" name="cabang" id="cabang">
                    <option value="all">Semua Cabang</option>
                    @foreach ($cabang as $cab)
                      <option @if (Auth::user()->kode_cabang == $cab->kode)
                        selected="" 
                      @endif value="{{ $cab->kode }}">{{ $cab->nama }}</option>
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


$(document).ready(function(){
  cari();
})


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

$('.date').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
});

$('#cabang').change(function(){
  $.ajax({
    data:$('#search').serialize(),
    type:'get',
    url: baseUrl + '/laporan_sales/analisa_piutang/piutang_dropdown',
    success : function(data){
      $('#akun').empty();
      for (var i = 0; i < data.piutang.length; i++) {
        $('#akun').append("<option value='all'>- Semua - Piutang -</option>");
        $('#akun').append("<option value='"+data.piutang[i].id_akun+"'>"+data.piutang[i].id_akun+'-'+data.piutang[i].nama_akun+"</option>");
        $('#akun').chosen().trigger("chosen:updated");
      }
    }
  })
})

function cari(){
  var min = $('.min').val();
  var cabang = $('#cabang').val();
  var max = $('.max').val();
  var customer = $('#customer').val();
  var customer_t = $('#customer option:selected').text();
  var customer = $('#customer ').val();
  var akun = $('#akun').val();
  var akun_t = $('#akun option:selected').text();
  var cabang_t = $('#cabang option:selected').text();
  var laporan = $('#laporan').val();


    $('.drop').html('<div class="loader"></div>');
    $('.modal').modal('hide');
    $.ajax({
      data:{min,max,customer,akun,laporan,cabang},
      type:'get',
      url: '{{ url('/laporan_sales/analisa_piutang/ajax_lap_analisa_piutang') }}',
      success : function(data){
        $('.drop').html(data);
        $('.cabang').addClass('hide');
        $('.customer').addClass('hide');
        $('.akun').addClass('hide');

        $('.tanggal_append').html('Tanggal : '+min+' s/d '+max);
        $('.cabang_append').html('Cabang : '+cabang_t);
        $('.akun_append').html('Akun Piutang : '+akun_t);
        $('.customer_append').html('Customer : '+customer_t);
        $('.rekap').html('REKAP '+laporan);
      },error:function(){
        $('.drop').html('<div class="auto"><h1 align="center">Oops, Terlalu Banyak Data. Coba Gunakan Fitur Filter<h1></div>');
      }
    })

}

$('.filter').click(function(){
  $('.modal').modal('show');
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
</script>
</html>
