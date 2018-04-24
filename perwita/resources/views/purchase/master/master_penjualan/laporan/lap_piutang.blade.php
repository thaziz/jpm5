@extends('main')

@section('tittle','dashboard')

@section('content')

<style type="text/css">
    .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
  .dataTables_filter, .dataTables_info { display: none; }
  .saldo{
    border: none;
    background-color: #e6ffda;
    color: #676a6c;
  }
  #total_debet{
    border: none;
    color: #676a6c;
  }
  #total_kredit{
    border: none;
    color: #676a6c;
  }
  #total_total{
    border: none;
    color: #676a6c;
  }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Laporan DO Koran
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
                    <table class="table table-bordered datatable table-striped">
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
                          {{--   <th style="width: 100px; padding-top: 16px"> Satuan </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" class="select-picker3 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn1()">
                            <option value="" disabled="" selected=""> --Pilih --</option>
                            @foreach ($sat as $sat)
                              <option value="{{ $sat->kode }}">{{ $sat->kode }} - {{ $sat->nama }}</option>
                            @endforeach
                           </select>
                          </td>
 --}}
                           {{-- <th style="width: 100px; padding-top: 16px"> Customer </th>
                          <td colspan="3"> 
                           <select style="width: 200px; margin-top: 20px;" class="select-picker5 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn2()">
                            <option selected="">- Pilih Customer -</option>
                            @foreach ($cus as $c)
                              <option value="{{ $c->nama }}" >{{ $c->kode }} - {{ $c->nama }}</option>
                            @endforeach
                           </select>
                          </td> --}}
                        </tr>
                       
                      <br>
                      </table>
                      <div class="row" style="margin-top: 20px;"> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>
                    </div>
                </form>
                <div class="box-body">
                <table id="addColumn" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th width="10%"> Kode</th>
                            <th width="10%"> Tgl </th>
                            <th width="10%"> Keterangan </th>
                            <th width="10%"> Debet(+) </th>
                            <th width="10%"> Kredit(-) </th>
                            <th width="10%"> saldo </th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($data_i as $a => $element)
                         <tr>
                           <td colspan="6">{{ $data_i[$a]->i_kode_customer }}</td>
                         </tr>
                         @foreach ($data as $e => $element)
                      <tr style="text-align: right;background-color: #e6ffda;">
                          
                            @if ($data_i[$a]->i_kode_customer == $data[$e]->cutomer)
                                    <td><input type="hidden" value="{{ $data[$e]->kode }}" name="nomor">{{ $data[$e]->kode }}</td>
                                    <td>{{ $data[$e]->tanggal }}</td>
                                    <td align="left">{{ $data[$e]->keterangan }}</td>
                                    <td align="right" > 
                                    @if ($data[$e]->flag == 'D' or substr($data[$e]->kode,0,3) == 'INV')
                                      {{ $data[$e]->total }}
                                      <input type="hidden" class="debet" value="{{ $data[$e]->total }}" name="">
                                    @else 
                                      0
                                      <input type="hidden" class="debet" value="0" name="">
                                    @endif
                                    </td>

                                    <td align="right"> 
                                    @if ($data[$e]->flag == 'K' or substr($data[$e]->kode,0,2) == 'KN' or substr($data[$e]->kode,0,3) == 'KWT' or substr($data[$e]->kode,0,3) == 'PST')
                                      <input type="hidden" class="kredit" value="{{ $data[$e]->total }}" name="">
                                      {{ $data[$e]->total }}
                                    @else 
                                      0
                                      <input type="hidden" class="kredit" value="0" name="">
                                    @endif
                                    </td>

                                    <td ><input type="text" name="" readonly="" class="saldo" style="text-align: right"></td>
                            @endif 
                           {{--  @if ($data_i[$a]->i_kode_customer == $data_p[$e]->i_kode_customer)
                                  <td>{{ $data_p[$e]->i_nomor }}</td>
                                  <td>{{ $data_p[$e]->i_tanggal }}</td>
                                  <td>{{ $data_p[$e]->i_keterangan }}</td>
                            @endif --}}

                      </tr>
                        @endforeach
                        
                    @endforeach
                    <tr>
                          <th colspan="3" align="right">total</th>
                          <td><input type="text" id="total_debet" readonly="" name="" style="text-align: right;font-weight: bold;"></td>
                          <td><input type="text" id="total_kredit" readonly="" name="" style="text-align: right;font-weight: bold;"></td>
                          <td><input type="text" id="total_total" readonly="" name="" style="text-align: right;font-weight: bold;"></td>
                        </tr>
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
   
   
  var awal = 0;
  $('.debet').each(function(){
    var total = parseInt($(this).val());
    awal += total;
    console.log(awal);
  });
  $('#total_debet').val(accounting.formatMoney(awal,"",0,'.',','));

  var kred = 0;
  $('.kredit').each(function(){
    var total = parseInt($(this).val());
    kred += total;
    console.log(kred);
  });
  $('#total_kredit').val(accounting.formatMoney(kred,"",0,'.',','));


  var saldo = 0;
  $('.debet').each(function(){
    var par = $(this).parents('tr');
    var kredit = $(par).find('.kredit').val();
    var hasil = $(this).val() - kredit;
    saldo += hasil;
    $(par).find('.saldo').val(saldo);
  })
  $('#total_total').val(accounting.formatMoney(saldo,"",0,'.',','));


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
