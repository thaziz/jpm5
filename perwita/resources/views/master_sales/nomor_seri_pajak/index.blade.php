@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> NOMOR SERI PAJAK </h2>
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
                            <strong> NOMOR SERI PAJAK </strong>
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
                    <h5> NOMOR SERI PAJAK
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <div class="text-right">
                       <button  type="button" class="btn btn-success " id="btn_add" name="btnok"><i class="glyphicon glyphicon-plus"></i>Tambah Data</button>
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
                                  
                                </table>
                      <div class="col-xs-6">



                      </div>



                  </div>
                </form>
                <div class="box-body">
                  <table id="seragam_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th> Tanggal</th>
                            <th> Nomor Depan</th>
                            <th> Dari Nomor</th>
                            <th> Sampai Nomor</th>
                            <th> Aktif </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>20/12/2016</td>
                            <td>082132137</td>
                            <td>08213213713415432413</td>
                            <td>08213213713415499999</td>
                            <td>
                                <input type="checkbox" id="checkbox1">
                            </td>
                        </tr>
                        <tr>
                            <td>20/01/2017</td>
                            <td>082442138</td>
                            <td>08244213813415777565</td>
                            <td>08213213713415499999</td>
                            <td>
                                <input type="checkbox" id="checkbox1">
                            </td>
                        </tr>
                        <tr>
                            <td>20/02/2017</td>
                            <td>082135555</td>
                            <td>08213555551341543241</td>
                            <td>08213555571341549999</td>
                            <td>
                                <input type="checkbox" id="checkbox1">
                            </td>
                        </tr>
                        <tr>
                            <td>12/03/2016</td>
                            <td>082199999</td>
                            <td>08219999913415411111</td>
                            <td>08219999913415455555</td>
                            <td>
                                <input type="checkbox" id="checkbox1">
                            </td>
                        </tr>
                        <tr>
                            <td>20/12/2016</td>
                            <td>082132137</td>
                            <td>08213213713415432413</td>
                            <td>08213213713415492789</td>
                            <td>
                                <input type="checkbox" id="checkbox1">
                            </td>
                        </tr>
                        <tr>
                            <td>20/12/2016</td>
                            <td>082132137</td>
                            <td>08213213713415432413</td>
                            <td>08213213713415489777</td>
                            <td>
                                <input type="checkbox" id="checkbox1">
                            </td>
                        </tr>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <!-- modal -->
                <div id="modal" class="modal" >
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insert Edit Biaya</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal">
                          <table id="table_data" class="table table-striped table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <td style="width:120px; padding-top: 0.4cm">Nomor Depan</td>
                                    <td>
                                        <input type="text" class="form-control" id="edkode" >
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Dari Nomor</td>
                                    <td><input type="text" class="form-control" id="edsatuan"></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Sampai Nomor</td>
                                    <td><input type="text" class="form-control" id="edsatuan"></td>
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
                <div class="box-footer">
                  <div class="pull-right">


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
    $(document).on("click","#btn_add",function(){
        $("#modal").modal("show");
    });
    $(document).on( "click",".btnedit", function() {
        $("#modal").modal("show");
    });
    $(document).on( "click",".btndelete", function() {
        if(!confirm("Hapus Data ?")) return false;
    });
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
