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

  .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
  .dataTables_filter, .dataTables_info { display: none; }
    .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
</style>
  <meta name="csrf-token" content="{{ csrf_token() }}" /> 

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
                                                                                
                        <tr>
                           <th style="width: 100px; padding-top: 16px"> Jenis </th>
                          <td colspan="2"> 
                           <select style="width: 200px; margin-top: 20px;" class="select-picker chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn()">
                            <option value="" disabled="" selected=""> --Pilih --</option>
                            <option value="REGULER">REGULER</option>
                            <option value="EXPRESS">EXPRESS</option>
                            <option value="OUTLET">OUTLET</option>
                           </select>
                          </td>
                        </tr>
                        <tr>
                           <th style="width: 100px; padding-top: 16px"> Tipe </th>
                          <td colspan="2"> 
                           <select style="width: 200px; margin-top: 20px;" class="select-picker1 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn1()">
                            <option value="" disabled="" selected=""> --Pilih --</option>
                            <option value="DOKUMEN">DOKUMEN</option>
                            <option value="KILOGRAM">KILOGRAM</option>
                            <option value="KOLI">KOLI</option>
                            <option value="SEPEDA">SEPEDA</option>
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
                        <th align="center"> No</th>
                        <th align="center" hidden=""> No</th>
                        <th align="center"> Jenis</th>
                        <th align="center"> Tipe </th>
                        <th align="center"> Keterangan </th>
                        <th align="center"> Harga </th>
                    </tr>        
                    </thead>        
                    <tbody>
                      @foreach($data as $index => $val)
                      <tr>
                        <td>{{ $index+1 }}</td>
                        <td hidden><input type="hidden" name="" value="{{ $val->id }}"></td>
                        <td align="center">{{$val->jenis}}</td>
                        <td align="center">{{$val->tipe_kiriman}}</td>
                        <td align="center">{{$val->keterangan}}</td>
                        <td align="right">{{"Rp " . number_format($val->harga,2,",",".")}}</td>
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
                  title:'LAPORAN TARIF PENERUSDEFAULT',
                  filename:'PENERUSDEFAULT-'+a+b+c,
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

   function filterColumn () {
    $('#addColumn').DataTable().column(2).search(
        $('.select-picker').val()
    ).draw();    
    }
    function filterColumn1 () {
        $('#addColumn').DataTable().column(3).search(
            $('.select-picker1').val()
        ).draw();    
    }
    $('.select-picker1').change(function(){
      var anj = $(this).val();
      console.log(anj);
    });

      function cetak(){
      var asw=[];
       var asd = addColumn.rows( { filter : 'applied'} ).data(); 
       for(var i = 0 ; i < asd.length; i++){

           asw[i] =  $(asd[i][1]).val();
  
       }
       console.log(asw);

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });


      $.ajax({
        data: {a:asw,c:'download'},
        url: baseUrl + '/reportpenerusdefault/reportpenerusdefault',
        type: "post",    
        success : function(data){
        var win = window.open();
            win.document.write(data);
        }
      });
    }


  
</script>
@endsection
