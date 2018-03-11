@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> LAPORAN MUTASI PIUTANG
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                       <!--  <div class="form-group">

                            <div class="form-group">
                            <label for="bulan_id" class="col-sm-1 control-label">Bulan</label>
                            <div class="col-sm-2">
                             <select id="bulan_id" name="bulan_id" class="form-control">
                                                      <option value="">Pilih Bulan</option>

                              </select>
                            </div>
                          </div>
                          </div>
                           <div class="form-group">

                            <div class="form-group">
                            <label for="tahun" class="col-sm-1 control-label">Tahun</label>
                            <div class="col-sm-2">
                             <select id="tahun" name="tahun" class="form-control">
                                                      <option value="">Pilih Tahun</option>

                              </select>
                            </div>
                          </div>
                          </div> -->
                          <div class="row">
                              <table class="table table-striped table-bordered dt-responsive nowrap table-hover">
                                <tbody>
                                    <tr>
                                        <td style="padding-top: 0.4cm">Mulai</td>
                                        <td>
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="ed_mulai" class="form-control" value="<?php $mulai=date('Y-m-d',time());  echo date('d/m/Y', strtotime('-7 days', strtotime($mulai)));?>">
                                            </div>
                                        </td>
                                        <td style="padding-top: 0.4cm">Sampai</td>
                                        <td>
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="ed_sampai" class="form-control" value="<?php echo date('d/m/Y',time())?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top: 0.4cm">Customer</td>
                                        <td colspan="4">
                                            <select class="chosen-select-width"  name="cb_customer" id="cb_customer" style="width:100%" >
                                                <option> </option>
                                            @foreach ($customer as $row)
                                                <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                            @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan = "4" >
                                            <button style="width:100%;" type="button" class="btn btn-success " id="btn_ok" name="btnok">Tampilkan Data</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                          <div class="col-xs-6">



                         </div>



                    </div>
                </form>
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>Customer</td>
                            <td style="width:7%">Saldo Awal</td>
                            <td style="width:7%">Tambah</td>
                            <td style="width:7%">Kurang</td>
                            <td style="width:7%">Saldo Akhir</td>
                        </tr>
                    </thead>

                  </table>
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
    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    $(document).ready( function () {
        $('#tabel_data').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
        });
        var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"100%"}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
    });

    $(document).on("click","#btn_ok",function(){
        var mulai = $("input[name='ed_mulai']").val();
        var sampai = $("input[name='ed_sampai']").val();
        var customer = $("select[name='cb_customer']").val();
        var value = {
              mulai: mulai,
              sampai: sampai,
              customer: customer
            };
        $.ajax(
        {
            url : baseUrl + "/laporan_sales/mutasi_piutang/tampil_data",
            type: "GET",
            dataType:"JSON",
            data : value,
            success: function(data, textStatus, jqXHR)
            {
                $("#table_data").html(data.html);

            }      
        });
        
    });

</script>

@endsection
