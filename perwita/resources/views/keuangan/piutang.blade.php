@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Piutang
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
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
                            <th>Kode</th>                                    
                            <th>Nama Transaksi</th>
                            <th>Detail</th>                                    
                            <th>Keterangan</th>
                            <th>Hasil</th>
                    </tr>
                    </thead>
                    <tbody>
                      
                      <tr>
                        <td align="center">1125</td>
                        <td>Pembayaran Piutang Non Usaha : Owner</td>
                        <td>TAM</td>
                        <td>COBA</td>
                        <td>5000.0000</td>
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
</script>
@endsection
