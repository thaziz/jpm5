@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 style="margin-left : 5px"> DELIVERY ORDER
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
                                        <tr style="max-height: 15px !important; height: 15px !important; overflow:hidden;">
                                            <td style="width:110px; padding-top: 0.4cm">Nomor</td>
                                            <td>
                                                <input type="text" class="form-control input-sm" id="ednomor" name="ednomor" value="">
                                            </td>
                                            <td style="padding-top: 0.4cm">Tanggal</td>
                                            <td>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control input-sm" value="<?php echo date('Y-m-d',time())?>">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:110px; padding-top: 0.4cm">Kota Asal</td>
                                            <td>
                                                <input type="text" class="form-control input-sm" name="kota_asal" id="kota_asal" value="">
                                            </td>
                                            <td style="width:110px; padding-top: 0.4cm">Kota Tujuan</td>
                                            <td>
                                                <input type="text" class="form-control input-sm" id="ednomor" name="ednomor" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:110px; padding-top: 0.4cm">Pendapatan</td>
                                            <td>
                                                <select class="select2_single form-control input-sm" name="pendapatan" id="pendapatan" class="form-control input-sm" onChange="tkir();" >
                                                    <option value="">-- Pilih Pendapatan --</option>
                                                    <option value="paket" />PAKET</option>
                                                    <option value="kertas" />KERTAS</option>
                                                </select>
                                            </td>
                                            <td style="width:110px; padding-top: 0.4cm">Type Kiriman</td>
                                            <td>
                                                <select class="select2_single form-control"  name="type_kiriman" id="type_kiriman" >
                                                    <option>--Pilih Type Pengiriman--</option>
                                                    <option>Kargo Kertas</option>
                                                    <option>Kertas</option>
                                                </select>
                                            </td>
                                            <td style="width:110px; padding-top: 0.4cm">Jenis Kiriman</td>
                                            <td colspan="3">
                                                <select class="select2_single form-control input-sm" name="jenis_kiriman" id="jenis_kiriman" >
                                                    <option>--Pilih Jenis Kiriman--</option>
                                                    <option>Express</option>
                                                    <option>Regular</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>

                                        </tr>
                                        <tr id="kendaraan" style="display:none">
                                            <td>Jenis Kendaraan</td>
                                            <td colspan="3">
                                                <select class="select2_single form-control input-sm" name="jenis_kendaraan" id="jenis_kendaraan" >
                                                    <option value="">-- Pilih Jenis Kendaraan --</option>
                                                    <option value="pickup" />Pick Up</option>
                                                    <option value="cde" />Colt Diesel Engkel</option>
                                                    <option value="cdd" />Colt Diesel Double</option>
                                                    <option value="truck" />Truck Gandeng</option>
                                                    <option value="tronton" />Tronton</option>
                                                    <option value="spd" />Sepeda Motor</option>
                                                    <option value="fuso" />Fuso Engkel</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr id="sj" style="display:none">

                                            <td style="padding-top: 0.4cm">No.Surat Jalan</td>
                                            <td colspan="3">
                                                <input type="text" name="no_sj" id="no_sj" class="form-control input-sm"  placeholder=""/>
                                            </td>
                                        </tr>
                                        <tr id="np" style="display:none">
                                            <td style="padding-top: 0.4cm">No Pol</td>
                                            <td colspan="3">
                                                <input type="text" name="vhccde" id="vhccde" class="form-control input-sm"  placeholder=""/>
                                                <input type="hidden" name="id_vhc" id="id_vhc" class="form-control input-sm"  />
                                            </td>
                                        </tr>
                                        <tr id="div_berat" style="display:none;">
                                            <td style="padding-top: 0.4cm">Berat</td>
                                            <td colspan="3">
                                                <input type="text" name="berat" id="berat" class="form-control input-sm" placeholder="" style="text-align:right"/>
                                            </td>
                                        </tr>
                                        <tr id="dimensi" style="display:none;">
                                            <td style="padding-top: 0.4cm">Panjang</td>
                                            <td>
                                                <input type="text" name="panjang" id="panjang" class="form-control input-sm" placeholder="" style="text-align:right"/>
                                            </td>
                                            <td style="padding-top: 0.4cm">Lebar</td>
                                            <td>
                                                <input type="text" name="lebar" id="lebar" class="form-control input-sm" placeholder="" style="text-align:right"/>
                                            </td>
                                        </tr>
                                        <tr id="dimensi2" style="display:none;">
                                            <td style="padding-top: 0.4cm">Tinggi</td>
                                            <td colspan="3">
                                                <input type="text" name="tinggi" id="tinggi" class="form-control input-sm"  placeholder="" style="text-align:right"/>
                                            </td>
                                        </tr>
                                        <tr id="div_koli" style="display:none;">
                                            <td style="padding-top: 0.4cm">Koli</td>
                                            <td colspan="3">
                                                <input type="text" name="koli" id="koli" class="form-control input-sm" style="text-align:right"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:110px; padding-top: 0.4cm">DO Outlet</td>
                                            <td colspan="3">
                                                <select class="select2_single form-control input-sm"  name="do_agen" id="do_agen" >
                                                    <option value="">-- Non Outlet --</option>
                                                    <option>Outlet 1</option>
                                                    <option>Outlet 2</option>
                                                    <option>Outlet 3</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="">Biaya Tambahan</td>
                                            <td colspan="3"><input type="text" class="form-control input-sm" id="edtotaljualh" name="edtotaljualh" value="" style="text-align:right"></td>
                                        </tr>
                                        <tr id="div_kom" style="display:none;">
                                            <td style="padding-top: 0.4cm">Biaya Komisi</td>
                                            <td colspan="3"><input type="text" class="form-control input-sm" name="biaya_komisi" id="biaya_komisi" value="" style="text-align:right"></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.7cm">Total Biaya</td>
                                            <td colspan="3">
                                                <input type="checkbox" id="checkbox1">
                                                <label for="checkbox1"> PPN </label>
                                                <input type="text" class="form-control input-sm" id="edtotaljualh" name="edtotaljualh" value="" style="text-align:right" disabled="disabled">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Customer</td>
                                            <td colspan="4">
                                                <select class="select2_single form-control input-sm" id="cbcustomer" name="cbcustomer" >
                                                    <option></option>
                                                    <option>Pelanggan 1</option>
                                                    <option>Pelanggan 2</option>
                                                    <option>Pelanggan 3</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style=" background-color: #00bfff;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:110px;">Nama Pengirim</td>
                                            <td>
                                                <input type="text" class="form-control input-sm" id="ednomor" name="ednomor" value="">
                                            </td>
                                            <td style="width:110px;">Nama Penerima</td>
                                            <td>
                                                <input type="text" class="form-control input-sm" id="ednomor" name="ednomor" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:110px;">Alamat Pengirim</td>
                                            <td>
                                                <input type="text" class="form-control input-sm" id="ednomor" name="ednomor" value="">
                                            </td>
                                            <td style="width:110px;">Alamat Penerima</td>
                                            <td>
                                                <input type="text" class="form-control input-sm" id="ednomor" name="ednomor" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:110px;">Telpon Pengirim</td>
                                            <td>
                                                <input type="text" class="form-control input-sm" id="ednomor" name="ednomor" value="">
                                            </td>
                                            <td style="width:110px;">Telpon Penerima</td>
                                            <td>
                                                <input type="text" class="form-control input-sm" id="ednomor" name="ednomor" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style=" background-color: #00bfff;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:110px; padding-top: 0.4cm">Marketing</td>
                                            <td colspan="3">
                                                <select class="select2_single form-control"  name="do_agen" id="do_agen" >
                                                    <option value="">-- Pilih Marketing --</option>
                                                    <option>Marketing 1</option>
                                                    <option>Marketing 2</option>
                                                    <option>Marketing 3</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 0.4cm">Total</td>
                                            <td colspan="3"><input type="text" class="form-control input-sm" id="edtotaljualh" name="edtotaljualh" value="" style="text-align:right" disabled="disabled"></td>
                                            <td style="padding-top: 0.4cm">Diskon</td>
                                            <td colspan="3"><input type="text" class="form-control input-sm" id="edtotaljualh" name="edtotaljualh" value="" style="text-align:right" disabled="disabled"></td>
                                            <td style="padding-top: 0.4cm">Total Net</td>
                                            <td colspan="3"><input type="text" class="form-control input-sm" id="edtotaljualh" name="edtotaljualh" value="" style="text-align:right" disabled="disabled"></td>
                                        </tr>
                                        <tr>
                                            
                                        </tr>
                                        <tr>
                                            
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
                                  <h4 class="modal-title">Insert Edit Delivery Order Cabang</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal">
                                        <table id="table_data" class="table table-striped table-bordered table-hover">
                                            <tbody>
                                                <tr>
                                                    <td style="width:120px; padding-top: 0.4cm">No Sales Order</td>
                                                    <td colspan="3">
                                                        <div class="input-group" style="width : 100%"><input  type="text" class="form-control"> <span class="input-group-btn"> <button type="button" id="btn_pilih_so" class="btn btn-primary">Go!
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td style="width:120px; padding-top: 0.4cm">item</td>
                                                    <td colspan="3">
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
                                                    <td style="padding-top: 0.4cm">Satuan</td>
                                                    <td colspan="3"><input type="text" class="form-control" id="edsatuan"></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 0.4cm">Jumlah</td>
                                                    <td><input type="text" class="form-control" id="edjumlah" style="text-align:right"></td>
                                                    <input type="hidden" id="edoldjumlah">
                                                    <td><input type="text" class="form-control" id="edtotal" style="text-align:right" disabled="disabled" ></td>
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
                                                    <td colspan="3"><textarea class="form-control" rows="3" id="edketerangan" name="edketerangan" ></textarea></td>
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
    function tkir(){
    if (document.getElementById('pendapatan').value != ''){if (document.getElementById('pendapatan').value == "kertas"){document.getElementById('type_kiriman').innerHTML = "<option value='kargo'>Kargo Kertas</option><option value='kertas'>Kertas</option>"}
    } else {document.getElementById('type_kiriman').innerHTML = "<option value=''>-- Pilih Type Kiriman --</option>"}
    if (document.getElementById('pendapatan').value != ''){if (document.getElementById('pendapatan').value == "koran"){document.getElementById('type_kiriman').innerHTML = ""}
    } else {document.getElementById('type_kiriman').innerHTML = "<option value=''>-- Pilih Type Kiriman --</option>"}
    if (document.getElementById('pendapatan').value != ''){if (document.getElementById('pendapatan').value == "paket"){document.getElementById('type_kiriman').innerHTML = "<option value='doc'>Dokumen</option><option value='kargo'>Kargo Paket</option><option value='kilo'>Kilogram</option><option value='koli'>Koli</option>"}
    } else {document.getElementById('type_kiriman').innerHTML = "<option value=''>-- Pilih Type Kiriman --</option>"}

    }
    $('#type_kiriman').change(function(){
        x=$(this).val();
            if(x=='doc'){
                $('#kendaraan').hide();
                $('#sj').hide();
                $('#np').hide();
                $('#div_berat').hide();
                $('#dimensi').hide();
                $('#dimensi2').hide();
                $('#div_koli').hide();
            } else if(x=='kilo'){
                $('#kendaraan').hide();
                $('#sj').hide();
                $('#np').hide();
                $('#div_berat').show();
                $('#dimensi').show();
                $('#dimensi2').show();
                $('#div_koli').show();
            } else if(x=='kertas'){
                $('#kendaraan').hide();
                $('#sj').show();
                $('#np').show();
                $('#div_berat').show();
                $('#dimensi').hide();
                $('#dimensi2').hide();
                $('#div_koli').hide();
            } else if(x=='koli'){
                $('#kendaraan').hide();
                $('#sj').hide();
                $('#np').hide();
                $('#div_berat').show();
                $('#dimensi').hide();
                $('#dimensi2').hide();
                $('#div_koli').show();
            } else if(x=='kargo'){
                $('#kendaraan').show();
                $('#sj').show();
                $('#np').show();
                $('#div_berat').hide();
                $('#dimensi').hide();
                $('#dimensi2').hide();
                $('#div_koli').hide();
            } else {
          $('#kendaraan').hide();
          $('#sj').hide();
          $('#np').hide();
                $('#div_berat').hide();
                $('#dimensi').hide();
                $('#dimensi2').hide();
                $('#div_koli').hide();
        }
    });
    $('#do_agen').change(function(){
        x=$(this).val();
            if(x!=''){
                $('#div_kom').show();
            } else {
                $('#div_kom').hide();
        }
    });

    $('#pendapatan').change(function(){
        x=$(this).val();
            if(x=='kertas'){
                $('#sj').show();
                $('#np').show();
            } else {
                $('#sj').hide();
                $('#np').hide();
        }
    });


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
