@extends('main')

@section('title', 'dashboard')

@section('content')


<style type="text/css">
  .asw{
    color: grey;
  }
  .asw:hover{
    color: red;
  }
  .center:{
    text-align: center !important;
  }
  .right:{
    text-align: right !important;
  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
      <h2> Form Tanda Terima </h2>
      <ol class="breadcrumb">
          <li>
              <a>Home</a>
          </li>
          <li>
              <a>Purchase</a>
          </li>
          <li>
            <a>Transaksi Hutang</a>
          </li>
          <li class="active">
              <strong>Form Tanda Terima Pembelian</strong>
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
                    <div class="ibox-title">
                      <h5>Form Tanda Terima Pembelian</h5>
                      <a href="{{ url('form_tanda_terima_pembelian') }}" class="pull-right" style="color: grey"><i class="fa fa-arrow-left"> Kembali</i></a>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
                <div class="box-body">
                  <div class="col-sm-12">
                    <table class="table table-bordered">
                      <tr>
                        <td width="150">Nomor</td>
                        <td width="300"><input type="text" readonly="" name="nomor" class="nomor form-control"></td>
                        <td width="150">Pihak Ketiga</td>
                        <td>
                          <select  name="supplier" class="supplier form-control">
                            <option>asdsadsadsa</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="4">
                          <div class="row">
                            <div class="col-sm-3"> 
                              <div class="checkbox checkbox-info checkbox-circle">
                                  <input id="Kwitansi" type="checkbox" checked="" name="kwitansi">
                                    <label for="Kwitansi">
                                        Kwitansi / Invoice / No
                                    </label>
                              </div> 
                            </div>
                            <div class="col-sm-3"> 
                              <div class="checkbox checkbox-info checkbox-circle">
                                  <input id="FakturPajak" type="checkbox" checked="" name="faktur_pajak">
                                    <label for="FakturPajak">
                                        Faktur Pajak
                                    </label>
                              </div> 
                            </div>
                            <div class="col-sm-3"> 
                              <div class="checkbox checkbox-info checkbox-circle">
                                  <input id="SuratPerananAsli" type="checkbox" checked="" name="surat_peranan">
                                    <label for="SuratPerananAsli">
                                        Surat Peranan Asli
                                    </label>
                              </div> 
                            </div>
                             <div class="col-sm-3"> 
                              <div class="checkbox checkbox-info checkbox-circle">
                                  <input id="SuratJalanAsli" type="checkbox" checked="" name="surat_jalan">
                                    <label for="SuratJalanAsli">
                                       Surat Jalan Asli
                                    </label>
                              </div> 
                            </div>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-sm-12">
                    <table class="table table-bordered table-striped table_tt " style="color: white">
                      <thead>
                        <tr>
                          <td>No</td>
                          <td>Nomor</td>
                          <td>Tanggal</td>
                          <td>Nama Pihak Ketiga</td>
                          <td>Print</td>
                          <td>Aksi</td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                  <div class="pull-right">
            
                     
                    </div>
                  </div><!-- /.box-footer --> 
              </div><!-- /.box -->
            </div><!-- /.col -->
            </div>
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
  $('.table_tt').DataTable({
    searching:true,
    sorting:false,
  });

</script>
@endsection
