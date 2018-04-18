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
#bawah {
    position: fixed;
    bottom: 80px;
}
  .dataTables_filter, .dataTables_info { display: none; }

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
                
                <div class="ibox-content" style="min-height: 550px;">
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
                  <select id="cabang" class="chosen-select-width" id="cabang">
                      <option value="">- cabang -</option>
                    @foreach ($cabang as $element)
                      <option value="{{ $element->kode }}">{{ $element->kode }} - {{ $element->nama }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-2">
                  <button  class="btn btn-info" onclick="cari()"> <i class="fa fa-search" aria-hidden="true"></i> Cari </button>
                </div>
              </div>  
              
                    <div id="container" style="height: 400px"></div>
                  

                 <div id="bawah">
                  
                    <span><li class="badge " style="background-color: rgb(124, 181, 236);color: white;">Pendapatan Paket Hari ini Sebanyak <t style="color: white;">Rp.{{ number_format($paket,0,'.',',') }}      </t></li>
                          <li class="badge " style="background-color: rgb(67, 67, 72);color: white;">Pendapatan Koran Hari ini Sebanyak <t style="color: white;">Rp.{{ number_format($koran,0,'.',',') }}</t></li>
                          <li class="badge " style="background-color: rgb(144, 237, 125);color: white;">Pendapatan Kargo Hari ini Sebanyak <t style="color: white;">Rp.{{ number_format($kargo,0,'.',',') }}</t></li>
                          </span>  

                 </div> 
                <div class="box-footer">
                  <div class="pull-right">
                    </div>
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

    function filterColumn () {
    $('#addColumn').DataTable().column(0).search(
        $('.select-picker1').val()).draw();    
    }
    function filterColumn1 () {
        $('#addColumn').DataTable().column(1).search(
            $('.select-picker2').val()).draw();    
    }
    function filterColumn2 () {
        $('#addColumn').DataTable().column(10).search(
            $('.select-picker3').val()).draw(); 
     }
     function filterColumn3 () {
        $('#addColumn').DataTable().column(11).search(
            $('.select-picker4').val()).draw(); 
     }
     function filterColumn4 () {
        $('#addColumn').DataTable().column(12).search(
            $('.select-picker5').val()).draw(); 
     }
     $('#nama_pengirim').on( 'keyup', function () {
         table.column(4).search( this.value ).draw();
      });  
     $('#nama_penerima').on( 'keyup', function () {
        table.column(5).search( this.value ).draw();
      });  

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
        url: baseUrl + '/reportdeliveryorder/reportdeliveryorder',
        type: "post",
       success : function(data){
        var win = window.open();
            win.document.write(data);
        }
      });
    }




var date = new Date();
console.log(date);
    var y = date.getFullYear();
    var d = date.getDate();

    var months = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Augustus","September","Oktober","November","Desember"];

Highcharts.chart('container', {

    chart: {
        type: 'column'
    },
 xAxis: {
        categories: ['']
    },
    title: {
        text: 'DIAGRAM BATANG PENJUALAN HARI INI PADA TANGGAL '+d+' '+months[date.getMonth()]+' '+y
    },

    yAxis: [{
        className: 'highcharts-color-0',
        title: {
            text: 'Data Delivery Order'
        }
    }, {
        className: 'highcharts-color-1',
        opposite: true,
        title: {
            text: 'Data Delivery Order'
        }
    }],

    plotOptions: {
        column: {
            borderRadius: 0
        }
    },

   
    series: [{
        name: 'PAKET',
        data: [
        {{ $paket }},
        
        
        ]
    },{
        name: 'KORAN',
        data: [
        {{ $koran}},
       
        ]
    },
    {
        name: 'KARGO',
        data: [
        {{ $kargo}},
       
        ]
    ,
    }]

});



 function cari(){
      var date_awal = $('#date_awal').val();
      var date_akir = $('#date_akir').val();
      var cabang = $('#cabang').val();
      
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
        data: {a:date_awal,b:date_akir,c:cabang},
        url: baseUrl + '/caridiagram_penjualan/caridiagram_penjualan',
        type: "get",
       success : function(data){
        if (data.hasil == "0") {
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
                name: 'PAKET',
                data: [0]
            },{
                name: 'KORAN',
                data: [0]
            },{
                name: 'KARGO',
                data: [0]
            },

            ],
          });
          $('.highcharts-title').html('Menampilkan Diagram Tanggal '+data.a+' Hingga '+data.b)
             
        }else {
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
                name: 'PAKET',
                data: [data.paket]
            },{
                name: 'KORAN',
                data: [data.koran]
            },{
                name: 'KARGO',
                data: [data.kargo]
            },

            ],
          });

          $('.highcharts-title').html('Menampilkan Diagram Tanggal '+data.a+' Hingga '+data.b)

        }
        console.log(data);
        
        }
      });
    }


</script>
@endsection
