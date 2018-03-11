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
                            <strong> Surat Permintaan Pembelian  </strong>
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
                      {{--   <td> Dimulai Tanggal </td> <td> <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input name="min" id="min" type="text" class="form-control date_to date_range_filter
                                              date" onchange="tgl()">

                              </div> </td>  <td> Diakhiri Tanggal </td> <td> <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input type="text" class="form-control date_to date_range_filter
                                              date" name="max" id="max" onchange="tgl()" >
                              </div> </td>
                      </tr> --}}
                      <br>
                                                                                
                        <tr id="filter_col1" data-column="1">
                           <th> Cabang  </th>
                          <td colspan="3">
                            <input type="text" id="col1_filter" name="filter_cabang" value="" class="col-sm-12 form-control column_filter" placeholder="Cabang" >
                          </td>
                        </tr>
                    
                        <tr id="filter_col2" data-column="5">
                          <th> Status </th>
                          <td colspan="3"> 
                            <input type="text" id="col5_filter" name="fitler_supplier" class="col-sm-12 form-control column_filter" value=""   placeholder="status" >
                          </td>
                        </tr>
                        <tr>
                          <th> Pilih Laporan : </th>
                          <td colspan="3">
                           <select class="form-control" onchange="location = this.value;">
                  <option selected="" disabled="">Pilih terlebih dahulu</option>
                  <option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Master Item</option>
                  <option value="/jpm/reportmasterdepartment/reportmasterdepartment">Laporan Data Department</option>
                  <option value="/jpm/reportmastergudang/reportmastergudang">Laporan Data Master Gudang</option>
                  <option value="/jpm/reportmastersupplier/reportmastersupplier">Laporan Data Supplier</option>
                  <option value="/jpm/reportspp/reportspp" selected="" disabled="" style="background-color: #DDD; ">Laporan Data Surat Permintaan Pembelian</option>
                  <option value="/jpm/reportpo/reportpo">Laporan Data Order</option>
                  <option value="/jpm/reportfakturpembelian/reportfakturpembelian">Laporan Data Faktur Pembelian</option>
                  <option value="/jpm/buktikaskeluar/patty_cash">Laporan Data Patty Cash</option>
                  <option value="/jpm/reportbayarkas/reportbayarkas">Laporan Data Pelunasan Hutang/Bayar Kas</option>
                  <option value="/jpm/reportbayarbank/reportbayarbank">Laporan Data Pelunasan Hutang/Bayar Bank</option>
                  {{-- <option value="/jpm/reportbayarbank/reportbayarbank">Laporan Data Kartu Hutang</option>
                  <option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Mutasi Hutang</option>
                  <option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Historis Faktur vs Pelunasan</option>
                  <option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Analisa Usia Hutang</option>
                  <option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Faktur Pajak Masukan</option>
                  <option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Historis Uang Muka Pembelian</option> --}}
                 </select>
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
                        <th> Perusahaan Pemohon </th>
                        <th> No SPP</th>
                        <th> Tanggal di Butuhkan </th>
                        <th hidden=""> tgl</th>
                        <th> status </th>
 
                    </tr>        
                    </thead>        
                    <tbody>
                    @foreach($cari as $index=>$data)
                    <tr>
                    <td style="width: 5%; text-align: center">{{$index+1}}</td>
                    <td>
                      {{$data->nama}}
                      <input class="br" hidden=""  type="text" name="pemohon[]" value="{{$data->nama}}">
                    </td>
                    <td>
                      <input class="br" readonly=""   type="text" name="spp[]" value="{{$data->spp_nospp}}"></td>
                    <td><input class="br" readonly=""  type="text" name="butuh[]" value="{{ \Carbon\Carbon::parse($data->spp_tgldibutuhkan)->format('m/d/Y')}}"></td>
                    <td hidden="">{{$data->created_at}}</td>
                    <td>
                      {{$data->spp_status}}
                      {{-- <input class="br" hidden=""   type="text" name="status[]" value="{{$data->spp_status}}">  --}}
                    </td>      
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
$(document).ready(function(){
   var d = new Date();
    var a = d.getDate();
    var b = d.getSeconds();
    var c = d.getMilliseconds();
    var tgl1 = '1/1/2018';
    var tgl2 = '2/2/2018';
  $('#addColumn').DataTable({
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
                title:'LAPORAN MASTER SUPPLIER',
                filename:'MASTERAUPPLIWE-'+a+b+c,
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


})
 ////
           /* Custom filtering function which will search data in column four between two values */
           
        

/////////////////////////////////////////////////////////////////////////
    function filterGlobal () {
    $('.tbl-item').DataTable().search(
        $('#global_filter').val(),
        $('#global_regex').prop('checked'),
        $('#global_smart').prop('checked')
    ).draw();
    }
     
    function filterColumn ( i ) {
        $('.tbl-item').DataTable().column( i ).search(
            $('#col'+i+'_filter').val()
        ).draw();
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

    // table.on('search.dt', function() {
    //       //number of filtered rows
    //       // console.log(table.rows( { filter : 'applied'} ).nodes().length);
    //       //filtered rows data as arrays
                                           
    //     })    

    function cetak(){
      var cabang = $('#cabang').val();
      var supplier = $('#supplier').val();
      var barang = $('#barang').val();
      var tgl1   = $("#min").val();
      var tgl2   = $("#max").val();

          tgl1   = tgl1.replace('/','-');
          tgl2   = tgl2.replace('/','-');
          tgl1   = tgl1.replace('/','-');
          tgl2   = tgl2.replace('/','-');
          console.log(tgl1);
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
        url: baseUrl + '/reportspp/table',
        data:  {asw:asw,tgl1:tgl1,tgl2:tgl2},
        type: "POST",    
        success : function(data){
            var win = window.open();
            win.document.write(data);
        }
      });
    }
   

</script>
@endsection
