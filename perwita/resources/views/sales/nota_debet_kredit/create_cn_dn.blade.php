@extends('main')

@section('title', 'dashboard')

@section('content')

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> CN / DN PENJUALAN </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Sales</a>
                        </li>
                        <li>
                          <a> Penerimaan Kwitansi</a>
                        </li>
                        <li class="active">
                            <strong> Create CN / DN Penjualan </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
<style type="text/css" media="screen">
  .disabled {
        pointer-events: none;
        opacity: 0.7;
        }
  .borderless td, .borderless th {
    border: none !important;
}

</style>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12" >
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5> Tambah Data
            {{Session::get('comp_year')}}
          </h5>
        </div>
        <div class="ibox-content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="col-sm-12">
                  <div class="col-sm-6">
                    <table class="table borderless tabel_header1">
                      <tr>
                        <td>
                          Jenis CN/DN
                        </td>
                        <td>
                          <select class="form-control jenis_cd" name="jenis_cd">
                          <option value=""> Credit Nota </option>
                          <option value=""> Debet Nota </option>
                        </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Tanggal</td>
                        <td>
                           <div class="input-group date">
                              <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </span>
                              <input type="text" class="form-control tgl" name="tgl" value="{{carbon\carbon::now()->format('Y-m-d')}}">
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Invoice</td> 
                        <td><input type="text" class="form-control nomor_invoice" name="nomor_invoice"></td>
                      </tr>
                      <tr>
                        <td>Tanggal Invoice</td>
                        <td>
                           <div class="input-group date">
                              <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </span>
                              <input type="text" class="form-control tgl disabled=""  readonly="" value="">
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Jumlah Invoice</td> 
                        <td><input type="text" readonly="" class="form-control jumlah_invoice" name="jumlah_invoice"></td>
                      </tr>
                      <tr>
                        <td>Customer</td> 
                        <td><input type="text" readonly=""  class="form-control customer" ></td>
                      </tr>
                      <tr>
                        <td>Keterangan</td> 
                        <td><input type="text" class="form-control keterangan" ></td>
                      </tr>
                    </table>
                    <table class="table borderless table_data">
                      <h4>Detail Pembiayaan</h4>
                      <tr>
                        <td>Akun</td>
                        <td>
                          <select class="form-control jenis_cd" name="jenis_cd">
                          <option value="K">Kredit</option>
                          <option value="D">Debet</option>
                        </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Jumlah</td> 
                        <td><input type="text" class="form-control jumlah_biaya" ></td>
                      </tr>
                      <tr>
                        <td>keterangan</td> 
                        <td><input type="text" class="form-control keterangan_biaya" ></td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-sm-6">
                    <table class="table borderless table-hover table_pajak">
                        <tbody>
                            <tr>
                                <td>Total</td>
                                <td colspan="4">
                                    <input type="text" name="ed_total" class="form-control ed_total" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right">
                                </td>
                            </tr>
                            <tr>
                                <td>Debet</td>
                                <td colspan="4">
                                    <input type="text" name="debet" class="form-control debet" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" value="0">
                                </td>
                            </tr>
                            <tr>
                                <td>Kredit</td>
                                <td colspan="4">
                                    <input type="text" name="kredit" class="form-control kredit" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" value="0">
                                </td>
                            </tr>
                            <tr>
                                <td>Netto DPP</td>
                                <td colspan="4">
                                    <input type="text" name="netto_total" id="netto_total" class="form-control netto_total" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" >
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis PPN</td>
                                <td>
                                    <select class="form-control" name="cb_jenis_ppn" onchange="hitung_pajak_ppn()" id="cb_jenis_ppn" >
                                        <option value="4" ppnrte="0" ppntpe="npkp" >NON PPN</option>
                                        <option value="1" ppnrte="10" ppntpe="pkp" >EXCLUDE 10 %</option>
                                        <option value="2" ppnrte="1" ppntpe="pkp" >EXCLUDE 1 %</option>
                                        <option value="3" ppnrte="1" ppntpe="npkp" >INCLUDE 1 %</option>
                                        <option value="5" ppnrte="10" ppntpe="npkp" >INCLUDE 10 %</option>
                                    </select>
                                </td>
                                <td>PPN</td>
                                <td>
                                    <input type="text" name="ppn" class="form-control ppn" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" >
                                </td>
                            </tr>
                            <tr>
                                <td>Pajak lain-lain</td>
                                <td>
                                    <select onchange="hitung_pajak_lain()" class="pajak_lain form-control" name="pajak_lain" id="pajak_lain" >
                                        <option value="0"  >Pilih Pajak Lain-lain</option>
                                        @foreach($pajak as $val)
                                            <option value="{{$val->kode}}" data-pph="{{$val->nilai}}">{{$val->nama}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>PPH</td>
                                <td>
                                    <input type="text" name="pph" class="pph form-control" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right" >
                                </td>
                            </tr>
                            <tr>
                                <td>Total Tagihan</td>
                                <td colspan="4">
                                    <input type="text" name="total_tagihan" class="form-control total_tagihan" readonly="readonly" tabindex="-1" style="text-transform: uppercase;text-align:right">
                                </td>
                            </tr>
                        </tbody>
                    </table> 
                  </div>
                </div>
                <div class="box-footer">
                  <div class="pull-right">
                    <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-success">
                  </div>
                  {{-- MODAL --}}
                  <div id="modal_cd" class="modal" >
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Edit Insert Biaya</h4>
                            </div>
                            <div class="modal-body">
                                <table id="table_data_do" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                           <th>Nomor Invoice</th>
                                           <th>Tanggal</th>
                                           <th>Customer</th>
                                           <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="update_biaya">Save changes</button>
                                </div>
                            </div>
                        </div>
                      </div>
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
    
    $('.nomor_invoice').focus(function(){
      $('#modal_cd').modal('show');
    })
   

</script>
@endsection
