@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
  .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Kartu Hutang </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Laporan Purchase </a>
                        </li>
                        <li class="active">
                            <strong> Kartu Hutang </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Laporan Kartu Hutang
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    
                <div class="box-body">
                 
                {{-- <h3 style="text-align: center"> PT JAWA PRATAMA MANDIRI  <br> JL. KARAH AGUNG NO 45 SURABAYA
                </h3> --}}
                <form id="save_data">
                <div class="col-sm-8">
                  <table class="table" width="80%">
                    <tr>
                      <td>Awal</td>
                      <td><input type="text" name="min" id="min" class="form-control datepicker_date input-sm" value="2018-07-01"></td>
                    </tr>
                    <tr>
                      <td>Akir</td>
                      <td><input type="text" name="max" id="max" class="form-control datepicker_date input-sm" value="2018-07-31"></td>
                    </tr>
                    <tr>
                      <td>Laporan</td>
                      <td>
                          <select class="chosen-select-width input-sm" name="laporan" id="laporan">
                            <option  value="">- Pilih -</option>
                            <option selected value="Rekap per Supplier">Rekap per Supplier</option>
                            <option value="Rekap per Supplier Detail">Rekap per Supplier Detail</option>
                            <option value="Rekap per akun">Rekap per akun</option>
                            <option value="Rekap per akun Detail">Rekap per akun Detail</option>
                      </td>
                    </tr>
                    <tr>
                      <td>Supplier</td>
                      <td>
                          <select class="chosen-select-width" name="supplier" id="supplier">
                              <option value="">- Pilih -</option>
                              @foreach ($supplier as $element)
                                <option value="{{ $element->no_supplier }}" data-name="{{ $element->nama_supplier }}" data-id="{{ $element->idsup }}">{{ $element->no_supplier }} - {{ $element->nama_supplier }}</option>
                              @endforeach
                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td>Cabang</td>
                      <td>
                          <select class="chosen-select-width input-sm" name="cabang" id="cabang">
                              <option value="">- Pilih -</option>
                              @foreach ($cabang as $cabang)
                                <option value="{{ $cabang->kode }}">{{ $cabang->kode }} - {{ $cabang->nama }}</option>
                              @endforeach
                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td>Akun</td>
                      <td>
                          <select class="chosen-select-width input-sm" name="akun" id="akun">
                              <option value="">- Pilih -</option>
                              @foreach ($akun as $akun)
                                <option value="{{ $akun->id_akun }}">{{ $akun->id_akun }} - {{ $akun->nama_akun }}</option>
                              @endforeach
                          </select>
                      </td>
                    </tr>
                    <input type="hidden" name="supplier_name" id="supplier_name">
                    <input type="hidden" name="supplier_id" id="supplier_id">
                  </table>
                </div>
                </form>
                  <div class="row"> &nbsp; &nbsp; 
                    <a class="btn btn-info" onclick="cari()">
                      <i class="fa fa-search" aria-hidden="true"></i> Cari </a> 
                  </div>
                  
                  <div class="row"> &nbsp; &nbsp; 
                    <a class="btn btn-info" onclick="cetak()">
                      <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> 
                  </div>
                  <div id="drop">
                    
                  </div>
                  <table id="datatable" class="table table-bordered table-striped" >
                    <thead>
                      
                    </thead>
                    <tbody >
                    {{--  @foreach ($data['data'] as $index => $element)
                       <tr>
                         <td>{{ $index+1 }}</td>
                         <td>{{ $element->tgl }}</td>
                         <td>{{ $element->nota }}</td>
                         @if ($element->keterangan == null)
                            <td>{{ $element->keterangan }}</td>
                         @else
                            <td>{{ $element->keterangan }}</td>
                         @endif
                         
                         @if ($element->flag == 'D')
                            <td>{{ $element->debet }}</td>
                            <td>0</td>
                         @else
                            <td>0</td>
                            <td>{{ $element->kredit }}</td>
                         @endif
                         
                         <td>{{ $element->flag }}</td>
                       </tr>
                     @endforeach --}}
                    </tbody>
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


@endsection



@section('extra_scripts')
<script type="text/javascript">

$('#supplier').change(function(){
  $('#supplier_name').val($(this).find(':selected').data('name'));
  $('#supplier_id').val($(this).find(':selected').data('id'));

})
// $('#datatable').DataTable({
//             responsive: true,
//             searching: true,
//             //paging: false,
//             "pageLength": 10,
//             "language": dataTableLanguage,
//     });

/*  function cari() {
      $.ajax({
            type: "GET",
            data : $('#save_data').serialize(),
            url : ('{{ route('carikartuhutang_perakun') }}'),
            success: function(data)
            {   
              
            }
      })
  }
*/
 function cari(){

  var awal = $('#min').val();
  var akir = $('#max').val();
  var customer = $('#customer').val();
  var akun = $('#akun').val();
  var cabang = $('#akun').val();
  var laporan = $('#laporan').val();
  var supplier = $('#supplier').val();

   if (laporan == 'Rekap per Supplier') {
      $.ajax({
            type: "GET",
            data : $('#save_data').serialize(),
            url : ('{{ route('carikartuhutang_persupplier') }}'),
            success: function(data)
            {   
                $('#drop').html(data);
                $('.saldo').each(function(i){
                   var saldo_index = $('.saldo_'+i).val();
                   $('.debet_'+i).each(function(a){ 
                      saldo_index = parseFloat(saldo_index) + parseFloat($(this).val()) - parseFloat($('.kredit_'+i).eq(a).val());
                      var parent = $(this).parents('tr');
                      $(parent).find('.total').text(accounting.formatMoney(saldo_index,"",0,'.',','));
                   })    
                   $('.grand_'+i).text(accounting.formatMoney(saldo_index,"",0,'.',','));
                })
            }
      })


   }else if (laporan == 'Rekap per Supplier Detail') {
     $.ajax({
            type: "GET",
            data : $('#save_data').serialize(),
            url : ('{{ route('carikartuhutang_persupplier_detail') }}'),
            success: function(data)
            {   
                $('#drop').html(data);
                $('.saldo').each(function(i){
                   var saldo_index = $('.saldo_'+i).val();
                  
                   $('.hutangbaru_'+i).each(function(a){ 
                      saldo_index = parseFloat(saldo_index) + parseFloat($(this).val()) 
                      + parseFloat($('.vc_'+i).val())
                      + parseFloat($('.cn_'+i).val())
                      - parseFloat($('.k_'+i).val())
                      - parseFloat($('.bg_'+i).val())
                      - parseFloat($('.rn_'+i).val())
                      - parseFloat($('.dn_'+i).val());
                      var parent = $(this).parents('tr');
                      $(parent).find('.total').text(accounting.formatMoney(saldo_index,"",0,'.',','));
                   })    
                   var hutangbaru = 0;
                   $('.hutangbaru_'+i).each(function(h){
                       hutangbaru += parseFloat($(this).val());
                   })

                   var vc = 0;
                   $('.vc_'+i).each(function(l){
                       vc += parseFloat($('.vc_'+i).val());
                   })

                   var cn = 0;
                   $('.cn_'+i).each(function(l){
                       cn += parseFloat($('.cn_'+i).val());
                   })

                   var k = 0;
                   $('.k_'+i).each(function(l){
                       k += parseFloat($('.k_'+i).val());
                   })

                   var bg = 0;
                   $('.bg_'+i).each(function(l){
                       bg += parseFloat($('.bg_'+i).val());
                   })

                   var rn = 0;
                   $('.rn_'+i).each(function(l){
                       rn += parseFloat($('.rn_'+i).val());
                   })

                   var dn = 0;
                   $('.dn_'+i).each(function(l){
                       dn += parseFloat($('.dn_'+i).val());
                   })


                   $('.hut_baru_'+i).text(accounting.formatMoney(hutangbaru,"",0,'.',','));
                   $('.hut_voc_'+i).text(accounting.formatMoney(vc,"",0,'.',','));
                   $('.not_kredit_'+i).text(accounting.formatMoney(cn,"",0,'.',','));
                   $('.b_cash_'+i).text(accounting.formatMoney(k,"",0,'.',','));
                   $('.cek_bg_'+i).text(accounting.formatMoney(bg,"",0,'.',','));
                   $('.return_beli_'+i).text(accounting.formatMoney(rn,"",0,'.',','));
                   $('.no_debet_'+i).text(accounting.formatMoney(dn,"",0,'.',','));
                   $('.grand_'+i).text(accounting.formatMoney(saldo_index,"",0,'.',','));
                })
            }
      })
   }else if (laporan == 'Rekap per akun') {
      $.ajax({
            type: "GET",
            data : $('#save_data').serialize(),
            url : ('{{ route('carikartuhutang_perakun') }}'),
            success: function(data)
            {   
                $('#drop').html(data);
            }
      })
   }else if (laporan == 'Rekap per akun Detail') {

    alert('d');
   }
     
 }

</script>
@endsection




{{-- 
ANALISA
<table id="addColumn" class="table table-bordered table-striped tbl-item">
<thead>
 <tr >
    <th align="center" rowspan="2">No.</th>
    <th align="center" colspan="2">Supplier</th>
    <th align="center" rowspan="2">Saldo Awal</th>
    <th align="center" colspan="3">MUTASI KREDIT</th>
    <th align="center" colspan="3">MUTASI DEBET</th>
    <th align="center" rowspan="2">Saldo Akir.</th>
    <th align="center" rowspan="2">Sisa Uang Muka.</th> 
</tr>
<tr>
  <th>Kode</th>
  <th>Nama</th>
  <th>Hutang Baru</th>
  <th>Hutang Voucher</th>
  <th>Nota Kredit</th>
  <th>Bayar Cash</th>
  <th>Byr Uang Muka</th>
  <th>Cek/Bg/Trans</th>
</tr>

</thead>

<tbody>
 
</tbody>

</table> --}}