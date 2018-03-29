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
                                                                                
                        <tr >
                           <th style="width: 100px; padding-top: 16px"> Kota Asal  </th>
                          <td colspan="2">
                          <select style="width: 200px; margin-top: 20px;" class="select-picker1 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn()">
                            <option value="semua"> --Pilih Terlebih Dahulu--</option>
                            @foreach ($kota1 as $asal)
                                <option value="{{ $asal->asal }}">{{ $asal->asal }}</option>
                            @endforeach
                          </select>
                          </td>
                        </tr>
                    
                        <tr >
                          <th style="width: 100px; padding-top: 16px"> Kota Tujuan </th>
                          <td colspan="2"> 
                           <select style="width: 200px; margin-top: 20px;" class="select-picker2 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn1()">
                            <option value="semua"> --Pilih Terlebih Dahulu--</option>
                            @foreach ($kota as $tujuan)
                                <option value="{{ $tujuan->tujuan }}">{{ $tujuan->tujuan }}</option>
                            @endforeach
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
                        <th align="center"> Kota Asal</th>
                        <th align="center"> Kota Tujuan</th>
                        <th >kode</th>
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
                        <td >{{$val->kode}}</td>
                        <td align="center">{{$val->jenis}}</td>
                        <td align="center">-</td>
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
                  title:'LAPORAN TARIF CABANG KOLI',
                  filename:'CABANGKOLI-'+a+b+c,
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
    $('#addColumn').DataTable().column(0).search(
        $('.select-picker1').val()
    ).draw();    
    }
    function filterColumn1 () {
        $('#addColumn').DataTable().column(1).search(
            $('.select-picker2').val()
        ).draw();    
    }


     function cetak(){
      z = $('.select-picker1 option:selected').val();
       z1 = $('.select-picker2 option:selected').val();
       console.log(z);
       console.log(z1)


      $.ajax({
        data: {a:z,b:z1},
        url: baseUrl + '/reportcabangkargo/reportcabangkargo',
        type: "get",
         complete : function(){
        window.open(this.url,'_blank');
        },     
        success : function(data){
        // window.open(this.data,'_blank');  
        }
      });
    }



  
</script>
@endsection
