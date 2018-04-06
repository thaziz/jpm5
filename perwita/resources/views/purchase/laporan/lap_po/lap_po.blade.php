@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
  .br{
    border:none;
  }

  .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
</style>

<div class="return">
  {{ csrf_field() }}
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Surat Permintaan Pembelian  </h2>
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
                            <strong> Surat Permintaan Pembeslian  </strong>
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
                <div class="ibox-title">
                
                    <h5> Laporan Surat Permintaan Pembelian
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    
                <div class="col-xs-12">

                  <table class="table table-bordered table-striped">
                      <tr>
                      <br>
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
                        <th> Supplier : </th> 
                          <td> 
                                <input id="supplier" type="text" class="form-control ">
                          </td>  
                          <th> Status : </th> 
                            <td> 
                                <input id="status" type="text" class="form-control" >
                            </td>
                            
                      </tr>
                        <tr>
                          <th> Pilih Laporan : </th>
                          <td >
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
                          <th> Acc Finance : </th> 
                            <td> 
                                <input id="finance" type="text" class="form-control" >
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <div class="row "> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>

                </div>


                <div class="box-body">
                    <br>
                    <br>
                    <br>
                    <br>
                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                        <th> No </th>
                        <th> No Po </th>
                        <th> tanggal </th>
                        <th> Catatan </th>
                        <th> Bayar</th>
                        <th> Status </th>
                        <th> Supplier </th>
                        <th> Diskon </th>
                        <th> Ppn </th>
                        <th> Sub total </th>
                        <th> Total harga </th>
                        <th> Acc finance </th>
                    </tr>        
                    </thead>        
                    <tbody>
                    @foreach($data as $index=>$data)
                      <tr>
                        <td>{{ $index+1 }}</td>
                        <td><input type="hidden" name="" value="{{ $data->po_no }}">{{ $data->po_no }}</td>
                        <td>{{ $data->po_tglpengiriman }}</td>
                        <td>{{ $data->po_catatan }}</td>
                        <td>{{ $data->po_bayar }}</td>
                        <td>{{ $data->po_status }}</td>
                        <td>{{ $data->nama }}</td>
                        @if ($data->po_diskon == null or '')
                          <td>0</td>
                        @else 
                        <td>{{ $data->po_diskon }}</td>
                        @endif

                        @if ($data->po_ppn == null or '')
                          <td>0</td>
                        @else 
                        <td>{{ $data->po_ppn }}</td>
                        @endif

                        <td>{{ $data->po_subtotal }}</td>
                        <td>{{ $data->po_totalharga }}</td>
                        <td>{{ $data->po_setujufinance }}</td>
                      </tr>
                    @endforeach
                    </tbody>       
                  </table>
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
</div>

@endsection



@section('extra_scripts')
<script type="text/javascript">

   var d = new Date();
    var a = d.getDate();
    var b = d.getSeconds();
    var c = d.getMilliseconds();
  var table= $('#addColumn').DataTable({
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
                title:'LAPORAN PURCHASE ORDER',
                filename:'MASTERPO-'+a+b+c,
                init: function(api, node, config) {
                $(node).removeClass('btn-default'),
                $(node).addClass('btn-warning'),
                $(node).css({'margin-top': '-50px','margin-left': '95px'})
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
   
 
     $('#supplier').on( 'keyup', function () {
         table.column(6).search( this.value ).draw();
      });  
     $('#status').on( 'keyup', function () {
        table.column(5).search( this.value ).draw();
      }); 
     $('#finance').on( 'keyup', function () {
        table.column(11).search( this.value ).draw();
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
        url: baseUrl + '/reportspp/reportspp',
       type: "post",
       success : function(data){
        var win = window.open();
            win.document.write(data);
        }
      });
    
    }
   

</script>
@endsection
