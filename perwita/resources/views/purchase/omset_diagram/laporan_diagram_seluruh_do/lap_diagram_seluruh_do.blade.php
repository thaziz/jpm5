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
              <div class="form-row">
                <div class="form-group col-md-2">
                  <input type="text" class="date form-control" readonly="" id="date_awal" name="">
                </div>
                <div class="form-group col-md-2">
                  <input type="text" class="date form-control" readonly="" id="date_akir" name="">
                </div>
                <div class="form-group col-md-4">
                  <select class="chosen-select-width" name="cabang" id="cabang">
                    <option value="" selected="">- Cabang -</option>
                      @foreach ($cabang as $e)
                          <option value="{{ $e->kode }}">{{ $e->kode }} - {{ $e->nama }}</option>
                      @endforeach
                  </select>
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
                    </div>
                </form>
                <div class="box-body">
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
        format: 'yyyy-mm-dd'
    });

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
        name: 'DOKUMEN',
        data: [
        {{ $arraybulan_dokumen[0]}},
        {{ $arraybulan_dokumen[1]}},
        {{ $arraybulan_dokumen[2]}},
        {{ $arraybulan_dokumen[3]}},
        {{ $arraybulan_dokumen[4]}},
        {{ $arraybulan_dokumen[5]}},
        {{ $arraybulan_dokumen[6]}},
        {{ $arraybulan_dokumen[7]}},
        {{ $arraybulan_dokumen[8]}},
        {{ $arraybulan_dokumen[9]}},
        {{ $arraybulan_dokumen[10]}},
        {{ $arraybulan_dokumen[11]}},
        ]
    }, 
   {
        name: 'KILOGRAM',
        data: [
        {{ $arraybulan_kilogram[0]}},
        {{ $arraybulan_kilogram[1]}},
        {{ $arraybulan_kilogram[2]}},
        {{ $arraybulan_kilogram[3]}},
        {{ $arraybulan_kilogram[4]}},
        {{ $arraybulan_kilogram[5]}},
        {{ $arraybulan_kilogram[6]}},
        {{ $arraybulan_kilogram[7]}},
        {{ $arraybulan_kilogram[8]}},
        {{ $arraybulan_kilogram[9]}},
        {{ $arraybulan_kilogram[10]}},
        {{ $arraybulan_kilogram[11]}},
        ]
    }, 
    {
        name: 'KOLI',
        data: [
        {{ $arraybulan_koli[0]}},
        {{ $arraybulan_koli[1]}},
        {{ $arraybulan_koli[2]}},
        {{ $arraybulan_koli[3]}},
        {{ $arraybulan_koli[4]}},
        {{ $arraybulan_koli[5]}},
        {{ $arraybulan_koli[6]}},
        {{ $arraybulan_koli[7]}},
        {{ $arraybulan_koli[8]}},
        {{ $arraybulan_koli[9]}},
        {{ $arraybulan_koli[10]}},
        {{ $arraybulan_koli[11]}},
        ]
    }, 
    {
        name: 'SEPEDA',
        data: [
        {{ $arraybulan_sepeda[0]}},
        {{ $arraybulan_sepeda[1]}},
        {{ $arraybulan_sepeda[2]}},
        {{ $arraybulan_sepeda[3]}},
        {{ $arraybulan_sepeda[4]}},
        {{ $arraybulan_sepeda[5]}},
        {{ $arraybulan_sepeda[6]}},
        {{ $arraybulan_sepeda[7]}},
        {{ $arraybulan_sepeda[8]}},
        {{ $arraybulan_sepeda[9]}},
        {{ $arraybulan_sepeda[10]}},
        {{ $arraybulan_sepeda[11]}},
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
        url: baseUrl + '/cari_paket/cari_paket',
        type: "get",
       success : function(data){
        // console.log(data.dokumen == null &&  data.kilogram == null  &&  data.koli == null &&  data.sepeda == null);
         if (data.dokumen == null && data.kilogram == null && data.koli == null && data.sepeda == null) {
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
          $('#container').html('');

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
            categories: ['TAMPILAN'],
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
            name: 'DOKUMEN',
            data: [data.dokumen]
        },{
            name: 'KILOGRAM',
            data: [data.kilogram]
        },{
            name: 'KOLI',
            data: [data.koli]
        },{
            name: 'SEPEDA',
            data: [data.sepeda]
        },

        ],
      });
        }
        }
      });
    }


</script>
@endsection
