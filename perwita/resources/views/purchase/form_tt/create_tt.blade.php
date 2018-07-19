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
    text-align: center ;
  }
  .right:{
    text-align: right ;
  }
/*  .table_tt td{
    text-align: center !important;
  }*/
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
                <div class="ibox-title" style="background: hotpink">
                    <div  style="background: hotpink" >
                      <h5 style="color: white">Form Tanda Terima Pembelian</h5>
                      <a href="{{ url('form_tanda_terima_pembelian') }}" class="pull-right" style="color: white"><i class="fa fa-arrow-left"> Kembali</i></a>
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
                        <td colspan="2">
                          <select  name="supplier" class="supplier form-control">
                            <option>asdsadsadsa</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="5">
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
                      <tr>
                        <td>Lain-lain</td>
                        <td colspan="2"><input type="text" class="lain form-control" name="lain"></td>
                        <td width="150">Tanggal</td>
                        <td width="300">
                          <input type="text" class="tanggal form-control" name="tanggal" value="{{ Carbon\carbon::now()->format('d/m/Y') }}">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-sm-12">
                    <table class="table table-bordered">
                      <tr>
                        <td>Nomor Invoice</td>
                        <td><input type="text" class="form-control"  id="invoice"></td>
                        <td>Nominal</td>
                        <td><input type="text" class="form-control"  id="nominal"></td>
                        <td align="center"><button type="button" class="btn btn-success append"><i class="fa fa-plus"> Append</i></button></td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-sm-12">
                    <table class="table table-bordered table-striped table_tt " >
                      <thead style="color: white">
                        <tr align="center">
                          <td width="60">No</td>
                          <td>Nomor</td>
                          <td>Nominal</td>
                          <td>Aksi</td>
                        </tr>
                      </thead>
                      <tbody>
                        
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
  var index = 1 ;
  var table = $('.table_tt').DataTable({
    searching:true,
    sorting:false,
    columnDefs: [
      {
         targets: 0,
         className:'center'
      },
      {
         targets: 2,
         className:'right'
      },
      {
         targets: 3,
         className:'center'
      },
      
    ]
  });
  $('.tanggal').datepicker();

  $("#nominal").maskMoney({
      precision:0,
      thousands:'.',
      allowZero:true,
  });

  $('.append').click(function(){
    var invoice = $('#invoice').val();
    var invoice = $('#invoice').val();
    var nominal = $('#nominal').val();
    if (invoice == '') {
      return toastr.warning('Invoice Harus Diisi');
    }
    if (nominal == '') {
      return toastr.warning('Nominal Harus Diisi');
    }
    table.row.add([
      '<p class="index center">'+index+'</p>'+
      '<input type="hidden" class="index index_'+index+'" value="'+index+'">',

      '<p class="invoice_text">'+invoice+'</p>'+
      '<input type="hidden" class="invoice" name="invoice[]">',

      '<p class="nominal_text">'+nominal+'</p>'+
      '<input type="hidden" class="nominal" name="nominal[]">',

      '<div class="btn btn-sm btn-group">'+
      '<button class="btn btn-warning"><i class="fa fa-edit"></i></button>'+
      '<button class="btn btn-danger"><i class="fa fa-trash"></i></button>'+
      '</div>',
    ]).draw();
    index++;
  });
</script>
@endsection
