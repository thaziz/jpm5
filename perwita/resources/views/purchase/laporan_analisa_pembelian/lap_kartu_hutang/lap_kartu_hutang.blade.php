@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
  .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Kartu Hutang </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Laporan Purchase </a>
                        </li>
                        <li class="active">
                            <strong> Kartu Hutang </strong>
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
                    <h5> Laporan Kartu Hutang
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    
                <div class="box-body">
                 
                {{-- <h3 style="text-align: center"> PT JAWA PRATAMA MANDIRI  <br> JL. KARAH AGUNG NO 45 SURABAYA
                </h3> --}}
                <div class="col-sm-8">
                  <table class="table" width="80%">
                    <tr>
                      <td>Awal</td>
                      <td><input type="text" name="" class="form-control datepicker_date"></td>
                    </tr>
                    <tr>
                      <td>Akir</td>
                      <td><input type="text" name="" class="form-control datepicker_date"></td>
                    </tr>
                    <tr>
                      <td>Customer</td>
                      <td>
                          <select class="chosen-select-width">
                              <option>- Pilih -</option>
                              @foreach ($customer as $element)
                                <option value="{{ $element->kode }}">{{ $element->kode }} - {{ $element->nama }}</option>
                              @endforeach
                          </select>
                      </td>
                    </tr>
                  </table>
                </div>
                  <div class="row"> &nbsp; &nbsp; 
                    <a class="btn btn-info" onclick="cari()">
                      <i class="fa fa-search" aria-hidden="true"></i> Cari </a> 
                  </div>
                  
                  <div class="row"> &nbsp; &nbsp; 
                    <a class="btn btn-info" onclick="cetak()">
                      <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> 
                  </div>
                  <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>No bukti</th>
                        <th>Keterangan</th>
                        <th>debbet</th>
                        <th>kredit</th>
                        <th>saldo</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                        <td>6</td>
                        <td>7</td>
                      </tr>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  
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
     
$('#datatable').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

</script>
@endsection




{{-- 
ANALISA
<table id="addColumn" class="table table-bordered table-striped tbl-item">
<thead>
 <tr >
    <th align="center" rowspan="2">No.</th>
    <th align="center" colspan="2">Supplier</th>
    <th align="center" rowspan="2">Saldo Awal</th>
    <th align="center" colspan="3">MUTASI KREDIT</th>
    <th align="center" colspan="3">MUTASI DEBET</th>
    <th align="center" rowspan="2">Saldo Akir.</th>
    <th align="center" rowspan="2">Sisa Uang Muka.</th> 
</tr>
<tr>
  <th>Kode</th>
  <th>Nama</th>
  <th>Hutang Baru</th>
  <th>Hutang Voucher</th>
  <th>Nota Kredit</th>
  <th>Bayar Cash</th>
  <th>Byr Uang Muka</th>
  <th>Cek/Bg/Trans</th>
</tr>

</thead>

<tbody>
 
</tbody>

</table> --}}