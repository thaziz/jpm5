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
                    <h2> Laporan Master Supplier </h2>
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
                            <strong> Master Supplier </strong>
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
                    <h5> Laporan Master Supplier
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
                           <th > Cari Nama Supplier :  </th>
                          <td >
                            <input type="text" id="col0_filter" name="filter_cabang"  onkeyup="filterColumn()" value="" class="col-sm-12 asal form-control column_filter" placeholder="Pencarian.." >
                          </td>
                          <th> Pilih Laporan : </th>
                          <td >
                            <select class="form-control" onchange="location = this.value;">
                  <option value="/jpm/reportmasteritem/reportmasteritem">Laporan Data Master Item</option>
                  <option value="/jpm/reportmasterdepartment/reportmasterdepartment">Laporan Data Department</option>
                  <option value="/jpm/reportmastergudang/reportmastergudang">Laporan Data Master Gudang</option>
                  <option value="/jpm/reportmastersupplier/reportmastersupplier" selected="" disabled="" style="background-color: #DDD; ">Laporan Data Supplier</option>
                  <option value="/jpm/reportspp/reportspp">Laporan Data Surat Permintaan Pembelian</option>
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
                          </td>
                        </tr>
                        <tr id="filter_col2" data-column="0">
                           <th > Cari Nama Kota :  </th>
                          <td >
                            <input type="text" id="col1_filter" name="filter_cabang"  onkeyup="filterColumn1()" value="" class="col-sm-12 asal form-control column_filter" placeholder="Pencarian.." >
                          </td>
                          <th > Cari Nama Provinsi :  </th>
                          <td >
                            <input type="text" id="col2_filter" name="filter_cabang"  onkeyup="filterColumn2()" value="" class="col-sm-12 asal form-control column_filter" placeholder="Pencarian.." >
                          </td>
                        </tr>
                    </table>
                  <div class="row"> &nbsp; &nbsp; 
                    <a class="btn btn-info" href="{{ route('masterSupplier.ViewReport') }}"> 
                      <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> 
                    </div>

                      <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                        <th>NO</th>
                        <th>Kode Supplier</th>
                        <th>Nama Supplier</th>
                        <th>Alamat</th>
                        <th>Kota</th>
                        <th>Provinsi</th>
                        <th>Kode Pos</th>
                        <th>No Telp / Fax</th>
                        <th>Contact Person</th>
                        <th>Syarat Kredit</th>
                       <!--  <th>Plafon Kredit</th> -->
                        <th>Mata Uang</th>
                        <!-- <th>NPWP</th>
                        <th>Acc Hutang Dagang</th> -->
                    </tr>
                 
                    </thead>
                    
                    <tbody>
                      @for ($index = 0; $index < count($masterSupplier["nama"]); $index++)
                        <tr>
                          <td align="center">{{ $index + 1 }}</td>
                          <td align="center">{{ $masterSupplier["kode"][$index] }}</td>
                          <td align="center">{{ $masterSupplier["nama"][$index] }}</td>
                          <td align="center">{{ $masterSupplier["alamat"][$index] }}</td>
                          <td align="center">{{ $masterSupplier["kota"][$index] }}</td>
                          <td align="center">{{ $masterSupplier["provinsi"][$index] }}</td>
                          <td align="center">{{ $masterSupplier["kodePos"][$index] }}</td>
                          <td align="center">{{ $masterSupplier["telp"][$index] }}</td>
                          <td align="center">{{ $masterSupplier["contPerson"][$index] }}</td>
                          <td align="center">{{ $masterSupplier["kredit"][$index] }} Hari</td>
                         <!--  <td align="center"></td> -->
                          <td align="center">{{ $masterSupplier["currency"][$index] }}</td>
                          <!-- <td align="center">{{ $masterSupplier["npwp"][$index] }}</td>
                          <td align="center">{{ $masterSupplier["hutang"][$index] }}</td> -->
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
function filterColumn1 ( ) {
    $('#addColumn').DataTable().column(4).search(
        $('#col1_filter').val()
    ).draw();    
} 
function filterColumn2 ( ) {
    $('#addColumn').DataTable().column(5).search(
        $('#col2_filter').val()
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
 
   

</script>
@endsection
