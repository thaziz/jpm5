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
                            <th> Total </th>
                            <th> Diskon Do </th>
                            <th> Netto detil</th>
                            <th> Diskon Inv </th>
                            <th> Netto DPP </th>
                            <th> PPN </th>
                            <th> PPH </th>
                            <th> Total Tagihan </th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $index =>$e)
                        <tr>
                        <td><input type="hidden" value="{{ $e->i_nomor }}" name="nomor">{{ $e->i_nomor }}</td>
                        <td>{{ $e->i_tanggal }}</td>
                        <td>{{ $e->i_jatuh_tempo }}</td>
                        <td>{{ $e->i_kode_customer }}</td>
                        <td align="right">{{ number_format($e->i_total,0,',','.') }}</td>
                        <td align="right">{{ number_format($e->i_diskon1,0,',','.') }}</td>
                        <td align="right">{{ number_format($e->i_netto,0,',','.') }}</td>
                        <td align="right">{{ number_format($e->i_diskon2,0,',','.') }}</td>
                        <td align="right">{{ number_format($e->i_netto_detail,0,',','.') }}</td>
                        <td align="right">{{ number_format($e->i_ppnrp,0,',','.') }}</td>
                        <td align="right">{{ number_format($e->i_pajak_lain,0,',','.') }}</td>
                        <td align="right">{{ number_format($e->i_total_tagihan,0,',','.') }}</td>
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
                  title:'LAPORAN TARIF CABANG KOLI',
                  filename:'CABANGKOLI-'+a+b+c,
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

            var startDate = new Date(data[1]);
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


var date = new Date();
var y = date.getFullYear();


    Highcharts.chart('container', {

    chart: {
        type: 'column',
         options3d: {
                enabled: true,
                alpha: 15,
                beta: 15,
                depth: 50
            }
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
            text: ''
        }
    }, {
        className: 'highcharts-color-1',
        opposite: true,
        title: {
            text: ''
        }
    }],

    plotOptions: {
        column: {
            borderRadius: 0
        }
    },

     
    series: [
    {
        name: 'INVOICE',
        data: [
        {{ $invoice[0]}},
        {{ $invoice[1]}},
        {{ $invoice[2]}},
        {{ $invoice[3]}},
        {{ $invoice[4]}},
        {{ $invoice[5]}},
        {{ $invoice[6]}},
        {{ $invoice[7]}},
        {{ $invoice[8]}},
        {{ $invoice[9]}},
        {{ $invoice[10]}},
        {{ $invoice[11]}},
        ]
    ,
    }]

});
    
   

//cari 

function cari(){
      var date_awal = $('#date_awal').val();
      var date_akir = $('#date_akir').val();
      
      if(date_awal == ''){
          Command: toastr["warning"]("Tanggal Tidak Boleh kosong", "Peringatan!")
          toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
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

      if(date_akir == ''){
          Command: toastr["warning"]("Tanggal Tidak Boleh kosong", "Peringatan!")
          toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
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
        data: {a:date_awal,b:date_akir},
        url: baseUrl + '/cari_lap_invoice/cari_lap_invoice',
        type: "get",
       success : function(data){
        // console.log(data);
        if (data.data == null) {
          Command: toastr["warning"](data.response, "Peringatan !")

          toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
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

        }else{
            var awal = $.datepicker.formatDate("dd MM yy", new Date(data.awal))
            var akir = $.datepicker.formatDate("dd MM yy", new Date(data.akir))
              $('#replace').html('Tampilkan Data ' + awal + ' S/D ' + akir);
            Highcharts.chart('container', {
            chart: {
                type: 'column',
              
            },
            title: {
                text: 'Laporan'
            },
            subtitle: {
                text: 'PENJUALAN PAKET'
            },
            plotOptions: {
                column: {
                    depth: 100
                }
            },
            xAxis: {
                categories: ['LAPORAN'],
                labels: {
                    skew3d: true,
                    style: {
                        fontSize: '16px'
                    }
                }
            },
            yAxis: {
                title: {
                    text: null
                }
            },
            series: [{
                name: 'INVOICE',
                data: [data.data]
            },

            ],
          });
        }
        }
      });
    }

</script>
@endsection
