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
                    <h2> Laporan Master Item </h2>
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
                            <strong> Master Item </strong>
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
                    <h5> Laporan Master Item
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    
                <div class="box-body">
                <h3 style="text-align: center"> PT JAWA PRATAMA MANDIRI  <br> JL. KARAH AGUNG NO 45 SURABAYA
                </h3>
           <table class="table table-bordered datatable table-striped">
                      <br>
                                                                                
                        <tr id="filter_col1" data-column="0">
                           <th > Cari Nama Item :  </th>
                          <td >
                            <input type="text" id="col0_filter" name="filter_cabang"  onkeyup="filterColumn()" value="" class="col-sm-12 asal form-control column_filter" placeholder="Pencarian.." >
                          </td>
                        
                        
                          <th> Pilih Laporan : </th>
                          <td >
                            <select class="form-control" onchange="location = this.value;">
                            <option selected="" disabled="">Pilih terlebih dahulu</option>
                  <option value="{{ url('/reportmasteritem/reportmasteritem') }}">Laporan Data Master Item</option>
                  <option value="{{ url('/reportmasterdepartment/reportmasterdepartment') }}">Laporan Data Department</option>
                  <option value="{{ url('/reportmastergudang/reportmastergudang') }}">Laporan Data Master Gudang</option>
                  <option value="{{ url('/reportmastersupplier/reportmastersupplier') }}">Laporan Data Supplier</option>
                  <option value="{{ url('/reportspp/reportspp') }}">Laporan Data Surat Permintaan Pembelian</option>
                  <option value="{{ url('/reportpo/reportpo') }}">Laporan Data Order</option>
                  <option value="{{ url('/reportfakturpembelian/reportfakturpembelian') }}">Laporan Data Faktur Pembelian</option>
                  <option value="{{ url('/buktikaskeluar/patty_cash') }}">Laporan Data Patty Cash</option>
                    <option value="{{ url('/reportbayarkas/reportbayarkas') }}">Laporan Data Pelunasan Hutang/Bayar Kas</option>
                  <option value="{{ url('/reportbayarbank/reportbayarbank') }}">Laporan Data Pelunasan Hutang/Bayar Bank</option>
                           </select>
                          </td>
                        </tr>
                    </table>

                

                  <hr>
                  
                  <div class="row"> &nbsp; &nbsp; 
                    <a class="btn btn-info" onclick="cetak()" >
                        <i class="fa fa-print" aria-hidden="true"></i> Cetak 
                    </a> 
                  </div>

                   <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                        <th width="50">NO</th>
                        <th width="50"> Kode </th>
                        <th> Nama  Item </th>
                        <th>  Group </th> 
                        <th> Satuan </th>   
                        <th> Acc Stock </th>
                        <th> Acc HP </th>                
                    </tr>
                 
                    </thead>
                    
                    <tbody>
                      @for ($index = 0; $index < count($masterItem["namaItem"]); $index++)
                        <tr>
                          <td align="center">
                           <input type="hidden" id="a" name="a[]" value="{{ $masterItem["kodeItem"][$index] }}">{{ $index + 1 }}</td>

                          <td align="center">
                            <input type="hidden" id="b" name="b[]" value="{{ $masterItem["kodeItem"][$index] }}">{{ $masterItem["kodeItem"][$index] }}</td>

                          <td align="center">
                           <input type="hidden" id="c" name="c[]" value="{{ $masterItem["namaItem"][$index] }}">{{ $masterItem["namaItem"][$index] }}</td>

                          <td align="center">
                            <input type="hidden" id="d" name="d[]" value="{{ $masterItem["groupItem"][$index] }}">{{ $masterItem["groupItem"][$index] }}</td>

                          <td align="center">
                           <input type="hidden" id="e" name="e[]" value="{{ $masterItem["satuanItem"][$index] }}">{{ $masterItem["satuanItem"][$index] }}</td>

                          <td align="center">
                           <input type="hidden" id="f" name="f[]" value="{{ $masterItem["accStock"][$index] }}">{{ $masterItem["accStock"][$index] }}</td>

                          <td align="center">
                           <input type="hidden" id="g" name="g[]" value="{{ $masterItem["accHpp"][$index] }}">{{ $masterItem["accHpp"][$index] }}</td>

                        </tr>
                      @endfor
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
    ordering:'true',

       dom: 'Bfrtip',
       buttons: [
          {
                extend: 'excel',
               /* messageTop: 'Hasil pencarian dari Nama : ',*/
                text: ' Excel',
                className:'excel',
                title:'LAPORAN MASTER ITEM',
                filename:'MASTERITEM-'+a+b+c,
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
    $('#addColumn').DataTable().column(2).search(
        $('#col0_filter').val()
    ).draw();    
} 



    $('.date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    
    $no = 0;
    $('.carispp').click(function(){
      $no++;
      $("#addColumn").append('<tr> <td> ' + $no +' </td> <td> no spp </td> <td> 21 Juli 2016  </td> <td> <a href="{{ url('purchase/konfirmasi_orderdetail')}}" class="btn btn-danger btn-flat" id="tmbh_data_barang">Lihat Detail</a> </td> <td> <i style="color:red" >Disetujui </i> </td> </tr>');   
    })
 
   function cetak(){
    
      var a = $('#a').val();
      var b = $('#b').val();
      var c = $('#c').val();
      var d = $('#d').val();
      var e = $('#e').val(); 
      var f = $('#f').val();
      var g = $('#g').val();

      var asw=[];
       var asd = table.rows( { filter : 'applied'} ).data(); 
       for(var i = 0 ; i < asd.length; i++){
           asw[i] =  $(asd[i][1]).val();
       }
       console.log(asw);


      $.ajax({
        data: {asw:asw,download:'download'},
        url: baseUrl + '/masteritem/masteritem/masteritem',
        type: "get",
         complete : function(){
        window.location = /*baseUrl+'/'+*/this.url;
        },     
        success : function(data){
        }
      });
    }

</script>
@endsection
