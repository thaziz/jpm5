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
                            <option value="{{ url('/masteritem/masteritem/masteritem') }}" >Laporan Data Master Item</option>
                            <option value="{{ url('/lap_masterdepartment/lap_masterdepartment') }}">Laporan Data Department</option>
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

                

                  <hr>
                  
                  <div class="row" style="margin-top: 20px;"> &nbsp; &nbsp; <a class="btn btn-info" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>

                   <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                        <th width="50"> No.</th>
                        <th width="50"> Kode Item </th>
                        <th> Nama Item </th>
                        <th> Group Item</th> 
                        <th> Acc Stock </th>
                        <th> Acc HP </th> 
                        <th> Harga</th>               
                    </tr>
                 
                    </thead>
                    
                    <tbody>
                      @foreach ($data as $index => $a )
                        <tr>
                          <td align="center">{{ $index + 1 }}</td>
                          <td align="center"><input type="hidden" name="" value="{{ $a->kode_item }}">{{ $a->kode_item }}</td>
                          <td align="center">{{ $a->nama_masteritem }}</td>
                          <td align="center">{{ $a->groupitem }}</td>
                          <td align="center">{{ $a->acc_persediaan }}</td>
                          <td align="center">{{ $a->acc_hpp }}</td>
                          <td align="right">{{ $a->harga }}</td>
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


@endsection



@section('extra_scripts')
<script type="text/javascript">
    var d = new Date();
    var a = d.getDate();
    var b = d.getSeconds();
    var c = d.getMilliseconds();

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
        url: baseUrl + '/reportmasteritem/reportmasteritem',
       type: "post",
       success : function(data){
        var win = window.open();
            win.document.write(data);
        }
      });
    }

</script>
@endsection
