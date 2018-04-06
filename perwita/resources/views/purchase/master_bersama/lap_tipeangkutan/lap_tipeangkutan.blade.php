@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
  .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Pelunasan Hutang / Pembayaran Kas </h2>
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
                            <strong> Pelunasan Hutang / Pembayaran Kas </strong>
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
  
                <div class="col-xs-12">
                  <table class="table table-bordered datatable table-striped">
                      <br>
                        <tr>                                                     
                        <th> Nama : </th> 
                          <td> 
                                <input id="nama" type="text" class="form-control ">
                          </td>  
                          <th> Bahan Bakar : </th> 
                            <td> 
                                <input id="bahan_bakar" type="text" class="form-control" >
                            </td>
                      </tr>
                      <tr>                                                     
                        <th> Km/Liter : </th> 
                          <td colspan="4"> 
                                <input id="km_liter" type="text" class="form-control ">
                          </td>  
                      </tr>
                      <tr>
                        <th> Pilih Laporan</th>
                        <td colspan="4">
                          <select class="form-control" onchange="location = this.value;">
                            <option selected="" disabled="">Pilih terlebih dahulu</option>
                            <option value="{{ url('/lappajak/lappajak') }}"> LAPORAN MASTER PAJAK </option>
                            <option value="{{ url('/lapprovinsi/lapprovinsi') }}"> LAPORAN MASTER PROVINSI</option>
                            <option value="{{ url('/lapkota/lapkota') }}"> LAPORAN MASTER KOTA </option>
                            <option value="{{ url('/lapkecamatan/lapkecamatan') }}"> LAPORAN MASTER KECAMATAN </option>
                            <option value="{{ url('/lapcabang/lapcabang') }}"> LAPORAN MASTER CABANG </option>
                            <option value="{{ url('/laptipeangkutan/laptipeangkutan') }}"> LAPORAN MASTER TIPE ANGKUTAN </option>
                            <option value="{{ url('/lapkendaraan/lakendaraan') }}"> LAPORAN MASTER KENDARAAN </option>
                           </select>
                        </td>
                      </tr>
                      <br>
                    
                    
                    </table>
                  <div class="row"> &nbsp; &nbsp; <a class="btn btn-info" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>
                  <table id="addColumn" class="table table_header table-bordered table-striped"> 
                    <thead>
                    <tr>
                      <th  style="text-align: center"> No.</th>                      
                      <th  style="text-align: center"> Kode</th>
                      <th  style="text-align: center"> Nama </th>
                      <th  style="text-align: center"> Bahan Bakar </th>
                      <th  style="text-align: center"> Km/Liter </th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $index => $element)
                    <tr>
                      <td>{{ $index+1 }} </td>
                      <td><input type="hidden" name="" value="{{ $element->kode }}">{{ $element->kode }}  </td>
                      <td>{{ $element->nama }}  </td>
                      <td>{{ $element->bahan_bakar }} </td>
                      <td>{{ $element->bbm_per_liter }} </td>
                    </tr>
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
</div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

    var d = new Date();
    var a = d.getDate();
    var b = d.getSeconds();
    var c = d.getMilliseconds();
    var tgl1 = '1/1/2018';
    var tgl2 = '2/2/2018';

  var table = $('#addColumn').DataTable({
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
                title:'LAPORAN TIPE ANGKUTAN',
                filename:'TPANGKUTAN-'+a+b+c,
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

  function filterColumn ( ) {
    $('#addColumn').DataTable().column(6).search(
        $('#col0_filter').val()
    ).draw();    
} 

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
    
    $('#nama').on( 'keyup', function () {
        table.column(2).search( this.value ).draw();
      });  
    $('#bahan_bakar').on( 'keyup', function () {
         table.column(3).search( this.value ).draw();
      });  
    $('#km_liter').on( 'keyup', function () {
         table.column(4).search( this.value ).draw();
      });
    
 
 
   
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
        url: baseUrl + '/reporttipeangkutan/reporttipeangkutan',
         type: "post",
       success : function(data){
        var win = window.open();
            win.document.write(data);
        }
      });
    }
   

</script>
@endsection
