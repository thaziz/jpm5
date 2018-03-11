@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Delivery Order Cabang
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
                                            <td>
                                                <input type="text" class="form-control" id="ednomor" name="ednomor" value="">
                                            </td>

                                        </tr>
                                        <!--
                                        <tr>
                                            <td style="width:110px; padding-top: 0.4cm">Kota Asal</td>
                                            <td>
                                                <input type="text" class="form-control" id="ednomor" name="ednomor" value="">
                                            </td>
                                            <td style="width:110px; padding-top: 0.4cm">Kota Tujuan</td>
                                            <td>
                                                <input type="text" class="form-control" id="ednomor" name="ednomor" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:110px;">Nama Pengirim</td>
                                            <td>
                                                <input type="text" class="form-control" id="ednomor" name="ednomor" value="">
                                            </td>
                                            <td style="width:110px;">Nama Penerima</td>
                                            <td>
                                                <input type="text" class="form-control" id="ednomor" name="ednomor" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:110px;">Alamat Pengirim</td>
                                            <td>
                                                <input type="text" class="form-control" id="ednomor" name="ednomor" value="">
                                            </td>
                                            <td style="width:110px;">Alamat Penerima</td>
                                            <td>
                                                <input type="text" class="form-control" id="ednomor" name="ednomor" value="">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="width:110px; padding-top: 0.4cm">Pendapatan</td>
                                            <td>
                                                <select class="select2_single form-control" id="cbcustomer" name="cbcustomer" >
                                                    <option>--Pilih Pendapatan--</option>
                                                    <option>Paket</option>
                                                    <option>Kertas</option>
                                                </select>
                                            </td>
                                            <td style="width:110px; padding-top: 0.4cm">Type Kiriman</td>
                                            <td>
                                                <select class="select2_single form-control" id="cbcustomer" name="cbcustomer" >
                                                    <option>--Pilih Type Pengiriman--</option>
                                                    <option>Kargo Kertas</option>
                                                    <option>Kertas</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="width:110px; padding-top: 0.4cm">Jenis Kiriman</td>
                                            <td colspan="3">
                                                <select class="select2_single form-control" id="cbcustomer" name="cbcustomer" >
                                                    <option>--Pilih Jenis Kiriman--</option>
                                                    <option>Paket</option>
                                                    <option>Kertas</option>
                                                </select>
                                            </td>
                                        </tr>
                                    -->
                                        <tr>
                                            <td style="padding-top: 0.4cm">Tanggal</td>
                                            <td>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="<?php echo date('Y-m-d',time())?>">
                                                </div>
                                            </td>
                                        </tr>
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
                                            <td style="padding-top: 0.4cm">Dengan SO</td>
                                            <td>
                                                <select class="select2_single form-control" id="cbcustomer" name="cbcustomer" >
                                                    <option></option>
                                                    <option>Ya</option>
                                                    <option>Tidak</option>
                                                </select>
                                          </td>
                                        </tr>

                                        <tr>
                                            <td style="padding-top: 0.4cm">Total</td>
                                            <td><input type="text" class="form-control" id="edtotaljualh" name="edtotaljualh" value="" style="text-align:right" disabled="disabled"></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Diskon</td>
                                            <td><input type="text" class="form-control" id="edtotaljualh" name="edtotaljualh" value="" style="text-align:right" disabled="disabled"></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Total Net</td>
                                            <td><input type="text" class="form-control" id="edtotaljualh" name="edtotaljualh" value="" style="text-align:right" disabled="disabled"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                <div class="col-md-4">
                                  <button type="button" class="btn btn-primary " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Add Item</button>
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
                                  <h4 class="modal-title">Insert Edit Delivery Order</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal">
                                        <table id="table_data" class="table table-striped table-bordered table-hover">
                                            <tbody>
                                              <tr>
                                                  <tr>
                                                      <td style="width:120px; padding-top: 0.4cm">No Sales Order</td>
                                                      <td>
                                                           <div class="input-group"><input type="text" class="form-control"> <span class="input-group-btn"> <button type="button" id="btn_pilih_so" class="btn btn-primary">Go!
                                                      </td>
                                                  </tr>
                                                  <td style="width:120px; padding-top: 0.4cm">item</td>
                                                  <td>
                                                      <select class="select2_single form-control"  id="cbitem"  style="width: 100% !important;">
                                                          <option></option>
                                                          <option>Item 1</option>
                                                          <option>Item 2</option>
                                                          <option>Item 3</option>
                                                      </select>
                                                      <input type="hidden" class="form-control" id="edkode" >
                                                      <input type="hidden" id="txtid">
                                                      <input type="hidden" id="crudmethod" value="N">
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td style="padding-top: 0.4cm">Satuan Satu</td>
                                                  <td><input type="text" class="form-control" id="edsatuan"></td>
                                                  <td><input type="text" class="form-control" id="edsatuan"></td>
                                              </tr>
                                              <tr>
                                                  <td style="padding-top: 0.4cm">Satuan Dua</td>
                                                  <td><input type="text" class="form-control" id="edsatuan"></td>
                                                  <td><input type="text" class="form-control" id="edsatuan"></td>
                                              </tr>
                                              <tr>
                                                  <td style="padding-top: 0.4cm">Jumlah</td>
                                                  <td><input type="text" class="form-control" id="edjumlah" style="text-align:right"></td>
                                                   <input type="hidden" id="edoldjumlah">
                                              </tr>
                                              <tr>
                                                  <td style="padding-top: 0.4cm">Harga/Jml Harga</td>
                                                  <td><input type="text" class="form-control" id="edharga" style="text-align:right"></td>
                                                  <td><input type="text" class="form-control" id="edtotal" style="text-align:right" disabled="disabled" ></td>
                                              </tr>
                                              <tr>
                                                  <td style="padding-top: 0.4cm">Discount/Total</td>
                                                  <td><input type="text" class="form-control" id="edharga" style="text-align:right"></td>
                                                  <td><input type="text" class="form-control" id="edtotal" style="text-align:right" disabled="disabled" ></td>
                                              </tr>
                                              <tr>
                                                  <td style="padding-top: 0.4cm">Keterangan</td>
                                                  <td><textarea class="form-control" rows="3" id="edketerangan" name="edketerangan" ></textarea></td>
                                              </tr>
                                              <td style="width:120px; padding-top: 0.4cm">Tujuan</td>
                                              <td>
                                                  <select class="select2_single form-control"  id="cbitem"  style="width: 100% !important;">
                                                      <option></option>
                                                      <option>Tujuan 1</option>
                                                      <option>Tujuan 2</option>
                                                      <option>Tujuan 3</option>
                                                  </select>
                                              </td>
                                              <tr>
                                                  <td style="padding-top: 0.4cm">Nopol</td>
                                                  <td><input type="text" class="form-control" id="edharga" ></td>
                                                  <td><input type="text" class="form-control" id="edtotal" ></td>
                                              </tr>
                                              <tr>
                                                  <td style="padding-top: 0.4cm">Kode Sopir</td>
                                                  <td><input type="text" class="form-control" id="edharga" ></td>
                                                  <td><input type="text" class="form-control" id="edtotal" ></td>
                                              </tr>
                                              <tr>
                                                  <td style="padding-top: 0.4cm">Kode Markerting</td>
                                                  <td><input type="text" class="form-control" id="edharga" ></td>
                                                  <td><input type="text" class="form-control" id="edtotal" ></td>
                                              </tr>
                                              <tr>
                                                  <td style="padding-top: 0.4cm">Cabang</td>
                                                  <td><input type="text" class="form-control" id="edharga" ></td>
                                                  <td><input type="text" class="form-control" id="edtotal" ></td>
                                              </tr>
                                              <tr>
                                                  <td style="padding-top: 0.4cm">Tipe Angkutan</td>
                                                  <td><input type="text" class="form-control" id="edharga" ></td>
                                                  <td><input type="text" class="form-control" id="edtotal" ></td>
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

                        <!----modal pilih nomor sales order--->

                        <div id="modal_pilih_nomor_so" class="modal" >
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h2>Pilih Nomor SO dari Pelanggan 1</h2>
                              </div>
                              <div class="modal-body">
                                <form class="form-horizontal">
                                    <table id="table_data" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nomor SO</th>
                                                <th>Tanggal</th>
                                                <th>Item</th>
                                                <th>Qty</th>
                                                <th>Jml Harga</th>
                                                <th>Pilih</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>000001</td>
                                                <td>28/05/2017</td>
                                                <td>Item 1</td>
                                                <td>2</td>
                                                <td>1000000</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" id="" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-ok"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>000002</td>
                                                <td>28/05/2017</td>
                                                <td>Item 1</td>
                                                <td>1</td>
                                                <td>6000000</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" id="" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-ok"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>000002</td>
                                                <td>28/05/2017</td>
                                                <td>Item 3</td>
                                                <td>2</td>
                                                <td>1500000</td>
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
                                <th>Kode Item</th>
                                <th>Nama Item</th>
                                <th>Keterangan</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Jml Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>00001</td>
                                <td>Item 1</td>
                                <td>Hati hati</td>
                                <td>2</td>
                                <td>20000</td>
                                <td>40000</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="submit" id="" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="submit" id="" name="" class="btn btn-danger btn-xs btnhapus" ><i class="glyphicon glyphicon-remove"></i></button>
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td>00002</td>
                                <td>Item 2</td>
                                <td>Hati hati Lagi</td>
                                <td>3</td>
                                <td>10000</td>
                                <td>30000</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="submit" id="" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="submit" id="" name="" class="btn btn-danger btn-xs btnhapus" ><i class="glyphicon glyphicon-remove"></i></button>
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
    $(document).on("click","#btn_pilih_so",function(){
        $("#modal_pilih_nomor_so").modal("show");
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
