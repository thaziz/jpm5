@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> SALDO PIUTANG </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Master Penjualan</a>
                        </li>
                        <li>
                          <a> Master DO</a>
                        </li>
                        <li class="active">
                            <strong> SALDO PIUTANG </strong>
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
                    <h5> SALDO PIUTANG
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
                          <div class="x_content">
                          <form action="" class="form-horizontal" method="post" >
                              <table class="table table-striped table-bordered dt-responsive nowrap table-hover">
                                  <tbody>

                                      <tr>
                                          <td style="padding-top: 0.4cm">Customer</td>
                                          <td>
                                              <select class="select2_single form-control" id="cbcustomer" name="cbcustomer" >
                                                  <option></option>
                                                  <option>Pelanggan 1</option>
                                                  <option>Pelanggan 2</option>
                                                  <option>Pelanggan 3</option>
                                              </select>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td style="padding-top: 0.4cm">Periode</td>
                                          <td>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="<?php echo date('Y-m-d',time())?>">
                                                </div>
                                          </td>
                                      </tr>

                                      <tr>
                                          <td style="padding-top: 0.4cm">Saldo Awal</td>
                                          <td><input type="text" class="form-control" id="edtotaljualh" name="edtotaljualh" value="" style="text-align:right" disabled="disabled"></td>
                                      </tr>
                                      <tr>
                                          <td colspan = "4" ><button style="width:100%;" type="button" class="btn btn-primary " id="btnok" name="btnok">Tampilkan Data</button></td>
                                      </tr>
                                  </tbody>
                              </table>

                          </form>
                      </div>




                    </div>
                </form>
                <div class="box-body">
                    <table id="table_data" class="table table-striped table-bordered dt-responsive nowrap table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="display:none;">Id</th>
                                <th>Nomor Faktur</th>
                                <th>Tanggal</th>
                                <th>Jatuh Tempo</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>00001</td>
                                <td>Item 1</td>
                                <td>Hati hati</td>
                                <td>2</td>
                                <td>20000</td>

                            </tr>
                            <tr>
                                <td>00002</td>
                                <td>Item 2</td>
                                <td>Hati hati Lagi</td>
                                <td>3</td>
                                <td>10000</td>

                            </tr>
                        </tbody>
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

    $(document).on("click","#btnadd",function(){
        $("#modal").modal("show");
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    function tambahdata() {
        window.location.href = baseUrl + '/data-master/master-akun/create'
    }
    function hapusData(id) {

        $.ajax({
            url: baseUrl + '/data-master/master-akun/delete/' + id,
            type: 'get',
            dataType: 'text',
            //headers: {'X-XSRF-TOKEN': $_token},
            success: function (response) {
                if (response == 'sukses') {
                    $('.alertBody').html('<div class="alert alert-success">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                            'Data Berhasil Di Hapus' +
                            '</div>');
                    $('.alertBody').show();
                    $('.alertBody').delay(4000).slideUp(300);
                    $("#hapus" + id).remove();
                } else if (response == 'gagal') {
                    $('.alertBody').html('<div class="alert alert-danger">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                            'Data Akun Sudah Digunakan' +
                            '</div>');
                    $('.alertBody').show();
                    $('.alertBody').delay(4000).slideUp(300);
                }

            }
        });
    }

</script>
@endsection
