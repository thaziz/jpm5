@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Faktur Pajak
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
                                          <td style="width:110px;"> Nomor Faktur Pajak</td>
                                          <td colspan="7">
                                              <input type="text" class="form-control" id="ednomor" name="ednomor" value="">
                                              <input type="hidden" id="txtid_h" name="txtid_h" value="" >
                                              <input type="hidden" id="crudmethod_h" name="crudmethod_h" value="" >
                                          </td>
                                      </tr>
                                      <tr>
                                          <td style="width:120px; padding-top: 0.4cm">Pilih Invoice</td>
                                          <td colspan="7">
                                               <div class="input-group" style="width: 100% !important;" >
                                                   <input type="text" class="form-control"> <span class="input-group-btn"> <button type="button" id="btn_pilih_invoice" class="btn btn-primary">Go!
                                                </div>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td style="padding-top: 0.4cm">Tanggal</td>
                                          <td colspan="7">
                                                <div class="input-group date" style="width: 100% !important;" >
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="<?php echo date('Y-m-d',time())?>">
                                                </div>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td style="padding-top: 0.4cm">Customer</td>
                                          <td colspan="7">
                                              <select class="select2_single form-control" id="cbcustomer" name="cbcustomer" >
                                                    <option></option>
                                                    <option>Pelanggan 1</option>
                                                    <option>Pelanggan 2</option>
                                                    <option>Pelanggan 3</option>
                                              </select>
                                          </td>
                                      </tr>

                                      <tr>
                                          <td style="padding-top: 0.4cm">NPWP</td>
                                          <td colspan="7"><input type="text" class="form-control" id="edtotaljualh" name="edtotaljualh" value="" style="text-align:right"></td>
                                      </tr>
                                      <tr>
                                          <td style="">Type Faktur Pajak</td>
                                          <td colspan="7">
                                              <select class="select2_single form-control" id="cbcustomer" name="cbcustomer" >
                                                    <option></option>
                                                    <option>Type 1</option>
                                                    <option>Type 2</option>
                                                    <option>Type 3</option>
                                              </select>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td style="">Kode Transaksi Pajak</td>
                                          <td><input type="text" class="form-control" id="edtotaljualh" name="edtotaljualh" value=""></td>
                                          <td><input type="text" class="form-control" id="edtotaljualh" name="edtotaljualh" value=""></td>
                                          <td><input type="text" class="form-control" id="edtotaljualh" name="edtotaljualh" value=""></td>
                                          <td><input type="text" class="form-control" id="edtotaljualh" name="edtotaljualh" value=""></td>
                                          <td><input type="text" class="form-control" id="edtotaljualh" name="edtotaljualh" value=""></td>
                                          <td><input type="text" class="form-control" id="edtotaljualh" name="edtotaljualh" value=""></td>
                                      </tr>
                                      <tr>
                                          <td style="padding-top: 0.4cm">DPP Cetak</td>
                                          <td colspan="7"><input type="text" class="form-control" id="edtotaljualh" name="edtotaljualh" value="" style="text-align:right"></td>
                                      </tr>
                                      <tr>
                                          <td style="padding-top: 0.4cm">DPP</td>
                                          <td colspan="7"><input type="text" class="form-control" id="edtotaljualh" name="edtotaljualh" value="" style="text-align:right"></td>
                                      </tr>
                                      <tr>
                                          <td style="padding-top: 0.4cm">PPN</td>
                                          <td colspan="7"><input type="text" class="form-control" id="edtotaljualh" name="edtotaljualh" value="" style="text-align:right"></td>
                                      </tr>
                                      <tr>
                                          <td style="padding-top: 0.4cm">PPn BM</td>
                                          <td colspan="7"><input type="text" class="form-control" id="edtotaljualh" name="edtotaljualh" value="" style="text-align:right"></td>
                                      </tr>
                                  </tbody>
                              </table>
                              <div class="row">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary " id="btnadd" name="btnadd"><i class=""></i> Simpan</button>
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
                              <h4 class="modal-title">Pilih Nomor Faktur Penjualan</h4>
                            </div>
                            <div class="modal-body">
                              <form class="form-horizontal">
                                  <table id="table_data" class="table table-striped table-bordered dt-responsive nowrap table-hover" cellspacing="0" width="100%">
                                      <thead>
                                          <tr>
                                              <th style="display:none;">Id</th>
                                              <th>Nomor Faktur Pajak</th>
                                              <th>Nomor Invoice</th>
                                              <th>Tanggal</th>
                                              <th>Customer</th>
                                              <th>Total</th>
                                              <th>Keterangan</th>
                                              <th>Pilih</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td>899909988123</td>
                                              <td>00001</td>
                                              <td>20/07/2016</td>
                                              <td>Pelanggan 1</td>
                                              <td>2000000</td>
                                              <td>Keterangan 1</td>
                                              <td>
                                                  <div class="btn-group">
                                                      <button type="button" id="" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-ok"></i></button>
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td>899909988124</td>
                                              <td>00002</td>
                                              <td>25/07/2016</td>
                                              <td>Pelanggan 2</td>
                                              <td>4000000</td>
                                              <td>Keterangan 2</td>
                                              <td>
                                                  <div class="btn-group">
                                                      <button type="button" id="" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-ok"></i></button>
                                                  </div>
                                              </td>
                                          </tr>
                                      </tbody>
                                  </table>

                              </form>
                            </div>
                            <div class="modal-footer">

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
                                <th>Nama Item Kena Pajak</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nama Item 1</td>
                                <td>10000000</td>
                            </tr>
                            <tr>
                                <td>Nama Item 2</td>
                                <td>20000000</td>
                            </tr>
                            <tr>
                                <td>Nama Item 3</td>
                                <td>30000000</td>
                            </tr>
                            <tr>
                                <td>Nama Item 4</td>
                                <td>40000000</td>
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

    $(document).on("click","#btn_pilih_invoice",function(){
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
