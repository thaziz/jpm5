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
                    <h5> Laporan 
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
                    {{-- <table class="table table-bordered datatable table-striped">
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
                        <tr>
                           <th style="width: 100px; padding-top: 16px"> Customer </th>
                          <td colspan="3"> 
                           <select style="width: 200px; margin-top: 20px;" class="select-picker5 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn2()">
                            <option selected="">- Pilih Customer -</option>
                            @foreach ($cus as $c)
                              <option value="{{ $c->nama }}" >{{ $c->kode }} - {{ $c->nama }}</option>
                            @endforeach
                           </select>
                          </td>
                        </tr>
                       
                      <br>
                      </table> --}}
                         <div class="form-row">
                                    <div class="form-group col-md-2">
                                      <input type="text" class="date form-control" readonly="" id="date_awal" name="">
                                    </div>

                                    <div class="form-group col-md-2">
                                      <input type="text" class="date form-control" readonly="" id="date_akir" name="">
                                    </div>

                                    <div class="form-group col-md-4">
                                      <select style="width: 200px; margin-top: 20px;" class="select-picker5 chosen-select-width form-control"   data-show-subtext="true" data-live-search="true" >
                                          <option selected="" value="">- Pilih Customer -</option>
                                          @foreach ($cus as $c)
                                            <option value="{{ $c->kode }}" >{{ $c->kode }} - {{ $c->nama }}</option>
                                          @endforeach
                                      </select>
                                    </div>


                                    <div class="form-group col-md-2">
                                      <button  class="btn btn-info" onclick="cari()"> <i class="fa fa-search" aria-hidden="true"></i> Cari </button>
                                    </div>
                                </div>

                          <div>
                            <div class="form-group col-md-4">
                                <select class="cari_semua chosen-select-width laporan" id="jenis"  name="jenis">
                                  <option value="INVOICE">INVOICE</option>
                                  <option value="INVOICE BELUM TT">INVOICE BELUM TT</option>
                                  <option value="INVOICE SESUDAH TT">INVOICE SESUDAH TT</option>
                                  <option value="JARAK INVOICE DENGAN TT">JARAK INVOICE DENGAN TT</option>
                                  <option value="ENTRY">ENTRY</option>
                                </select>
                              </div>

                              <div class="form-group col-md-4">
                                <select class="cari_semua chosen-select-width" id="cabang"  name="cabang">
                                  <option></option>
                                  @foreach ($cabang as $element)
                                    <option value="{{ $element->kode }}">{{ $element->kode }} - {{ $element->nama }}</option>
                                  @endforeach
                                </select>
                              </div>
                          </div> 


                      <div class="row" style="margin-top: 20px;"> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>
                </form>
                <div class="box-body">
                <table id="addColumn" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          
                            <th> No Kwitansi</th>
                            <th> Tanggal </th>
                            <th> Customer </th>
                            <th> Ttl Bayar</th>
                            <th> Debet(+) </th>
                            <th> Kredit(-) </th>
                            <th> Netto </th>
                            <th> bank </th>
                            
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $index =>$e)
                        <tr>
                        
                        <td><input type="hidden" value="{{ $e->k_nomor }}" name="nomor">{{ $e->k_nomor }}</td>
                        <td>{{ $e->k_tanggal }}</td>
                        <td>{{ $e->k_kode_customer }}</td>
                        <td align="right">{{ number_format($e->k_jumlah,0,',','.') }}</td>
                        <td align="right">{{ number_format($e->k_debet,0,',','.') }}</td>
                        <td align="right">{{ number_format($e->k_kredit,0,',','.') }}</td>
                        <td align="right">{{ number_format($e->k_netto,0,',','.') }}</td>
                        <td >{{ $e->k_nota_bank }}</td>
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

    
    // function filterColumn1 () {
    //     $('#addColumn').DataTable().column(3).search(
    //         $('.select-picker3').val()).draw();    
    // }
    function filterColumn2 () {
        $('#addColumn').DataTable().column(2).search(
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
        url: baseUrl + '/reportkwitansi/reportkwitansi',
        type: "post",
       success : function(data){
        var win = window.open();
            win.document.write(data);
        }
      });
    }
</script>
@endsection
