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
              <h3 id="replace" align="center"></h3> 
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                       <table class="table ">
                           <tr>
                              <td> Dimulai : </td>
                              <td>
                                <div class="input-group">
                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                      <input name="min" id="min" type="text" class=" date form-control date_to date_range_filter
                                          date" onchange="tgl()">

                                  </div> 
                              </td> 
                              <td> Diakhiri : </td> 
                              <td> 
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class=" date form-control date_to date_range_filter
                                        date" name="max" id="max" onchange="tgl()" >
                                </div> 
                              </td>
                            </tr>
                            <tr>
                                <th style="width: 100px; padding-top: 16px"> Cabang </th>
                                  <td> 
                                   <select style="width: 200px; margin-top: 20px;" class="select-picker6 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn5()">
                                      <option value="" disabled="" selected=""> --Pilih --</option>
                                      @foreach ($cabang as $cabang)
                                          <option value="{{ $cabang->nama }}">{{ $cabang->kode }} - {{ $cabang->nama }}</option>
                                      @endforeach
                                   </select>
                                  </td>
                                
                                <th style="width: 100px; padding-top: 16px"> Tipe </th>
                                  <td> 
                                   <select style="width: 200px; margin-top: 20px;" class="select-picker3 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn2()">
                                      <option value="" disabled="" selected=""> --Pilih --</option>
                                      <option value="DOKUMEN">DOKUMEN</option>
                                      <option value="KILOGRAM">KILOGRAM</option>
                                      <option value="KOLI">KOLI</option>
                                      <option value="SEPEDA">SEPEDA</option>
                                   </select>
                                  </td>
                            </tr>
                            <tr>
                                <th> Nama Pengirim : </th> 
                                  <td> 
                                      <input id="nama_pengirim" type="text" class="form-control ">
                                  </td>  
                                <th> Nama Penerima : </th> 
                                  <td> 
                                      <input id="nama_penerima" type="text" class="form-control" >
                                  </td>
                            </tr>
                            <tr >
                                <th style="width: 100px; padding-top: 16px"> Kota Asal  </th>
                                  <td >
                                    <select style="width: 200px; margin-top: 20px;" class="select-picker1 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn()">
                                        <option value="" disabled="" selected=""> --Pilih --</option>
                                        @foreach ($kota1 as $asal)
                                            <option value="{{ $asal->asal }}">{{ $asal->asal }}</option>
                                        @endforeach
                                    </select>
                                  </td>
                          
                                <th style="width: 100px; padding-top: 16px"> Kota Tujuan </th>
                                  <td > 
                                     <select style="width: 200px; margin-top: 20px;" class="select-picker2 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn1()">
                                        <option value="" disabled="" selected=""> --Pilih --</option>
                                        @foreach ($kota as $tujuan)
                                            <option value="{{ $tujuan->tujuan }}">{{ $tujuan->tujuan }}</option>
                                        @endforeach
                                     </select>
                                  </td>
                            </tr>

                            <tr>
                                 <th style="width: 100px; padding-top: 16px"> Status </th>
                                  <td > 
                                     <select style="width: 200px; margin-top: 20px;" class="select-picker5 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn4()">
                                        <option value="" disabled="" selected=""> --Pilih --</option>
                                        <option value="MANIFESTED">MANIFESTED</option>
                                        <option value="TRANSIT">TRANSIT</option>
                                        <option value="RECEIVED">RECEIVED</option>
                                        <option value="DELIVERED">DELIVERED</option>
                                        <option value="DELIVERED OK">DELIVERED OK</option>
                                     </select>
                                  </td>

                                  <th style="width: 100px; padding-top: 16px"> Jenis </th>
                                    <td > 
                                       <select style="width: 200px; margin-top: 20px;" class="select-picker4 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn3()">
                                          <option value="" disabled="" selected=""> --Pilih --</option>
                                          <option value="REGULER">REGULER</option>
                                          <option value="EXPRESS">EXPRESS</option>
                                          <option value="OUTLET">OUTLET</option>
                                       </select>
                                    </td>
                            </tr>
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
    $('#addColumn').DataTable().column(5).search(
        $('.select-picker1').val()).draw();    
    }
    function filterColumn1 () {
        $('#addColumn').DataTable().column(6).search(
            $('.select-picker2').val()).draw();    
    }
    function filterColumn2 () {
        $('#addColumn').DataTable().column(8).search(
            $('.select-picker3').val()).draw(); 
     }
     function filterColumn3 () {
        $('#addColumn').DataTable().column(9).search(
            $('.select-picker4').val()).draw(); 
     }
     function filterColumn4 () {
        $('#addColumn').DataTable().column(7).search(
            $('.select-picker5').val()).draw(); 
     }
      function filterColumn5 () {
        $('#addColumn').DataTable().column(10).search(
            $('.select-picker6').val()).draw(); 
     }
     $('#nama_pengirim').on( 'keyup', function () {
         table.column(3).search( this.value ).draw();
      });  
     $('#nama_penerima').on( 'keyup', function () {
        table.column(4).search( this.value ).draw();
      });   

      function cetak(){
      var asw=[];
       var asd = table.rows( { filter : 'applied'} ).data(); 
       for(var i = 0 ; i < asd.length; i++){

           asw[i] =  $(asd[i][2]).val();
  
       }

      // $.ajaxSetup({
      //   headers: {
      //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //   }
      // });


      $.ajax({
        data: {a:asw,a:"_token": "{{ csrf_token() }}"},
        url: baseUrl + '/reportdeliveryorder/reportdeliveryorder',
        type: "post",
       success : function(data){
        var win = window.open();
            win.document.write(data);
        }
      });
    }


</script>
@endsection
