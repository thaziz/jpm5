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
                            <strong> Surat Permintaan Order  </strong>
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
                    <h5> Laporan Surat Permintaan Order

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

                   <table class="table table-bordered datatable table-striped">
                      <br>
                                                                                
                        <tr id="filter_col1" data-column="0">
                           <th > Cari Nama Perusahaan :  </th>
                          <td >
                            <input type="text" id="col0_filter" name="filter_cabang"  onkeyup="filterColumn()" value="" class="col-sm-12 asal form-control column_filter" placeholder="Pencarian.." >
                          </td>
                          <th > Cari Status Order :  </th>
                          <td >
                            <input type="text" id="col1_filter" name="filter_cabang"  onkeyup="filterColumn1()" value="" class="col-sm-12 asal form-control column_filter" placeholder="Pencarian.." >
                          </td>
                        </tr>
                        <tr >                    
                          <th> Pilih Laporan : </th>
                          <td  colspan="4">
                            <select class="form-control" onchange="location = this.value;">
                  <option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Master Item</option>
                  <option value="/jpm/reportmasterdepartment/reportmasterdepartment">Laporan Data Department</option>
                  <option value="/jpm/reportmastergudang/reportmastergudang" >Laporan Data Master Gudang</option>
                  <option value="/jpm/reportmastersupplier/reportmastersupplier">Laporan Data Supplier</option>
                  <option value="/jpm/reportspp/reportspp">Laporan Data Surat Permintaan Pembelian</option>
                  <option value="/jpm/reportpo/reportpo" selected="" disabled="" style="background-color: #DDD; ">Laporan Data Order</option>
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
                          </td>
                        </tr>
                    </table>
                   
                    <hr>
                    <div class="row"> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>

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
                        <th> No PO</th>
                        <th> Tanggal di Butuhkan </th>
                        <th hidden=""> tgl</th>
                        <th> status </th>
                    </tr>        
                    </thead>        
                    <tbody>
                    @foreach($cari as $index=>$data)
                    <tr>
                    <td style="width: 5%; text-align: center"> <input class="br"  type="hidden" name="pemohon[]" value="{{$data->po_id}}">{{$index+1}}</td>
                    <td>
                      <input class="br"  type="hidden" name="pemohon[]" value="{{$data->nama}}">{{ $data->nama }}</td>
                    <td>

                      <input class="br" type="hidden" name="spp[]" value="{{$data->po_no}}">{{$data->po_no}}</td>
                    <td>

                      <input class="br"  type="hidden" name="butuh[]" value="{{$data->spp_tgldibutuhkan}}">{{$data->spp_tgldibutuhkan}}</td>
                    
                    <td hidden="">{{$data->created_at}}</td>
                    <td>
                      <input class="br"  type="hidden" name="status[]" value="{{$data->spp_status}}">
                      {{$data->spp_status}}
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
  var d = new Date();
    var a = d.getDate();
    var b = d.getSeconds();
    var c = d.getMilliseconds();
    var tgl1 = '1/1/2018';
    var tgl2 = '2/2/2018';
     var addColumn = $('#addColumn').DataTable({
    paging:true,
       dom: 'Bfrtip',
       buttons: [
          {
                extend: 'excel',
               /* messageTop: 'Hasil pencarian dari Nama : ',*/
                text: ' Excel',
                className:'excel',
                title:'LAPORAN ORDER',
                filename:'ORDER-'+a+b+c,
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

 

  function filterColumn ( ) {
    $('#addColumn').DataTable().column(1).search(
        $('#col0_filter').val()
    ).draw();    
} 
  function filterColumn1 ( ) {
    $('#addColumn').DataTable().column(5).search(
        $('#col1_filter').val()
    ).draw();    
}




/////////////////////////////////////////////////////////////////////////
  

    // table.on('search.dt', function() {
    //       //number of filtered rows
    //       // console.log(table.rows( { filter : 'applied'} ).nodes().length);
    //       //filtered rows data as arrays
                                           
    //     })    

     function cetak(){
    
      var a = $('#a').val();
      var b = $('#b').val();
      var c = $('#c').val();
      var d = $('#d').val();
      var e = $('#e').val(); 
      var f = $('#f').val();
      var g = $('#g').val();

      var asw=[];
       var asd = addColumn.rows( { filter : 'applied'} ).data(); 
       for(var i = 0 ; i < asd.length; i++){
           asw[i] =  $(asd[i][0]).val();
       }
       console.log(asw);


      $.ajax({
        data: {asw:asw,download:'download'},
        url: baseUrl + '/masterpurchaseorder/masterpurchaseorder/masterpurchaseorder',
        type: "get",
         complete : function(){
        window.open(this.url,'_blank');
        },     
        success : function(data){
        }
      });
    }
   
  

</script>
@endsection
