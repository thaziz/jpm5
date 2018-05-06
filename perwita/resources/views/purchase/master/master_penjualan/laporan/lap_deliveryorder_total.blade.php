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
                          <select style="width: 200px; margin-top: 20px;" class="cari_semua select-picker1 form-control" data-show-subtext="true" data-live-search="true"  id="kota_asal" onchange="filterColumn()">
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
                           <select style="width: 200px; margin-top: 20px;" class="cari_semua select-picker3 form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn2()">
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
                           <select style="width: 200px; margin-top: 20px;" class="cari_semua select-picker5 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" id="status" onchange="filterColumn4()">
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
                            {{-- <th> Pendapatan </th> --}}
                            <th> Tipe </th>
                            {{-- <th> Jenis </th> --}}
                            <th> Status </th>
                          {{--   <th> Tarif Dasar </th>
                            <th> Tarif Penerus </th>
                            <th> Biaya Tambabahan </th>
                            <th> diskon </th> --}}
                            <th> Tarif Keseluruhan </th>
                            <th hidden=""></th>
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
                            {{-- <td>{{ $row->pendapatan }}</td> --}}
                            <td>{{ $row->type_kiriman }}</td>
                            {{-- <td>{{ $row->jenis_pengiriman }}</td> --}}
                            <td>{{ $row->status }}</td>
                            {{-- <td align="right">{{ number_format($row->tarif_dasar,0,',','.')  }}</td>
                            <td align="right">{{ number_format($row->tarif_penerus,0,',','.') }}</td>
                            <td align="right">{{ number_format($row->biaya_tambahan,0,',','.') }}</td>
                            <td align="right">{{ number_format($row->diskon,0,',','.')}}</td> --}}
                            <td align="right"><input type="hidden" name="" class="total_net" value="{{ $row->total_net }}">{{ number_format($row->total_net,0,',','.') }}</td>
                            <td hidden="">{{ $row->kode_cabang }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tr>
                      <td colspan="9">Total net</td>
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
                  $(node).css({'margin-top': '-63px','margin-left': '80px'})
                  },
                  exportOptions: {
                  modifier: {
                      page: 'all'
                  }
              }
              
              }
          ]
    });


   
    

   
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



    $('.cari_semua').change(function(){
       var aa=[];
       var bb = table.rows( { filter : 'applied'} ).data(); 
         for(var i = 0 ; i < bb.length; i++){
            aa[i] =  $(bb[i][11]).val(); 
         }
       console.log(aa);
       var aas = $('.select-picker1').find(':selected').val();
       console.log(aas);
       var total = 0;
        for (var i = 0; i < aa.length; i++) {
            total += aa[i] << 0;
        }
    $('#total_grandtotal').text(accounting.formatMoney(total,"",0,'.',','));

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
    $('#addColumn').DataTable().column(6).search(
        $('#kota_asal').val()).draw();    
    }
    function filterColumn1 () {
        $('#addColumn').DataTable().column(7).search(
            $('#kota_tujuan').val()).draw();    
    }
    function filterColumn2 () {
        $('#addColumn').DataTable().column(9).search(
            $('.select-picker3').val()).draw(); 
     }
     // function filterColumn3 () {
     //    $('#addColumn').DataTable().column(11).search(
     //        $('.select-picker4').val()).draw(); 
     // }
     function filterColumn4 () {
        $('#addColumn').DataTable().column(10).search(
            $('#status').val()).draw(); 
     }
     function filterColumn5 () {
        $('#addColumn').DataTable().column(12).search(
            $('#cabang').val()).draw(); 
     }
     // $('#nama_pengirim').on( 'keyup', function () {
     //     table.column(4).search( this.value ).draw();
     //  });  
     // $('#nama_penerima').on( 'keyup', function () {
     //    table.column(5).search( this.value ).draw();
     //  });  

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



</script>
@endsection
