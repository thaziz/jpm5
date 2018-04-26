@extends('main')

@section('tittle','dashboard')

@section('content')

<style type="text/css">
    .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
   #container {
    height: 400px; 
    min-width: 310px; 
    max-width: 100%;
    margin: 0 auto;
}
.highcharts-color-0{
  color:red;
}

  .dataTables_filter, .dataTables_info { display: none; }

</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Laporan INVOICE
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
               <div class="form-row">
                <div class="form-group col-md-2">
                  <input type="text" class="date form-control" readonly="" id="date_awal" name="">
                </div>
                <div class="form-group col-md-2">
                  <input type="text" class="date form-control" readonly="" id="date_akir" name="">
                </div>
                <div class="form-group col-md-2">
                  <button  class="btn btn-info" onclick="cari()"> <i class="fa fa-search" aria-hidden="true"></i> Cari </button>
                </div>
                {{-- <div class="form-group col-md-2 pull-right">
                  <button  class="btn btn-info" onclick="reresh()"> <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Reload </button>
                </div> --}}
              </div> 
              <h3 id="replace" align="center"></h3> 
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                    <table class="table " style="margin-top: 100px;">
                         <tr>
                        <td> Dimulai : </td> <td> <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input name="min" id="min" type="text" class=" date form-control date_to date_range_filter
                                              date" onchange="tgl()">

                              </div> </td>  <td> Diakhiri : </td> <td> <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input type="text" class=" date form-control date_to date_range_filter
                                              date" name="max" id="max" onchange="tgl()" >
                              </div> </td>
                      </tr>
                        {{-- <tr>
                            <th style="width: 100px; padding-top: 16px"> Satuan </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" class="select-picker3 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn1()">
                            <option value="" disabled="" selected=""> --Pilih --</option>
                            @foreach ($sat as $sat)
                              <option value="{{ $sat->kode }}">{{ $sat->kode }} - {{ $sat->nama }}</option>
                            @endforeach
                           </select>
                          </td> --}}

                          <th style="width: 100px; padding-top: 16px"> Customer </th>
                          <td colspan="3"> 
                           <select style="width: 200px; margin-top: 20px;" class="select-picker5 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn2()">
                            <option selected="">- Pilih Customer -</option>
                            @foreach ($cus as $c)
                              <option value="{{ $c->kode }}" >{{ $c->kode }} - {{ $c->nama }}</option>
                            @endforeach
                           </select>
                          </td>
                        </tr>
                       
                      <br>
                      </table>
                      <div class="row" style="margin-top: 20px;"> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>
                    </div>
                </form>
                <div class="box-body">
                <table id="addColumn" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th> No Inv</th>
                            <th> Tanggal </th>
                            <th> Jatuh Tempo </th>
                            <th> Customer </th>
                            <th> Brutto </th>
                            <th> Diskon Do </th>
                            <th> Diskon Inv </th>
                            <th> PPN </th>
                            <th> PPH </th>
                            <th> Netto DPP </th>
                            <th> Netto detil</th>
                            <th> Total Tagihan </th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach (  $cust as $element)
                        <tr>
                          <td colspan="12">{{  $element->i_kode_customer}} - {{  $element->cus}}</td>
                        </tr>
                      @foreach ($data as $index =>$e)
                        <tr>
                          @if ($e->i_kode_customer == $element->i_kode_customer)
                        <td><input type="hidden" value="{{ $e->i_nomor }}" name="nomor">{{ $e->i_nomor }}</td>
                        <td>{{ $e->i_tanggal }}</td>
                        <td>{{ $e->i_jatuh_tempo }}</td>
                        <td>{{ $e->i_kode_customer }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_total }}" class="total_brutto" name="">{{ number_format($e->i_total,0,',','.') }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_diskon1 }}" class="total_diskondo" name="">{{ number_format($e->i_diskon1,0,',','.') }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_diskon2 }}" class="total_diskoninv" name="">{{ number_format($e->i_diskon2,0,',','.') }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_ppnrp }}" class="total_ppn" name="">{{ number_format($e->i_ppnrp,0,',','.') }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_pajak_lain }}" class="total_pajak_lain" name="">{{ number_format($e->i_pajak_lain,0,',','.') }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_netto }}" class="total_netto" name="">{{ number_format($e->i_netto,0,',','.') }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_netto_detail }}" class="total_netto_detil" name="">{{ number_format($e->i_netto_detail,0,',','.') }}</td>
                        <td align="right"><input type="hidden" value="{{ $e->i_total_tagihan }}" class="total_net" name=""> {{ number_format($e->i_total_tagihan,0,',','.') }}</td>
                        @endif
                        </tr>

                      @endforeach
                      
                    @endforeach
                      <tr align="right">
                        <th colspan="4">Total</th>
                        <td id="brutto_grandtotal"></td>
                        <td id="diskondo_grandtotal"></td>
                        <td id="diskoninv_grandtotal"></td>
                        <td id="ppn_grandtotal"></td>
                        <td id="pajaklain_grandtotal"></td>
                        <td id="netto_grandtotal"></td>
                        <td id="nettodetil_grandtotal"></td>
                        <td id="total_grandtotal"></td>
                      </tr>
                    </tbody>

                  </table>
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
        /*minViewMode:1,*/
    });

    var total = 0;
    $('.total_net').each(function(){
        var parents_net = parseInt($(this).val());
        total += parents_net;
    });
    $('#total_grandtotal').text(accounting.formatMoney(total,"",0,'.',','));

    var brutto = 0;
    $('.total_brutto').each(function(){
        var parents_brutto = parseInt($(this).val());
        brutto += parents_brutto;
    });
    $('#brutto_grandtotal').text(accounting.formatMoney(brutto,"",0,'.',','));

    var netto = 0;
    $('.total_netto_detil').each(function(){
        var parents_netto = parseInt($(this).val());
        netto += parents_netto;
    });
    $('#netto_grandtotal').text(accounting.formatMoney(netto,"",0,'.',','));

    var netto_detil = 0;
    $('.total_netto').each(function(){
        var parents_netto_detil = parseInt($(this).val());
        netto_detil += parents_netto_detil;
    });
    $('#nettodetil_grandtotal').text(accounting.formatMoney(netto_detil,"",0,'.',','));

     var ppn = 0;
    $('.total_ppn').each(function(){
        var parents_ppn = parseInt($(this).val());
        ppn += parents_ppn;
    });
    $('#ppn_grandtotal').text(accounting.formatMoney(ppn,"",0,'.',','));

     var diskon_do = 0;
    $('.total_diskondo').each(function(){
        var parents_diskon_do = parseInt($(this).val());
        diskon_do += parents_diskon_do;
    });
    $('#diskondo_grandtotal').text(accounting.formatMoney(diskon_do,"",0,'.',','));

     var diskon_inv = 0;
    $('.total_diskoninv').each(function(){
        var parents_diskon_inv = parseInt($(this).val());
        diskon_inv += parents_diskon_inv;
    });
    $('#diskoninv_grandtotal').text(accounting.formatMoney(diskon_inv,"",0,'.',','));

     var pajak_lain = 0;
    $('.total_pajak_lain').each(function(){
        var parents_pajak_lain = parseInt($(this).val());
        pajak_lain += parents_pajak_lain;
    });
    $('#pajaklain_grandtotal').text(accounting.formatMoney(pajak_lain,"",0,'.',','));

    console.log(netto_detil);
    console.log(netto);
    console.log(total);
    console.log(brutto);


    var d = new Date();
    var a = d.getDate();
    var b = d.getSeconds();
    var c = d.getMilliseconds();


    var table;
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
        url: baseUrl + '/reportinvoice/reportinvoice',
        type: "post",
       success : function(data){
        var win = window.open();
            win.document.write(data);
        }
      });
    }

    //reload 

    

    //chart 



   

//cari 



</script>
@endsection
