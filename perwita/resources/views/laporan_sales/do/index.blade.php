@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Laporan Delivery Order
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
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                                            </div>
                                        </td>
                                        <td style="padding-top: 0.4cm">Sampai</td>
                                        <td>
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top: 0.4cm">Customer</td>
                                        <td colspan="4">
                                            <select class="select2_single form-control" id="cbcustomer" name="cbcustomer" >
                                                  <option>Semua Pelanggan</option>
                                                  <option>Pelanggan 1</option>
                                                  <option>Pelanggan 2</option>
                                                  <option>Pelanggan 3</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top: 0.4cm">Keterangan Faktur Penjualan</td>
                                        <td colspan="4">
                                            <select class="select2_single form-control" id="cbcustomer" name="cbcustomer" >
                                                  <option>Semua Data</option>
                                                  <option>Sudah di Pakai Faktur Penjualan</option>
                                                  <option>Belum di Pakai Faktur Penjualan</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan = "4" >
                                            <button style="width:100%;" type="button" class="btn btn-success " id="btn_add_order" name="btnok">Tampilkan Data</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                          <div class="col-xs-6">



                         </div>



                    </div>
                </form>
                <div class="box-body">
                  <table id="seragam_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th> No DO</th>
                            <th> Tanggal </th>
                            <th> Pengirim </th>
                            <th> Penerima </th>
                            <th> Kota Asal </th>
                            <th> Kota Tujuan </th>
                            <th> Status </th>
                            <th> Tarif </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>0000001</td>
                            <td>22/07/2017</td>
                            <td>PT. SUPER WAHANA TEHNO</td>
                            <td>PT. SINARMAS DISTRIBUSI NUSATARA</td>
                            <td>Kab. Gresik</td>
                            <td>KAB. JEMBER</td>
                            <td>MANIFESTED</td>
                            <td>1300000.00</td>

                        </tr>
                        <tr>
                            <td>0000002</td>
                            <td>22/07/2017</td>
                            <td>CV SINDUNATA</td>
                            <td>IBU SRI LESTARI</td>
                            <td>Kota Surakarta</td>
                            <td>KAB. REMBANG</td>
                            <td>MANIFESTED</td>
                            <td>148800.00</td>

                        </tr>
                        <tr>
                            <td>0000003</td>
                            <td>22/07/2017</td>
                            <td>BINA PUTRA MANDIRI</td>
                            <td>BP SAMSUDIN</td>
                            <td>Kota Surakarta</td>
                            <td>KAB. BLITAR</td>
                            <td>MANIFESTED</td>
                            <td>40000.00</td>

                        </tr>
                        <tr>
                            <td>0000004</td>
                            <td>22/07/2017</td>
                            <td>BINA PUTRA MANDIRI</td>
                            <td>IBU WATIK</td>
                            <td>Kota Surakarta</td>
                            <td>KAB. JEPARA</td>
                            <td>MANIFESTED</td>
                            <td>40000.00</td>

                        </tr>
                        <tr>
                            <td>0000005</td>
                            <td>22/07/2017</td>
                            <td>DIPO MULYO SOLO</td>
                            <td>SULARTO</td>
                            <td>Kota Surakarta</td>
                            <td>KAB. PATI</td>
                            <td>MANIFESTED</td>
                            <td>117000.00</td>

                        </tr>
                        <tr>
                            <td>0000006</td>
                            <td>22/07/2017</td>
                            <td>PT. SUPER WAHANA TEHNO</td>
                            <td>PT. SINARMAS DISTRIBUSI NUSATARA</td>
                            <td>Kab. Gresik</td>
                            <td>KAB. JEMBER</td>
                            <td>MANIFESTED</td>
                            <td>1300000.00</td>

                        </tr>

                        <tr>
                            <td>0000007</td>
                            <td>22/07/2017</td>
                            <td>BUNDA SUKESI</td>
                            <td>SUNARSIH</td>
                            <td>Kota Surakarta</td>
                            <td>KAB. MADIUN</td>
                            <td>MANIFESTED</td>
                            <td>25000.00</td>

                        </tr>
                        <tr>
                            <td>0000008</td>
                            <td>22/07/2017</td>
                            <td>PT. SUPER WAHANA TEHNO</td>
                            <td>PT. SINARMAS DISTRIBUSI NUSATARA</td>
                            <td>Kab. Gresik</td>
                            <td>KAB. JEMBER</td>
                            <td>MANIFESTED</td>
                            <td>1300000.00</td>
                        </tr>

                        <tr>
                            <td>0000009</td>
                            <td>22/07/2017</td>
                            <td>BUNDA SUKESI</td>
                            <td>SUNARSIH</td>
                            <td>Kota Surakarta</td>
                            <td>KAB. MADIUN</td>
                            <td>MANIFESTED</td>
                            <td>25000.00</td>

                        </tr>
                    </tbody>

                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">

                   <input type="submit" id="submit" name="submit" value="Print" class="btn btn-info" onclick="window.open('Seragam/cetak')">



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
    $(document).on("click","#btn_add_order",function(){
        //window.location.href = baseUrl + '/sales/deliveryorderform'
    });

    $('.date').datepicker({
        autoclose: true,
        //format: 'yyyy-mm-dd'
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
