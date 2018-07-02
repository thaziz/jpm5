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
                <form id="save_data">
                <div class="col-sm-8">
                  <table class="table" width="80%">
                    <tr>
                      <td>Awal</td>
                      <td><input type="text" name="min" id="min" class="form-control datepicker_date input-sm"></td>
                    </tr>
                    <tr>
                      <td>Akir</td>
                      <td><input type="text" name="max" id="max" class="form-control datepicker_date input-sm"></td>
                    </tr>
                    <tr>
                      <td>Laporan</td>
                      <td>
                          <select class="chosen-select-width input-sm" name="laporan" id="laporan">
                            <option selected value="">- Pilih -</option>
                            <option value="Rekap per Customer">Rekap per Customer</option>
                            <option value="Rekap per Customer Detail">Rekap per Customer Detail</option>
                            <option value="Rekap per akun">Rekap per akun</option>
                            <option value="Rekap per akun Detail">Rekap per akun Detail</option>
                      </td>
                    </tr>
                    <tr>
                      <td>Supplier</td>
                      <td>
                          <select class="chosen-select-width" name="supplier" id="supplier">
                              <option value="">- Pilih -</option>
                              @foreach ($supplier as $element)
                                <option value="{{ $element->no_supplier }}">{{ $element->no_supplier }} - {{ $element->nama_supplier }}</option>
                              @endforeach
                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td>Cabang</td>
                      <td>
                          <select class="chosen-select-width input-sm" name="cabang" id="cabang">
                              <option value="">- Pilih -</option>
                              @foreach ($cabang as $cabang)
                                <option value="{{ $cabang->kode }}">{{ $cabang->kode }} - {{ $cabang->nama }}</option>
                              @endforeach
                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td>Akun</td>
                      <td>
                          <select class="chosen-select-width input-sm" name="akun" id="akun">
                              <option value="">- Pilih -</option>
                              @foreach ($akun as $akun)
                                <option value="{{ $akun->id_akun }}">{{ $akun->id_akun }} - {{ $akun->nama_akun }}</option>
                              @endforeach
                          </select>
                      </td>
                    </tr>
                  </table>
                </div>
                </form>
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
                        <th>debet</th>
                        <th>kredit</th>
                        <th>saldo</th>
                      </tr>
                    </thead>
                    <tbody id="drop">
                    {{--  @foreach ($data['data'] as $index => $element)
                       <tr>
                         <td>{{ $index+1 }}</td>
                         <td>{{ $element->tgl }}</td>
                         <td>{{ $element->nota }}</td>
                         @if ($element->keterangan == null)
                            <td>{{ $element->keterangan }}</td>
                         @else
                            <td>{{ $element->keterangan }}</td>
                         @endif
                         
                         @if ($element->flag == 'D')
                            <td>{{ $element->debet }}</td>
                            <td>0</td>
                         @else
                            <td>0</td>
                            <td>{{ $element->kredit }}</td>
                         @endif
                         
                         <td>{{ $element->flag }}</td>
                       </tr>
                     @endforeach --}}
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

/*  function cari() {
      $.ajax({
            type: "GET",
            data : $('#save_data').serialize(),
            url : ('{{ route('carikartuhutan_perakun') }}'),
            success: function(data)
            {   
              
            }
      })
  }
*/
 function cari(){

  var awal = $('#min').val();
  var akir = $('#max').val();
  var customer = $('#customer').val();
  var akun = $('#akun').val();
  var cabang = $('#akun').val();
  var laporan = $('#laporan').val();
  var supplier = $('#supplier').val();

   if (laporan == 'Rekap per Supplier') {
      alert('a');
   }else if (laporan == 'Rekap per Supplier Detail') {

    alert('b');
   }else if (laporan == 'Rekap per akun') {
      $.ajax({
            type: "GET",
            data : $('#save_data').serialize(),
            url : ('{{ route('carikartuhutan_perakun') }}'),
            success: function(data)
            {   
                $('#drop').html(data);
            }
      })
   }else if (laporan == 'Rekap per akun Detail') {

    alert('d');
   }
     
 }

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