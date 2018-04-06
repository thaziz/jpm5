@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Faktur Pajak Masukan </h2>
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
                            <strong> Faktur Pajak Masukan </strong>
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
                
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    
                <div class="box-body">
                
                <div class="row">
                <div class="col-xs-12">
                <table class="table table-bordered table-striped">
                          <tr>
                            <th colspan="4">Masa Pajak</th>
                          </tr> 
                        <tr>

                        <td> awal : </td> <td> <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input name="min" id="min" type="text" class=" date form-control date_to date_range_filter
                                              date" onchange="tgl()">

                              </div> </td>  <td> akir : </td> <td> <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input type="text" class=" date form-control date_to date_range_filter
                                              date" name="max" id="max" onchange="tgl()" >
                              </div> </td>
                      </tr>
                      <br>
                  </table>
                </div>
                    
                </div>
                 <div class="row" style="margin-top: 20px;"> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>
                                    </div>
                <div class="col-xs-12">
                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                      <tr>
                        <th> No.</th>
                        <th> Faktur Pajak Masukan </th>
                        <th> Tanggal </th>
                        <th> Masa pajak </th>
                        <th> D P P </th>
                        <th> PPn </th>
                        <th> Netto </th>
                       </tr>
                    </thead>
                    <tbody>
                      @foreach ($array as $index => $e)
                        <td>{{ $index+1 }}</td>
                        <td> <input type="hidden" name="" value="{{  $e->fpm_nota }}">{{ $e->fpm_nota }}</td>
                        <td>{{ $e->fpm_tgl }}</td>
                        <td>{{ $e->fpm_masapajak }}</td>
                        <td align="right">{{ number_format($e->fpm_dpp,0,',','.')  }}</td>
                        <td align="right">{{ number_format($e->fpm_inputppn,0,',','.') }}</td>
                        <td align="right">{{ number_format($e->fpm_netto,0,',','.') }}</td>
                      @endforeach
                    </tbody>
                  </table>
                  </div>
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
                  $(node).css({'margin-top': '-50px','margin-left': '65px'})
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
        url: baseUrl + '/reportfakturpajakmasukan/reportfakturpajakmasukan',
        type: "post",
       success : function(data){
        var win = window.open();
            win.document.write(data);
        }
      });
    }

</script>
@endsection
