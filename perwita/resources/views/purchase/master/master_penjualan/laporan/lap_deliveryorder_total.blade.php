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
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                    <table class="table datatable" border="0">
                         <tr>
                        <td> Dimulai : </td> <td> <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input name="min" id="min" type="text" class="cari_semua date form-control date_to date_range_filter
                                              date" onchange="tgl()">

                              </div> </td>  <td> Diakhiri : </td> <td> <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input type="text" class="cari_semua date form-control date_to date_range_filter
                                              date" name="max" id="max" onchange="tgl()" >
                              </div> </td>
                      </tr>
                       {{-- <tr>
                        <th> Nama Pengirim : </th> 
                          <td> 
                                <input id="nama_pengirim" type="text" class="form-control ">
                          </td>  
                          <th> Nama Penerima : </th> 
                            <td> 
                                <input id="nama_penerima" type="text" class="form-control" >
                            </td>
                      </tr> --}}
                      <tr>
                          <th style="width: 100px; padding-top: 16px">Cabang</th>
                          <td colspan="3">
                            <select class="cari_semua chosen-select-width" id="cabang" onchange="filterColumn5()">
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
                          <select style="width: 200px; margin-top: 20px;" class="cari_semua chosen-select-width select-picker1 form-control" data-show-subtext="true" data-live-search="true"  id="kota_asal" onchange="filterColumn()">
                            <option value="" disabled="" selected=""> --Asal --</option>
                            @foreach ($kota1 as $asal)
                                <option value="{{ $asal->asal }}">{{ $asal->asal }}</option>
                            @endforeach
                          </select>
                          </td>
                        
                          <th style="width: 100px; padding-top: 16px"> Kota Tujuan </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" class="cari_semua select-picker2 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" id="kota_tujuan"  onchange="filterColumn1()">
                            <option value="" disabled="" selected=""> --Tujuan --</option>
                            @foreach ($kota as $tujuan)
                                <option value="{{ $tujuan->tujuan }}">{{ $tujuan->tujuan }}</option>
                            @endforeach
                           </select>
                          </td>
                        </tr>
                        <tr>
                           <th style="width: 100px; padding-top: 16px"> Tipe </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" class="cari_semua select-picker3 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn2()">
                            <option value="" disabled="" selected=""> --Tipe --</option>
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
                           <select style="width: 200px; margin-top: 20px;" class="cari_semua select-picker5 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" id="status" onchange="filterColumn4()" >
                            <option value="" disabled="" selected=""> --Status --</option>
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
                      <div class="row" style="margin-top: 20px;"> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>
                    </div>
                    <div class="row" style="margin-top: -51px;margin-left: 67px;"> &nbsp; &nbsp; <a class="btn btn-warning cetak" onclick="excel()"> <i class="fa fa-print" aria-hidden="true"></i> Excel </a> </div>
                    </div>
                </form>
                <div class="box-body">
                <table id="addColumn" class="table table-bordered table-striped">
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

            // { "data": "type_kiriman" },
            // { "data": "jenis_pengiriman" },
            // { "data": "cab" },
            // { "data": "total", render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            // { "data": "total_net", render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            // { "data": "button" },
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
    table.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );
  
      var aa=[];
       var bb = table.rows( { filter : 'applied'} ).data(); 
       for(var i = 0 ; i < bb.length; i++){

           aa[i] =  $(bb[i][11]).val();
  
       }
       var total = 0;
        for (var i = 0; i < aa.length; i++) {
            total += aa[i] << 0;
        }
    $('#total_grandtotal').text(accounting.formatMoney(total,"",0,'.',','));





     $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
            $("#min").datepicker({format:"dd/mm/yyyy"});
            $("#max").datepicker({format:"dd/mm/yyyy"});

       function tgl(){
         var tgl1   = $("#min").val();
         var tgl2   = $("#max").val();
          if(tgl1 != "" && tgl2 != ""){
          }

            $(document).ready(function(){
        $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var min = $('#min').datepicker("getDate");
            console.log(min);
            var max = $('#max').datepicker("getDate");
            console.log(max);

            var startDate = new Date(data[3]);
            console.log(startDate);
            if (min == null || min == '' && max == null || max == '') { return true; }
            if (min == null || min == '' || min == 'Invalid Date' && startDate <= max) { return true;}
            if (max == null || max == '' || max == 'Invalid Date' && startDate >= min) {return true;}
            if (startDate <= max && startDate >= min) { return true; }
            return false;
        }
        );
            $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
           

            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                /*if($('#max').val() == '' || $('#max').val() == null ){
                    $('#max').val(0);
                }*/
                table.draw();
            });
        });
          }
   
 
    function filterColumn () {
    $('#addColumn').DataTable().column(6).search(
        $('#kota_asal').val()).draw();    
    var aa=[];
         console.log('anjay');
         var bb = table.rows( { filter : 'applied'} ).data(); 
           for(var i = 0 ; i < bb.length; i++){
              aa[i] =  $(bb[i][13]).val(); 
           }

         var total = 0;
          for (var i = 0; i < aa.length; i++) {
              total += aa[i] << 0;
          }
          console.log(aa);
      $('#total_grandtotal').text(accounting.formatMoney(total,"",0,'.',','));
    }

    function filterColumn1 () {
        $('#addColumn').DataTable().column(7).search(
            $('#kota_tujuan').val()).draw();  
            var aa=[];
         console.log('anjay');
         var bb = table.rows( { filter : 'applied'} ).data(); 
           for(var i = 0 ; i < bb.length; i++){
              aa[i] =  $(bb[i][13]).val(); 
           }

         var total = 0;
          for (var i = 0; i < aa.length; i++) {
              total += aa[i] << 0;
          }
          console.log(aa);
      $('#total_grandtotal').text(accounting.formatMoney(total,"",0,'.',','));  
    }
    function filterColumn2 () {
        $('#addColumn').DataTable().column(9).search(
            $('.select-picker3').val()).draw(); 
        var aa=[];
         console.log('anjay');
         var bb = table.rows( { filter : 'applied'} ).data(); 
           for(var i = 0 ; i < bb.length; i++){
              aa[i] =  $(bb[i][13]).val(); 
           }

         var total = 0;
          for (var i = 0; i < aa.length; i++) {
              total += aa[i] << 0;
          }
          console.log(aa);
      $('#total_grandtotal').text(accounting.formatMoney(total,"",0,'.',','));
   }
   function filterColumn4 () {
      $('#addColumn').DataTable().column(10).search(
          $('#status').val()).draw(); 
      var aa=[];
         console.log('anjay');
         var bb = table.rows( { filter : 'applied'} ).data(); 
           for(var i = 0 ; i < bb.length; i++){
              aa[i] =  $(bb[i][13]).val(); 
           }

         var total = 0;
          for (var i = 0; i < aa.length; i++) {
              total += aa[i] << 0;
          }
          console.log(aa);
      $('#total_grandtotal').text(accounting.formatMoney(total,"",0,'.',','));
   }
   function filterColumn5 () {
      $('#addColumn').DataTable().column(14).search(
          $('#cabang').val()).draw(); 

         var aa=[];
         console.log('anjay');
         var bb = table.rows( { filter : 'applied'} ).data(); 
           for(var i = 0 ; i < bb.length; i++){
              aa[i] =  $(bb[i][13]).val(); 
           }

         var total = 0;
          for (var i = 0; i < aa.length; i++) {
              total += aa[i] << 0;
          }
          console.log(aa);
      $('#total_grandtotal').text(accounting.formatMoney(total,"",0,'.',','));
   } 

      function cetak(){
      var asw=[];
       var asd = table.rows( { filter : 'applied'} ).data(); 
       for(var i = 0 ; i < asd.length; i++){

           asw[i] =  $(asd[i][2]).val();
  
       }

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });


      $.ajax({
        data: {a:asw,c:'download'},
        url: baseUrl + '/reportdeliveryorder_total/reportdeliveryorder_total',
        type: "post",
       success : function(data){
        var win = window.open();
            win.document.write(data);
        }
      });
    }

    function excel(){
      var asw=[];
       var asd = table.rows( { filter : 'applied'} ).data(); 
       for(var i = 0 ; i < asd.length; i++){

           asw[i] =  $(asd[i][2]).val();
  
       }

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });


      $.ajax({
        data: {a:asw,c:'download'},
        url: baseUrl + '/exceldeliveryorder_total/exceldeliveryorder_total',
        type: "post",
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



</script>
@endsection
