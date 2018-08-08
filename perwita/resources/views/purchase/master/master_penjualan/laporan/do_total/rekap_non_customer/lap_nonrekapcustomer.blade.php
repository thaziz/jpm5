@extends('main')

@section('tittle','dashboard')

@section('content')

<style type="text/css">
    .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
  .btn-special{
    background-color: #6d2db3;
    border-color: #6d2db3;
    color: #FFFFFF;
  }
  .dataTables_filter, .dataTables_info { display: none; }

</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Laporan DO Koran
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <h5 class="pull-right"><a href="{{ url('sales/laporandeliveryorder_total') }}"><i class="fa fa-arrow-left"></i></a></h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <form class="form-horizontal" id="form_ajax" action="post" method="POST">
                  <div class="box-body">
                    <table class="table table-bordered datatable table-striped">
                          <tr>
                          <td> Dimulai : </td>
                          <td> 
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="min" id="min" type="text" class=" date form-control date_to date_range_filter
                                    date">
                            </div> 
                          </td>  
                          <td> Diakhiri : </td> 
                          <td> 
                          <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="date form-control date_to date_range_filter
                                    date" name="max" id="max" >
                          </div> 
                          </td>
                          </tr>
                          <tr>
                            <td>Cabang :</td>
                            <td>
                              <select class="chosen-select-width" name="cabang" id="cabang">
                                  <option selected="" readonly value="">- Cabang -</option>
                                @foreach ($cabang as $r)
                                  <option value="{{ $r->kode }}">{{ $r->kode }} - {{ $r->nama }}</option>
                                @endforeach
                              </select>
                            </td>
                          
                          
                            <td>View :</td>
                            <td>
                              <select class="chosen-select-width" name="view" id="view">
                                  <option selected="" readonly value="">- View -</option>
                                  <option value="rekap"> Rekap</option>
                                  <option value="rekap_detail"> Rekap Detail</option>
                              </select>
                            </td>
                          </tr>
                      <br>
                      </table>
                      <div class="row" style="margin-top: 20px;"> &nbsp; &nbsp; <a class="btn btn-special cetak" onclick="cari()"> <i class="fa fa-search" aria-hidden="true"></i> Cari </a> </div>
                      <div class="row" style="margin-top: -39px;margin-left: 55px;"> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="pdf()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>
                      <div class="row" style="margin-top: -39px;margin-left: 136px;"> &nbsp; &nbsp; <a class="btn btn-warning cetak" onclick="excel()"> <i class="fa fa-print" aria-hidden="true"></i> Excel </a> </div>
                    </div>
                
                <div class="box-body">
                <div id="disini" style="margin-top: 20px"></div>
                </form>
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
</div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

    $( ".date" ).datepicker();

      function cari(){
        var view = $('#view').val();
        var awal = $('#min').val();
        var akir = $('#max').val();

        if (view == null || view == '') {
          Command: toastr["warning"]("View Harus Dipilih", "Peringatan!")

          toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }
          return false;
        }
        if (awal == null || awal ==  '') {
          Command: toastr["warning"]("Tanggal Harus Dipilih", "Peringatan!")

          toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }
          return false;
        }
        if (akir == null || akir == '') {
          Command: toastr["warning"]("Tanggal Harus Dipilih", "Peringatan!")

          toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }
          return false;
        }

        $.ajax({
          data: $('#form_ajax').serialize(),
          url: baseUrl + '/cari_rekapcustomer/cari_rekapcustomer',
          type: "get",
          success : function(data){
            if (data.data == '0') {
               Command: toastr["warning"]("Data Terkait Tidak Ditemukan", "Peringatan!")

                toastr.options = {
                  "closeButton": false,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": true,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
              $('#disini').html('');

            }else{
              $('#disini').html(data);
            }
          }
        });
      }

    function excel(){
     
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        data: $('#form_ajax').serialize(),
        url: baseUrl + '/report_rekapcustomer/report_rekapcustomer',
        type: "get",
        complete:function(data){
        window.open(this.url,'_blank');
        },
       success : function(data){
           
        }
      });
    }


    function pdf(){
     
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        data: $('#form_ajax').serialize(),
        url: baseUrl + '/reportpdf_rekapcustomer/reportpdf_rekapcustomer',
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
