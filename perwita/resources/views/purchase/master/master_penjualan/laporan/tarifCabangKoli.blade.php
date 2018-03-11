@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
  .br{
    border:none;
  }
  th{
        text-align: center !important;
      }
 
</style>

<div class="return">
  {{ csrf_field() }}

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Laporan Tarif Dokumen
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
                                                                                
                        <tr id="filter_col0" data-column="0">
                           <th style="width: 100px; padding-top: 16px"> Kota Asal  </th>
                          <td colspan="2">
                            <input type="text" id="col0_filter" name="filter_cabang"  value="" class="col-sm-12 asal form-control column_filter" placeholder="Asal" >
                          </td>
                        </tr>
                    
                        <tr id="filter_col1" data-column="1">
                          <th style="width: 100px; padding-top: 16px"> Kota Tujuan </th>
                          <td colspan="2"> 
                            <input type="text" id="col1_filter" name="fitler_supplier" class="col-sm-12 tujuan form-control column_filter" value=""   placeholder="Tujuan" >
                          </td>
                        </tr>
                        
                    </table>
                    <hr>
                    <div class="row pull-right"> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>

                </div>


                <div class="box-body">
                    <br>
                    <br>
                    <br>
                    <br>
                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                        <th align="center"> Kota Asal</th>
                        <th align="center"> Kota Tujuan</th>
                        <th hidden="">kode</th>
                        <th align="center"> jenis </th>
                        <th align="center"> Keterangan</th>
                        <th align="center"> Tarif</th>
                    </tr>        
                    </thead>        
                    <tbody>
                      @foreach($data as $val)
                      <tr>
                        <td>{{$val->asal}}</td>
                        <td>{{$val->tujuan}}</td>
                        <td hidden="">{{$val->kode}}</td>
                        <td align="center">{{$val->jenis}}</td>
                        <td align="center">{{$val->keterangan}}</td>
                        <td>{{"Rp " . number_format($val->harga,2,",",".")}}</td>
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
  var table;
  $(document).ready(function(){
     table = $('.tbl-item').DataTable({
      responsive: true,
      searching: true,
      //paging: false,
      "pageLength": 10,
      "language": dataTableLanguage,
    });
  });

   function filterGlobal () {
    $('.tbl-item').DataTable().search(
        $('#global_filter').val(),
        $('#global_regex').prop('checked'),
        $('#global_smart').prop('checked')
    ).draw();
    }
     
    function filterColumn ( i ) {
        $('.tbl-item').DataTable().column( i ).search(
            $('#col'+i+'_filter').val(),
            $('#col'+i+'_regex').prop('checked'),
            $('#col'+i+'_smart').prop('checked')
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



     function cetak(){
      var asal1 = $('.asal').val();
      var tujuan1 = $('.tujuan').val();

       var kode=[];
       var asd = table.rows( { filter : 'applied'} ).data(); 
       for(var i = 0 ; i < asd.length; i++){
            
           kode[i] =  asd[i][2];
  
       }

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url: baseUrl + '/laporan_master_penjualan/tablekoli',
        data:  {kode:kode,asal1:asal1,tujuan1:tujuan1},
        type: "GET",    
        success : function(data){
            var win = window.open();
            win.document.write(data);
        }
      });
    }



  
</script>
@endsection
