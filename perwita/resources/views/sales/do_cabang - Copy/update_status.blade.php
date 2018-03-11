@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Update Delivery Order
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
                                            <td style="padding-top: 0.4cm; width:180px">Status Pengiriman</td>
                                            <td colspan = "5">
                                                <select class="select2_single form-control" id="cbcustomer" name="cbcustomer" >
                                                    <option>MANISFITED</option>
                                                    <option>TRANSIT</option>
                                                    <option>RECEIVED</option>
                                                    <option>DELIVERED</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Catatan Admin</td>
                                            <td ><textarea class="form-control" rows="3" id="edketerangan" name="edketerangan" ></textarea></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Nama Penerima</td>
                                            <td><input type="text" class="form-control" id="edharga" style="text-align:right"></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Id Penerima (KTP/SIM)</td>
                                            <td><input type="text" class="form-control" id="edharga" style="text-align:right"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-primary " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Update</button>
                                    </div>

                                    <div class="pull-right">

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
        window.location.href = baseUrl + '/sales/deliveryorder'
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
