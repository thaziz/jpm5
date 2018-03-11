@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
  <div><h2>Laporan Arus Kas</h2></div>
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h2>Daftar Operating Cash Flow</h2>
                    <div class="ibox-tools">
                      <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                

                </div>
                <div class="box-body">
                  <div class="box-body table-responsive">
                  <table id="exa" class="table table-bordered table-striped">
                    <thead>
                     <tr>
                        <th>Kode Transaksi</th>
                        <th>Nama Transaksi</th>
                        <th>Jumlah</th>
                    </tr>
                    </thead>
                    <tbody>
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

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                     <h2>Daftar Investing Cash Flow</h2>
                    <div class="ibox-tools">
                      <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
               
                </div>
                <div class="box-body">
                  <div class="box-body table-responsive">
                  <table id="exam" class="table table-bordered table-striped">
                    <thead>
                     <tr>
                        <th>Kode Transaksi</th>
                        <th>Nama Transaksi</th>
                        <th>Jumlah</th>
                    </tr>
                    </thead>
                    <tbody>
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

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
               <div class="ibox-title">
                    <h2>Daftar Financial Cash Flow</h2>
                    <div class="ibox-tools">
                      <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                
                </div>
                <div class="box-body">
                  <div class="box-body table-responsive">
                  <table id="examp" class="table table-bordered table-striped">
                    <thead>
                     <tr>
                      <th>Kode Transaksi</th>
                        <th>Nama Transaksi</th>
                        <th>Jumlah</th>
                    </tr>
                    </thead>
                    <tbody>
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




<!-- <div class="row" style="padding-bottom: 50px;"></div> -->


@endsection

@section('extra_scripts')
<script type="text/javascript">
 var table = $("#exa").DataTable({

                "paging": true,
                        "language": {
                        "lengthMenu": "Menampilkan _MENU_ hasil ",
                                "zeroRecords": "Maaf - Tidak ada yang di temukan",
                                "info": "Manampilkan Halaman _PAGE_ Dari _PAGES_",
                                "infoEmpty": "Tidak Ada Hasil Yang Sesuai",
                                "infoFiltered": "(Mencari Dari _MAX_ total Hasil)",
                                "search": "Pencarian",
                                "paginate": {
                                "next": "selanjutnya",
                                "previous": "sebelumnya"

                         }

                        }
                });
 var table = $("#exam").DataTable({

                "paging": true,
                        "language": {
                        "lengthMenu": "Menampilkan _MENU_ hasil ",
                                "zeroRecords": "Maaf - Tidak ada yang di temukan",
                                "info": "Manampilkan Halaman _PAGE_ Dari _PAGES_",
                                "infoEmpty": "Tidak Ada Hasil Yang Sesuai",
                                "infoFiltered": "(Mencari Dari _MAX_ total Hasil)",
                                "search": "Pencarian",
                                "paginate": {
                                "next": "selanjutnya",
                                "previous": "sebelumnya"

                         }

                        }
                });
 var table = $("#examp").DataTable({

                "paging": true,
                        "language": {
                        "lengthMenu": "Menampilkan _MENU_ hasil ",
                                "zeroRecords": "Maaf - Tidak ada yang di temukan",
                                "info": "Manampilkan Halaman _PAGE_ Dari _PAGES_",
                                "infoEmpty": "Tidak Ada Hasil Yang Sesuai",
                                "infoFiltered": "(Mencari Dari _MAX_ total Hasil)",
                                "search": "Pencarian",
                                "paginate": {
                                "next": "selanjutnya",
                                "previous": "sebelumnya"

                         }

                        }
                });
</script>
@endsection