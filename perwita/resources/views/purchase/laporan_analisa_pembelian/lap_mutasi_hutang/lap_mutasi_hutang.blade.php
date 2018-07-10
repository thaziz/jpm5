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
                    <table class="table datatable ">
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
                        <td>Supplier</td>
                        <td>
                          <select class="chosen-select-width" name="supplier" id="supplier">
                            <option value="">- Pilih -</option>
                            @foreach ($supplier as $e)
                              <option value="{{ $e->no_supplier }}">{{ $e->no_supplier }} - {{ $e->nama_supplier }}</option>
                            @endforeach
                          </select>
                        </td>
                      
                        <td>Acc Piutang</td>
                        <td>
                          <select class="chosen-select-width" name="akun" id="akun">
                            <option value="">- Pilih -</option>
                            @foreach ($piutang as $piu)
                              <option value="{{ $piu->id_akun }}">{{ $piu->id_akun }} - {{ $piu->nama_akun }}</option>
                            @endforeach
                          </select>
                        </td>
                      </tr>
                      <tr>  
                      <td>Laporan</td>
                        <td>
                          <select class="chosen-select-width" name="laporan" id="laporan" style="pointer-events: none">
                            <option value="mutasi" selected="">Mutasi Hutang</option>
                            <option value="mutasi_detail" selected="">Mutasi Hutang Detail</option>
                          </select>
                        </td>

                       <td>Cabang</td>
                        <td>
                          <select class="chosen-select-width" name="cabang" id="cabang">
                            <option value="">- Pilih -</option>
                            @foreach ($cabang as $cab)
                              <option value="{{ $cab->kode }}">{{ $cab->kode }} - {{ $cab->nama }}</option>
                            @endforeach
                          </select>
                        </td>
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



 function cari(){

  var awal = $('#min').val();
  var akir = $('#max').val();
  var supplier = $('#supplier').val();
  var akun = $('#akun').val();
  var laporan = $('#laporan').val();

if (laporan == 'mutasi_detail') {
   
    $.ajax({
      data:$('#search').serialize(),
      type:'get',
      url:("{{ route('cari_ajax_mutasi_hutang_detail') }}"),
      success : function(data){
         
        $('#disini').html(data);
        $('#container').hide();

             
      }
    });


 }else if (laporan == 'mutasi') {
    $.ajax({
      data:$('#search').serialize(),
      type:'get',
      url:("{{ route('cari_ajax_mutasi_hutang') }}"),
      success : function(data){
         
        $('#disini').html(data);
        $('#container').hide();

          //saldo awal
          var saldoawal = 0;
          $('.saldoawal').each(function(){
            var this_val_saldoawal = $('.saldoawal').val();
            var hasil_saldoawal = parseFloat(this_val_saldoawal);
            saldoawal += hasil_saldoawal;
          })
          $('.output_saldoawal').text(accounting.formatMoney(saldoawal,"",0,'.',','));

          //hutang baru
          var hutangbaru = 0;
          $('.hutangbaru').each(function(){
            var this_val_hutangbaru = $('.hutangbaru').val();
            var hasil_hutangbaru = parseFloat(this_val_hutangbaru);
            hutangbaru += hasil_hutangbaru;
          })
          $('.output_hutangbaru').text(accounting.formatMoney(hutangbaru,"",0,'.',','));

          //hutang voucher
          var voucherhutang = 0;
          $('.voucherhutang').each(function(){
            var this_val_voucherhutang = $('.voucherhutang').val();
            var hasil_voucherhutang = parseFloat(this_val_voucherhutang);
            voucherhutang += hasil_voucherhutang;
          })
          $('.output_voucherhutang').text(accounting.formatMoney(voucherhutang,"",0,'.',','));

          //hutang nota kredit
          var creditnota = 0;
          $('.creditnota').each(function(){
            var this_val_creditnota = $('.creditnota').val();
            var hasil_creditnota = parseFloat(this_val_creditnota);
            creditnota += hasil_creditnota;
          })
          $('.output_creditnota').text(accounting.formatMoney(creditnota,"",0,'.',','));

          //byr cash
          var cash = 0;
          $('.cash').each(function(){
            var this_val_cash = $('.cash').val();
            var hasil_cash = parseFloat(this_val_cash);
            cash += hasil_cash;
          })
          $('.output_cash').text(accounting.formatMoney(cash,"",0,'.',','));

          //uangmuka
          var uangmuka = 0;
          $('.uangmuka').each(function(){
            var this_val_uangmuka = $('.uangmuka').val();
            var hasil_uangmuka = parseFloat(this_val_uangmuka);
            uangmuka += hasil_uangmuka;
          })
          $('.output_uangmuka').text(accounting.formatMoney(uangmuka,"",0,'.',','));

          //bg
          var bg = 0;
          $('.bg').each(function(){
            var this_val_bg = $('.bg').val();
            var hasil_bg = parseFloat(this_val_bg);
            bg += hasil_bg;
          })
          $('.output_bg').text(accounting.formatMoney(bg,"",0,'.',','));

          //rn
          var rn = 0;
          $('.rn').each(function(){
            var this_val_rn = $('.rn').val();
            var hasil_rn = parseFloat(this_val_rn);
            rn += hasil_rn;
          })
          $('.output_rn').text(accounting.formatMoney(rn,"",0,'.',','));

          //debitnota
          var debitnota = 0;
          $('.debitnota').each(function(){
            var this_val_debitnota = $('.debitnota').val();
            var hasil_debitnota = parseFloat(this_val_debitnota);
            debitnota += hasil_debitnota;
          })
          $('.output_debitnota').text(accounting.formatMoney(debitnota,"",0,'.',','));

          //saldoakhir
          var saldoakhir = 0;
          $('.saldoakhir').each(function(){
            var this_val_saldoakhir = $('.saldoakhir').val();
            var hasil_saldoakhir = parseFloat(this_val_saldoakhir);
            saldoakhir += hasil_saldoakhir;
          })
          $('.output_saldoakhir').text(accounting.formatMoney(saldoakhir,"",0,'.',','));

          //sisaum
          var sisaum = 0;
          $('.sisaum').each(function(){
            var this_val_sisaum = $('.sisaum').val();
            var hasil_sisaum = parseFloat(this_val_sisaum);
            sisaum += hasil_sisaum;
          })
          $('.output_sisaum').text(accounting.formatMoney(sisaum,"",0,'.',','));
        } 
      })
    }
 }



 
</script>
@endsection
