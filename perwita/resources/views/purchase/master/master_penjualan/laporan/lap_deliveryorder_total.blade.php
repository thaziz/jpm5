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
  .dataTables_filter, .dataTables_info { display: none; }
  .details-control {
        background: url('{{ asset('assets/img/details_open.png') }}') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('{{ asset('assets/img/details_close.png') }}') no-repeat center center;
    }
    .redline {
      background-color: red;
      color: white; 
    }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Laporan Delivery order paket
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
                  <form class="form-horizontal" id="cari_data">
                  <div class="box-body">
                    <table class="table datatable" border="0">
                         <tr>
                        <td> Dimulai : </td> <td> <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input name="min" id="min" type="text" class="cari_semua date form-control date_to date_range_filter
                                              date" >

                              </div> </td>  <td> Diakhiri : </td> <td> <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input type="text" class="cari_semua date form-control date_to date_range_filter
                                              date" name="max" id="max"  >
                              </div> </td>
                      </tr>
                    
                      <tr>

                          <th style="width: 100px; padding-top: 16px"> Laporan </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" name="laporan" class="cari_semua laporan chosen-select-width form-control" data-show-subtext="true" data-live-search="true" >
                            <option value=""  selected=""> --Laporan--</option>
                            <option value="DEFAULT">MASTER</option>
                            <option value="MASTER DETAIL">DO DETAIL</option>
                            <option value="rekap">REKAP CUSTOMER</option>
                            <option value="rekap_detail">REKAP CUSTOMER DETIL</option>
                            <option value="REKAP BULANAN">REKAP BULANAN</option>
                            <option value="DETAIL PER NOPOL">DETAIL PER NOPOL</option>
                            <option value="DETAIL PER MOBIL">DETAIL PER MOBIL</option>
                            <option value="DETAIL PER SOPIR" class="redline">DETAIL PER SOPIR</option>
                            <option value="DETAIL PER SALES" class="redline">DETAIL PER SALES</option>
                            <option value="REKAP PER MOBIL" class="redline">REKAP PER MOBIL</option>
                            <option value="REKAP PER SOPIR" class="redline">REKAP PER SOPIR</option>
                            <option value="REKAP PER SALES" class="redline">REKAP PER SALES</option>
                           </select>
                          </td>

                          <th style="width: 100px; padding-top: 16px"> Kota Asal  </th>
                          <td >
                          <select style="width: 200px; margin-top: 20px;" name="asal" class="cari_semua chosen-select-width select-picker1 form-control" data-show-subtext="true" data-live-search="true"  id="kota_asal">
                            <option value=""  selected=""> --Asal --</option>
                            @foreach ($kota1 as $asal)
                                <option value="{{ $asal->id }}">{{ $asal->asal }}</option>
                            @endforeach
                          </select>
                          </td>

                        </tr>       
                        <tr>
                          

                          <th style="width: 100px; padding-top: 16px"> Pendapatan </th>
                          <td > 
                           <select  name="pendapatan" class="cari_semua select-picker3  form-control" data-show-subtext="true" data-live-search="true" >
                            <option value=""  selected=""> --Pendapatan --</option>
                            <option value="PAKET">PAKET</option>
                            <option value="KORAN">KORAN</option>
                            <option value="KARGO">KARGO</option>
                           </select>
                          </td>

                          <th style="width: 100px; padding-top: 16px"> Kota Tujuan </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" name="tujuan" class="cari_semua select-picker2 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" id="kota_tujuan" >
                            <option value=""  selected=""> --Tujuan --</option>
                            @foreach ($kota as $tujuan)
                                <option value="{{ $tujuan->id }}">{{ $tujuan->tujuan }}</option>
                            @endforeach
                           </select>
                          </td>

                           
                        </tr>
                        <tr >
                          <th style="width: 100px; padding-top: 16px">Cabang</th>
                          <td colspan="1">
                            <select class="cari_semua chosen-select-width" id="cabang"  name="cabang">
                              <option></option>
                              @foreach ($cabang as $element)
                                <option value="{{ $element->kode }}">{{ $element->kode }} - {{ $element->nama }}</option>
                              @endforeach
                            </select>
                          </td>
                        
                        <th style="width: 100px; padding-top: 16px"> Status </th>
                          <td colspan="3"> 
                           <select style="width: 200px; margin-top: 20px;" name="status" class="cari_semua select-picker5 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" id="status"  >
                            <option value=""  selected=""> --Status --</option>
                            <option value="MANIFESTED">MANIFESTED</option>
                            <option value="TRANSIT">TRANSIT</option>
                            <option value="RECEIVED">RECEIVED</option>
                            <option value="DELIVERED">DELIVERED</option>
                            <option value="DELIVERED OK">DELIVERED OK</option>
                           </select>
                          </td>

                          
                        </tr>
                        <tr>
                          <th style="width: 100px; padding-top: 16px"> Jenis </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" name="jenis" class="select-picker4 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" >
                            <option value="" disabled="" selected=""> --Pilih --</option>
                            <option value="REGULER">REGULER</option>
                            <option value="EXPRESS">EXPRESS</option>
                            <option value="OUTLET">OUTLET</option>
                           </select>
                          </td>

                          <th style="width: 100px; padding-top: 16px"> Customer </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" name="customer" class="cari_semua customer chosen-select-width form-control" data-show-subtext="true" data-live-search="true" >
                            <option value=""  selected=""> --Customer --</option>
                            @foreach ($customer as $e)
                                <option value="{{ $e->kode }}">{{ $e->kode }} - {{ $e->nama }}</option>
                            @endforeach
                           </select>
                          </td>
                          
                        </tr>
                        <tr>
                          

                          
                        </tr>
                          <th style="width: 100px; padding-top: 16px"> Tipe </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" name="tipe" class="cari_semua select-picker3 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" >
                            <option value=""  selected=""> --Tipe --</option>
                            <option value="DOKUMEN">DOKUMEN</option>
                            <option value="KILOGRAM">KILOGRAM</option>
                            <option value="KOLI">KOLI</option>
                            <option value="SEPEDA">SEPEDA</option>
                           </select>
                          </td>

                      <br>
                      </table>
                      

                      <div class="row" style="margin-top: 20px;margin-bottom: -72px;"> &nbsp; &nbsp; <a class="btn btn-primary" onclick="cari()"> <i class="fa fa-search" aria-hidden="true"></i> Cari </a> </div>
                      <div class="row" style="margin-top: 34px;margin-left: 56px;"> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>
                      <div class="row" style="margin-top: -38px;margin-left: 137.5px;"> &nbsp; &nbsp; <a class="btn btn-warning cetak" onclick="excel()"> <i class="fa fa-print" aria-hidden="true"></i> Excel </a> </div>
                </form>
                <div class="box-body">
                <div id="replace">
                <table id="addColumn"  class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th> No DO</th>
                            <th> Cabang</th>
                            <th> Tanggal </th>
                            <th> Customer </th>
                            <th> Pengirim </th>
                            <th> Penerima </th>
                            <th> Kota Asal </th>
                            <th> Kota Tujuan </th>
                            <th> Detail </th>
                       
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tr>
                      <td colspan="8">Total net</td>
                      <td id="total_grandtotal"></td>
                    </tr>
                  </table>
                  </div>
                  {{-- {{ $data->links() }}  --}}

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



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
      function format ( d ) {
      return  '<table class="table">'+
                '<tr>'+
                    '<td>Tipe</td>'+
                    '<td>:</td>'+
                    '<td>'+d.type_kiriman+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Jenis</td>'+
                    '<td>:</td>'+
                    '<td>'+d.jenis_pengiriman+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Pendapatan</td>'+
                    '<td>:</td>'+
                    '<td>'+d.pendapatan+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>customer</td>'+
                    '<td>:</td>'+
                    '<td>'+d.cab+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>DPP</td>'+
                    '<td>:</td>'+
                    '<td>'+d.total_dpp+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Vendor</td>'+
                    '<td>:</td>'+
                    '<td>'+d.total_vendo+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td class="tot">total net</td>'+
                    '<td>:</td>'+
                    '<td>'+d.total_net+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>status</td>'+
                    '<td>:</td>'+
                    '<td>'+d.status+'</td>'+
                '</tr>'+
            '</table>'
              ;
      }
 
      var table =  $('#addColumn').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route('deliveryorder_total_data') }}',
            },
            "columns": [
            { "data": "nomor" },
            { "data": "cab" },
            { "data": "tanggal" },
            { "data": "cus" },
            { "data": "nama_pengirim" },
            { "data": "nama_penerima" },
            { "data": "asal" },
            { "data": "tujuan" },
            {
                "class": "details-control",
                "orderable": false,
                "data": null,
                "defaultContent": "",
            },
            ]
      });
    
     var detailRows = [];

       $('#addColumn tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );
 
        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();
 
            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( format( row.data() ) ).show();
 
            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );
 
    // On each draw, loop over the `detailRows` array and show any child rows
   

    // $('#tot').each(function(){

    // })


    function cetak(){
      $.ajax({
        data: $('#cari_data').serialize(),
        url: baseUrl + '/reportdeliveryorder_total/reportdeliveryorder_total',
        type: "get",
       success : function(data){
        var win = window.open();
            win.document.write(data);
        }
      });
    }

    function excel(){
      $.ajax({
        data:  $('#cari_data').serialize(),
        url: baseUrl + '/exceldeliveryorder_total/exceldeliveryorder_total',
        type: "get",
        success: function (response, textStatus, request) {
        var a = document.createElement("a");
        a.href = response.file; 
        a.download = response.name;
        document.body.appendChild(a);
        a.click();
        a.remove();
      },
      error: function (ajaxContext) {
        toastr.error('Export error: '+ajaxContext.responseText);
      },
        
      });
    }
    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
        
    });

    $("select[name='laporan']").change(function(){
        var this_val = $(this).find(':selected').val();
        if (this_val == 'REKAP BULANAN') {
            $('#min').attr('disabled',true);
            $('#max').attr('disabled',true);
            $('#max').val('-');
            $('#min').val('-');
        }else{
            $('#max').attr('disabled',false);
            $('#min').attr('disabled',false);
            $('#max').val();
            $('#min').val();
        }

        if (this_val == 'DETAIL PER NOPOL') {
            $("select[name='pendapatan']").html(' <option value=""  selected=""> --Tipe --</option>'+
                            '<option value="KARGO" selected>KARGO</option>');
            $('#max').val();
            $('#min').val();
        }else if(this_val == 'DETAIL PER MOBIL'){
            $("select[name='pendapatan']").html(' <option value=""  selected=""> --Tipe --</option>'+
                            '<option value="KARGO" selected>KARGO</option>');
            $('#max').val();
            $('#min').val();
        }else{
            $("select[name='pendapatan']").html('<option value=""  selected=""> --Tipe --</option>'+
                            '<option value="PAKET">PAKET</option>'+
                            '<option value="KORAN">KORAN</option>'+
                            '<option value="KARGO">KARGO</option>');
            $('#max').val();
            $('#min').val();
        }
        

    })
    function cari(){
      var min = $('#min').val();
      var max = $('#max').val();
      var laporan = $('.laporan').val();
      console.log(laporan);
      if (min == '') {
                Command: toastr["warning"]("Pilih Tanggal Terlebih Dahulu", "Peringatan!")

                toastr.options = {
                  "closeButton": false,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": true,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }

                return false;

            }
        if (max == '') {
                Command: toastr["warning"]("Pilih Tanggal Terlebih Dahulu", "Peringatan!")

                toastr.options = {
                  "closeButton": false,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": true,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }

                return false;

            }
            if (laporan == '') {
                Command: toastr["warning"]("Pilih Laporan Terlebih Dahulu", "Peringatan!")

                toastr.options = {
                  "closeButton": false,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": true,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }

                return false;
            }
      if (laporan == 'DEFAULT') {



        $.ajax({
            data: $('#cari_data').serialize(),
            url: baseUrl + '/ajaxcarideliveryorder_total/ajaxcarideliveryorder_total',
            type: "get",
            success: function (response, textStatus, request) {
              $('#replace').html(response);
              
            },
            error: function (ajaxContext) {
              toastr.error('Export error: '+ajaxContext.responseText);
            },
            
        });




      }


      //CARI MASTER DETAIL
      else if(laporan == 'MASTER DETAIL'){
        $.ajax({
            data: $('#cari_data').serialize(),
            url: baseUrl + '/ajaxcarideliveryorder_total_masterdetail/ajaxcarideliveryorder_total_masterdetail',
            type: "get",
            success: function (response, textStatus, request) {
              $('#replace').html(response);
              
            },
            error: function (ajaxContext) {
              toastr.error('Export error: '+ajaxContext.responseText);
            },
            
        });
      }


      //CARI REKAP CUSTOMER
      else if(laporan == 'rekap' || laporan == 'rekap_detail'){
        $.ajax({
          data: $('#cari_data').serialize(),
          url: baseUrl + '/cari_rekapcustomer/cari_rekapcustomer',
          type: "get",
          success : function(data){
            if (data.data == '0') {
               Command: toastr["warning"]("Data Terkait Tidak Ditemukan", "Peringatan!")

                toastr.options = {
                  "closeButton": false,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": true,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
              $('#replace').html('');

            }else{
              $('#replace').html(data);
            }
          }
        });
      }
      //CARI REKAP BULANAN
      else if(laporan == 'REKAP BULANAN'){
        $.ajax({
            data: $('#cari_data').serialize(),
            url: baseUrl + '/ajaxcarideliveryorder_total_rekapbulanan/ajaxcarideliveryorder_total_rekapbulanan',
            type: "get",
            success: function (response, textStatus, request) {
              $('#replace').html(response);
              // alert('a');
              var total = 0;
               $('.april').each(function(){
                  var par = $(this).parents('tr');
                  var jan = $(par).find('.jan').text();
                  var feb = $(par).find('.feb').text() ;
                  var mar = $(par).find('.mar').text() ;
                  var mei = $(par).find('.mei').text() ;
                  var jun = $(par).find('.jun').text() ;
                  var jul = $(par).find('.jul').text() ;
                  var aug = $(par).find('.aug').text() ;
                  var sep = $(par).find('.sep').text() ;
                  var okt = $(par).find('.okt').text() ;
                  var nov = $(par).find('.nov').text() ;
                  var des = $(par).find('.des').text() ;
                  var hasil = parseInt($(this).text())  + parseInt(jan) + parseInt(feb) + parseInt(mar) + parseInt(mei) + parseInt(jun) + parseInt(jul) + parseInt(aug) + parseInt(sep) + parseInt(okt) + parseInt(nov) + parseInt(des) ;
                  // console.log(hasil);
                  total += hasil;
                  $(par).find('.total_total').text(hasil);
                })
               // alert(total);
               $('#hasilakir').text(total);
               $('#bulan_rep').DataTable({});
            },
            error: function (ajaxContext) {
              toastr.error('Export error: '+ajaxContext.responseText);
            },
            
        });
      }
       //CARI DETAIL PER NOPOL
      else if(laporan == 'DETAIL PER NOPOL'){
        $.ajax({
            data: $('#cari_data').serialize(),
            url: baseUrl + '/ajaxcarideliveryorder_total_detailnopol/ajaxcarideliveryorder_total_detailnopol',
            type: "get",
            success: function (response, textStatus, request) {
              $('#replace').html(response);
              
            },
            error: function (ajaxContext) {
              toastr.error('Export error: '+ajaxContext.responseText);
            },
            
        });
      }
      //CARI DETAIL PER MOBIL
      else if(laporan == 'DETAIL PER MOBIL'){
        $.ajax({
            data: $('#cari_data').serialize(),
            url: baseUrl + '/ajaxcarideliveryorder_total_detailmobil/ajaxcarideliveryorder_total_detailmobil',
            type: "get",
            success: function (response, textStatus, request) {
              $('#replace').html(response);
            },
            error: function (ajaxContext) {
              toastr.error('Export error: '+ajaxContext.responseText);
            },
            
        });
      }
      //CARI DETAIL PER SALES
      else if(laporan == 'DETAIL PER SALES'){
         $.ajax({
            data: $('#cari_data').serialize(),
            url: baseUrl + '/ajaxcarideliveryorder_total_detailsales/ajaxcarideliveryorder_total_detailsales',
            type: "get",
            success: function (response, textStatus, request) {
              $('#replace').html(response);
              // $('#table_detailsales').DataTable({});
            },
            error: function (ajaxContext) {
              toastr.error('Export error: '+ajaxContext.responseText);
            },
            
        });
      }
      //CARI DETAIL PER SOPIR
      else if(laporan == 'DETAIL PER SOPIR'){
        alert('a');
      }
      
      //CARI REKAP PER MOBIL
      else if(laporan == 'REKAP PER MOBIL'){
        alert('a');
      }
      //CARI REKAP PER SOPIR
      else if(laporan == 'REKAP PER SOPIR'){
        alert('a');
      }

    }


    

</script>
@endsection
