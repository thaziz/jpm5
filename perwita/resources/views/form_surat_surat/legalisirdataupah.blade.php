@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Form Data Pegawai Surat Permohonan Legalisir Data Upah
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="#">
                <div class="row">
                    <div class="col-sm-9"></div>
                    <!-- <div class="col-sm-2">Bulan Februari 2017</div> -->
                </div>
                <div class="box-body">
                  <form class="form-horizontal">
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="nik">Nama </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="nik" placeholder="Nama Pegawai">
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="no peserta">Alamat</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="no peserta" placeholder="Alamat Pegawai">
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="nama">Perusahaan Outsourcing</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="nama" placeholder="Perusahaan Outsourcing">
                        </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-2" for="nama">Perusahaan Bekerja</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="nama" placeholder="Perusahaan Bekerja">
                        </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-2" for="nama">Alasan Berhenti</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="nama" placeholder="Alasan Berhenti">
                        </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-2" for="tgl lahir">Mulai Bekerja</label>
                        <div class="col-sm-8">
                          <input type="date" class="form-control" id="tg; lahit" placeholder="tempat lahir">
                        </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="tgl lahir">Selesai Bekerja</label>
                        <div class="col-sm-8">
                          <input type="date" class="form-control" id="tg; lahit" placeholder="Selesai Bekerja">
                        </div>
                    </div>


                    <div class="form-group"> 
                      <div class="col-sm-offset-2 col-sm-10">
                          <a href="{{url('LegalisirDataUpah')}}" class="btn btn-danger" role="button">Cetak Laporan</a>

                      </div>
                    </div>
                  </form>
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
