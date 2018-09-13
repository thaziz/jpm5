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
            <h2 class="black"><b>ANALISA PIUTANG</b></h2>
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
          <div class="drop col-sm-12">
              
          </div><!-- /.box-body -->
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
                  <option value="all">- Semua Customer -</option>
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
                  <option value="all">- Semua Piutang -</option>
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
                  <option value="all">- Semua Cabang -</option>
                  @foreach ($cabang as $cab)
                    <option value="{{ $cab->kode }}">{{ $cab->kode }} - {{ $cab->nama }}</option>
                  @endforeach
                </select>
               </td>
               @else
               <td class="disabled">
                  <select class="chosen-select-width form-control" name="cabang" id="cabang">
                    <option value="all">- Semua Cabang -</option>
                    @foreach ($cabang as $cab)
                      <option value="{{ $cab->kode }}">{{ $cab->kode }} - {{ $cab->nama }}</option>
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
$(document).ready(function(){
  cari();
  console.log('tes');
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
  var akun = $('#akun').val();
  var laporan = $('#laporan').val();


    $.ajax({
      data:{min,max,customer,akun,laporan,cabang},
      type:'get',
      url: '{{ url('/laporan_sales/analisa_piutang/ajax_lap_analisa_piutang') }}',
      success : function(data){
        $('.drop').html(data);
        // $('#container').hide();
      }
    })
  
}

$('.filter').click(function(){
  $('.modal').modal('show');
})
</script>
</html>
