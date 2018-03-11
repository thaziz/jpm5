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
                            <form action="{{ url('sales/deliveryorderform/save_update_status') }}" class="form-horizontal" method="post" >
                                <table class="table table-striped table-bordered dt-responsive nowrap table-hover">
                                    <tbody>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Nomor</td>
                                            <td>
                                                <input type="text" class="form-control" id="ed_nomor" name="ed_nomor" style="text-transform: uppercase" value="{{ $do->nomor or null }}" readonly="readonly" >
                                                <input type="hidden" class="form-control" id="ed_nomor_old" name="ed_nomor_old" value="{{ $do->nomor or null }}">
                                                <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly >
                                                <input type="hidden" class="form-control" name="crud_h" value="E">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm; width:180px">Status Pengiriman</td>
                                            <td>
                                                <select class="select2_single form-control" id="cb_customer" name="cb_status" >
                                                    <option>MANISFITED</option>
                                                    <option>TRANSIT</option>
                                                    <option>RECEIVED</option>
                                                    <option>DELIVERED</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Catatan Admin</td>
                                            <td >
                                                <textarea class="form-control" rows="3" id="ed_catatan_admin" name="ed_catatan_admin" ></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Nama Penerima</td>
                                            <td>
                                                <input type="text" class="form-control" name="ed_nama_penerima">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Id Penerima (KTP/SIM)</td>
                                            <td>
                                                <input type="text" class="form-control" name="ed_id_penerima" >
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
