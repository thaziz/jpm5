@extends('main')

@section('tittle','dashboard')

@section('content')

<style type="text/css">
    .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
   #container {
    height: 400px; 
    min-width: 310px; 
    max-width: 100%;
    margin: 0 auto;
}
.highcharts-color-0{
  color:red;
}

  .dataTables_filter, .dataTables_info { display: none; }

</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Laporan INVOICE
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content">
                <div class="row">
              <div class="col-xs-12">
               <div class="form-row">
                          <div class="form-group col-md-2">
                            <input type="text" class="date form-control" readonly="" id="date_awal" name="">
                          </div>

                          <div class="form-group col-md-2">
                            <input type="text" class="date form-control" readonly="" id="date_akir" name="">
                          </div>

                          <div class="form-group col-md-4">
                            <select style="width: 200px; margin-top: 20px;" class="select-picker5 chosen-select-width form-control"   data-show-subtext="true" data-live-search="true" >
                                <option selected="" value="">- Pilih Customer -</option>
                                @foreach ($cus as $c)
                                  <option value="{{ $c->kode }}" >{{ $c->kode }} - {{ $c->nama }}</option>
                                @endforeach
                            </select>
                          </div>


                          <div class="form-group col-md-2">
                            <button  class="btn btn-info" onclick="cari()"> <i class="fa fa-search" aria-hidden="true"></i> Cari </button>
                          </div>
                      </div>

                <div>
                  <div class="form-group col-md-4">
                      <select class="cari_semua chosen-select-width laporan" id="jenis"  name="jenis">
                        <option value="INVOICE">INVOICE</option>
                        <option value="ENTRY">ENTRY</option>
                      </select>
                    </div>

                    <div class="form-group col-md-4">
                      <select class="cari_semua chosen-select-width" id="cabang"  name="cabang">
                        <option></option>
                        @foreach ($cabang as $element)
                          <option value="{{ $element->kode }}">{{ $element->kode }} - {{ $element->nama }}</option>
                        @endforeach
                      </select>
                    </div>
                </div> 

              </div> 
              <h3 id="replace" align="center"></h3> 
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                    <div class="box-body">
                      <br>
                      <div class="row" style="margin-top: 20px;margin-left: 30px;"> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>
                      <div class="row" style="margin-top: -59px;margin-left: 112px;"> &nbsp; &nbsp; <a class="btn btn-warning cetak" onclick="excel()"> <i class="fa fa-print" aria-hidden="true"></i> Excel </a> </div>
                    </div>
                </form>
                <div class="box-body">
                <div id="drop_here"></div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
                    </div>
                  </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

  $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        /*minViewMode:1,*/
    });
    var d = new Date();
    var a = d.getDate();
    var b = d.getSeconds();
    var c = d.getMilliseconds();
    var table;
      


    


    function cari(){
      var awal =  $('#date_awal').val();
      var akir =  $('#date_akir').val();
      var customer =  $('.select-picker5').val();
      var cabang =  $('#cabang').val();
      var laporan = $('.laporan').val();

      if (laporan == 'INVOICE') {
        $.ajax({
          data: {awal:awal,akir:akir,customer:customer,cabang:cabang},
          url: baseUrl + '/carireport_invoice/carireport_invoice',
          type: "get",
           success : function(data){
            $('#drop_here').html(data);
          }
       });
      }else if (laporan == 'ENTRY') {
        $.ajax({
          data: {awal:awal,akir:akir,customer:customer,cabang:cabang},
          url: baseUrl + '/carientry_invoice/carientry_invoice',
          type: "get",
           success : function(data){
            $('#drop_here').html(data);
          }
       });
      }
      
    }



    function cetak(){
      var awal =  $('#date_awal').val();
      var akir =  $('#date_akir').val();
      var customer =  $('.select-picker5').val();
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      
      $.ajax({
        data: {awal:awal,akir:akir,customer:customer},
        url: baseUrl + '/reportinvoice/reportinvoice',
        type: "post",
       success : function(data){
        var win = window.open();
            win.document.write(data);
        }
      });
    }

    function excel(){
      var awal =  $('#date_awal').val();
      var akir =  $('#date_akir').val();
      var customer =  $('.select-picker5').val();
      
      $.ajax({
        data: {awal:awal,akir:akir,customer:customer},
        url: baseUrl + '/excelinvoice/excelinvoice',
        type: "get",
         complete:function(data){
        window.open(this.url,'_blank');
        },
       success : function(data){
       
        }
      });
    }

</script>
@endsection
