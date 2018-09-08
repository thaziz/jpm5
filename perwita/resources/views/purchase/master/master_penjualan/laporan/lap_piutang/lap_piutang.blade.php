@extends('main')

@section('tittle','dashboard')

@section('content')

<style type="text/css">
    .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
  .dataTables_filter, .dataTables_info { display: none; }
  .saldo{
    border: none;
    background-color: #e6ffda;
    color: #676a6c;
  }
  #total_debet{
    border: none;
    color: #676a6c;
  }
  #total_kredit{
    border: none;
    color: #676a6c;
  }
  #total_total{
    border: none;
    color: #676a6c;
  }
  .btn-special{
    background-color: #6d2db3;
    border-color: #6d2db3;
    color: #FFFFFF;
  }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> KARTU PIUTANG
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
                  <form class="form-horizontal" id="search" action="post" method="POST">
                  <div class="box-body">
                    <table class="table datatable ">
                        <tr>
                        <td> Dimulai : </td> 
                        <td> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input name="min" id="min" type="text" class=" date form-control date_to date_range_filter
                                date" value="{{ carbon\carbon::now()->startOfMonth()->format('Y-m-d') }}">
                          </div> 
                        </td>  
                        <td> Diakhiri : </td> 
                        <td> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class=" date form-control date_to date_range_filter
                                date" name="max" id="max"  value="{{ carbon\carbon::now()->format('Y-m-d')}}">
                          </div> 
                        </td>
                      </tr>
                      <tr>
                        <td>Customer</td>
                        <td>
                          <select class="chosen-select-width customer" name="customer" id="customer">
                            <option value="0">- Semua Customer -</option>
                            @foreach ($customer as $e)
                              <option  value="{{ $e->kode }}">{{ $e->kode }} - {{ $e->nama }}</option>
                            @endforeach
                          </select>
                        </td>
                        <td>Acc Piutang</td>
                        <td>
                          <select class="chosen-select-width" name="akun" id="akun">
                            <option value="0">- Semua Piutang -</option>
                            @foreach ($piutang as $piu)
                              <option value="{{ $piu->id_akun }}">{{ $piu->id_akun }} - {{ $piu->nama_akun }}</option>
                            @endforeach
                          </select>
                        </td>
                      </tr>
                      <tr>  
                      <td>Laporan</td>
                        <td>
                          <select class="chosen-select-width" name="laporan" id="laporan">
                            <option value="hirarki">- Hirarki -</option>
                            <option value="customer">- customer -</option>
                            <option value="akun">- akun -</option>
                            <option value="invoice">- invoice -</option>
                          </select>
                        </td>
                       <td>Cabang</td>
                       @if (Auth::user()->punyaAkses('Laporan Penjualan','cabang'))
                       <td>
                        <select class="chosen-select-width" name="cabang" id="cabang">
                          <option value="0">- Semua Cabang -</option>
                          @foreach ($cabang as $cab)
                            <option value="{{ $cab->kode }}">{{ $cab->kode }} - {{ $cab->nama }}</option>
                          @endforeach
                        </select>
                       </td>
                       @else
                       <td class="disabled">
                          <select class="chosen-select-width" name="cabang" id="cabang">
                            <option value="0">- Semua Cabang -</option>
                            @foreach ($cabang as $cab)
                              <option value="{{ $cab->kode }}">{{ $cab->kode }} - {{ $cab->nama }}</option>
                            @endforeach
                          </select>
                        </td>
                       @endif
                      </tr>
                      <br>
                      </table>
                       <div class="row" style="margin-top: 20px;"> &nbsp; &nbsp; <a class="btn btn-special cetak" onclick="cari()"> <i class="fa fa-search" aria-hidden="true"></i> Cari </a> </div>
                      <div class="row" style="margin-top: -39px;margin-left: 55px;"> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="pdf()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>
                      <div class="row" style="margin-top: -39px;margin-left: 136px;"> &nbsp; &nbsp; <a class="btn btn-warning cetak" onclick="excel()"> <i class="fa fa-print" aria-hidden="true"></i> Excel </a> </div>
                    </div>
                </form>
                <div class="box-body">
                <div id="disini">

                  </div>
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

$('.date').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
});
       


function cetak(){
  var asw=[];
   var asd = table.rows( { filter : 'applied'} ).data(); 
   for(var i = 0 ; i < asd.length; i++){

       asw[i] =  $(asd[i][0]).val();

   }

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


  $.ajax({
    data: {a:asw,c:'download'},
    url: baseUrl + '/reportkwitansi/reportkwitansi',
    type: "post",
   success : function(data){
    var win = window.open();
        win.document.write(data);
    }
  });
}


function cari() {
  var min       = $('#min').val();
  var max       = $('#max').val();
  var customer  = $('#customer').val();
  var akun      = $('#akun').val();
  var cabang    = $('#cabang').val();
  var jenis     = $('#laporan').val();

  window.open('{{ url('cari_kartupiutang/cari_kartupiutang') }}?min='+min+'&max='+max+'&customer='+customer+'&akun='+akun+'&cabang='+cabang+'&jenis='+jenis);
}

</script>
@endsection
