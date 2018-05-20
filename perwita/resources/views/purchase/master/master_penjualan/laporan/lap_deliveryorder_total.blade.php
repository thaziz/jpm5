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
                                              date" 

                              </div> </td>  <td> Diakhiri : </td> <td> <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input type="text" class="cari_semua date form-control date_to date_range_filter
                                              date" name="max" id="max"  >
                              </div> </td>
                      </tr>
                    
                      <tr>
                          <th style="width: 100px; padding-top: 16px">Cabang</th>
                          <td colspan="3">
                            <select class="cari_semua chosen-select-width" id="cabang"  name="cabang">
                              <option></option>
                              @foreach ($cabang as $element)
                                <option value="{{ $element->kode }}">{{ $element->kode }} - {{ $element->nama }}</option>
                              @endforeach
                            </select>
                          </td>
                        </tr>
                        <tr >
                           <th style="width: 100px; padding-top: 16px"> Kota Asal  </th>
                          <td >
                          <select style="width: 200px; margin-top: 20px;" name="asal" class="cari_semua chosen-select-width select-picker1 form-control" data-show-subtext="true" data-live-search="true"  id="kota_asal">
                            <option value=""  selected=""> --Asal --</option>
                            @foreach ($kota1 as $asal)
                                <option value="{{ $asal->id }}">{{ $asal->asal }}</option>
                            @endforeach
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
                        <tr>
                           <th style="width: 100px; padding-top: 16px"> Tipe </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" name="tipe" class="cari_semua select-picker3 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" >
                            <option value=""  selected=""> --Tipe --</option>
                            <option value="DOKUMEN">DOKUMEN</option>
                            <option value="KILOGRAM">KILOGRAM</option>
                            <option value="KOLI">KOLI</option>
                            <option value="SEPEDA">SEPEDA</option>
                            <option value="KORAN">KORAN</option>
                            <option value="KARGO">KARGO</option>
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
                        
                      <br>
                      </table>
                      <div class="row pull-right" style="margin-top: 0px;margin-right: 3px;"> &nbsp; &nbsp; 
                        <select class="chosen-select-width form-control" onchange="location = this.value;">
                          <option selected="" disabled="">- Jenis Laporan -</option>
                          <option value="{{ url('rekap_customer/rekap_customer') }}">Rekap Customer</option>
                        </select>
                      </div>
                      <div class="row" style="margin-top: 20px;margin-bottom: -72px;"> &nbsp; &nbsp; <a class="btn btn-primary" onclick="cari()"> <i class="fa fa-search" aria-hidden="true"></i> Cari </a> </div>
                      <div class="row" style="margin-top: 21px;margin-left: 56px;"> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>
                      <div class="row" style="margin-top: -51px;margin-left: 137px;"> &nbsp; &nbsp; <a class="btn btn-warning cetak" onclick="excel()"> <i class="fa fa-print" aria-hidden="true"></i> Excel </a> </div>
                </form>
                <div class="box-body">
                <div id="replace">
                <table id="addColumn"  class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th> No DO</th>
                            <th> Tanggal </th>
                            <th> Pengirim </th>
                            <th> Penerima </th>
                            <th> Kota Asal </th>
                            <th> Kota Tujuan </th>
                            <th> Tipe </th>
                            <th> Detail </th>
                           {{--  <th> Pendapatan </th>
                            <th> Customer </th>
                            <th> Tarif Keseluruhan </th>
                            <th hidden=""></th> --}}
                        </tr>
                    </thead>
                    <tbody>
                       {{--  @foreach ($data as $row)
                        <tr>
                            <td hidden="">{{ $row->kaid }}</td>
                            <td hidden="">{{ $row->ktid }}</td>
                            <td><input type="hidden" name="" value="{{ $row->nomor }}">{{ $row->nomor }}</td>
                            <td>{{ $row->tanggal }}</td>
                            <td>{{ $row->nama_pengirim }}</td>
                            <td>{{ $row->nama_penerima }}</td>
                            <td>{{ $row->asal }}</td>
                            <td>{{ $row->tujuan }}</td>
                            <td>{{ $row->kecamatan }}</td>
                            <td>{{ $row->type_kiriman }}</td>
                            {{-- <td>{{ $row->jenis_pengiriman }}</td>
                            <td>{{ $row->status }}</td>
                            <td>{{ $row->pendapatan }}</td>
                            <td>{{ $row->customer }}</td>
                            <td align="right"><input type="hidden" name="" class="total_net" value="{{ $row->total_net }}">{{ number_format($row->total_net,0,',','.') }}</td>
                            <td hidden="">{{ $row->kode_cabang }}</td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                    <tr>
                      <td colspan="7">Total net</td>
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
                    '<td>status</td>'+
                    '<td>:</td>'+
                    '<td>'+d.status+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>pendapatan</td>'+
                    '<td>:</td>'+
                    '<td>'+d.pendapatan+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>customer</td>'+
                    '<td>:</td>'+
                    '<td>'+d.cus+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>total net</td>'+
                    '<td>:</td>'+
                    '<td>'+d.total_net+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>cabang</td>'+
                    '<td>:</td>'+
                    '<td>'+d.cab+'</td>'+
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
            { "data": "tanggal" },
            { "data": "nama_pengirim" },
            { "data": "nama_penerima" },
            { "data": "asal" },
            { "data": "tujuan" },
            { "data": "type_kiriman" },
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

    function cari(){
      var min = $('#min').val();
      var max = $('#max').val();
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



</script>
@endsection
