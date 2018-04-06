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
                    <h2> Laporan Faktur Pembelian </h2>
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
                            <strong> Faktur Pembelian </strong>
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
                  <h3 style="text-align: center"> PT JAWA PRATAMA MANDIRI  <br> Register Faktur Pembelian & Voucher (Master) <br>
                {{-- Tanggal : 01 July 2017 s/d 31 July 2017 --}}
                </h3>
                <table class="table table-bordered table-striped">
         
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
                          <th> Pilih Laporan : </th>
                          <td colspan="4">
                            <select class="form-control" onchange="location = this.value;">
                            <option selected="" disabled="">Pilih terlebih dahulu</option>
                            <option value="{{ url('/masteritem/masteritem/masteritem') }}" >Laporan Data Master Item</option>
                            {{-- <option value="{{ url('/reportmasterdepartment/reportmasterdepartment') }}">Laporan Data Department</option> --}}
                            <option value="{{ url('/mastergudang/mastergudang/mastergudang') }}" >Laporan Data Master Gudang</option>
                            <option value="{{ url('/mastersupplier/mastersupplier/mastersupplier') }}" >Laporan Data Supplier</option>
                            <option value="{{ url('/spp/spp/spp') }}" selected="" disabled="">Laporan Data Surat Permintaan Pembelian</option>
                            <option value="{{ url('/masterpo/masterpo/masterpo') }}">Laporan Data Order</option>
                            <option value="{{ url('/masterfakturpembelian/masterfakturpembelian/masterfakturpembelian') }}">Laporan Data Faktur Pembelian</option>
                            <option value="{{ url('/buktikaskeluar/patty_cash') }}">Laporan Data Patty Cash</option>
                            <option value="{{ url('/masterkaskeluar/masterkaskeluar/masterkaskeluar') }}">Laporan Data Pelunasan Hutang/Bayar Kas</option>
                            <option value="{{ url('/masterbayarbank/masterbayarbank/masterbayarbank') }}">Laporan Data Pelunasan Hutang/Bayar Bank</option>
                           </select>
                          </td>
                        </tr>
                  
                  </table>
                </div>
 

                <div class="col-xs-12">
                

                  <div class="row"> &nbsp; &nbsp; <a class="btn btn-info" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>

                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr >
                        <th style="width:10px;">No.</th>
                        <th> No Faktur </th>
                        <th> Tanggal </th>
                        <th> Discount </th>
                        <th> D P P </th>
                        <th> PPn </th>
                        <th> Pajak </th>
                        <th> Netto </th>
                    </tr> 
                    </thead>
                    <tbody>
                      @foreach ($data as $index => $element)
                    <tr>
                      <td>{{ $index+1 }} </td>
                      <td><input type="hidden" name="" value="{{ $element->fp_nofaktur }}">{{ $element->fp_nofaktur }}</td>
                      <td>{{ $element->fp_tgl }}</td>
                      <td style="text-align: right">{{ $element->fp_discount }} </td>
                      <td style="text-align: right">{{ $element->fp_dpp }} </td>
                      <td style="text-align: right">{{ $element->fp_ppn }} </td>
                      <td style="text-align: right">{{ $element->fp_fakturpajak }} </td>
                      <td style="text-align: right">{{ $element->fp_netto }} </td>
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

$(document).ready(function(){

  $('.cetak').attr('disabled', true);

})
     $("#min").datepicker({format:"dd/mm/yyyy"});
     $("#max").datepicker({format:"dd/mm/yyyy"});
    


    var d = new Date();
    var a = d.getDate();
    var b = d.getSeconds();
    var c = d.getMilliseconds();

 var table = $('#addColumn').DataTable({
    paging:true,
       dom: 'Bfrtip',
       buttons: [
          {
                extend: 'excel',
               /* messageTop: 'Hasil pencarian dari Nama : ',*/
                text: ' Excel',
                className:'excel',
                title:'LAPORAN FAKTUR PEMBELIAN',
                filename:'FAKTURPEMBELIAN-'+a+b+c,
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

            var startDate = new Date(data[2]);
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

  function filterColumn ( ) {
    $('#addColumn').DataTable().column(2).search(
        $('#col0_filter').val()
    ).draw();    
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
        url: baseUrl + '/reportfakturpembelian/reportfakturpembelian',
         type: "post",
       success : function(data){
        var win = window.open();
            win.document.write(data);
        }
      });
    }
   

</script>
@endsection
