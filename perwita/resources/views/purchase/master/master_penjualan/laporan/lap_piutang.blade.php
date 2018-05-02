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
                    <h5> Laporan DO Koran
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
                    <table class="table table-bordered datatable table-striped">
                        <tr>
                        <td> Dimulai : </td> 
                        <td> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input name="min" id="min" type="text" class=" date form-control date_to date_range_filter
                                date">
                          </div> 
                        </td>  
                        <td> Diakhiri : </td> 
                        <td> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class=" date form-control date_to date_range_filter
                                date" name="max" id="max"  >
                          </div> 
                        </td>
                      </tr>
                      <tr>
                        <td>Customer</td>
                        <td>
                          <select class="chosen-select-width" name="customer" >
                            <option value="">- Customer -</option>
                            @foreach ($customer as $e)
                              <option value="{{ $e->kode }}">{{ $e->kode }} - {{ $e->nama }}</option>
                            @endforeach
                          </select>
                        </td>
                      </tr>
                      <br>
                      </table>
                      <div id="container" style="height: 400px"></div>
                      <div class="row" style="margin-top: 20px;"> &nbsp; &nbsp; <a class="btn btn-special cetak" onclick="cari()"> <i class="fa fa-search" aria-hidden="true"></i> Cari </a> </div>
                      <div class="row" style="margin-top: -39px;margin-left: 55px;"> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="pdf()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>
                      <div class="row" style="margin-top: -39px;margin-left: 136px;"> &nbsp; &nbsp; <a class="btn btn-warning cetak" onclick="excel()"> <i class="fa fa-print" aria-hidden="true"></i> Excel </a> </div>
                    </div>
                </form>
                <div class="box-body">
                <div id="disini"></div>
                <div id="hilang" style="background-color: red;">
                <table id="addColumn" class="table table-bordered table-striped" width="100%" >
                    <thead>
                        <tr>
                            <th width="10%"> Kode</th>
                            <th width="10%"> Tgl </th>
                            <th width="10%"> Keterangan </th>
                            <th width="10%"> Debet(+) </th>
                            <th width="10%"> Kredit(-) </th>
                            <th width="10%"> saldo </th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($data_i as $a => $element)
                         <tr>
                           <td colspan="6">{{ $data_i[$a]->i_kode_customer }}  - {{ $data_i[$a]->cnama }}</td>
                           <input type="hidden" name="" class="gege" value="{{ $data_i[$a]->i_kode_customer }}">
                         </tr>
                         @foreach ($data as $e => $element)
                        <tr style="text-align: right;background-color: #e6ffda;">
                              @if ($data_i[$a]->i_kode_customer == $data[$e]->cutomer)

                                      <td><input type="hidden" value="{{ $data[$e]->kode }}" name="nomor">{{ $data[$e]->kode }}</td>
                                      <td>{{ $data[$e]->tanggal }}</td>
                                      <td align="left">{{ $data[$e]->keterangan }}</td>
                                      <td align="right" > 
                                      @if ($data[$e]->flag == 'D' or substr($data[$e]->kode,0,3) == 'INV')
                                        {{ number_format($data[$e]->total,0,',','.') }}
                                        <input type="hidden" class="debet" value="{{ $data[$e]->total }}" name="">
                                      @else 
                                        0
                                        <input type="hidden" class="debet" value="0" name="">
                                      @endif
                                      </td>

                                      <td align="right"> 
                                      @if ($data[$e]->flag == 'K' or substr($data[$e]->kode,0,2) == 'KN' or substr($data[$e]->kode,0,3) == 'KWT' or substr($data[$e]->kode,0,3) == 'PST')
                                        <input type="hidden" class="kredit" value="{{ $data[$e]->total }}" name="">
                                        {{ number_format($data[$e]->total,0,',','.') }}
                                      @else 
                                        0
                                        <input type="hidden" class="kredit" value="0" name="">
                                      @endif
                                      </td>

                                      <td>
                                        <input type="text" name="" readonly="" class="saldo" style="text-align: right">
                                      </td>

                              @endif 
                        </tr>

                        @endforeach
                          <tr>
                            <td colspan="3">Total</td>
                            <td class="debet_perc" align="right"></td>
                            <td class="kredit_perc" align="right"></td>
                            <td class="total_perc" align="right"></td>
                          </tr>
                    @endforeach
                    <tr>
                          <th colspan="3" align="right">total</th>
                          <td><input type="text" id="total_debet" readonly="" name="" style="text-align: right;font-weight: bold;"></td>
                          <td><input type="text" id="total_kredit" readonly="" name="" style="text-align: right;font-weight: bold;"></td>
                          <td><input type="text" id="total_total" readonly="" name="" style="text-align: right;font-weight: bold;"></td>
                        </tr>
                    </tbody>

                  </table>
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
   
    var d = new Date();
    var a = d.getDate();
    var b = d.getSeconds();
    var c = d.getMilliseconds();


    var table;
  
    

   var awal = 0;
  $('.debet').each(function(){
    var total = parseInt($(this).val());
    awal += total;
    // console.log(awal);
  });
  $('#total_debet').val(accounting.formatMoney(awal,"",0,'.',','));

  var kred = 0;
  $('.kredit').each(function(){
    var total = parseInt($(this).val());
    kred += total;
    // console.log(kred);
  });
  $('#total_kredit').val(accounting.formatMoney(kred,"",0,'.',','));


  var saldo = 0;
  $('.debet').each(function(){
    var par = $(this).parents('tr');
    var kredit = $(par).find('.kredit').val();
    var hasil = $(this).val() - kredit;
    saldo += hasil;
    $(par).find('.saldo').val(accounting.formatMoney(saldo,"",0,'.',','));
  })
  $('#total_total').val(accounting.formatMoney(saldo,"",0,'.',','));



     $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm',
        minViewMode:1,
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


Highcharts.chart('container', {
    chart: {
        type: 'column',
        width: 1000
    },
    title: {
        text: 'Total Piutang Seluruh cutomer'
    },

    xAxis: {
        categories: ['Saldo'],
                
    },
    plotOptions:{
      series:{
        pointWidth:40
      }
    },
    series: [{
        data: [saldo]
    }]
});

 function cari(){
    $.ajax({
      data:$('#search').serialize(),
      type:'get',
      url:baseUrl + '/cari_kartupiutang/cari_kartupiutang',
      success : function(data){
        
        $('#disini').html(data);

      }
    })
 }
</script>
@endsection
