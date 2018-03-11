@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Form Daftar Gaji
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
                      <label class="control-label col-sm-2" for="nik">NIK</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="nik" placeholder="nik tenaga kerja">
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="nama">Nama Lengkap</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="nama" placeholder="nama tenaga kerja">
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="jabatan">Jabatan</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="jabatan" placeholder="jabatan tenaga kerja">
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="gapok">Gaji Pokok</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="gapok" placeholder="gapok tenaga kerja">
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="masaker">T. MASA KERJA</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="masaker" placeholder="masaker tenaga kerja">
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="masajab">T. JABATAN</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="masajab" placeholder="masajab tenaga kerja">
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="funsi">T. FUNGSIONAL</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="funsi" placeholder="funsi tenaga kerja">
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="bpjs">BPJS TK</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="bpjs" placeholder="bpjs tenaga kerja">
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="potongan">POTONGAN</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="potongan" placeholder="potongan tenaga kerja">
                        </div>
                    </div> 
                    <div class="form-group"> 
                      <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                        <a href="{{ url('bpjs/daftargaji ') }}"<button type="button" class="btn btn-md btn-danger" title="kembali">Kembali</button></a>
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
