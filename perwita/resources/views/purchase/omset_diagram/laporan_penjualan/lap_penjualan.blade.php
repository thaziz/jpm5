@extends('main')

@section('tittle','dashboard')

@section('content')

<style type="text/css">
    .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
  .dataTables_filter, .dataTables_info { display: none; }

</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Laporan Penjualan
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
                <table align="center">
                  <tr >
                    <td valign="top" style="padding-left: 20px;"><p style="background-color: red;width: 15px;height: 15px">&nbsp;</p></td>
                    <td><p>&nbsp;&nbsp;&nbsp;</p></td>
                    <td valign="top"><p> Data Berasal Dari Penjualan Do Paket yang berstatus <f style="color: red;";>*DELIVERED OK</f> <b>Dan</b><f style="color: red;";>* Data Invoice</f> Dari Data Tersebut diolah dan Mendapat Hasil Per-Bulan</p></td>
                    <td valign="top" style="padding-left: 12px;"><p style="background-color: red;width: 15px;height: 15px">&nbsp;</p></td>
                                             
                  </tr>
                </table>
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
              </div>  
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                    <div id="container" style="height: 400px"></div>
                    <table class="table table-bordered datatable table-striped" style="margin-top: 100px;">
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
      
                       
                      <br>
                      </table>
                      <div class="row" style="margin-top: 20px;"> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>
                    </div>
                </form>
                <div class="box-body">
                <table id="addColumn" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th hidden=""></th>
                            <th hidden=""></th>
                            <th> No DO</th>
                            <th> Tanggal </th>
                            <th> Pengirim </th>
                            <th> Penerima </th>
                            <th> Kota Asal </th>
                            <th> Kota Tujuan </th>
                            <th> Kec Tujuan </th>
                            <th> Pendapatan </th>
                            <th> Tipe </th>
                            <th> Jenis </th>
                            <th> Status </th>
                            <th> Tarif Dasar </th>
                            <th> Tarif Penerus </th>
                            <th> Biaya Tambabahan </th>
                            <th> diskon </th>
                            <th> Tarif Keseluruhan </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
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
                            <td>{{ $row->pendapatan }}</td>
                            <td>{{ $row->type_kiriman }}</td>
                            <td>{{ $row->jenis_pengiriman }}</td>
                            <td>{{ $row->status }}</td>
                            <td align="right">{{ number_format($row->tarif_dasar,0,',','.')  }}</td>
                            <td align="right">{{ number_format($row->tarif_penerus,0,',','.') }}</td>
                            <td align="right">{{ number_format($row->biaya_tambahan,0,',','.') }}</td>
                            <td align="right">{{ number_format($row->diskon,0,',','.')}}</td>
                            <td align="right">{{ number_format($row->total,0,',','.') }}</td>
                        </tr>
                        @endforeach
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
   
    var d = new Date();
    var a = d.getDate();
    var b = d.getSeconds();
    var c = d.getMilliseconds();


    var table;
   
   table = $('#addColumn').DataTable( {
      responsive: true,
              searching: true,
              //paging: false,
              "pageLength": 10,
              "language": dataTableLanguage,
         dom: 'Bfrtip',
         buttons: [
            {
                  extend: 'excel',
                 /* messageTop: 'Hasil pencarian dari Nama : ',*/
                  text: ' Excel',
                  className:'excel',
                  title:'LAPORAN TARIF PENJUALAN',
                  filename:'PENJUALAN-'+a+b+c,
                  init: function(api, node, config) {
                  $(node).removeClass('btn-default'),
                  $(node).addClass('btn-warning'),
                  $(node).css({'margin-top': '-50px','margin-left': '80px'})
                  },
                  exportOptions: {
                  modifier: {
                      page: 'all'
                  }
              }
              
              }
          ]
    });

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
            // console.log(min);
            var max = $('#max').datepicker("getDate");
            // console.log(max);

            var startDate = new Date(data[3]);
            // console.log(startDate);
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
   
 
    $(document).ready(function() {
        $('.tbl-item').DataTable();
     
        $('input.global_filter').on( 'keyup click', function () {
            filterGlobal();
        } );
     
        $('input.column_filter').on( 'keyup click', function () {
            filterColumn( $(this).parents('tr').attr('data-column') );
        } );
    } );

    
   
    function filterColumn2 () {
        $('#addColumn').DataTable().column(3).search(
            $('.select-picker5').val()).draw(); 
     }
     

      function cetak(){
      var asw=[];
       var asd = table.rows( { filter : 'applied'} ).data(); 
       for(var i = 0 ; i < asd.length; i++){

           asw[i] =  $(asd[i][1]).val();
  
       }

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });


      $.ajax({
        data: {a:asw,c:'download'},
        url: baseUrl + '/reportlaporan_penjualan/reportlaporan_penjualan',
        type: "post",
       success : function(data){
        var win = window.open();
            win.document.write(data);
        }
      });
    }

    var date = new Date();
    var y = date.getFullYear();

Highcharts.chart('container', {

    chart: {
        type: 'column'
    },
 xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    title: {
        text: 'DIAGRAM BATANG PENJUALAN TAHUN '+ y
    },

    yAxis: [{
        className: 'highcharts-color-0',
        title: {
            text: 'Data Delivery Order Paket'
        }
    }, {
        className: 'highcharts-color-1',
        opposite: true,
        title: {
            text: 'Data Delivery Order Paket'
        }
    }],

    plotOptions: {
        column: {
            borderRadius: 0
        }
    },

   
    series: [{
        name: 'PENJUALAN',
        data: [
        {{ $penjualan[0]}},
        {{ $penjualan[1]}},
        {{ $penjualan[2]}},
        {{ $penjualan[3]}},
        {{ $penjualan[4]}},
        {{ $penjualan[5]}},
        {{ $penjualan[6]}},
        {{ $penjualan[7]}},
        {{ $penjualan[8]}},
        {{ $penjualan[9]}},
        {{ $penjualan[10]}},
        {{ $penjualan[11]}},
        ]
    ,
    }]

});

</script>
@endsection
