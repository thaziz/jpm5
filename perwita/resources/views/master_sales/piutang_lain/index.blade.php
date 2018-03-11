@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> SALDO AWAL PIUTANG LAIN </h2>
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
                            <strong> SALDO AWAL PIUTANG LAIN </strong>
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
                    <h5> SALDO AWAL PIUTANG LAIN
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
                            <th> Kode Relasi</th>
                            <th> Nama </th>
                            <th> Periode </th>
                            <th> Saldo Awal </th>
                            <th> Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>0000001</td>
                            <td>Saldo Awal Piutang Lain 1</td>
                            <td>21/07/2017</td>
                            <td>1000000</td>
                            <td>
                                <div class="btn-group">
                                    <a href="" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit"><i class="fa fa-pencil"></i></a>
                                    <a href="" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>0000002</td>
                            <td>Saldo Awal Piutang Lain 2</td>
                            <td>22/07/2017</td>
                            <td>1300000.00</td>
                            <td>
                                <div class="btn-group">
                                    <a href="" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit"><i class="fa fa-pencil"></i></a>
                                    <a href="" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>0000003</td>
                            <td>Saldo Awal Piutang Lain 3</td>
                            <td>23/07/2017</td>
                            <td>1500000.00</td>
                            <td>
                                <div class="btn-group">
                                    <a href="" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit"><i class="fa fa-pencil"></i></a>
                                    <a href="" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>0000004</td>
                            <td>Saldo Awal Piutang Lain 4</td>
                            <td>24/07/2017</td>
                            <td>1700000.00</td>
                            <td>
                                <div class="btn-group">
                                    <a href="" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit"><i class="fa fa-pencil"></i></a>
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
    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    $(document).on("click","#btn_add",function(){
        window.location.href = baseUrl + '/mastersales/saldoawalpiutanglainform'
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
