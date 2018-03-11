@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Daftar Order Seragam
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
                  <div class="form-group">
                      
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
                    </div>
                    </div>
                    </form>
                <div class="row">
                    <div class="col-sm-10">
                    </div>
                    <div class="col-sm-2">Bulan Februari 2017</div>
                </div>
                <div class="box-body">
                  <table id="seragam_table" class="table table-bordered table-striped">
                    <thead>
                     <tr>
                        <th rowspan="2">NO</th>
                        <th rowspan="2">AREA</th>
                        <th rowspan="2">JENIS SERAGAM</th>
                        <th rowspan="2">WARNA SERAGAM</th>
                        <th rowspan="2">STOK (SAAT INI)</th>
                        <th colspan="3">ORDER</th>
                        <th rowspan="2">TOTAL ORDER</th>
                        <th rowspan="2" width="10%">TOTAL ORDER & TOTAL STOK</th>
                    </tr>
                    <tr>
                        <th >L</th>
                        <th >XL</th>
                        <th >XXL</th>
                    </tr>
                    </thead>
                    <tbody>
                      
                      <tr>
                      <td>1</td>
                      <td>KAS MANYAR</td>
                      <td>PERWITA</td>
                      <td>MERAH</td>
                      <td></td>
                      <td>80</td>
                      <td>20</td>
                      <td></td>
                      <td>100</td>
                      <td>100</td>
                    
                      </tr>
                      
                      <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>BIRU</td>
                      <td></td>
                      <td>80</td>
                      <td>20</td>
                      <td></td>
                      <td>100</td>
                      <td>100</td>
                    
                      </tr>
                      
                      <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>BIRU</td>
                      <td></td>
                      <td>80</td>
                      <td>20</td>
                      <td></td>
                      <td>100</td>
                      <td>100</td>
                    
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
