@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> BIAYA </h2>
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
                            <strong> BIAYA </strong>
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
                    <h5> BIAYA
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
                                    <tbody>

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
                            <th> Kode</th>
                            <th> Nama </th>
                            <th> D/K </th>
                            <th> Account </th>
                            <th> Cash FLow </th>
                            <th> Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>0000001</td>
                            <td>Biaya 1</td>
                            <td>D</td>
                            <td>10001</td>
                            <td>10002</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" name="button" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit"><i class="fa fa-pencil"></i></button>
                                    <button type="button" name="button" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger btndelete"><i class="fa fa-times"></i></a></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>0000002</td>
                            <td>Biaya 2</td>
                            <td>D</td>
                            <td>11001</td>
                            <td>10202</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" name="button" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit"><i class="fa fa-pencil"></i></button>
                                    <button type="button" name="button" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger btndelete"><i class="fa fa-times"></i></a></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>0000003</td>
                            <td>Biaya 3</td>
                            <td>D</td>
                            <td>10301</td>
                            <td>12002</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" name="button" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit"><i class="fa fa-pencil"></i></button>
                                    <button type="button" name="button" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger btndelete"><i class="fa fa-times"></i></a></button>
                                </div>
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
                                    <td style="width:120px; padding-top: 0.4cm">Kode</td>
                                    <td>
                                        <input type="text" class="form-control" id="edkode" >
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Nama</td>
                                    <td><input type="text" class="form-control" id="edsatuan"></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Debet/Kredit</td>
                                    <td>
                                        <select class="select2_single form-control"  id="cbitem"  style="width: 100% !important;">
                                            <option>D</option>
                                            <option>K</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Kode Accounting</td>
                                    <td><input type="text" class="form-control" id="edsatuan"></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Kode Cash Flow</td>
                                    <td><input type="text" class="form-control" id="edjumlah" ></td>
                                </tr>
                                <tr>
                                    <td style="width:120px; padding-top: 0.4cm">Default</td>
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
