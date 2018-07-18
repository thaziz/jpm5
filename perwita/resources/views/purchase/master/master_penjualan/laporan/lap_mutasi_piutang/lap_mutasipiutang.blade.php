@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
  .br{
    border:none;
  }
  th{
        text-align: center !important;
      }

  .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
  .dataTables_filter, .dataTables_info { display: none; }
    .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
  .btn-special{
    background-color: #6d2db3;
    border-color: #6d2db3;
    color: #FFFFFF;
  }
</style>
  <meta name="csrf-token" content="{{ csrf_token() }}" /> 

<div class="return">
  {{ csrf_field() }}

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Laporan Tarif Dokumen
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    
                <div class="col-xs-12">

                 
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
                        <td>Customer</td>
                        <td>
                          <select class="chosen-select-width" name="customer" id="customer">
                            <option value="">- Pilih -</option>
                            @foreach ($customer as $e)
                              <option value="{{ $e->kode }}">{{ $e->kode }} - {{ $e->nama }}</option>
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
                          <select class="chosen-select-width" name="laporan" id="laporan">
                            <option value="">- Pilih -</option>
                            <option value="Rekap">Rekap </option>
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

                </div>


                <div class="box-body">
                    <br>
                    <br>
                    <br>
                    <br>
                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                       <tr>
                          <th align="center" rowspan="2" > No</th>
                          <th align="center" colspan="2"> Customer</th>
                          <th align="center" rowspan="2"> Saldo Awal</th>
                          <th align="center" colspan="2"> DEBET</th>
                          <th align="center" colspan="4"> Kota Tujuan</th>
                          <th align="center" rowspan="2"> Saldo Akir</th>
                          <th align="center" rowspan="2"> Sisa Uangmuka </th>
                      </tr> 
                      <tr>
                          <th>Kode</th>
                          <th>Nama</th>
                          <th>Piutang Baru</th>
                          <th>Nota Debet</th>
                          <th>Byr Cash</th>
                          <th>Byr.Cek/BG/Trans</th>
                          <th>Byr Uang Muka</th>
                          <th>Nota Kredit</th>
                      </tr>       
                    </thead>        
                    <div class="drop">
                      
                    </div>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  
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
</div>

@endsection



@section('extra_scripts')
<script type="text/javascript">


    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
    });
    
      function cari(){

      var awal = $('#min').val();
      var akir = $('#max').val();
      var customer = $('#customer').val();
      var akun = $('#akun').val();
      var laporan = $('#laporan').val();

     if (laporan == 'Rekap') {

       $.ajax({
          data:$('#search').serialize(),
          type:'get',
          url: baseUrl + '/laporan_sales/ajax_mutasipiutang_rekap/ajax_mutasipiutang_rekap',
          success : function(data){
            $('.drop').html(data);
            $('#container').hide();

            // $('.saldo').each(function(i){
            //     var saldo_index = $('.saldo_'+i).val();

            //     $('.debet_'+i).each(function(a){ 
            //       saldo_index = parseFloat(saldo_index) + parseFloat($(this).val()) - parseFloat($('.kredit_'+i).val());

            //       console.log(parseFloat($('.kredit_'+0).val()));
            //       console.log(i); 
            //       var parent = $(this).parents('tr');
            //       $(parent).find('.total').text(accounting.formatMoney(saldo_index,"",0,'.',','));
            //     })  
            // })
          }
        })
     }else if (laporan == 'Rekap per Customer Detail') {
      alert('b');
     }else if (laporan == 'Rekap per akun') {

      alert('c');
     }else if (laporan == 'Rekap per akun Detail') {

      // alert('d');
     }
        
     }

  
</script>
@endsection
