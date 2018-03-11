@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>RBH 
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
                    <!-- <div class="col-sm-9"><a type="button" class="btn btn-box-tool" style="color: #888; font-size:12pt;" title="tambahkan data item" href="{{url('bpjs/input_datapeserta')}}"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp;Tambah Data</a></div>
                    <div class="col-md-3"> 
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Pencarian" name="Pencarian">
                    <div class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                    </div>
                    </div> -->
                    <!-- <div class="col-sm-2">Bulan Februari 2017</div> -->
                </div>
                <div class="box-body table-responsive">
                  <table id="#" class="table table-bordered table-striped">
                    <thead>
                     <tr>
                        <th rowspan="2">NO</th>
                        <th rowspan="2">Divisi Cuti</th>
                        <th colspan="2">JUMLAH TK CUTI</th>
                        <th colspan="2">PEMBAYARAN (Rp.)</th>
                        <th rowspan="2">JUMLAH (Rp.)</th>
                    </tr>
                    <tr>
                        <th>PERIODE I</th>
                        <th>PERIODE II</th>
                        <th>PERIODE I</th>
                        <th>PERIODE II</th>
                    </tr>
                    </thead>
                    <tbody>
                      
                      <tr>
                        <td>1.</td>
                        <td>ALUMINDO SHEET</td>
                        <td>0</td>
                        <td>0</td>
                        <td>-</td>
                        <td>-</td>  
                        <td>-</td>  
                      </tr>
                      <tr>
                        <td>2.</td>
                        <td>ELEKTRO</td>
                         <td>3</td>
                        <td>3</td>
                        <td>28,500</td>
                        <td>28,500</td>  
                        <td>57,000</td>  
                      </tr>
                      <tr>
                        <td>3.</td>
                        <td>LOGAM</td>
                        <td>7</td>
                        <td>7</td>
                        <td> 66,500 </td>
                        <td>66,500</td>  
                        <td> 133,000 </td>  
                      </tr>
                      <tr>
                        <td>4.</td>
                        <td>CUTI M-3</td>
                        <td>0</td>
                        <td>0</td>
                        <td>-</td>
                        <td>-</td>  
                        <td>-</td> 
                      </tr>
                      <tr>
                        <td>5.</td>
                        <td>CUTI M-4</td>
                        <td>0</td>
                        <td>0</td>
                        <td>-</td>
                        <td>-</td>  
                        <td>-</td> 
                      </tr>
                      <tr>
                        <td colspan="2" align="center">Total</td>
                        <td>10</td>
                        <td>10</td>
                        <td> 95,000 </td>
                        <td>95,000</td>
                        <td> 190,000 </td>
                      </tr>
                    </tbody>
                   
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
                      <input type="submit" id="submit" name="submit" value="Print" class="btn btn-info" onclick="window.open('cetak_rbh')">
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
