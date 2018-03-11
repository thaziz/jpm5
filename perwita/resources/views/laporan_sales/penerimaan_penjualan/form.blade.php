@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Penerimaan Penjualan
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
                                          <td style="width:110px; padding-top: 0.4cm">Nomor</td>
                                          <td colspan = "5">
                                              <input type="text" class="form-control" id="ednomor" name="ednomor" value="">
                                              <input type="hidden" id="txtid_h" name="txtid_h" value="" >
                                              <input type="hidden" id="crudmethod_h" name="crudmethod_h" value="" >
                                          </td>
                                      </tr>
                                      <tr>
                                          <td style="padding-top: 0.4cm">Tanggal</td>
                                          <td colspan = "5">
                                                <div class="input-group date" style="width : 100%">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="<?php echo date('Y-m-d',time())?>">
                                                </div>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td style="padding-top: 0.4cm">Customer</td>
                                          <td colspan = "5">
                                              <select class="select2_single form-control" id="cbcustomer" name="cbcustomer" >
                                                    <option></option>
                                                    <option>Pelanggan 1</option>
                                                    <option>Pelanggan 2</option>
                                                    <option>Pelanggan 3</option>

                                              </select>
                                          </td>
                                      </tr>

                                      <tr>
                                          <td style="padding-top: 0.4cm">Akun Debet</td>
                                          <td colspan = "5">
                                              <select class="select2_single form-control" id="cbakundebet" name="cbakundebet" >
                                                  <option></option>
                                                  <option>KAS KECIL</option>
                                                  <option>BANK BCA</option>
                                                  <option>BANK BN1</option>
                                              </select>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td style="padding-top: 0.4cm">Keterangan</td>
                                          <td colspan = "5" ><textarea class="form-control" rows="3" id="edketerangan" name="edketerangan" ></textarea></td>
                                      </tr>
                                      <tr>
                                          <td style="padding-top: 0.4cm">Jumlah</td>
                                          <td><input type="text" class="form-control" id="edjumlah" name="edjumlah" value="" style="text-align:right"></td>
                                          <td style="padding-top: 0.4cm">Terpakai</td>
                                          <td><input type="text" class="form-control" id="edterpakai" name="edterpakai" value="" style="text-align:right" disabled="disabled"></td>
                                          <td style="padding-top: 0.4cm">Sisa</td>
                                          <td><input type="text" class="form-control" id="edsisa" name="edsisa" value="" style="text-align:right" disabled="disabled"></td>
                                      </tr>
                                  </tbody>
                              </table>
                              <div class="row">
                                <div class="col-md-4">
                                  <button type="button" class="btn btn-primary " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Pilih Nota</button>
                                </div>

                                <div class="pull-right">
                                  <button type="submit" class="btn btn-success " id="btnsimpan" name="btnsimpan"  style="position: absolute; right: 14px;"><i class="glyphicon glyphicon-ok"></i>Simpan</button>
                                </div>
                              </div>
                          </form>
                      </div>
                      <!-- modal -->
                      <div id="modal" class="modal" >
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title">Pilih Nota dari Pelanggan 1</h4>
                            </div>
                            <div class="modal-body">
                              <form class="form-horizontal">
                                <table id="table_data" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>NomorNota</th>
                                            <th>Jumlah</th>
                                            <th>Pilih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>0000001</td>
                                            <td>2000000</td>
                                            <td>
                                                <input type="checkbox" id="checkbox1">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>0000002</td>
                                            <td>4000000</td>
                                            <td>
                                                <input type="checkbox" id="checkbox1">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>0000003</td>
                                            <td>5000000</td>
                                            <td>
                                                <input type="checkbox" id="checkbox1">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                              </form>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary" id="btnsave">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div>
                        <!-- modal -->



                    </div>
                </form>
                <div class="box-body">
                    <table id="table_data" class="table table-striped table-bordered dt-responsive nowrap table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="display:none;">Id</th>
                                <th>Nomor Nota</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>0000001</td>
                                <td>2000000</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>0000002</td>
                                <td>5000000</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                    </div>
                                </td>
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
